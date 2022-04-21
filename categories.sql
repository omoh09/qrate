-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2020 at 04:10 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qrate-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`, `color`) VALUES
(1, 'Acrylic Painting', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#BC0272'),
(2, 'Animation', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#6372C1'),
(3, 'Calligraphy', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#F7931E'),
(4, 'Ceramics', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#277839'),
(5, 'Charcoal Drawing', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#955BAS'),
(6, 'Clay Scuplture', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#F44336'),
(7, 'Comics', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#FF005C'),
(8, 'Conte Drawing', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#229B1F'),
(9, 'Digital Art', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#8000FF'),
(10, 'Digital Collage', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#DB8C16'),
(11, 'Digital Painting', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#E06426'),
(12, 'Graffiti Art', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#8BC605'),
(13, 'Handmade', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#05D8E5'),
(14, 'Illustrations', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#805333'),
(15, 'Lino Cut', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#607D8B'),
(16, 'Mixed Media', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#FF18BE'),
(17, 'Oil Painting', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#6372C1'),
(18, 'Pastel Drawing', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#3E3E3E'),
(19, 'Performance Art', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#4FACFE'),
(20, 'Photography', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#3645C7'),
(21, 'Portraiture', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#111111'),
(22, 'Print Making', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#7B7B7B'),
(23, 'Recycle Art', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#87CED9'),
(24, 'Sculpture', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#2E384D'),
(25, 'Textile', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#FFBC00'),
(26, 'Videography', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#A33A3A'),
(27, 'Watercolor painting', NULL, '2020-10-16 12:48:18', '2020-10-16 12:48:18', '#A3983A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
