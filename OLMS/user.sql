-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 27, 2024 at 07:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `olms`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `RollNo` varchar(250) NOT NULL,
  `Name` varchar(250) DEFAULT NULL,
  `Type` varchar(20) DEFAULT NULL,
  `Category` varchar(50) DEFAULT NULL,
  `EmailId` varchar(250) DEFAULT NULL,
  `MobNo` bigint(11) DEFAULT NULL,
  `Password` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`RollNo`, `Name`, `Type`, `Category`, `EmailId`, `MobNo`, `Password`) VALUES
('ADMIN', 'Admin', 'Admin', '', 'admin@gmail.com', 701237865, 'admin'),
('s001', 'Shiva', 'Student', 'ST', 'shiva@gmail.com', 703237865, 's123'),
('s002', 'John', 'Student', 'GEN', 'john@gmail.com', 701234865, 's223'),
('s003', 'Karthi', 'Student', 'OBC', 'karthi@gmail.com', 701297865, 's323'),
('s004', 'Moni', 'Student', 'GEN', 'moni@gmail.com', 721237865, 's423'),
('s005', 'Shakthi', 'Student', 'ST', 'shakthi@gmail.com', 701237065, 's523'),
('s006', 'Rachel', 'Student', 'OBC', 'rachel@gmail.com', 701231865, 's623'),
('s007', 'Adam', 'Student', 'GEN', 'adam@gmail.com', 771237865, 's723'),
('s008', 'Kevin', 'Student', 'GEN', 'kevin@gmail.com', 701237868, 's823'),
('s009', 'Bob', 'Student', 'GEN', 'bob@gmail.com', 70123783, 's923');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`RollNo`),
  ADD UNIQUE KEY `EmailId` (`EmailId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
