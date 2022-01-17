-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2022 at 06:11 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospitalmanagementsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments_doctor`
--

CREATE TABLE `appointments_doctor` (
  `id` tinyint(4) NOT NULL,
  `day` varchar(20) NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time NOT NULL,
  `doctors_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments_doctor`
--

INSERT INTO `appointments_doctor` (`id`, `day`, `from_time`, `to_time`, `doctors_id`) VALUES
(2, 'Dante Wise', '09:52:00', '08:28:00', 18);

-- --------------------------------------------------------

--
-- Table structure for table `doctor-more-info`
--

CREATE TABLE `doctor-more-info` (
  `id` tinyint(4) NOT NULL,
  `title` char(100) NOT NULL,
  `specialize_id` tinyint(4) NOT NULL,
  `doctor_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` tinyint(4) NOT NULL,
  `patient_id` tinyint(4) NOT NULL,
  `appoint_doctor_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(4) NOT NULL,
  `title` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`) VALUES
(1, 'admin'),
(2, 'doctor'),
(3, 'patient');

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` tinyint(4) NOT NULL,
  `specialize` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` tinyint(4) NOT NULL,
  `name` char(150) NOT NULL,
  `gender` tinyint(1) NOT NULL COMMENT '"1 for male, 2 for female" ',
  `email` char(100) NOT NULL,
  `password` char(100) NOT NULL,
  `address` char(150) NOT NULL,
  `phone` char(11) NOT NULL,
  `emergencyPhone` char(11) NOT NULL,
  `image` char(150) DEFAULT NULL,
  `role_id` tinyint(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `email`, `password`, `address`, `phone`, `emergencyPhone`, `image`, `role_id`) VALUES
(18, 'Laith Sears', 1, 'jizataco@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'Laboris non omnis be', '01012345678', '01012345678', '16423702901032000074.png', 2),
(19, 'a', 1, 'a@a.a', '96e79218965eb72c92a549dd5a330112', 'assssssssssssssssssssssssssssdasds', '01012345678', '01012345678', '16424364852011755626.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments_doctor`
--
ALTER TABLE `appointments_doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctors_id`);

--
-- Indexes for table `doctor-more-info`
--
ALTER TABLE `doctor-more-info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctorUserRelation` (`doctor_id`),
  ADD KEY `specialize` (`specialize_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appoint_patient_id` (`patient_id`),
  ADD KEY `appoint_doctor_id` (`appoint_doctor_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments_doctor`
--
ALTER TABLE `appointments_doctor`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctor-more-info`
--
ALTER TABLE `doctor-more-info`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments_doctor`
--
ALTER TABLE `appointments_doctor`
  ADD CONSTRAINT `appoint_doctor_relation` FOREIGN KEY (`doctors_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `doctor-more-info`
--
ALTER TABLE `doctor-more-info`
  ADD CONSTRAINT `doctorSpecializeRelation` FOREIGN KEY (`specialize_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `doctorUserRelation` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `appointDoctorRelation` FOREIGN KEY (`appoint_doctor_id`) REFERENCES `appointments_doctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointpatientRelation` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `role_relation` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
