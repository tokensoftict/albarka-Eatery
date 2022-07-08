-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2020 at 09:38 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final_year`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

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

CREATE TABLE `others` (
  `SN` int(11) NOT NULL,
  `vat` int(11) NOT NULL,
  `scharge` int(11) NOT NULL,
  `sname` text NOT NULL,
  `saddress_1` text NOT NULL,
  `saddress_2` text NOT NULL,
  `scontact_no` text NOT NULL,
  `slogo` varchar(250) NOT NULL,
  `expire_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `others`
--

INSERT INTO `others` (`SN`, `vat`, `scharge`, `sname`, `saddress_1`, `saddress_2`, `scontact_no`, `slogo`, `expire_count`) VALUES
(1, 0, 0, '', '', '', '', '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `SN` int(11) NOT NULL,
  `payment_method` varchar(300) NOT NULL,
  `defaults` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`SN`, `payment_method`, `defaults`) VALUES
(1, 'CASH', 1),
(2, 'POS', 1),
(3, 'TRANSFER', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_bar_code`
--

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

CREATE TABLE `sales` (
  `SN` int(11) NOT NULL,
  `reciept_id` varchar(100) NOT NULL,
  `items` longtext NOT NULL,
  `discount_type` int(11) NOT NULL,
  `discount` decimal(16,2) NOT NULL,
  `total_amount` decimal(16,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_` varchar(20) NOT NULL,
  `payment_type` enum('Direct','Invoice') NOT NULL,
  `payment_method` int(11) NOT NULL,
  `waiter_id` int(11) NOT NULL,
  `customer` varchar(200) NOT NULL,
  `reservation_invoice_link` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  `vat` int(11) NOT NULL,
  `scharge` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`SN`, `reciept_id`, `items`, `discount_type`, `discount`, `total_amount`, `user_id`, `date`, `time_`, `payment_type`, `payment_method`, `waiter_id`, `customer`, `reservation_invoice_link`, `comment`, `branch_id`, `vat`, `scharge`, `created`, `modified`) VALUES
