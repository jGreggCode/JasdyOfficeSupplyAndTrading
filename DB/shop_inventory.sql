-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2025 at 12:14 PM
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
-- Database: `shop_inventory`
--
CREATE DATABASE IF NOT EXISTS `shop_inventory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `shop_inventory`;

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `auditID` int(11) NOT NULL,
  `time` varchar(200) NOT NULL,
  `userID` int(11) NOT NULL,
  `usertype` varchar(45) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `Action` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`auditID`, `time`, `userID`, `usertype`, `userName`, `Action`) VALUES
(2022332, '2025-06-20 19:21:07', 2020158, 'Admin', 'John Gregg Felicisimo', 'Account: (2020158) Updated Item 2024114'),
(2022333, '2025-06-20 19:21:44', 2020158, 'Admin', 'John Gregg Felicisimo', 'Account: (2020158) Updated Item 2024114'),
(2022334, '2025-06-20 19:44:41', 2020159, 'Reseller', 'eunice ', 'eunice  has registered under account name \"eunice\"'),
(2022335, '2025-06-20 19:50:03', 2020158, 'Admin', 'John Gregg Felicisimo', 'Account: (2020158) Activated 2020159'),
(2022336, '2025-06-20 19:55:27', 2020160, 'Reseller', 'john doe', 'john doe has registered under account name \"Jonny Doe\"'),
(2022337, '2025-06-20 19:57:34', 2020161, 'Reseller', 'john doe', 'john doe has registered under account name \"Jonny Doe\"'),
(2022338, '2025-06-20 20:00:55', 2020158, 'Admin', 'John Gregg Felicisimo', 'Account: (2020158) Activated 2020161'),
(2022339, '2025-07-08 13:34:51', 2020162, 'Reseller', 'John Deep', 'John Deep has registered under account name \"johndeep\"'),
(2022340, '2025-07-08 13:35:29', 2020158, 'Admin', 'John Gregg Felicisimo', 'Account: (2020158) Activated 2020162'),
(2022341, '2025-07-08 13:36:39', 2020158, 'Admin', 'John Gregg Felicisimo', 'Account: (2020158) Updated 2020162 details.'),
(2022342, '2025-07-08 13:37:02', 2020158, 'Admin', 'John Gregg Felicisimo', 'Account: (2020158) Updated 2020162 details.');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) NOT NULL,
  `phone2` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `district` varchar(30) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `productID` int(11) NOT NULL,
  `category` varchar(45) DEFAULT NULL,
  `itemNumber` varchar(255) DEFAULT NULL,
  `itemName` varchar(255) DEFAULT NULL,
  `discount` float NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL DEFAULT 0,
  `costing` float NOT NULL DEFAULT 0,
  `unitPrice` float NOT NULL DEFAULT 0,
  `imageURL` varchar(255) NOT NULL DEFAULT 'imageNotAvailable.jpg',
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`productID`, `category`, `itemNumber`, `itemName`, `discount`, `stock`, `costing`, `unitPrice`, `imageURL`, `status`, `description`) VALUES
(2024114, 'Ballpen', 'PEN101', 'Sign Pen', 0, 0, 0, 10, '1748388365_IMG_20250428_180017_905.jpg', 'Active', 'Inkless');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `orderID` int(11) NOT NULL,
  `saleID` int(11) NOT NULL,
  `itemNumber` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unitPrice` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`orderID`, `saleID`, `itemNumber`, `quantity`, `unitPrice`) VALUES
(37, 2026130, 'PEN101', 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchaseID` int(11) NOT NULL,
  `itemNumber` varchar(255) NOT NULL,
  `purchaseDate` date NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `unitPrice` float NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `vendorName` varchar(255) NOT NULL DEFAULT 'Test Vendor',
  `vendorID` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `saleID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `sellerID` int(11) NOT NULL,
  `customerName` varchar(255) NOT NULL,
  `itemNumber` varchar(255) DEFAULT NULL,
  `saleDate` date NOT NULL,
  `payment` varchar(255) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  `itemName` varchar(255) DEFAULT NULL,
  `discount` float DEFAULT 0,
  `quantity` int(11) DEFAULT 0,
  `unitPrice` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`saleID`, `customerID`, `sellerID`, `customerName`, `itemNumber`, `saleDate`, `payment`, `status`, `itemName`, `discount`, `quantity`, `unitPrice`) VALUES
(2026130, 281881, 2020158, '', NULL, '2024-11-06', '0', 'Active', NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `usertype` varchar(45) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT 'No email',
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Disabled',
  `sales` bigint(20) DEFAULT 0,
  `sold` bigint(20) DEFAULT 0,
  `mobile` varchar(255) DEFAULT 'N/A',
  `location` varchar(255) DEFAULT 'N/A',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `usertype`, `fullName`, `username`, `email`, `password`, `status`, `sales`, `sold`, `mobile`, `location`, `reset_token`, `reset_expires`) VALUES
(2020157, 'Employee', 'John Gregg Felicisimo', 'jgregg', 'felicisimojv@gmail.com', 'a4feb7cf38b7c0da58c09188f8dd57ff', 'Active', 0, 0, '09917822877', 'N/A', NULL, NULL),
(2020158, 'Admin', 'John Gregg Felicisimo', 'admin', 'jgreggfel@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Active', 100, 10, '09917822877', 'Lucena, Quezon', '733cab96acb3b13b51d52021fbb5f94f71870d8eebdf104d1850f983d09696fd', '2025-07-08 13:44:42'),
(2020161, 'Reseller', 'john doe', 'johndoe', 'theprojectzilch@gmail.com', '0192023a7bbd73250516f069df18b500', 'Active', 0, 0, '09917822877', 'N/A', NULL, NULL),
(2020162, 'Employee', 'JG FEL', 'johndeep', 'jgdev101613@gmail.com', '0192023a7bbd73250516f069df18b500', 'Active', 0, 0, '09917822877', 'N/A', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendorID` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `district` varchar(30) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`auditID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchaseID`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`saleID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendorID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `auditID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2022343;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2023117;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2024115;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchaseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2025106;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `saleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2026131;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2020163;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2027115;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
