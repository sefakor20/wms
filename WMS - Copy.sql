-- phpMyAdmin SQL Dump
-- version 4.4.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2018 at 03:59 PM
-- Server version: 5.5.60-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `WMS`
--

-- --------------------------------------------------------

--
-- Table structure for table `Account_Status`
--

CREATE TABLE IF NOT EXISTS `Account_Status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Account_Status`
--

INSERT INTO `Account_Status` (`id`, `name`) VALUES
(1, 'Active'),
(2, 'Deactivate');

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE IF NOT EXISTS `Category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`id`, `name`) VALUES
(1, 'tablet'),
(2, 'cyrup');

-- --------------------------------------------------------

--
-- Table structure for table `Client_Stock`
--

CREATE TABLE IF NOT EXISTS `Client_Stock` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Client_Stock`
--

INSERT INTO `Client_Stock` (`id`, `item_id`, `category_id`, `quantity`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 207, 2, '2018-05-29 13:54:28', '2018-05-30 18:27:58'),
(2, 3, 1, 245, 2, '2018-05-29 14:42:13', '2018-06-06 16:44:52'),
(3, 4, 2, 334, 2, '2018-05-30 18:27:08', '2018-06-05 12:50:09');

-- --------------------------------------------------------

--
-- Table structure for table `Client_Stock_Request`
--

CREATE TABLE IF NOT EXISTS `Client_Stock_Request` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Client_Stock_Request`
--

INSERT INTO `Client_Stock_Request` (`id`, `item_id`, `category_id`, `quantity`, `client_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100, 2, 2, '2018-05-21 12:00:32', '2018-05-21 16:13:47'),
(2, 4, 1, 400, 2, 1, '2018-05-21 12:01:17', NULL),
(3, 3, 1, 0, 2, 3, '2018-05-28 11:54:33', '2018-05-28 11:55:29'),
(4, 1, 1, 30, 2, 2, '2018-05-28 13:29:41', '2018-05-28 19:07:10'),
(5, 3, 1, 67, 2, 1, '2018-05-30 11:29:48', NULL),
(6, 1, 1, 0, 2, 3, '2018-05-30 11:31:37', '2018-05-30 11:32:30'),
(7, 4, 2, 0, 2, 3, '2018-05-30 11:45:17', '2018-06-05 12:49:24'),
(8, 4, 2, 0, 2, 3, '2018-05-30 18:26:15', '2018-05-30 18:26:48'),
(10, 3, 1, 0, 2, 3, '2018-06-01 14:00:04', '2018-06-06 16:44:16');

-- --------------------------------------------------------

--
-- Table structure for table `Company`
--