(1, 'VW27819', '[{\"item_name\":\"Milo\",\"item_price\":\"1200.00\",\"item_qty\":\"2\",\"total\":2400,\"manu\":\"2020-06-19\",\"exp\":\"2020-06-17\"}]', 2, '0.00', '2400.00', 2, '2020-06-19', '10:06 am', 'Direct', 0, 0, '2', '', '', 0, 0, 0, '2020-06-19 09:57:27', '2020-06-19 09:57:27'),
(2, 'MM91435', '[{\"item_name\":\"Milo\",\"item_price\":\"1200.00\",\"item_qty\":\"2\",\"total\":2400,\"manu\":\"2020-06-19\",\"exp\":\"2020-08-28\"}]', 2, '0.00', '2400.00', 1, '2020-08-26', '08:08 am', 'Direct', 1, 1, 'Walking Customer', '', '', 0, 0, 0, '2020-08-26 07:41:33', '2020-08-26 07:41:33');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `SN` bigint(20) NOT NULL,
  `id_stock` varchar(255) NOT NULL,
  `product_name` tinytext NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(16,2) NOT NULL,
  `cost_price` double(16,2) NOT NULL,
  `manufacturer_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `manufacturer` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`SN`, `id_stock`, `product_name`, `quantity`, `price`, `cost_price`, `manufacturer_date`, `expired_date`, `status`, `manufacturer`, `date_added`, `date_updated`) VALUES
(1, 'GG66546', 'Milo', 40, 1200.00, 1500.00, '2020-06-19', '2020-08-28', 0, 0, '2020-06-19 06:47:03', '2020-08-26 07:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `stock_branch`
--

CREATE TABLE `stock_branch` (
  `ID` bigint(20) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_arena` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_branch`
--

INSERT INTO `stock_branch` (`ID`, `branch_id`, `stock_id`, `quantity`, `quantity_arena`, `created`, `updated`) VALUES
(1, 0, 1, 0, -2, '2020-06-19 08:15:36', '2020-06-19 08:17:33');

-- --------------------------------------------------------

--
-- Table structure for table `stock_recieved`
--

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

--
-- Dumping data for table `stock_recieved`
--

INSERT INTO `stock_recieved` (`SN`, `recieved_id`, `products`, `recieved_date`, `branch`, `reciever_userfullname`, `transfer_user`, `confirm_userfullname`, `note`, `branch_id`, `created`, `updated`) VALUES
(1, 'YJ41145', '[{\"qty\":\"10\",\"product\":\"GG66546\",\"remark\":\"Received\"}]', '2020-08-26', '', 1, 'Akin', '', '', 0, '2020-08-26 07:32:08', '2020-08-26 07:32:08');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenses`
--

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

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`SN`, `payment_id`, `cuustomer`, `amount`, `invoice_id`, `type`, `payment_type`, `department`, `invoice_serial`, `payment_date`, `user`, `branch_id`, `vat`, `scharge`, `modified`, `created`) VALUES
(1, 'MY10389', 0, '2400', 'ZV36996', 'Canteen', 'Direct', 'Sales Arena', 0, '2020-06-19', 1, 0, 0, 0, '2020-06-19 09:15:37', '2020-06-19 09:15:37'),
(2, 'WH74615', 0, '2400', 'ZU30390', 'Canteen', 'Direct', 'Sales Arena', 0, '2020-06-19', 1, 0, 0, 0, '2020-06-19 09:17:34', '2020-06-19 09:17:34'),
(3, 'XO18312', 0, '2400', 'CE19148', 'Canteen', 'Direct', 'Sales Arena', 0, '2020-06-19', 1, 0, 0, 0, '2020-06-19 09:18:18', '2020-06-19 09:18:18'),
(4, 'DR98661', 0, '3600', 'IN42645', 'Canteen', 'Direct', 'Sales Arena', 0, '2020-06-19', 1, 0, 0, 0, '2020-06-19 09:25:41', '2020-06-19 09:25:41'),
(5, 'IO87692', 0, '2400', 'QK42076', 'Canteen', 'Direct', 'Sales Arena', 0, '2020-06-19', 1, 0, 0, 0, '2020-06-19 09:26:35', '2020-06-19 09:26:35'),
(6, 'CJ29194', 0, '2400', 'OJ98196', 'Canteen', 'Direct', 'Sales Arena', 0, '2020-06-19', 1, 0, 0, 0, '2020-06-19 09:28:20', '2020-06-19 09:28:20'),
(7, 'VH44428', 0, '2400', 'QM07796', 'Canteen', 'Direct', 'Sales Arena', 0, '2020-06-19', 1, 0, 0, 0, '2020-06-19 09:30:10', '2020-06-19 09:30:10'),
(8, 'JT41178', 0, '3600', 'XO78033', 'Canteen', 'Direct', 'Sales Arena', 0, '2020-06-19', 1, 0, 0, 0, '2020-06-19 09:38:13', '2020-06-19 09:38:13'),
(9, 'WI57919', 0, '2400', 'VW27819', 'Canteen', 'Direct', 'Sales Arena', 0, '2020-06-19', 2, 0, 0, 0, '2020-06-19 09:57:27', '2020-06-19 09:57:27'),
(10, 'MG10169', 0, '2400', 'MM91435', 'Canteen', 'Direct', 'Sales Arena', 0, '2020-08-26', 1, 0, 0, 0, '2020-08-26 07:41:33', '2020-08-26 07:41:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transfer_recieved`
--

CREATE TABLE `tbl_transfer_recieved` (
  `SN` bigint(20) NOT NULL,
  `tracking_id` varchar(100) NOT NULL,
  `stock_id` varchar(30) NOT NULL,
  `amt_in` varchar(30) NOT NULL,
  `amt_out` varchar(30) NOT NULL,
  `date_` date NOT NULL,
  `balance` varchar(100) NOT NULL,
  `sold` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transfer_recieved`
--

INSERT INTO `tbl_transfer_recieved` (`SN`, `tracking_id`, `stock_id`, `amt_in`, `amt_out`, `date_`, `balance`, `sold`, `user`) VALUES
(1, '0', '1', '0', '2', '2020-08-26', '22', 0, 1),
(2, '0', '1', '0', '2', '2020-08-26', '20', 0, 1),
(3, 'HO03476', '1', '10', '0', '2020-08-26', '30', 0, 1),
(4, 'YJ41145', '1', '10', '0', '2020-08-26', '40', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

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
(1, 'admin', '$2a$08$MRbsgMBjK9PG6YQo4Gx9pupDOXlgPT2djQVvPuJhMyvzwaVFDQz2q', 'admin@admin.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2020-08-26 07:32:01', '2018-07-14 15:34:16', '2020-08-26 05:32:01', 0, 'Administrator'),
(2, 'sales', '$2a$08$MRbsgMBjK9PG6YQo4Gx9pupDOXlgPT2djQVvPuJhMyvzwaVFDQz2q', 'sales@sales.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2020-08-25 23:16:13', '2020-06-19 10:54:49', '2020-08-25 21:16:13', 0, 'Sales Representative');

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

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
(1, 1, NULL, NULL),
(2, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `waiter_name`
--

CREATE TABLE `waiter_name` (
  `SN` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `date_of_birth` date NOT NULL,
  `joined_date` date NOT NULL,
  `gender` varchar(100) NOT NULL,
  `salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `waiter_name`
--

INSERT INTO `waiter_name` (`SN`, `name`, `date_of_birth`, `joined_date`, `gender`, `salary`) VALUES
(1, 'Damilola Olojoku', '2020-08-26', '2020-08-25', 'Female', 20000);

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
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
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
-- Indexes for table `tbl_transfer_recieved`
--
ALTER TABLE `tbl_transfer_recieved`
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
-- Indexes for table `waiter_name`
--
ALTER TABLE `waiter_name`
  ADD PRIMARY KEY (`SN`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_bar_code`
--
ALTER TABLE `product_bar_code`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `SN` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_branch`
--
ALTER TABLE `stock_branch`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_recieved`
--
ALTER TABLE `stock_recieved`
  MODIFY `SN` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `SN` bigint(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_transfer_recieved`
--
ALTER TABLE `tbl_transfer_recieved`
  MODIFY `SN` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `waiter_name`
--
ALTER TABLE `waiter_name`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
