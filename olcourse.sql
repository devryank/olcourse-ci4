-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2020 at 11:05 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `olcourse`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) UNSIGNED NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `detail` text NOT NULL,
  `duration` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `slug`, `img`, `price`, `detail`, `duration`, `created_at`, `updated_at`) VALUES
(2001, 'Belajar Golang', 'belajar-golang', '1591084725_1b4de2f54c8b7dcedf0f.jpg', 80000, '<p>tutorial golang</p>\r\n', 30, '2020-06-02 07:58:45', '2020-07-13 14:12:07'),
(2002, 'Belajar HTML Dasar', 'belajar-html-dasar', '1591084774_aeee35ddc4af758b6c80.png', 50000, '<p>tutorial html</p>\r\n', 20, '2020-06-02 07:59:34', '2020-07-19 01:43:43'),
(2003, 'Belajar CSS Dasar', 'belajar-css-dasar', '1591084789_3c35c6bc05782aa91fc7.png', 70000, '<p>tutorial css</p>\r\n', 30, '2020-06-02 07:59:49', '2020-07-13 14:12:28'),
(2004, 'Belajar Java Fundamental', 'belajar-java-fundamental', '1591085226_c86ea4801e6caa527cf4.png', 85000, '<p>tutorial java fundamental</p>\r\n', 30, '2020-06-02 08:07:06', '2020-07-13 14:12:29'),
(2005, 'Belajar Kotlin ', 'belajar-kotlin', '1591085257_7ab20206027d6ed1a9ee.jpg', 100000, '<p>tutorial kotlin</p>\r\n', 30, '2020-06-02 08:07:37', '2020-07-13 14:12:29'),
(2006, 'Paket 1 Kelas 1', 'paket-1-kelas-1', '1595075998_6a4b829dbe95c35dadfe.png', 120000, '<p>paket 1 kelas 1</p>\r\n', 30, '2020-07-18 12:39:58', '2020-07-19 06:53:20'),
(2007, 'Paket 1 Kelas 2', 'paket-1-kelas-2', '1595076146_e9f5778cd17fb4936756.png', 75000, '<p>paket 1 kelas 2</p>\r\n', 20, '2020-07-18 12:42:26', '2020-07-18 12:42:26'),
(2008, 'Paket 1 Kelas 3', 'paket-1-kelas-3', '1595076451_8c5b75382d0d59653c24.png', 150000, '<p>paket 1 kelas 3</p>\r\n', 30, '2020-07-18 12:47:31', '2020-07-19 06:53:23');

-- --------------------------------------------------------

--
-- Table structure for table `class_packages`
--

CREATE TABLE `class_packages` (
  `class_package_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_packages`
--

INSERT INTO `class_packages` (`class_package_id`, `package_id`, `class_id`, `created_at`, `updated_at`) VALUES
(1, 1001, 2002, '2020-07-18 04:02:07', '2020-07-18 04:02:07'),
(2, 1001, 2003, '2020-07-18 04:02:07', '2020-07-18 04:02:07'),
(3, 1002, 2004, '2020-07-18 04:02:51', '2020-07-18 04:02:51'),
(4, 1002, 2005, '2020-07-18 04:02:51', '2020-07-18 04:02:51'),
(5, 1003, 2006, '2020-07-18 12:46:42', '2020-07-19 06:54:13'),
(6, 1003, 2007, '2020-07-18 12:46:42', '2020-07-18 12:46:42'),
(8, 1003, 2008, '2020-07-18 12:56:47', '2020-07-19 06:54:16');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discount_id` int(11) UNSIGNED NOT NULL,
  `promo_code` varchar(15) DEFAULT NULL,
  `discount` int(11) NOT NULL,
  `from` datetime NOT NULL,
  `to` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`discount_id`, `promo_code`, `discount`, `from`, `to`, `created_at`, `updated_at`) VALUES
(1, 'TEST', 10, '2020-06-02 15:58:00', '2020-06-07 23:59:00', '2020-06-02 08:59:30', '2020-06-02 08:59:30'),
(2, 'FGFGFG', 5, '2020-06-01 00:00:00', '2020-06-01 16:00:00', '2020-06-02 12:26:00', '2020-06-02 12:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `membership_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `duration` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) UNSIGNED NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `detail` text NOT NULL,
  `duration` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `package_name`, `slug`, `img`, `price`, `detail`, `duration`, `created_at`, `updated_at`) VALUES
