-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2024 at 09:49 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectsmartcard`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(20) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `tell` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `firstname`, `lastname`, `email`, `password`, `tell`, `role`, `status`) VALUES
(1, 'เมธี', 'หตะเสน', 'methihatasen266@gmail.com', '1234', '0952216234', 'admin-main', 'active'),
(28, 'สุภกิจ', 'โคตรสุข', 'supakit12@gmail.com', '3333', '0933401643', 'admin-regular', 'inactive'),
(29, 'สุภารัตน์', 'สุภาวิชัย', 'suparat@gmail.com', '1234', '0622016841', 'admin-main', 'active'),
(30, 'สุชาติ', 'หีบหงษ์', 'Suchart.H@gmail.com', '2024', '0959734578', 'admin-regular', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(20) NOT NULL,
  `store_id` int(20) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `price` int(20) NOT NULL,
  `note` varchar(250) NOT NULL,
  `product_type_id` int(20) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `store_id`, `product_name`, `price`, `note`, `product_type_id`, `img`) VALUES
(3, 1, 'กะเพราหมูสับ', 60, '', 1, 'thai-basil-pork.jpg'),
(4, 1, 'ก๋วยจั๊บรวม', 70, '', 2, '1679995414_1c8409d87312fcd2775ade4c3e9d5005.jpg'),
(5, 3, 'เฟรนช์ฟรายส์', 50, '', 3, '240702604_266985148606899_6200597326834282392_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `product_type_id` int(20) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`product_type_id`, `type`) VALUES
(1, 'เมนูข้าว'),
(2, 'เมนูเส้น'),
(3, 'ของหวาน'),
(4, 'เครื่องดื่ม');

-- --------------------------------------------------------

--
-- Table structure for table `smartcard`
--

CREATE TABLE `smartcard` (
  `smartcard_id` varchar(20) NOT NULL,
  `type` varchar(250) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smartcard`
--

