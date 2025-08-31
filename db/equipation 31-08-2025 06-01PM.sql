-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2025 at 05:01 PM
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
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `id` int(11) NOT NULL,
  `equipment_code` varchar(50) NOT NULL,
  `equipment_name` varchar(100) NOT NULL,
  `equipment_type` varchar(50) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `plate_number` varchar(50) DEFAULT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`id`, `equipment_code`, `equipment_name`, `equipment_type`, `owner_id`, `model`, `plate_number`, `description`, `status`, `created_at`) VALUES
(2, 'EQERTYY', 'Hino', '2', 3, '2002', '98494', 'Ù‚Ù„Ø§Ø¨ ØµÙŠÙ†ÙŠ', 1, '2025-08-28 08:42:15'),
(4, 'ÙŒREXR', 'Mitsobitchy', '1', 2, '2002', '98493', 'Ø­ÙØ§Ø± Ø§Ù„ÙŠ', 1, '2025-08-28 08:44:26'),
(5, 'EXR', 'Daio', '2', 1, '2005', '6757', 'Ù‚Ù„Ø§Ø¨ ÙŠØ§Ø¨Ø§Ù†ÙŠ', 1, '2025-08-28 08:49:46');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_types`
--

CREATE TABLE `equipment_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `description` text,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equipment_types`
--

INSERT INTO `equipment_types` (`id`, `type_name`, `description`, `status`, `created_at`) VALUES
(1, 'Ø­ÙØ§Ø±', 'ÙŠØ­ÙØ± ', 1, '2025-08-28 08:24:47'),
(2, 'Ù‚Ù„Ø§Ø¨', 'ÙŠÙ‚Ù„Ø¨', 1, '2025-08-28 08:25:01');

-- --------------------------------------------------------

--
-- Table structure for table `excavator`
--

CREATE TABLE `excavator` (
  `id` int(11) NOT NULL,
  `cost_code` varchar(11) NOT NULL,
  `entry_name` varchar(50) NOT NULL,
  `machine_name` varchar(100) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `driver_name` varchar(100) NOT NULL,
  `shift` varchar(50) NOT NULL,
  `shift_hours` int(11) DEFAULT NULL,
  `counter_start` varchar(20) DEFAULT NULL,
  `executed_hours` int(11) DEFAULT NULL,
  `bucket_hours` int(11) DEFAULT NULL,
  `jackhammer_hours` int(11) DEFAULT NULL,
  `extra_hours` int(11) DEFAULT NULL,
  `extra_hours_total` int(11) DEFAULT NULL,
  `standby_hours` int(11) DEFAULT NULL,
  `dependence_hours` varchar(20) NOT NULL,
  `total_work_hours` int(11) DEFAULT NULL,
  `work_notes` text,
  `hr_fault` varchar(100) DEFAULT NULL,
  `maintenance_fault` varchar(100) DEFAULT NULL,
  `marketing_fault` varchar(100) DEFAULT NULL,
  `approval_fault` varchar(100) DEFAULT NULL,
  `other_fault_hours` int(11) DEFAULT NULL,
  `total_fault_hours` varchar(20) NOT NULL,
  `fault_notes` text,
  `counter_end` varchar(20) DEFAULT NULL,
  `counter_diff` varchar(20) DEFAULT NULL,
  `fault_type` varchar(100) DEFAULT NULL,
  `fault_department` varchar(100) DEFAULT NULL,
  `fault_part` varchar(100) DEFAULT NULL,
  `fault_details` text,
  `general_notes` text,
  `operator_hours` varchar(100) DEFAULT NULL,
  `machine_standby_hours` varchar(100) DEFAULT NULL,
  `jackhammer_standby_hours` varchar(20) NOT NULL,
  `bucket_standby_hours` varchar(20) NOT NULL,
  `extra_operator_hours` varchar(100) DEFAULT NULL,
  `operator_standby_hours` varchar(100) DEFAULT NULL,
  `operator_notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `excavator`
--

