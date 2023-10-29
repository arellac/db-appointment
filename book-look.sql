-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2023 at 02:25 AM
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
-- Database: `book-look`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aemail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appoid` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time NOT NULL,
  `s_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appoid`, `c_id`, `scheduledate`, `scheduletime`, `s_id`, `service_id`, `payment_method`) VALUES
(1, 7, '2023-11-05', '12:00:00', 8, 10, 0),
(2, 7, '2023-11-05', '12:00:00', 8, 10, 0),
(3, 7, '2023-11-05', '12:00:00', 8, 10, 0),
(4, 7, '2023-11-06', '12:00:00', 8, 5, 0),
(5, 7, '2023-11-06', '12:00:00', 8, 4, 0),
(6, 7, '2023-11-06', '13:00:00', 8, 4, 0),
(7, 7, '2023-11-06', '12:00:00', 8, 4, 0),
(8, 7, '2023-10-29', '10:00:00', 8, 4, 0),
(9, 7, '2023-10-29', '09:00:00', 8, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `c_id` int(11) NOT NULL,
  `c_email` varchar(255) NOT NULL,
  `c_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`c_id`, `c_email`, `c_name`) VALUES
(7, 'test123@gmail.com', 'Test Account');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `m_id` int(11) NOT NULL,
  `m_email` varchar(255) NOT NULL,
  `m_number` varchar(20) NOT NULL,
  `m_name` varchar(255) DEFAULT NULL,
  `m_password` varchar(255) DEFAULT NULL,
  `role` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`m_id`, `m_email`, `m_number`, `m_name`, `m_password`, `role`) VALUES
(7, 'test123@gmail.com', '012', 'Test Account', '123', 'C'),
(8, '1@gmail.com', '123456789', 'Name', '123', 'S'),
(10, '2@gmail.com', '123456789', 'Name', '123', 'S');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_price` int(11) NOT NULL,
  `service_details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_price`, `service_details`) VALUES
(2, 'Haircut', 25, 'A nice haircut'),
(3, 'Haircut2', 252, 'A nice haircu2'),
(4, 'Haircut2', 252, 'A nice haircu2'),
(5, 'd', 12, 'd'),
(6, 'AAA', 222, 'AA'),
(7, 'd', 22, 'aa'),
(8, 'd', 22, 'aa'),
(9, 'd', 323, 'a'),
(10, 'AD', 443, 'DDEA');

-- --------------------------------------------------------

--
-- Table structure for table `stylist`
--

CREATE TABLE `stylist` (
  `s_id` int(11) NOT NULL,
  `s_email` varchar(255) NOT NULL,
  `s_name` varchar(255) DEFAULT NULL,
  `sln_name` varchar(255) DEFAULT NULL,
  `sln_info` text NOT NULL,
  `sln_address` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stylist`
--

INSERT INTO `stylist` (`s_id`, `s_email`, `s_name`, `sln_name`, `sln_info`, `sln_address`, `image_url`) VALUES
(8, '1@gmail.com', 'Young Thug', 'Jeffrey', '', '123 Street Address, Munster, IN', 'https://pbs.twimg.com/media/F9evRUIXAAAv24x?format=jpg&name=large');

-- --------------------------------------------------------

--
-- Table structure for table `stylist_services`
--

CREATE TABLE `stylist_services` (
  `service_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stylist_services`
--

INSERT INTO `stylist_services` (`service_id`, `s_id`) VALUES
(3, 8),
(4, 8),
(5, 8),
(6, 8),
(9, 8),
(10, 8);

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
  ADD KEY `c_id` (`c_id`),
  ADD KEY `s_id` (`s_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `c_email` (`c_email`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`m_id`),
  ADD UNIQUE KEY `m_email` (`m_email`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `stylist`
--
ALTER TABLE `stylist`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `s_email` (`s_email`);

--
-- Indexes for table `stylist_services`
--
ALTER TABLE `stylist_services`
  ADD PRIMARY KEY (`service_id`,`s_id`),
  ADD KEY `s_id` (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`aemail`) REFERENCES `members` (`m_email`);

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `client` (`c_id`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`s_id`) REFERENCES `stylist` (`s_id`),
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `members` (`m_id`),
  ADD CONSTRAINT `client_ibfk_2` FOREIGN KEY (`c_email`) REFERENCES `members` (`m_email`);

--
-- Constraints for table `stylist`
--
ALTER TABLE `stylist`
  ADD CONSTRAINT `stylist_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `members` (`m_id`),
  ADD CONSTRAINT `stylist_ibfk_2` FOREIGN KEY (`s_email`) REFERENCES `members` (`m_email`);

--
-- Constraints for table `stylist_services`
--
ALTER TABLE `stylist_services`
  ADD CONSTRAINT `stylist_services_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  ADD CONSTRAINT `stylist_services_ibfk_2` FOREIGN KEY (`s_id`) REFERENCES `stylist` (`s_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
