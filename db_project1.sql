-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2023 at 08:40 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aemail` varchar(255) NOT NULL,
  `apassword` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aemail`, `apassword`) VALUES
('admin@stylist.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appoid` int(11) NOT NULL,
  `pid` int(10) DEFAULT NULL,
  `apponum` int(3) DEFAULT NULL,
  `scheduleid` int(10) DEFAULT NULL,
  `appodate` date DEFAULT NULL,
  `scheduletime` time NOT NULL,
  `sid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appoid`, `pid`, `apponum`, `scheduleid`, `appodate`, `scheduletime`, `sid`) VALUES
(15, 1, 1, 1, '2023-09-19', '14:00:00', 4),
(14, 1, 1, 1, '2023-09-19', '12:00:00', 4),
(13, 1, 1, 1, '2023-09-19', '15:00:00', 4),
(12, 1, 1, 1, '2023-09-20', '12:00:00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `cid` int(11) NOT NULL,
  `cemail` varchar(255) DEFAULT NULL,
  `cname` varchar(255) DEFAULT NULL,
  `cpassword` varchar(255) DEFAULT NULL,
  `caddress` varchar(255) DEFAULT NULL,
  `cnic` varchar(15) DEFAULT NULL,
  `cdob` date DEFAULT NULL,
  `ctel` varchar(15) DEFAULT NULL,
  `favorites` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`favorites`))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`cid`, `cemail`, `cname`, `cpassword`, `caddress`, `cnic`, `cdob`, `ctel`, `favorites`) VALUES
(1, 'client@stylist.com', 'Test Client', '123', '', NULL, NULL, NULL, '[1,3]'),
(4, 'test23@gmail.com', 'Test Client2', '123', NULL, NULL, NULL, NULL, NULL),
(5, 'ab@mail.com', 'a b', '123', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `cid` int(11) NOT NULL,
  `cemail` varchar(255) DEFAULT NULL,
  `cname` varchar(255) DEFAULT NULL,
  `cpassword` varchar(255) DEFAULT NULL,
  `caddress` varchar(255) DEFAULT NULL,
  `cnic` varchar(15) DEFAULT NULL,
  `cdob` date DEFAULT NULL,
  `ctel` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`cid`, `cemail`, `cname`, `cpassword`, `caddress`, `cnic`, `cdob`, `ctel`) VALUES
(36, 'stylist2@mail.com', 'Stylist Name 2', '123', '', '', '0000-00-00', ''),
(35, 'ab@mail.com', 'a b', '123', '', '', '0000-00-00', ''),
(34, 'test23@gmail.com', 'Test Client2', '123', '', '', '0000-00-00', ''),
(33, 'mail@mail.com', 'First Last', '123', '', '', '0000-00-00', ''),
(32, 'testStylist@mail.com', 'Test Client', '123', '', '', '0000-00-00', ''),
(31, 'client@stylist.com', 'Client', '123', NULL, NULL, NULL, NULL),
(30, 'stylist@stylist.com', 'Stylist', '123', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `one_time_links`
--

CREATE TABLE `one_time_links` (
  `user_id` int(11) NOT NULL,
  `link` text NOT NULL,
  `expiration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `one_time_links`
--

INSERT INTO `one_time_links` (`user_id`, `link`, `expiration_date`) VALUES
(111, 'WXK9nBejps4lKpHmiObtQc167gRr3Spd', '2023-09-14'),
(123, 'GpNzO12hVl7L92sJY83rVnoOeW2MUTcu', '2023-09-22'),
(133, 'T6PZ7kgANHqdXr6n6mkpQ6w8sGqzDJVn', '2023-09-20'),
(154, '5aZDnCcNIg9Xc4NdI6ai73xEiIkTCwZQ', '2023-09-14'),
(444, 'VtNMkNubec2KpoV9BKyMeWGKZQZCLLVw', '2023-09-15'),
(1111, 'YjXhnh6UDxNVXYWPGqRgMHEXe9Cv6R3p', '2023-09-21'),
(4444, 'InwGno2yCh1hf7EGocPWbCDcOgjXGFXj', '2023-09-27');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scheduleid` int(11) NOT NULL,
  `docid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time DEFAULT NULL,
  `nop` int(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleid`, `docid`, `title`, `scheduledate`, `scheduletime`, `nop`) VALUES
(1, '1', 'Test Session', '2050-01-01', '18:00:00', 50),
(2, '1', '1', '2022-06-10', '20:36:00', 1),
(3, '1', '12', '2022-06-10', '20:33:00', 1),
(4, '1', '1', '2022-06-10', '12:32:00', 1),
(5, '1', '1', '2022-06-10', '20:35:00', 1),
(6, '1', '12', '2022-06-10', '20:35:00', 1),
(7, '1', '1', '2022-06-24', '20:36:00', 1),
(8, '1', '12', '2022-06-10', '13:33:00', 1),
(9, '1', 'sss', '2222-02-22', '14:22:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stylist`
--

CREATE TABLE `stylist` (
  `sid` int(11) NOT NULL,
  `semail` varchar(255) DEFAULT NULL,
  `sname` varchar(255) DEFAULT NULL,
  `spassword` varchar(255) DEFAULT NULL,
  `snic` varchar(15) DEFAULT NULL,
  `stel` varchar(15) DEFAULT NULL,
  `sln_name` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stylist`
--

INSERT INTO `stylist` (`sid`, `semail`, `sname`, `spassword`, `snic`, `stel`, `sln_name`, `image_url`) VALUES
(1, 'stylist@stylist.com', 'Test Stylist', '123', '000000000', '0110000000', 'Salon 1', 'https://photoai.com/cdn-cgi/image/format=jpeg,width=1536,quality=75/https://r2.photoai.com/1690071399-144fefcdce08c48f8a694e3c48efd4c3-13.png'),
(3, 'testStylist@mail.com', 'Test Client', '123', NULL, NULL, 'Salon 2', 'https://photoai.com/cdn-cgi/image/format=jpeg,width=1536,quality=75/https://r2.photoai.com/1689877257-feaaf59ef2db988158d85b4f84a65ba3-1.png'),
(4, 'mail@mail.com', 'First Last', '123', NULL, NULL, 'Salon 3', 'https://photoai.com/cdn-cgi/image/format=jpeg,width=1536,quality=75/https://r2.photoai.com/1689974543-defb2677e4eca1533649b80997a87103-9.png'),
(5, 'stylist2@mail.com', 'Stylist Name 2', '123', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `webuser`
--

CREATE TABLE `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `webuser`
--

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('admin@stylist.com', 'a'),
('stylist2@mail.com', 'd'),
('ab@mail.com', 'p'),
('test23@gmail.com', 'p'),
('mail@mail.com', 'd'),
('testStylist@mail.com', 'd'),
('client@stylist.com', 'p'),
('stylist@stylist.com', 'd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aemail`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appoid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `scheduleid` (`scheduleid`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `one_time_links`
--
ALTER TABLE `one_time_links`
  ADD UNIQUE KEY `index` (`user_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleid`),
  ADD KEY `docid` (`docid`);

--
-- Indexes for table `stylist`
--
ALTER TABLE `stylist`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `webuser`
--
ALTER TABLE `webuser`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stylist`
--
ALTER TABLE `stylist`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
