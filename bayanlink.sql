-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2024 at 11:06 AM
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
  `log_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(22) NOT NULL,
  `post_id` int(22) NOT NULL,
  `req_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `notify_id` int(22) NOT NULL,
  `req_id` int(22) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(55) DEFAULT NULL,
  `notify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`notify_id`, `req_id`, `description`, `status`, `notify_date`) VALUES
(1, 4, 'Processed', 'read', '2024-08-26 13:43:24');

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
(10, 1, 'Malapit', 'Lorem ipsum odor amet, consectetuer adipiscing elit. Turpis ac nibh arcu magna purus magna cras turpis. Himenaeos felis enim pulvinar inceptos placerat, sem leo nam. Scelerisque rutrum ornare facilisis nunc eu nullam potenti lobortis. Maximus metus est sed vulputate nullam. Iaculis dictum dis ultrices sollicitudin dis! Id vehicula finibus tempus natoque in metus.', '[\"12-[BayanLink-66c5a1b0d2994].png\"]', '2024-08-21 16:13:36'),
(11, 6, 'Municipal', 'Lorem ipsum odor amet, consectetuer adipiscing elit. Turpis ac nibh arcu magna purus magna cras turpis. Himenaeos felis enim pulvinar inceptos placerat, sem leo nam. Scelerisque rutrum ornare facilisis nunc eu nullam potenti lobortis. Maximus metus est sed vulputate nullam. Iaculis dictum dis ultrices sollicitudin dis! Id vehicula finibus tempus natoque in metus. Lorem ipsum odor amet, consectetuer adipiscing elit. Turpis ac nibh arcu magna purus magna cras turpis. Himenaeos felis enim pulvinar inceptos placerat, sem leo nam. Scelerisque rutrum ornare facilisis nunc eu nullam potenti lobortis. Maximus metus est sed vulputate nullam. Iaculis dictum dis ultrices sollicitudin dis! Id vehicula finibus tempus natoque in metus.', '[\"12-[BayanLink-66c5a62ba87de].png\"]', '2024-08-21 16:32:43');

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
  `req_password` varchar(255) NOT NULL,
  `req_status` varchar(25) NOT NULL,
  `req_reasons` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_requests`
--

