-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 02:04 AM
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
-- Database: `classroom_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `post_id` int(11) NOT NULL,
  `class_code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `starting_date` date NOT NULL,
  `starting_time` time NOT NULL,
  `deadline_date` date NOT NULL,
  `deadline_time` time NOT NULL,
  `points` int(11) NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`post_id`, `class_code`, `created_at`, `starting_date`, `starting_time`, `deadline_date`, `deadline_time`, `points`, `status`) VALUES
(95, 'poYZ9bje', '2024-12-05 14:23:09', '2024-12-04', '12:00:00', '2024-11-09', '23:00:00', 100, ''),
(97, 'poYZ9bje', '2024-12-05 14:23:09', '2024-12-04', '12:00:00', '2024-11-09', '22:00:00', 100, ''),
(100, 'poYZ9bje', '2024-12-05 14:23:09', '2024-12-04', '12:00:00', '2024-11-09', '23:00:00', 100, ''),
(103, 'a8fuS3pm', '2024-12-05 14:23:09', '2024-12-04', '12:00:00', '2024-11-28', '12:00:00', 100, ''),
(402, 'a8fuS3pm', '2024-12-05 14:23:09', '2024-12-04', '12:00:00', '2024-12-03', '12:00:00', 100, ''),
(474, 'a8fuS3pm', '2024-12-05 14:23:09', '2024-12-04', '12:00:00', '2024-12-04', '12:00:00', 100, ''),
(483, 'a8fuS3pm', '2024-12-05 14:23:09', '2024-12-04', '12:00:00', '2024-12-04', '13:00:00', 100, ''),
(511, 'dh0bl51M', '2024-12-05 14:23:09', '2024-12-04', '12:00:00', '2024-12-05', '14:00:00', 100, ''),
(520, '0Uw1oZqr', '2024-12-05 14:23:09', '2024-12-04', '12:00:00', '2024-12-05', '15:00:00', 100, ''),
(521, '0Uw1oZqr', '2024-12-05 14:23:09', '2024-12-04', '12:00:00', '2024-12-06', '12:00:00', 100, ''),
(556, '3fCPK434', '2024-12-05 14:23:09', '2024-12-04', '12:00:00', '2024-12-26', '12:00:00', 1, 'Pending'),
(573, 'WzapuE0Y', '2024-12-06 10:13:44', '0000-00-00', '00:00:00', '2024-12-19', '12:00:00', 1, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `class_code` varchar(20) NOT NULL,
  `status` int(2) NOT NULL,
  `answer_text` varchar(500) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `class_code` varchar(15) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`class_code`, `user_id`, `status`, `date`) VALUES
