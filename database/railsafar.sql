-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2024 at 02:32 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `railsafar_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `message_list`
--

CREATE TABLE `message_list` (
  `id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `contact` text NOT NULL,
  `email` text NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_list`
--

INSERT INTO `message_list` (`id`, `fullname`, `contact`, `email`, `message`, `status`, `date_created`) VALUES
(1, 'Mark Cooper', '09456123789', 'mcooper@sample.com', 'Sample Inquiry only', 1, '2022-01-06 09:13:14');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_list`
--

CREATE TABLE `reservation_list` (
  `id` int(30) NOT NULL,
  `seat_num` varchar(50) NOT NULL,
  `schedule_id` int(30) NOT NULL,
  `schedule` datetime NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text NOT NULL,
  `lastname` text NOT NULL,
  `seat_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=First Class, 2 = Economy',
  `fare_amount` float NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation_list`
--

INSERT INTO `reservation_list` (`id`, `seat_num`, `schedule_id`, `schedule`, `firstname`, `middlename`, `lastname`, `seat_type`, `fare_amount`, `date_created`, `date_updated`) VALUES
(1, 'FC-001', 1, '2022-01-07 07:00:00', 'John', 'D', 'Smith', 1, 50, '2022-01-05 16:26:00', NULL),
(3, 'FC-003', 1, '2022-01-07 07:00:00', 'Mark', 'D', 'Cooper', 1, 50, '2022-01-05 16:27:56', NULL),
(4, 'FC-001', 2, '2022-01-07 08:00:00', 'John', 'D', 'Smith', 1, 250, '2022-01-05 16:31:27', NULL),
(5, 'FC-002', 2, '2022-01-07 08:00:00', 'Claire', 'C', 'Blake', 1, 250, '2022-01-05 16:31:27', NULL),
(6, 'E-001', 1, '2022-01-07 07:00:00', 'John', 'D', 'Smith', 2, 25, '2022-01-06 08:35:53', NULL),
(7, 'E-002', 1, '2022-01-07 07:00:00', 'Claire', 'C ', 'Blake', 2, 25, '2022-01-06 08:35:53', NULL),
(8, 'E-001', 2, '2022-01-07 08:00:00', 'Mark', 'D', 'Cooper', 2, 170, '2022-01-06 09:24:57', NULL),
(9, 'E-002', 2, '2022-01-07 08:00:00', 'Samantha', 'C', 'Cooper', 2, 170, '2022-01-06 09:24:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `train_id` int(30) NOT NULL,
  `route_from` text NOT NULL,
  `route_to` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = daily, 2= One-Time Schedule',
  `date_schedule` date DEFAULT NULL,
  `time_schedule` time NOT NULL,
  `first_class_fare` float NOT NULL DEFAULT 0,
  `economy_fare` float NOT NULL DEFAULT 0,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_list`
--

INSERT INTO `schedule_list` (`id`, `code`, `train_id`, `route_from`, `route_to`, `type`, `date_schedule`, `time_schedule`, `first_class_fare`, `economy_fare`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, '202201-0001', 1, 'Station 1', 'Station 2', 1, NULL, '07:00:00', 50, 25, 0, '2022-01-05 13:14:45', '2022-01-05 13:23:17'),
(2, '202201-0003', 2, 'Station 2', 'Station 5', 2, '2022-01-07', '08:00:00', 250, 170, 0, '2022-01-05 13:17:49', '2022-01-05 13:25:18'),
(3, '202201-0002', 1, 'Station 1', 'Station 3', 1, NULL, '08:30:00', 100, 75, 0, '2022-01-05 13:18:25', '2022-01-05 13:24:28'),
(4, '202201-0004', 1, 'Station 1', 'Station 2', 1, NULL, '00:00:00', 123, 89, 1, '2022-01-05 13:59:44', '2022-01-05 13:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'RAILSAFAR - Online Railway Reservation System'),
(6, 'short_name', 'railsafar'),
(11, 'logo', 'uploads/logo-1641351863.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1641351863.png'),
(15, 'content', 'Array'),
(16, 'email', 'info@railway.com'),
(17, 'contact', '09854698789 / 78945632'),
(18, 'from_time', '11:00'),
(19, 'to_time', '21:30'),
(20, 'address', 'XYZ Street, There City, Here, 2306');

-- --------------------------------------------------------

--
-- Table structure for table `train_list`
--

CREATE TABLE `train_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `first_class_capacity` float NOT NULL DEFAULT 0,
  `economy_capacity` float NOT NULL DEFAULT 0,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `train_list`
--

INSERT INTO `train_list` (`id`, `code`, `name`, `first_class_capacity`, `economy_capacity`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'TIR-1001', 'Train 101', 100, 200, 0, '2022-01-05 11:05:42', '2022-01-05 16:27:47'),
(2, 'TIR-1002', 'Train 102', 100, 200, 0, '2022-01-05 11:11:41', NULL),
(3, 'TIR-1003', 'Train 103', 150, 300, 0, '2022-01-05 11:11:56', NULL),
(4, 'TIR-1004', 'Train 104', 150, 300, 0, '2022-01-05 11:12:15', NULL),
(5, 'TIR-1005', 'Train 105', 800, 1500, 1, '2022-01-05 11:13:00', '2022-01-05 11:13:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', NULL, 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatar-1.png?v=1639468007', NULL, 1, 1, '2021-01-20 14:02:37', '2021-12-14 15:47:08'),
(4, 'Smantha', NULL, 'Lou', 'slou', '1ed1255790523a907da869eab7306f5a', 'uploads/avatar-4.png?v=1641346647', NULL, 2, 1, '2022-01-05 09:36:56', '2022-01-05 09:37:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message_list`
--
ALTER TABLE `message_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation_list`
--
ALTER TABLE `reservation_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `train_id` (`train_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `train_list`
--
ALTER TABLE `train_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message_list`
--
ALTER TABLE `message_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservation_list`
--
ALTER TABLE `reservation_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `train_list`
--
ALTER TABLE `train_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation_list`
--
ALTER TABLE `reservation_list`
  ADD CONSTRAINT `reservation_list_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedule_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD CONSTRAINT `schedule_list_ibfk_1` FOREIGN KEY (`train_id`) REFERENCES `train_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