CREATE TABLE IF NOT EXISTS `Company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_group` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Company`
--

INSERT INTO `Company` (`id`, `name`, `user_group`, `status`, `username`, `password`, `tel`, `created_at`, `updated_at`) VALUES
(1, 'Must Flow chemical shop', 1, 1, 'mustflow', '$2y$10$UPwcy4eRY7EJ9ke3Wmcatebj.CB5wA1tjDe1aZMfSrVy2X9N3oKcS', '0203456787', '2018-05-11 20:50:22', '2018-05-18 11:35:17'),
(2, 'Nana and Son''s Pharmacy Limited', 2, 1, 'nana', '$2y$10$jsalfYiPqk4ULJB6B7dGuO6.93cJC7/cPzby2bNg4vhEpQgnq2Y7S', '0203456756', '2018-05-11 20:51:47', '2018-06-01 14:23:18'),
(3, 'Ernest Chemist', 1, 1, 'ernest', '$2y$10$3qnR1ZKZ5AiEQ2vtBvEb0elw.7lk.izxor8y6faZox5I5V4KxuCsu', '0203456711', '2018-05-14 13:54:06', '2018-06-06 09:14:06'),
(4, 'pieroo chemicals', 1, 1, 'piero', '$2y$10$M9JSJXIAYEE75mNeqaaJp.NZgyETnpJT3dg/rg24luITV2LjWC4pq', '0203456711', '2018-06-06 16:38:55', '2018-06-06 16:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `Company_Group`
--

CREATE TABLE IF NOT EXISTS `Company_Group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Company_Group`
--

INSERT INTO `Company_Group` (`id`, `name`) VALUES
(1, 'Supplier'),
(2, 'Client');

-- --------------------------------------------------------

--
-- Table structure for table `Employee_Report`
--

CREATE TABLE IF NOT EXISTS `Employee_Report` (
  `id` int(11) NOT NULL,
  `personnel_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Employee_Report`
--

INSERT INTO `Employee_Report` (`id`, `personnel_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 2, 'the stock released to this client is incomplete, notify them when remaining stock is ready, also know that am on leave thank you', '2018-06-05 10:27:22', '2018-06-05 11:23:09'),
(2, 2, 'Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos', '2018-06-06 16:35:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Item`
--

CREATE TABLE IF NOT EXISTS `Item` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Item`
--

INSERT INTO `Item` (`id`, `name`) VALUES
(1, 'tramodol'),
(2, 'paracetamol'),
(3, 'chloroquin'),
(4, 'aspirin'),
(5, 'amozaslin');

-- --------------------------------------------------------

--
-- Table structure for table `Notice_Status`
--

CREATE TABLE IF NOT EXISTS `Notice_Status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Notice_Status`
--

INSERT INTO `Notice_Status` (`id`, `name`) VALUES
(1, 'Read'),
(2, 'Unread');

-- --------------------------------------------------------

--
-- Table structure for table `Release_Stock_Status`
--

CREATE TABLE IF NOT EXISTS `Release_Stock_Status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Release_Stock_Status`
--

INSERT INTO `Release_Stock_Status` (`id`, `name`) VALUES
(1, 'Waiting Approval'),
(2, 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `Request_Status`
--

CREATE TABLE IF NOT EXISTS `Request_Status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Request_Status`
--

INSERT INTO `Request_Status` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Incomplete'),
(3, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `Supplier_All_Release_Stock`
--

CREATE TABLE IF NOT EXISTS `Supplier_All_Release_Stock` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `released_quantity` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `note` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Supplier_Notice`
--

CREATE TABLE IF NOT EXISTS `Supplier_Notice` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `notice_status` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Supplier_Notice`
--

INSERT INTO `Supplier_Notice` (`id`, `item_id`, `category_id`, `supplier_id`, `notice_status`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 1, 2, 'Quantity not met', 'the quantity you requested for can''t be met at the moment, we will notify you when we get the requested quantity. thanks', '2018-05-17 11:50:41', NULL),
(2, 3, 1, 1, 1, 'No longer in stock', 'we no longer have the item you requested in stock. we advise you get this stock from another supplier. sorry for the inconveniences. thanks', '2018-05-17 12:49:34', '2018-05-21 15:02:56'),
(3, 4, 2, 1, 1, 'Item available', 'item is now available, we will bring them next week Monday, thanks', '2018-05-29 13:49:21', '2018-06-06 09:18:06'),
(4, 1, 1, 1, 1, 'stock not available now', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.', '2018-06-05 11:40:08', '2018-06-06 10:26:02'),
(5, 5, 1, 1, 1, 'Quantity ', 'relax small', '2018-06-06 16:40:33', '2018-06-06 16:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `Supplier_Release_Stock`
--

CREATE TABLE IF NOT EXISTS `Supplier_Release_Stock` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `requested_quantity` int(11) NOT NULL,
  `released_quantity` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `note` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Supplier_Release_Stock`
--

INSERT INTO `Supplier_Release_Stock` (`id`, `supplier_id`, `item_id`, `category_id`, `status`, `requested_quantity`, `released_quantity`, `expiry_date`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 2, 987, 600, '2020-02-11', 'We are unable to get the requested quantity, a note will be sent when the remaining quantity are met, thank you', '2018-05-14 21:28:48', NULL),
(2, 1, 3, 1, 2, 387, 100, '2018-05-29', 'we will add more', '2018-05-14 22:09:21', NULL),
(3, 1, 3, 1, 2, 287, 56, '2020-06-16', '', '2018-05-15 17:20:56', NULL),
(4, 1, 1, 1, 2, 120, 120, '2018-05-16', '', '2018-05-16 13:53:46', NULL),
(5, 1, 4, 2, 2, 458, 400, '2019-05-16', 'we could only afford 400 boxes for now. we will send the rest later', '2018-05-16 14:26:41', NULL),
(6, 1, 1, 1, 2, 400, 400, '2020-07-14', '', '2018-05-28 13:20:45', NULL),
(7, 1, 4, 2, 2, 300, 300, '2020-05-11', '', '2018-05-30 18:24:37', NULL),
(8, 1, 4, 2, 2, 58, 58, '2023-07-18', '', '2018-06-05 11:28:54', NULL),
(9, 1, 1, 1, 2, 30, 30, '2020-06-17', '', '2018-06-06 09:20:46', NULL),
(10, 1, 3, 1, 2, 231, 231, '2027-06-15', '', '2018-06-06 09:21:20', NULL),
(11, 1, 5, 1, 2, 500, 500, '2020-06-09', '', '2018-06-06 16:42:37', NULL),
(12, 1, 1, 1, 2, 480, 480, '2032-06-07', '', '2018-06-06 16:48:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `other_name` varchar(255) DEFAULT NULL,
  `user_group` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `first_name`, `last_name`, `other_name`, `user_group`, `status`, `password`, `username`, `created_at`, `updated_at`) VALUES
(1, 'konstantinos', 'mavropanos', 'dinos', 1, 1, '$2y$10$Owkv8KO3waYVRxmG3WZr6./7UOI1SL9KPnaNTMvShKdNTAqJjNsTa', 'admin', '2018-05-11 20:21:08', '2018-05-18 12:20:37'),
(2, 'frankson', 'frank', 'franks', 2, 1, '$2y$10$ZDt.vIVZIYnZgS9NlRHDLuTD5uo95oRbvJlOGIqRyKy34BptWmva2', 'frank', '2018-05-11 20:54:02', '2018-06-05 15:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `User_Group`
--

CREATE TABLE IF NOT EXISTS `User_Group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User_Group`
--

INSERT INTO `User_Group` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'General');

-- --------------------------------------------------------

--
-- Table structure for table `Warehouse_All_Release_Stock`
--

CREATE TABLE IF NOT EXISTS `Warehouse_All_Release_Stock` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Warehouse_All_Release_Stock`
--

INSERT INTO `Warehouse_All_Release_Stock` (`id`, `item_id`, `category_id`, `quantity`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 20, 2, '2018-05-29 13:54:28', NULL),
(2, 3, 1, 45, 2, '2018-05-29 14:42:13', NULL),
(3, 1, 1, 100, 2, '2018-05-30 11:25:11', NULL),
(4, 4, 2, 300, 2, '2018-05-30 18:27:08', NULL),
(5, 1, 1, 87, 2, '2018-05-30 18:27:58', NULL),
(6, 4, 2, 34, 2, '2018-06-05 12:50:09', NULL),
(7, 3, 1, 200, 2, '2018-06-06 16:44:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Warehouse_All_Stock`
--

CREATE TABLE IF NOT EXISTS `Warehouse_All_Stock` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `personnel_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Warehouse_All_Stock`
--

INSERT INTO `Warehouse_All_Stock` (`id`, `item_id`, `category_id`, `quantity`, `expiry_date`, `personnel_id`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 100, '2018-05-29', 1, 1, '2018-05-15 15:27:00', NULL),
(2, 3, 1, 56, '2020-06-16', 1, 1, '2018-05-15 17:21:44', NULL),
(3, 1, 1, 120, '2018-05-16', 1, 1, '2018-05-16 14:14:52', NULL),
(4, 4, 2, 400, '2019-05-16', 1, 1, '2018-05-16 15:24:06', NULL),
(5, 3, 1, 600, '2020-02-11', 1, 1, '2018-05-18 11:40:38', NULL),
(6, 1, 1, 400, '2020-07-14', 1, 1, '2018-05-28 13:24:05', NULL),
(7, 4, 2, 300, '2020-05-11', 1, 1, '2018-05-30 18:25:08', NULL),
(8, 4, 2, 58, '2023-07-18', 2, 1, '2018-06-05 11:37:25', NULL),
(9, 3, 1, 231, '2027-06-15', 2, 1, '2018-06-06 09:21:51', NULL),
(10, 1, 1, 30, '2020-06-17', 2, 1, '2018-06-06 09:21:53', NULL),
(11, 5, 1, 500, '2020-06-09', 2, 1, '2018-06-06 16:43:21', NULL),
(12, 1, 1, 480, '2032-06-07', 1, 1, '2018-06-06 16:48:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Warehouse_Notice`
--

CREATE TABLE IF NOT EXISTS `Warehouse_Notice` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `personnel_id` int(11) NOT NULL,
  `notice_status` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Warehouse_Notice`
--

INSERT INTO `Warehouse_Notice` (`id`, `item_id`, `category_id`, `personnel_id`, `notice_status`, `client_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2, 2, 'delay in delivery', 'we currently do not have enough stock of requested item, will let you know when stock is ready. thanks', '2018-05-31 23:18:34', NULL),
(2, 3, 1, 1, 1, 2, 'item quantity', 'Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.', '2018-05-31 23:22:12', '2018-06-01 14:04:51'),
(3, 3, 1, 2, 2, 2, 'relax wai', 'we will send the things ok', '2018-06-05 13:07:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Warehouse_Release_Stock`
--

CREATE TABLE IF NOT EXISTS `Warehouse_Release_Stock` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `requested_quantity` int(11) NOT NULL,
  `released_quantity` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `note` text,
  `personnel_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Warehouse_Release_Stock`
--

INSERT INTO `Warehouse_Release_Stock` (`id`, `client_id`, `item_id`, `category_id`, `requested_quantity`, `released_quantity`, `status`, `note`, `personnel_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 200, 100, 2, 'we are unable to meet your requested quantity, thanks', 1, '2018-05-21 16:13:47', NULL),
(2, 2, 3, 1, 45, 45, 2, '', 1, '2018-05-28 11:55:29', NULL),
(3, 2, 1, 1, 50, 20, 2, '', 1, '2018-05-28 19:07:10', NULL),
(4, 2, 1, 1, 87, 87, 2, '', 1, '2018-05-30 11:32:30', NULL),
(5, 2, 4, 2, 300, 300, 2, '', 1, '2018-05-30 18:26:48', NULL),
(6, 2, 4, 2, 34, 34, 2, '', 2, '2018-06-05 12:49:24', NULL),
(7, 2, 3, 1, 200, 200, 2, '', 2, '2018-06-06 16:44:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Warehouse_Stock`
--

CREATE TABLE IF NOT EXISTS `Warehouse_Stock` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `personnel_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Warehouse_Stock`
--

INSERT INTO `Warehouse_Stock` (`id`, `item_id`, `category_id`, `quantity`, `expiry_date`, `personnel_id`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 787, '2027-06-15', 1, 1, '2018-05-15 15:27:00', '2018-06-06 16:44:52'),
(2, 1, 1, 843, '2032-06-07', 1, 1, '2018-05-16 14:14:52', '2018-06-06 16:48:52'),
(3, 4, 2, 424, '2023-07-18', 1, 1, '2018-05-16 15:24:06', '2018-06-05 12:50:09'),
(4, 5, 1, 500, '2020-06-09', 2, 1, '2018-06-06 16:43:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Warehouse_Stock_Request`
--

CREATE TABLE IF NOT EXISTS `Warehouse_Stock_Request` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `request_status` int(11) NOT NULL,
  `personnel_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Warehouse_Stock_Request`
--

INSERT INTO `Warehouse_Stock_Request` (`id`, `item_id`, `category_id`, `quantity`, `supplier_id`, `request_status`, `personnel_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 1, 3, 1, '2018-05-14 13:52:01', NULL),
(2, 2, 1, 400, 3, 1, 1, '2018-05-14 13:54:30', NULL),
(3, 3, 1, 0, 1, 3, 1, '2018-05-14 15:24:13', '2018-06-06 09:21:20'),
(4, 4, 2, 0, 1, 3, 1, '2018-05-16 14:23:21', '2018-06-05 11:28:54'),
(5, 1, 1, 0, 1, 3, 1, '2018-05-28 13:19:42', '2018-05-28 13:20:45'),
(6, 4, 2, 0, 1, 3, 1, '2018-05-30 18:22:50', '2018-05-30 18:24:37'),
(7, 1, 1, 0, 1, 3, 2, '2018-06-05 11:38:47', '2018-06-06 09:20:46'),
(8, 5, 1, 0, 1, 3, 1, '2018-06-06 16:39:32', '2018-06-06 16:42:37'),
(9, 1, 1, 0, 1, 3, 1, '2018-06-06 16:47:36', '2018-06-06 16:48:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Account_Status`
--
ALTER TABLE `Account_Status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Client_Stock`
--
ALTER TABLE `Client_Stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Client_Stock_Request`
--
ALTER TABLE `Client_Stock_Request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Company`
--
ALTER TABLE `Company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Company_Group`
--
ALTER TABLE `Company_Group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Employee_Report`
--
ALTER TABLE `Employee_Report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Item`
--
ALTER TABLE `Item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Notice_Status`
--
ALTER TABLE `Notice_Status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Release_Stock_Status`
--
ALTER TABLE `Release_Stock_Status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Request_Status`
--
ALTER TABLE `Request_Status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Supplier_All_Release_Stock`
--
ALTER TABLE `Supplier_All_Release_Stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Supplier_Notice`
--
ALTER TABLE `Supplier_Notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Supplier_Release_Stock`
--
ALTER TABLE `Supplier_Release_Stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `User_Group`
--
ALTER TABLE `User_Group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Warehouse_All_Release_Stock`
--
ALTER TABLE `Warehouse_All_Release_Stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Warehouse_All_Stock`
--
ALTER TABLE `Warehouse_All_Stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Warehouse_Notice`
--
ALTER TABLE `Warehouse_Notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Warehouse_Release_Stock`
--
ALTER TABLE `Warehouse_Release_Stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Warehouse_Stock`
--
ALTER TABLE `Warehouse_Stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Warehouse_Stock_Request`
--
ALTER TABLE `Warehouse_Stock_Request`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Account_Status`
--
ALTER TABLE `Account_Status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Client_Stock`
--
ALTER TABLE `Client_Stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Client_Stock_Request`
--
ALTER TABLE `Client_Stock_Request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Company`
--
ALTER TABLE `Company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Company_Group`
--
ALTER TABLE `Company_Group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Employee_Report`
--
ALTER TABLE `Employee_Report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Item`
--
ALTER TABLE `Item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Notice_Status`
--
ALTER TABLE `Notice_Status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Release_Stock_Status`
--
ALTER TABLE `Release_Stock_Status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Request_Status`
--
ALTER TABLE `Request_Status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Supplier_All_Release_Stock`
--
ALTER TABLE `Supplier_All_Release_Stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Supplier_Notice`
--
ALTER TABLE `Supplier_Notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Supplier_Release_Stock`
--
ALTER TABLE `Supplier_Release_Stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `User_Group`
--
ALTER TABLE `User_Group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Warehouse_All_Release_Stock`
--
ALTER TABLE `Warehouse_All_Release_Stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Warehouse_All_Stock`
--
ALTER TABLE `Warehouse_All_Stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `Warehouse_Notice`
--
ALTER TABLE `Warehouse_Notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Warehouse_Release_Stock`
--
ALTER TABLE `Warehouse_Release_Stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Warehouse_Stock`
--
ALTER TABLE `Warehouse_Stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Warehouse_Stock_Request`
--
ALTER TABLE `Warehouse_Stock_Request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
