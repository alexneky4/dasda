-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2023 at 06:15 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emof`
--

-- --------------------------------------------------------

--
-- Table structure for table `component-responses`
--

DROP TABLE IF EXISTS `component-responses`;
CREATE TABLE `component-responses` (
  `component_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `emotion` text NOT NULL,
  `description` text DEFAULT NULL,
  `response_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `component-responses`
--

INSERT INTO `component-responses` (`component_id`, `user_id`, `emotion`, `description`, `response_date`) VALUES
(39, 2, 'pensiveness', '', '2023-06-19 06:07:25'),
(40, 2, 'contempt', '', '2023-06-19 06:07:25');

-- --------------------------------------------------------

--
-- Table structure for table `components-images`
--

DROP TABLE IF EXISTS `components-images`;
CREATE TABLE `components-images` (
  `component_id` int(11) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `components-images`
--

INSERT INTO `components-images` (`component_id`, `path`) VALUES
(39, '11-Romania-component-1-image-0.jpg'),
(39, '11-Romania-component-1-image-1.jpg'),
(39, '11-Romania-component-1-image-2.jpg'),
(40, '11-Romania-component-2-image-0.jpg'),
(40, '11-Romania-component-2-image-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `form-images`
--

DROP TABLE IF EXISTS `form-images`;
CREATE TABLE `form-images` (
  `form_id` int(11) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form-images`
--

INSERT INTO `form-images` (`form_id`, `path`) VALUES
(133, '11-Romania-image-0.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `form-responses`
--

DROP TABLE IF EXISTS `form-responses`;
CREATE TABLE `form-responses` (
  `form_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `emotion` text DEFAULT NULL,
  `description` text NOT NULL,
  `response_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form-responses`
--

INSERT INTO `form-responses` (`form_id`, `user_id`, `emotion`, `description`, `response_date`) VALUES
(124, 2, 'love', 'I love the cat!', '2023-06-19 06:57:12'),
(133, 2, 'acceptance', '', '2023-06-19 06:07:25');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `ending_date` datetime NOT NULL,
  `public_stats` tinyint(1) NOT NULL,
  `show_after_exp` tinyint(1) NOT NULL,
  `main_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`, `description`, `user_id`, `ending_date`, `public_stats`, `show_after_exp`, `main_image`) VALUES
(124, 'My cat', 'Hello! This is my cat, Luna! She will be soon 1 year old and I am curious to see what you think about her!', 1, '2023-06-22 05:33:00', 1, 1, '1-My cat-main-image.jpg'),
(133, 'Romania', 'Descriptie Romania', 11, '2023-06-24 06:06:00', 1, 1, '11-Romania-main-image.png');

-- --------------------------------------------------------

--
-- Table structure for table `form_components`
--

DROP TABLE IF EXISTS `form_components`;
CREATE TABLE `form_components` (
  `id` int(11) NOT NULL,
  `form_id` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_components`
--

INSERT INTO `form_components` (`id`, `form_id`, `name`, `description`) VALUES
(39, 133, 'Food', 'Descriptie Food'),
(40, 133, 'Terrain', '');

-- --------------------------------------------------------

--
-- Table structure for table `form_tags`
--

DROP TABLE IF EXISTS `form_tags`;
CREATE TABLE `form_tags` (
  `form_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_tags`
--

INSERT INTO `form_tags` (`form_id`, `tag_id`) VALUES
(124, 6),
(125, 4),
(131, 1),
(133, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(1, 'Games'),
(2, 'Cars'),
(3, 'Phones'),
(4, 'Countries'),
(6, 'Animals');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(25) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `profile_picture_path` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `gender`, `date_of_birth`, `country`, `phone_number`, `is_admin`, `profile_picture_path`) VALUES
(0, 'Anonym', 'asdsadf123e23easdasxc213e213e', 'anonym@gmail.com', 'Male', '2013-06-07', 'Romania', NULL, 0, NULL),
(1, 'Razvan', '$2y$10$dd2LJJTydSPMHBS9DaRo.ecOq32sB2xO2/mcjlDWGuT097QavjEsO', 'apetreirazvane@gmail.com', 'Male', '2023-06-13', 'Romania', NULL, 1, '1_profile_picture.gif'),
(2, 'test', '$2y$10$eXVuxPZ/X/b2VkCozOcfn.l3DvW1lNEaj10zvgNWSEixvgNuQyj3C', 'test@yahoo.com', 'Male', '2023-06-07', 'China', NULL, 1, '2_profile_picture.png'),
(4, 'test1', '$2y$10$gZYYeb1qAGEb9eXYlI7c0.CgllYXwnwnLIZoyOW8GfVvnkSB.bYCa', 'test1@yahoo.com', 'Male', '2023-06-08', 'Taiwan', NULL, 0, NULL),
(5, 'test4', '$2y$10$bdJFaAOkfEAAP6acgRP58.Gy0kjEqOIJGk3qhUDo5gSp57CK9xGfK', 'test4@yahoo.com', 'Male', '2023-06-07', 'Angola', NULL, 0, NULL),
(6, 'admin', '$2y$10$VM872UrhQpOTUdqrqGzbp.e3lNbBeegjdfZ4feP1FUtatDvu1G6YK', 'admin@yahoo.com', 'Male', '2004-02-04', 'United States of America', NULL, 1, NULL),
(8, 'Toni', '$2y$10$aCGePV2KrJlZoxzLCXVmxuBt33ijGDSthDK21Er.ovusgOZR3NplO', 'ddumitru128@gmail.com', 'Male', '2023-06-21', 'Romania', NULL, 0, NULL),
(10, 'new', '$2y$10$.bL/N5oT7leLCisjnDY6he3YH09YddJYSEefvDaXqyLQytSyDzaJy', 'new@yahoo.com', 'Male', '2023-06-15', 'Albania', NULL, 0, NULL),
(12, 'ANDREI', '$2y$10$IsVRFw3Ie9c76JrISCHcOOE9d0vAqbRRpJeJ04IZHoSZ5QrvT8hr2', 'andrei@yahoo.com', 'Male', '2023-06-15', 'Algeria', NULL, 0, NULL),
(13, 'Alexandru', '$2y$10$u6rbiuuv4f..d7S7rzpEnuvlOzNJrV9pjLTeu7PR2F4/pnxwj7Y/u', 'alexandru@yahoo.com', 'Male', '2023-06-14', 'Antigua and Barbuda', NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form-responses`
--
ALTER TABLE `form-responses`
  ADD PRIMARY KEY (`form_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_components`
--
ALTER TABLE `form_components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
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
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `form_components`
--
ALTER TABLE `form_components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `form-responses`
--
ALTER TABLE `form-responses`
  ADD CONSTRAINT `form-responses_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`),
  ADD CONSTRAINT `form-responses_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
