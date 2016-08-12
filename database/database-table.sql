-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2016 at 03:18 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `oc_ebay_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `oc_ebay_category`
--

CREATE TABLE `oc_ebay_category` (
	`category_id` bigint(20) NOT NULL DEFAULT '0',
	`category_parent` bigint(20) DEFAULT NULL,
	`category_level` int(11) DEFAULT NULL,
	`category_name` varchar(250) DEFAULT NULL,
	`bestofferenabled` varchar(50) DEFAULT NULL,
	`autopayenabled` varchar(50) DEFAULT NULL,
	`time_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oc_ebay_category`
--


-- --------------------------------------------------------

--
-- Table structure for table `oc_ebay_listing_history`
--

CREATE TABLE `oc_ebay_listing_history` (
	`history_id` int(11) NOT NULL,
	`product_id` int(11) NOT NULL,
	`template_id` int(11) NOT NULL,
	`item_id` int(11) NOT NULL,
	`item_url` varchar(300) NOT NULL,
	`status` varchar(50) NOT NULL,
	`time_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oc_ebay_listing_history`
--



-- --------------------------------------------------------

--
-- Table structure for table `oc_ebay_listing_template`
--

CREATE TABLE `oc_ebay_listing_template` (
	`template_id` int(11) NOT NULL,
	`template_name` varchar(200) DEFAULT NULL,
	`listing_type` varchar(100) DEFAULT NULL,
	`listing_duration` varchar(50) DEFAULT NULL,
	`default_template` tinyint(1) NOT NULL DEFAULT '0',
	`item_condition` bigint(10) DEFAULT NULL,
	`condition_description` text,
	`currency` varchar(3) DEFAULT NULL,
	`country` varchar(2) DEFAULT NULL,
	`postal_code` bigint(10) DEFAULT NULL,
	`pricing_mode` varchar(50) DEFAULT NULL,
	`price_action` varchar(1) DEFAULT NULL,
	`price_method` varchar(10) DEFAULT NULL,
	`price_value` varchar(20) DEFAULT NULL,
	`category_id` bigint(10) DEFAULT NULL,
	`quantity` varchar(20) DEFAULT NULL,
	`payment_methods` text,
	`paypal_email` varchar(200) DEFAULT NULL,
	`return_accepted` varchar(100) DEFAULT NULL,
	`refund_option` varchar(200) DEFAULT NULL,
	`return_within` varchar(50) DEFAULT NULL,
	`return_description` text,
	`return_cost_payed_by` varchar(150) DEFAULT NULL,
	`shipping_type` varchar(50) DEFAULT NULL,
	`package_type` varchar(50) DEFAULT NULL,
	`package_depth` varchar(10) DEFAULT NULL,
	`package_length` varchar(10) DEFAULT NULL,
	`package_width` varchar(10) DEFAULT NULL,
	`package_weight` varchar(10) DEFAULT NULL,
	`shipping_duration` varchar(10) DEFAULT NULL,
	`shipping_details` text,
	`time_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oc_ebay_listing_template`
--



-- --------------------------------------------------------

--
-- Table structure for table `oc_ebay_order_history`
--

CREATE TABLE `oc_ebay_order_history` (
	`ohistory_id` int(11) NOT NULL,
	`item_id` bigint(20) DEFAULT NULL,
	`time_log` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oc_ebay_settings`
--

CREATE TABLE `oc_ebay_settings` (
	`setting_id` int(11) NOT NULL,
	`user_token` text,
	`dev_id` text,
	`app_id` text,
	`cert_id` text,
	`error_language` varchar(5) DEFAULT NULL,
	`site_id` int(1) DEFAULT NULL,
	`listing_mode` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oc_ebay_settings`
--



--
-- Indexes for dumped tables
--

--
-- Indexes for table `oc_ebay_category`
--
ALTER TABLE `oc_ebay_category`
ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `oc_ebay_listing_history`
--
ALTER TABLE `oc_ebay_listing_history`
ADD PRIMARY KEY (`history_id`);

--
-- Indexes for table `oc_ebay_listing_template`
--
ALTER TABLE `oc_ebay_listing_template`
ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `oc_ebay_order_history`
--
ALTER TABLE `oc_ebay_order_history`
ADD PRIMARY KEY (`ohistory_id`);

--
-- Indexes for table `oc_ebay_settings`
--
ALTER TABLE `oc_ebay_settings`
ADD PRIMARY KEY (`setting_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oc_ebay_listing_history`
--
ALTER TABLE `oc_ebay_listing_history`
MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `oc_ebay_listing_template`
--
ALTER TABLE `oc_ebay_listing_template`
MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `oc_ebay_order_history`
--
ALTER TABLE `oc_ebay_order_history`
MODIFY `ohistory_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oc_ebay_settings`
--
ALTER TABLE `oc_ebay_settings`
MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;