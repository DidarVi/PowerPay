-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2024 at 10:56 PM
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
-- Table structure for table `user_bill`
--

CREATE TABLE `user_bill` (
  `bill_no` int(11) NOT NULL,
  `meter_no` varchar(20) NOT NULL,
  `previously_used_unit` decimal(10,2) NOT NULL,
  `currently_used_unit` decimal(10,2) NOT NULL,
  `bill` decimal(10,2) NOT NULL,
  `late_payment_amount` decimal(10,2) NOT NULL,
  `billing_month` date NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_bill`
--

INSERT INTO `user_bill` (`bill_no`, `meter_no`, `previously_used_unit`, `currently_used_unit`, `bill`, `late_payment_amount`, `billing_month`, `issue_date`, `due_date`) VALUES
(1, '1234', 40.00, 600.00, 7532.00, 8182.00, '2024-01-01', '2024-01-20', '2024-02-14'),
(2, '245', 4.00, 100.00, 528.00, 678.00, '2024-01-01', '2024-01-20', '2024-02-14'),
(3, '34', 60.00, 460.00, 4228.00, 4628.00, '2024-01-01', '2024-01-20', '2024-02-14'),
(4, '43', 60.00, 660.00, 4260.00, 4410.00, '2024-01-01', '2024-01-20', '2024-02-14'),
(5, '234234', 30.00, 500.00, 3337.00, 3487.00, '2024-01-01', '2024-01-20', '2024-02-14'),
(6, '7890', 420.00, 2000.00, 20540.00, 20940.00, '2024-01-01', '2024-01-20', '2024-02-14');

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
(9, 'Sabbir Ali', '11111', '98798744', 'iuhkjn', '$2y$10$l9Ia0O6vsa2/UkRrSTzJxupYFUonZYO/HTz8Yg8kegp/ZYgmhKZu6'),
(10, 'test', '123', '12', 'asdf', '$2y$10$mfSbs/0W8A5uOVwoU/HQW.Bb3191lOA37Nc4BRHihacDI39AKXZhy');

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
(7, 'didar', 33, 'male', '23', 'adsf', '34', 'garments', '$2y$10$zSULSzCKHxkgoLpHnOXk2u8l4W0j.mUU3HXpoK5R9jw1Z0zn1Dd4u'),
(8, 'mohim', 44, 'male', '444', 'adsf', '245', 'residential', '$2y$10$n6.hPPvXleUgiGIDkEodFeFyPinpC7XdZS4cZQHZZB8abe5NFIwJK'),
(9, 'nasim', 50, 'female', '01234234234', 'puran dhaka', '1234', 'industry', '$2y$10$dsvpfm3mKcN9U4FeELxOteKE7rWawf.0xbzNeKmQriYeGPLQqENd2'),
(11, '456', 33, 'male', '53434', 'agfkjkaj', '43', 'residential', '$2y$10$zIF3VCAA0fKmgPpR4E.sweZaQQFpl.E/FL1hVjsLZn1zpxNhDg7Q.'),
(12, '12367', 34, 'male', '01521', 'asdfjkajsdlfk', '234234', 'residential', '$2y$10$tWd/1ythXQpvqh6Ijb1YD.aN9i.uLN0NuZMK0Gn43ElcQX0Xr1Y3m'),
(14, 'dipta', 23, 'male', '01521', 'asdkfjlkasdjf', '7890', 'garments', '$2y$10$kRP8sqOm5K7zYWUVR6ub8eWIsbvvQIf9PPGCHbgAW840hcFbeXPz6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_bill`
--
ALTER TABLE `user_bill`
  ADD PRIMARY KEY (`bill_no`),
  ADD KEY `meter_no` (`meter_no`);

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
-- AUTO_INCREMENT for table `user_bill`
--
ALTER TABLE `user_bill`
  MODIFY `bill_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `your_admin_table`
--
ALTER TABLE `your_admin_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `your_user_table`
--
ALTER TABLE `your_user_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_bill`
--
ALTER TABLE `user_bill`
  ADD CONSTRAINT `user_bill_ibfk_1` FOREIGN KEY (`meter_no`) REFERENCES `your_user_table` (`meter_no`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
