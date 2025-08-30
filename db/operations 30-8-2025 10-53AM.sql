-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2025 at 09:21 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `equipation`
--

-- --------------------------------------------------------

--
-- Table structure for table `operations`
--

CREATE TABLE `operations` (
  `id` int(11) NOT NULL,
  `entry_name` varchar(100) NOT NULL,
  `entry_date` varchar(10) NOT NULL,
  `equipment_name` text,
  `equipment_type` text,
  `ownership_type` text,
  `owner_name` text,
  `plate_no` text,
  `client_name` text,
  `project_name` text,
  `site_name` text,
  `shift` text,
  `today_hours` text,
  `work_hours` text,
  `standby_hours` text,
  `overtime_hours` text,
  `total_work_hours` text,
  `hr_fault` varchar(50) DEFAULT NULL,
  `maintenance_fault` varchar(50) DEFAULT NULL,
  `excavator_fault` varchar(50) DEFAULT NULL,
  `other_hours` varchar(50) DEFAULT NULL,
  `total_downtime_hours` varchar(50) DEFAULT NULL,
  `trips_count` text,
  `load_weight` text,
  `total_weight` text,
  `start_meter` text,
  `end_meter` text,
  `total_km` text,
  `fuel_consumption` text,
  `avg_consumption` text,
  `fault_type` text,
  `fault_section` text,
  `faulty_part` text,
  `fault_details` text,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `operations`
--
ALTER TABLE `operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
