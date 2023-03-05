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
-- Table structure for table `labs`
--

DROP TABLE IF EXISTS `labs`;
CREATE TABLE IF NOT EXISTS `labs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `No_of_pcs` int(11) NOT NULL,
  `lab_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Utilization_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`id`, `No_of_pcs`, `lab_number`, `Utilization_status`, `created_at`, `updated_at`) VALUES
(1, 18, 'lab 1', 18, NULL, NULL),
(2, 18, 'lab 2', 18, NULL, NULL),
(3, 18, 'lab 3', 18, NULL, NULL),
(4, 18, 'lab 4', 18, NULL, NULL),
(6, 18, 'lab 6', 15, NULL, NULL),
(9, 18, 'lab 7', 18, NULL, NULL),
(10, 12, 'lab 8', 12, NULL, NULL),
(11, 18, 'lab 9', 14, NULL, NULL),
(14, 18, 'seminar', 14, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