('3fCPK434', 6, 'Absent', '2024-11-23'),
('3fCPK434', 15, 'Absent', '2024-11-23'),
('3fCPK434', 16, 'Present', '2024-11-23'),
('3fCPK434', 17, 'Absent', '2024-11-23'),
('WzapuE0Y', 6, 'Present', '2024-11-23'),
('WzapuE0Y', 9, 'Present', '2024-11-23'),
('WzapuE0Y', 15, 'Present', '2024-11-23'),
('p9Qzj1Hi', 15, 'Late', '2024-11-23'),
('p9Qzj1Hi', 26, 'Late', '2024-11-23'),
('vZdXuBkk', 3, 'Absent', '2024-11-23'),
('vZdXuBkk', 20, 'Present', '2024-11-23'),
('3fCPK434', 6, 'Absent', '2024-11-28'),
('3fCPK434', 15, 'Late', '2024-11-28'),
('3fCPK434', 16, 'Late', '2024-11-28'),
('3fCPK434', 17, 'Present', '2024-11-28'),
('rB0wd5Ao', 6, 'Absent', '2024-11-28'),
('rB0wd5Ao', 9, 'Present', '2024-11-28'),
('rB0wd5Ao', 15, 'Present', '2024-11-28'),
('rB0wd5Ao', 20, 'Absent', '2024-11-28'),
('3fCPK434', 6, 'Absent', '2024-12-02'),
('3fCPK434', 15, 'Present', '2024-12-02'),
('3fCPK434', 16, 'Absent', '2024-12-02'),
('3fCPK434', 17, 'Absent', '2024-12-02'),
('3fCPK434', 6, 'Present', '2024-12-05'),
('3fCPK434', 15, 'Present', '2024-12-05'),
('3fCPK434', 16, 'Present', '2024-12-05'),
('3fCPK434', 17, 'Absent', '2024-12-05'),
('a8fuS3pm', 15, 'Present', '2024-12-06'),
('3fCPK434', 6, 'Present', '2024-12-06'),
('3fCPK434', 15, 'Absent', '2024-12-06'),
('3fCPK434', 16, 'Present', '2024-12-06'),
('3fCPK434', 17, 'Absent', '2024-12-06');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_num` int(11) NOT NULL,
  `class_code` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `class_teacher` varchar(100) NOT NULL,
  `class_schedule` varchar(100) NOT NULL,
  `class_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_num`, `class_code`, `user_id`, `class_name`, `class_teacher`, `class_schedule`, `class_status`) VALUES
(1, '3fCPK434', 2, 'Java Programming', 'Kang Haerin', '(Wednesday) 02:00 PM-03:00 PM', 'Active'),
(2, 'WzapuE0Y', 2, 'Introduction to Computing', 'Kang Haerin', '(Monday) 02:00 PM-06:00 PM', 'Active'),
(3, 'rB0wd5Ao', 29, 'Data Structures and Algorithm', 'Sir Victor Aquino', '(Thursday) 03:00 AM-04:00 PM', 'Active'),
(4, '0Uw1oZqr', 2, 'C Programming', 'Kang Haerin', '(Tuesday) 03:20 PM-06:50 PM', 'Active'),
(5, 'D3Ue732A', 8, 'Object Oriented Programming', 'Kim Minjeong', '(Monday) 01:30 PM-02:30 PM', 'Active'),
(6, '8fq825Qh', 13, 'Python Programming', 'Wonyoung Jang', '(Saturday) 01:10 AM-02:30 AM', 'Active'),
(7, 'p9Qzj1Hi', 2, 'Web Development', 'Kang Haerin', '(Monday) 04:00 AM-06:00 AM', 'Active'),
(8, '3276p5QF', 19, 'Chemistry', 'Aeri Uchinaga', '(Wednesday) 04:30 PM-06:30 PM', 'Active'),
(9, 'ZidrF63Z', 19, 'Physics', 'Aeri Uchinaga', '(Monday) 04:10 PM-06:30 PM', 'Active'),
(10, 'sn9hTfqD', 1, 'Biology', 'Ning Yizhuo', '(Thursday) 04:10 PM-06:30 PM', 'Active'),
(11, '4S90t60w', 19, 'English', 'Aeri Uchinaga', '(Monday) 03:50 PM-06:00 PM', 'Active'),
(12, '7Ym4B5NH', 1, 'System Fundamentals', 'Ning Yizhuo', '(Tuesday) 06:00 PM-06:20 PM', 'Active'),
(13, 'a8fuS3pm', 2, 'Integral Calculus', 'Kang Haerin', '(Sunday) 04:10 PM-06:30 PM', 'Active'),
(14, 'vZdXuBkk', 2, 'Application Development', 'Kim Minjeong', '(Friday) 04:30 PM-06:30 PM', 'Active'),
(15, 'd9BU7610', 2, 'Networking', 'Kang Haerin', '(Wednesday) 04:10 PM-06:30 PM', 'Active'),
(16, 'dh0bl51M', 8, 'Digital Circuit', 'Kang Haerin', '(Friday) 04:10 PM-06:30 PM', 'Active'),
(17, 'poYZ9bje', 2, 'Discrete Mathematics', 'Kang Haerin', '(Sunday) 01:10 PM-06:30 PM', 'Active'),
(18, 'Zk7FlOWD', 1, 'Physical Education', 'Ning Yizhuo', '(Thursday) 02:20 PM-07:50 PM', 'Active'),
(19, '65j225v7', 13, 'Algebra', 'Wonyoung Jang', '(Monday) 01:00 PM-03:00 PM', 'Active'),
(20, 'Nw6A245U', 13, 'Software Engineer I', 'Wonyoung Jang', '(Monday) 01:00 PM-05:00 PM', 'Active'),
(21, 'QCLM69nl', 13, 'Software Engineer II', 'Wonyoung Jang', '(Wednesday) 05:10 PM-08:00 PM', 'Active'),
(22, 'U0kKYmjs', 1, 'History', 'Ning Yizhuo', '(Wednesday) 02:40 PM-04:50 PM', 'Active'),
(27, '792F7DpJ', 1, 'Vocal Class', 'Ning Yizhuo', '(Saturday) 10:01 AM-03:01 PM', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`post_id`, `user_id`, `class_code`, `name`, `comment`, `created_at`) VALUES
(61, 15, 'WzapuE0Y', 'Hanni Pham', 'Test', '2024-11-30 14:18:05'),
(61, 15, 'WzapuE0Y', 'Hanni Pham', 'test', '2024-11-30 14:18:05'),
(61, 15, 'WzapuE0Y', 'Hanni Pham', 'Test', '2024-11-30 14:18:05'),
(65, 15, 'WzapuE0Y', 'Hanni Pham', 'Test', '2024-11-30 14:18:05'),
(41, 2, 'vZdXuBkk', 'Kang Haerin', 'TEST', '2024-11-30 14:20:00'),
(41, 2, 'vZdXuBkk', 'Kang Haerin', 'Multiple\nText\nIn\nOne \nComment', '2024-11-30 14:20:00'),
(41, 2, 'vZdXuBkk', 'Kang Haerin', '1', '2024-11-30 14:20:00'),
(41, 2, 'vZdXuBkk', 'Kang Haerin', '3', '2024-11-30 14:20:00'),
(41, 2, 'vZdXuBkk', 'Kang Haerin', '4', '2024-11-30 14:20:00'),
(41, 2, 'vZdXuBkk', 'Kang Haerin', 'Text\nTwo\nThree', '2024-11-30 14:20:00'),
(75, 2, 'p9Qzj1Hi', 'Kang Haerin', 'Test', '2024-11-30 14:20:00'),
(75, 2, 'p9Qzj1Hi', 'Kang Haerin', 'Test', '2024-11-30 14:20:00'),
(75, 15, 'p9Qzj1Hi', 'Hanni Pham', 'C', '2024-11-30 14:18:05'),
(75, 2, 'p9Qzj1Hi', 'Kang Haerin', 'C', '2024-11-30 14:20:00'),
(75, 15, 'p9Qzj1Hi', 'Hanni Pham', 'E', '2024-11-30 14:18:05'),
(37, 2, '3fCPK434', 'Kang Haerin', 'Test', '2024-11-30 14:20:00'),
(37, 15, '3fCPK434', 'Hanni Pham', 'Test', '2024-11-30 14:18:05'),
(37, 2, '3fCPK434', 'Kang Haerin', 'Test', '2024-11-30 14:20:00'),
(37, 15, '3fCPK434', 'Hanni Pham', 'Test', '2024-11-30 14:18:05'),
(37, 15, '3fCPK434', 'Hanni Pham', 'Test', '2024-11-30 14:18:05'),
(44, 2, '3fCPK434', 'Kang Haerin', 'Test', '2024-11-30 14:20:00'),
(44, 15, '3fCPK434', 'Hanni Pham', 'Test', '2024-11-30 14:18:05'),
(44, 15, '3fCPK434', 'Hanni Pham', 'C', '2024-11-30 14:18:05'),
(44, 15, '3fCPK434', 'Hanni Pham', 'Test', '2024-11-30 14:18:05'),
(44, 15, '3fCPK434', 'Hanni Pham', 'Test', '2024-11-30 14:18:05'),
(44, 15, '3fCPK434', 'Hanni Pham', 'tEST', '2024-11-30 14:18:05'),
(44, 2, '3fCPK434', 'Kang Haerin', 'Test', '2024-11-30 14:20:00'),
(50, 15, '3fCPK434', 'Hanni Pham', 'Comment', '2024-11-30 14:18:05'),
(50, 2, '3fCPK434', 'Kang Haerin', 'Comment', '2024-11-30 14:20:00'),
(48, 15, '3fCPK434', 'Hanni Pham', 'TEST', '2024-11-30 14:18:05'),
(48, 2, '3fCPK434', 'Kang Haerin', 'tEST', '2024-11-30 14:20:00'),
(48, 15, '3fCPK434', 'Hanni Pham', 'tEST', '2024-11-30 14:18:05'),
(44, 2, '3fCPK434', 'Kang Haerin', 'tEST', '2024-11-30 14:20:00'),
(44, 2, '3fCPK434', 'Kang Haerin', 'qwq', '2024-11-30 14:20:00'),
(35, 15, '3fCPK434', 'Hanni Pham', 'Comment 1', '2024-11-30 14:18:05'),
(35, 2, '3fCPK434', 'Kang Haerin', 'Comment 2', '2024-11-30 14:20:00'),
(35, 15, '3fCPK434', 'Hanni Pham', 'Comment 3', '2024-11-30 14:18:05'),
(104, 2, 'a8fuS3pm', 'Kang Haerin', 'Test', '2024-11-30 14:20:00'),
(104, 15, 'a8fuS3pm', 'Hanni Pham', 'Test', '2024-11-30 14:18:05'),
(78, 2, '3fCPK434', 'Kang Haerin', 'Comment', '2024-11-30 14:20:00'),
(44, 2, '3fCPK434', 'Kang Haerin', 'Test', '2024-11-30 14:20:00'),
(38, 2, 'a8fuS3pm', 'Kang Haerin', 'Comment 1', '2024-11-30 14:20:00'),
(497, 2, '3fCPK434', 'Kang Haerin', 'Test1', '2024-12-04 01:32:53'),
(505, 2, '3fCPK434', 'Kang Haerin', 'ANOTHER LESSON 8', '2024-12-04 01:34:16'),
(504, 2, '3fCPK434', 'Kang Haerin', 'ORIG LESSON 8', '2024-12-04 01:34:41'),
(504, 2, '3fCPK434', 'Kang Haerin', 'Test', '2024-12-04 01:34:58'),
(44, 15, '3fCPK434', 'Hanni Pham', 'wq', '2024-12-04 01:53:55'),
(35, 15, '3fCPK434', 'Hanni Pham', 'test', '2024-12-04 02:04:28'),
(35, 15, '3fCPK434', 'Hanni Pham', 'Test', '2024-12-04 02:06:00'),
(504, 15, '3fCPK434', 'Hanni Pham', 'Test', '2024-12-04 02:06:24'),
(504, 15, '3fCPK434', 'Hanni Pham', 'Test', '2024-12-04 02:07:43'),
(504, 15, '3fCPK434', 'Hanni Pham', 'Another lesson', '2024-12-04 02:08:26'),
(504, 15, '3fCPK434', 'Hanni Pham', 'q', '2024-12-04 02:09:05'),
(504, 15, '3fCPK434', 'Hanni Pham', 'q', '2024-12-04 02:10:28'),
(36, 15, '0Uw1oZqr', 'Hanni Pham', 'q', '2024-12-04 02:11:19'),
(36, 15, '0Uw1oZqr', 'Hanni Pham', 'W', '2024-12-04 02:11:27'),
(36, 15, '0Uw1oZqr', 'Hanni Pham', 'e', '2024-12-04 02:11:30'),
(36, 2, '0Uw1oZqr', 'Kang Haerin', 'Test', '2024-12-04 02:11:47'),
(39, 2, 'WzapuE0Y', 'Kang Haerin', 'Test', '2024-12-04 02:23:38'),
(39, 15, 'WzapuE0Y', 'Hanni Pham', 'Test', '2024-12-04 02:23:41'),
(39, 15, 'WzapuE0Y', 'Hanni Pham', 'test', '2024-12-04 02:23:55'),
(39, 15, 'WzapuE0Y', 'Hanni Pham', 'Q', '2024-12-04 02:24:03'),
(39, 2, 'WzapuE0Y', 'Kang Haerin', 'Q', '2024-12-04 02:24:15'),
(68, 15, 'WzapuE0Y', 'Hanni Pham', 'q', '2024-12-04 02:25:03'),
(68, 15, 'WzapuE0Y', 'Hanni Pham', 'w', '2024-12-04 02:25:09'),
(39, 2, 'WzapuE0Y', 'Kang Haerin', 'Q', '2024-12-04 02:25:31'),
(68, 15, 'WzapuE0Y', 'Hanni Pham', 'Q', '2024-12-04 02:26:11'),
(68, 15, 'WzapuE0Y', 'Hanni Pham', 'E', '2024-12-04 02:27:41'),
(68, 15, 'WzapuE0Y', 'Hanni Pham', 'w', '2024-12-04 02:28:54'),
(68, 15, 'WzapuE0Y', 'Hanni Pham', 'r', '2024-12-04 02:29:23'),
(407, 15, 'a8fuS3pm', 'Hanni Pham', 'A', '2024-12-04 02:33:22'),
(407, 15, 'a8fuS3pm', 'Hanni Pham', 'A', '2024-12-04 02:33:25'),
(32, 15, 'WzapuE0Y', 'Hanni Pham', 'Test', '2024-12-04 02:39:28'),
(32, 15, 'WzapuE0Y', 'Hanni Pham', 'Q', '2024-12-04 02:39:55'),
(32, 15, 'WzapuE0Y', 'Hanni Pham', 'w', '2024-12-04 02:41:16'),
(32, 15, 'WzapuE0Y', 'Hanni Pham', 'q', '2024-12-04 02:43:03'),
(44, 2, '3fCPK434', 'Kang Haerin', 'TEST', '2024-12-04 02:43:49'),
(44, 2, '3fCPK434', 'Kang Haerin', 'W', '2024-12-04 02:43:54'),
(44, 2, '3fCPK434', 'Kang Haerin', 'W', '2024-12-04 02:44:39'),
(44, 2, '3fCPK434', 'Kang Haerin', 'C', '2024-12-04 02:45:03'),
(44, 2, '3fCPK434', 'Kang Haerin', 'qw', '2024-12-04 02:45:41'),
(44, 2, '3fCPK434', 'Kang Haerin', 'qw', '2024-12-04 02:46:03'),
(68, 2, 'WzapuE0Y', 'Kang Haerin', 'Test', '2024-12-04 02:46:30'),
(39, 15, 'WzapuE0Y', 'Hanni Pham', 'q', '2024-12-04 02:46:37'),
(39, 2, 'WzapuE0Y', 'Kang Haerin', 'TEST', '2024-12-04 02:46:46'),
(39, 15, 'WzapuE0Y', 'Hanni Pham', 'Q', '2024-12-04 02:46:51'),
(32, 15, 'WzapuE0Y', 'Hanni Pham', 'AS', '2024-12-04 02:49:16'),
(43, 15, '3fCPK434', 'Hanni Pham', 'A', '2024-12-04 11:22:23'),
(60, 15, 'WzapuE0Y', 'Hanni Pham', 'Test', '2024-12-04 11:37:56'),
(442, 15, 'WzapuE0Y', 'Hanni Pham', 'TEST', '2024-12-04 16:01:07'),
(442, 15, 'WzapuE0Y', 'Hanni Pham', 'test2', '2024-12-04 16:01:15'),
(442, 15, 'WzapuE0Y', 'Hanni Pham', 'test2', '2024-12-04 16:01:21'),
(528, 15, 'p9Qzj1Hi', 'Hanni Pham', 'Comment 1', '2024-12-05 03:51:15'),
(533, 15, 'a8fuS3pm', 'Hanni Pham', 'Test', '2024-12-06 07:05:09');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `class_code` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `google_drive_file_id` varchar(255) NOT NULL,
  `file_size` varchar(30) NOT NULL,
  `user_category` varchar(10) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `post_id`, `class_code`, `user_id`, `file_name`, `google_drive_file_id`, `file_size`, `user_category`, `created`) VALUES
(4, 511, 'dh0bl51M', 2, 'GROUP-3.pdf', '1uJ1rfZGz1yW5VL1o4X3842rlY6c3dkKR', '53 KB', '3', '2024-12-04 14:18:43'),
(5, 510, '3fCPK434', 2, '462562224_549093717989178_5624656158005881905_n.png', '1K3WREbBL9Im-zPrXO0VUDykHWZmy6lAT', '482 KB', '3', '2024-12-04 14:18:46'),
(6, 510, '3fCPK434', 2, '467020634_485152024548543_7691672434637080723_n.jpg', '12DctR7Cuur1SkbkV-EV941QlHtclLzx7', '47 KB', '3', '2024-12-04 14:19:07'),
(7, 510, '3fCPK434', 2, 'p2.php', '1VJor5N4ii98KzCPcjwAKU2_e5sDrl3oj', '20 KB', '3', '2024-12-04 14:19:07'),
(8, 510, '3fCPK434', 2, 'p2.php', '16JlWD6LFicu0jbPDBmUHDQXKqHZGCExv', '20 KB', '3', '2024-12-04 14:19:07'),
(9, 519, '3fCPK434', 2, 'GROUP-3.pdf', '1d90X4QVp6igeHgnSnojUwX97xbH6vzrT', '53 KB', '3', '2024-12-04 14:19:07'),
(10, 522, '0Uw1oZqr', 2, 'p2.php', '1hsAl02JJa9huoYrn9iBQQTpY4kVy0ALR', '20 KB', '3', '2024-12-04 14:19:07'),
(11, 523, '0Uw1oZqr', 2, 'GROUP-5-QUESTIONS-FINALS.docx', '1vYgWI6jm4wXJDdADBNkxhOD3CcfsDOJ7', '16 KB', '3', '2024-12-04 14:19:07'),
(12, 523, '0Uw1oZqr', 2, 'Linear-txt.txt', '12fDcKbtwPkh4YVuyiSitW8HsMHLZZgd2', '1 KB', '3', '2024-12-04 14:19:07'),
(13, 524, '0Uw1oZqr', 2, 'p2.php', '1I200PZINCmZEg9aYloMktPbNWDTLNI1L', '20 KB', '3', '2024-12-04 14:19:07'),
(14, 525, '0Uw1oZqr', 2, 'p2.php', '1Um3NMwYlRkaxe2GGnMCcY8Qz00q18Eee', '20 KB', '3', '2024-12-04 14:19:07'),
(15, 525, '0Uw1oZqr', 2, 'GROUP-3.pdf', '1toNkCvy1ehtE5CDsK6HczoNWw0BXCWLd', '53 KB', '3', '2024-12-04 14:19:07'),
(16, 526, 'd9BU7610', 2, 'p2.php', '1u2NUhs1O-f9j7yFYN1F0p4BzYfptLL4m', '20 KB', '3', '2024-12-04 14:19:07'),
(17, 526, 'd9BU7610', 2, 'GROUP-3.pdf', '163JdnBVz_pAHoHd8M9uxfbCkxouvsy8O', '53 KB', '3', '2024-12-04 14:19:07'),
(18, 527, '0Uw1oZqr', 2, 'classroom_db (7).sql', '1RHYT01y2CuX2MwayfWpi3eXeVQeiOUuu', '82 KB', '3', '2024-12-04 14:19:07'),
(19, 527, '0Uw1oZqr', 2, 'index.css', '1eXJjpAK-e_jRdWmyiCCBpwfe-FC4B7cd', '9 KB', '3', '2024-12-04 14:19:07'),
(20, 13, '0Uw1oZqr', 15, 'Linear-txt.txt', '1GZ_EFw5RqGId7Ivt0eKtB-Cbv74P4_JF', '3 KB', '4', '2024-12-04 14:50:24'),
(21, 34, 'WzapuE0Y', 15, 'Linear-txt.txt', '1ndErPXkxVoKITgjIUBeXPinYz6Vx8nyj', '3 KB', '4', '2024-12-04 16:32:16'),
(22, 0, 'a8fuS3pm', 15, 'classroom_db (8).sql', '1yqby2UxiwzbdNL-bni8IHFHsg5_V3OHr', '83 KB', '4', '2024-12-04 15:44:32'),
(23, 60, 'WzapuE0Y', 15, 'credentials.json', '1gQA8F6ecGiTfp6YL_-7dUfNPZ6ru7lPX', '1 KB', '4', '2024-12-04 16:29:28'),
(24, 7, 'WzapuE0Y', 15, 'me.png', '1tjMN2-pgaYYXDg5NLEPcHWN470nX7es3', '95 KB', '4', '2024-12-04 17:19:14'),
(25, 7, 'WzapuE0Y', 15, 'hanni.jpg', '1UutXsABILqM6Sa8Vf-BDnD8crXLAGgRs', '15 KB', '4', '2024-12-04 17:21:00'),
(26, 61, 'WzapuE0Y', 15, '2.jpeg', '1911GoKMfbPvTH9hhhEIy_Tso_8SD61tj', '41 KB', '4', '2024-12-04 17:27:22'),
(27, 51, '3fCPK434', 15, 'haerin.png', '1jH71Hg5AGeX9ndqw2B_IhY3c9nIQvl-u', '213 KB', '4', '2024-12-04 17:32:00'),
(28, 521, '0Uw1oZqr', 15, '462562224_549093717989178_5624656158005881905_n.png', '1jYajOyKMjODlZfeXW6EyaBgdqbdOxqep', '482 KB', '4', '2024-12-05 03:06:52'),
(29, 35, '3fCPK434', 15, 'class1.php', '1BMaWCnB4Xi7A7jv5WQvQHnzzySHCUJRC', '15 KB', '4', '2024-12-05 03:09:36'),
(30, 528, 'p9Qzj1Hi', 2, 'GROUP-3.pdf', '1DQJv46P9rUyLmuPhWsiRhDHxxrxMUcrG', '53 KB', '3', '2024-12-05 03:41:33'),
(31, 528, 'p9Qzj1Hi', 2, 'GROUP-5-QUESTIONS-FINALS.docx', '1fqtvUifB7Ig76UcIRhURQQ9IInTGV3Iv', '16 KB', '3', '2024-12-05 03:41:33'),
(32, 528, 'p9Qzj1Hi', 15, 'index.css', '1rh8ASyjqaqMX9gZL1ZaxXY_AO0siBZVp', '9 KB', '4', '2024-12-05 03:42:30'),
(59, 528, 'p9Qzj1Hi', 15, 'fpdf186 (1).zip', '1lhN4R6sWZBtShKXbRKkbvrN6PF_Tg7OP', '180 KB', '4', '2024-12-05 04:35:53'),
(60, 528, 'p9Qzj1Hi', 15, 'Speak.no.Evil.2024-en.srt', '1v8jWUHyqaR9mylVnat956mQxuS1ZNBDb', '121 KB', '4', '2024-12-05 04:35:53'),
(61, 35, '3fCPK434', 15, 'GROUP-3.pdf', '1NXoJMrP51OByjTIp78C6aGnOLGTTgCAH', '53 KB', '4', '2024-12-05 04:51:56'),
(62, 529, '3fCPK434', 2, 'GROUP-3.pdf', '17JxWBl2yyce5DrKdUX-K8DenWiqHKSf7', '53 KB', '3', '2024-12-05 05:06:02'),
(63, 529, '3fCPK434', 15, 'GROUP-3.pdf', '1SI-WG6LreFxvVKEK46jrHKnhM7cqIi0k', '53 KB', '4', '2024-12-05 05:07:55'),
(64, 483, 'a8fuS3pm', 15, 'GROUP-5-QUESTIONS-FINALS (1).docx', '1xOft9wuOf2dwRG6JglAabbFzQvxOdtmm', '16 KB', '4', '2024-12-05 05:54:33'),
(65, 483, 'a8fuS3pm', 15, 'post-form1.php', '1uIZfNNRYs6UzBQGTMn0mHneBMc75ODyC', '17 KB', '4', '2024-12-05 05:54:33'),
(66, 484, 'a8fuS3pm', 15, 'post-form1.php', '1ncE3WvoB3FSg8uhH74YtUizW18i9DPS3', '17 KB', '4', '2024-12-05 05:57:32'),
(67, 483, 'a8fuS3pm', 15, 'p2.php', '1aP2gM4Abnrm9x8k9dd6SFkDggSjtQRsf', '20 KB', '4', '2024-12-05 06:02:33'),
(68, 530, 'd9BU7610', 2, 'Activity.pdf', '1dT6SOOtEeN8l9uHhTvx9DtmCzki_ipS9', '66 KB', '3', '2024-12-05 06:07:42'),
(69, 530, 'd9BU7610', 2, 'proof.png', '1n2Asa02-D1HCNQYbPOx2FcKVao7mL2K-', '58 KB', '3', '2024-12-05 06:07:42'),
(70, 531, 'd9BU7610', 2, 'p2.php', '1cUqbYitUuaTheasC5xILKyohW7rlSQ5I', '20 KB', '3', '2024-12-05 06:09:02'),
(71, 532, 'd9BU7610', 2, 'GROUP-3.pdf', '194S6vfcVzsvir6ZjHJaGiO94pvPZJFa9', '53 KB', '3', '2024-12-05 06:09:33'),
(72, 534, '3fCPK434', 2, 'GROUP-3.pdf', '1n8SSK7lCTI-Z8TTReSJwKOPUYRtUzLYG', '53 KB', '3', '2024-12-05 11:27:07'),
(73, 535, '3fCPK434', 2, 'class1.php', '1Jm-km9yfVWLYFBF7j8AtSQp2Cd-7rXGR', '15 KB', '3', '2024-12-05 12:16:25'),
(74, 535, '3fCPK434', 15, 'GROUP-3 (1).pdf', '1dgM578p29TZwN8IeBevyjN_awxlkWC6D', '53 KB', '4', '2024-12-05 12:40:34'),
(75, 551, '3fCPK434', 2, 'att.php', '19zRKSNW1O_xfFgj_5V6Ice7bBC20QMu2', '18 KB', '3', '2024-12-05 12:47:34'),
(76, 553, '3fCPK434', 2, 'index.css', '118UETJviDcY7nE4eCBI9sSKvAl6OYt2q', '9 KB', '3', '2024-12-05 12:56:03'),
(77, 556, '3fCPK434', 15, 'classes.php', '1XvS91gKKaJgVGv3t8vsfZDkooa_B-46Z', '40 KB', '4', '2024-12-05 13:42:48'),
(78, 556, '3fCPK434', 15, 'Xd35Kw_5f.jpg', '1d7B4aIvyBfNufuhLozCyGYLzNvfEMbwn', '88 KB', '4', '2024-12-05 13:42:48'),
(79, 483, 'a8fuS3pm', 15, '462562224_549093717989178_5624656158005881905_n.png', '1E4EscMuMr_2rQR4f4ED-qOzAFuUICACm', '482 KB', '4', '2024-12-07 09:48:17'),
(80, 586, '3fCPK434', 2, 'classroom_db (5).sql', '1BNhq_k-GXnlt4LjOn21RDWNe0SBDYcmu', '50 KB', '3', '2024-12-07 10:43:37'),
(81, 586, '3fCPK434', 2, '2. TOPCIT Application Manual(20241028) (1).pdf', '1CipNx-0RdpivK6au5-c21_8x3MN8mK-H', '2 MB', '3', '2024-12-07 10:43:37');

-- --------------------------------------------------------

--
-- Table structure for table `join_class`
--

CREATE TABLE `join_class` (
  `user_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `class_code` varchar(10) NOT NULL,
  `class_num` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `join_class`
