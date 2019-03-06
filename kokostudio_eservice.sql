-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2019 at 03:21 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eservice_koko`
--

-- --------------------------------------------------------

--
-- Table structure for table `ex_branch`
--

CREATE TABLE `ex_branch` (
  `bra_id` int(11) NOT NULL,
  `bra_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `line_token` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `bra_status` int(1) NOT NULL DEFAULT '1',
  `bra_create` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bra_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ex_branch`
--

INSERT INTO `ex_branch` (`bra_id`, `bra_name`, `line_token`, `bra_status`, `bra_create`, `bra_update`) VALUES
(1, 'B1', 'xxx', 1, '2018-12-22 12:14:32', '2019-01-12 09:06:07'),
(2, 'B2', 'xxx', 1, '2018-12-22 12:23:40', '2019-01-12 09:06:14'),
(3, 'B3', 'xxx', 1, '2018-12-22 12:23:46', '2019-01-12 09:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `ex_category`
--

CREATE TABLE `ex_category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `cat_status` int(1) NOT NULL DEFAULT '1',
  `cat_create` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cat_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ex_category`
--

INSERT INTO `ex_category` (`cat_id`, `cat_name`, `cat_status`, `cat_create`, `cat_update`) VALUES
(1, 'อุปกรณ์ (Hardware )', 1, '2018-11-22 10:31:58', '2019-01-14 09:02:28'),
(2, 'โปรแกรม (Software)', 1, '2018-11-22 10:32:06', '2018-11-22 07:51:14'),
(3, 'ระบบเครือข่าย (Network)', 1, '2018-11-22 10:32:11', '2018-11-22 07:51:30'),
(4, 'สิทธิ์ใช้งานระบบ (Authorization)', 1, '2018-11-22 10:32:28', '2018-11-22 07:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `ex_department`
--

CREATE TABLE `ex_department` (
  `dep_id` int(11) NOT NULL,
  `dep_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `dep_status` int(1) NOT NULL DEFAULT '1',
  `dep_create` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dep_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ex_department`
--

INSERT INTO `ex_department` (`dep_id`, `dep_name`, `dep_status`, `dep_create`, `dep_update`) VALUES
(1, 'คอมพิวเตอร์ (IT)', 1, '2018-11-15 10:33:54', '2018-12-19 06:00:03'),
(2, 'ทรัพยากรบุคคล (Human Resource)', 1, '2018-11-15 10:34:45', '2018-11-26 08:03:46'),
(3, 'บัญชี (Account)', 1, '2018-11-15 11:00:27', '2018-11-26 08:03:58'),
(4, 'การตลาด (Marketing)', 1, '2018-12-19 13:00:28', '2018-12-19 06:00:28'),
(5, 'ออกแบบ (Graphic)', 1, '2018-12-19 13:00:52', '2018-12-19 06:00:52'),
(6, 'ซ่อมบำรุง (Maintenance)', 1, '2018-12-19 13:01:39', '2018-12-19 06:01:39'),
(7, 'ตรวจรับ (Receive product)', 1, '2018-12-19 13:03:49', '2019-01-17 03:40:46'),
(8, 'จัดซื้อ (Purchasing Department)', 1, '2018-12-27 13:57:55', '2019-01-15 09:45:59');

-- --------------------------------------------------------

--
-- Table structure for table `ex_hardware`
--

CREATE TABLE `ex_hardware` (
  `hw_id` int(11) NOT NULL,
  `hw_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `hw_asset` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hw_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_brand` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hw_model` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hw_serial_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hw_computer_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_domain_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_ip` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `hw_mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hw_cpu` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_mainboard` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_ram_1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_ram_2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_harddisk` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_ssd` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_monitor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_keyboard` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_mouse` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hw_text` text COLLATE utf8_unicode_ci NOT NULL,
  `hw_status` int(1) NOT NULL DEFAULT '1',
  `hw_create` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hw_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ex_hardware`
--

