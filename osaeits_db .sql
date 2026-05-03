-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2026 at 06:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `osaeits_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(50) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES
(1, 1, 'transaction.create', 'transaction', 4, '{\"item_type\":\"equipment\",\"item_id\":5,\"transaction_type\":\"issue\",\"quantity\":4,\"unit_price\":0,\"total_amount\":0,\"reference_number\":\"1234\"}', '::1', '2026-03-26 01:28:40'),
(2, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-03-26 19:07:51'),
(3, 1, 'auth.logout', NULL, NULL, NULL, '::1', '2026-03-26 19:09:55'),
(4, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-03-26 19:10:39'),
(5, 1, 'auth.logout', NULL, NULL, NULL, '::1', '2026-03-26 19:17:54'),
(6, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-03-26 19:20:07'),
(7, 1, 'auth.logout', NULL, NULL, NULL, '::1', '2026-03-26 19:22:04'),
(8, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-03-26 19:23:48'),
(9, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-03-26 22:02:04'),
(10, 1, 'supply.update', 'supply', 2, '{\"name\":\"Ballpen\"}', '::1', '2026-03-26 22:08:11'),
(11, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-03-30 16:26:07'),
(12, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-03-31 14:20:31'),
(13, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-03-31 14:25:16'),
(14, 1, 'supply.create', 'supply', 13, '{\"name\":\"Paper Clips\"}', '::1', '2026-03-31 14:30:15'),
(15, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-08 18:53:28'),
(16, 1, 'equipment.update', 'equipment', 7, '{\"name\":\"CCTV Camera\",\"status\":\"in_use\"}', '::1', '2026-04-08 19:26:00'),
(17, 1, 'equipment.update', 'equipment', 2, '{\"name\":\"Chair\",\"status\":\"available\"}', '::1', '2026-04-08 19:27:49'),
(18, 1, 'equipment.update', 'equipment', 2, '{\"name\":\"Chair\",\"status\":\"available\"}', '::1', '2026-04-08 19:27:59'),
(19, 1, 'equipment.update', 'equipment', 5, '{\"name\":\"Desktop PC\",\"status\":\"in_use\"}', '::1', '2026-04-08 19:28:18'),
(20, 1, 'equipment.update', 'equipment', 5, '{\"name\":\"Desktop PC\",\"status\":\"in_use\"}', '::1', '2026-04-08 19:28:27'),
(21, 1, 'equipment.update', 'equipment', 3, '{\"name\":\"Electric Fan\",\"status\":\"available\"}', '::1', '2026-04-08 19:28:44'),
(22, 1, 'equipment.update', 'equipment', 11, '{\"name\":\"Extension Table\",\"status\":\"available\"}', '::1', '2026-04-08 19:29:14'),
(23, 1, 'equipment.update', 'equipment', 12, '{\"name\":\"Laptop\",\"status\":\"in_use\"}', '::1', '2026-04-08 19:29:33'),
(24, 1, 'equipment.update', 'equipment', 6, '{\"name\":\"Printer\",\"status\":\"in_use\"}', '::1', '2026-04-08 19:30:06'),
(25, 1, 'equipment.update', 'equipment', 13, '{\"name\":\"Short Bondpaper\",\"status\":\"available\"}', '::1', '2026-04-08 19:35:28'),
(26, 1, 'equipment.update', 'equipment', 1, '{\"name\":\"Shovel\",\"status\":\"available\"}', '::1', '2026-04-08 19:39:21'),
(27, 1, 'equipment.update', 'equipment', 8, '{\"name\":\"Speaker\",\"status\":\"available\"}', '::1', '2026-04-08 19:40:57'),
(28, 1, 'equipment.update', 'equipment', 4, '{\"name\":\"Table\",\"status\":\"available\"}', '::1', '2026-04-08 19:41:17'),
(29, 1, 'equipment.update', 'equipment', 10, '{\"name\":\"UPS\",\"status\":\"available\"}', '::1', '2026-04-08 19:41:38'),
(30, 1, 'equipment.update', 'equipment', 9, '{\"name\":\"WiFi Router\",\"status\":\"available\"}', '::1', '2026-04-08 19:41:55'),
(31, 1, 'official.create', 'barangay_official', 1, '{\"name\":\"Mona Odag\",\"position_title\":\"Treasurer\",\"status\":\"active\"}', '::1', '2026-04-08 21:16:23'),
(32, 1, 'official.create', 'barangay_official', 2, '{\"name\":\"Joven Andog\",\"position_title\":\"Brgy. Captain\",\"status\":\"active\"}', '::1', '2026-04-08 21:16:48'),
(33, 1, 'equipment.update', 'equipment', 7, '{\"name\":\"CCTV Camera\",\"status\":\"servicable\"}', '::1', '2026-04-08 21:17:10'),
(34, 1, 'assign_item.create', 'assign_item', 0, '{\"item_type\":\"equipment\",\"item_ref_id\":7,\"assigned_to\":\"Barangay\",\"assigned_area\":\"Centrro\",\"appropriation\":\"sldfjslf if lsdfj sdfjs\",\"status\":\"assigned\",\"quantity\":1}', '::1', '2026-04-08 21:17:39'),
(35, 1, 'assign_item.create', 'assign_item', 0, '{\"item_type\":\"equipment\",\"item_ref_id\":3,\"assigned_to\":\"Nazareno\",\"assigned_area\":\"1\",\"appropriation\":\"l skfj lfjlsflsjkfs\",\"status\":\"assigned\",\"quantity\":1}', '::1', '2026-04-08 21:18:05'),
(36, 1, 'auth.logout', NULL, NULL, NULL, '::1', '2026-04-08 21:21:57'),
(37, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-08 21:22:05'),
(38, 1, 'equipment.update', 'equipment', 2, '{\"name\":\"Chair\",\"status\":\"servicable\"}', '::1', '2026-04-08 21:22:18'),
(39, 1, 'equipment.update', 'equipment', 2, '{\"name\":\"Chair\",\"status\":\"unservicable\"}', '::1', '2026-04-08 21:22:25'),
(40, 1, 'official.update', 'barangay_official', 1, '{\"name\":\"Serma Pladias\",\"position_title\":\"Treasurer\",\"status\":\"active\"}', '::1', '2026-04-08 21:24:58'),
(41, 1, 'official.update', 'barangay_official', 2, '{\"name\":\"Librado Magcanta\",\"position_title\":\"Brgy. Captain\",\"status\":\"active\"}', '::1', '2026-04-08 21:28:17'),
(42, 1, 'equipment.update', 'equipment', 3, '{\"name\":\"Electric Fan\",\"status\":\"servicable\"}', '::1', '2026-04-08 21:40:42'),
(43, 1, 'equipment.update', 'equipment', 9, '{\"name\":\"WiFi Router\",\"status\":\"servicable\"}', '::1', '2026-04-08 21:40:56'),
(44, 1, 'equipment.update', 'equipment', 10, '{\"name\":\"UPS\",\"status\":\"servicable\"}', '::1', '2026-04-08 21:41:11'),
(45, 1, 'equipment.update', 'equipment', 13, '{\"name\":\"Short Bondpaper\",\"status\":\"servicable\"}', '::1', '2026-04-08 21:41:16'),
(46, 1, 'equipment.update', 'equipment', 1, '{\"name\":\"Shovel\",\"status\":\"servicable\"}', '::1', '2026-04-08 21:41:25'),
(47, 1, 'equipment.update', 'equipment', 12, '{\"name\":\"Laptop\",\"status\":\"servicable\"}', '::1', '2026-04-08 21:41:32'),
(48, 1, 'equipment.update', 'equipment', 6, '{\"name\":\"Printer\",\"status\":\"servicable\"}', '::1', '2026-04-08 21:41:38'),
(49, 1, 'equipment.update', 'equipment', 5, '{\"name\":\"Desktop PC\",\"status\":\"servicable\"}', '::1', '2026-04-08 21:42:29'),
(50, 1, 'assign_item.update', 'assign_item', 2, '{\"item_type\":\"equipment\",\"item_ref_id\":3,\"assigned_to\":\"Brgy. Chairman\",\"assigned_area\":\"1\",\"appropriation\":\"Brgy. Fund\",\"status\":\"assigned\",\"quantity\":1}', '::1', '2026-04-08 21:45:21'),
(51, 1, 'assign_item.update', 'assign_item', 1, '{\"item_type\":\"equipment\",\"item_ref_id\":7,\"assigned_to\":\"Brgy Chairman\",\"assigned_area\":\"Covered Court\",\"appropriation\":\"Brgy. Fund\",\"status\":\"assigned\",\"quantity\":1}', '::1', '2026-04-08 21:47:07'),
(52, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-13 23:43:52'),
(53, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-14 16:21:52'),
(54, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-15 20:50:25'),
(55, 1, 'supply.update', 'supply', 2, '{\"name\":\"Ballpen\"}', '::1', '2026-04-15 21:29:02'),
(56, 1, 'supply.create', 'supply', 14, '{\"name\":\"Pencil\"}', '::1', '2026-04-15 21:30:34'),
(57, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-17 01:33:46'),
(58, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-17 01:44:22'),
(59, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-21 20:38:15'),
(60, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-22 15:09:11'),
(61, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-22 15:09:45'),
(62, 1, 'supply.update', 'supply', 2, '{\"name\":\"Ballpen\"}', '::1', '2026-04-22 15:17:43'),
(63, 1, 'supply.update', 'supply', 2, '{\"name\":\"Ballpen\"}', '::1', '2026-04-22 15:33:10'),
(64, 1, 'equipment.delete', 'equipment', 2, '{\"name\":\"Chair\",\"serial_number\":\"E0002\"}', '::1', '2026-04-22 15:45:35'),
(65, 1, 'user.update', 'user', 1, '{\"username\":\"admin\",\"email\":\"admin@osaeits.com\",\"role\":\"admin\"}', '::1', '2026-04-22 15:46:16'),
(66, 1, 'assign_item.create', 'assign_item', 3, '{\"item_type\":\"supply\",\"item_ref_id\":13,\"assigned_to\":\"Barangay\",\"assigned_area\":\"5\",\"appropriation\":\"Brgy. Fund\",\"status\":\"assigned\",\"quantity\":1}', '::1', '2026-04-22 15:49:29'),
(67, 1, 'assign_item.create', 'assign_item', 0, '{\"item_type\":\"equipment\",\"item_ref_id\":5,\"assigned_to\":\"Nazareno\",\"assigned_area\":\"Centrro\",\"appropriation\":\"Brgy. Fund\",\"status\":\"assigned\",\"quantity\":1}', '::1', '2026-04-22 15:50:47'),
(68, 1, 'equipment.update', 'equipment', 5, '{\"name\":\"Desktop PC\",\"status\":\"servicable\"}', '::1', '2026-04-22 15:51:38'),
(69, 1, 'equipment.delete', 'equipment', 13, '{\"name\":\"Short Bondpaper\",\"serial_number\":\"E0008\"}', '::1', '2026-04-22 15:51:48'),
(70, 1, 'transaction.create', 'transaction', 5, '{\"item_type\":\"equipment\",\"item_id\":5,\"transaction_type\":\"issue\",\"quantity\":1,\"unit_price\":0,\"total_amount\":0,\"reference_number\":\"5468764747\"}', '::1', '2026-04-22 15:53:20'),
(71, 1, 'transaction.create', 'transaction', 6, '{\"item_type\":\"supply\",\"item_id\":3,\"transaction_type\":\"issue\",\"quantity\":10,\"unit_price\":20,\"total_amount\":200,\"reference_number\":\"5468764747\"}', '::1', '2026-04-22 15:54:12'),
(72, 1, 'supply.delete', 'supply', 14, '{\"name\":\"Pencil\"}', '::1', '2026-04-22 15:55:11'),
(73, 1, 'supply.delete', 'supply', 12, '{\"name\":\"Pencil\"}', '::1', '2026-04-22 15:55:15'),
(74, 1, 'transaction.create', 'transaction', 7, '{\"item_type\":\"supply\",\"item_id\":5,\"transaction_type\":\"issue\",\"quantity\":9,\"unit_price\":20,\"total_amount\":180,\"reference_number\":\"5468764747\"}', '::1', '2026-04-22 15:56:20'),
(75, 1, 'transaction.create', 'transaction', 8, '{\"item_type\":\"supply\",\"item_id\":5,\"transaction_type\":\"issue\",\"quantity\":5,\"unit_price\":20,\"total_amount\":100,\"reference_number\":\"5468764747\"}', '::1', '2026-04-22 15:58:28'),
(76, 1, 'transaction.create', 'transaction', 9, '{\"item_type\":\"supply\",\"item_id\":2,\"transaction_type\":\"purchase\",\"quantity\":4,\"unit_price\":3,\"total_amount\":12,\"reference_number\":null}', '::1', '2026-04-22 16:30:32'),
(77, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-23 01:12:29'),
(78, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-29 18:01:24'),
(79, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-29 18:06:56'),
(80, 1, 'supply.update', 'supply', 5, '{\"name\":\"Trash Bin\"}', '::1', '2026-04-29 18:20:16'),
(81, 1, 'equipment.create', 'equipment', 14, '{\"name\":\"Smart TV\",\"status\":\"servicable\"}', '::1', '2026-04-29 18:26:04'),
(82, 1, 'equipment.create', 'equipment', 15, '{\"name\":\"Ladder\",\"status\":\"servicable\"}', '::1', '2026-04-29 18:30:10'),
(83, 1, 'equipment.update', 'equipment', 15, '{\"name\":\"Ladder\",\"status\":\"servicable\"}', '::1', '2026-04-29 18:31:35'),
(84, 1, 'supply.create', 'supply', 15, '{\"name\":\"Puncher\"}', '::1', '2026-04-29 18:34:30'),
(85, 1, 'supply.update', 'supply', 15, '{\"name\":\"Puncher\"}', '::1', '2026-04-29 18:34:55'),
(86, 1, 'transaction.create', 'transaction', 10, '{\"item_type\":\"supply\",\"item_id\":2,\"transaction_type\":\"adjustment\",\"quantity\":5,\"unit_price\":200,\"total_amount\":1000,\"reference_number\":\"SP-ADJ-20260429-194\"}', '::1', '2026-04-29 21:20:35'),
(87, 1, 'transaction.update', 'transaction', 10, '{\"item_type\":\"supply\",\"item_id\":2,\"transaction_type\":\"adjustment\",\"quantity\":3,\"unit_price\":200,\"total_amount\":600,\"reference_number\":\"SP-ADJ-20260429-194\"}', '::1', '2026-04-29 21:21:57'),
(88, 1, 'transaction.create', 'transaction', 11, '{\"item_type\":\"supply\",\"item_id\":2,\"transaction_type\":\"purchase\",\"quantity\":1,\"unit_price\":200,\"total_amount\":200,\"reference_number\":\"SP-PUR-20260430-392\"}', '::1', '2026-04-30 19:51:40'),
(89, 1, 'supply.update', 'supply', 5, '{\"name\":\"Trash Bin\"}', '::1', '2026-04-30 19:59:40'),
(90, 1, 'supply.update', 'supply', 3, '{\"name\":\"Bondpaper\"}', '::1', '2026-04-30 20:00:01'),
(91, 1, 'supply.update', 'supply', 15, '{\"name\":\"Puncher\"}', '::1', '2026-04-30 20:00:33'),
(92, 1, 'transaction.create', 'transaction', 12, '{\"item_type\":\"supply\",\"item_id\":3,\"transaction_type\":\"adjustment\",\"quantity\":2,\"unit_price\":1025,\"total_amount\":2050,\"reference_number\":\"SP-ADJ-20260430-291\"}', '::1', '2026-04-30 20:03:28'),
(93, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-04-30 22:45:19'),
(94, 1, 'transaction.create', 'transaction', 13, '{\"item_type\":\"supply\",\"item_id\":2,\"transaction_type\":\"issue\",\"quantity\":1,\"unit_price\":200,\"total_amount\":200,\"reference_number\":\"SP-ISS-20260430-564\"}', '::1', '2026-04-30 22:57:20'),
(95, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-05-01 17:50:48'),
(96, 1, 'assign_item.create', 'assign_item', 0, '{\"item_type\":\"equipment\",\"item_ref_id\":6,\"assigned_to\":\"Secretary\",\"assigned_area\":\"Inside the office\",\"appropriation\":null,\"status\":\"assigned\",\"quantity\":1}', '::1', '2026-05-01 18:20:57'),
(97, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-05-02 13:47:00'),
(98, 1, 'supply.update', 'supply', 5, '{\"name\":\"Trash Bin\"}', '::1', '2026-05-02 13:49:27'),
(99, 1, 'supply.update', 'supply', 5, '{\"name\":\"Trash Bin\"}', '::1', '2026-05-02 13:49:46'),
(100, 1, 'auth.logout', NULL, NULL, NULL, '::1', '2026-05-02 14:04:11'),
(101, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-05-02 14:04:27'),
(102, 1, 'auth.logout', NULL, NULL, NULL, '::1', '2026-05-02 14:11:41'),
(103, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-05-02 14:11:53'),
(104, 1, 'supply.create', 'supply', 16, '{\"name\":\"Shoes Glue\"}', '::1', '2026-05-02 14:14:39'),
(105, 1, 'assign_item.create', 'assign_item', 0, '{\"item_type\":\"supply\",\"item_ref_id\":16,\"assigned_to\":\"Barangay Piao\",\"assigned_area\":\"Purok Talisay\",\"appropriation\":null,\"status\":\"assigned\",\"quantity\":1}', '::1', '2026-05-02 14:15:47'),
(106, 1, 'assign_item.update', 'assign_item', 6, '{\"item_type\":\"supply\",\"item_ref_id\":16,\"assigned_to\":\"Barangay Piao\",\"assigned_area\":\"Purok Talisay\",\"appropriation\":\"Brgy. Fund\",\"status\":\"assigned\",\"quantity\":1}', '::1', '2026-05-02 14:16:07'),
(107, 1, 'transaction.create', 'transaction', 14, '{\"item_type\":\"supply\",\"item_id\":16,\"transaction_type\":\"purchase\",\"quantity\":1,\"unit_price\":25,\"total_amount\":25,\"reference_number\":\"SP-PUR-20260502-176\"}', '::1', '2026-05-02 14:17:13'),
(108, 1, 'assign_item.update', 'assign_item', 4, '{\"item_type\":\"equipment\",\"item_ref_id\":5,\"assigned_to\":\"Brgy. Chairman\",\"assigned_area\":\"Centrro\",\"appropriation\":\"Brgy. Fund\",\"status\":\"assigned\",\"quantity\":1}', '::1', '2026-05-02 14:47:57'),
(109, 1, 'transaction.create', 'transaction', 15, '{\"item_type\":\"supply\",\"item_id\":2,\"transaction_type\":\"return\",\"quantity\":1,\"unit_price\":200,\"total_amount\":200,\"reference_number\":\"SP-RET-20260502-887\"}', '::1', '2026-05-02 14:49:24'),
(110, 1, 'auth.logout', NULL, NULL, NULL, '::1', '2026-05-02 15:47:56'),
(111, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-05-02 15:48:26'),
(112, 1, 'auth.logout', NULL, NULL, NULL, '::1', '2026-05-02 16:56:25'),
(113, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-05-03 23:27:43'),
(114, 1, 'supply.delete', 'supply', 5, '{\"name\":\"Trash Bin\"}', '::1', '2026-05-03 23:41:21'),
(115, 1, 'supply.update', 'supply', 3, '{\"name\":\"Bondpaper\"}', '::1', '2026-05-03 23:42:59'),
(116, 1, 'official.create', 'barangay_official', 3, '{\"name\":\"Joy Sarigumba\",\"position_title\":\"SB Member\",\"status\":\"active\"}', '::1', '2026-05-03 23:59:07'),
(117, 1, 'official.create', 'barangay_official', 4, '{\"name\":\"Ramonito Ocay\",\"position_title\":\"SB Member\",\"status\":\"active\"}', '::1', '2026-05-04 00:05:17'),
(118, 1, 'official.create', 'barangay_official', 5, '{\"name\":\"JOANNA MARIE CASTANEDA\",\"position_title\":\"SB SECRETARY\",\"status\":\"active\"}', '::1', '2026-05-04 00:36:13'),
(119, 1, 'supply.update', 'supply', 6, '{\"name\":\"Extension Cord\"}', '::1', '2026-05-04 00:41:25'),
(120, 1, 'supply.update', 'supply', 9, '{\"name\":\"Puncher\"}', '::1', '2026-05-04 00:41:29'),
(121, 1, 'supply.update', 'supply', 1, '{\"name\":\"Pencil\"}', '::1', '2026-05-04 00:41:33'),
(122, 1, 'supply.update', 'supply', 4, '{\"name\":\"Scissors\"}', '::1', '2026-05-04 00:41:41'),
(123, 1, 'supply.update', 'supply', 11, '{\"name\":\"Cutter Knife\"}', '::1', '2026-05-04 00:41:45'),
(124, 1, 'supply.update', 'supply', 10, '{\"name\":\"Binder Clips\"}', '::1', '2026-05-04 00:41:48'),
(125, 1, 'supply.update', 'supply', 8, '{\"name\":\"Envelope (Short)\"}', '::1', '2026-05-04 00:42:25'),
(126, 1, 'supply.update', 'supply', 13, '{\"name\":\"Paper Clips\"}', '::1', '2026-05-04 00:42:32'),
(127, 1, 'supply.update', 'supply', 7, '{\"name\":\"Envelope (Long)\"}', '::1', '2026-05-04 00:42:39'),
(128, 1, 'assign_item.update', 'assign_item', 5, '{\"item_type\":\"equipment\",\"item_ref_id\":6,\"assigned_to\":\"Secretary\",\"assigned_area\":\"Inside the office\",\"appropriation\":\"Brgy. Fund\",\"status\":\"assigned\",\"quantity\":1}', '::1', '2026-05-04 00:45:35'),
(129, 1, 'supply.update', 'supply', 11, '{\"name\":\"Cutter Knife\"}', '::1', '2026-05-04 00:51:55'),
(130, 1, 'auth.logout', NULL, NULL, NULL, '::1', '2026-05-04 02:41:58'),
(131, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-05-04 02:42:37'),
(132, 1, 'supply.create', 'supply', 17, '{\"name\":\"Highlighter\"}', '::1', '2026-05-04 02:50:53'),
(133, 1, 'transaction.create', 'transaction', 16, '{\"item_type\":\"supply\",\"item_id\":17,\"transaction_type\":\"purchase\",\"quantity\":5,\"unit_price\":165,\"total_amount\":825,\"reference_number\":\"SP-PUR-20260503-243\"}', '::1', '2026-05-04 02:53:58'),
(134, 1, 'transaction.create', 'transaction', 17, '{\"item_type\":\"supply\",\"item_id\":17,\"transaction_type\":\"purchase\",\"quantity\":2,\"unit_price\":149.97,\"total_amount\":299.94,\"reference_number\":\"SP-PUR-20260503-872\"}', '::1', '2026-05-04 02:55:43'),
(135, 1, 'supply.create', 'supply', 18, '{\"name\":\"Paper Clips\"}', '::1', '2026-05-04 03:00:08'),
(136, 1, 'transaction.create', 'transaction', 18, '{\"item_type\":\"supply\",\"item_id\":18,\"transaction_type\":\"purchase\",\"quantity\":1,\"unit_price\":50,\"total_amount\":50,\"reference_number\":\"SP-PUR-20260503-288\"}', '::1', '2026-05-04 03:00:31'),
(137, 1, 'transaction.create', 'transaction', 19, '{\"item_type\":\"supply\",\"item_id\":1,\"transaction_type\":\"return\",\"quantity\":1,\"unit_price\":50,\"total_amount\":50,\"reference_number\":\"SP-RET-20260503-204\"}', '::1', '2026-05-04 03:01:07'),
(138, 1, 'transaction.create', 'transaction', 20, '{\"item_type\":\"supply\",\"item_id\":1,\"transaction_type\":\"return\",\"quantity\":3,\"unit_price\":50,\"total_amount\":150,\"reference_number\":\"SP-RET-20260503-106\"}', '::1', '2026-05-04 03:01:54'),
(139, 1, 'transaction.create', 'transaction', 21, '{\"item_type\":\"supply\",\"item_id\":1,\"transaction_type\":\"adjustment\",\"quantity\":1,\"unit_price\":50,\"total_amount\":50,\"reference_number\":\"SP-ADJ-20260503-290\"}', '::1', '2026-05-04 03:02:50'),
(140, 1, 'transaction.create', 'transaction', 22, '{\"item_type\":\"supply\",\"item_id\":1,\"transaction_type\":\"purchase\",\"quantity\":1,\"unit_price\":49.92,\"total_amount\":49.92,\"reference_number\":\"SP-PUR-20260503-840\"}', '::1', '2026-05-04 03:03:29'),
(141, 1, 'auth.login', 'user', 1, '{\"username\":\"admin\"}', '::1', '2026-05-04 03:15:44'),
(142, 1, 'transaction.create', 'transaction', 23, '{\"item_type\":\"supply\",\"item_id\":15,\"transaction_type\":\"purchase\",\"quantity\":1,\"unit_price\":200,\"total_amount\":200,\"reference_number\":\"SP-PUR-20260503-315\"}', '::1', '2026-05-04 03:38:34');

-- --------------------------------------------------------

--
-- Table structure for table `assign_items`
--

CREATE TABLE `assign_items` (
  `id` int(11) NOT NULL,
  `item_type` enum('supply','equipment','inventory') NOT NULL,
  `item_ref_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `assigned_to` varchar(120) NOT NULL,
  `assigned_area` varchar(120) DEFAULT NULL,
  `appropriation` varchar(180) DEFAULT NULL,
  `assigned_date` date NOT NULL,
  `status` enum('assigned','returned') DEFAULT 'assigned',
  `notes` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assign_items`
--

INSERT INTO `assign_items` (`id`, `item_type`, `item_ref_id`, `quantity`, `assigned_to`, `assigned_area`, `appropriation`, `assigned_date`, `status`, `notes`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'equipment', 7, 1, 'Brgy Chairman', 'Covered Court', 'Brgy. Fund', '2026-04-08', 'assigned', NULL, 1, '2026-04-08 21:17:39', '2026-04-08 21:47:07'),
(2, 'equipment', 3, 1, 'Brgy. Chairman', '1', 'Brgy. Fund', '2026-04-08', 'assigned', NULL, 1, '2026-04-08 21:18:05', '2026-04-08 21:45:21'),
(3, 'supply', 13, 1, 'Barangay', '5', 'Brgy. Fund', '2026-04-24', 'assigned', NULL, 1, '2026-04-22 15:49:29', '2026-04-22 15:49:29'),
(4, 'equipment', 5, 1, 'Brgy. Chairman', 'Centrro', 'Brgy. Fund', '2026-04-23', 'assigned', NULL, 1, '2026-04-22 15:50:47', '2026-05-02 14:47:57'),
(5, 'equipment', 6, 1, 'Secretary', 'Inside the office', 'Brgy. Fund', '2026-05-01', 'assigned', NULL, 1, '2026-05-01 18:20:57', '2026-05-04 00:45:35'),
(6, 'supply', 16, 1, 'Barangay Piao', 'Purok Talisay', 'Brgy. Fund', '2026-05-02', 'assigned', NULL, 1, '2026-05-02 14:15:47', '2026-05-02 14:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(50) NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `created_at`) VALUES
(1, 1, 'login', 'auth', 1, 'User logged in', '2026-03-18 04:35:53'),
(2, 1, 'logout', 'auth', 1, 'User logged out', '2026-03-18 04:36:27'),
(3, 1, 'login', 'auth', 1, 'User logged in', '2026-03-18 04:36:30'),
(4, 1, 'login', 'auth', 1, 'User logged in', '2026-03-18 18:32:59'),
(5, 1, 'create', 'equipment', 1, 'Created equipment: Shovel', '2026-03-18 18:49:45'),
(6, 1, 'create', 'equipment', 2, 'Created equipment: Chair', '2026-03-18 18:53:55'),
(7, 1, 'create', 'equipment', 3, 'Created equipment: Electric Fan', '2026-03-18 18:56:08'),
(8, 1, 'update', 'equipment', 3, 'Updated equipment: Electric Fan', '2026-03-18 18:57:45'),
(9, 1, 'login', 'auth', 1, 'User logged in', '2026-03-19 14:31:32'),
(10, 1, 'logout', 'auth', 1, 'User logged out', '2026-03-19 14:31:45'),
(11, 1, 'login', 'auth', 1, 'User logged in', '2026-03-19 14:31:48'),
(12, 1, 'logout', 'auth', 1, 'User logged out', '2026-03-19 14:32:23'),
(13, 1, 'login', 'auth', 1, 'User logged in', '2026-03-23 03:25:03'),
(14, 1, 'create', 'equipment', 4, 'Created equipment: Table', '2026-03-23 03:44:18'),
(15, 1, 'create', 'equipment', 5, 'Created equipment: Desktop PC', '2026-03-23 03:45:15'),
(16, 1, 'update', 'equipment', 5, 'Updated equipment: Desktop PC', '2026-03-23 03:46:42'),
(17, 1, 'create', 'equipment', 6, 'Created equipment: Printer', '2026-03-23 03:48:37'),
(18, 1, 'update', 'equipment', 4, 'Updated equipment: Table', '2026-03-23 03:49:07'),
(19, 1, 'create', 'equipment', 7, 'Created equipment: CCTV Camera', '2026-03-23 03:51:57'),
(20, 1, 'create', 'equipment', 8, 'Created equipment: Speaker', '2026-03-23 03:54:09'),
(21, 1, 'logout', 'auth', 1, 'User logged out', '2026-03-23 03:54:56'),
(22, 1, 'login', 'auth', 1, 'User logged in', '2026-03-23 03:54:58'),
(23, 1, 'create', 'equipment', 9, 'Created equipment: WiFi Router', '2026-03-23 03:57:56'),
(24, 1, 'create', 'equipment', 10, 'Created equipment: UPS', '2026-03-23 03:59:11'),
(25, 1, 'create', 'equipment', 11, 'Created equipment: Extension Table', '2026-03-23 04:00:56'),
(26, 1, 'login', 'auth', 1, 'User logged in', '2026-03-23 13:33:22'),
(27, 1, 'login', 'auth', 1, 'User logged in', '2026-03-23 13:40:24'),
(28, 1, 'create', 'equipment', 12, 'Created equipment: Laptop', '2026-03-23 13:44:24'),
(29, 1, 'update', 'equipment', 12, 'Updated equipment: Laptop', '2026-03-23 13:44:58'),
(30, 1, 'login', 'auth', 1, 'User logged in', '2026-03-23 16:10:06'),
(31, 1, 'login', 'auth', 1, 'User logged in', '2026-03-23 16:16:19'),
(32, 1, 'login', 'auth', 1, 'User logged in', '2026-03-24 19:16:09'),
(33, 1, 'logout', 'auth', 1, 'User logged out', '2026-03-24 19:23:08'),
(34, 1, 'login', 'auth', 1, 'User logged in', '2026-03-24 21:53:33'),
(35, 1, 'logout', 'auth', 1, 'User logged out', '2026-03-24 22:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `barangay_officials`
--

CREATE TABLE `barangay_officials` (
  `id` int(11) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `middle_name` varchar(60) DEFAULT NULL,
  `last_name` varchar(60) NOT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `position_title` varchar(120) NOT NULL,
  `committee` varchar(120) DEFAULT NULL,
  `contact_number` varchar(30) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `term_start` date DEFAULT NULL,
  `term_end` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_officials`
