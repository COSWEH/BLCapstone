-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2024 at 02:38 PM
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
(3, 'Who will limit access to certain information?', 'Access to certain sensitive or restricted information will be managed by system administrators and security officers. They will configure access controls based on user roles, permissions, and security policies to ensure that only authorized individuals can view or manipulate sensitive data.', '2024-08-26 10:01:32'),
(14, 'How do I reset my password?', 'Click on the \"Forgot Password\" link on the login page, enter your email address, and follow the instructions sent to your inbox to reset your password.', '2024-09-01 11:00:28'),
(15, 'How can I update my profile information?', 'Log in to your account, go to the \"Profile\" section, and click on \"Edit Profile.\" Update your information and click \"Save Changes\" to apply the updates.', '2024-09-01 11:00:28'),
(16, 'What should I do if I encounter an error while submitting a form?', 'Ensure all required fields are filled out correctly. If the issue persists, clear your browser cache and try again. If the problem continues, contact our support team for assistance.', '2024-09-01 11:00:28'),
(17, 'What is the refund policy?', 'Our refund policy allows for a full refund within 30 days of purchase. Please contact our support team for more details.', '2024-09-01 11:05:37'),
(18, 'How can I contact customer support?', 'You can reach our customer support team via email at support@example.com or call us at (123) 456-7890.', '2024-09-01 11:05:37'),
(19, 'Where can I find the user manual?', 'The user manual can be found on our website under the Support section or directly at www.example.com/manual.', '2024-09-01 11:05:37'),
(20, 'Do you offer international shipping?', 'Yes, we offer international shipping. Shipping rates and delivery times vary depending on the destination.', '2024-09-01 11:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_home`
--

CREATE TABLE `tbl_home` (
  `home_id` int(22) NOT NULL,
  `home_title` text NOT NULL,
  `home_subtitleOne` text NOT NULL,
  `home_subtitleTwo` text NOT NULL,
  `home_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_home`
--

INSERT INTO `tbl_home` (`home_id`, `home_title`, `home_subtitleOne`, `home_subtitleTwo`, `home_img`) VALUES
(2, 'Welcome To Bayanlink', 'At bayanlink, we connect communities and simplify access to essential services. Our platform provides direct access to official information, streamlines document requests, and enhances civic engagement. Tete. Tete\r\n', 'Explore our features to see how we make your experience more efficient and engaging. Tete.', 'img1.png');

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
(70, 'User admin123 added another super admin account', '2024-08-31 17:43:54', 5),
(71, 'Super Admin account deleted by user admin123.', '2024-08-31 21:26:03', 5),
(72, 'User admin123 added another super admin account', '2024-08-31 21:33:14', 5),
(73, 'Super Admin account deleted by user admin123.', '2024-08-31 21:37:26', 5),
(74, ' Super Admin account registered by admin123.', '2024-08-31 21:38:27', 5),
(75, 'User admin123 created a post', '2024-08-31 21:40:45', 5),
(76, 'Admin account registered by Qwerty123.', '2024-08-31 22:44:06', 1),
(77, 'Super Admin account deleted by user Qwerty123.', '2024-08-31 22:48:54', 1),
(78, 'Super Admin account deleted by user admin123.', '2024-08-31 22:49:55', 5),
(79, 'User Qwerty123 approved a document', '2024-09-01 10:26:58', 1),
(80, 'User Qwerty123 proccessed a document', '2024-09-01 10:27:36', 1),
(81, 'User Qwerty123 approved a document', '2024-09-01 10:27:46', 1),
(82, 'User admin123 added a FAQs', '2024-09-01 13:50:51', 5),
(83, 'FAQs deleted by user admin123.', '2024-09-01 14:19:41', 5),
(84, 'FAQs deleted by user admin123.', '2024-09-01 14:20:14', 5),
(85, 'User Qwerty123 updated a post', '2024-09-01 15:28:26', 1),
(86, 'User pao updated his/her information', '2024-09-01 16:04:06', 2),
(87, 'User pao updated his/her information', '2024-09-01 16:07:31', 2),
(88, 'User pao updated his/her information', '2024-09-01 16:08:25', 2),
(89, 'User pao updated his/her information', '2024-09-01 16:08:53', 2),
(90, 'User pao updated his/her information', '2024-09-01 16:09:02', 2),
(91, 'User pao updated his/her information', '2024-09-01 16:09:11', 2),
(92, 'User pao updated his/her information', '2024-09-01 16:12:17', 2),
(93, 'User pao updated his/her information', '2024-09-01 16:12:39', 2),
(94, 'User pao updated his/her information', '2024-09-01 16:13:39', 2),
(95, 'User pao requested a Barangay Clearance', '2024-09-01 17:12:47', 2),
(96, 'Document type deleted by user Qwerty123.', '2024-09-01 17:25:42', 1),
(97, 'User Qwerty123 added a document', '2024-09-01 17:39:25', 1),
(98, 'Document deleted by user Qwerty123.', '2024-09-01 17:39:39', 1),
(99, 'User Qwerty123 proccessed a document', '2024-09-01 17:56:40', 1),
(100, 'User Qwerty123 proccessed a document', '2024-09-01 18:11:43', 1),
(101, 'User Qwerty123 cancelled a document', '2024-09-01 18:12:14', 1),
(102, 'User Qwerty123 approved a document', '2024-09-01 18:12:30', 1),
(103, 'User admin123 created a post', '2024-09-01 19:06:41', 5),
(104, 'User admin123 updated a post', '2024-09-01 19:21:34', 5),
(105, 'User admin123 changed the home title', '2024-09-02 12:31:43', 5),
(106, 'User admin123 changed the home title', '2024-09-02 12:38:16', 5),
(107, 'User admin123 changed the first home subtitle', '2024-09-02 13:32:00', 5),
(108, 'User admin123 changed the first home subtitle', '2024-09-02 13:32:45', 5),
(109, 'User admin123 changed the first home subtitle', '2024-09-02 13:33:29', 5),
(110, 'User admin123 changed the first home subtitle', '2024-09-02 13:33:44', 5),
(111, 'User admin123 changed the first home subtitle', '2024-09-02 13:34:11', 5),
(112, 'User admin123 changed the first home subtitle', '2024-09-02 13:46:21', 5),
(113, 'User admin123 changed the first home subtitle', '2024-09-02 13:46:33', 5),
(114, 'User admin123 changed the first home subtitle', '2024-09-02 13:46:49', 5),
(115, 'User admin123 changed the home title', '2024-09-02 13:52:44', 5),
(116, 'User admin123 changed the home title', '2024-09-02 13:52:57', 5),
(117, 'User admin123 changed the first home subtitle', '2024-09-02 13:53:07', 5),
(118, 'User admin123 changed the second home subtitle', '2024-09-02 13:55:06', 5),
(119, 'User admin123 changed the second home subtitle', '2024-09-02 13:56:29', 5),
(120, 'User admin123 changed the first home subtitle', '2024-09-02 13:56:45', 5),
(121, 'User admin123 updated the home image', '2024-09-02 14:09:37', 5),
(122, 'User admin123 updated the home image', '2024-09-02 14:11:28', 5),
(123, 'User admin123 updated the home image', '2024-09-02 14:13:12', 5),
(124, 'User admin123 updated the home image', '2024-09-02 14:27:14', 5),
(125, 'User admin123 updated the home image', '2024-09-02 14:28:24', 5),
(126, 'User admin123 updated the home image', '2024-09-02 14:33:03', 5),
(127, 'User admin123 updated the home image', '2024-09-02 14:33:10', 5),
(128, 'User admin123 updated the home image', '2024-09-02 14:33:51', 5);

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
(34, 4, 'Cancelled', 'read', '2024-08-31 16:01:14'),
(35, 1, 'Approved', 'unread', '2024-09-01 10:26:58'),
(36, 1, 'Processed', 'unread', '2024-09-01 10:27:36'),
(37, 1, 'Approved', 'unread', '2024-09-01 10:27:46'),
(38, 2, 'Processed', 'read', '2024-09-01 17:56:40'),
(39, 4, 'Processed', 'unread', '2024-09-01 18:11:43'),
(40, 2, 'Cancelled', 'read', '2024-09-01 18:12:14'),
(41, 4, 'Approved', 'unread', '2024-09-01 18:12:30');

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
(1, 1, 'Malapit', 'asdsasd', '[]', '2024-09-01 15:28:26'),
(2, 5, 'Municipal', 'asdsadsadsd13131333', '[]', '2024-08-31 21:40:45'),
(3, 5, 'Municipal', 'ASDASD', '[]', '2024-09-01 20:44:23');

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
(1, 1, '2024-09-01 18:10:12', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isidro', 'Single', 'ss-[BayanLink-66d156d3b0d8f].png', 'Barangay Clearance', 'id-[BayanLink-66d156d3b0d94].png', 'Pending', ''),
(2, 1, '2024-09-01 18:10:14', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isdro', 'Single', 'ss-[BayanLink-66d157520d4ae].png', 'Cedula', 'id-[BayanLink-66d157520d4b4].png', 'Pending', ''),
(3, 1, '2024-09-01 18:10:16', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isidro', 'Single', 'ss-[BayanLink-66d16a9f2c42e].png', 'Job Seeker', 'id-[BayanLink-66d16a9f2c431].png', 'Pending', 'User account issue, Document no longer applicable, '),
(4, 1, '2024-09-01 18:10:20', 'Asd', 'Asd', 'Asd', '09876543212', 'Male', 'Malapit', '2', 22, '2002-02-22', 'San Isidro', 'Single', 'ss-[BayanLink-66d16cbddfa49].png', 'Job Seeker', 'id-[BayanLink-66d16cbddfa4c].png', 'Pending', ''),
(5, 2, '2024-09-01 18:12:14', 'Pao', 'Pao', 'Pao', '09876543212', 'Male', 'Malapit', '3', 34, '1990-04-28', 'San Isidro, Nueva Ecija', 'Single', 'ss-[BayanLink-66d2935843f06].png', 'Business Permit', 'id-[BayanLink-66d2935843f09].png', 'Cancelled', 'Insufficient supporting documents, User account issue, Document no longer applicable, '),
(6, 4, '2024-09-01 18:12:30', 'Tiktalk', 'Tiktalk', 'Tiktalk', '09876543212', 'Male', 'Malapit', '2', 16, '2007-12-31', 'San Isidro, Nueva Ecija', 'Single', 'ss-[BayanLink-66d2cd3a9d187].png', 'Barangay Clearance', 'id-[BayanLink-66d2cd3a9d18a].png', 'Approved', 'Invalid or expired information, Insufficient supporting documents, User account issue, Document no longer applicable, '),
(7, 2, '2024-09-01 17:12:47', 'Pao', 'Pao', 'Pao', '09876543212', 'Male', 'Malapit', '3', 34, '1990-04-28', 'San Isidro, Nueva Ecija', 'Single', 'ss-[BayanLink-66d4300fbca1f].png', 'Barangay Clearance', 'id-[BayanLink-66d4300fbca22].png', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_typedoc`
--

CREATE TABLE `tbl_typedoc` (
  `id` int(22) NOT NULL,
  `docType` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_typedoc`
--

INSERT INTO `tbl_typedoc` (`id`, `docType`) VALUES
(1, 'Barangay Clearance'),
(2, 'Barangay Indigency'),
(5, 'Business Permit'),
(3, 'Cedula'),
(4, 'Job Seeker');

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
(5, 'Yes', 'Malapit', 'Admin', 'Admin', 'Admin', 'Male', '09876543212', '1985-12-12', 38, 'San Isidro, Nueva Ecija', 'Married', 'San Isidro', '2', 'admin@gmail.com', 'admin123', '$2y$10$UO478AZvC84E/gvG/L9zd.hONFYVHwbtz1.7ATL7KpptBfq7efpGi', 2, '2024-08-31 17:13:37', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_faqs`
--
ALTER TABLE `tbl_faqs`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `tbl_home`
--
ALTER TABLE `tbl_home`
  ADD PRIMARY KEY (`home_id`);

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
-- Indexes for table `tbl_typedoc`
--
ALTER TABLE `tbl_typedoc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `docType` (`docType`);

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
  MODIFY `faq_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_home`
--
ALTER TABLE `tbl_home`
  MODIFY `home_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `log_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `notify_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `post_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_requests`
--
ALTER TABLE `tbl_requests`
  MODIFY `req_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_typedoc`
--
ALTER TABLE `tbl_typedoc`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_useracc`
--
ALTER TABLE `tbl_useracc`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
