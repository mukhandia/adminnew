-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2024 at 05:19 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `action_logs`
--

CREATE TABLE `action_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `record_id` int(11) NOT NULL,
  `field_changed` varchar(100) DEFAULT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `action_logs`
--

INSERT INTO `action_logs` (`id`, `user_id`, `action`, `record_id`, `field_changed`, `old_value`, `new_value`, `action_date`) VALUES
(2, 10, 'Record with ID 1 updated by user 10.', 0, NULL, NULL, NULL, '2024-09-01 14:05:18'),
(3, 10, 'Record with ID 1 updated by user 10.', 0, NULL, NULL, NULL, '2024-09-01 14:09:20'),
(4, 10, 'Record with ID 2 updated by user 10.', 0, NULL, NULL, NULL, '2024-09-01 14:09:53'),
(5, 10, 'Record with ID 2 updated by user 10.', 0, NULL, NULL, NULL, '2024-09-01 14:16:13'),
(6, 10, 'Record with ID 1 updated by user 10.', 0, NULL, NULL, NULL, '2024-09-01 14:29:31'),
(7, 10, 'Record with ID 1 updated by user 10. Changes: phon', 0, NULL, NULL, NULL, '2024-09-01 14:32:40'),
(8, 10, 'Record with ID 1 updated by user 10. Changes: comp', 0, NULL, NULL, NULL, '2024-09-01 15:17:07'),
(9, 10, 'Record with ID 1 updated by user 10. Changes: comp', 0, NULL, NULL, NULL, '2024-09-01 15:17:55'),
(10, 10, 'Record with ID 2 updated by user 10. Changes: firs', 0, NULL, NULL, NULL, '2024-09-01 15:18:52');

-- --------------------------------------------------------

--
-- Table structure for table `business_records`
--

CREATE TABLE `business_records` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `lead_source` varchar(255) NOT NULL,
  `decision_maker_name` varchar(255) NOT NULL,
  `decision_maker_position` varchar(255) NOT NULL,
  `ecommerce_platform` varchar(255) NOT NULL,
  `main_product_category` varchar(255) NOT NULL,
  `monthly_revenue` decimal(15,2) NOT NULL,
  `first_contact_date` datetime NOT NULL,
  `services_interested_in` varchar(255) NOT NULL,
  `current_marketing_channels` varchar(255) NOT NULL,
  `estimated_budget` decimal(15,2) NOT NULL,
  `proposal_sent_date` datetime NOT NULL,
  `proposal_value` decimal(15,2) NOT NULL,
  `contract_sign_date` datetime DEFAULT NULL,
  `contract_value` decimal(15,2) DEFAULT NULL,
  `last_contact_date` datetime DEFAULT NULL,
  `next_scheduled_action` datetime NOT NULL,
  `current_status` enum('Lead','Client','Lost') NOT NULL,
  `follow_ups` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_records`
--

INSERT INTO `business_records` (`id`, `company_name`, `phone_number`, `email_address`, `lead_source`, `decision_maker_name`, `decision_maker_position`, `ecommerce_platform`, `main_product_category`, `monthly_revenue`, `first_contact_date`, `services_interested_in`, `current_marketing_channels`, `estimated_budget`, `proposal_sent_date`, `proposal_value`, `contract_sign_date`, `contract_value`, `last_contact_date`, `next_scheduled_action`, `current_status`, `follow_ups`, `created_at`) VALUES
(1, 'summit mobile', '0114144451', 'felixmukhandia@gmail.com', 'facebook', 'Lead', 'CEO', 'wordpress', 'electronics', 2030.00, '2024-08-30 16:30:00', 'webdevelopment', 'social media', 2030.00, '2024-08-29 20:30:00', 2390.00, '2024-08-23 03:31:00', 3400.00, '2024-08-17 23:28:00', '2024-09-05 20:31:00', 'Client', 2, '2024-08-31 20:28:35'),
(2, 'Fortress Electronics', '0114149451', 'felixmukhandia@gmail.com', 'facebook', 'Lead', 'CEO', 'wordpress', 'electronics', 4.00, '2024-08-01 23:33:00', 'webdevelopment', 'social media', 3.00, '2024-08-24 23:33:00', 4.00, '2024-09-13 17:09:00', 8.00, '2024-08-17 23:33:00', '2024-08-16 23:33:00', 'Client', 2, '2024-08-31 20:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `registered_time` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`id`, `name`, `email`, `password`, `role`, `registered_time`) VALUES
(10, 'fasike', 'felixmukhandia@gmail.com', '$2y$10$gec77f8FHtB.9skWVoWHCeL00QSUHa0x4d2WPQrqbbk59MP/jThGO', 'admin', '2024-08-30'),
(11, 'Felix', 'felixmukhandwia@gmail.com', '$2y$10$9HZ.Y7cprL5ZNndXb3sM/egwloC6mZpNm1cqZxu5umgh45Y5cOSPG', 'superadmin', '2024-08-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action_logs`
--
ALTER TABLE `action_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `business_records`
--
ALTER TABLE `business_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action_logs`
--
ALTER TABLE `action_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `business_records`
--
ALTER TABLE `business_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `action_logs`
--
ALTER TABLE `action_logs`
  ADD CONSTRAINT `action_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
