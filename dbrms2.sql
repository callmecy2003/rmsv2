-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2024 at 10:52 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbrms2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcart`
--

CREATE TABLE `tblcart` (
  `id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` float DEFAULT NULL,
  `product_quantity` int(11) NOT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `bottles_per_case` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcart`
--

INSERT INTO `tblcart` (`id`, `user_id`, `product_id`, `product_price`, `product_quantity`, `total_cost`, `bottles_per_case`, `timestamp`) VALUES
(100, 'EEDsXDw2cY', 25, 49, 1, 49.00, 7, '2024-04-21 20:23:06'),
(101, 'EEDsXDw2cY', 23, 84, 2, 84.00, 12, '2024-04-21 20:23:20');

-- --------------------------------------------------------

--
-- Table structure for table `tblmessage`
--

CREATE TABLE `tblmessage` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(20) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblmessage`
--

INSERT INTO `tblmessage` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(0, 0, 'Cy', 'admin@gmail.com', '09215652154', '1151615');

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `id` int(11) NOT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `bottles_per_case` int(11) DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`id`, `productName`, `price`, `quantity`, `bottles_per_case`, `image`) VALUES
(22, 'juicy lemon', 15, -610, 6, '../images/products/jlemon.png'),
(23, 'coke', 7, 9724, 12, '../images/products/431096484_458329116521509_1508463505399006433_n.jpg'),
(24, 'juicy lemon', 32, 10, 23, '../images/products/8b939cc29d59ff9840edfd85127682ee.jpg'),
(25, 'test', 7, 2365, 7, '../images/products/jlemon.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbltransaction`
--

CREATE TABLE `tbltransaction` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_status` enum('Pending','Completed','Cancelled') DEFAULT NULL,
  `archive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbltransaction`
--

INSERT INTO `tbltransaction` (`id`, `user_id`, `transaction_date`, `total_amount`, `payment_method`, `transaction_status`, `archive`) VALUES
(1, 'EEDsXDw2cY', '2024-04-20 17:44:16', 1460.00, '', 'Pending', 0),
(2, 'EEDsXDw2cY', '2024-04-20 17:49:01', 20.00, '', 'Pending', 0),
(3, 'EEDsXDw2cY', '2024-04-20 17:52:21', 20.00, '', 'Pending', 0),
(4, 'EEDsXDw2cY', '2024-04-20 18:00:26', 20.00, '', 'Completed', 0),
(5, 'EEDsXDw2cY', '2024-04-20 18:02:12', 3.00, '', 'Completed', 0),
(6, 'EEDsXDw2cY', '2024-04-20 18:03:38', 18.00, '', 'Completed', 1),
(7, 'EEDsXDw2cY', '2024-04-20 18:05:47', 18.00, '', 'Pending', 0),
(8, 'EEDsXDw2cY', '2024-04-20 18:06:46', 18.00, '', 'Pending', 1),
(9, 'EEDsXDw2cY', '2024-04-20 18:20:11', 36.00, 'cash_on_delivery', 'Pending', 1),
(10, 'EEDsXDw2cY', '2024-04-20 18:21:12', 6.00, 'cash_on_delivery', 'Pending', 1),
(11, 'EEDsXDw2cY', '2024-04-20 18:21:33', 2.00, 'cash_on_delivery', 'Pending', 0),
(12, 'EEDsXDw2cY', '2024-04-20 18:24:38', 36.00, 'cash_on_delivery', 'Pending', 0),
(13, 'EEDsXDw2cY', '2024-04-20 18:24:57', 36.00, 'cash_on_delivery', 'Pending', 0),
(14, 'EEDsXDw2cY', '2024-04-20 18:28:47', 72.00, 'cash_on_delivery', 'Pending', 0),
(15, 'EEDsXDw2cY', '2024-04-20 18:33:59', 18.00, 'cash_on_delivery', 'Pending', 0),
(16, 'EEDsXDw2cY', '2024-04-20 18:34:15', 18.00, 'cash_on_delivery', 'Pending', 0),
(17, 'EEDsXDw2cY', '2024-04-20 18:37:03', 18.00, 'cash_on_delivery', 'Pending', 0),
(18, 'EEDsXDw2cY', '2024-04-21 14:23:50', 120.00, 'gcash', 'Pending', 0),
(19, 'EEDsXDw2cY', '2024-04-21 15:19:43', 48.00, 'cash_on_delivery', 'Pending', 0),
(20, 'wug414GZIi', '2024-04-21 15:39:42', 29.00, 'paymaya', 'Pending', 0),
(21, 'EEDsXDw2cY', '2024-04-21 20:22:23', 224.00, 'cash_on_delivery', 'Pending', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbltransaction_items`
--

