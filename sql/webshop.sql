-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2018 at 08:24 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Mail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `username`, `Name`, `Surname`, `Mail`, `Pass`) VALUES
(1, '', 'Luca', 'Colagiorgio', 'l.colagiorgio@hotmail.com', 'test123'),
(2, 'test', 'test', 'test', 'test@test.ch', '$2y$10$BBCpJxgPa8K.iw9ZporxzuW2Lt478RPUV/JFvKRHKzJhIwGhd1tpa'),
(3, 'test2', '', '', 'test@test2.ch', '$2y$10$VaOSjsNV9t.72v4kX.igUOc2LR9XUziCp922kCtBvyTthQaPArDtS'),
(4, 'test3', '', '', 'test3@test.ch', '$2y$10$b9rV1jE4PoAls2yIUNIP/uB/o1nOBRkfigsqSFY0OTYvKzebeqJwK'),
(5, 'qwertz', 'Luca', 'Colagiorgio', 'test123@test.ch', '$2y$10$1hywxF2.WHWzYnY73nEILei8KdkUGBGOZsXTIUbS6KieCeeuFQQGy');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `quantity` int(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `accepted` enum('Yes','No','','') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `c_id`, `r_id`, `price`, `quantity`, `timestamp`, `accepted`) VALUES
(1, 3, 4, '4.00', 4, '2018-03-08 19:19:23', 'Yes'),
(2, 3, 4, '44.00', 44, '2018-03-08 19:23:50', 'Yes'),
(3, 3, 1, '3.00', 2, '2018-03-07 21:16:33', 'No'),
(4, 5, 2, '33.00', 21, '2018-03-08 19:14:55', 'Yes'),
(5, 5, 2, '4.00', 23, '2018-03-08 19:17:25', 'Yes'),
(6, 5, 2, '55.00', 23, '2018-03-08 19:22:30', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `Item` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` decimal(20,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('Open','Closed') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `c_id`, `Item`, `subject`, `descr`, `Date`, `timestamp`, `price`, `quantity`, `status`) VALUES
(1, 2, 'test', 'asd', 'asd', '0000-00-00', '2018-03-07 21:16:01', '123.00', 321, 'Open'),
(2, 3, 'tisch', 'test', 'descri', '0000-00-00', '2018-03-07 21:16:10', '32.00', 32333, 'Open'),
(3, 5, 'schrauben', 'Verkaufe Bolzen 12mm', 'Neu zustand bla', '0000-00-00', '2018-03-07 21:16:23', '123.00', 70, 'Open'),
(4, 3, 'bolt 4', 'asd', '1', '0000-00-00', '2018-03-06 14:59:26', '1.00', 1, 'Open'),
(5, 3, 'fff', 'asd', '3', '0000-00-00', '2018-03-06 14:59:44', '3.00', 3, 'Open'),
(6, 3, 'nieten', '123dasd', 'dsa', '0000-00-00', '2018-03-08 18:33:43', '2018.00', 1, 'Open'),
(7, 3, 'nieten', 'asd', 'dsasd', '2018-03-29', '2018-03-08 18:34:20', '321.00', 3, 'Open');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_id` (`c_id`),
  ADD KEY `r_id` (`r_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_id` (`c_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offers_ibfk_2` FOREIGN KEY (`r_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
