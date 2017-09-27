-- phpMyAdmin SQL Dump
-- version 2.11.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 28, 2015 at 08:23 PM
-- Server version: 5.5.42
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `youthcyb_160s2g4`
--

-- --------------------------------------------------------

--
-- Table structure for table `registrationdb`
--

DROP TABLE IF EXISTS `registrationdb`;
CREATE TABLE IF NOT EXISTS `registrationdb` (
  `username` varchar(22) NOT NULL,
  `password` text NOT NULL,
  `timestamp` int(16) NOT NULL,
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registrationdb`
--

INSERT INTO `registrationdb` (`username`, `password`, `timestamp`) VALUES
('account@gmail.com', '$P$BuehATLX88QoQDTSLJt8as3tDmsYcD.', 1430264673),
('potato@potato.com', '$P$BiD7wNReDqAW5WrEvlTvWJJ/7pASjB.', 1430272384),
('teestest@gmail.com', '$P$B4ETGBJznHK4KHOthjO4cp7lskHHrX/', 1430263227),
('test@gmail.com', '$P$BaaI0SDZyGFzYJi7VlGiTWG3QzU2V/1', 1430264208),
('testest@gmail.com', '$P$BtZ/vYmEsrXRkJHxuPLiGU9jXvlmMw.', 1430264526);
