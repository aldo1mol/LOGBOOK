-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 07:18 PM
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
-- Database: `uits`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `device_brand` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `device_brand`) VALUES
(1, 'HEWLETT-PACKARD(HP)'),
(2, 'MSI'),
(3, 'TOSHIBA'),
(4, 'ACER'),
(5, 'DELL'),
(6, 'LENOVO'),
(7, 'COMPAQ'),
(8, 'ASUS'),
(9, 'ALIENWARE'),
(10, 'KAT'),
(11, 'APPLE'),
(12, 'SAMSUNG'),
(13, 'MICROSOFT'),
(14, 'MAC'),
(15, 'TM1');

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `device_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`id`, `device_name`) VALUES
(1, 'Charger'),
(2, 'Desktop'),
(3, 'HDD'),
(4, 'Laptop'),
(5, 'Pendrive'),
(6, 'Phone'),
(7, 'Printer'),
(8, 'Projector'),
(9, 'Scanner'),
(10, 'Tablet'),
(11, 'UPS'),
(12, 'Mobile Phone');

-- --------------------------------------------------------

--
-- Table structure for table `logbook`
--

CREATE TABLE `logbook` (
  `id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `issue_reported` varchar(255) NOT NULL,
  `device_type` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `machine_model` varchar(255) NOT NULL,
  `serial_number` varchar(20) NOT NULL,
  `received_by` varchar(255) NOT NULL,
  `additional_items` varchar(255) NOT NULL,
  `hypothesis` varchar(255) NOT NULL,
  `wikihow` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `handled_by` varchar(255) NOT NULL,
  `date_fixed` varchar(20) NOT NULL,
  `date_taken` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logbook`
--

INSERT INTO `logbook` (`id`, `date`, `name`, `contact`, `department`, `issue_reported`, `device_type`, `brand_name`, `machine_model`, `serial_number`, `received_by`, `additional_items`, `hypothesis`, `wikihow`, `status`, `handled_by`, `date_fixed`, `date_taken`) VALUES
(1, '2024-02-11', 'Caroline Efua', 557842528, 'Pharmacy', 'Laptop power button not working', 'Laptop', 'Asus', 'cod88499  ', '9938mmcmc', 'Laptop', 'charger', 'Needs to be examined further to know the problem', 'Cleaned the ram', '', 'Laptop', '2024-02-11', '2024-02-11'),
(3, '2024-02-11', 'Jullian', 557842528, 'Pharmacy', 'Blue screen on power up', 'Laptop', 'Asus', 'cod88499  ', '9938mmcmc', 'Laptop', 'charger', 'Ram needs to be cleaned', 'cleaned ram with eraser', 'Fixed', 'Laptop', '2024-02-11', '2024-02-11');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status_type`) VALUES
(1, 'Fixed'),
(2, 'Not Successful'),
(3, 'Awaiting Part');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `priority`) VALUES
(1, 'Edinam', 'logbook@uits', 'user'),
(2, 'Lawrence', 'logbook@uits', 'user'),
(3, 'Ablor', 'logbook@uits', 'user\r\n'),
(4, 'Larbi', 'larbi@uits', 'admin'),
(5, 'Collins', 'logbook@uits', 'user\r\n'),
(6, 'Donald', 'logbook@uits', 'admin'),
(7, 'Cedric', 'logbook@uits', 'user'),
(8, 'Chris', 'logbook@uits', 'user'),
(11, 'Felix', 'admin@uits', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logbook`
--
ALTER TABLE `logbook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `logbook`
--
ALTER TABLE `logbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
