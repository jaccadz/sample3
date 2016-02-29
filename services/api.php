<?php

require_once("Rest.inc.php");

class api extends REST {

	private $dbh = NULL;
	
	const DB_SERVER = "127.0.0.1";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB = "db_practical";

	public function __construct(){
			parent::__construct();			
			$this->dbConnect();			
	}
	
	function dbconnect() {
		$server="localhost";$user="root";$pass="";
		$this->dbh = new PDO("mysql:host=$server;dbname=db_practical", $user, $pass);
		$this->mysqli = new mysqli(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
	}

	public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);
	}
	
	private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
	}
	
	private function submitMessage() {
		if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$message1 = json_decode(file_get_contents("php://input"),true);
			$column_names = array('o_fromName', 'o_fromTelephone', 'o_toName', 'o_toTelephone', 'o_message',);
			$keys = array_keys($message1);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ 
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $message1[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO outgoing(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($message1)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Message Created Successfully.", "data" => $message1);
				//$this->response($this->json($success),200);
				echo json_encode($values);
			}else
				$this->response('',204);	
	}
	
	private function getConvo(){
		$data = file_get_contents("php://input");
		$objData = json_decode($data);
		
		$query = 'SELECT * FROM outgoing WHERE (o_fromName="'. $objData->convoFrom .'" OR o_toName="'. $objData->convoFrom .'") AND (o_fromName="'. $objData->convoTo .'" OR o_toName="'. $objData->convoTo .'")';
		//$query = 'SELECT * FROM outgoing WHERE o_fromName="'. $objData->convoFrom .'"';
		$stmt = $this->dbh->prepare( $query );
		$stmt->execute();
		$result = $stmt->fetchAll( PDO::FETCH_ASSOC );
		
		//$result = array();
		//$result['hello'] = "hello";
		
		$json = json_encode( $result );
		echo $json;
	}

	private function searchJO(){
		$data = file_get_contents("php://input");
		$objData = json_decode($data);

		$query = 'SELECT * FROM tbl_joborder WHERE jo_no="'. $objData->data .'" AND jo_lname="'. $objData->lname .'"';
		$stmt = $this->dbh->prepare( $query );
		$stmt->execute();
		$result = $stmt->fetch( PDO::FETCH_ASSOC );
		//$result = json_encode( $result1 );
		$response = array();

		if ($result != NULL) {
			$response['jo_no'] = $result['jo_no'];
			$response['jo_fullname'] = $result['jo_fname'] . " " . $result['jo_lname'];
			$response['jo_date'] = $result['jo_date'];
			if ($result['jo_status'] == 1 ) {
				$response['status'] = "Finished since " . $result['jo_finishedDate'];
			}
			else if ($result['jo_status'] == 2 ) {
				$response['status'] = "Pending";
			}
			else if ($result['jo_status'] == 3 ) {
				$response['status'] = "Picked-up on " . $result['jo_picked-upDate'];
			}
			//$response['status'] = $result['jo_no'];
			//$response['jo_no'] = $result['jo_no'];
		} else {
			$response['jo_no'] = "No record found.";
			$response['jo_fullname'] = "";
			$response['jo_date'] = "";
			$response['status'] = "";
		}

		$json = json_encode( $response );
		echo '[' . $json . ']';
	}
	
	private function joDetails(){
		$data = file_get_contents("php://input");
		$objData = json_decode($data);
		
		$query = 'SELECT * FROM tbl_jobdetails WHERE jo_no="'. $objData->data .'" AND jod_removed=0';
		$stmt = $this->dbh->prepare( $query );
		$stmt->execute();
		$result = $stmt->fetchAll( PDO::FETCH_ASSOC );
		$response = array();
		
		$json = json_encode( $result );
		echo $json;

	}
	
	private function joServiceReport(){
		$data = file_get_contents("php://input");
		$objData = json_decode($data);
		
		$query = 'SELECT * FROM tbl_servicereport WHERE jo_no="'. $objData->data .'" AND sr_removed=0';
		$stmt = $this->dbh->prepare( $query );
		$stmt->execute();
		$result = $stmt->fetchAll( PDO::FETCH_ASSOC );
		$response = array();

		$json = json_encode( $result );
		echo $json;
	}
	
	private function srTotals(){
		$data = file_get_contents("php://input");
		$objData = json_decode($data);
		$total = 0;
		$query = 'SELECT * FROM tbl_servicereport WHERE jo_no="'. $objData->data .'" AND sr_removed=0';
		$stmt = $this->dbh->prepare( $query );
		$stmt->execute();
		$result = array();
		$x=0;
		while($row = $stmt->fetch( PDO::FETCH_ASSOC )){
			$total += $row['sr_amount'];
			
			$x+=1;
		}
		$result['totals'] = "Php " . number_format($total, 2, ".", ",");
		$json = json_encode( $result );
		echo '[' . $json . ']';
	}
	
	
}


$api = new api;
$api->processApi();


?>