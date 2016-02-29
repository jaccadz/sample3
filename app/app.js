
var app = angular.module('sampleApp', ['ngRoute', 'ui-notification']);

app.factory("services", ['$http', function($http, $rootScope) {
  var serviceBase = 'services/'
    var obj = {};
    
	  // lol this
	  obj.insertMessage = function (message) {
		return $http.post(serviceBase + 'submitMessage', message).then(function (results) {
		  return results;
		  });
	  };
	  
	  obj.getConvo = function(){
			return $http.post(serviceBase + 'getConvo', { "convoFrom" : $rootScope.convoFrom, "convoTo" : $rootscope.convoTo}).
			then(function(data, status) {
				window.alert("OLA at sucess");
				return data.data;
			})
			
	  }

    return obj;   
}]);


app.controller('submitCtrl', function ($http, $scope, $rootScope, $location, $routeParams, services) {
    //window.alert("OLA at submitctrl");
    //lol this
    $scope.submitMessage = function(message) {
		$rootScope.convoFrom = message.o_fromName;
		$rootScope.convoTo = message.o_toName;
		services.insertMessage(message);	
		//$location.path('/');

		var serviceBase = 'services/'
		$scope.from = $rootScope.convoFrom;
		$scope.to = $rootScope.convoTo;
		
		$http.post(serviceBase + 'getConvo', { "convoFrom" : $scope.from, "convoTo" : $scope.to}).
			success(function(data, status) {
				//window.alert("OLA at sucess");
				$scope.status = status;
				$scope.data = data;
				$scope.convoResult = data; 
			})
			.
			error(function(data, status) {
				$scope.data = data || "Request failed";
				$scope.status = status;		
				$scope.convoResult = data; 			
			});  
    };

});

app.controller('convoCtrl', function ($http, $scope, $rootScope, $location, $routeParams, services) {
    window.alert("OLA at convoCtrl");
    //lol this
	
	//services.getConvo().then(function(data){
    //$scope.convoResult = data.data;
	//});

    var serviceBase = 'services/'
	$scope.from = $rootScope.convoFrom;
	$scope.to = $rootScope.convoTo;
	
	$http.post(serviceBase + 'getConvo', { "convoFrom" : $scope.from, "convoTo" : $scope.to}).
		success(function(data, status) {
			window.alert("OLA at sucesssssssssssss");
			$scope.status = status;
			$scope.data = data;
			$scope.convoResult = data; 
		})
		.
		error(function(data, status) {
			window.alert("OLA at error");
			$scope.data = data || "Request failed";
			$scope.status = status;		
			$scope.convoResult = data; 			
		});


});




app.config(['$routeProvider',
  function($routeProvider, $locationProvider) {
    $routeProvider.
      when('/', {
        title: 'Message',
        templateUrl: 'partials/body.html',
        controller: 'submitCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });

}]);


app.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
		$rootScope.convoFrom = "";
		$rootScope.convoTo = "";
		
    });
}]);




















