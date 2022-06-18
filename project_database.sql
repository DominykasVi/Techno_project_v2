-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 18, 2022 at 09:43 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image_link` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`id`, `name`, `image_link`) VALUES
(1, 'Bench Press', 'https://cdn-icons-png.flaticon.com/512/2548/2548440.png'),
(2, 'Squat', 'https://cdn-icons-png.flaticon.com/512/3043/3043290.png'),
(3, 'Push ups', 'https://cdn-icons-png.flaticon.com/512/5147/5147050.png'),
(4, 'Pull ups', 'https://cdn-icons-png.flaticon.com/512/5147/5147107.png'),
(5, 'Dumbbell curls', 'https://cdn-icons-png.flaticon.com/512/1545/1545440.png'),
(6, 'Sit ups', 'https://cdn-icons-png.flaticon.com/512/5147/5147183.png');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` bigint(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `location` varchar(30) NOT NULL,
  `people` int(5) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `exercise_id`, `location`, `people`, `status`, `date`) VALUES
(2, 1, 1, '', 1, 'Done', '0000-00-00'),
(3, 1, 1, '', 1, 'In progress', '0000-00-00'),
(4, 1, 1, '', 1, 'In progress', '0000-00-00'),
(7, 1, 1, 'home', 1, 'In progress', '0000-00-00'),
(8, 1, 1, ' ', 1, 'In progress', '0000-00-00'),
(9, 1, 1, 'home', 3, 'In progress', '0000-00-00'),
(10, 1, 2, 'Outside', 3, 'Done', '0000-00-00'),
(11, 1, 2, 'Home', 1, 'Done', '0000-00-00'),
(12, 1, 3, ' ', 1, 'Done', '0000-00-00'),
(13, 1, 3, ' ', 1, 'Not completed', '0000-00-00'),
(14, 1, 6, ' ', 1, 'Done', '0000-00-00'),
(15, 1, 3, ' ', 1, 'Done', '0000-00-00'),
(16, 1, 3, ' ', 1, 'Done', '0000-00-00'),
(17, 1, 4, ' ', 1, 'Not completed', '0000-00-00'),
(18, 1, 5, ' ', 1, 'Done', '0000-00-00'),
(19, 1, 6, ' ', 1, 'Not completed', '0000-00-00'),
(20, 2, 4, ' ', 1, 'Not completed', '0000-00-00'),
(21, 2, 6, ' ', 1, 'In progress', '0000-00-00'),
(22, 2, 6, ' ', 1, 'In progress', '0000-00-00'),
(23, 2, 4, ' ', 1, 'Not completed', '0000-00-00'),
(24, 1, 4, ' ', 1, 'Done', '2022-06-18'),
(25, 1, 4, ' ', 1, 'Done', '2022-06-18'),
(26, 1, 6, ' ', 1, 'In progress', '2022-06-18');

-- --------------------------------------------------------

--
-- Table structure for table `relationships`
--

CREATE TABLE `relationships` (
  `id` int(11) NOT NULL,
  `follower` int(11) NOT NULL,
  `following` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `relationships`
--

INSERT INTO `relationships` (`id`, `follower`, `following`) VALUES
(1, 4, 1),
(2, 2, 1),
(3, 3, 1),
(4, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `custom_id` varchar(30) NOT NULL,
  `image` varchar(200) NOT NULL,
  `height` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `custom_id`, `image`, `height`) VALUES
(1, 'user', 'user', 'user', 'pass', 'user#1', 'profile_pic.png', 181.5),
(2, 'cutie', 'cuteAlien', 'cutie', 'cutie', '', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQWb8K3oCadfjT91q1nyuzUHR4QjzVQYIDTvw&usqp=CAU', 60),
(3, 'yoda', 'babyYoda', 'yoda', 'yoda', '', 'https://media.vanityfair.com/photos/5eb06b3ec135d48f5b12097d/4:3/w_1116,h_837,c_limit/baby-yoda-craze.jpg', 120),
(4, 'cuteBot', 'Bot', 'bot', 'bot', '', 'https://cellularnews.com/wp-content/uploads/2020/05/58-star-wars-a-cute-bb-8-artwork-325x485.jpg', 90);

-- --------------------------------------------------------

--
-- Table structure for table `weights`
--

CREATE TABLE `weights` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `weight` double NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weights`
--

INSERT INTO `weights` (`id`, `user_id`, `weight`, `date`) VALUES
(1, 1, 87.5, '0000-00-00'),
(2, 1, 87.5, '0000-00-00'),
(3, 1, 20, '2022-06-01'),
(4, 1, 40, '2022-06-13'),
(5, 1, 87.5, '2022-06-13'),
(6, 1, 33, '2022-06-13'),
(7, 1, 22, '2022-06-13'),
(8, 1, 12, '2022-06-13'),
(9, 1, 22, '2022-06-13'),
(10, 1, 85, '2022-06-13'),
(11, 1, 87, '2022-06-16'),
(12, 2, 30, '2022-06-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exercise_id` (`user_id`);

--
-- Indexes for table `relationships`
--
ALTER TABLE `relationships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follower` (`follower`),
  ADD KEY `following` (`following`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weights`
--
ALTER TABLE `weights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `relationships`
--
ALTER TABLE `relationships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `weights`
--
ALTER TABLE `weights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `exercise_id` FOREIGN KEY (`user_id`) REFERENCES `exercises` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `relationships`
--
ALTER TABLE `relationships`
  ADD CONSTRAINT `follower` FOREIGN KEY (`follower`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `following` FOREIGN KEY (`following`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `weights`
--
ALTER TABLE `weights`
  ADD CONSTRAINT `users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
