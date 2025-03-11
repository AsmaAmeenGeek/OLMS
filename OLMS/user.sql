-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2025 at 07:00 PM
-- Server version: 8.0.23
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
  `RollNo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Name` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Type` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `EmailId` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `MobNo` bigint DEFAULT NULL,
  `Password` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ProfilePicture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`RollNo`, `Name`, `Type`, `EmailId`, `MobNo`, `Password`, `ProfilePicture`) VALUES
('ADMIN', 'Admin', 'Admin', 'admin@gmail.com', 701237862, 'admin', '../Assets/profile/download.jpeg'),
('s001', 'Shiva', 'Student', 'shiva@gmail.com', 784567890, 's123', '../Assets/profile/profile_6.jpg'),
('s002', 'John', 'Student', 'john@gmail.com', 701234865, 's223', '../Assets/profile/profile_7.jpg'),
('s003', 'Karthi', 'Student', 'karthi@gmail.com', 701297865, 's323', '../Assets/profile/profile_1.jpg'),
('s004', 'Moni', 'Student', 'Moni@gmail.com', 721237865, 's423', '../Assets/profile/profile_6.jpg'),
('s005', 'Shakthi', 'Student', 'Shakthi@gmail.com', 701237065, 's523', '../Assets/profile/profile_9.png'),
('s006', 'Rachel', 'Student', 'rachel@gmail.com', 701231865, 's623', '../Assets/profile/profile_5.jpg'),
('s007', 'Adam', 'Student', 'adam@gmail.com', 771237865, 's723', '../Assets/profile/profile_9.png'),
('s008', 'Kevin', 'Student', 'kevin@gmail.com', 701237868, 's823', '../Assets/profile/profile_10.jpg');

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
