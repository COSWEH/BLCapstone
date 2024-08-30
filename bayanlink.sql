-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2024 at 03:03 PM
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
(24, 'User qwerty123 cancelled a document', '2024-08-30 14:57:40', 2);

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
(1, 1, 'Processed', 'read', '2024-08-30 13:21:48'),
(2, 1, 'Processed', 'read', '2024-08-30 13:23:43'),
(3, 1, 'Approved', 'read', '2024-08-30 13:47:37'),
(4, 1, 'Approved', 'read', '2024-08-30 13:47:48'),
(5, 1, 'Processed', 'read', '2024-08-30 13:58:51'),
(6, 1, 'Approved', 'unread', '2024-08-30 14:42:35'),
(7, 1, 'Cancelled', 'unread', '2024-08-30 14:57:40');

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
  `req_dateOfBirth` date DEFAULT NULL,
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
(1, 1, '2024-08-30 14:42:35', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isidro', 'Single', 'ss-[BayanLink-66d156d3b0d8f].png', 'Barangay Clearance', 'id-[BayanLink-66d156d3b0d94].png', 'Approved', NULL),
(2, 1, '2024-08-30 13:58:51', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isdro', 'Single', 'ss-[BayanLink-66d157520d4ae].png', 'Cedula', 'id-[BayanLink-66d157520d4b4].png', 'Processing', NULL),
(3, 1, '2024-08-30 14:45:51', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isidro', 'Single', 'ss-[BayanLink-66d16a9f2c42e].png', 'Job Seeker', 'id-[BayanLink-66d16a9f2c431].png', 'Pending', NULL),
(4, 1, '2024-08-30 14:57:40', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isidro', 'Single', 'ss-[BayanLink-66d16cbddfa49].png', 'Job Seeker', 'id-[BayanLink-66d16cbddfa4c].png', 'Cancelled', 'Duplicate submission, ');

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

INSERT INTO `tbl_useracc` (`user_id`, `fromSanIsidro`, `user_brgy`, `user_fname`, `user_mname`, `user_lname`, `user_gender`, `user_contactNum`, `user_city`, `user_purok`, `user_email`, `username`, `password`, `role_id`, `user_create_at`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'Yes', 'Malapit', 'Asd', 'Asd', 'Asd', 'Male', '09876543212', 'San Isidro', '2', 'asd@gmail.com', 'asd', '$2y$10$ILlCaCyA4y97P8FNR4dNbeos9222TB9d3if.iNYvy3N2GbJbapX86', 0, '2024-08-29 21:15:05', NULL, NULL),
(2, 'Yes', 'Malapit', 'Paolo', 'Marvel', 'Ramos', 'Male', '09876543212', 'San Isidro', '2', 'qwerty123@gmail.com', 'qwerty123', '$2y$10$VLeSQfBqUjOTAwTPZuW//OFrFwSUIMD5.DkeXV6osInvgSXlj9/TS', 1, '2024-08-29 21:15:46', NULL, NULL);

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
  MODIFY `log_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `notify_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `post_id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_requests`
--
ALTER TABLE `tbl_requests`
  MODIFY `req_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_useracc`
--
ALTER TABLE `tbl_useracc`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