(1001, 'Pemrograman Web Dasar', 'pemrograman-web-dasar', '1591084988_8ec0438d04d85323e583.jpg', 120000, '<p>tutorial html css</p>\r\n', 60, '2020-06-02 08:03:08', '2020-07-13 14:12:50'),
(1002, 'Menjadi Android Developer', 'menjadi-android-developer', '1591085295_c457eb7d3fbd47c01b0d.png', 165000, '<p>tutorial pemrograman android</p>\r\n', 60, '2020-06-02 08:08:15', '2020-07-19 01:30:56'),
(1003, 'Paket 1', 'paket-1', '1595076402_9b360b1e54859f54c707.png', 250000, '<p>paket 1</p>\r\n', 60, '2020-07-18 12:46:42', '2020-07-18 12:47:48');

-- --------------------------------------------------------

--
-- Table structure for table `passes`
--

CREATE TABLE `passes` (
  `pass_id` int(10) UNSIGNED NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `topic_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `passes`
--

INSERT INTO `passes` (`pass_id`, `class_id`, `topic_id`, `user_id`, `created_at`) VALUES
(2, 2006, 4, 2, '2020-07-19 06:28:32');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) UNSIGNED NOT NULL,
  `class_id` int(11) UNSIGNED NOT NULL,
  `number` smallint(6) DEFAULT NULL,
  `topic_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `class_id`, `number`, `topic_name`, `slug`, `content`, `created_at`, `updated_at`) VALUES
