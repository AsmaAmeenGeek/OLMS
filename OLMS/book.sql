-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2025 at 01:22 PM
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
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `BookId` int NOT NULL,
  `Title` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Publisher` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Year` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Availability` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`BookId`, `Title`, `Publisher`, `Year`, `Availability`) VALUES
(1, 'Pride and Prejudice', 'Penguin Classics', '2002', 7),
(2, 'To Kill a Mockingbird', 'J.B. Lippincott & Co.', '2000', 3),
(3, 'The Great Gatsby', 'Charles Scribner\'s Sons', '1980', 1),
(4, 'Moby Dick', 'Harper & Brothers', '1990', 9),
(5, 'Harry Potter and the Philosopher\'s Stone', 'Bloomsbury', '1998', 10),
(6, 'A Game of Thrones', 'Bantam Books', '2010', 1),
(7, 'The Hobbit', 'George Allen & Unwin', '2009', 1),
(8, 'A Brief History of Humankind', 'Harper', '1980', 1),
(9, 'The Power of Habit', 'Random House', '1999', 4),
(10, 'harry', 'ab', '2001', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`BookId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `BookId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
