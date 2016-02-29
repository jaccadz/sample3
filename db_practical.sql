-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 29, 2016 at 10:43 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_practical`
--
CREATE DATABASE IF NOT EXISTS `db_practical` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_practical`;

-- --------------------------------------------------------

--
-- Table structure for table `outgoing`
--

CREATE TABLE IF NOT EXISTS `outgoing` (
  `o_id` int(11) NOT NULL AUTO_INCREMENT,
  `o_fromName` varchar(50) NOT NULL,
  `o_fromTelephone` varchar(10) NOT NULL,
  `o_toName` varchar(50) NOT NULL,
  `o_toTelephone` varchar(10) NOT NULL,
  `o_message` varchar(500) NOT NULL,
  `o_dateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`o_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `outgoing`
--

INSERT INTO `outgoing` (`o_id`, `o_fromName`, `o_fromTelephone`, `o_toName`, `o_toTelephone`, `o_message`, `o_dateTime`) VALUES
(1, 'John', '', 'David', '', 'Hi David!', '2016-02-29 17:40:36'),
(2, 'David', '', 'John', '', 'Hi John!', '2016-02-29 17:40:52'),
(3, 'David', '', 'John', '', 'Hi John!', '2016-02-29 17:40:57'),
(4, 'David', '', 'John', '', 'How have you been', '2016-02-29 17:41:12'),
(5, 'John', '', 'David', '', 'We are all good, thanks, and you?', '2016-02-29 17:41:31'),
(6, 'Jacob', '', 'Javier', '', 'Good day!', '2016-02-29 17:42:23'),
(7, 'Jacob', '', 'Javier', '', 'How are you?', '2016-02-29 17:42:43'),
(8, 'Javier', '', 'Jacob', '', 'Im fine. thank you!', '2016-02-29 17:42:54'),
(9, 'Javier', '', 'Jacob', '', 'Im fine. thank you!', '2016-02-29 17:42:58');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
