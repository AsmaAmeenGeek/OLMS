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
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `Message_id` int(10) NOT NULL,
  `RollNo` varchar(50) DEFAULT NULL,
  `Message` varchar(250) DEFAULT NULL,
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
(6, 's009', 'Your request for issue of BookId: 007 has been rejected.', '2024-04-13', '09:23:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`Message_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
