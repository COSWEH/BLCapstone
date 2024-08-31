-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2024 at 06:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bayanlink`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faqs`
--

CREATE TABLE `tbl_faqs` (
  `faq_id` int(22) NOT NULL,
  `faq_question` text NOT NULL,
  `faq_answer` text NOT NULL,
  `faq_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_faqs`
--

INSERT INTO `tbl_faqs` (`faq_id`, `faq_question`, `faq_answer`, `faq_created_at`) VALUES
(1, 'Who will verify users that will be allowed with certain features within the app?', 'The verification of users for accessing certain features within the app will be managed by the system administrators. They will review user requests and validate their eligibility based on predefined criteria. This ensures that only authorized users gain access to specialized features.', '2024-08-26 09:59:09'),
(2, 'Who will check and accept the requests made for information gathering?', 'Requests for information gathering will be reviewed and accepted by designated information officers or administrators. They will assess the validity and relevance of each request before granting access to the requested information.', '2024-08-26 10:01:09'),
(3, 'Who will limit access to certain information?', 'Access to certain sensitive or restricted information will be managed by system administrators and security officers. They will configure access controls based on user roles, permissions, and security policies to ensure that only authorized individuals can view or manipulate sensitive data.', '2024-08-26 10:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `log_id` int(22) NOT NULL,
  `log_desc` varchar(255) NOT NULL,
  `log_date` datetime NOT NULL,
  `user_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_logs`
--

INSERT INTO `tbl_logs` (`log_id`, `log_desc`, `log_date`, `user_id`) VALUES
(1, 'User asd requested a Barangay Clearance', '2024-08-29 21:16:58', 1),
(2, 'User asd requested a Cedula', '2024-08-29 21:42:59', 1),
(3, 'User asd requested a Job Seeker', '2024-08-29 21:47:07', 1),
(4, 'User qwerty123 proccessed a document', '2024-08-29 21:49:13', 2),
(5, 'User qwerty123 proccessed a document', '2024-08-29 21:49:18', 2),
(6, 'User qwerty123 proccessed a document', '2024-08-29 21:49:21', 2),
(7, 'User qwerty123 proccessed a document', '2024-08-29 21:49:26', 2),
(8, 'User qwerty123 proccessed a document', '2024-08-29 21:49:32', 2),
(9, 'User qwerty123 proccessed a document', '2024-08-29 21:49:37', 2),
(10, 'User qwerty123 proccessed a document', '2024-08-29 21:49:40', 2),
(11, 'User qwerty123 approved a document', '2024-08-29 21:52:05', 2),
(12, 'User qwerty123 proccessed a document', '2024-08-29 21:56:43', 2),
(13, 'User qwerty123 cancelled a document', '2024-08-30 13:18:50', 2),
(14, 'User asd requested a Barangay Clearance', '2024-08-30 13:21:23', 1),
(15, 'User qwerty123 proccessed a document', '2024-08-30 13:21:48', 2),
(16, 'User asd requested a Cedula', '2024-08-30 13:23:30', 1),
(17, 'User qwerty123 proccessed a document', '2024-08-30 13:23:43', 2),
(18, 'User qwerty123 approved a document', '2024-08-30 13:47:37', 2),
(19, 'User qwerty123 approved a document', '2024-08-30 13:47:48', 2),
(20, 'User qwerty123 proccessed a document', '2024-08-30 13:58:51', 2),
(21, 'User qwerty123 approved a document', '2024-08-30 14:42:35', 2),
(22, 'User asd requested a Job Seeker', '2024-08-30 14:45:51', 1),
(23, 'User asd requested a Job Seeker', '2024-08-30 14:54:53', 1),
(24, 'User qwerty123 cancelled a document', '2024-08-30 14:57:40', 2),
(25, 'User pao updated his/her information', '2024-08-30 18:11:19', 2),
(26, 'User pao updated his/her information', '2024-08-30 18:11:37', 2),
(27, 'User pao updated his/her information', '2024-08-30 18:15:59', 2),
(28, 'User pao updated his/her information', '2024-08-30 18:16:11', 2),
(29, 'User pao changed his/her password', '2024-08-30 18:18:45', 2),
(30, 'User Qwerty123 created a post', '2024-08-30 20:14:21', 1),
(31, 'User Qwerty123 added another admin account', '2024-08-30 21:07:05', 1),
(32, 'User pao updated his/her information', '2024-08-31 10:09:34', 2),
(33, 'User pao requested a Business Permit', '2024-08-31 11:51:52', 2),
(34, 'User Qwerty123 proccessed a document', '2024-08-31 12:47:44', 1),
(35, 'User Qwerty123 proccessed a document', '2024-08-31 13:45:00', 1),
(36, 'User Qwerty123 proccessed a document', '2024-08-31 14:21:42', 1),
(37, 'User Qwerty123 proccessed a document', '2024-08-31 14:26:26', 1),
(38, 'User Qwerty123 proccessed a document', '2024-08-31 14:30:47', 1),
(39, 'User Qwerty123 approved a document', '2024-08-31 14:31:03', 1),
(40, 'User Qwerty123 proccessed a document', '2024-08-31 14:50:36', 1),
(41, 'User Qwerty123 cancelled a document', '2024-08-31 14:50:53', 1),
(42, 'User Qwerty123 approved a document', '2024-08-31 14:51:10', 1),
(43, 'User Qwerty123 cancelled a document', '2024-08-31 14:52:20', 1),
(44, 'User Qwerty123 cancelled a document', '2024-08-31 14:52:28', 1),
(45, 'User Qwerty123 cancelled a document', '2024-08-31 14:52:54', 1),
(46, 'User Qwerty123 proccessed a document', '2024-08-31 14:53:23', 1),
(47, 'User Qwerty123 proccessed a document', '2024-08-31 14:53:28', 1),
(48, 'User Qwerty123 approved a document', '2024-08-31 14:56:28', 1),
(49, 'User Qwerty123 cancelled a document', '2024-08-31 14:56:37', 1),
(50, 'User Qwerty123 approved a document', '2024-08-31 14:56:47', 1),
(51, 'User Qwerty123 cancelled a document', '2024-08-31 14:56:58', 1),
(52, 'User Qwerty123 cancelled a document', '2024-08-31 14:57:07', 1),
(53, 'User Qwerty123 proccessed a document', '2024-08-31 14:57:18', 1),
(54, 'User Qwerty123 approved a document', '2024-08-31 14:57:27', 1),
(55, 'User Qwerty123 cancelled a document', '2024-08-31 14:57:35', 1),
(56, 'User Qwerty123 proccessed a document', '2024-08-31 15:34:25', 1),
(57, 'User Qwerty123 cancelled a document', '2024-08-31 15:34:40', 1),
(58, 'User Qwerty123 approved a document', '2024-08-31 15:36:17', 1),
(59, 'User Qwerty123 proccessed a document', '2024-08-31 15:36:39', 1),
(60, 'User Qwerty123 approved a document', '2024-08-31 15:36:52', 1),
(61, 'User Qwerty123 proccessed a document', '2024-08-31 15:37:16', 1),
(62, 'User Qwerty123 cancelled a document', '2024-08-31 15:37:29', 1),
(63, 'User Qwerty123 proccessed a document', '2024-08-31 15:37:51', 1),
(64, 'User Qwerty123 approved a document', '2024-08-31 15:38:09', 1),
(65, 'User Qwerty123 proccessed a document', '2024-08-31 15:39:03', 1),
(66, 'User tiktalk requested a Barangay Clearance', '2024-08-31 15:58:50', 4),
(67, 'User Qwerty123 proccessed a document', '2024-08-31 15:59:13', 1),
(68, 'User Qwerty123 approved a document', '2024-08-31 16:00:25', 1),
(69, 'User Qwerty123 cancelled a document', '2024-08-31 16:01:14', 1),
(70, 'User admin123 added another super admin account', '2024-08-31 17:43:54', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `notify_id` int(22) NOT NULL,
  `user_id` int(22) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(55) DEFAULT NULL,
  `notify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`notify_id`, `user_id`, `description`, `status`, `notify_date`) VALUES
(1, 2, 'Processed', 'read', '2024-08-31 13:45:00'),
(2, 2, 'Processed', 'read', '2024-08-31 14:21:42'),
(3, 1, 'Processed', 'unread', '2024-08-31 14:26:26'),
(4, 1, 'Processed', 'unread', '2024-08-31 14:30:47'),
(5, 1, 'Approved', 'unread', '2024-08-31 14:31:03'),
(6, 1, 'Processed', 'unread', '2024-08-31 14:50:36'),
(7, 1, 'Cancelled', 'unread', '2024-08-31 14:50:53'),
(8, 2, 'Approved', 'read', '2024-08-31 14:51:10'),
(9, 2, 'Cancelled', 'read', '2024-08-31 14:52:20'),
(10, 1, 'Cancelled', 'unread', '2024-08-31 14:52:28'),
(11, 2, 'Cancelled', 'read', '2024-08-31 14:52:54'),
(12, 1, 'Processed', 'unread', '2024-08-31 14:53:23'),
(13, 1, 'Processed', 'unread', '2024-08-31 14:53:28'),
(14, 1, 'Approved', 'unread', '2024-08-31 14:56:28'),
(15, 1, 'Cancelled', 'unread', '2024-08-31 14:56:37'),
(16, 1, 'Approved', 'unread', '2024-08-31 14:56:47'),
(17, 1, 'Cancelled', 'unread', '2024-08-31 14:56:58'),
(18, 1, 'Cancelled', 'unread', '2024-08-31 14:57:07'),
(19, 1, 'Processed', 'unread', '2024-08-31 14:57:18'),
(20, 1, 'Approved', 'unread', '2024-08-31 14:57:27'),
(21, 1, 'Cancelled', 'unread', '2024-08-31 14:57:35'),
(22, 1, 'Processed', 'unread', '2024-08-31 15:34:25'),
(23, 1, 'Cancelled', 'unread', '2024-08-31 15:34:40'),
(24, 2, 'Approved', 'read', '2024-08-31 15:36:17'),
(25, 2, 'Processed', 'read', '2024-08-31 15:36:39'),
(26, 2, 'Approved', 'read', '2024-08-31 15:36:52'),
(27, 1, 'Processed', 'unread', '2024-08-31 15:37:16'),
(28, 1, 'Cancelled', 'unread', '2024-08-31 15:37:29'),
(29, 2, 'Processed', 'read', '2024-08-31 15:37:51'),
(30, 2, 'Approved', 'read', '2024-08-31 15:38:09'),
(31, 1, 'Processed', 'unread', '2024-08-31 15:39:03'),
(32, 4, 'Processed', 'read', '2024-08-31 15:59:13'),
(33, 4, 'Approved', 'read', '2024-08-31 16:00:25'),
(34, 4, 'Cancelled', 'read', '2024-08-31 16:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_posts`
--

CREATE TABLE `tbl_posts` (
  `post_id` int(22) NOT NULL,
  `user_id` int(22) NOT NULL,
  `post_brgy` varchar(55) NOT NULL,
  `post_content` text NOT NULL,
  `post_img` text NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_posts`
--

INSERT INTO `tbl_posts` (`post_id`, `user_id`, `post_brgy`, `post_content`, `post_img`, `post_date`) VALUES
(1, 1, 'Malapit', 'asdsasd', '[]', '2024-08-30 20:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_requests`
--

CREATE TABLE `tbl_requests` (
  `req_id` int(22) NOT NULL,
  `user_id` int(22) NOT NULL,
  `req_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `req_fname` varchar(55) NOT NULL,
  `req_mname` varchar(55) NOT NULL,
  `req_lname` varchar(55) NOT NULL,
  `req_contactNo` varchar(55) NOT NULL,
  `req_gender` varchar(55) NOT NULL,
  `req_brgy` varchar(55) NOT NULL,
  `req_purok` varchar(55) NOT NULL,
  `req_age` int(55) NOT NULL,
  `req_dateOfBirth` date NOT NULL,
  `req_placeOfBirth` varchar(55) NOT NULL,
  `req_civilStatus` varchar(55) NOT NULL,
  `req_eSignature` text NOT NULL,
  `req_typeOfDoc` varchar(75) NOT NULL,
  `req_valid_id` text NOT NULL,
  `req_status` varchar(25) NOT NULL,
  `req_reasons` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_requests`
--

INSERT INTO `tbl_requests` (`req_id`, `user_id`, `req_date`, `req_fname`, `req_mname`, `req_lname`, `req_contactNo`, `req_gender`, `req_brgy`, `req_purok`, `req_age`, `req_dateOfBirth`, `req_placeOfBirth`, `req_civilStatus`, `req_eSignature`, `req_typeOfDoc`, `req_valid_id`, `req_status`, `req_reasons`) VALUES
(1, 1, '2024-08-31 14:57:07', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isidro', 'Single', 'ss-[BayanLink-66d156d3b0d8f].png', 'Barangay Clearance', 'id-[BayanLink-66d156d3b0d94].png', 'Cancelled', ''),
(2, 1, '2024-08-31 15:39:03', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isdro', 'Single', 'ss-[BayanLink-66d157520d4ae].png', 'Cedula', 'id-[BayanLink-66d157520d4b4].png', 'Processing', ''),
(3, 1, '2024-08-31 15:37:29', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isidro', 'Single', 'ss-[BayanLink-66d16a9f2c42e].png', 'Job Seeker', 'id-[BayanLink-66d16a9f2c431].png', 'Cancelled', 'User account issue, Document no longer applicable, '),
(4, 1, '2024-08-31 15:36:07', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isidro', 'Single', 'ss-[BayanLink-66d16cbddfa49].png', 'Job Seeker', 'id-[BayanLink-66d16cbddfa4c].png', 'Pending', ''),
(5, 2, '2024-08-31 15:38:09', 'Pao', 'Pao', 'Pao', '09876543212', 'Male', 'Malapit', '3', 34, '1990-04-28', 'San Isidro, Nueva Ecija', 'Single', 'ss-[BayanLink-66d2935843f06].png', 'Business Permit', 'id-[BayanLink-66d2935843f09].png', 'Approved', ''),
(6, 4, '2024-08-31 16:01:14', 'Tiktalk', 'Tiktalk', 'Tiktalk', '09876543212', 'Male', 'Malapit', '2', 16, '2007-12-31', 'San Isidro, Nueva Ecija', 'Single', 'ss-[BayanLink-66d2cd3a9d187].png', 'Barangay Clearance', 'id-[BayanLink-66d2cd3a9d18a].png', 'Cancelled', 'Invalid or expired information, Insufficient supporting documents, User account issue, Document no longer applicable, ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_useracc`
--

CREATE TABLE `tbl_useracc` (
  `user_id` int(11) NOT NULL,
  `fromSanIsidro` varchar(5) NOT NULL,
  `user_brgy` varchar(55) NOT NULL,
  `user_fname` varchar(55) NOT NULL,
  `user_mname` varchar(55) NOT NULL,
  `user_lname` varchar(55) NOT NULL,
  `user_gender` varchar(55) NOT NULL,
  `user_contactNum` varchar(55) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `user_age` int(22) NOT NULL,
  `placeOfBirth` varchar(55) NOT NULL,
  `civilStatus` varchar(55) NOT NULL,
  `user_city` varchar(55) NOT NULL,
  `user_purok` varchar(55) NOT NULL,
  `user_email` varchar(55) NOT NULL,
  `username` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(55) NOT NULL,
  `user_create_at` datetime DEFAULT current_timestamp(),
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_useracc`
--

INSERT INTO `tbl_useracc` (`user_id`, `fromSanIsidro`, `user_brgy`, `user_fname`, `user_mname`, `user_lname`, `user_gender`, `user_contactNum`, `dateOfBirth`, `user_age`, `placeOfBirth`, `civilStatus`, `user_city`, `user_purok`, `user_email`, `username`, `password`, `role_id`, `user_create_at`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'Yes', 'Malapit', 'Paolo', 'Marvel', 'Ramos', 'Male', '09876543212', '2002-04-29', 22, 'San Isidro, Nueva Ecija', 'Single', 'San Isidro', '2', 'qwerty123@gmail.com', 'Qwerty123', '$2y$10$ulORW5LZ1bhPitfMf16P8OCxXOj2W6ZSg4r2ctiG/BCHssNYIMw6m', 1, '2024-08-30 17:52:50', NULL, NULL),
(2, 'Yes', 'Malapit', 'Pao', 'Pao', 'Pao', 'Male', '09876543212', '1990-04-28', 34, 'San Isidro, Nueva Ecija', 'Single', 'San Isidro', '3', 'pao@gmail.com', 'pao', '$2y$10$4nvFdzqFRpdgrcDpLOupQ.ZFCPA4Bagey4Ota1PX5gNCk3sjjUhGC', 0, '2024-08-30 17:54:44', NULL, NULL),
(3, 'Yes', 'Malapit', 'Zxc', 'Zxc', 'Zxc', 'Female', '09876543212', '2004-01-01', 20, 'San Isidro', 'Single', 'San Isidro', '2', 'zxc@gmail.com', 'Qwerty123', '$2y$10$hYs6kcCtafVx1Gg7SaFtje2QBGhaa6VbS6Egj74aO0VaL1FzHNp7y', 1, '2024-08-30 21:07:05', NULL, NULL),
(4, 'Yes', 'Malapit', 'Tiktalk', 'Tiktalk', 'Tiktalk', 'Male', '09876543212', '2007-12-31', 16, 'San Isidro, Nueva Ecija', 'Single', 'San Isidro', '2', 'tiktalkcompany6969@gmail.com', 'tiktalk', '$2y$10$SqnNyGjWhjv/ZOiH0xJ/XesGMF0UvuShU54bMnTIVIkHcvzY8Lw1m', 0, '2024-08-31 15:58:18', NULL, NULL),
(5, 'Yes', 'Malapit', 'Admin', 'Admin', 'Admin', 'Male', '09876543212', '1985-12-12', 38, 'San Isidro, Nueva Ecija', 'Married', 'San Isidro', '2', 'admin@gmail.com', 'admin123', '$2y$10$UO478AZvC84E/gvG/L9zd.hONFYVHwbtz1.7ATL7KpptBfq7efpGi', 2, '2024-08-31 17:13:37', NULL, NULL),
(6, 'Yes', 'Malapit', 'Minda', 'Minda', 'Minda', 'Female', '09876543212', '1990-12-12', 33, 'San Isidro, Nueva Ecija', 'Married', 'San Isidro', '2', 'minda@gmail.com', 'admin123', '$2y$10$rBckP8.dW1NMiErswAAOj.eZ64L9NAj1PWG1X3lWS0EAEwmM6VS3i', 2, '2024-08-31 17:43:54', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_faqs`
--
ALTER TABLE `tbl_faqs`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`notify_id`);

--
-- Indexes for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tbl_requests`
--
ALTER TABLE `tbl_requests`
  ADD PRIMARY KEY (`req_id`);

--
-- Indexes for table `tbl_useracc`
--
ALTER TABLE `tbl_useracc`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_faqs`
--
ALTER TABLE `tbl_faqs`
  MODIFY `faq_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `log_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `notify_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `post_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_requests`
--
ALTER TABLE `tbl_requests`
  MODIFY `req_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_useracc`
--
ALTER TABLE `tbl_useracc`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