(1, 2002, 1, 'Pengenalan', 'pengenalan', '<p><img alt=\"\" src=\"/assets/vendor/kcfinder/upload/files/1591084774_aeee35ddc4af758b6c80.png\" style=\"height:340px; width:600px\" /></p>\r\n\r\n<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Mollitia sint deserunt, ipsa culpa ratione minima cupiditate provident quis impedit facilis ut harum aliquid, nihil dicta beatae sapiente eos soluta aspernatur. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Mollitia sint deserunt, ipsa culpa ratione minima cupiditate provident quis impedit facilis ut harum aliquid, nihil dicta beatae sapiente eos soluta aspernatur. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Mollitia sint deserunt, ipsa culpa ratione minima cupiditate provident quis impedit facilis ut harum aliquid, nihil dicta beatae sapiente eos soluta aspernatur.</p>\r\n', '2020-06-20 02:33:35', '2020-07-19 02:15:46'),
(2, 2002, 3, 'Tag Dasar', 'tag-dasar', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Mollitia sint deserunt, ipsa culpa ratione minima cupiditate provident quis impedit facilis ut harum aliquid, nihil dicta beatae sapiente eos soluta aspernatur.\r\nLorem ipsum dolor, sit amet consectetur adipisicing elit. Mollitia sint deserunt, ipsa culpa ratione minima cupiditate provident quis impedit facilis ut harum aliquid, nihil dicta beatae sapiente eos soluta aspernatur.\r\n', '2020-06-20 02:33:35', '2020-07-19 02:15:46'),
(3, 2003, 1, 'Pengenalan CSS', 'pengenalan-css', '<p>pengenalan css</p>\r\n', '2020-07-17 13:09:47', '2020-07-17 13:09:47'),
(4, 2006, 1, 'Topik 1 Paket 1 Kelas 1', 'topik-1-paket-1-kelas-1', '<p>topik 1</p>\r\n', '2020-07-18 13:10:28', '2020-07-18 13:14:51'),
(5, 2007, 1, 'Topik 1 Paket 1 Kelas 2', 'topik-1-paket-1-kelas-2', '<p>topik 1</p>\r\n', '2020-07-18 13:11:54', '2020-07-18 13:11:54'),
(6, 2008, 1, 'Topik 1 Paket 1 Kelas 3', 'topik-1-paket-1-kelas-3', '<p>topik 1</p>\r\n', '2020-07-18 13:15:16', '2020-07-18 13:15:16'),
(7, 2004, 1, 'Pengenalan', 'pengenalan', '<p>Pengenalan</p>\r\n', '2020-07-18 13:15:33', '2020-07-18 13:15:33'),
(8, 2001, 1, 'Pengenalan', 'pengenalan', '<p>Pengenalan</p>\r\n', '2020-07-18 13:15:44', '2020-07-18 13:15:44'),
(9, 2005, 1, 'Pengenalan', 'pengenalan', '<p>pengenalan kotlin</p>\r\n', '2020-07-19 07:01:28', '2020-07-19 07:01:28');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` varchar(12) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `id` int(11) NOT NULL,
  `option` enum('package','class') NOT NULL DEFAULT 'package',
  `discount_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `waiting_confirmation` enum('0','1') NOT NULL,
  `is_paid` enum('0','1') NOT NULL DEFAULT '0',
  `payment_date` datetime DEFAULT NULL,
  `token` varchar(6) DEFAULT NULL,
  `is_token_activated` enum('0','1') DEFAULT '0',
  `token_activated_date` datetime DEFAULT NULL,
  `course_end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `id`, `option`, `discount_id`, `amount`, `order_date`, `waiting_confirmation`, `is_paid`, `payment_date`, `token`, `is_token_activated`, `token_activated_date`, `course_end_date`) VALUES
('012006020001', 2, 1001, 'package', 1, 108161, '2020-06-02 08:06:56', '0', '1', '2020-07-14 00:00:00', 'WPRJI', '1', '2020-07-14 08:43:17', '2020-09-12 08:43:17'),
('012007020002', 3, 1002, 'package', 1, 108161, '2020-07-02 08:06:56', '1', '0', '2020-07-14 08:42:47', 'WPRJA', '0', NULL, NULL),
('012007190003', 2, 1003, 'package', NULL, 250176, '2020-07-19 12:37:51', '0', '1', '2020-07-19 01:17:12', 'NSVJG', '1', '2020-07-19 01:18:38', '2020-09-17 01:18:38'),
('022006030001', 2, 2004, 'class', NULL, 85000, '2020-06-03 00:00:00', '0', '1', '2020-07-10 00:00:00', 'ABVDG', '0', NULL, NULL),
('022007030002', 3, 2004, 'class', NULL, 85000, '2020-07-03 00:00:00', '0', '1', '2020-07-03 00:00:00', 'WPRJG', '1', '2020-07-18 03:43:50', '2020-08-17 03:43:50'),
('022007120004', 3, 2001, 'class', NULL, 80196, '2020-07-18 07:55:14', '0', '1', '2020-07-18 10:55:14', 'WPRJS', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('user','admin') NOT NULL DEFAULT 'user',
  `is_active` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `email`, `password`, `level`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Admin Ryan', 'adminryan', 'ryanolcourse@gmail.com', '$2y$10$uRJEJtG4zwJDdvQOSahwkO3cr.uL6eWpAFP1b3osnqOwqUd96jUty', 'admin', '1', '2020-06-02 07:47:13', '2020-07-19 08:59:34'),
(2, 'User Ryan', 'ryan', 'ryansg41@gmail.com', '$2y$10$XKwYUNaLFie9ja4eKcpdvuPWcZLbJgKSLWXH.Tmxp3Nv1O7581aWO', 'user', '1', '2020-06-02 08:09:38', '2020-07-19 08:59:39'),
(3, 'Ihsan', 'ihsan', 'ihsan@gmail.com', '$2y$10$XKwYUNaLFie9ja4eKcpdvuPWcZLbJgKSLWXH.Tmxp3Nv1O7581aWO', 'user', '1', '2020-07-18 08:37:52', '2020-07-18 08:37:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `class_packages`
--
ALTER TABLE `class_packages`
  ADD PRIMARY KEY (`class_package_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discount_id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`membership_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `passes`
--
ALTER TABLE `passes`
  ADD PRIMARY KEY (`pass_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_packages`
--
ALTER TABLE `class_packages`
  MODIFY `class_package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `passes`
--
ALTER TABLE `passes`
  MODIFY `pass_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
