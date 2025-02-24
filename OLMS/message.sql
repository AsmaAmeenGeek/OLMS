-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 02:28 PM
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
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `Message_id` int NOT NULL,
  `RollNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Message` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`Message_id`, `RollNo`, `Message`, `Date`, `Time`) VALUES
(1, 's001', 'Your request for BookId: 001 has been accepted.', '2024-12-10', '12:30:30'),
(2, 's002', 'Your request for BookId: 004  has been accepted.', '2024-10-10', '15:30:20'),
(3, 's005', 'Your request for return of BookId: 006 has been accepted.', '2024-12-09', '12:40:55'),
(4, 's006', 'Your request for return of BookId: 002 has been accepted.', '2024-05-09', '09:40:30'),
(5, 's008', 'Your request for return of BookId: 003 has been accepted.', '2024-09-14', '07:12:40'),
(6, 's009', 'Your request for issue of BookId: 007 has been rejected.', '2024-04-13', '09:23:55'),
(7, 's003', 'ji', '2025-02-23', '19:40:18'),
(8, 's003', 'ji', '2025-02-23', '19:41:15'),
(9, 's003', 'ji', '2025-02-23', '19:44:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`Message_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `Message_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
