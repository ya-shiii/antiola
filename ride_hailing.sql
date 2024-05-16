-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 06:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ride_hailing`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_log`
--

CREATE TABLE `booking_log` (
  `booking_id` int(255) NOT NULL,
  `driver_id` int(255) NOT NULL,
  `passenger_id` int(255) NOT NULL,
  `booked_at` datetime NOT NULL DEFAULT current_timestamp(),
  `book_time` datetime NOT NULL,
  `start_loc` varchar(255) NOT NULL,
  `desti_loc` varchar(255) NOT NULL,
  `status` enum('pending','accepted','completed','cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_log`
--

INSERT INTO `booking_log` (`booking_id`, `driver_id`, `passenger_id`, `booked_at`, `book_time`, `start_loc`, `desti_loc`, `status`) VALUES
(1, 6, 1, '2024-05-14 23:39:08', '2024-05-01 09:00:00', 'Location A', 'Location X', 'cancelled'),
(2, 7, 2, '2024-05-14 18:39:08', '2024-05-02 10:00:00', 'Location B', 'Location Y', 'pending'),
(3, 8, 3, '2024-05-14 20:39:08', '2024-05-03 11:00:00', 'Location C', 'Location Z', 'pending'),
(4, 9, 4, '2024-05-14 18:47:08', '2024-05-04 12:00:00', 'Location D', 'Location W', 'pending'),
(5, 10, 5, '2024-05-14 21:39:08', '2024-05-05 13:00:00', 'Location E', 'Location V', 'accepted'),
(6, 6, 1, '2024-05-16 10:53:56', '2024-05-17 16:53:00', 'asdf', 'asdf', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `rider_list`
--

CREATE TABLE `rider_list` (
  `u_id` int(255) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` text NOT NULL,
  `vehicle` enum('motorcycle','car') NOT NULL,
  `plate_num` varchar(255) NOT NULL,
  `status` enum('booked','standby') NOT NULL DEFAULT 'standby'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rider_list`
--

INSERT INTO `rider_list` (`u_id`, `u_name`, `password`, `full_name`, `email`, `phone`, `address`, `vehicle`, `plate_num`, `status`) VALUES
(6, 'driver1', 'password1', 'Michael Johnson', 'michael@example.com', '1234567890', '123 Main St, City', 'motorcycle', '412341234', 'booked'),
(7, 'driver2', 'password2', 'Emily White', 'emily@example.com', '9876543210', '456 Elm St, Town', 'motorcycle', '12341234', 'standby'),
(8, 'driver3', 'password3', 'David Leee', 'david@example.com', '5551234567', '789 Oak St, Village', 'car', '1234123d', 'standby'),
(9, 'driver4', 'password4', 'Olivia Brown', 'olivia@example.com', '3337779999', '101 Pine St, Town', 'motorcycle', '1234', 'booked'),
(10, 'driver5', 'password5', 'Sophia Rodriguez', 'sophia@example.com', '2228884444', '246 Cedar St, City', 'car', '431412', 'standby'),
(11, 'driver6', 'driver6', 'Joshua Jumamil Vicente', 'gamerotaku80085@yahoo.com', '09516545327', 'Isidro D. Tan, Tangub City', 'car', 'asdasdasdf', 'booked'),
(12, 'asdf', 'asdf', 'Joshua Jumamil Vicente', 'gamerotaku80085@yahoo.coma', '09516545327', 'Isidro D. Tan, Tangub City', 'car', 'asdasdasdfaaa', 'standby'),
(13, 'user1aaa', 'user1aaa', 'Joshua Jumamil Vicente', 'gamerotaku80085@yahoo.comaaa', '09516545327', 'Isidro D. Tan, Tangub City', 'car', 'asdasdasdfaaaaaa', 'standby');

-- --------------------------------------------------------

--
-- Table structure for table `user_list`
--

CREATE TABLE `user_list` (
  `u_id` int(255) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_list`
--

INSERT INTO `user_list` (`u_id`, `u_name`, `password`, `full_name`, `email`, `phone`, `address`, `status`) VALUES
(1, 'user1', 'password1', 'John Doee', 'john@example.com', '1234567890', 123, 'active'),
(2, 'user2', 'password2', 'Jane Smith', 'jane@example.com', '9876543210', 456, 'active'),
(3, 'user3', 'password3', 'Alice Johnson', 'alice@example.com', '5551234567', 789, 'active'),
(4, 'user4', 'password4', 'Bob Brown', 'bob@example.com', '3337779999', 101, 'active'),
(5, 'user5', 'password5', 'Eva Lee', 'eva@example.com', '2228884444', 246, 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `welcome_message`
--

CREATE TABLE `welcome_message` (
  `text_id` int(155) NOT NULL,
  `display_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `welcome_message`
--

INSERT INTO `welcome_message` (`text_id`, `display_message`) VALUES
(1, 'Wanna go somewhere? Book a reservation now!'),
(2, 'Sample Message');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_log`
--
ALTER TABLE `booking_log`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `rider_list`
--
ALTER TABLE `rider_list`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `user_list`
--
ALTER TABLE `user_list`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `welcome_message`
--
ALTER TABLE `welcome_message`
  ADD PRIMARY KEY (`text_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_log`
--
ALTER TABLE `booking_log`
  MODIFY `booking_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rider_list`
--
ALTER TABLE `rider_list`
  MODIFY `u_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_list`
--
ALTER TABLE `user_list`
  MODIFY `u_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `welcome_message`
--
ALTER TABLE `welcome_message`
  MODIFY `text_id` int(155) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
