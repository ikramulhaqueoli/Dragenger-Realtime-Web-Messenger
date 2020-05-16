-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2020 at 11:57 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dragenger_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `friend_list`
--

CREATE TABLE `friend_list` (
  `user_id_1` bigint(20) NOT NULL,
  `user_id_2` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `friend_list`
--

INSERT INTO `friend_list` (`user_id_1`, `user_id_2`) VALUES
(17, 13);

-- --------------------------------------------------------

--
-- Table structure for table `friend_req_list`
--

CREATE TABLE `friend_req_list` (
  `sender_id` bigint(20) NOT NULL,
  `receiver_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL,
  `text` text NOT NULL,
  `sender_id` bigint(20) NOT NULL,
  `receiver_id` bigint(20) NOT NULL,
  `sent_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `text`, `sender_id`, `receiver_id`, `sent_time`) VALUES
(60, 'hi how are you?', 13, 17, '2020-05-16 21:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `username` varchar(25) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `type` varchar(15) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `last_active` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `username`, `gender`, `type`, `birthdate`, `last_active`) VALUES
(13, 'Ikramul Haque Chowdhury', 'ikramuloli56@gmail.com', 'webtech', 'ikramuloli', 'Male', 'consumer', '1996-04-25', '2020-05-17 03:56:59'),
(16, 'Ahmed Efaz', 'ahmedefaz@gmail.com', 'webtech', 'efazahmed', 'Male', 'moderator', NULL, NULL),
(17, 'Nusrat Moon', 'nusratmoon2020@gmail.com', 'webtech', 'nusratmoon', 'Female', 'consumer', NULL, NULL),
(18, 'Md Arif', 'ariful@gmail.com', 'webtech', 'ariful', 'Male', 'administrator', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friend_list`
--
ALTER TABLE `friend_list`
  ADD KEY `user_id_1` (`user_id_1`),
  ADD KEY `user_id_2` (`user_id_2`);

--
-- Indexes for table `friend_req_list`
--
ALTER TABLE `friend_req_list`
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unq` (`email`),
  ADD UNIQUE KEY `username_unq` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friend_list`
--
ALTER TABLE `friend_list`
  ADD CONSTRAINT `friend_list_ibfk_1` FOREIGN KEY (`user_id_1`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `friend_list_ibfk_2` FOREIGN KEY (`user_id_2`) REFERENCES `users` (`Id`);

--
-- Constraints for table `friend_req_list`
--
ALTER TABLE `friend_req_list`
  ADD CONSTRAINT `friend_req_list_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `friend_req_list_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`Id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
