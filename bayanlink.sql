-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2024 at 09:51 PM
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
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `role_id` int(22) NOT NULL,
  `role_name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`role_id`, `role_name`) VALUES
(0, 'civilian'),
(1, 'super admin');

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
  `role_id` int(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_useracc`
--

INSERT INTO `tbl_useracc` (`user_id`, `fromSanIsidro`, `user_brgy`, `user_fname`, `user_mname`, `user_lname`, `user_gender`, `user_address`, `user_contactNum`, `user_email`, `username`, `password`, `role_id`) VALUES
(1, 'Yes', 'Malapit', 'Paolo', 'Marvel', 'Ramos', 'Male', ' Purok 1 Brgy. Tagpos, Sta. Rosa Nueva Ecija', '09876543212', 'qwerty123@gmail.com', 'qwerty123', '$2y$10$lA2M6NwaMUWrQOxpellmYOVzp.VaNXBVVpWOu8ibIT9ZtChFglh62', 1),
(3, 'Yes', 'Malapit', 'V', 'V', 'V', 'Male', 'V', '09876543212', 'asd@gmail.com', 'asd', '$2y$10$cBtk0GdAqksqO0v3Qnucmu7Zg/ptzsCymedVO/Pg/rKYgkQOcMKUK', 0),
(4, 'Yes', 'Poblacion', 'P', 'P', 'P', 'Male', 'P', '09876543212', 'qweqwe@gmail.com', 'qweqwe', '$2y$10$BR5XaNBUQUHSw7IDKUYE7u3jWixypEf7tuHWfJGF9FdtgZgu4/w0G', 1),
(5, 'Yes', 'Poblacion', 'W', 'W', 'W', 'Female', 'W', '09876543212', 'asdasd@gmail.com', 'asdasd', '$2y$10$6TEcv24imR6lpfWItJOok.n4MQebzxhE2FAi9OqPbZBzmzU63b2p6', 0),
(6, 'Yes', 'Municipal', 'admin', 'admin', 'admin', 'Male', 'admin', '', 'admin@gmail.com', 'admin', '$2y$10$lA2M6NwaMUWrQOxpellmYOVzp.VaNXBVVpWOu8ibIT9ZtChFglh62', 2),
(7, 'Yes', 'Alua', 'P', '', 'P', 'Male', 'P City P Street', '639876543212', 'p@gmail.com', 'ppp', '$2y$10$R6gFN/rbrsfEiuBcTkm0t.xMME7DRbWLMYPQ.sdIvVACoR9SZ/nk6', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tbl_useracc`
--
ALTER TABLE `tbl_useracc`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `post_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_useracc`
--
ALTER TABLE `tbl_useracc`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
