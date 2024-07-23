-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2024 at 05:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Contact_Number` varchar(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `Name`, `Contact_Number`, `Address`, `role`, `email`, `username`, `password`) VALUES
(1, 'try', '09234567891', 'sana gumana', 'guard', 'tryguard@gmail.com', 'tryguard', '6467b9cee1c277da5021803831be8aa3'),
(2, 'admin', '09234567891', 'sa admin naman', 'admin', 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(3, 'owner', '09234567891', 'hahahahahaha', 'owner', 'owner@gmail.com', 'owner', '5be057accb25758101fa5eadbbd79503'),
(5, 'John Vincent Delima', '9519299068', '123', 'owner', 'jvdelima9@gmail.com', 'jvdelima9@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `content`) VALUES
(1, 'Announcement', 'sadasdsa'),
(2, 'Announcement', ''),
(3, 'Announcement', ''),
(4, 'Announcement', ''),
(5, 'Announcement', ''),
(6, 'Announcement', ''),
(7, 'Announcement', ''),
(8, 'Announcement', ''),
(9, 'Announcement', ''),
(10, 'Announcement', ''),
(11, 'Announcement', 'asdsa'),
(12, 'Announcement', ''),
(13, 'Announcement', ''),
(14, 'Announcement', 'sadsa'),
(15, 'Announcement', ''),
(16, '', ''),
(17, 'Announcement', ''),
(18, 'Announcement', ''),
(19, 'test', ''),
(20, 'test', ''),
(21, 'tetessssst', ''),
(22, 'tetessssst', ''),
(23, 'tetessssst', ''),
(24, 'tetessssst', ''),
(25, 'Announcement', 'asdasdas');

-- --------------------------------------------------------

--
-- Table structure for table `home_owner`
--

CREATE TABLE `home_owner` (
  `HO_Id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `hnum` varchar(255) NOT NULL,
  `con_num` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `qr_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_owner`
--

INSERT INTO `home_owner` (`HO_Id`, `fname`, `lname`, `hnum`, `con_num`, `email`, `image`, `qr_code`) VALUES
(15, 'John Vincent', 'Delima', '123', '9519299068', 'jvdelima9@gmail.com', 'uploads/john vincent_delima.png', 'qr_code/john vincent_delima.png');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `HO_name` varchar(255) NOT NULL,
  `HO_housenum` varchar(255) NOT NULL,
  `Guest_name` varchar(255) NOT NULL,
  `Guest_email` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `HO_name`, `HO_housenum`, `Guest_name`, `Guest_email`, `message`) VALUES
(1, 'Jvie', '112', 'Philip Emmanuel Bucal', 'emmanbucal@gmail.com', 'help'),
(2, 'Emman', '056', 'Jvie Delima', 'Jviedeloima@gmail.com', 'Here to Visit'),
(3, 'emman', '123', 'renzo', 'admin@gmail.com', 'papasok');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_owner`
--
ALTER TABLE `home_owner`
  ADD PRIMARY KEY (`HO_Id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `home_owner`
--
ALTER TABLE `home_owner`
  MODIFY `HO_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
