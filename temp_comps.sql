-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 23, 2023 at 05:46 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anusdb_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `temp_comps`
--

DROP TABLE IF EXISTS `temp_comps`;
CREATE TABLE IF NOT EXISTS `temp_comps` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Host_Name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hardware_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_hardware_issue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `software_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_software_issue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_Network_issue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Network_issue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_issue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_complain` date DEFAULT NULL,
  `Lab_id` int(11) DEFAULT NULL,
  `Pc_ip` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `temp_comps_pc_ip_foreign` (`Pc_ip`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_comps`
--

INSERT INTO `temp_comps` (`id`, `Host_Name`, `email`, `hardware_name`, `other_hardware_issue`, `software_name`, `other_software_issue`, `other_Network_issue`, `Network_issue`, `other_issue`, `status`, `date_of_complain`, `Lab_id`, `Pc_ip`, `created_at`, `updated_at`) VALUES
(15, NULL, 'muhammadanasz786@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-22 13:57:18', '2023-02-22 13:57:18'),
(20, NULL, 'anus2109d@aptechgdn.net', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-22 23:00:36', '2023-02-22 23:00:36'),
(23, NULL, 'm.anas7861101@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-23 00:39:43', '2023-02-23 00:39:43');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
