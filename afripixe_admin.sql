-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2024 at 08:53 PM
-- Server version: 10.6.19-MariaDB-cll-lve
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `afripixe_admin`
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
(0, 14, 'Field \'phone_number\' changed', 1, 'phone_number', '0114144451', '0114144453', '2024-09-02 19:45:12'),
(0, 14, 'Field \'follow_ups\' changed', 1, 'follow_ups', '7', '7', '2024-09-02 19:45:12'),
(0, 14, 'Field \'company_name\' changed', 1, 'company_name', 'summit mobile Limited', 'summit mobile', '2024-09-02 10:45:00'),
(0, 14, 'Field \'follow_ups\' changed', 1, 'follow_ups', '7', '7', '2024-09-02 10:45:00'),
(0, 10, 'Field \'follow_ups\' changed', 1, 'follow_ups', '7', '7', '2024-09-02 11:19:26'),
(0, 14, 'Field \'contract_sign_date\' changed', 0, 'contract_sign_date', '-0001-11-30 00:00:00', '2024-09-03 16:18:00', '2024-09-02 13:16:50'),
(0, 14, 'Field \'contract_value\' changed', 0, 'contract_value', '0.00', '39998', '2024-09-02 13:16:50'),
(0, 14, 'Field \'follow_ups\' changed', 0, 'follow_ups', '1', '1', '2024-09-02 13:16:50'),
(0, 14, 'Field \'follow_ups\' changed', 1, 'follow_ups', '7', '7', '2024-09-02 15:26:53'),
(0, 10, 'Field \'follow_ups\' changed', 0, 'follow_ups', '1', '4', '2024-09-02 18:01:28');

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
(1, 'summit mobile', '0114144453', 'felixmukhandia@gmail.com', 'facebook', 'Lead', 'Manager', 'wordpress', 'Computer and laptops', 2030.00, '2024-08-30 16:30:00', 'webdevelopment', 'social media', 20399.00, '2024-08-29 20:30:00', 23999.00, '2024-08-23 03:31:00', 3400.00, '2024-08-17 23:28:00', '2024-09-05 20:31:00', 'Client', 7, '2024-08-31 20:28:35'),
(2, 'Fortress Electronics Limited', '0114149451', 'felixmukhandia@gmail.com', 'facebook', 'Lead', 'CEO', 'wordpress', 'electronics', 4.00, '2024-08-01 23:33:00', 'webdevelopment', 'social media', 3.00, '2024-08-24 23:33:00', 4.00, '2024-09-13 17:09:00', 8.00, '2024-08-17 23:33:00', '2024-08-16 23:33:00', 'Client', 4, '2024-08-31 20:34:04'),
(0, 'Ken computers', '0114149543', 'felixmukhandia@gmail.com', 'Facebook', 'Felix', 'Manager', 'Woocomerce', 'Electronics', 23000.00, '2024-09-01 16:16:00', 'web development, digital marketing', 'social media', 24000.00, '2024-09-01 19:19:00', 245000.00, '2024-09-03 16:18:00', 39998.00, '2024-09-01 16:17:00', '2024-09-04 21:00:00', 'Client', 4, '2024-09-02 13:15:59');

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
(10, 'Wasike', 'felixmukhandia@gmail.com', '$2y$10$Im073Rw9unqaxTXv4Afxh.nvVgPvswvGsd.4sP4NEdWLXmgsYlAO6', 'admin', '2024-08-30'),
(13, 'Carson', 'carson@gmail.com', '$2y$10$3EuICx84U7MNLTpqL15GF.U7Ng/F8kq5g2lxpPdCYY99LUZeKF0.C', 'admin', '2024-09-02'),
(14, 'Admin', 'admin@gmail.com', '$2y$10$licINzAYU57K1lpgtonU7eEiEv.ErQdxasWgcaqMh7x1dASw1HnpS', 'superadmin', '2024-09-02');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
