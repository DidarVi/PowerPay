-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2024 at 08:17 PM
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
-- Database: `powerpay`
--

-- --------------------------------------------------------

--
-- Table structure for table `your_admin_table`
--

CREATE TABLE `your_admin_table` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `adminid` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `your_admin_table`
--

INSERT INTO `your_admin_table` (`id`, `name`, `adminid`, `phone`, `address`, `password`) VALUES
(1, 'Nasim', '2224', '8887666567', 'Nill', '$2y$10$ibdkPul1SVbZjIoQ5yOnrOHfduC2JbQvuc1PV6LAnKSWgRlbBtCTm'),
(2, 'Didar', '134133', '1341341', 'sadf3214134', '$2y$10$aw92hnONdMYSOBcEJcKrrehV015qccx5xYqm/kNYGIZvuoS0QdbFi'),
(5, 'aaa', '1341', '1341341', 'sadf3214134', '$2y$10$1JeZvCwc9dH4tH1.PrrqYeYtua8dzkzBlEEchRqxAsvXp5W4wMwcG'),
(6, 'madara', '111', '111', '23/3 solimollah road', '$2y$10$qjTP4c0ED6fvPTIy15dKLuNMwxxb2z2Szd4N242j1WcHE540JwRTm'),
(7, 'Sabbir', '1111', '987987', 'iuhkjn', '$2y$10$w.yzMMYSaAhE/EA9jQPpLuzvVRN90EUM5Zc6HLaKEOUpemsWuJ8PS'),
(9, 'Sabbir Ali', '11111', '98798744', 'iuhkjn', '$2y$10$l9Ia0O6vsa2/UkRrSTzJxupYFUonZYO/HTz8Yg8kegp/ZYgmhKZu6');

-- --------------------------------------------------------

--
-- Table structure for table `your_user_table`
--

CREATE TABLE `your_user_table` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `meter_no` varchar(20) NOT NULL,
  `meter_type` enum('residential','garments','industry') NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `your_user_table`
--

INSERT INTO `your_user_table` (`id`, `username`, `age`, `gender`, `phone`, `address`, `meter_no`, `meter_type`, `password`) VALUES
(7, 'didar', 33, 'male', '23', 'adsf', '34', 'residential', '$2y$10$zSULSzCKHxkgoLpHnOXk2u8l4W0j.mUU3HXpoK5R9jw1Z0zn1Dd4u'),
(8, 'mohim', 44, 'male', '444', 'adsf', '245', 'residential', '$2y$10$n6.hPPvXleUgiGIDkEodFeFyPinpC7XdZS4cZQHZZB8abe5NFIwJK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `your_admin_table`
--
ALTER TABLE `your_admin_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adminid` (`adminid`);

--
-- Indexes for table `your_user_table`
--
ALTER TABLE `your_user_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meter_no` (`meter_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `your_admin_table`
--
ALTER TABLE `your_admin_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `your_user_table`
--
ALTER TABLE `your_user_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
