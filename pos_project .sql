-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2018 at 03:43 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
CREATE TABLE `branch` (
  `SN` int(11) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `branch_address` tinytext NOT NULL,
  `delete_status` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE `manufacturer` (
  `SN` int(11) NOT NULL,
  `manufacturer` tinytext NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `moved_history`
--

DROP TABLE IF EXISTS `moved_history`;
CREATE TABLE `moved_history` (
  `SN` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `from` varchar(100) NOT NULL,
  `to` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `qty_moved` int(11) NOT NULL,
  `remaining_qty` int(11) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `others`
--

DROP TABLE IF EXISTS `others`;
CREATE TABLE `others` (
  `SN` int(11) NOT NULL,
  `vat` int(11) NOT NULL,
  `scharge` int(11) NOT NULL,
  `sname` text NOT NULL,
  `saddress_1` text NOT NULL,
  `saddress_2` text NOT NULL,
  `scontact_no` text NOT NULL,
  `slogo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `others`
--

INSERT INTO `others` (`SN`, `vat`, `scharge`, `sname`, `saddress_1`, `saddress_2`, `scontact_no`, `slogo`) VALUES
(1, 0, 0, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_bar_code`
--

DROP TABLE IF EXISTS `product_bar_code`;
CREATE TABLE `product_bar_code` (
  `SN` int(11) NOT NULL,
  `bar_code` tinytext NOT NULL,
  `stock_id` int(11) NOT NULL,
  `date_available` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `recieved_ref` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales` (
  `SN` int(11) NOT NULL,
  `reciept_id` varchar(100) NOT NULL,
  `items` longtext NOT NULL,
  `discount_type` int(11) NOT NULL,
  `discount` decimal(16,2) NOT NULL,
  `total_amount` decimal(16,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `payment_type` enum('Direct','Invoice') NOT NULL,
  `customer` varchar(200) NOT NULL,
  `reservation_invoice_link` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  `vat` int(11) NOT NULL,
  `scharge` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `SN` bigint(20) NOT NULL,
  `id_stock` varchar(255) NOT NULL,
  `product_name` tinytext NOT NULL,
  `product_description` longtext NOT NULL,
  `model` tinytext NOT NULL,
  `price` double(16,2) NOT NULL,
  `date_available` date NOT NULL,
  `image` tinytext NOT NULL,
  `product_code` varchar(300) NOT NULL,
  `status` int(11) NOT NULL,
  `manufacturer` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_branch`
--

DROP TABLE IF EXISTS `stock_branch`;
CREATE TABLE `stock_branch` (
  `ID` bigint(20) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_arena` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_recieved`
--

DROP TABLE IF EXISTS `stock_recieved`;
CREATE TABLE `stock_recieved` (
  `SN` bigint(11) NOT NULL,
  `recieved_id` varchar(25) NOT NULL,
  `products` longtext NOT NULL,
  `recieved_date` date NOT NULL,
  `branch` varchar(200) NOT NULL,
  `reciever_userfullname` int(11) NOT NULL,
  `transfer_user` varchar(255) NOT NULL,
  `confirm_userfullname` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

DROP TABLE IF EXISTS `stock_transfer`;
CREATE TABLE `stock_transfer` (
  `SN` bigint(11) NOT NULL,
  `transfer_id` varchar(25) NOT NULL,
  `products` longtext NOT NULL,
  `transfer_date` date NOT NULL,
  `branch` int(11) NOT NULL,
  `transfer_user` int(11) NOT NULL,
  `reciever_userfullname` varchar(255) NOT NULL,
  `confirm_userfullname` varchar(255) NOT NULL,
  `branch_id` varchar(200) NOT NULL,
  `note` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `SN` bigint(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_address` tinytext NOT NULL,
  `supplier_email` varchar(255) NOT NULL,
  `supplier_phone_number` varchar(16) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

DROP TABLE IF EXISTS `tbl_customers`;
CREATE TABLE `tbl_customers` (
  `SN` bigint(11) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` tinytext NOT NULL,
  `city` varchar(40) NOT NULL,
  `additional_info` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`SN`, `firstname`, `lastname`, `email`, `phone`, `address`, `city`, `additional_info`, `branch_id`, `updated`, `created`) VALUES
(1, 'Yusuf', 'Olatunji', 'yoyforever@gmail.com', '08130610626', 'Airport Road Ilorin Kwara State Nigeria', 'Ilorin', '', 0, '2018-02-08 11:29:19', '2018-02-08 11:29:19'),
(2, 'Chinwe ', 'Esther', 'yoyforever@gmail.com', '08130610626', 'Airport Road Ilorin Kwara State Nigeria', 'Ilorin', '', 0, '2018-02-13 13:17:46', '2018-02-13 13:17:46'),
(3, 'Ale', 'Rapheal', 'yoyforever@gmail.com', '08130610626', 'Airport Road Ilorin Kwara State Nigeria', 'Ilorin', '', 0, '2018-02-13 13:18:38', '2018-02-13 13:18:38'),
(4, 'Oladipo', 'Olatunde', 'yoyforever@gmail.com', '08130610626', 'Airport Road Ilorin Kwara State Nigeria', 'Ilorin', '', 0, '2018-02-13 13:19:52', '2018-02-13 13:19:52'),
(5, 'Aishat', 'Bello', 'yoyforever@gmail.com', '08130610626', 'Airport Road Ilorin Kwara State Nigeria', 'Ilorin', '', 0, '2018-02-13 13:21:06', '2018-02-13 13:21:06'),
(6, 'Ogunmola', 'Taiye', 'yoyforever@gmail.com', '08130610626', 'Airport Road Ilorin Kwara State Nigeria', 'Ilorin', '', 0, '2018-02-13 13:22:19', '2018-02-13 13:22:19'),
(7, 'Hakeem', 'Salman Akande', 'yoyforever@gmail.com', '08130610626', 'Kwara State', 'Ilorin', '', 0, '2018-02-13 13:25:31', '2018-02-13 13:25:31'),
(9, 'Student', 'Mystideny', 'yoyforever@gmail.com', '8130610626', 'Airport Road Ilorin Kwara State Nigeria', 'Ilorin', '', 0, '2018-02-13 16:37:20', '2018-02-13 16:37:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenses`
--

DROP TABLE IF EXISTS `tbl_expenses`;
CREATE TABLE `tbl_expenses` (
  `SN` bigint(11) NOT NULL,
  `expense_date` date NOT NULL,
  `month` varchar(15) NOT NULL,
  `month_number` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `expense_total_amount` decimal(10,0) NOT NULL,
  `expense_purpose` text NOT NULL,
  `expense_purpose_title` tinytext NOT NULL,
  `branch_id` int(11) NOT NULL,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_history`
--

DROP TABLE IF EXISTS `tbl_invoice_history`;
CREATE TABLE `tbl_invoice_history` (
  `SN` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `invoice_id` varchar(20) NOT NULL,
  `department` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `user_created` int(11) NOT NULL,
  `last_modeified_user` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer` int(11) NOT NULL,
  `invoice_item` mediumtext NOT NULL,
  `reservation_invoice_link` varchar(100) NOT NULL,
  `payment_id` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `payment_serial` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `vat` int(11) NOT NULL,
  `scharge` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

DROP TABLE IF EXISTS `tbl_payment`;
CREATE TABLE `tbl_payment` (
  `SN` int(11) NOT NULL,
  `payment_id` varchar(50) NOT NULL,
  `cuustomer` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `invoice_id` varchar(60) NOT NULL,
  `type` varchar(100) NOT NULL,
  `payment_type` enum('Invoice','Direct') NOT NULL DEFAULT 'Invoice',
  `department` varchar(100) NOT NULL,
  `invoice_serial` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `user` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `vat` int(11) NOT NULL,
  `scharge` int(11) NOT NULL,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `branch_id` int(11) NOT NULL,
  `role` enum('Sales Representative','Administrator','Branch Head') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`, `branch_id`, `role`) VALUES
(1, 'admin', '$2a$08$MRbsgMBjK9PG6YQo4Gx9pupDOXlgPT2djQVvPuJhMyvzwaVFDQz2q', 'admin@admin.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2018-07-14 15:38:08', '2018-07-14 15:34:16', '2018-07-14 13:40:00', 0, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

DROP TABLE IF EXISTS `user_autologin`;
CREATE TABLE `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `country`, `website`) VALUES
(1, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `moved_history`
--
ALTER TABLE `moved_history`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `others`
--
ALTER TABLE `others`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `product_bar_code`
--
ALTER TABLE `product_bar_code`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `stock_branch`
--
ALTER TABLE `stock_branch`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `stock_recieved`
--
ALTER TABLE `stock_recieved`
  ADD PRIMARY KEY (`SN`),
  ADD UNIQUE KEY `transfer_id` (`recieved_id`);

--
-- Indexes for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  ADD PRIMARY KEY (`SN`),
  ADD UNIQUE KEY `transfer_id` (`transfer_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `tbl_invoice_history`
--
ALTER TABLE `tbl_invoice_history`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_autologin`
--
ALTER TABLE `user_autologin`
  ADD PRIMARY KEY (`key_id`,`user_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moved_history`
--
ALTER TABLE `moved_history`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `others`
--
ALTER TABLE `others`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product_bar_code`
--
ALTER TABLE `product_bar_code`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `SN` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_branch`
--
ALTER TABLE `stock_branch`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_recieved`
--
ALTER TABLE `stock_recieved`
  MODIFY `SN` bigint(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  MODIFY `SN` bigint(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SN` bigint(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `SN` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  MODIFY `SN` bigint(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_invoice_history`
--
ALTER TABLE `tbl_invoice_history`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