--

INSERT INTO `join_class` (`user_id`, `name`, `class_code`, `class_num`) VALUES
(6, 'Seulgi Kang', '3fCPK434', 1),
(6, 'Seulgi Kang', 'WzapuE0Y', 2),
(6, 'Seulgi Kang', 'rB0wd5Ao', 3),
(6, 'Seulgi Kang', 'D3Ue732A', 5),
(9, 'Haewon Oh', 'WzapuE0Y', 2),
(9, 'Haewon Oh', 'rB0wd5Ao', 3),
(9, 'Haewon Oh', 'D3Ue732A', 5),
(9, 'Haewon Oh', 'poYZ9bje', 17),
(20, 'Gaeul Lee', 'sn9hTfqD', 10),
(20, 'Gaeul Lee', 'vZdXuBkk', 14),
(20, 'Gaeul Lee', 'ZidrF63Z', 9),
(20, 'Gaeul Lee', 'rB0wd5Ao', 3),
(9, 'Haewon Oh', 'Zk7FlOWD', 18),
(15, 'Hanni Pham', 'D3Ue732A', 5),
(15, 'Hanni Pham', 'rB0wd5Ao', 3),
(5, 'Seulgi Kang', 'D3Ue732A', 5),
(15, 'Hanni Pham', '3fCPK434', 1),
(15, 'Hanni Pham', 'WzapuE0Y', 2),
(15, 'Hanni Pham', 'p9Qzj1Hi', 7),
(17, 'Minji Kim', '3fCPK434', 1),
(16, 'Danielle Marsh', '3fCPK434', 1),
(26, 'Jihyo Park', 'p9Qzj1Hi', 7),
(15, 'Hanni Pham', 'ZidrF63Z', 9),
(15, 'Hanni Pham', 'a8fuS3pm', 13),
(15, 'Hanni Pham', '0Uw1oZqr', 4),
(16, 'Danielle Marsh', '0Uw1oZqr', 4);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `question_id`, `option_text`) VALUES
(1, 1, 'A'),
(2, 1, 'B'),
(3, 1, 'C'),
(4, 1, 'D'),
(5, 3, 'True'),
(6, 3, 'False'),
(7, 4, ''),
(8, 4, ''),
(9, 5, 'A'),
(10, 5, 'B'),
(11, 5, 'C'),
(12, 7, 'True'),
(13, 7, 'False'),
(14, 9, 'Choice A'),
(15, 9, 'Choice B'),
(16, 9, 'Choice C'),
(17, 11, 'True'),
(18, 11, 'False'),
(19, 12, 'A'),
(20, 12, 'B'),
(21, 12, 'C'),
(22, 12, 'D'),
(23, 13, 'CHOICE A'),
(24, 13, 'Choice B'),
(25, 13, 'Choice C'),
(26, 13, 'Choice D'),
(27, 14, 'True'),
(28, 14, 'False'),
(29, 16, 'TEST A'),
(30, 16, 'TEST B'),
(31, 17, 'Q'),
(32, 17, 'A'),
(33, 18, 'A'),
(34, 18, 'B'),
(35, 19, 'A'),
(36, 20, 'B'),
(40, 23, 'True'),
(41, 23, 'False'),
(42, 13, 'C'),
(53, 26, 'BB'),
(54, 26, 'AA'),
(55, 27, 'AA'),
(56, 27, 'BB'),
(57, 27, 'CC'),
(58, 27, 'DD'),
(62, 23, 'True'),
(64, 23, 'True'),
(66, 23, 'True'),
(68, 23, 'True'),
(69, 23, 'False'),
(75, 23, 'True'),
(76, 23, 'False'),
(77, 23, 'True'),
(78, 23, 'False'),
(79, 23, 'True'),
(80, 23, 'False'),
(81, 23, 'True'),
(82, 23, 'False'),
(83, 23, 'True'),
(84, 23, 'False'),
(85, 23, 'True'),
(86, 23, 'False'),
(87, 23, 'True'),
(88, 23, 'False'),
(89, 23, 'True'),
(90, 23, 'False'),
(91, 23, 'True'),
(92, 23, 'False'),
(93, 23, 'True'),
(94, 23, 'False'),
(95, 23, 'True'),
(96, 23, 'False'),
(97, 23, 'True'),
(98, 23, 'False'),
(99, 23, 'True'),
(100, 23, 'False'),
(101, 23, 'True'),
(102, 23, 'False'),
(103, 23, 'True'),
(104, 23, 'False'),
(105, 32, 'A'),
(106, 32, 'B'),
(110, 33, 'True'),
(111, 33, 'False'),
(112, 34, 'BB'),
(113, 34, 'AA'),
(114, 35, 'Q'),
(116, 35, 'B'),
(117, 35, 'A'),
(118, 36, 'A'),
(119, 36, 'B'),
(120, 37, 'A'),
(121, 37, 'B'),
(124, 37, 'C'),
(125, 37, 'D'),
(126, 38, 'A'),
(127, 38, 'B'),
(128, 38, 'C'),
(129, 38, 'D'),
(130, 39, 'A'),
(131, 39, 'B'),
(132, 39, 'C'),
(133, 39, 'D'),
(134, 40, 'A'),
(135, 40, 'B'),
(138, 40, 'E'),
(139, 40, 'F'),
(140, 41, 'A'),
(141, 41, 'B'),
(144, 42, 'BC'),
(145, 42, 'DDD'),
(147, 43, 'BC'),
(148, 43, 'DDD'),
(149, 45, 'ASDAD'),
(150, 45, 'SADDA'),
(151, 47, 'True'),
(152, 47, 'False'),
(153, 48, 'a'),
(154, 48, 'b'),
(155, 48, 'c'),
(156, 50, 'a'),
(157, 50, 'b'),
(158, 51, 'A'),
(159, 53, 'A'),
(160, 54, 'True'),
(161, 54, 'False'),
(162, 55, 'True'),
(163, 55, 'False'),
(164, 56, 'ZX');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `class_code` varchar(20) NOT NULL,
  `prof_name` varchar(50) NOT NULL,
  `title` varchar(500) NOT NULL,
  `content_type` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `visibility` varchar(10) NOT NULL DEFAULT 'Visible',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `class_code`, `prof_name`, `title`, `content_type`, `content`, `visibility`, `created_at`) VALUES