INSERT INTO `ex_hardware` (`hw_id`, `hw_name`, `user_code`, `hw_asset`, `hw_image`, `hw_brand`, `hw_model`, `hw_serial_number`, `hw_computer_name`, `hw_domain_name`, `hw_ip`, `hw_mac`, `hw_cpu`, `hw_mainboard`, `hw_ram_1`, `hw_ram_2`, `hw_harddisk`, `hw_ssd`, `hw_monitor`, `hw_keyboard`, `hw_mouse`, `hw_text`, `hw_status`, `hw_create`, `hw_update`) VALUES
(1, 'โน๊ตบุค', '10325', '00001', '0140M.jpg', 'ACER', 'X260', 'xxx', '0140M', '1', '0', '0', 'I5', 'ACER', '4', '4', '500', '55', '0', '0', '0', '', 1, '2019-02-26 15:31:44', '2019-02-26 08:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `ex_hardware_detail`
--

CREATE TABLE `ex_hardware_detail` (
  `detail_id` int(11) NOT NULL,
  `hw_id` int(11) NOT NULL,
  `sw_id` int(11) NOT NULL,
  `sw_key` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `detail_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ex_log`
--

CREATE TABLE `ex_log` (
  `log_id` int(11) NOT NULL,
  `log_username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `log_host` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `log_ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `log_status` int(11) NOT NULL,
  `log_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ex_login`
--

CREATE TABLE `ex_login` (
  `login_id` int(11) NOT NULL,
  `user_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `login_create` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `login_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ex_login`
--

INSERT INTO `ex_login` (`login_id`, `user_code`, `user_username`, `user_password`, `login_create`, `login_update`) VALUES
(2, '999999', 'admin', '$2y$10$YxXve7UNruVLFwu2bBg2hejvPenTdA1W/BcC6IOLho5uKj7uW5tNS', '2018-11-19 11:35:15', '2018-12-26 06:17:09');

-- --------------------------------------------------------

--
-- Table structure for table `ex_manage`
--

CREATE TABLE `ex_manage` (
  `manage_id` int(11) NOT NULL,
  `req_id` int(11) NOT NULL,
  `manage_user` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `manage_file` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `manage_text` text COLLATE utf8_unicode_ci NOT NULL,
  `manage_date_start` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `manage_date_end` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `manage_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ex_request`
--

CREATE TABLE `ex_request` (
  `req_id` int(11) NOT NULL,
  `req_year` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `req_last` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `req_gen` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `service_id` int(11) NOT NULL,
  `req_user` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `req_user_process` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `req_operator` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `req_dep` int(11) NOT NULL,
  `bra_id` int(11) NOT NULL,
  `req_branch` int(11) NOT NULL,
  `req_file` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `req_text` text COLLATE utf8_unicode_ci NOT NULL,
  `req_status` int(11) DEFAULT '1',
  `req_create` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `req_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ex_service`
--

CREATE TABLE `ex_service` (
  `service_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `bra_id` int(11) NOT NULL,
  `service_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `service_status` int(1) NOT NULL DEFAULT '1',
  `service_create` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `service_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ex_service`
--

INSERT INTO `ex_service` (`service_id`, `cat_id`, `bra_id`, `service_name`, `service_status`, `service_create`, `service_update`) VALUES
(1, 1, 0, 'คอมพิวเตอร์เปิดไม่ติด , ขึ้น Blue Screen', 2, '2018-11-26 11:19:08', '2019-02-28 01:17:10'),
(2, 1, 0, 'Monitor หน้าจอไม่มีภาพขึ้น, หน้าจอภาพเป็นเส้น', 1, '2018-11-22 15:02:31', '2018-11-22 08:18:03'),
(3, 1, 0, 'Printer ปริ้นส์ไม่ออก, ปริ้นส์แล้วตัวหนังสือขาด ตกหล่น, ไม่ดึงกระดาษ', 1, '2018-11-22 15:17:26', '2018-11-22 08:17:57'),
(4, 1, 0, 'UPS ไม่สำรองไฟ, เปิดไม่ติด', 1, '2018-11-22 15:17:38', '2018-11-22 08:17:44'),
(5, 1, 0, 'Scanner เปิดไม่ติด, ไม่ Scan เอกสาร', 1, '2018-11-22 15:18:24', '2018-11-22 08:18:29'),
(6, 2, 0, 'Ms Word, Ms Excel เปิดไม่ขึ้น ค้าง ช้า', 1, '2018-11-22 15:21:22', '2018-11-22 08:22:17'),
(7, 2, 0, 'E-Mail, Outlook เปิดไม่ขึ้น ส่ง E-Mail ไม่ออก ', 1, '2018-11-22 15:22:04', '2018-11-22 08:22:04'),
(8, 2, 0, 'Browser Chrome, Internet Explorer เปิดไม่ขึ้น ค้าง', 2, '2018-11-22 15:24:47', '2019-01-14 09:02:08'),
(9, 3, 0, 'อินเตอร์เน็ทช้า อินเตอร์เน็ทเข้าไม่ได้', 1, '2018-11-22 15:25:31', '2018-11-22 08:25:31'),
(10, 4, 0, 'ขอสิทธิ์การใช้งานระบบใหม่ , ยกเลิกสิทธิ์การใช้งานระบบ , เปลี่ยนแปลงสิทธิ์การใช้งาน', 1, '2018-11-22 15:26:23', '2018-11-22 08:28:01'),
(11, 4, 0, 'ขอสิทธิ์การใช้ E-Mail , ยกเลิกสิทธิ์การใช้ E-Mail , เปลี่ยนแปลงสิทธิ์ E-Mail', 1, '2018-11-22 15:26:57', '2018-11-22 08:28:33'),
(12, 6, 0, 'จอไม่ติด', 1, '2018-12-19 11:30:46', '2018-12-19 04:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `ex_software`
--

CREATE TABLE `ex_software` (
  `sw_id` int(11) NOT NULL,
  `sw_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `sw_status` int(1) NOT NULL DEFAULT '1',
  `sw_create` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sw_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ex_software`
--

INSERT INTO `ex_software` (`sw_id`, `sw_name`, `sw_status`, `sw_create`, `sw_update`) VALUES
(1, 'Windows 10 Pro 64 bit', 1, '2018-11-27 10:03:11', '2018-11-27 03:15:36'),
(2, 'Windows 10 Pro 32 bit', 1, '2018-11-27 10:04:15', '2018-11-27 03:04:15'),
(3, 'Windows 8.1 Pro 64 bit', 1, '2018-11-27 10:04:19', '2018-12-28 08:54:40'),
(4, 'Windows XP 32 bit', 1, '2018-11-27 10:04:27', '2018-12-26 09:12:40'),
(5, 'Windows 7 Pro 64 bit', 1, '2018-11-27 10:04:32', '2018-11-27 03:04:32'),
(6, 'Windows 7 Pro 32 bit', 1, '2018-11-27 10:04:36', '2018-11-27 03:04:36'),
(7, 'MS Office XP', 1, '2018-11-27 10:04:39', '2018-12-26 09:13:31'),
(8, 'MS Office Professional 2007', 1, '2018-11-27 10:04:43', '2018-12-26 09:13:40'),
(9, 'Adobe Acrobat Reader ', 1, '2018-11-27 10:04:47', '2018-12-26 09:14:13'),
(10, 'Teamviewer', 1, '2018-11-27 10:04:50', '2018-12-26 09:14:40'),
(11, 'MS Office Standard 2016', 1, '2018-11-27 10:04:56', '2018-11-27 03:04:56'),
(12, 'MS Office Professional 2016', 1, '2018-11-27 10:05:01', '2018-11-27 03:05:01'),
(13, 'MS Office Home 2019', 1, '2018-11-27 10:05:05', '2018-11-27 03:05:05'),
(14, 'MS Office Business 2019', 1, '2018-11-27 10:05:08', '2018-11-27 03:05:08'),
(15, 'MS Office 365 Home', 1, '2018-11-27 10:05:12', '2018-11-27 03:05:12'),
(16, 'MS Office 365 Personal', 1, '2018-11-27 10:05:15', '2018-11-27 03:05:15'),
(17, 'ESET Endpoint Antivirus', 1, '2018-11-27 10:05:19', '2018-11-27 03:05:19'),
(18, 'Foxit Reader', 1, '2018-11-27 10:05:23', '2018-11-27 03:05:23'),
(19, '7-Zip', 1, '2018-11-27 10:05:28', '2018-11-27 03:05:28'),
(20, 'Google Chrome', 1, '2018-11-27 10:06:21', '2018-11-30 02:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `ex_status`
--

CREATE TABLE `ex_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status_status` int(11) NOT NULL DEFAULT '1',
  `status_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ex_status`
--

INSERT INTO `ex_status` (`status_id`, `status_name`, `status_status`, `status_update`) VALUES
(1, 'รอรับเรื่อง', 1, '2018-12-11 06:36:21'),
(2, 'กำลังดำเนินการ', 1, '2018-12-11 06:26:37'),
(3, 'รออุปกรณ์ทดแทน', 1, '2018-12-11 06:26:39'),
(4, 'ดำเนินการเรียบร้อยแล้ว', 1, '2018-12-11 06:26:41'),
(5, 'ยกเลิกรายการ', 2, '2019-02-28 02:22:51'),
(6, 'รออนุมัติ', 1, '2018-12-27 09:55:19'),
(7, 'อนุมัติแล้ว', 1, '2019-01-15 07:04:20');

-- --------------------------------------------------------

--
-- Table structure for table `ex_system`
--

CREATE TABLE `ex_system` (
  `system_id` int(11) NOT NULL,
  `company_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `gmail_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gmail_username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gmail_password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `line_token` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `line_token_k1` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `line_token_k3` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password_default` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `system_create` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `system_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ex_system`
--

INSERT INTO `ex_system` (`system_id`, `company_name`, `gmail_name`, `gmail_username`, `gmail_password`, `line_token`, `line_token_k1`, `line_token_k3`, `password_default`, `user_code`, `system_create`, `system_update`) VALUES
(1, 'e-Service', 'e-Service Notification', 'xxx@gmail.com', 'xxx', 'xxx', '', '', '123456', '999999', '2018-11-23 14:24:14', '2019-01-12 09:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `ex_user`
--

CREATE TABLE `ex_user` (
  `user_id` int(11) NOT NULL,
  `user_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_surname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_picture` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_nickname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dep_id` int(11) NOT NULL,
  `bra_id` int(11) NOT NULL,
  `user_branch` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_telephone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_mobile` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_line` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_level` int(11) NOT NULL DEFAULT '1',
  `user_approve` int(1) NOT NULL DEFAULT '0',
  `user_status` int(1) NOT NULL DEFAULT '1',
  `user_create` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ex_user`
--

INSERT INTO `ex_user` (`user_id`, `user_code`, `user_name`, `user_surname`, `user_picture`, `user_nickname`, `dep_id`, `bra_id`, `user_branch`, `user_email`, `user_telephone`, `user_mobile`, `user_line`, `user_level`, `user_approve`, `user_status`, `user_create`, `user_update`) VALUES
(2, '999999', 'Administrator', 'System', '999999.jpg', 'Administrator', 1, 2, '', 'support@kokostudio.net', '', '', '', 99, 0, 1, '2018-11-19 11:35:15', '2019-01-15 09:48:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ex_branch`
--
ALTER TABLE `ex_branch`
  ADD PRIMARY KEY (`bra_id`);

--
-- Indexes for table `ex_category`
--
ALTER TABLE `ex_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `ex_department`
--
ALTER TABLE `ex_department`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `ex_hardware`
--
ALTER TABLE `ex_hardware`
  ADD PRIMARY KEY (`hw_id`,`user_code`);

--
-- Indexes for table `ex_hardware_detail`
--
ALTER TABLE `ex_hardware_detail`
  ADD PRIMARY KEY (`detail_id`,`hw_id`,`sw_id`);

--
-- Indexes for table `ex_log`
--
ALTER TABLE `ex_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `ex_login`
--
ALTER TABLE `ex_login`
  ADD PRIMARY KEY (`login_id`,`user_code`);

--
-- Indexes for table `ex_manage`
--
ALTER TABLE `ex_manage`
  ADD PRIMARY KEY (`manage_id`,`req_id`,`manage_user`);

--
-- Indexes for table `ex_request`
--
ALTER TABLE `ex_request`
  ADD PRIMARY KEY (`req_id`,`req_user`,`service_id`);

--
-- Indexes for table `ex_service`
--
ALTER TABLE `ex_service`
  ADD PRIMARY KEY (`service_id`,`cat_id`);

--
-- Indexes for table `ex_software`
--
ALTER TABLE `ex_software`
  ADD PRIMARY KEY (`sw_id`);

--
-- Indexes for table `ex_status`
--
ALTER TABLE `ex_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `ex_system`
--
ALTER TABLE `ex_system`
  ADD PRIMARY KEY (`system_id`,`user_code`);

--
-- Indexes for table `ex_user`
--
ALTER TABLE `ex_user`
  ADD PRIMARY KEY (`user_id`,`dep_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ex_branch`
--
ALTER TABLE `ex_branch`
  MODIFY `bra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ex_category`
--
ALTER TABLE `ex_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ex_department`
--
ALTER TABLE `ex_department`
  MODIFY `dep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ex_hardware`
--
ALTER TABLE `ex_hardware`
  MODIFY `hw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ex_hardware_detail`
--
ALTER TABLE `ex_hardware_detail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ex_log`
--
ALTER TABLE `ex_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ex_login`
--
ALTER TABLE `ex_login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `ex_manage`
--
ALTER TABLE `ex_manage`
  MODIFY `manage_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ex_request`
--
ALTER TABLE `ex_request`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ex_service`
--
ALTER TABLE `ex_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ex_software`
--
ALTER TABLE `ex_software`
  MODIFY `sw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ex_status`
--
ALTER TABLE `ex_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ex_system`
--
ALTER TABLE `ex_system`
  MODIFY `system_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ex_user`
--
ALTER TABLE `ex_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