INSERT INTO `excavator` (`id`, `cost_code`, `entry_name`, `machine_name`, `project_name`, `owner_name`, `driver_name`, `shift`, `shift_hours`, `counter_start`, `executed_hours`, `bucket_hours`, `jackhammer_hours`, `extra_hours`, `extra_hours_total`, `standby_hours`, `dependence_hours`, `total_work_hours`, `work_notes`, `hr_fault`, `maintenance_fault`, `marketing_fault`, `approval_fault`, `other_fault_hours`, `total_fault_hours`, `fault_notes`, `counter_end`, `counter_diff`, `fault_type`, `fault_department`, `fault_part`, `fault_details`, `general_notes`, `operator_hours`, `machine_standby_hours`, `jackhammer_standby_hours`, `bucket_standby_hours`, `extra_operator_hours`, `operator_standby_hours`, `operator_notes`, `created_at`) VALUES
(1, '3', 'medo', 'Mitsobitchy', 'Ù…Ø´Ø±ÙˆØ¹ Ø§Ù„Ø±ÙˆØ³ÙŠØ©', 'Ø¹Ø¨Ø¯ Ø§Ù„Ø±Ø­ÙŠÙ…', 'Ù…Ø­Ù…Ø¯ Ø³ÙŠØ¯', '', 10, '0:00:00', 0, 0, 0, 0, 0, 0, '0', 0, '', '0', '0', '0', '0', 0, '0', '', '0:00:00', '0 Ø³Ø§Ø¹Ø© 0 Ø¯Ù‚ÙŠÙ', '', '', '', '', '', '', '0', '', '', '', '0', '', '2025-08-31 11:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `master`
--

CREATE TABLE `master` (
  `id` int(11) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `plant_no` varchar(100) DEFAULT NULL,
  `contract_type` varchar(100) DEFAULT NULL,
  `yom` year(4) DEFAULT NULL,
  `plate_no` varchar(100) DEFAULT NULL,
  `supplier_code` varchar(100) DEFAULT NULL,
  `owner` varchar(200) DEFAULT NULL,
  `owner_toc` varchar(200) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `releasing_date` date DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `user` varchar(10) NOT NULL,
  `notes` text,
  `hours` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master`
--

INSERT INTO `master` (`id`, `status`, `plant_no`, `contract_type`, `yom`, `plate_no`, `supplier_code`, `owner`, `owner_toc`, `contact_no`, `starting_date`, `releasing_date`, `project_name`, `user`, `notes`, `hours`) VALUES
(3, '1', 'Mitsobitchy', 'Rental', 2002, '98493', 'ÙŒREXR', 'Ø¹Ø¨Ø¯ Ø§Ù„Ø±Ø­ÙŠÙ…', '', '0115667710', '0000-00-00', '0000-00-00', 'Ù…Ø´Ø±ÙˆØ¹ Ø§Ù„Ø±ÙˆØ³ÙŠØ©', '2', 'Ù†Ù…Ù†Ù…', '20'),
(5, '1', 'Hino', 'RentalØ§', 2002, '98494', 'EQERTYY', 'Hino', '', '6567570', '2025-08-08', '0000-00-00', 'Ù…Ø´Ø±ÙˆØ¹ Ø§Ù„Ø±ÙˆØ³ÙŠØ©', '3', 'Ù…Ø§Ùƒ', '100');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `title` longtext NOT NULL,
  `text` longtext NOT NULL,
  `keywords` longtext NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `image`, `title`, `text`, `keywords`, `create_at`) VALUES
(1, '2025032717430739635342.jpg', 'Ø¹ÙˆØ¯Ø© Ø¹ÙÙ‚Ø§Ø¨ ØªØ´ØºÙ„ Ø¨ÙŠØ¦ÙŠÙŠÙ† Ø¨Ø§Ù„Ø¹Ø±Ø¬Ø§Øª', 'ÙÙŠ Ø£Ø­Ø¯Ø« Ù…Ø³ØªØ¬Ø¯Ø§Øª ÙˆØ±Ø´ Ø¥Ø¹Ø§Ø¯Ø© ØªØ£Ù‡ÙŠÙ„ Ø§Ù„Ø·ÙŠÙˆØ± Ø§Ù„Ø¬Ø§Ø±Ø­Ø© Ø¨Ø§Ù„Ù…Ù…Ù„ÙƒØ© Ø£Ø¹Ù„Ù† Ø¬Ù…Ø¹ÙˆÙŠÙˆÙ† ÙŠØ´ØªØºÙ„ÙˆÙ† ÙÙŠ Ø§Ù„Ù…Ø¬Ø§Ù„ Ø§Ù„Ø¨ÙŠØ¦ÙŠ Ø¹Ù† Ø®Ø¨Ø± Ø¹ÙˆØ¯Ø© Ø·ÙŠØ± Ù…Ù† ØµÙ†Ù â€œØ¹ÙÙ‚Ø§Ø¨ Ø§Ù„Ø«Ø¹Ø§Ø¨ÙŠÙ†â€ØŒ Ø§Ù„Ù…Ø¹Ø±ÙˆÙ Ø¹Ù„Ù…ÙŠØ§ Ø¨Ù€â€CircaÃ¨te Jean le Blancâ€ØŒ Ø¥Ù„Ù‰ Ø§Ù„Ù…ØºØ±Ø¨ Ø¨Ø¹Ø¯ Ø­ÙˆØ§Ù„ÙŠ Ø³Ù†ØªÙŠÙ† Ù…Ù† Ø§Ù„ØºÙŠØ§Ø¨.\r\n\r\n\r\nØ¹ÙˆØ¯Ø© Ø¹ÙÙ‚Ø§Ø¨ ØªØ´ØºÙ„ Ø¨ÙŠØ¦ÙŠÙŠÙ† Ø¨Ø§Ù„Ø¹Ø±Ø¬Ø§Øª\r\nØ¹ÙˆØ¯Ø© Ø¹ÙÙ‚Ø§Ø¨ ØªØ´ØºÙ„ Ø¨ÙŠØ¦ÙŠÙŠÙ† Ø¨Ø§Ù„Ø¹Ø±Ø¬Ø§Øª\r\nÙˆØ£ÙˆØ¶Ø­Øª Ø§Ù„Ø¬Ù…Ø¹ÙŠØ© Ø§Ù„Ù…ØºØ±Ø¨ÙŠØ© Ù„Ø­Ù…Ø§ÙŠØ© Ø§Ù„Ø¬ÙˆØ§Ø±Ø­ â€œAMPRâ€ Ø£Ù† Ø¹ÙˆØ¯Ø© Ù‡Ø°Ø§ Ø§Ù„Ø·Ø§Ø¦Ø± Ø§Ù„Ø­Ø§Ù…Ù„ Ù„Ù„ØªØ±Ù‚ÙŠÙ… A31 Ø¥Ù„Ù‰ Ø§Ù„ØªØ±Ø§Ø¨ Ø§Ù„Ù…ØºØ±Ø¨ÙŠ Ø¬Ø§Ø¡Øª Ø¨Ø¹Ø¯ Ø±Ø­Ù„Ø© Ù‡Ø¬Ø±Ø© Ù‚Ø§Ø¯ØªÙ‡ Ø¥Ù„Ù‰ Ø§Ù„Ø®Ø§Ø±Ø¬ Ø®Ù„Ø§Ù„ Ø§Ù„Ø£Ø´Ù‡Ø± Ø§Ù„Ù…Ø§Ø¶ÙŠØ©ØŒ Ø¥Ø° Ø£Ø¸Ù‡Ø± Ù†Ø¸Ø§Ù… Ø§Ù„Ø±ØµØ¯ Ø¹Ù† Ø¨Ø¹Ø¯ GPS Ø£Ù†Ù‡ ÙˆØµÙ„ Ø¥Ù„Ù‰ Ø§Ù„Ø­Ø¯ÙˆØ¯ Ù…Ø§ Ø¨ÙŠÙ† Ù…ÙˆØ±ÙŠØªØ§Ù†ÙŠØ§ ÙˆÙ…Ø§Ù„ÙŠ Ù…Ù†Ø° Ø£ÙƒØ«Ø± Ù…Ù† 700 ÙŠÙˆÙ….\r\n\r\n\r\nØ¹ÙˆØ¯Ø© Ø¹ÙÙ‚Ø§Ø¨ ØªØ´ØºÙ„ Ø¨ÙŠØ¦ÙŠÙŠÙ† Ø¨Ø§Ù„Ø¹Ø±Ø¬Ø§Øª\r\nØ¹ÙˆØ¯Ø© Ø¹ÙÙ‚Ø§Ø¨ ØªØ´ØºÙ„ Ø¨ÙŠØ¦ÙŠÙŠÙ† Ø¨Ø§Ù„Ø¹Ø±Ø¬Ø§Øª\r\nÙˆØ°ÙƒØ±Øª Ø§Ù„Ø¬Ù…Ø¹ÙŠØ© Ø°Ø§ØªÙ‡Ø§ Ø£Ù† Ø§Ù„Ø·Ø§Ø¦Ø±ØŒ Ø§Ù„Ù…Ø¹Ø±ÙˆÙ ÙƒØ°Ù„Ùƒ Ø¨Ø§Ø³Ù… â€œØ¹ÙÙ‚Ø§Ø¨ ØµØ±Ø§Ø±Ø©â€ØŒ Ø¹Ø§Ø¯ Ø¥Ù„Ù‰ Ø§Ù„ØªØ±Ø§Ø¨ Ø§Ù„Ù…ØºØ±Ø¨ÙŠ ÙˆØªØ­Ø¯ÙŠØ¯Ø§ Ù…Ø±ÙƒØ² ØªØ£Ù‡ÙŠÙ„ Ø§Ù„Ø¬ÙˆØ§Ø±Ø­ â€œØ¨ÙŠØ± Ø§Ù„Ø£Ø­Ù…Ø±â€ØŒ Ø§Ù„ÙƒØ§Ø¦Ù† Ø¨Ù…Ù†Ø·Ù‚Ø© Ø§Ù„Ø¹Ø±Ø¬Ø§Øª Ø¨Ø¬Ù‡Ø© Ø§Ù„Ø±Ø¨Ø§Ø· Ø³Ù„Ø§ Ø§Ù„Ù‚Ù†ÙŠØ·Ø±Ø©ØŒ Ø§Ù„Ø°ÙŠ Ø¹Ù…Ù„ Ø¹Ù„Ù‰ ØªØ£Ù‡ÙŠÙ„Ù‡ Ù…Ù†Ø° ØªØ³Ù„Ù‘Ù…Ù‡ Ù…Ù† Ù…ØµØ§Ù„Ø­ Ø§Ù„Ù…ÙŠØ§Ù‡ ÙˆØ§Ù„ØºØ§Ø¨Ø§Øª ÙÙŠ Ø´ØªÙ†Ø¨Ø± 2022.\r\n\r\n\r\nØ¹ÙˆØ¯Ø© Ø¹ÙÙ‚Ø§Ø¨ ØªØ´ØºÙ„ Ø¨ÙŠØ¦ÙŠÙŠÙ† Ø¨Ø§Ù„Ø¹Ø±Ø¬Ø§Øª\r\nØ¹ÙˆØ¯Ø© Ø¹ÙÙ‚Ø§Ø¨ ØªØ´ØºÙ„ Ø¨ÙŠØ¦ÙŠÙŠÙ† Ø¨Ø§Ù„Ø¹Ø±Ø¬Ø§Øª\r\nÙƒÙ…Ø§ Ø£Ø´Ø§Ø±Øª Ø§Ù„Ù‡ÙŠØ¦Ø© Ø°Ø§ØªÙ‡Ø§ Ø¥Ù„Ù‰ Ø£Ù†Ù‡ ØªÙ… Ø¥Ø·Ù„Ø§Ù‚ Ø³Ø±Ø§Ø­ Ù‡Ø°Ø§ Ø§Ù„Ø·Ø§Ø¦Ø± Ø¨ØªØ§Ø±ÙŠØ® 16 Ø£Ø¨Ø±ÙŠÙ„ 2023ØŒ Ù‚Ø¨Ù„ Ø£Ù† ÙŠØ¨Ø¯Ø£ Ø±Ø­Ù„ØªÙ‡ Ø¥Ù„Ù‰ Ø§Ù„Ø£Ø¬ÙˆØ§Ø¡ Ø§Ù„Ù…ÙˆØ±ÙŠØªØ§Ù†ÙŠØ©ØŒ Ù„ÙŠØ¹ÙˆØ¯ Ø¥Ù„Ù‰ Ø§Ù„Ù…ØºØ±Ø¨ Ø¨Ø¹Ø¯ Ù‡Ø°Ù‡ Ø§Ù„Ù…Ø¯Ø© Ø§Ù„ØªÙŠ ØªÙ†Ù‚Ù‘Ù„ ÙÙŠÙ‡Ø§ Ø¥Ù„Ù‰ Ù…ÙˆØ·Ù†Ù‡ Ø§Ù„Ø´ØªÙˆÙŠØŒ Ù…ÙˆØ¶Ø­Ø© Ø£Ù† Ø§Ù„Ø±Ø­Ù„Ø© Ø§Ù„ØªÙŠ Ù‚Ø§Ù… Ø¨Ù‡Ø§ ÙÙŠ Ù‡Ø°Ø§ Ø§Ù„ØµØ¯Ø¯ â€œØªØ¹ØªØ¨Ø± Ø¨Ù…Ø«Ø§Ø¨Ø© Ø´Ù‡Ø§Ø¯Ø© Ø¹Ù„Ù‰ Ù‚ÙˆØªÙ‡ ÙˆØªØµÙ…ÙŠÙ…Ù‡â€.', 'Ø§Ù„Ø³ÙˆØ¯Ø§Ù†,Ø§Ù„Ø«Ø±ÙˆØ©,Ø§Ù„Ù…Ø¹Ø§Ø¯Ù†', '2025-03-27 11:12:43'),
(2, '2025032717430802045840.png', 'Ø§Ù„Ø¨Ø±Ù‡Ø§Ù† ÙŠØ¹Ù„Ù† ØªØ­Ø±ÙŠØ± Ø§Ù„Ø®Ø±Ø·ÙˆÙ… ÙˆØ§Ø³ØªØ¹Ø§Ø¯Ø© Ø§Ù„Ø³ÙŠØ·Ø±Ø© Ø¹Ù„Ù‰ Ù…Ø¹Ø§Ù‚Ù„ Ø±Ø¦ÙŠØ³ÙŠØ©', 'Ø£Ø¹Ù„Ù† Ù‚Ø§Ø¦Ø¯ Ø§Ù„Ø¬ÙŠØ´ Ø§Ù„Ø³ÙˆØ¯Ø§Ù†ÙŠ Ø§Ù„ÙØ±ÙŠÙ‚ Ø£ÙˆÙ„ Ø¹Ø¨Ø¯Ø§Ù„ÙØªØ§Ø­ Ø§Ù„Ø¨Ø±Ù‡Ø§Ù†ØŒ Ø§Ù„ÙŠÙˆÙ… Ø§Ù„Ø£Ø±Ø¨Ø¹Ø§Ø¡ØŒ Ù…Ù† Ø¯Ø§Ø®Ù„ Ø§Ù„Ù‚ØµØ± Ø§Ù„Ø¬Ù…Ù‡ÙˆØ±ÙŠ Ø£Ù† Â«Ø§Ù„Ø®Ø±Ø·ÙˆÙ… Ø­Ø±Ø©Â»ØŒ ÙˆØ°Ù„Ùƒ Ø¨Ø¹Ø¯ Ù‡Ø¨ÙˆØ· Ø·Ø§Ø¦Ø±ØªÙ‡ ÙÙŠ Ù…Ø·Ø§Ø± Ø§Ù„Ø®Ø±Ø·ÙˆÙ… Ù„Ø£ÙˆÙ„ Ù…Ø±Ø© Ù…Ù†Ø° Ø§Ù†Ø¯Ù„Ø§Ø¹ Ø§Ù„Ø­Ø±Ø¨ Ù…Ø¹ Ù‚ÙˆØ§Øª Â«Ø§Ù„Ø¯Ø¹Ù… Ø§Ù„Ø³Ø±ÙŠØ¹Â»\r\nÙ‚Ø§Ù… Ø§Ù„Ù‚Ø§Ø¦Ø¯ Ø§Ù„Ø¹Ø§Ù… Ù„Ù„Ù‚ÙˆØ§Øª Ø§Ù„Ù…Ø³Ù„Ø­Ø© Ø¨Ø¹Ù…Ù„ Ø§Ù„Ø§ØªÙŠ \r\n\r\n- ØªØ±ÙƒÙŠØ² Ø§Ù„Ø¬Ù‡ÙˆØ¯ \r\n- ØªÙˆÙÙŠØ± Ø§Ù„Ù…ÙˆØ§Ø¯', 'Ø§Ù„Ø³ÙˆØ¯Ø§Ù†,ØªØ­Ø±ÙŠØ±,Ø§Ù„Ø®Ø±Ø·ÙˆÙ…', '2025-03-27 12:56:44'),
(3, '2025041617447895529948.png', 'Ù…Ø¨Ø§Ø¯Ø±Ø© Ø¬Ø¯ÙŠØ¯Ø© Ù„ØªØ¹Ø²ÙŠØ² Ø§Ù„Ø§Ø³ØªØ«Ù…Ø§Ø± ÙÙŠ Ø§Ù„Ù‚Ø·Ø§Ø¹ Ø§Ù„Ø²Ø±Ø§Ø¹ÙŠ Ø¨Ø§Ù„Ø³ÙˆØ¯Ø§Ù†', 'Ø§Ù„Ø®Ø±Ø·ÙˆÙ… - ÙÙŠ Ø®Ø·ÙˆØ© Ù‡Ø§Ù…Ø© Ù†Ø­Ùˆ ØªØ¹Ø²ÙŠØ² Ø§Ù„Ø§Ù‚ØªØµØ§Ø¯ Ø§Ù„Ø³ÙˆØ¯Ø§Ù†ÙŠØŒ Ø£Ø¹Ù„Ù†Øª ÙˆØ²Ø§Ø±Ø© Ø§Ù„Ø²Ø±Ø§Ø¹Ø© Ø¹Ù† Ø¥Ø·Ù„Ø§Ù‚ Ù…Ø¨Ø§Ø¯Ø±Ø© Ø¬Ø¯ÙŠØ¯Ø© ØªÙ‡Ø¯Ù Ø¥Ù„Ù‰ Ø¬Ø°Ø¨ Ø§Ù„Ø§Ø³ØªØ«Ù…Ø§Ø±Ø§Øª Ø§Ù„Ù…Ø­Ù„ÙŠØ© ÙˆØ§Ù„Ø¯ÙˆÙ„ÙŠØ© ÙÙŠ Ø§Ù„Ù‚Ø·Ø§Ø¹ Ø§Ù„Ø²Ø±Ø§Ø¹ÙŠØŒ ÙÙŠ Ø¥Ø·Ø§Ø± Ø³Ø¹ÙŠ Ø§Ù„Ø­ÙƒÙˆÙ…Ø© Ù„ØªÙ†Ù…ÙŠØ© Ø§Ù„Ù‚Ø·Ø§Ø¹ ÙˆØªØ­Ù‚ÙŠÙ‚ Ø§Ù„Ø§ÙƒØªÙØ§Ø¡ Ø§Ù„Ø°Ø§ØªÙŠ Ù…Ù† Ø§Ù„Ù…Ù†ØªØ¬Ø§Øª Ø§Ù„Ø²Ø±Ø§Ø¹ÙŠØ©.\\r\\n\\r\\nØªØªÙ…Ø«Ù„ Ø§Ù„Ù…Ø¨Ø§Ø¯Ø±Ø© ÙÙŠ ØªÙˆÙÙŠØ± Ø­ÙˆØ§ÙØ² Ø¶Ø±ÙŠØ¨ÙŠØ© ÙˆØªÙ…ÙˆÙŠÙ„ Ù…ÙŠØ³Ø± Ù„Ù„Ù…Ø³ØªØ«Ù…Ø±ÙŠÙ† ÙÙŠ Ø§Ù„Ù…Ø´Ø§Ø±ÙŠØ¹ Ø§Ù„Ø²Ø±Ø§Ø¹ÙŠØ©ØŒ Ø¨Ø§Ù„Ø¥Ø¶Ø§ÙØ© Ø¥Ù„Ù‰ ØªØ­Ø³ÙŠÙ† Ø§Ù„Ø¨Ù†ÙŠØ© Ø§Ù„ØªØ­ØªÙŠØ© Ù„Ù„Ù…Ù†Ø§Ø·Ù‚ Ø§Ù„Ø²Ø±Ø§Ø¹ÙŠØ© Ø¨Ù…Ø§ ÙŠØ¶Ù…Ù† Ø§Ø³ØªØ¯Ø§Ù…Ø© Ø§Ù„Ø¥Ù†ØªØ§Ø¬ ÙˆØ²ÙŠØ§Ø¯Ø© Ø§Ù„Ø¥Ù†ØªØ§Ø¬ÙŠØ©.\\r\\n\\r\\nÙ‚Ø§Ù„ ÙˆØ²ÙŠØ± Ø§Ù„Ø²Ø±Ø§Ø¹Ø© ÙÙŠ ØªØµØ±ÙŠØ­ ØµØ­ÙÙŠ Ø¥Ù† Ù‡Ø°Ù‡ Ø§Ù„Ù…Ø¨Ø§Ø¯Ø±Ø© ØªØ³ØªÙ‡Ø¯Ù ØªØ­Ø³ÙŠÙ† Ù…Ø³ØªÙˆÙŠØ§Øª Ø§Ù„Ø£Ù…Ù† Ø§Ù„ØºØ°Ø§Ø¦ÙŠ ÙÙŠ Ø§Ù„Ø³ÙˆØ¯Ø§Ù† ÙˆØªØ¹Ø²ÙŠØ² Ù‚Ø¯Ø±Ø© Ø§Ù„Ø¨Ù„Ø§Ø¯ Ø¹Ù„Ù‰ ØªØµØ¯ÙŠØ± Ø§Ù„Ù…Ø­Ø§ØµÙŠÙ„ Ø§Ù„Ø²Ø±Ø§Ø¹ÙŠØ© Ø¥Ù„Ù‰ Ø§Ù„Ø£Ø³ÙˆØ§Ù‚ Ø§Ù„Ø¥Ù‚Ù„ÙŠÙ…ÙŠØ© ÙˆØ§Ù„Ø¯ÙˆÙ„ÙŠØ©ØŒ Ù…Ø¤ÙƒØ¯Ø§Ù‹ Ø£Ù† Ø§Ù„Ù‚Ø·Ø§Ø¹ Ø§Ù„Ø²Ø±Ø§Ø¹ÙŠ ÙŠÙ…Ø«Ù„ Ø£Ø­Ø¯ Ø£Ø¹Ù…Ø¯Ø© Ø§Ù„Ø§Ù‚ØªØµØ§Ø¯ Ø§Ù„ÙˆØ·Ù†ÙŠ ÙˆÙ„Ù‡ Ø¯ÙˆØ± ÙƒØ¨ÙŠØ± ÙÙŠ ØªÙˆÙÙŠØ± ÙØ±Øµ Ø§Ù„Ø¹Ù…Ù„.\\r\\n\\r\\nÙ…Ù† Ø§Ù„Ù…ØªÙˆÙ‚Ø¹ Ø£Ù† ØªØ³Ù‡Ù… Ù‡Ø°Ù‡ Ø§Ù„Ù…Ø¨Ø§Ø¯Ø±Ø© ÙÙŠ Ø¯Ø¹Ù… Ù…Ø²Ø§Ø±Ø¹ÙŠ Ø§Ù„Ø³ÙˆØ¯Ø§Ù† ÙˆØªØ¹Ø²ÙŠØ² Ø§Ù„Ù‚Ø¯Ø±Ø© Ø§Ù„ØªÙ†Ø§ÙØ³ÙŠØ© Ù„Ù„Ù…Ù†ØªØ¬Ø§Øª Ø§Ù„Ø²Ø±Ø§Ø¹ÙŠØ© Ø§Ù„Ø³ÙˆØ¯Ø§Ù†ÙŠØ© ÙÙŠ Ø§Ù„Ø£Ø³ÙˆØ§Ù‚ Ø§Ù„Ø¹Ø§Ù„Ù…ÙŠØ©', 'Ø³ÙˆØ¯Ø§Ù†', '2025-04-16 07:45:52'),
(4, '2025041617447926978032.png', 'Ø¹ÙˆØ¯Ø© Ø§Ù„Ø´Ø±ÙƒØ§Øª Ø§Ù„Ø§Ù”Ø¬Ù†Ø¨ÙŠØ© Ø§Ù•Ù„Ù‰ Ù‚Ø·Ø§Ø¹ Ø§Ù„ØªØ¹Ø¯ÙŠÙ† ÙÙŠ Ø§Ù„Ø³ÙˆØ¯Ø§Ù† ØªØ·ÙˆØ±Ø§Øª Ø§Ù•ÙŠØ¬Ø§Ø¨ÙŠØ©', 'Ø¹ÙˆØ¯Ø© Ø§Ù„Ø´Ø±ÙƒØ§Øª Ø§Ù„Ø§Ù”Ø¬Ù†Ø¨ÙŠØ© Ø§Ù•Ù„Ù‰ Ù‚Ø·Ø§Ø¹ Ø§Ù„ØªØ¹Ø¯ÙŠÙ† ÙÙŠ Ø§Ù„Ø³ÙˆØ¯Ø§Ù† ØªØ·ÙˆØ±Ø§Øª Ø§Ù•ÙŠØ¬Ø§Ø¨ÙŠØ© :\\r\\n\\r\\nØ´Ù‡Ø¯ Ù‚Ø·Ø§Ø¹ Ø§Ù„ØªØ¹Ø¯ÙŠÙ† ÙÙŠ Ø§Ù„Ø³ÙˆØ¯Ø§Ù† ØªØ·ÙˆØ±Ø§Øª Ø§Ù•ÙŠØ¬Ø§Ø¨ÙŠØ© Ù…Ø¹ Ø¹ÙˆØ¯Ø© Ø¹Ø¯Ø¯ Ù…Ù† Ø§Ù„Ø´Ø±ÙƒØ§Øª Ø§Ù„Ø§Ù”Ø¬Ù†Ø¨ÙŠØ© Ù„Ø§Ø³ØªÙŠÙ”Ù†Ø§Ù Ù†Ø´Ø§Ø·Ù‡Ø§ØŒ Ù…Ù…Ø§ ÙŠØ¹ÙƒØ³ ØªØ­Ø³Ù† Ø§Ù„Ø§Ù”ÙˆØ¶Ø§Ø¹ ÙˆØ§Ø³ØªÙ‚Ø±Ø§Ø± Ø§Ù„Ø¨ÙŠÙŠÙ”Ø© Ø§Ù„Ø§Ø³ØªØ«Ù…Ø§Ø±ÙŠØ© ÙÙŠ Ø§Ù„Ø¨Ù„Ø§Ø¯.\\r\\n\\r\\nØ§Ø³ØªÙŠÙ”Ù†Ø§Ù Ù†Ø´Ø§Ø· Ø§Ù„Ø´Ø±ÙƒØ§Øª Ø§Ù„ØµÙŠÙ†ÙŠØ© : Ø§Ù”Ø¹Ù„Ù† Ø§ØªØ­Ø§Ø¯ Ø´Ø±ÙƒØ§Øª Ø§Ù„ØªØ¹Ø¯ÙŠÙ† Ø§Ù„ØµÙŠÙ†ÙŠØ© ÙÙŠ Ø§Ù„Ø³ÙˆØ¯Ø§Ù† Ø¹Ù† Ø§Ø³ØªÙŠÙ”Ù†Ø§Ù Ø¬Ù…ÙŠØ¹ Ø§Ù„Ø´Ø±ÙƒØ§Øª Ø§Ù„ØµÙŠÙ†ÙŠØ© Ø§Ù„Ø¹Ø§Ù…Ù„Ø© ÙÙŠ Ù‚Ø·Ø§Ø¹ Ø§Ù„ØªØ¹Ø¯ÙŠÙ† Ù„Ù†Ø´Ø§Ø·Ù‡Ø§ Ø§Ø¹ØªØ¨Ø§Ø±Ù‹Ø§ Ù…Ù† Ù…Ø·Ù„Ø¹ Ø¹Ø§Ù… 2025. Ø¬Ø§Ø¡ Ø°Ù„Ùƒ Ø¨Ø¹Ø¯ Ù„Ù‚Ø§Ø¡ Ø¨ÙŠÙ† Ø§Ù„Ù…Ø¯ÙŠØ± Ø§Ù„Ø¹Ø§Ù… Ù„Ù„Ø´Ø±ÙƒØ© Ø§Ù„Ø³ÙˆØ¯Ø§Ù†ÙŠØ© Ù„Ù„Ù…ÙˆØ§Ø±Ø¯ Ø§Ù„Ù…Ø¹Ø¯Ù†ÙŠØ©ØŒ Ù…Ø­Ù…Ø¯ Ø·Ø§Ù‡Ø± Ø¹Ù…Ø±ØŒ ÙˆØ±ÙŠÙ”ÙŠØ³ Ø§Ù„Ø§ØªØ­Ø§Ø¯ ÙˆÙ…Ø¯ÙŠØ± Ø´Ø±ÙƒØªÙŠ \\"Ø§Ù„Ù†ÙˆØ§ØªÙŠ\\" Ùˆ\\"Ø§Ù„Ø¬Ø³Ø± Ø§Ù„Ø°Ù‡Ø¨ÙŠ\\"ØŒ ØµÙ† Ø¬Ù† Ø¨ÙˆØ§ØŒ Ø­ÙŠØ« ØªÙ… Ø§Ù„ØªØ§Ù”ÙƒÙŠØ¯ Ø¹Ù„Ù‰ ØªÙ‚Ø¯ÙŠÙ… Ø§Ù„Ø¯Ø¹Ù… Ø§Ù„ÙÙ†ÙŠ ÙˆØ§Ù„Ø§Ù•Ø¯Ø§Ø±ÙŠ Ø§Ù„Ù„Ø§Ø²Ù… Ù„Ù„Ø´Ø±ÙƒØ§Øª Ø§Ù„ØµÙŠÙ†ÙŠØ© Ù„Ø¶Ù…Ø§Ù† Ø¹ÙˆØ¯ØªÙ‡Ø§ Ø§Ù„Ø³Ø±ÙŠØ¹Ø© Ù„Ù„Ø§Ù•Ù†ØªØ§Ø¬. ÙƒÙ…Ø§ ØªÙ… Ø§Ù„ØªØ§Ù”ÙƒÙŠØ¯ Ø¹Ù„Ù‰ Ø§Ø³ØªÙ‚Ø±Ø§Ø± Ø§Ù„Ø§Ù”ÙˆØ¶Ø§Ø¹ Ø§Ù„Ø§Ù”Ù…Ù†ÙŠØ© ÙÙŠ Ù…ÙˆØ§Ù‚Ø¹ Ø§Ù„ØªØ¹Ø¯ÙŠÙ†ØŒ Ù…Ø¹ ØªÙ†Ø³ÙŠÙ‚ ÙƒØ¨ÙŠØ± Ù…Ø¹ Ø­ÙƒÙˆÙ…Ø© Ø§Ù•Ù‚Ù„ÙŠÙ… Ø§Ù„Ù†ÙŠÙ„ Ø§Ù„Ø§Ù”Ø²Ø±Ù‚ Ù„Ø§Ø³ØªÙŠÙ”Ù†Ø§Ù Ù†Ø´Ø§Ø· Ø§Ù„Ø´Ø±ÙƒØ§Øª Ø§Ù„Ø¹Ø§Ù…Ù„Ø© ÙÙŠ Ù…Ø¬Ø§Ù„ Ø§Ù„ÙƒØ±ÙˆÙ….\\r\\n\\r\\nØ¹ÙˆØ¯Ø© Ø´Ø±ÙƒØ© \\"Ù†ÙˆØ±Ù…Ø§ÙŠÙ†Ù†\\" Ø§Ù„ØµÙŠÙ†ÙŠØ© : ÙÙŠ Ø³ÙŠØ§Ù‚ Ù…ØªØµÙ„ØŒ ÙˆØ§ÙÙ‚Øª Ø´Ø±ÙƒØ© \\"Ù†ÙˆØ±Ù…Ø§ÙŠÙ†Ù†\\" Ø§Ù„ØµÙŠÙ†ÙŠØ© Ø¹Ù„Ù‰ Ø§Ø³ØªÙŠÙ”Ù†Ø§Ù Ù†Ø´Ø§Ø·Ù‡Ø§ Ø§Ù„ØªØ¹Ø¯ÙŠÙ†ÙŠ ÙÙŠ Ø§Ù„Ø³ÙˆØ¯Ø§Ù† Ø¨Ø¹Ø¯ ØªÙˆÙ‚ÙÙ‡Ø§ Ø¨Ø³Ø¨Ø¨ Ø§Ù„Ø­Ø±Ø¨. ØªÙ…Øª Ù…Ù†Ø§Ù‚Ø´Ø© ØªØ±ØªÙŠØ¨Ø§Øª Ø§Ù„Ø¹ÙˆØ¯Ø© Ø®Ù„Ø§Ù„ Ø²ÙŠØ§Ø±Ø© Ø§Ù„Ù…Ø¯ÙŠØ± Ø§Ù„Ø¹Ø§Ù… Ù„Ù„Ø´Ø±ÙƒØ© Ø§Ù„Ø³ÙˆØ¯Ø§Ù†ÙŠØ© Ù„Ù„Ù…ÙˆØ§Ø±Ø¯ Ø§Ù„Ù…Ø¹Ø¯Ù†ÙŠØ© Ø§Ù•Ù„Ù‰ Ø¨ÙƒÙŠÙ†ØŒ Ø­ÙŠØ« Ø§Ù”ÙƒØ¯ Ø§Ù”Ù† Ø¬Ù…ÙŠØ¹ Ù…Ù†Ø§Ø·Ù‚ Ø§Ù„ØªØ¹Ø¯ÙŠÙ† Ø§Ù“Ù…Ù†Ø© ÙˆÙ„Ø§ ØªÙˆØ¬Ø¯ Ù…Ù‡Ø¯Ø¯Ø§Øª ØªØ­ÙˆÙ„ Ø¯ÙˆÙ† Ø§Ù„Ø¹Ù…Ù„. Ù…Ù† Ø§Ù„Ù…ØªÙˆÙ‚Ø¹ Ø§Ù”Ù† ØªØ³Ù‡Ù… Ø§Ù„Ø´Ø±ÙƒØ© ÙÙŠ Ø§Ù•Ù†ØªØ§Ø¬ Ø³Ø¨Ø¹Ø© Ø§Ù”Ø·Ù†Ø§Ù† Ù…Ù† Ø§Ù„Ø°Ù‡Ø¨ Ø³Ù†ÙˆÙŠÙ‹Ø§ØŒ Ù…Ø¹ Ø§Ù…ØªÙ„Ø§ÙƒÙ‡Ø§ Ù„Ø§Ù”Ø±Ø¨Ø¹Ø© Ù…ÙˆØ§Ù‚Ø¹ ÙÙŠ ÙˆÙ„Ø§ÙŠØªÙŠ Ø§Ù„Ø¨Ø­Ø± Ø§Ù„Ø§Ù”Ø­Ù…Ø± ÙˆÙ†Ù‡Ø± Ø§Ù„Ù†ÙŠÙ„.\\r\\n\\r\\nØ¬Ù‡ÙˆØ¯ Ø­ÙƒÙˆÙ…ÙŠØ© Ù„Ø¬Ø°Ø¨ Ø§Ù„Ø§Ø³ØªØ«Ù…Ø§Ø±Ø§Øª: Ø§Ù”ÙƒØ¯ ÙˆØ²ÙŠØ± Ø§Ù„Ù…Ø§Ù„ÙŠØ© ÙˆØ§Ù„ØªØ®Ø·ÙŠØ· Ø§Ù„Ø§Ù‚ØªØµØ§Ø¯ÙŠØŒ Ø§Ù„Ø¯ÙƒØªÙˆØ± Ø¬Ø¨Ø±ÙŠÙ„ Ø§Ù•Ø¨Ø±Ø§Ù‡ÙŠÙ…ØŒ ÙÙŠ Ù…ÙˆÙ”ØªÙ…Ø± ØµØ­ÙÙŠ Ø¨Ø¨ÙˆØ±ØªØ³ÙˆØ¯Ø§Ù†ØŒ Ø¹ÙˆØ¯Ø© Ø´Ø±ÙƒØ§Øª Ø§Ù„ØªØ¹Ø¯ÙŠÙ† Ø§Ù„Ø§Ù”Ø¬Ù†Ø¨ÙŠØ© Ø§Ù„ØªÙŠ ØºØ§Ø¯Ø±Øª Ø§Ù„Ø³ÙˆØ¯Ø§Ù† Ø¨Ø³Ø¨Ø¨ Ø§Ù„Ø­Ø±Ø¨ Ø§Ù•Ù„Ù‰ Ù…Ù…Ø§Ø±Ø³Ø© Ø§Ù”Ù†Ø´Ø·ØªÙ‡Ø§. ÙˆØ§Ù”Ø´Ø§Ø± Ø§Ù•Ù„Ù‰ Ø­Ø±Øµ Ø§Ù„Ø­ÙƒÙˆÙ…Ø© Ø¹Ù„Ù‰ Ø§Ù•Ø¬Ø±Ø§Ø¡ Ù…Ø³Ø­ Ø¬ÙŠÙˆÙ„ÙˆØ¬ÙŠ Ø­Ø¯ÙŠØ« Ø¨Ø§Ù„ØªØ¹Ø§ÙˆÙ† Ù…Ø¹ Ø§Ù”Ù„Ù…Ø§Ù†ÙŠØ§ Ù„Ù…Ø¹Ø±ÙØ© Ù…Ø®Ø²ÙˆÙ† Ø§Ù„Ù…Ø¹Ø§Ø¯Ù† Ø¨Ø§Ù„Ø¨Ù„Ø§Ø¯ØŒ Ø¨Ù…Ø§ ÙÙŠ Ø°Ù„Ùƒ Ø§Ù„ÙŠÙˆØ±Ø§Ù†ÙŠÙˆÙ…ØŒ Ø¨Ù‡Ø¯Ù ØªÙ…ÙƒÙŠÙ† Ø§Ù„Ø³ÙˆØ¯Ø§Ù† Ù…Ù† Ø§Ù„Ø­ØµÙˆÙ„ Ø¹Ù„Ù‰ Ù‚Ø±ÙˆØ¶ Ø¨Ù†Ø§Ø¡Ù‹ Ø¹Ù„Ù‰ Ù‡Ø°Ù‡ Ø§Ù„Ù…ÙˆØ§Ø±Ø¯.\\r\\n\\r\\nØªÙØ¨Ø±Ø² Ù‡Ø°Ù‡ Ø§Ù„ØªØ·ÙˆØ±Ø§Øª Ø§Ù„ØªØ²Ø§Ù… Ø§Ù„Ø³ÙˆØ¯Ø§Ù† Ø¨ØªØ¹Ø²ÙŠØ² Ù‚Ø·Ø§Ø¹ Ø§Ù„ØªØ¹Ø¯ÙŠÙ† Ù…Ù† Ø®Ù„Ø§Ù„ ØªÙˆÙÙŠØ± Ø¨ÙŠÙŠÙ”Ø© Ø§Ù“Ù…Ù†Ø© ÙˆØ¬Ø§Ø°Ø¨Ø© Ù„Ù„Ø§Ø³ØªØ«Ù…Ø§Ø±Ø§Øª Ø§Ù„Ø§Ù”Ø¬Ù†Ø¨ÙŠØ©ØŒ Ù…Ù…Ø§ ÙŠØ³Ù‡Ù… ÙÙŠ Ø¯ÙØ¹ Ø¹Ø¬Ù„Ø© Ø§Ù„Ø§Ù‚ØªØµØ§Ø¯ Ø§Ù„ÙˆØ·Ù†ÙŠ ÙˆØªØ­Ù‚ÙŠÙ‚ Ø§Ù„ØªÙ†Ù…ÙŠØ© Ø§Ù„Ù…Ø³ØªØ¯Ø§Ù…Ø©.', 'Ø§Ù„Ø´Ø±ÙƒØ§Øª', '2025-04-16 08:38:17'),
(5, '2025052817484362397810.jpg', 'Ù…Ø¨Ø§Ø­Ø«Ø§Øª Ù…Ø¹ Ø´Ø±ÙƒØ§Øª Ù…ØµØ±ÙŠØ© ÙˆØªØ±ÙƒÙŠØ© Ù„Ø¥Ø¹Ø§Ø¯Ø© ØªØ£Ù‡ÙŠÙ„ Ø§Ù„ÙƒØ¨Ø§Ø±ÙŠ ÙÙŠ Ø§Ù„Ø®Ø±Ø·ÙˆÙ…', 'ÙˆÙÙŠ Ù‡Ø°Ø§ Ø§Ù„Ø³ÙŠØ§Ù‚ØŒ Ø£ÙˆØ¶Ø­ Ø§Ù„Ù…Ù‡Ù†Ø¯Ø³ Ù…Ø®ØªØ§Ø± Ø¹Ù…Ø± ØµØ§Ø¨Ø±ØŒ Ù…Ø¯ÙŠØ± Ø¹Ø§Ù… Ù‡ÙŠØ¦Ø© Ø§Ù„Ø·Ø±Ù‚ ÙˆØ§Ù„Ø¬Ø³ÙˆØ± ÙˆÙ…ØµØ§Ø±Ù Ø§Ù„Ù…ÙŠØ§Ù‡ Ø¨Ø§Ù„ÙˆÙ„Ø§ÙŠØ©ØŒ Ø£Ù† Ø§Ù„Ù‡ÙŠØ¦Ø©ØŒ Ø¨Ø§Ù„ØªØ¹Ø§ÙˆÙ† Ù…Ø¹ Ø§Ù„Ù„Ø¬Ù†Ø© Ø§Ù„Ø¹Ù„ÙŠØ§ Ø§Ù„Ù…Ø¹Ù†ÙŠØ© Ø¨Ø¯Ø±Ø§Ø³Ø© Ø£ÙˆØ¶Ø§Ø¹ Ø§Ù„ÙƒØ¨Ø§Ø±ÙŠØŒ Ù‚Ø¯ Ù‚Ø¯Ù…Øª Ù…Ø¬Ù…ÙˆØ¹Ø© Ù…Ù† Ø§Ù„Ø§Ù‚ØªØ±Ø§Ø­Ø§Øª Ø§Ø³ØªÙ†Ø§Ø¯Ø§Ù‹ Ø¥Ù„Ù‰ Ø§Ù„ØªÙ‚Ø±ÙŠØ± Ø§Ù„Ù†Ù‡Ø§Ø¦ÙŠ Ø§Ù„Ø°ÙŠ Ø£Ø¹Ø¯ØªÙ‡ Ø§Ù„Ù„Ø¬Ù†Ø© Ø§Ù„ÙÙ†ÙŠØ©. ÙˆØ£Ø´Ø§Ø± Ø¥Ù„Ù‰ Ø£Ù† Ø§Ù„Ù‡ÙŠØ¦Ø© Ø§Ù„Ù‚ÙˆÙ…ÙŠØ© Ù„Ù„Ø·Ø±Ù‚ ÙˆØ§Ù„Ø¬Ø³ÙˆØ± ØªØ¹Ù…Ù„ Ø­Ø§Ù„ÙŠØ§Ù‹ Ø¹Ù„Ù‰ Ø¥Ø¹Ø§Ø¯Ø© Ø¨Ù†Ø§Ø¡ ÙƒØ¨Ø±ÙŠ Ø¯ÙŠØ±ÙŠ ÙÙŠ Ù…Ù†Ø·Ù‚Ø© Ø§Ù„Ø¬ÙŠÙ„ÙŠ ÙˆÙƒØ¨Ø±ÙŠ Ø§Ù„ÙƒÙ†Ø¬Ø± ÙÙŠ Ù…Ù†Ø·Ù‚Ø© Ø§Ù„Ø³Ù‚Ø§ÙŠ Ø´Ù…Ø§Ù„ Ø¨Ø­Ø±ÙŠØŒ Ù…Ù…Ø§ ÙŠØ¹ÙƒØ³ Ø§Ù„ØªØ²Ø§Ù… Ø§Ù„Ù‡ÙŠØ¦Ø© Ø¨ØªØ­Ø³ÙŠÙ† Ø´Ø¨ÙƒØ© Ø§Ù„Ù†Ù‚Ù„ ÙÙŠ Ø§Ù„ÙˆÙ„Ø§ÙŠØ©.\\r\\n\\r\\nÙƒÙ…Ø§ Ø£Ø¶Ø§Ù Ø§Ù„Ù…Ù‡Ù†Ø¯Ø³ Ù…Ø®ØªØ§Ø± Ø£Ù† Ø§Ù„Ù„Ø¬Ù†Ø© Ø§Ù„Ø¹Ù„ÙŠØ§ ØªØ¬Ø±ÙŠ Ù…Ø´Ø§ÙˆØ±Ø§Øª Ù…Ø¹ Ø´Ø±ÙƒØ© â€œÙŠØ§Ø¨ÙŠâ€ØŒ Ø§Ù„Ù…Ù‚Ø§ÙˆÙ„ Ø§Ù„Ø³Ø§Ø¨Ù‚ Ù„ÙƒØ¨Ø±ÙŠ Ø§Ù„Ø­Ù„ÙØ§ÙŠØ§ØŒ Ù…Ù† Ø£Ø¬Ù„ ØªÙ†ÙÙŠØ° Ø£Ø¹Ù…Ø§Ù„ Ø§Ù„ØµÙŠØ§Ù†Ø© Ø§Ù„Ù„Ø§Ø²Ù…Ø© Ù„Ù‡Ø°Ø§ Ø§Ù„ÙƒØ¨Ø±ÙŠ. ÙˆØ£ÙƒØ¯ ÙˆØ¬ÙˆØ¯ Ø§ØªØµØ§Ù„Ø§Øª Ù…Ø³ØªÙ…Ø±Ø© Ù…Ø¹ Ø§Ù„Ø¬Ø§Ù†Ø¨ Ø§Ù„Ù…ØµØ±ÙŠ Ù„Ù„Ù…Ø³Ø§Ù‡Ù…Ø© ÙÙŠ Ø£Ø¹Ù…Ø§Ù„ ØµÙŠØ§Ù†Ø© ÙƒØ¨Ø±ÙŠ Ø´Ù…Ø¨Ø§ØªØŒ Ù…Ø´ÙŠØ±Ø§Ù‹ Ø¥Ù„Ù‰ Ø£Ù† Ø¨Ù‚ÙŠØ© Ø£Ø¹Ù…Ø§Ù„ Ø§Ù„ØµÙŠØ§Ù†Ø© Ø§Ù„Ù…ØªØ¹Ù„Ù‚Ø© Ø¨Ø§Ù„ÙƒØ¨Ø§Ø±ÙŠ ÙˆØ§Ù„Ø¬Ø³ÙˆØ± Ø³ØªÙØ·Ø±Ø­ Ù„Ù…Ù‚Ø§ÙˆÙ„ÙŠÙ† Ù…Ø­Ù„ÙŠÙŠÙ† Ù…Ù† Ø®Ù„Ø§Ù„ Ù…Ù†Ø§ÙØ³Ø© Ù…Ø¨Ø§Ø´Ø±Ø©ØŒ Ù…Ù…Ø§ ÙŠØ¹Ø²Ø² Ù…Ù† Ø¯ÙˆØ± Ø§Ù„Ø´Ø±ÙƒØ§Øª Ø§Ù„Ù…Ø­Ù„ÙŠØ© ÙÙŠ Ø¥Ø¹Ø§Ø¯Ø© ØªØ£Ù‡ÙŠÙ„ Ø§Ù„Ø¨Ù†ÙŠØ© Ø§Ù„ØªØ­ØªÙŠØ©.', 'Ø³ÙˆØ¯Ø§Ù†,Ø´Ø±ÙƒØ§Øª,Ø§ØªØµØ§Ù„Ø§Øª', '2025-05-28 12:43:59'),
(6, '2025052817484363246045.jpg', 'Ù…Ø¨Ø§Ø­Ø«Ø§Øª Ù…Ø¹ Ø´Ø±ÙƒØ§Øª Ù…ØµØ±ÙŠØ© ÙˆØªØ±ÙƒÙŠØ© Ù„Ø¥Ø¹Ø§Ø¯Ø© ØªØ£Ù‡ÙŠÙ„ Ø§Ù„ÙƒØ¨Ø§Ø±ÙŠ ÙÙŠ Ø§Ù„Ø®Ø±Ø·ÙˆÙ…', 'ÙˆÙÙŠ Ù‡Ø°Ø§ Ø§Ù„Ø³ÙŠØ§Ù‚ØŒ Ø£ÙˆØ¶Ø­ Ø§Ù„Ù…Ù‡Ù†Ø¯Ø³ Ù…Ø®ØªØ§Ø± Ø¹Ù…Ø± ØµØ§Ø¨Ø±ØŒ Ù…Ø¯ÙŠØ± Ø¹Ø§Ù… Ù‡ÙŠØ¦Ø© Ø§Ù„Ø·Ø±Ù‚ ÙˆØ§Ù„Ø¬Ø³ÙˆØ± ÙˆÙ…ØµØ§Ø±Ù Ø§Ù„Ù…ÙŠØ§Ù‡ Ø¨Ø§Ù„ÙˆÙ„Ø§ÙŠØ©ØŒ Ø£Ù† Ø§Ù„Ù‡ÙŠØ¦Ø©ØŒ Ø¨Ø§Ù„ØªØ¹Ø§ÙˆÙ† Ù…Ø¹ Ø§Ù„Ù„Ø¬Ù†Ø© Ø§Ù„Ø¹Ù„ÙŠØ§ Ø§Ù„Ù…Ø¹Ù†ÙŠØ© Ø¨Ø¯Ø±Ø§Ø³Ø© Ø£ÙˆØ¶Ø§Ø¹ Ø§Ù„ÙƒØ¨Ø§Ø±ÙŠØŒ Ù‚Ø¯ Ù‚Ø¯Ù…Øª Ù…Ø¬Ù…ÙˆØ¹Ø© Ù…Ù† Ø§Ù„Ø§Ù‚ØªØ±Ø§Ø­Ø§Øª Ø§Ø³ØªÙ†Ø§Ø¯Ø§Ù‹ Ø¥Ù„Ù‰ Ø§Ù„ØªÙ‚Ø±ÙŠØ± Ø§Ù„Ù†Ù‡Ø§Ø¦ÙŠ Ø§Ù„Ø°ÙŠ Ø£Ø¹Ø¯ØªÙ‡ Ø§Ù„Ù„Ø¬Ù†Ø© Ø§Ù„ÙÙ†ÙŠØ©. ÙˆØ£Ø´Ø§Ø± Ø¥Ù„Ù‰ Ø£Ù† Ø§Ù„Ù‡ÙŠØ¦Ø© Ø§Ù„Ù‚ÙˆÙ…ÙŠØ© Ù„Ù„Ø·Ø±Ù‚ ÙˆØ§Ù„Ø¬Ø³ÙˆØ± ØªØ¹Ù…Ù„ Ø­Ø§Ù„ÙŠØ§Ù‹ Ø¹Ù„Ù‰ Ø¥Ø¹Ø§Ø¯Ø© Ø¨Ù†Ø§Ø¡ ÙƒØ¨Ø±ÙŠ Ø¯ÙŠØ±ÙŠ ÙÙŠ Ù…Ù†Ø·Ù‚Ø© Ø§Ù„Ø¬ÙŠÙ„ÙŠ ÙˆÙƒØ¨Ø±ÙŠ Ø§Ù„ÙƒÙ†Ø¬Ø± ÙÙŠ Ù…Ù†Ø·Ù‚Ø© Ø§Ù„Ø³Ù‚Ø§ÙŠ Ø´Ù…Ø§Ù„ Ø¨Ø­Ø±ÙŠØŒ Ù…Ù…Ø§ ÙŠØ¹ÙƒØ³ Ø§Ù„ØªØ²Ø§Ù… Ø§Ù„Ù‡ÙŠØ¦Ø© Ø¨ØªØ­Ø³ÙŠÙ† Ø´Ø¨ÙƒØ© Ø§Ù„Ù†Ù‚Ù„ ÙÙŠ Ø§Ù„ÙˆÙ„Ø§ÙŠØ©.\r\n\r\nÙƒÙ…Ø§ Ø£Ø¶Ø§Ù Ø§Ù„Ù…Ù‡Ù†Ø¯Ø³ Ù…Ø®ØªØ§Ø± Ø£Ù† Ø§Ù„Ù„Ø¬Ù†Ø© Ø§Ù„Ø¹Ù„ÙŠØ§ ØªØ¬Ø±ÙŠ Ù…Ø´Ø§ÙˆØ±Ø§Øª Ù…Ø¹ Ø´Ø±ÙƒØ© â€œÙŠØ§Ø¨ÙŠâ€ØŒ Ø§Ù„Ù…Ù‚Ø§ÙˆÙ„ Ø§Ù„Ø³Ø§Ø¨Ù‚ Ù„ÙƒØ¨Ø±ÙŠ Ø§Ù„Ø­Ù„ÙØ§ÙŠØ§ØŒ Ù…Ù† Ø£Ø¬Ù„ ØªÙ†ÙÙŠØ° Ø£Ø¹Ù…Ø§Ù„ Ø§Ù„ØµÙŠØ§Ù†Ø© Ø§Ù„Ù„Ø§Ø²Ù…Ø© Ù„Ù‡Ø°Ø§ Ø§Ù„ÙƒØ¨Ø±ÙŠ. ÙˆØ£ÙƒØ¯ ÙˆØ¬ÙˆØ¯ Ø§ØªØµØ§Ù„Ø§Øª Ù…Ø³ØªÙ…Ø±Ø© Ù…Ø¹ Ø§Ù„Ø¬Ø§Ù†Ø¨ Ø§Ù„Ù…ØµØ±ÙŠ Ù„Ù„Ù…Ø³Ø§Ù‡Ù…Ø© ÙÙŠ Ø£Ø¹Ù…Ø§Ù„ ØµÙŠØ§Ù†Ø© ÙƒØ¨Ø±ÙŠ Ø´Ù…Ø¨Ø§ØªØŒ Ù…Ø´ÙŠØ±Ø§Ù‹ Ø¥Ù„Ù‰ Ø£Ù† Ø¨Ù‚ÙŠØ© Ø£Ø¹Ù…Ø§Ù„ Ø§Ù„ØµÙŠØ§Ù†Ø© Ø§Ù„Ù…ØªØ¹Ù„Ù‚Ø© Ø¨Ø§Ù„ÙƒØ¨Ø§Ø±ÙŠ ÙˆØ§Ù„Ø¬Ø³ÙˆØ± Ø³ØªÙØ·Ø±Ø­ Ù„Ù…Ù‚Ø§ÙˆÙ„ÙŠÙ† Ù…Ø­Ù„ÙŠÙŠÙ† Ù…Ù† Ø®Ù„Ø§Ù„ Ù…Ù†Ø§ÙØ³Ø© Ù…Ø¨Ø§Ø´Ø±Ø©ØŒ Ù…Ù…Ø§ ÙŠØ¹Ø²Ø² Ù…Ù† Ø¯ÙˆØ± Ø§Ù„Ø´Ø±ÙƒØ§Øª Ø§Ù„Ù…Ø­Ù„ÙŠØ© ÙÙŠ Ø¥Ø¹Ø§Ø¯Ø© ØªØ£Ù‡ÙŠÙ„ Ø§Ù„Ø¨Ù†ÙŠØ© Ø§Ù„ØªØ­ØªÙŠØ©.', '', '2025-05-28 12:45:24');

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

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` int(11) NOT NULL,
  `customer_code` varchar(50) DEFAULT NULL,
  `owner_name` varchar(255) NOT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `first_contract_date` date DEFAULT NULL,
  `notes` text,
  `owner_type` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`id`, `customer_code`, `owner_name`, `contact_no`, `first_contract_date`, `notes`, `owner_type`, `status`) VALUES
(1, 'EXC23', 'Equipation', '6567570', '2025-08-01', 'Ù…Ù…ØªØ§Ø² ', 'Ø´Ø±ÙƒØ©', 1),
(2, '0', 'Ù…Ø­Ù…Ø¯ Ø³ÙŠØ¯ ', '6567570', '2025-08-01', 'Ù…Ø­Ù…Ø¯ Ø³ÙŠØ¯ Ù„Ø§ÙŠ Ø²ÙˆÙ„', 'ÙØ±Ø¯', 1),
(3, '206', 'Ø¹Ø¨Ø¯ Ø§Ù„Ø±Ø­ÙŠÙ…', '0115667710', '2025-08-01', 'Ø¹Ø¨Ø¯ Ø§Ù„Ø±Ø­ÙŠÙ… Ø§Ù„ÙØ§Ø¯Ù†ÙŠ', 'ÙˆÙƒÙŠÙ„', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_location` varchar(255) DEFAULT NULL,
  `contract_type` varchar(100) DEFAULT NULL,
  `contract_duration` varchar(100) DEFAULT NULL,
  `target_hours` varchar(10) DEFAULT NULL,
  `target_tons` varchar(10) DEFAULT NULL,
  `target_meters` varchar(10) DEFAULT NULL,
  `target_floors` varchar(10) DEFAULT NULL,
  `notes` text,
  `status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `project_location`, `contract_type`, `contract_duration`, `target_hours`, `target_tons`, `target_meters`, `target_floors`, `notes`, `status`, `created_at`) VALUES
(1, 'Ù…Ø´Ø±ÙˆØ¹ Ø§Ù„Ø±ÙˆØ³ÙŠØ©', 'Ø§Ù…Ø¯Ø±Ù…Ø§Ù†', 'RentalØ§', '10 Ø³Ù†Ø©', '100', '100', '100', '100', 'Ù…Ù„Ø§Ø­Ø¸Ø§Øª', 1, '2025-08-28 17:48:39');

-- --------------------------------------------------------

--
-- Table structure for table `tipper`
--

CREATE TABLE `tipper` (
  `id` int(11) NOT NULL,
  `cost_code` varchar(11) NOT NULL,
  `entry_name` varchar(50) NOT NULL,
  `machine_name` varchar(100) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `driver_name` varchar(100) NOT NULL,
  `shift` varchar(50) NOT NULL,
  `shift_hours` int(11) DEFAULT NULL,
  `counter_start` varchar(20) DEFAULT NULL,
  `executed_hours` int(11) DEFAULT NULL,
  `extra_hours_total` int(11) DEFAULT NULL,
  `standby_hours` int(11) DEFAULT NULL,
  `dependence_hours` varchar(20) NOT NULL,
  `total_work_hours` int(11) DEFAULT NULL,
  `work_notes` text,
  `hr_fault` varchar(100) DEFAULT NULL,
  `maintenance_fault` varchar(100) DEFAULT NULL,
  `marketing_fault` varchar(100) DEFAULT NULL,
  `approval_fault` varchar(100) DEFAULT NULL,
  `other_fault_hours` int(11) DEFAULT NULL,
  `total_fault_hours` varchar(20) NOT NULL,
  `fault_notes` text,
  `counter_end` varchar(20) DEFAULT NULL,
  `counter_diff` varchar(20) DEFAULT NULL,
  `number_of_moves` varchar(20) NOT NULL,
  `fault_type` varchar(100) DEFAULT NULL,
  `fault_department` varchar(100) DEFAULT NULL,
  `fault_part` varchar(100) DEFAULT NULL,
  `fault_details` text,
  `general_notes` text,
  `operator_hours` varchar(100) DEFAULT NULL,
  `extra_operator_hours` varchar(20) NOT NULL,
  `machine_standby_hours` varchar(100) DEFAULT NULL,
  `operator_standby_hours` varchar(100) DEFAULT NULL,
  `operator_notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipper`
--

INSERT INTO `tipper` (`id`, `cost_code`, `entry_name`, `machine_name`, `project_name`, `owner_name`, `driver_name`, `shift`, `shift_hours`, `counter_start`, `executed_hours`, `extra_hours_total`, `standby_hours`, `dependence_hours`, `total_work_hours`, `work_notes`, `hr_fault`, `maintenance_fault`, `marketing_fault`, `approval_fault`, `other_fault_hours`, `total_fault_hours`, `fault_notes`, `counter_end`, `counter_diff`, `number_of_moves`, `fault_type`, `fault_department`, `fault_part`, `fault_details`, `general_notes`, `operator_hours`, `extra_operator_hours`, `machine_standby_hours`, `operator_standby_hours`, `operator_notes`, `created_at`) VALUES
(1, '3', 'medo', 'Mitsobitchy', 'Ù…Ø´Ø±ÙˆØ¹ Ø§Ù„Ø±ÙˆØ³ÙŠØ©', 'Ø¹Ø¨Ø¯ Ø§Ù„Ø±Ø­ÙŠÙ…', 'Ù…Ø­Ù…Ø¯ Ø³ÙŠØ¯', 'D', 10, '0:00:00', 0, 0, 0, '0', 0, '', '0', '0', '0', '0', 0, '0', '', '0:00:00', '0', '0', '', '', '', '', '', '', '', '0', '0', '', '2025-08-31 14:11:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Ø§Ù„Ø§Ø¯Ø§Ø±Ø© Ø§Ù„Ø¹Ù„ÙŠØ§', 'admin', '2025', '0', 'admin', '2025-08-23 11:40:53', '2025-08-23 11:45:53'),
(2, 'Ù…Ø­Ù…Ø¯ Ø³ÙŠØ¯', 'medo', 'medo', '0928293983', 'user', '2025-08-23 11:46:26', '2025-08-23 11:54:22'),
(3, 'Ø¹Ù…Ø± Ù…Ø­Ù…Ø¯ ', 'omer', 'omer', '01123475758', 'user', '2025-08-28 18:40:44', '2025-08-28 18:40:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipment_code` (`equipment_code`);

--
-- Indexes for table `equipment_types`
--
ALTER TABLE `equipment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `excavator`
--
ALTER TABLE `excavator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master`
--
ALTER TABLE `master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipper`
--
ALTER TABLE `tipper`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `equipment_types`
--
ALTER TABLE `equipment_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `excavator`
--
ALTER TABLE `excavator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `master`
--
ALTER TABLE `master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `operations`
--
ALTER TABLE `operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tipper`
--
ALTER TABLE `tipper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
