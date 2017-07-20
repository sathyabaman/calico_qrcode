-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 20, 2017 at 03:10 PM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surplus_barcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `loginAttempts`
--

CREATE TABLE `loginAttempts` (
  `IP` varchar(20) NOT NULL,
  `Attempts` int(11) NOT NULL,
  `LastLogin` datetime NOT NULL,
  `Username` varchar(65) DEFAULT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loginAttempts`
--

INSERT INTO `loginAttempts` (`IP`, `Attempts`, `LastLogin`, `Username`, `ID`) VALUES
('127.0.0.1', 2, '2017-07-20 14:48:25', 'sathya', 6),
('127.0.0.1', 3, '2017-07-20 14:52:47', 'root', 7);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` char(23) NOT NULL,
  `username` varchar(65) NOT NULL DEFAULT '',
  `password` varchar(65) NOT NULL DEFAULT '',
  `email` varchar(65) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `mod_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `email`, `verified`, `mod_timestamp`) VALUES
('1', 'sathya', 'sathya', 'sathya@gmail.com', 1, '2017-07-19 18:30:00'),
('2', 'surplusAdmin', 'surplusAdmin', 'sa@gmail.com', 1, '2017-07-19 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `productlist`
--

CREATE TABLE `productlist` (
  `ctn` int(10) NOT NULL,
  `barcode` varchar(60) NOT NULL,
  `pi` varchar(60) NOT NULL,
  `po` varchar(60) NOT NULL,
  `im` varchar(60) NOT NULL,
  `color` varchar(60) NOT NULL,
  `style` varchar(60) NOT NULL,
  `length` int(8) NOT NULL,
  `qty` int(8) NOT NULL,
  `total` int(8) NOT NULL,
  `nett` double NOT NULL,
  `gross` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productlist`
--

INSERT INTO `productlist` (`ctn`, `barcode`, `pi`, `po`, `im`, `color`, `style`, `length`, `qty`, `total`, `nett`, `gross`) VALUES
(1, '12ct25365sa', '2555', '3658', '29d555', 'dddd5522', '5 vgbmk mmn', 25, 25, 658, 12.5, 65.3),
(2, '9865gglf', '74', '584', '25611', 'sfefdsdfsf fsdf', 'fsdfsdf fsdff', 66666, 5222, 5588, 65.6, 35.6),
(3, '256857iu45', '857', '55885555', '22255', 'color red', 'gangam', 256, 253, 365, 25.6, 365.6),
(4, 'fddfd525555', '6555', '2033', '666', '66666', 'flluay', 55, 698, 566, 68.6, 3578.25),
(5, 'sathya654', '5258', '2665', '2222', 'color 254', 'fdsfsd style', 552, 5255, 222, 6983.5, 635.6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loginAttempts`
--
ALTER TABLE `loginAttempts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `productlist`
--
ALTER TABLE `productlist`
  ADD PRIMARY KEY (`ctn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loginAttempts`
--
ALTER TABLE `loginAttempts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `productlist`
--
ALTER TABLE `productlist`
  MODIFY `ctn` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