--

INSERT INTO `barangay_officials` (`id`, `first_name`, `middle_name`, `last_name`, `suffix`, `position_title`, `committee`, `contact_number`, `email`, `term_start`, `term_end`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Serma', 'O', 'Pladias', NULL, 'Treasurer', NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-04-08 21:16:22', '2026-04-08 21:24:58'),
(2, 'Librado', 'T', 'Magcanta', 'Jr', 'Brgy. Captain', NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-04-08 21:16:48', '2026-04-08 21:28:17'),
(3, 'Joy', 'I', 'Sarigumba', NULL, 'SB Member', NULL, '09665754779', NULL, NULL, NULL, 'active', NULL, '2026-05-03 23:59:07', '2026-05-03 23:59:07'),
(4, 'Ramonito', 'A', 'Ocay', NULL, 'SB Member', 'Barangay Affairs', '09665754779', 'ramonito@gmail.com', '2023-11-09', '2026-11-03', 'active', NULL, '2026-05-04 00:05:17', '2026-05-04 00:05:17'),
(5, 'JOANNA MARIE', 'L', 'CASTANEDA', NULL, 'SB SECRETARY', NULL, '09095397099', 'joannamarie@gmail.com', NULL, NULL, 'active', NULL, '2026-05-04 00:36:13', '2026-05-04 00:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `status` enum('servicable','unservicable') DEFAULT 'servicable',
  `condition` enum('serviceable','non_serviceable','disposable') DEFAULT 'serviceable',
  `location` varchar(100) DEFAULT NULL,
  `purok_area` varchar(120) DEFAULT NULL,
  `appropriation` varchar(180) DEFAULT NULL,
  `person_incharge` varchar(120) DEFAULT NULL,
  `person_in_charge` varchar(100) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `assigned_to_name` varchar(100) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `warranty_expiry` date DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT 0.00,
  `budget` decimal(12,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `description`, `category`, `serial_number`, `model`, `brand`, `status`, `condition`, `location`, `purok_area`, `appropriation`, `person_incharge`, `person_in_charge`, `assigned_to`, `assigned_to_name`, `purchase_date`, `warranty_expiry`, `purchase_price`, `budget`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(1, 'Shovel', '', 'Equipment', 'E0009', NULL, 'Mitashi', 'servicable', 'serviceable', 'Under the table', NULL, NULL, NULL, 'Barangay Tanod', NULL, 'Construct', '2026-02-21', '2028-10-02', 250.00, 1000.00, '2026-03-18 18:49:45', '2026-04-08 21:41:25', 0, NULL),
(3, 'Electric Fan', 'Stand Fan', 'Equipment', 'E0004', NULL, 'Panasonic', 'servicable', 'serviceable', 'Inside the barangay office', '1', 'Brgy. Fund', 'Brgy. Chairman', 'NA', NULL, 'NA', '2026-02-04', '2028-03-04', 5000.00, 10000.00, '2026-03-18 18:56:08', '2026-04-08 21:45:21', 0, NULL),
(4, 'Table', '', 'Furniture', 'E0011', 'TBL-01', 'Uratex', '', 'serviceable', 'Conference room', NULL, NULL, NULL, 'NA', NULL, 'NA', '2026-04-04', '2027-12-31', 2500.00, 3000.00, '2026-03-23 03:44:18', '2026-04-08 21:08:50', 0, NULL),
(5, 'Desktop PC', '', 'Equipment', 'E0003', NULL, 'Dell / OptiPlex', 'unservicable', 'serviceable', 'Inside the barangay office', 'Centrro', 'Brgy. Fund', 'Brgy. Chairman', 'Barangay Treasurer', NULL, 'Barangay Treasurer', '2026-12-31', '2027-02-04', 25000.00, 30000.00, '2026-03-23 03:45:15', '2026-05-02 14:47:57', 0, NULL),
(6, 'Printer', '', 'Equipment', 'E0007', 'L3210', 'Epson', 'unservicable', 'serviceable', 'Records section', 'Inside the office', 'Brgy. Fund', 'Secretary', NULL, NULL, NULL, '2026-12-23', '2027-12-24', 9500.00, 10000.00, '2026-03-23 03:48:37', '2026-05-04 00:45:35', 0, NULL),
(7, 'CCTV Camera', '', 'Equipment', 'E0001', 'DS-2', 'Hikvision', 'servicable', 'serviceable', 'Entrance gate', 'Covered Court', 'Brgy. Fund', 'Brgy Chairman', NULL, NULL, NULL, '2026-12-31', '2028-12-04', 3500.00, 4000.00, '2026-03-23 03:51:57', '2026-04-08 21:47:07', 0, NULL),
(8, 'Speaker', '', 'Equipment', 'E0010', 'Go 3', 'JBL', '', 'serviceable', 'Second Floor', NULL, NULL, NULL, NULL, NULL, NULL, '2026-12-23', '2028-12-31', 2200.00, 2500.00, '2026-03-23 03:54:09', '2026-04-08 21:08:50', 0, NULL),
(9, 'WiFi Router', '', 'Equipment', 'E0013', 'Archer C6', 'TP-Link', 'servicable', 'serviceable', 'Office main area', NULL, NULL, NULL, NULL, NULL, NULL, '2026-12-31', '2027-12-04', 2000.00, 2500.00, '2026-03-23 03:57:56', '2026-04-08 21:40:56', 0, NULL),
(10, 'UPS', '', 'Equipment', 'E0012', 'BVX700LUI', 'APC', 'servicable', 'serviceable', 'Server desk', NULL, NULL, NULL, NULL, NULL, NULL, '2026-12-31', '2028-12-31', 3500.00, 4000.00, '2026-03-23 03:59:11', '2026-04-08 21:41:11', 0, NULL),
(11, 'Extension Table', '', 'Furniture', 'E0005', 'ET-Long', 'Local', '', 'serviceable', 'Meeting room', NULL, NULL, NULL, NULL, NULL, NULL, '2026-12-23', '2027-12-23', 3200.00, 3500.00, '2026-03-23 04:00:56', '2026-04-08 21:08:50', 0, NULL),
(12, 'Laptop', '', 'Equipment', 'E0006', NULL, 'Dell XPS 13', 'servicable', 'serviceable', 'Office room', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10000.00, 15000.00, '2026-03-23 13:44:24', '2026-04-08 21:41:32', 0, NULL),
(14, 'Smart TV', '', 'Equipment', NULL, NULL, 'DEVANT', 'servicable', 'serviceable', 'Inside the barangay office', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-31', '2027-02-15', 15000.00, 0.00, '2026-04-29 18:26:04', '2026-04-29 18:26:04', 0, NULL),
(15, 'Ladder', '', 'Equipment', NULL, '8ft Fiberglass Ladder', 'Werner', 'servicable', 'serviceable', 'Inside the storage room', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-23', '2027-12-31', 0.00, 0.00, '2026-04-29 18:30:10', '2026-04-29 18:31:35', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_type` enum('supply','equipment') NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `action` enum('in','out','adjustment') NOT NULL,
  `reference_number` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

CREATE TABLE `supplies` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `status` enum('serviceable','non_serviceable','disposable') DEFAULT 'serviceable',
  `unit` varchar(20) NOT NULL,
  `current_stock` int(11) DEFAULT 0,
  `minimum_stock` int(11) DEFAULT 0,
  `unit_price` decimal(10,2) DEFAULT 0.00,
  `budget` decimal(12,2) DEFAULT 0.00,
  `supplier` varchar(100) DEFAULT NULL,
  `person_in_charge` varchar(100) DEFAULT NULL,
  `assigned_to_name` varchar(100) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplies`
--

INSERT INTO `supplies` (`id`, `serial_number`, `name`, `brand`, `description`, `category`, `status`, `unit`, `current_stock`, `minimum_stock`, `unit_price`, `budget`, `supplier`, `person_in_charge`, `assigned_to_name`, `purchase_date`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(1, NULL, 'Pencil', NULL, '', 'Supplies', 'serviceable', 'box', 15, 5, 50.00, 0.00, 'Sebio School Supply', NULL, NULL, NULL, '2026-03-18 18:34:48', '2026-05-04 03:03:29', 0, NULL),
(2, NULL, 'Ballpen', NULL, '.5', 'Supplies', 'serviceable', 'box', 15, 10, 200.00, 0.00, 'Sebio School Supply', NULL, NULL, NULL, '2026-03-18 18:37:43', '2026-05-02 14:49:24', 0, NULL),
(3, NULL, 'Bondpaper', NULL, 'A4', 'Supplies', 'serviceable', 'Ream', 10, 12, 210.00, 0.00, 'Sebio School Supply', NULL, NULL, NULL, '2026-03-18 18:40:20', '2026-05-03 23:42:59', 0, NULL),
(4, NULL, 'Scissors', NULL, '', 'Supplies', 'serviceable', 'piece', 20, 10, 75.00, 0.00, 'Sebio School Supply', NULL, NULL, NULL, '2026-03-23 03:31:26', '2026-05-04 00:41:41', 0, NULL),
(6, NULL, 'Extension Cord', NULL, '', 'Supplies', 'serviceable', 'piece', 8, 3, 350.00, 0.00, 'PowerLine Trading', NULL, NULL, NULL, '2026-03-23 03:36:26', '2026-05-04 00:41:25', 0, NULL),
(7, NULL, 'Envelope (Long)', NULL, '', 'Supplies', 'serviceable', 'pack', 60, 30, 180.00, 0.00, 'MailSafe Supplies', NULL, NULL, NULL, '2026-03-23 03:37:44', '2026-05-04 00:42:39', 0, NULL),
(8, NULL, 'Envelope (Short)', NULL, '', 'Supplies', 'serviceable', 'pack', 35, 15, 120.00, 0.00, 'Thea Enterprise', NULL, NULL, NULL, '2026-03-23 13:47:23', '2026-05-04 00:42:25', 0, NULL),
(9, NULL, 'Puncher', NULL, '', 'Supplies', 'serviceable', 'pcs', 8, 3, 150.00, 0.00, 'Sebio School Supply', NULL, NULL, NULL, '2026-03-23 13:50:18', '2026-05-04 00:41:29', 0, NULL),
(10, NULL, 'Binder Clips', NULL, '', 'Supplies', 'serviceable', 'box', 30, 10, 80.00, 0.00, 'Sebio School Supply', NULL, NULL, NULL, '2026-03-23 13:53:54', '2026-05-04 00:41:48', 0, NULL),
(11, NULL, 'Cutter Knife', NULL, '', 'Supplies', 'serviceable', 'pcs', 22, 10, 60.00, 0.00, 'Mr DIY', NULL, NULL, NULL, '2026-03-23 13:55:23', '2026-05-04 00:51:55', 0, NULL),
(13, NULL, 'Paper Clips', NULL, '', 'Supplies', 'serviceable', 'box', 50, 40, 10.00, 0.00, 'Piao', NULL, NULL, NULL, '2026-03-31 14:30:15', '2026-05-04 00:42:32', 0, NULL),
(15, NULL, 'Puncher', NULL, '', 'Supplies', 'serviceable', 'piece', 4, 10, 200.00, 0.00, 'Sebio Enterprice', NULL, NULL, NULL, '2026-04-29 18:34:30', '2026-05-04 03:38:34', 0, NULL),
(16, NULL, 'Shoes Glue', NULL, '', 'Supplies', 'serviceable', 'piece', 20, 25, 25.00, 0.00, 'Sebio Enterprice', NULL, NULL, NULL, '2026-05-02 14:14:39', '2026-05-02 14:17:13', 0, NULL),
(17, NULL, 'Highlighter', NULL, 'blue', 'Supplies', 'serviceable', 'box', 10, 5, 149.97, 0.00, 'Mr DIY', NULL, NULL, NULL, '2026-05-04 02:50:53', '2026-05-04 02:55:43', 0, NULL),
(18, NULL, 'Paper Clips', NULL, '', 'Supplies', 'serviceable', 'box', 1, 0, 50.00, 0.00, 'Savemore', NULL, NULL, NULL, '2026-05-04 03:00:08', '2026-05-04 03:00:31', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `item_type` enum('supply','equipment') NOT NULL,
  `item_id` int(11) NOT NULL,
  `transaction_type` enum('purchase','issue','return','adjustment') NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) DEFAULT 0.00,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `reference_number` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `item_type`, `item_id`, `transaction_type`, `quantity`, `unit_price`, `total_amount`, `reference_number`, `notes`, `user_id`, `created_at`) VALUES
(1, 'equipment', 12, 'issue', 1, 0.00, 0.00, '1231244', NULL, 1, '2026-03-26 01:10:26'),
(2, 'supply', 2, 'issue', 1, 4.00, 4.00, '1231244', NULL, 1, '2026-03-26 01:12:37'),
(3, 'equipment', 7, 'issue', 3, 0.00, 0.00, '5468764747', NULL, 1, '2026-03-26 01:21:55'),
(4, 'equipment', 5, 'issue', 4, 0.00, 0.00, '1234', NULL, 1, '2026-03-26 01:28:40'),
(5, 'equipment', 5, 'issue', 1, 0.00, 0.00, '5468764747', NULL, 1, '2026-04-22 15:53:20'),
(6, 'supply', 3, 'issue', 10, 20.00, 200.00, '5468764747', NULL, 1, '2026-04-22 15:54:12'),
(7, 'supply', 5, 'issue', 9, 20.00, 180.00, '5468764747', NULL, 1, '2026-04-22 15:56:20'),
(8, 'supply', 5, 'issue', 5, 20.00, 100.00, '5468764747', NULL, 1, '2026-04-22 15:58:28'),
(9, 'supply', 2, 'purchase', 4, 3.00, 12.00, NULL, NULL, 1, '2026-04-22 16:30:32'),
(10, 'supply', 2, 'adjustment', 3, 200.00, 600.00, 'SP-ADJ-20260429-194', NULL, 1, '2026-04-29 21:20:35'),
(11, 'supply', 2, 'purchase', 1, 200.00, 200.00, 'SP-PUR-20260430-392', NULL, 1, '2026-04-30 19:51:40'),
(12, 'supply', 3, 'adjustment', 2, 1025.00, 2050.00, 'SP-ADJ-20260430-291', NULL, 1, '2026-04-30 20:03:28'),
(13, 'supply', 2, 'issue', 1, 200.00, 200.00, 'SP-ISS-20260430-564', NULL, 1, '2026-04-30 22:57:20'),
(14, 'supply', 16, 'purchase', 1, 25.00, 25.00, 'SP-PUR-20260502-176', NULL, 1, '2026-05-02 14:17:13'),
(15, 'supply', 2, 'return', 1, 200.00, 200.00, 'SP-RET-20260502-887', NULL, 1, '2026-05-02 14:49:24'),
(16, 'supply', 17, 'purchase', 5, 165.00, 825.00, 'SP-PUR-20260503-243', NULL, 1, '2026-05-04 02:53:58'),
(17, 'supply', 17, 'purchase', 2, 149.97, 299.94, 'SP-PUR-20260503-872', NULL, 1, '2026-05-04 02:55:43'),
(18, 'supply', 18, 'purchase', 1, 50.00, 50.00, 'SP-PUR-20260503-288', NULL, 1, '2026-05-04 03:00:31'),
(19, 'supply', 1, 'return', 1, 50.00, 50.00, 'SP-RET-20260503-204', NULL, 1, '2026-05-04 03:01:07'),
(20, 'supply', 1, 'return', 3, 50.00, 150.00, 'SP-RET-20260503-106', NULL, 1, '2026-05-04 03:01:54'),
(21, 'supply', 1, 'adjustment', 1, 50.00, 50.00, 'SP-ADJ-20260503-290', NULL, 1, '2026-05-04 03:02:50'),
(22, 'supply', 1, 'purchase', 1, 49.92, 49.92, 'SP-PUR-20260503-840', NULL, 1, '2026-05-04 03:03:29'),
(23, 'supply', 15, 'purchase', 1, 200.00, 200.00, 'SP-PUR-20260503-315', NULL, 1, '2026-05-04 03:38:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@osaeits.com', '$2y$10$urqasJ3xM5Tu1pJxmyiiJuufY4CCLvekiUwdVvedhEmq2vzqaMo9u', 'Admin', 'User', 'admin', '2026-03-18 04:35:42', '2026-03-18 04:35:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_activity_created` (`created_at`),
  ADD KEY `idx_activity_user` (`user_id`),
  ADD KEY `idx_activity_entity` (`entity_type`,`entity_id`);

--
-- Indexes for table `assign_items`
--
ALTER TABLE `assign_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_assign_item` (`item_type`,`item_ref_id`),
  ADD KEY `idx_assign_status` (`status`),
  ADD KEY `idx_assign_date` (`assigned_date`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay_officials`
--
ALTER TABLE `barangay_officials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_official_position` (`position_title`),
  ADD KEY `idx_official_status` (`status`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `assign_items`
--
ALTER TABLE `assign_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `barangay_officials`
--
ALTER TABLE `barangay_officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplies`
--
ALTER TABLE `supplies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
