-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 23, 2023 at 05:45 AM
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
-- Table structure for table `complain__masters`
--

DROP TABLE IF EXISTS `complain__masters`;
CREATE TABLE IF NOT EXISTS `complain__masters` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Complain_Category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Complain_Description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Date_of_Complain` date DEFAULT NULL,
  `Regiystered_By` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Lab_id` int(11) DEFAULT NULL,
  `Pc_ip` int(11) DEFAULT NULL,
  `role_type` int(11) DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `complain__masters_lab_id_foreign` (`Lab_id`),
  KEY `complain__masters_pc_ip_foreign` (`Pc_ip`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complain__masters`
--

INSERT INTO `complain__masters` (`id`, `Complain_Category`, `Complain_Description`, `Date_of_Complain`, `Regiystered_By`, `Lab_id`, `Pc_ip`, `role_type`, `Status`, `created_at`, `updated_at`) VALUES
(1, '1', 'lcd', '2023-02-22', 'm.anas7861101@gmail.com', 1, 326, 1, 2, '2023-02-22 14:21:55', '2023-02-22 15:18:08'),
(3, '2', 'in', '2023-02-23', 'anus2109d@aptechgdn.net', 3, NULL, 2, 0, '2023-02-22 23:04:37', '2023-02-22 23:04:37'),
(4, '2', 'in', '2023-02-23', 'anus2109d@aptechgdn.net', 6, NULL, 3, 1, '2023-02-22 23:07:48', '2023-02-22 23:18:59'),
(5, '1', 'lcd', '2023-02-23', 'm.anas7861101@gmail.com', 1, 326, 1, 2, '2023-02-22 23:21:28', '2023-02-22 23:22:20'),
(6, '1', 'hello', '2023-02-23', 'm.anas7861101@gmail.com', 1, 330, 4, 0, '2023-02-23 00:18:45', '2023-02-23 00:18:45'),
(7, '1', 'chair issue', '2023-02-23', 'm.anas7861101@gmail.com', 1, 331, 4, 0, '2023-02-23 00:39:38', '2023-02-23 00:39:38');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
