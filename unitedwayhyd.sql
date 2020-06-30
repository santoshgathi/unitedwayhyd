-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 30, 2020 at 07:25 AM
-- Server version: 5.7.26
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unitedwayhyd`
--

-- --------------------------------------------------------

--
-- Table structure for table `80guploads`
--

DROP TABLE IF EXISTS `80guploads`;
CREATE TABLE IF NOT EXISTS `80guploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(150) NOT NULL,
  `donor_name` varchar(150) NOT NULL,
  `pan_no` varchar(25) NOT NULL,
  `email` varchar(150) NOT NULL,
  `sum_monthly_contribution` float(10,2) NOT NULL,
  `amount_in_words` varchar(255) DEFAULT NULL,
  `trns_date` datetime NOT NULL,
  `ref_details` varchar(255) NOT NULL,
  `bank` varchar(150) NOT NULL,
  `pdf_80g` char(25) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `donation_cause` varchar(100) DEFAULT NULL,
  `sent_email` char(10) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `receipt_no_unique` (`receipt_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `appointment_date` date NOT NULL,
  `visit_purpose` varchar(255) NOT NULL,
  `approval` char(3) NOT NULL DEFAULT 'no',
  `applied_by` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`appointment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE IF NOT EXISTS `areas` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(255) NOT NULL,
  PRIMARY KEY (`area_id`),
  UNIQUE KEY `area_name` (`area_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

DROP TABLE IF EXISTS `donors`;
CREATE TABLE IF NOT EXISTS `donors` (
  `donor_id` int(32) NOT NULL AUTO_INCREMENT,
  `donor_name` varchar(100) NOT NULL,
  `donor_phone` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`donor_id`),
  UNIQUE KEY `donor_name` (`donor_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expenditures`
--

DROP TABLE IF EXISTS `expenditures`;
CREATE TABLE IF NOT EXISTS `expenditures` (
  `expenditure_id` int(11) NOT NULL AUTO_INCREMENT,
  `expenditure_dt` datetime NOT NULL,
  `donor_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `nutrition_hygiene_kit` smallint(5) NOT NULL DEFAULT '0',
  `meals` smallint(5) NOT NULL DEFAULT '0',
  `medical_equipment` smallint(5) NOT NULL DEFAULT '0',
  `sanitation_material` smallint(5) NOT NULL DEFAULT '0',
  `ppe_kits` smallint(5) NOT NULL DEFAULT '0',
  `amount_spent` int(15) NOT NULL,
  `uwh_admin` int(15) NOT NULL,
  PRIMARY KEY (`expenditure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `user_role` char(25) NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `full_name` (`full_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