(1, '7Ym4B5NH', 'Sir Vic', 'Material 1', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(2, '7Ym4B5NH', '[Sir Vic]', 'Material 2', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(3, '7Ym4B5NH', 'Sir Vic', 'Material 3', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(4, '7Ym4B5NH', 'Sir Vic', 'Material 4', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(5, '7Ym4B5NH', 'Sir Vic', 'Material 5', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(6, '7Ym4B5NH', 'Sir Vic', 'Material 6', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(7, '7Ym4B5NH', 'Sir Vic', 'Material 7', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(8, '4S90t60w', 'Sir Vic', 'Material 8', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(10, '4S90t60w', 'Sir Vic', 'Material 9', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(11, '4S90t60w', 'Sir Vic', 'Activity 1', 'Activity', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(12, '4S90t60w', 'Sir Vic', 'Quiz 1', 'Quiz', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(13, '4S90t60w', 'Sir Vic', 'Quiz 2', 'Quiz', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(14, '4S90t60w', 'Sir Vic', 'Quiz 3', 'Quiz', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(15, '4S90t60w', 'Sir Vic', 'Material 10', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(18, '7Ym4B5NH', 'Sir Vic', 'Quiz 1', 'Quiz', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-07 06:50:57'),
(32, 'WzapuE0Y', 'Kang Haerin', 'Material A', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(33, 'WzapuE0Y', 'Kang Haerin', 'Material B', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(34, 'WzapuE0Y', 'Kang Haerin', 'Activitity 1', 'Activity', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(36, '0Uw1oZqr', 'Kang Haerin', 'Material 1', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(40, '0Uw1oZqr', 'Kang Haerin', 'Activity 1', 'Activity', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(41, 'vZdXuBkk', 'Kang Haerin', 'Material 1', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(52, '0Uw1oZqr', 'Kang Haerin', 'Quiz 1', 'Quiz', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(53, '0Uw1oZqr', 'Kang Haerin', 'Quiz 2', 'Quiz', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(54, '0Uw1oZqr', 'Kang Haerin', 'Quiz 3', 'Quiz', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(60, 'WzapuE0Y', 'Kang Haerin', 'Activity 3', 'Activity', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(61, 'WzapuE0Y', 'Kang Haerin', 'Activity 2', 'Activity', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(62, 'WzapuE0Y', 'Kang Haerin', 'Activity 5', 'Activity', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(63, 'WzapuE0Y', 'Kang Haerin', 'Lesson 3', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(64, 'WzapuE0Y', 'Kang Haerin', 'Lesson 4', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(65, 'WzapuE0Y', 'Kang Haerin', 'Lesson 5', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(66, 'WzapuE0Y', 'Kang Haerin', 'Lesson 6', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(67, 'WzapuE0Y', 'Kang Haerin', 'Lesson 7', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(75, 'p9Qzj1Hi', 'Kang Haerin', 'Lesson 1', 'Material', 'LESSON DESCRIPTION GOES HERE', 'Visible', '2024-11-30 14:20:00'),
(76, 'p9Qzj1Hi', 'Kang Haerin', 'Lesson 2', 'Material', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(77, 'p9Qzj1Hi', 'Kang Haerin', 'Quiz 1', 'Quiz', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, culpa distinctio, tempore nulla in voluptas perferendis beatae saepe voluptates dolor sit similique dolore optio magnam amet harum. Asperiores velit laborum voluptatum est voluptate fuga nam corrupti inventore provident molestiae incidunt mollitia fugiat explicabo odio, et nesciunt, totam quaerat libero laboriosam. Expedita ut labore nisi, quae illum dicta maxime quo dolorum ipsa sint veritatis eos laborum autem fuga iure consectetur commodi. Sapiente saepe quas, quaerat magnam perspiciatis doloremque dolorum amet ea!', 'Visible', '2024-11-30 14:20:00'),
(79, 'poYZ9bje', 'Kang Haerin', 'Lesson 1', 'Material', 'Lesson 1 Description', 'Visible', '2024-11-30 14:20:00'),
(80, 'poYZ9bje', 'Kang Haerin', 'Lesson 2', 'Material', 'Lesson 2 Description', 'Visible', '2024-11-30 14:20:00'),
(81, 'poYZ9bje', 'Kang Haerin', 'Lesson 3', 'Material', 'Lesson 3 Description', 'Visible', '2024-11-30 14:20:00'),
(82, 'poYZ9bje', 'Kang Haerin', 'Lesson 4', 'Material', 'Description Here', 'Visible', '2024-11-30 14:20:00'),
(83, 'poYZ9bje', 'Kang Haerin', 'Lesson 5', 'Material', 'Lesson 5 Description', 'Visible', '2024-11-30 14:20:00'),
(84, 'poYZ9bje', 'Kang Haerin', 'Quiz 1', 'Quiz', 'Quiz Description', 'Visible', '2024-11-30 14:20:00'),
(90, 'poYZ9bje', 'Kang Haerin', 'Quiz 2', 'Quiz', 'Quiz Description', 'Visible', '2024-11-30 14:20:00'),
(92, 'poYZ9bje', 'Kang Haerin', 'Quiz 3', 'Quiz', 'Quiz Description', 'Visible', '2024-11-30 14:20:00'),
(94, 'poYZ9bje', 'Kang Haerin', 'Quiz 4', 'Quiz', 'Quiz Description', 'Visible', '2024-11-30 14:20:00'),
(95, 'poYZ9bje', 'Kang Haerin', 'Activity 1', 'Activity', 'Activity Description', 'Visible', '2024-11-30 14:20:00'),
(97, 'poYZ9bje', 'Kang Haerin', 'Activity 2', 'Activity', 'Activity Description', 'Visible', '2024-11-30 14:20:00'),
(99, 'poYZ9bje', 'Kang Haerin', 'Activity 3', 'Activity', 'Activity Description', 'Visible', '2024-11-30 14:20:00'),
(100, 'poYZ9bje', 'Kang Haerin', 'Activity 4', 'Activity', 'Activity Description', 'Visible', '2024-11-30 14:20:00'),
(110, 'p9Qzj1Hi', 'Kang Haerin', 'Test', 'Material', 'test1', 'Visible', '2024-11-30 14:20:00'),
(111, 'p9Qzj1Hi', 'Kang Haerin', '123', 'Material', '123', 'Visible', '2024-11-30 14:20:00'),
(112, 'p9Qzj1Hi', 'Kang Haerin', '123', 'Material', '123', 'Visible', '2024-11-30 14:20:00'),
(274, 'rB0wd5Ao', 'Sir Victor Aquino', '22', 'Material', '2', 'Visible', '2024-11-29 08:32:22'),
(275, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:51'),
(276, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:56'),
(277, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:57'),
(278, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:57'),
(279, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:57'),
(280, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:58'),
(281, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:58'),
(282, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:58'),
(283, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:58'),
(284, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:58'),
(285, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:59'),
(286, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:39:59'),
(287, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:40:44'),
(288, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:40:44'),
(289, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:40:45'),
(290, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:40:45'),
(291, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:40:45'),
(292, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:40:57'),
(293, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:40:57'),
(294, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:40:58'),
(295, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:40:58'),
(296, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:40:58'),
(297, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:40:58'),
(298, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:41:01'),
(299, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:41:11'),
(300, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:41:11'),
(301, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:41:11'),
(302, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:41:11'),
(303, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:41:11'),
(304, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:41:12'),
(305, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 08:41:47'),
(306, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 08:41:47'),
(307, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 08:41:47'),
(308, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 08:41:47'),
(309, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 08:41:48'),
(310, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '232', 'Visible', '2024-11-29 08:42:14'),
(311, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:43:26'),
(312, 'rB0wd5Ao', 'Sir Victor Aquino', '23', 'Material', '32', 'Visible', '2024-11-29 08:43:57'),
(313, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:44:35'),
(314, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:46:03'),
(315, 'rB0wd5Ao', 'Sir Victor Aquino', '1', 'Material', '1', 'Visible', '2024-11-29 08:46:32'),
(316, 'rB0wd5Ao', 'Sir Victor Aquino', '1', 'Material', '1', 'Visible', '2024-11-29 08:48:53'),
(317, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 08:50:04'),
(318, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 08:51:28'),
(319, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:53:10'),
(320, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:53:54'),
(321, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 08:57:07'),
(322, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 08:57:27'),
(323, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 08:58:42'),
(324, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:00:14'),
(325, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 09:01:14'),
(326, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:01:52'),
(327, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:02:40'),
(328, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 09:05:15'),
(329, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:06:40'),
(330, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 09:07:27'),
(331, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:07:58'),
(332, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 09:08:27'),
(333, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:08:59'),
(334, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:09:52'),
(335, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '32', 'Visible', '2024-11-29 09:13:43'),
(336, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '1231', 'Visible', '2024-11-29 09:14:16'),
(337, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '32', 'Visible', '2024-11-29 09:14:42'),
(338, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:15:22'),
(339, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:16:21'),
(340, 'rB0wd5Ao', 'Sir Victor Aquino', '1', 'Material', '1', 'Visible', '2024-11-29 09:16:47'),
(341, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:18:01'),
(342, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:19:01'),
(343, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:19:44'),
(344, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:22:32'),
(345, 'rB0wd5Ao', 'Sir Victor Aquino', '1', 'Material', '1', 'Visible', '2024-11-29 09:24:23'),
(346, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 09:24:52'),
(347, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:25:38'),
(348, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:26:41'),
(349, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '32', 'Visible', '2024-11-29 09:27:59'),
(350, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:29:10'),
(351, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:29:24'),
(352, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:30:08'),
(353, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:30:43'),
(354, 'rB0wd5Ao', 'Sir Victor Aquino', 'w', 'Material', 'e', 'Visible', '2024-11-29 09:30:59'),
(355, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 09:31:16'),
(356, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:31:43'),
(357, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:32:13'),
(358, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:32:41'),
(359, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:32:59'),
(360, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 09:34:08'),
(361, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:35:04'),
(362, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:35:21'),
(363, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 09:37:30'),
(364, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 09:37:50'),
(365, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 09:38:30'),
(366, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:44:23'),
(367, 'rB0wd5Ao', 'Sir Victor Aquino', '4', 'Material', '4', 'Visible', '2024-11-29 09:45:06'),
(368, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 09:45:24'),
(369, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 09:47:53'),
(370, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '123', 'Visible', '2024-11-29 09:48:51'),
(371, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 09:50:21'),
(372, 'rB0wd5Ao', 'Sir Victor Aquino', '213', 'Material', '321', 'Visible', '2024-11-29 11:02:31'),
(373, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '321', 'Visible', '2024-11-29 11:02:57'),
(374, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 11:03:33'),
(375, 'rB0wd5Ao', 'Sir Victor Aquino', '1', 'Material', '1', 'Visible', '2024-11-29 11:03:55'),
(376, 'rB0wd5Ao', 'Sir Victor Aquino', '123', 'Material', '32', 'Visible', '2024-11-29 11:04:20'),
(377, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 11:04:57'),
(378, 'rB0wd5Ao', 'Sir Victor Aquino', '23', 'Material', '23', 'Visible', '2024-11-29 11:05:34'),
(379, 'rB0wd5Ao', 'Sir Victor Aquino', '231', 'Material', '22', 'Visible', '2024-11-29 11:06:32'),
(380, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 11:12:23'),
(381, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 11:12:44'),
(382, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 11:13:41'),
(383, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 11:15:01'),
(384, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 11:15:17'),
(385, 'rB0wd5Ao', 'Sir Victor Aquino', '321', 'Material', '321', 'Visible', '2024-11-29 11:19:23'),
(386, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 11:19:51'),
(387, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 11:20:30'),
(388, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 11:21:00'),
(389, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 11:30:48'),
(390, 'rB0wd5Ao', 'Sir Victor Aquino', '4', 'Material', '4', 'Visible', '2024-11-29 11:32:10'),
(391, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 11:32:54'),
(392, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 11:33:34'),
(393, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 11:34:40'),
(394, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 11:35:21'),
(395, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 11:36:53'),
(396, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 11:37:21'),
(397, 'rB0wd5Ao', 'Sir Victor Aquino', '2', 'Material', '2', 'Visible', '2024-11-29 11:58:30'),
(398, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 11:58:51'),
(399, 'rB0wd5Ao', 'Sir Victor Aquino', '3', 'Material', '3', 'Visible', '2024-11-29 12:00:32'),
(407, 'a8fuS3pm', 'Kang Haerin', 'Lesson 1', 'Material', 'Lesson', 'Visible', '2024-12-02 08:26:07'),
(408, 'a8fuS3pm', 'Kang Haerin', 'Lesson 2', 'Material', 'Lesson Description', 'Visible', '2024-12-02 11:33:26'),
(409, 'dh0bl51M', 'Kang Haerin', 'Lesson 1', 'Material', 'Lesson Here', 'Visible', '2024-12-02 11:51:24'),
(412, 'a8fuS3pm', 'Kang Haerin', 'Lesson 3', 'Material', 'Lesson Description', 'Visible', '2024-12-02 11:59:42'),
(413, 'a8fuS3pm', 'Kang Haerin', 'Lesson 4', 'Material', 'Lesson Description', 'Visible', '2024-12-02 12:02:37'),
(414, 'dh0bl51M', 'Kang Haerin', '123', 'Material', '123', 'Visible', '2024-12-02 12:23:55'),
(415, 'd9BU7610', 'Kang Haerin', '123', 'Material', '123', 'Visible', '2024-12-02 12:25:03'),
(416, 'poYZ9bje', 'Kang Haerin', '123', 'Material', '123', 'Visible', '2024-12-02 12:26:11'),
(417, 'dh0bl51M', 'Kang Haerin', '123', 'Material', '123', 'Visible', '2024-12-02 12:26:41'),
(418, 'dh0bl51M', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-02 12:27:29'),
(419, 'd9BU7610', 'Kang Haerin', '123', 'Material', '123', 'Visible', '2024-12-02 12:30:10'),
(420, 'd9BU7610', 'Kang Haerin', '123', 'Material', '123', 'Visible', '2024-12-02 12:30:53'),
(421, 'd9BU7610', 'Kang Haerin', '3213', 'Material', '213', 'Visible', '2024-12-02 12:32:56'),
(422, 'd9BU7610', 'Kang Haerin', '2', 'Material', '2', 'Visible', '2024-12-02 12:34:12'),
(423, 'd9BU7610', 'Kang Haerin', '2', 'Material', '2', 'Visible', '2024-12-02 12:34:50'),
(424, 'dh0bl51M', 'Kang Haerin', '22', 'Material', '22', 'Visible', '2024-12-02 12:41:24'),
(425, 'dh0bl51M', 'Kang Haerin', '2', 'Material', '2', 'Visible', '2024-12-02 12:42:07'),
(426, 'd9BU7610', 'Kang Haerin', 'qwe', 'Material', 'qwe', 'Visible', '2024-12-02 12:42:23'),
(427, 'd9BU7610', 'Kang Haerin', '1', 'Material', '2', 'Visible', '2024-12-02 12:43:27'),
(428, 'd9BU7610', 'Kang Haerin', '123', 'Material', '123', 'Visible', '2024-12-02 12:43:44'),
(429, 'd9BU7610', 'Kang Haerin', '23', 'Material', '23', 'Visible', '2024-12-02 12:43:55'),
(430, 'dh0bl51M', 'Kang Haerin', '2', 'Material', '2', 'Visible', '2024-12-03 01:07:15'),
(432, 'd9BU7610', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-03 01:18:26'),
(441, 'WzapuE0Y', 'Kang Haerin', '231', 'Material', '321', 'Visible', '2024-12-03 01:38:44'),
(442, 'WzapuE0Y', 'Kang Haerin', '2', 'Material', '2', 'Visible', '2024-12-03 01:39:13'),
(443, 'WzapuE0Y', 'Kang Haerin', '2', 'Material', '2', 'Visible', '2024-12-03 01:39:54'),
(444, 'WzapuE0Y', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-03 01:40:18'),
(445, 'WzapuE0Y', 'Kang Haerin', '2', 'Material', '2', 'Visible', '2024-12-03 01:41:03'),
(450, 'd9BU7610', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-03 01:55:12'),
(451, 'WzapuE0Y', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-03 01:56:30'),
(452, 'd9BU7610', 'Kang Haerin', 'qwe', 'Material', 'ewq', 'Visible', '2024-12-03 01:57:03'),
(453, 'WzapuE0Y', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-03 02:03:59'),
(454, 'WzapuE0Y', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-03 02:04:18'),
(455, '0Uw1oZqr', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-03 02:04:35'),
(456, 'd9BU7610', 'Kang Haerin', 'qwe', 'Material', 'eqw', 'Visible', '2024-12-03 02:04:59'),
(457, 'a8fuS3pm', 'Kang Haerin', '3', 'Material', '2', 'Visible', '2024-12-03 02:05:40'),
(458, 'd9BU7610', 'Kang Haerin', '2', 'Material', '2', 'Visible', '2024-12-03 02:06:50'),
(459, '792F7DpJ', 'Ning Yizhuo', '231', 'Material', '321', 'Visible', '2024-12-05 15:09:01'),
(460, '792F7DpJ', 'Ning Yizhuo', '123', 'Material', '312', 'Visible', '2024-12-05 15:09:01'),
(461, 'd9BU7610', 'Kang Haerin', '132', 'Material', '321', 'Visible', '2024-12-03 02:11:28'),
(462, '792F7DpJ', 'Ning Yizhuo', '321', 'Material', '321', 'Visible', '2024-12-05 15:09:01'),
(463, '7Ym4B5NH', 'Ning Yizhuo', '321', 'Material', '321', 'Visible', '2024-12-05 15:09:01'),
(464, 'd9BU7610', 'Kang Haerin', 'qwe', 'Material', 'eqw', 'Visible', '2024-12-03 02:16:38'),
(465, 'WzapuE0Y', 'Kang Haerin', 'qwe', 'Material', 'wqe', 'Visible', '2024-12-03 02:17:05'),
(466, 'WzapuE0Y', 'Kang Haerin', '123', 'Material', '312', 'Visible', '2024-12-03 02:17:46'),
(468, 'd9BU7610', 'Kang Haerin', '231', 'Material', '31', 'Visible', '2024-12-03 02:25:23'),
(469, 'd9BU7610', 'Kang Haerin', '312', 'Material', '312', 'Visible', '2024-12-03 02:25:56'),
(470, 'WzapuE0Y', 'Kang Haerin', 'EQW', 'Material', 'EWQ', 'Visible', '2024-12-03 02:32:27'),
(471, 'WzapuE0Y', 'Kang Haerin', '32', 'Material', '32', 'Visible', '2024-12-03 02:32:44'),
(472, 'WzapuE0Y', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-03 02:33:50'),
(473, 'd9BU7610', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-03 02:50:07'),
(474, 'a8fuS3pm', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-03 02:50:32'),
(475, 'd9BU7610', 'Kang Haerin', '123', 'Material', '321312', 'Visible', '2024-12-03 02:52:01'),
(476, 'd9BU7610', 'Kang Haerin', 'aweq', 'Material', 'eqweq', 'Visible', '2024-12-03 02:52:39'),
(477, 'd9BU7610', 'Kang Haerin', '231', 'Material', '3213', 'Visible', '2024-12-03 02:52:50'),
(478, 'd9BU7610', 'Kang Haerin', '321', 'Material', '312', 'Visible', '2024-12-03 02:53:38'),
(479, 'd9BU7610', 'Kang Haerin', '321', 'Material', '321', 'Visible', '2024-12-03 02:56:57'),
(480, 'WzapuE0Y', 'Kang Haerin', '123', 'Material', '321', 'Visible', '2024-12-03 02:58:20'),
(481, 'WzapuE0Y', 'Kang Haerin', '231', 'Material', '321', 'Visible', '2024-12-03 02:58:39'),
(483, 'a8fuS3pm', 'Kang Haerin', 'qwe', 'Activity', 'qwe', 'Visible', '2024-12-03 05:38:03'),
(484, 'a8fuS3pm', 'Kang Haerin', 'QWE', 'Activity', 'QWEQ', 'Visible', '2024-12-03 05:38:49'),
(485, 'a8fuS3pm', 'Kang Haerin', '321', 'Activity', '321', 'Visible', '2024-12-03 05:39:46'),
(486, 'a8fuS3pm', 'Kang Haerin', 'TEST1', 'Material', 'TEST2', 'Visible', '2024-12-03 05:54:17'),
(487, 'a8fuS3pm', 'Kang Haerin', 'QWE', 'Material', 'QWE', 'Visible', '2024-12-03 05:56:53'),
(488, 'a8fuS3pm', 'Kang Haerin', 'Q', 'Material', 'W', 'Visible', '2024-12-03 05:57:15'),
(489, 'a8fuS3pm', 'Kang Haerin', 'qwe', 'Material', 'ewq', 'Visible', '2024-12-03 05:57:48'),
(490, 'a8fuS3pm', 'Kang Haerin', 'w', 'Material', 'w', 'Visible', '2024-12-03 05:58:00'),
(491, 'WzapuE0Y', 'Kang Haerin', 'SDA', 'Material', 'WQEE', 'Visible', '2024-12-03 05:59:42'),
(492, 'WzapuE0Y', 'Kang Haerin', 'WE', 'Material', 'WE', 'Visible', '2024-12-03 06:00:05'),
(493, 'WzapuE0Y', 'Kang Haerin', 'SDA', 'Material', 'DSA', 'Visible', '2024-12-03 06:00:31'),
(494, 'WzapuE0Y', 'Kang Haerin', 'qwe', 'Material', 'ewq', 'Visible', '2024-12-03 06:02:07'),
(495, 'WzapuE0Y', 'Kang Haerin', 'qwe', 'Material', 'eqw', 'Visible', '2024-12-03 06:02:16'),
(506, 'WzapuE0Y', 'Kang Haerin', 'qwe', 'Material', 'qwe', 'Visible', '2024-12-04 02:51:34'),
(507, 'WzapuE0Y', 'Kang Haerin', 'Q', 'Material', 'Q', 'Visible', '2024-12-04 02:58:59'),
(508, '0Uw1oZqr', 'Kang Haerin', 'Lesson 2', 'Material', 'Test', 'Visible', '2024-12-04 02:59:33'),
(509, '0Uw1oZqr', 'Kang Haerin', 'LESSON 4', 'Material', 'TEST', 'Visible', '2024-12-04 02:59:46'),
(511, 'dh0bl51M', 'Kang Haerin', 'Activity 1', 'Activity', 'Act Description', 'Visible', '2024-12-04 03:43:39'),
(520, '0Uw1oZqr', 'Kang Haerin', 'Activity 2', 'Activity', 'Activity Descrption', 'Visible', '2024-12-04 12:27:05'),
(521, '0Uw1oZqr', 'Kang Haerin', 'Activity 3', 'Activity', 'Act Description', 'Visible', '2024-12-04 12:28:04'),
(522, '0Uw1oZqr', 'Kang Haerin', 'q', 'Material', 'q', 'Visible', '2024-12-04 12:31:13'),
(523, '0Uw1oZqr', 'Kang Haerin', 'w', 'Material', 'w', 'Visible', '2024-12-04 12:31:30'),
(524, '0Uw1oZqr', 'Kang Haerin', '123321', 'Activity', '3213', 'Visible', '2024-12-04 12:34:07'),
(525, '0Uw1oZqr', 'Kang Haerin', 'TEST', 'Activity', 'TEST', 'Visible', '2024-12-04 12:34:29'),
(526, 'd9BU7610', 'Kang Haerin', 'test', 'Activity', 'test', 'Visible', '2024-12-04 12:35:15'),
(527, '0Uw1oZqr', 'Kang Haerin', 'NEW ACTIVITY', 'Activity', 'ACTIVITY DESCRIPTION', 'Visible', '2024-12-04 12:38:07'),
(528, 'p9Qzj1Hi', 'Kang Haerin', 'Activity 1', 'Activity', 'Act Description', 'Visible', '2024-12-05 03:41:27'),
(530, 'd9BU7610', 'Kang Haerin', 'Act 2', 'Activity', 'Act Description', 'Visible', '2024-12-05 06:07:35'),
(531, 'd9BU7610', 'Kang Haerin', 'TEST', 'Material', 'TEST', 'Visible', '2024-12-05 06:08:58'),
(532, 'd9BU7610', 'Kang Haerin', 'Act 3', 'Activity', 'Act Description', 'Visible', '2024-12-05 06:09:30'),
(533, 'a8fuS3pm', 'Kang Haerin', 'QUIZ 1', 'Quiz', 'QUIZ DESCRIPTION', 'Visible', '2024-12-05 06:24:48'),
(550, '3fCPK434', 'Kang Haerin', 'Lesson', 'Material', 'Lesson', 'Visible', '2024-12-05 12:47:10'),
(551, '3fCPK434', 'Kang Haerin', 'Lesson 2', 'Material', '2', 'Visible', '2024-12-05 12:47:31'),
(552, '3fCPK434', 'Kang Haerin', 'ACTIVITY 1', 'Activity', 'ACT DESCRIPTION', 'Visible', '2024-12-05 12:54:59'),
(553, '3fCPK434', 'Kang Haerin', 'Activity 2', 'Activity', 'Activity Description', 'Visible', '2024-12-05 12:55:54'),
(554, '3fCPK434', 'Kang Haerin', 'ACTIVITY 3', 'Activity', 'ACT DESCRIPTION', 'Visible', '2024-12-05 12:57:42'),
(555, '3fCPK434', 'Kang Haerin', 'ACT', 'Activity', 'ACT', 'Visible', '2024-12-05 13:01:29'),
(556, '3fCPK434', 'Kang Haerin', 'ACT 4', 'Activity', 'ACT DESC', 'Visible', '2024-12-05 13:02:41'),
(557, '3fCPK434', 'Kang Haerin', 'QUIZ 2', 'Quiz', 'Q', 'Visible', '2024-12-06 03:21:00'),
(558, 'p9Qzj1Hi', 'Kang Haerin', 'LESSON 5', 'Material', 'LESSON DESCRIPTION', 'Visible', '2024-12-05 13:52:09'),
(561, 'a8fuS3pm', 'Kang Haerin', 'QUIZ 2', 'Material', 'QUIZ DESCRIPTION', 'Visible', '2024-12-06 09:56:37'),
(562, 'a8fuS3pm', 'Kang Haerin', 'QUIZ 3', 'Quiz', 'QUIZ DESCRIPTION', 'Visible', '2024-12-06 09:58:43'),
(563, 'a8fuS3pm', 'Kang Haerin', 'QUIZ 4', 'Material', 'QUIZ', 'Visible', '2024-12-06 09:59:18'),
(564, '3fCPK434', 'Kang Haerin', 'Q', 'Material', 'Q', 'Visible', '2024-12-06 10:01:30'),
(565, '3fCPK434', 'Kang Haerin', 'Q', 'Material', 'Q', 'Visible', '2024-12-06 10:02:13'),
(566, '3fCPK434', 'Kang Haerin', 'QUIZ', 'Quiz', 'QUIZ', 'Visible', '2024-12-06 10:03:12'),
(567, '0Uw1oZqr', 'Kang Haerin', 'QUIZ', 'Material', 'QUIZ', 'Visible', '2024-12-06 10:04:56'),
(569, 'WzapuE0Y', 'Kang Haerin', 'Q', 'Material', 'Q', 'Visible', '2024-12-06 10:06:05'),
(571, 'WzapuE0Y', 'Kang Haerin', 'EWQ', 'Material', 'EWQEQW', 'Visible', '2024-12-06 10:09:02'),
(572, 'WzapuE0Y', 'Kang Haerin', 'ww', 'Material', 'ww', 'Visible', '2024-12-06 10:12:27'),
(573, 'WzapuE0Y', 'Kang Haerin', 'A', 'Activity', 'A', 'Visible', '2024-12-06 10:13:44'),
(578, 'WzapuE0Y', 'Kang Haerin', 're', 'Material', 'rere', 'Visible', '2024-12-06 10:20:49'),
(579, 'WzapuE0Y', 'Kang Haerin', 'q', 'Material', 'q', 'Visible', '2024-12-06 10:24:15'),
(581, 'WzapuE0Y', 'Kang Haerin', 'wwwww', 'Material', 'wwww', 'Visible', '2024-12-06 10:25:01'),
(582, 'WzapuE0Y', 'Kang Haerin', '2', 'Material', '2', 'Visible', '2024-12-06 10:27:17'),
(584, 'WzapuE0Y', 'Kang Haerin', 'QUIZ 1', 'Quiz', 'QUIZ DESCRIPTION', 'Visible', '2024-12-06 10:31:58'),
(585, 'a8fuS3pm', 'Kang Haerin', 'Q3', 'Quiz', 'Q3', 'Visible', '2024-12-06 13:09:01'),
(586, '3fCPK434', 'Kang Haerin', 'NEW LESSON', 'Material', 'LESSON DESCRIPTION', 'Visible', '2024-12-07 10:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `post_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `class_code` varchar(20) NOT NULL,
  `question_text` varchar(500) NOT NULL,
  `question_type` varchar(30) NOT NULL,
  `ans_key` varchar(255) NOT NULL,
  `points` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`post_id`, `question_id`, `class_code`, `question_text`, `question_type`, `ans_key`, `points`) VALUES
(0, 1, '3fCPK434', 'Q1', 'multiple-choice', 'C', 5),
(0, 2, '3fCPK434', 'Q2', 'short-text', 'Short Answer Key Here', 10),
(0, 3, '3fCPK434', 'Q3', 'true-false', 'True', 2),
(0, 4, '3fCPK434', 'Q1', 'multiple-choice', 'B', 1),
(0, 5, '3fCPK434', 'Q1', 'multiple-choice', 'B', 5),
(533, 6, '3fCPK434', 'Short Text Question', 'short-text', 'ANSWER HERE', 10),
(0, 7, '3fCPK434', 'Q3', 'true-false', 'True', 1),
(0, 8, '3fCPK434', 'Q', 'short-text', 'QWQW', 1),
(0, 9, '3fCPK434', 'Question 1', 'multiple-choice', 'Choice B', 5),
(0, 10, '3fCPK434', 'Question 2', 'short-text', 'Short Text Answer Key', 10),
(0, 11, '3fCPK434', 'Question 3', 'true-false', 'False', 1),
(533, 12, 'a8fuS3pm', 'QUESTION 1', 'multiple-choice', 'B', 5),
(533, 13, 'a8fuS3pm', 'QUESTION 2', 'multiple-choice', 'Choice D', 5),
(533, 14, 'a8fuS3pm', 'Yes Or No?', 'true-false', 'False', 1),
(533, 15, 'a8fuS3pm', 'Opinions About .....', 'short-text', 'Your Opinion Here', 10),
(533, 16, 'a8fuS3pm', 'QUESTION 5', 'multiple-choice', 'TEST B', 1),
(77, 18, 'p9Qzj1Hi', 'Q1', 'multiple-choice', 'A', 1),
(557, 21, '3fCPK434', 'First Question', 'short-text', 'Short Text Answer Here', 10),
(566, 24, '3fCPK434', 'test', 'short-text', 'test', 1),
(566, 25, '3fCPK434', 'q', 'short-text', 'q', 1),
(557, 55, '3fCPK434', 'Q', 'true-false', 'True', 1),
(557, 56, '3fCPK434', 'W', 'multiple-choice', 'ZX', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `post_id` int(11) NOT NULL,
  `class_code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `starting_date` date NOT NULL,
  `starting_time` time NOT NULL,
  `deadline_date` date NOT NULL,
  `deadline_time` time NOT NULL,
  `points` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`post_id`, `class_code`, `created_at`, `starting_date`, `starting_time`, `deadline_date`, `deadline_time`, `points`, `status`) VALUES
(77, 'p9Qzj1Hi', '2024-12-05 14:23:00', '2024-12-06', '12:00:00', '2024-11-10', '12:00:00', 100, 'Pending'),
(90, 'poYZ9bje', '2024-12-05 14:23:00', '2024-12-06', '12:00:00', '2024-11-10', '12:00:00', 100, 'Pending'),
(92, 'poYZ9bje', '2024-12-05 14:23:00', '2024-12-06', '12:00:00', '2024-11-10', '12:00:00', 100, 'Pending'),
(94, 'poYZ9bje', '2024-12-05 14:23:00', '2024-12-06', '12:00:00', '2024-11-11', '15:00:00', 100, 'Pending'),
(104, 'a8fuS3pm', '2024-12-05 14:23:00', '2024-12-06', '12:00:00', '2024-11-28', '12:00:00', 100, 'Pending'),
(105, 'a8fuS3pm', '2024-12-05 14:23:00', '2024-12-06', '12:00:00', '2024-11-30', '12:00:00', 100, 'Pending'),
(533, 'a8fuS3pm', '2024-12-05 14:23:00', '2024-12-06', '12:00:00', '2024-12-06', '12:00:00', 100, 'Pending'),
(557, '3fCPK434', '2024-12-05 14:45:27', '2024-12-07', '12:00:00', '2024-12-27', '12:00:00', 5, 'Pending'),
(559, 'WzapuE0Y', '2024-12-06 02:27:50', '2024-12-07', '12:00:00', '2024-12-07', '12:00:00', 100, 'Pending'),
(560, 'WzapuE0Y', '2024-12-06 02:41:34', '2024-12-07', '15:00:00', '2024-12-08', '12:00:00', 50, 'Pending'),
(562, 'a8fuS3pm', '2024-12-06 09:58:43', '2024-12-06', '12:00:00', '2024-12-07', '12:00:00', 1, 'Pending'),
(566, '3fCPK434', '2024-12-06 10:03:12', '2024-12-07', '12:00:00', '2024-12-06', '12:00:00', 1, 'Pending'),
(568, 'WzapuE0Y', '2024-12-06 10:05:41', '0000-00-00', '12:00:00', '0000-00-00', '12:00:00', 1, 'Pending'),
(570, 'WzapuE0Y', '2024-12-06 10:08:14', '2024-12-07', '12:00:00', '2024-12-15', '12:00:00', 1, 'Pending'),
(574, 'WzapuE0Y', '2024-12-06 10:19:04', '2024-12-07', '12:00:00', '2024-12-09', '12:00:00', 1, 'Pending'),
(575, 'WzapuE0Y', '2024-12-06 10:19:34', '2024-12-13', '12:00:00', '2025-01-02', '12:00:00', 1, 'Pending'),
(576, 'WzapuE0Y', '2024-12-06 10:19:35', '2024-12-13', '12:00:00', '2025-01-02', '12:00:00', 1, 'Pending'),
(577, 'WzapuE0Y', '2024-12-06 10:19:36', '2024-12-13', '12:00:00', '2025-01-02', '12:00:00', 1, 'Pending'),
(580, 'WzapuE0Y', '2024-12-06 10:24:43', '2024-12-07', '12:00:00', '2024-12-08', '12:00:00', 1, 'Pending'),
(583, 'WzapuE0Y', '2024-12-06 10:28:28', '2024-12-07', '12:00:00', '2024-12-13', '12:00:00', 1, 'Pending'),
(584, 'WzapuE0Y', '2024-12-06 10:31:58', '2024-12-07', '12:00:00', '2024-12-10', '12:00:00', 50, 'Pending'),
(585, 'a8fuS3pm', '2024-12-06 13:09:01', '2024-12-07', '12:00:00', '2024-12-12', '12:00:00', 1, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_category` tinyint(1) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` char(255) NOT NULL,
  `password` char(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_category`, `name`, `email`, `password`, `image`, `address`, `gender`, `status`) VALUES
(19, 3, 'Aeri Uchinaga', 'aeri@gmail.com', '$2y$10$GqeB9mYNOYnz2GZqdpvC3u959yN2fqTXDAgou6mQFrMkD0SUwgv3G', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(6, 4, 'Sir Victor D. Aquino', 'alpacasenseii@gmail.com', '$2y$10$DHu8tctOy48IfBfsVF6OYe88Nxb2M8AEmIZK2kdyXOz3g2jAGaWue', '../profiles/profile.png', '308 PNR Compound Samsom Rd. Caloocan City', 'Male', 'Active'),
(29, 3, 'Sir Victor Aquino', 'aquino.sir.victor.bscs2022@gmail.com', '$2y$10$Qz5J6A.qZVPBF2jA9zgmTuv/UC/akYmxgrVishWXb8.wL7y.CBzUG', '../profiles/profile.png', '308 PNR Compound Samsom Rd. Caloocan City', 'Male', 'Active'),
(16, 4, 'Danielle Marsh', 'danielle@gmail.com', '$2y$10$BiSEs6xQYXjStXGYgEvsWu.LiHqQNygqH94EDGHY75PpNIoi4Q2Oy', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(30, 1, 'admin admin', 'eduportalmain@gmail.com', '$2y$10$Lr3OrFJrKGRAjzJYgnnjqOtB4MPqOx5F8bd4YZZuv3SRm9iwturO.', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(20, 4, 'Gaeul Lee', 'gaeul@gmail.com', '$2y$10$8cz.wYrKEPrSFkreeMYgS.f.ZUNrAaMlbws.oUg/ySnhT7gGIeYuy', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(2, 3, 'Kang Haerin', 'haerin@gmail.com', '$2y$10$/RQoesV15lSM5DizWyN.XuE3V3ncRCcSskMPm0ENrbwQ5307syCfS', '../profiles/2.png', 'South Korea', 'Female', 'Active'),
(9, 4, 'Haewon Oh', 'haewon@gmail.com', '$2y$10$OQ0WqFC3CbLhlT8wj1mPoOjCpscZq1WtdpKA/dzV9XMvcoh012zKW', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(15, 4, 'Hanni Pham', 'hanni@gmail.com', '$2y$10$Ucwxlem3dslwwfZ.LJx6AOCOtIMqkGdIQy.oIf8/J5fpkBlWZJx5u', '../profiles/15.jpeg', 'South Korea', 'Female', 'Active'),
(14, 4, 'Hyein Lee', 'hyein@gmail.com', '$2y$10$WDt2xx1lZYoYx5lcYgsFJOu/3wAZw8tanAZEtZAX5n6vh/trOX4T2', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(12, 4, 'Jeongyeon Yoo', 'jeongyeon@gmail.com', '$2y$10$7D1In0Cs5nsVtpUfwV8w8ew.ebeQ7dK9ccYOT/PgV88KGaozDEVky', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(26, 4, 'Jihyo Park', 'jihyo@gmail.com', '$2y$10$49yhiftXtEwde62p7xp5YOQ7Y1fZkYAdxObH8ynC7R4CQ5uSCdpHu', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(18, 4, 'Jiwon Kim', 'jiwon@gmail.com', '$2y$10$W727WKTnH69U28eeiKe3zOXq2mvjWbjQYQL19QC8DZWuF.ErN.1k2', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(23, 4, 'Jimin Yu', 'karina@gmail.com', '$2y$10$JO82b7l7C7wII3/MLZJAVebzFJSFb.9osp1Av05lJHJv67AOluslK', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(8, 3, 'Kim Minjeong', 'kmj@gmail.com', '$2y$10$vI5KdEM6tazlnKZ8FhHeK.JdWbf9h06ozLjICwA3b.pNPxOMEFcvO', '../profiles/8.jpeg', 'South Korea', 'Female', 'Active'),
(24, 4, 'Mina Myoui', 'mina@gmail.com', '$2y$10$m/76vGsKSKeE2.qT/P6ZVuOVktiQwjZiKZYW35TTVnyzm4KiixAOe', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(17, 4, 'Minji Kim', 'minji@gmail.com', '$2y$10$s9LS4D08nA9TeQ.TN3S1OerLPp6.V5eNjxXrqqrDTENESj9JQdZaK', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(1, 3, 'Ning Yizhuo', 'ningning@gmail.com', '$2y$10$q7m/Wz5QnEB681BUfGYSO.A82ojxzNOeJnzZxnr5HER6cLuAlwCQu', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(4, 2, 'Rei Naoi', 'rei@gmail.com', '$2y$10$oglCHcgGebLyT4MM6a/tNenskKcIQ25bUUnWhQiWkbCFuUpaaZeBu', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(22, 4, 'Sana Minatozaki', 'sana@gmail.com', '$2y$10$XQ9jMDjbK.Lq1bfMoMdEVuy11cI0PnnHuSaJ7kZiR4LwzDWS.ydse', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(21, 4, 'Seulgi Kang', 'seulgi@gmail.com', '$2y$10$DK7flfdX1wgfo4QgeNe6j.Gp1Mj1i6xGXP5j8AkF5fwcw/L9SIyB6', '../profiles/profile.png', 'South Korea', 'Female', 'Active'),
(13, 3, 'Wonyoung Jang', 'wony@gmail.com', '$2y$10$d3KiCtHaJkFWFKgzZbC/XurOvHLkJRPIxzoOpePrn1SlHLVuMFt4.', '../profiles/profile.png', 'South Korea', 'Female', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD UNIQUE KEY `post_id` (`post_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_num`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD UNIQUE KEY `post_id` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `UNIQUE` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=587;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=586;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