INSERT INTO `tbl_requests` (`req_id`, `user_id`, `req_date`, `req_fname`, `req_mname`, `req_lname`, `req_contactNo`, `req_gender`, `req_brgy`, `req_purok`, `req_age`, `req_dateOfBirth`, `req_placeOfBirth`, `req_civilStatus`, `req_eSignature`, `req_typeOfDoc`, `req_valid_id`, `req_password`, `req_status`, `req_reasons`) VALUES
(1, 3, '2024-08-25 14:34:08', 'V', 'V', 'V', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isidro, Nueva Ecija', 'Single', 'ss-[BayanLink-66caa9e9bd247].png', 'Barangay Indigency', 'id-[BayanLink-66caa9e9bd24b].png', '$2y$10$SmDqtN9iG5eEdNq7.ABA6e./HcglM1u5vCO8krFP5cFsVuR53FCP.', 'Cancelled', ''),
(2, 14, '2024-08-25 14:34:11', 'Tiktalk', 'Tiktalk', 'Tiktalk', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isidro, Nueva Ecija', 'Single', 'ss-[BayanLink-66cabb6aa150a].png', 'Cedula', 'id-[BayanLink-66cabb6aa150e].png', '$2y$10$pWNU7wTQ1LI4vpQw82a1AeXK4ATGupQXoZ7iBf2cV3N4MQfRVQfU6', 'Cancelled', ''),
(4, 9, '2024-08-26 13:43:24', 'Not', 'Not', 'Not', '09765681352', 'Male', 'Malapit', '2', 22, '2022-02-22', 'N/a', 'Single', 'ss-[BayanLink-66cc15d5c16ad].png', 'Barangay Clearance', 'id-[BayanLink-66cc15d5c16b0].png', '$2y$10$UZ30WhYQjKjPSPElxfl4FONJA2HKWhkJwFFrGWTnkyxByq5/dQwSG', 'Processing', NULL);

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
  `user_address` text NOT NULL,
  `user_contactNum` varchar(55) NOT NULL,
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

INSERT INTO `tbl_useracc` (`user_id`, `fromSanIsidro`, `user_brgy`, `user_fname`, `user_mname`, `user_lname`, `user_gender`, `user_address`, `user_contactNum`, `user_email`, `username`, `password`, `role_id`, `user_create_at`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'Yes', 'Malapit', 'Paolo', 'Marvel', 'Ramos', 'Male', ' Purok 1 Brgy. Tagpos, Sta. Rosa Nueva Ecija', '09876543212', 'qwerty123@gmail.com', 'qwerty123', '$2y$10$lA2M6NwaMUWrQOxpellmYOVzp.VaNXBVVpWOu8ibIT9ZtChFglh62', 1, '2024-08-19 22:31:40', NULL, NULL),
(3, 'Yes', 'Malapit', 'V', 'V', 'V', 'Male', 'Malapit, San Isidro Nueva Ecija', '09876543212', 'asd@gmail.com', 'asd', '$2y$10$cBtk0GdAqksqO0v3Qnucmu7Zg/ptzsCymedVO/Pg/rKYgkQOcMKUK', 0, '2024-08-20 20:26:53', NULL, NULL),
(4, 'Yes', 'Poblacion', 'P', 'P', 'P', 'Male', 'P', '09876543212', 'qweqwe@gmail.com', 'qweqwe', '$2y$10$BR5XaNBUQUHSw7IDKUYE7u3jWixypEf7tuHWfJGF9FdtgZgu4/w0G', 1, '2024-08-19 22:31:40', NULL, NULL),
(5, 'Yes', 'Poblacion', 'W', 'W', 'W', 'Female', 'W', '09876543212', 'asdasd@gmail.com', 'asdasd', '$2y$10$6TEcv24imR6lpfWItJOok.n4MQebzxhE2FAi9OqPbZBzmzU63b2p6', 0, '2024-08-19 22:31:40', NULL, NULL),
(6, 'Yes', 'Municipal', 'admin', 'admin', 'admin', 'Male', 'admin', '', 'admin@gmail.com', 'admin', '$2y$10$lA2M6NwaMUWrQOxpellmYOVzp.VaNXBVVpWOu8ibIT9ZtChFglh62', 2, '2024-08-19 22:31:40', NULL, NULL),
(7, 'Yes', 'Alua', 'P', '', 'P', 'Male', 'P City P Street', '639876543212', 'p@gmail.com', 'ppp', '$2y$10$R6gFN/rbrsfEiuBcTkm0t.xMME7DRbWLMYPQ.sdIvVACoR9SZ/nk6', 0, '2024-08-19 22:31:40', NULL, NULL),
(8, 'Yes', 'Malapit', 'Asd', 'Asd', 'Asd', 'Male', 'Asd 123', '09876543214', 'asd123@gmail.com', 'asd123', '$2y$10$ULYVmECtoOkbgDaM2WwHs.aJDcq4fjIlbFBLr4eY2oGBqaNyfQQ2u', 0, '2024-08-19 22:31:40', NULL, NULL),
(9, 'No', 'N/a', 'Not', 'Not', 'Not', 'Male', 'Not Not Not St.', '09765681352', 'not@gmail.com', 'not', '$2y$10$r1NvgyJEYxiZWkwpWiyR8OO7frgWV7J9E6bYvZ2Sgk2jdk8WWQXeK', 0, '2024-08-19 22:31:40', NULL, NULL),
(10, 'Yes', 'Poblacion', 'Dsa', 'Das', 'Dsa', 'Male', 'Das Dsa Das', '09987123456', 'dsa@gmail.com', 'dsa', '$2y$10$ZuMsDdllIoiXcZvuysfVV.R3BYISBAu7ZztCWLmbQ./Y.Fg1ycGrm', 0, '2024-08-19 22:31:40', NULL, NULL),
(11, 'Yes', 'Malapit', 'Dsada', 'Dsadsa', 'Dsadsa', 'Female', 'Dsadadsadas Dsadsa', '09866535432', 'dsadas@gmail.com', 'dsadas', '$2y$10$KOl1emBzzZHxNsrIqzeW4Of3WbBiHuy2ttsvFwjovea7xzSiSKD3e', 0, '2024-08-19 22:31:40', NULL, NULL),
(12, 'Yes', 'Malapit', 'Asdsaddsa', 'Asdaad', 'Asdasdsdds', 'Male', 'Asdadasdda', '09876543212', 'kjlklj@gmail.com', 'hjkhjk', '$2y$10$y7QyXlG9sdyhIBGZGLHiluE0InDBc4oJ25rM9OgKsJPkIqlBkLhY6', 0, '2024-08-19 22:31:40', NULL, NULL),
(14, 'Yes', 'Malapit', 'Tiktalk', 'Tiktalk', 'Tiktalk', 'Male', 'Tiktalk Tiktalk Tiktalk 123', '09876543212', 'tiktalkcompany6969@gmail.com', 'Tiktalk', '$2y$10$H4B96lLKVOVmb/KN0cigtO3bRHCEX32YSuUIU4.30bGoovk.IuaSS', 0, '2024-08-20 22:23:31', NULL, NULL),
(18, 'Yes', 'Malapit', 'Ewq', 'Ewq', 'Ewq', 'Female', 'Ewq Qwe Ewq', '09876543212', 'brgyadmin@gmail.com', 'admin144', '$2y$10$GOkF21OAdCOsPN/dILoLm.UN09GxPrMSWrzLorhFJBjbNH6WdrInK', 1, '2024-08-28 10:52:05', NULL, NULL),
(19, 'Yes', 'Municipal', 'Super', 'Super', 'Super', 'Male', 'San Isidro, Nueva Ecija', '09876543212', 'superadmin@gmail.com', 'superAdmin', '$2y$10$ZrIPAnlinkPigWY8Zrk4suO5nGqFTT0XmGYEHSOsqlYEWUGo9AlNO', 2, '2024-08-28 11:04:23', NULL, NULL);

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
  MODIFY `faq_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `log_id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `notify_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `post_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_requests`
--
ALTER TABLE `tbl_requests`
  MODIFY `req_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_useracc`
--
ALTER TABLE `tbl_useracc`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
