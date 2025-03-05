-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 01:03 AM
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
-- Table structure for table `renew_requests`
--

CREATE TABLE `renew_requests` (
  `request_id` int(11) NOT NULL,
  `RollNo` varchar(50) NOT NULL,
  `BookId` int(11) NOT NULL,
  `status` enum('pending','accepted','declined') DEFAULT 'pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `renew_requests`
--
ALTER TABLE `renew_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `RollNo` (`RollNo`),
  ADD KEY `BookId` (`BookId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `renew_requests`
--
ALTER TABLE `renew_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `renew_requests`
--
ALTER TABLE `renew_requests`
  ADD CONSTRAINT `renew_requests_ibfk_1` FOREIGN KEY (`RollNo`) REFERENCES `user` (`RollNo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `renew_requests_ibfk_2` FOREIGN KEY (`BookId`) REFERENCES `book` (`BookId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
