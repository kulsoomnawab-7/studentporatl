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
-- Table structure for table `software_complains`
--

DROP TABLE IF EXISTS `software_complains`;
CREATE TABLE IF NOT EXISTS `software_complains` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `software_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_hardware_issue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `software_complains`
--

INSERT INTO `software_complains` (`id`, `software_name`, `other_hardware_issue`, `created_at`, `updated_at`) VALUES
(1, 'xyz\r\n', NULL, NULL, NULL),
(2, 'zzzz', NULL, NULL, NULL),
(3, 'gg', NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