INSERT INTO `smartcard` (`smartcard_id`, `type`, `status`) VALUES
('1972586203', 'payment', 'active'),
('3481127342', 'payment', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `store_id` int(20) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `storename` varchar(50) NOT NULL,
  `tell` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_id`, `firstname`, `lastname`, `storename`, `tell`, `email`, `password`, `status`) VALUES
(1, 'สุวิมล', 'กลางวงค์ทอง', 'ก๋วยจั๊บเจ้สุ', '0625893174', 'suwimol@gmail.com', '5555', 'inactive'),
(3, 'เมธา', 'ประเสิร์ฐสิทธิ์', 'อาหารตามสั่ง', '0956310027', 'metha.pra@gmail.com', '4567', 'active'),
(4, 'สุนิสา', 'ทองม้วน', 'ขนมจีบไม่ดังแต่อร่อย', '0621379533', 'sunisa@gmail.com', '3698', 'active'),
(5, 'จตุพล', 'อารีย์รักษ์', 'ข้าวหมกไก่เจ้าเก่าหาดใหญ่', '0874625513', 'Jatupol.Aree@gmail.com', '0000', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `topup_close`
--

CREATE TABLE `topup_close` (
  `topup_close_id` int(20) NOT NULL,
  `admin_id` int(20) DEFAULT NULL,
  `store_id` int(20) DEFAULT NULL,
  `smartcard_id` varchar(20) NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `incoming_money` int(50) NOT NULL,
  `dates` varchar(20) NOT NULL,
  `times` varchar(20) NOT NULL,
  `balance` int(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topup_close`
--

INSERT INTO `topup_close` (`topup_close_id`, `admin_id`, `store_id`, `smartcard_id`, `transaction_type`, `incoming_money`, `dates`, `times`, `balance`, `status`) VALUES
(49, 1, NULL, '3481127342', 'Topup', 300, '2024-08-28', '18:54:14', 300, 'active'),
(50, 1, NULL, '1972586203', 'Topup', 300, '2024-08-28', '18:54:25', 240, 'active'),
(62, NULL, 1, '3481127342', 'Purchase', 60, '2024-08-28', '14:55:47', 240, 'active'),
(63, NULL, 1, '3481127342', 'Purchase', 120, '2024-08-28', '14:59:12', 180, 'active'),
(64, NULL, 1, '3481127342', 'Purchase', 60, '2024-08-28', '15:04:51', 120, 'active'),
(65, NULL, 1, '3481127342', 'Purchase', 120, '2024-08-28', '15:05:15', 0, 'active'),
(66, 1, NULL, '1972586203', 'Topup', 100, '2024-08-28', '20:07:34', 340, 'active'),
(67, NULL, 1, '1972586203', 'Purchase', 120, '2024-08-28', '15:36:07', 220, 'active'),
(68, 1, NULL, '3481127342', 'Topup', 200, '2024-08-28', '20:36:38', 200, 'active'),
(69, NULL, 1, '3481127342', 'Purchase', 60, '2024-08-28', '15:37:03', 140, 'active'),
(70, NULL, 1, '3481127342', 'Purchase', 140, '2024-08-28', '16:25:06', 60, 'active'),
(71, 1, NULL, '1972586203', 'Topup', 100, '2024-08-28', '23:24:24', 320, 'active'),
(72, 1, NULL, '1972586203', 'Withdraw', -100, '2024-08-28', '23:24:52', 220, 'active'),
(73, 1, NULL, '3481127342', 'Topup', 100, '2024-08-29', '10:03:27', 160, 'active'),
(74, 1, NULL, '1972586203', 'Topup', 100, '2024-08-29', '10:19:28', 320, 'active'),
(75, 29, NULL, '1972586203', 'Topup', 100, '2024-08-29', '10:27:43', 420, 'active'),
(76, 1, NULL, '1972586203', 'Topup', 350, '2024-08-29', '10:41:41', 770, 'active'),
(77, 1, NULL, '1972586203', 'Withdraw', -100, '2024-08-29', '10:43:02', 670, 'active'),
(78, 1, NULL, '3481127342', 'Topup', 100, '2024-08-29', '18:04:54', 260, 'active'),
(79, NULL, 1, '3481127342', 'Purchase', 130, '2024-09-14', '22:31:32', 130, 'active'),
(80, NULL, 1, '3481127342', 'Purchase', 120, '2024-09-14', '22:33:28', 140, 'active'),
(81, NULL, 1, '1972586203', 'Purchase', 120, '2024-09-14', '22:34:15', 650, 'active'),
(82, NULL, 1, '1972586203', 'Purchase', 120, '2024-09-14', '22:36:08', 650, 'active'),
(83, NULL, 1, '1972586203', 'Purchase', 70, '2024-09-14', '22:36:46', 700, 'active'),
(84, NULL, 1, '3481127342', 'Purchase', 60, '2024-09-14', '22:41:05', 200, 'active'),
(85, NULL, 1, '3481127342', 'Purchase', 60, '2024-09-14', '22:41:40', 200, 'active'),
(86, NULL, 1, '1972586203', 'Purchase', 60, '2024-09-14', '22:41:53', 710, 'active'),
(87, NULL, 1, '1972586203', 'Purchase', 120, '2024-09-15', '08:59:14', 650, 'active'),
(88, NULL, 1, '3481127342', 'Purchase', 130, '2024-09-15', '09:01:58', 130, 'active'),
(90, NULL, 1, '1972586203', 'Purchase', 60, '2024-09-15', '14:29:27', 530, 'active'),
(91, NULL, 1, '1972586203', 'Purchase', 70, '2024-09-15', '14:35:03', 520, 'active'),
(92, NULL, 1, '1972586203', 'Purchase', 70, '2024-09-15', '14:39:07', 520, 'active'),
(93, NULL, 1, '1972586203', 'Purchase', 70, '2024-09-15', '14:39:18', 520, 'active'),
(94, NULL, 1, '1972586203', 'Purchase', 70, '2024-09-15', '14:39:37', 520, 'active'),
(95, NULL, 1, '3481127342', 'Purchase', 60, '2024-09-15', '14:54:15', 70, 'active'),
(96, NULL, 1, '1972586203', 'Purchase', 60, '2024-09-15', '14:55:14', 530, 'active'),
(97, NULL, 1, '1972586203', 'Purchase', 60, '2024-09-15', '14:55:35', 530, 'active'),
(98, NULL, 1, '1972586203', 'Purchase', 60, '2024-09-15', '14:56:20', 530, 'active'),
(99, NULL, 1, '1972586203', 'Purchase', 60, '2024-09-15', '14:58:17', 530, 'active'),
(100, NULL, 1, '1972586203', 'Purchase', 70, '2024-09-15', '15:00:23', 520, 'active'),
(101, NULL, 1, '1972586203', 'Purchase', 70, '2024-09-15', '15:01:00', 450, 'active'),
(102, NULL, 1, '1972586203', 'Purchase', 70, '2024-09-15', '15:01:40', 380, 'active'),
(103, NULL, 1, '3481127342', 'Purchase', 70, '2024-09-15', '15:02:08', 0, 'active'),
(104, NULL, 1, '1972586203', 'Purchase', 70, '2024-09-15', '15:10:10', 310, 'active'),
(105, NULL, 1, '1972586203', 'Purchase', 60, '2024-09-15', '15:18:26', 250, 'active'),
(106, NULL, 1, '1972586203', 'Purchase', 60, '2024-09-15', '15:19:02', 190, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `withdraw_id` int(20) NOT NULL,
  `smartcard_id` varchar(20) NOT NULL,
  `store_id` int(20) NOT NULL,
  `withdraw_price` int(20) NOT NULL,
  `dates` varchar(20) NOT NULL,
  `times` varchar(20) NOT NULL,
  `type_withdraw` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withdraw`
--

INSERT INTO `withdraw` (`withdraw_id`, `smartcard_id`, `store_id`, `withdraw_price`, `dates`, `times`, `type_withdraw`) VALUES
(7, '3481127342', 1, 120, '2024-08-28', '02:31:18', 'Purchase'),
(8, '1972586203', 1, 120, '2024-08-28', '02:40:42', 'Purchase'),
(9, '3481127342', 1, 120, '2024-08-28', '02:50:49', 'Purchase'),
(10, '3481127342', 1, 120, '2024-08-28', '03:03:40', 'Purchase'),
(11, '3481127342', 1, 120, '2024-08-28', '03:04:37', 'Purchase'),
(18, '3481127342', 1, 60, '2024-08-28', '12:52:20', 'Purchase'),
(19, '3481127342', 1, 60, '2024-08-28', '12:53:00', 'Purchase'),
(20, '3481127342', 1, 180, '2024-08-28', '12:53:40', 'Purchase'),
(29, '3481127342', 1, 60, '2024-08-28', '13:25:49', 'Purchase'),
(30, '1972586203', 1, 60, '2024-08-28', '13:28:01', 'Purchase'),
(32, '1972586203', 1, 60, '2024-08-28', '13:31:52', 'Purchase'),
(42, '1972586203', 1, 60, '2024-08-28', '14:09:55', 'Purchase'),
(43, '1972586203', 1, 60, '2024-08-28', '14:16:56', 'Purchase'),
(44, '1972586203', 1, 60, '2024-08-28', '14:17:14', 'Purchase'),
(45, '1972586203', 1, 60, '2024-08-28', '14:17:34', 'Purchase'),
(46, '3481127342', 1, 60, '2024-08-28', '14:18:36', 'Purchase'),
(47, '3481127342', 1, 60, '2024-08-28', '14:18:59', 'Purchase'),
(48, '1972586203', 1, 60, '2024-08-28', '14:25:23', 'Purchase'),
(49, '1972586203', 1, 60, '2024-08-28', '14:25:47', 'Purchase'),
(50, '1972586203', 1, 60, '2024-08-28', '14:32:05', 'Purchase'),
(51, '1972586203', 1, 60, '2024-08-28', '14:38:33', 'Purchase'),
(52, '1972586203', 1, 60, '2024-08-28', '14:48:55', 'Purchase'),
(53, '3481127342', 1, 60, '2024-08-28', '14:55:47', 'Purchase'),
(54, '3481127342', 1, 120, '2024-08-28', '14:59:12', 'Purchase'),
(55, '3481127342', 1, 60, '2024-08-28', '15:04:51', 'Purchase'),
(56, '3481127342', 1, 120, '2024-08-28', '15:05:15', 'Purchase'),
(57, '1972586203', 1, 120, '2024-08-28', '15:36:07', 'Purchase'),
(58, '3481127342', 1, 60, '2024-08-28', '15:37:03', 'Purchase'),
(59, '3481127342', 1, 140, '2024-08-28', '16:25:06', 'Purchase'),
(60, '3481127342', 1, 130, '2024-09-14', '22:31:32', 'Purchase'),
(61, '3481127342', 1, 120, '2024-09-14', '22:33:28', 'Purchase'),
(62, '1972586203', 1, 120, '2024-09-14', '22:34:15', 'Purchase'),
(63, '1972586203', 1, 120, '2024-09-14', '22:36:08', 'Purchase'),
(64, '1972586203', 1, 70, '2024-09-14', '22:36:46', 'Purchase'),
(65, '3481127342', 1, 60, '2024-09-14', '22:41:05', 'Purchase'),
(66, '3481127342', 1, 60, '2024-09-14', '22:41:40', 'Purchase'),
(67, '1972586203', 1, 60, '2024-09-14', '22:41:53', 'Purchase'),
(68, '1972586203', 1, 120, '2024-09-15', '08:59:14', 'Purchase'),
(69, '3481127342', 1, 130, '2024-09-15', '09:01:58', 'Purchase'),
(70, '1972586203', 1, 60, '2024-09-15', '14:25:15', 'Purchase'),
(71, '1972586203', 1, 60, '2024-09-15', '14:29:27', 'Purchase'),
(72, '1972586203', 1, 70, '2024-09-15', '14:35:03', 'Purchase'),
(73, '1972586203', 1, 70, '2024-09-15', '14:39:07', 'Purchase'),
(74, '1972586203', 1, 70, '2024-09-15', '14:39:18', 'Purchase'),
(75, '1972586203', 1, 70, '2024-09-15', '14:39:37', 'Purchase'),
(76, '3481127342', 1, 60, '2024-09-15', '14:54:15', 'Purchase'),
(77, '1972586203', 1, 60, '2024-09-15', '14:55:14', 'Purchase'),
(78, '1972586203', 1, 60, '2024-09-15', '14:55:35', 'Purchase'),
(79, '1972586203', 1, 60, '2024-09-15', '14:56:20', 'Purchase'),
(80, '1972586203', 1, 60, '2024-09-15', '14:58:17', 'Purchase'),
(81, '1972586203', 1, 70, '2024-09-15', '15:00:23', 'Purchase'),
(82, '1972586203', 1, 70, '2024-09-15', '15:01:00', 'Purchase'),
(83, '1972586203', 1, 70, '2024-09-15', '15:01:40', 'Purchase'),
(84, '3481127342', 1, 70, '2024-09-15', '15:02:08', 'Purchase'),
(85, '1972586203', 1, 70, '2024-09-15', '15:10:10', 'Purchase'),
(86, '1972586203', 1, 60, '2024-09-15', '15:18:26', 'Purchase'),
(87, '1972586203', 1, 60, '2024-09-15', '15:19:02', 'Purchase');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_detail`
--

CREATE TABLE `withdraw_detail` (
  `withdraw_detail_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `withdraw_id` int(20) NOT NULL,
  `number_of_purchases` int(30) NOT NULL,
  `total_price` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withdraw_detail`
--

INSERT INTO `withdraw_detail` (`withdraw_detail_id`, `product_id`, `withdraw_id`, `number_of_purchases`, `total_price`) VALUES
(1, 3, 8, 2, 120),
(2, 3, 9, 2, 120),
(43, 3, 57, 2, 120),
(44, 3, 58, 1, 60),
(45, 4, 59, 2, 140),
(46, 3, 60, 1, 60),
(47, 4, 60, 1, 70),
(48, 3, 61, 2, 120),
(49, 3, 62, 2, 120),
(50, 3, 63, 2, 120),
(51, 4, 64, 1, 70),
(52, 3, 65, 1, 60),
(53, 3, 66, 1, 60),
(54, 3, 67, 1, 60),
(55, 3, 68, 2, 120),
(56, 4, 69, 1, 70),
(57, 3, 69, 1, 60),
(58, 3, 70, 1, 60),
(59, 3, 71, 1, 60),
(60, 4, 72, 1, 70),
(61, 4, 73, 1, 70),
(62, 4, 74, 1, 70),
(63, 4, 75, 1, 70),
(64, 3, 76, 1, 60),
(65, 3, 77, 1, 60),
(66, 3, 78, 1, 60),
(67, 3, 79, 1, 60),
(68, 3, 80, 1, 60),
(69, 4, 81, 1, 70),
(70, 4, 82, 1, 70),
(71, 4, 83, 1, 70),
(72, 4, 84, 1, 70),
(73, 4, 85, 1, 70),
(74, 3, 86, 1, 60),
(75, 3, 87, 1, 60);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `product_type_id` (`product_type_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`product_type_id`);

--
-- Indexes for table `smartcard`
--
ALTER TABLE `smartcard`
  ADD PRIMARY KEY (`smartcard_id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `topup_close`
--
ALTER TABLE `topup_close`
  ADD PRIMARY KEY (`topup_close_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `smartcard_id` (`smartcard_id`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`withdraw_id`),
  ADD KEY `smartcard_id` (`smartcard_id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `withdraw_detail`
--
ALTER TABLE `withdraw_detail`
  ADD PRIMARY KEY (`withdraw_detail_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `withdraw_id` (`withdraw_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `store_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `topup_close`
--
ALTER TABLE `topup_close`
  MODIFY `topup_close_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `withdraw_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `withdraw_detail`
--
ALTER TABLE `withdraw_detail`
  MODIFY `withdraw_detail_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`product_type_id`) REFERENCES `product_type` (`product_type_id`);

--
-- Constraints for table `topup_close`
--
ALTER TABLE `topup_close`
  ADD CONSTRAINT `topup_close_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `topup_close_ibfk_2` FOREIGN KEY (`smartcard_id`) REFERENCES `smartcard` (`smartcard_id`);

--
-- Constraints for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD CONSTRAINT `withdraw_ibfk_1` FOREIGN KEY (`smartcard_id`) REFERENCES `smartcard` (`smartcard_id`),
  ADD CONSTRAINT `withdraw_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`);

--
-- Constraints for table `withdraw_detail`
--
ALTER TABLE `withdraw_detail`
  ADD CONSTRAINT `withdraw_detail_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `withdraw_detail_ibfk_2` FOREIGN KEY (`withdraw_id`) REFERENCES `withdraw` (`withdraw_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
