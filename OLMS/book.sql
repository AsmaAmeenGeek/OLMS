-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2025 at 07:01 PM
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
  `Availability` int DEFAULT NULL,
  `Status` enum('Available','Reserved','CheckedOut') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Available',
  `PDF_Link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`BookId`, `Title`, `Publisher`, `Year`, `Availability`, `Status`, `PDF_Link`) VALUES
(1, 'harry potter', 'Penguin Classics', '2004', 0, 'Reserved', 'uploads/pdfs/book_1_1741714107.pdf'),
(3, 'The Great Gatsby', 'Charles Scribner\'s Sons', '1980', 2, 'Reserved', 'uploads/pdfs/book_3_1741713516.pdf'),
(4, 'Moby Dick', 'Harper & Brothers', '1990', 8, 'Reserved', 'uploads/pdfs/book_4_1741713646.pdf'),
(6, 'A Game of Thrones', 'Bantam Books', '2010', 1, 'Reserved', 'uploads/pdfs/book_6_1741713886.pdf'),
(7, 'The Hobbit', 'George Allen & Unwin', '2009', 1, 'Reserved', 'uploads/pdfs/book_7_1741713954.pdf'),
(8, 'A Brief History of Humankind', 'Harper', '1980', 2, 'Reserved', 'uploads/pdfs/book_8_1741714498.pdf'),
(9, 'The Power of Habit', 'Random House', '1999', 3, 'Reserved', 'uploads/pdfs/book_9_1741714374.pdf'),
(15, 'ffff', 'ii', '2001', 0, 'Reserved', '../Assets/book_67d061667ed7c.pdf');

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
  MODIFY `BookId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