CREATE TABLE `tbltransaction_items` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbltransaction_items`
--

INSERT INTO `tbltransaction_items` (`id`, `transaction_id`, `product_id`, `product_name`, `product_price`, `quantity`, `total_price`) VALUES
(1, 1, 19, '0', 20.00, 73, 1460.00),
(2, 2, 17, '0', 20.00, 1, 20.00),
(3, 3, 17, '0', 20.00, 1, 20.00),
(4, 4, 17, '0', 20.00, 1, 20.00),
(5, 5, 16, '3', 3.00, 1, 3.00),
(6, 6, 6, '0', 18.00, 1, 18.00),
(7, 7, 6, '0', 18.00, 1, 18.00),
(8, 8, 6, '0', 18.00, 1, 18.00),
(9, 9, 6, '0', 18.00, 1, 18.00),
(10, 10, 16, '3', 3.00, 1, 3.00),
(11, 11, 15, '123', 1.00, 1, 1.00),
(12, 12, 12, '0', 18.00, 1, 18.00),
(13, 13, 6, '0', 18.00, 1, 18.00),
(14, 14, 1, '0', 18.00, 1, 18.00),
(15, 14, 1, '0', 18.00, 1, 18.00),
(16, 15, 1, '0', 18.00, 1, 18.00),
(17, 16, 1, '0', 18.00, 1, 18.00),
(18, 17, 1, '0', 18.00, 1, 18.00),
(19, 18, 21, '0', 20.00, 6, 120.00),
(20, 19, 1, 'Fanta', 18.00, 1, 18.00),
(21, 19, 8, 'juicy lemon', 15.00, 2, 30.00),
(22, 20, 22, 'juicy lemon', 15.00, 1, 15.00),
(23, 20, 23, 'coke', 7.00, 2, 14.00),
(24, 21, 25, '', 7.00, 15, 105.00),
(25, 21, 23, '', 7.00, 17, 119.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `contact` varchar(11) NOT NULL,
  `userType` enum('admin','client','employee') NOT NULL,
  `address` varchar(100) NOT NULL,
  `verification` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `username`, `password`, `email`, `fullname`, `gender`, `contact`, `userType`, `address`, `verification`) VALUES
('0', 'admin', '$2y$10$LFLdSR.9ssWimzAiAyUt7OyBACADo9m1gREkZNch1tgoPKaTPBgSu', 'admin@gmail.com', 'admin a admin', 'male', '0', 'admin', 'admin, admin, Bagong Nayon', 1),
('1', 'emp', '$2y$10$QWhky8SL.dYKGEBm2hPmDO0yP3jA4u7bHGjv0mzM6mr7m6nWf5Qem', 'emp@gmail.com', 'emp emp emp', 'male', '09208920761', 'employee', 'emp, emp, Bagong Nayon, Antipolo City, Rizal, 1870', 1),
('3IhJYnAPBu', 'test', '$2y$10$pt2oqBM3khptd5hSYCrBjORL6Uktu2ILJg8EPsgVnzB5nh1Z1Qh7u', 'test@gmail.com', 'Isaiah R. Luciano', 'male', '09208920761', 'client', 'E17, 3, San Isidro, Antipolo City, Rizal, 1870', 1),
('8Ga850gST4', 'carlo', '$2y$10$HfUBpUI4/GWUCmAr/SHvr.ELAUQCRMAmVHOQTHxXNX09KYOL37Rnq', 'carlo@gmail.com', 'Isaiah R. Luciano', 'male', '09876532145', 'client', 'E17, G1, Bagong Nayon, Antipolo City, Rizal, 1870', 1),
('EEDsXDw2cY', 'IsaiahLuciano', '$2y$10$43adjnn/qVntPfYKUl9poeh5Dk6Y3SXobvF7NAjnhQpTtFGstMHz6', 'isaiahreyesluciano@gmail.com', 'Isaiah R. Luciano', 'male', '2147483647', 'client', 'E17, G1, San Jose, Antipolo City, Rizal, 1870', 1),
('vl1ydxvqr1', 'rigel', '$2y$10$ujLbUIppGxPQt9xvXygoFOXlpVrCyp1kgeQdC4Tqzlhhk4S0TncrO', 'rigel@gmail.com', 'Isaiah R. Luciano', 'male', '09165406718', 'client', 'E17, G1, Bagong Nayon, Antipolo City, Rizal, 1870', 1),
('wug414GZIi', 'Azrael', '$2y$10$bOSt3mWZkLuSBeYLOcq0nuhhBa21tTRJap1m50vgFOLNKV9Afp7u.', 'rigel1@gmail.com', 'Rigel Azrael  Bautista  Navaro', 'female', '09165406718', 'client', 'B43 L32, tulip, Dela Paz, Antipolo City, Rizal, 1870', 1),
('Z7PsqnUnss', 'admin', '$2y$10$urczmcVcbPANIJc8Wojh/.SmI0EUccBdnWDuWqUQvF99WKFctRItG', 'yes@gmail.com', 'Isaiah a admin', 'male', '00000000000', 'client', 'admin, emp, Beverly Hills, Antipolo City, Rizal, 1870', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltransaction`
--
ALTER TABLE `tbltransaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltransaction_items`
--
ALTER TABLE `tbltransaction_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcart`
--
ALTER TABLE `tblcart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbltransaction`
--
ALTER TABLE `tbltransaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbltransaction_items`
--
ALTER TABLE `tbltransaction_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD CONSTRAINT `tblcart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tblproduct` (`id`);

--
-- Constraints for table `tbltransaction_items`
--
ALTER TABLE `tbltransaction_items`
  ADD CONSTRAINT `tbltransaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `tbltransaction` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
