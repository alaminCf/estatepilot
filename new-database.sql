-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 07, 2026 at 11:12 AM
-- Server version: 10.11.18-MariaDB
-- PHP Version: 8.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techbolo_abason`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plot_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `referral_agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `additional_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `booking_payment` decimal(15,2) NOT NULL,
  `custom_booking_amount` decimal(15,2) DEFAULT NULL,
  `remaining_payment` decimal(15,2) NOT NULL,
  `installment_plan` enum('monthly','quarterly') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_installments` int(11) DEFAULT NULL,
  `installment_payment` decimal(15,2) DEFAULT NULL,
  `status` enum('pending','confirmed','approved','cancelled','pre-booked') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `booking_date` timestamp NULL DEFAULT NULL,
  `pre_booking_expires_at` timestamp NULL DEFAULT NULL,
  `agent_changed_at` timestamp NULL DEFAULT NULL,
  `agent_commission_base_paid` decimal(15,2) DEFAULT NULL,
  `agent_commission` decimal(5,2) DEFAULT NULL,
  `commission_scheme` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hierarchy',
  `owners` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `plot_id`, `user_id`, `referral_agent_id`, `additional_info`, `price`, `booking_payment`, `custom_booking_amount`, `remaining_payment`, `installment_plan`, `total_installments`, `installment_payment`, `status`, `booking_date`, `pre_booking_expires_at`, `agent_changed_at`, `agent_commission_base_paid`, `agent_commission`, `commission_scheme`, `owners`, `created_at`, `updated_at`) VALUES
(1, 3, 5, 4, NULL, 4000000.00, 100000.00, NULL, 3900000.00, 'monthly', 120, 32500.00, 'approved', '2025-11-28 07:03:00', NULL, NULL, NULL, 10.00, 'flat', NULL, '2026-04-09 07:49:13', '2026-04-11 08:45:12'),
(2, 11, 7, 91, 'CUS-LA-00004,\r\nFull Booking Pay', 4000000.00, 100000.00, NULL, 3900000.00, 'monthly', 60, 65000.00, 'approved', '2025-11-28 10:25:00', NULL, '2026-06-17 10:39:23', 365000.00, 10.00, 'flat', NULL, '2026-04-12 10:25:42', '2026-06-17 10:39:23'),
(3, 19, 44, 11, 'Booking Gong-5, LA-00005 Dt:28/11/2025.', 3500000.00, 100000.00, NULL, 3400000.00, 'monthly', 144, 23611.11, 'approved', '2025-11-28 10:28:00', NULL, NULL, NULL, 10.00, 'flat', '[{\"name\":\"Md. Sohag Sarder\",\"phone\":\"1927751279\",\"nid\":\"1927751279\",\"address\":\"Enayetpur, karimgonj Hur-7920, Kalkini, Madaripur\",\"father_name\":\"A. Aziz Sarder\",\"mother_name\":\"Mos. Hamida Begum\",\"spouse_name\":null},{\"name\":\"Md. Akter\",\"phone\":\"5984947241\",\"nid\":\"5984947241\",\"address\":\"Enayetpur, karimgonj Hur-7920, Kalkini, Madaripur\",\"father_name\":\"A. Aziz Sarder\",\"mother_name\":\"Mos. Hamida Begum\",\"spouse_name\":null},{\"name\":\"Md. Bockther Hossain\",\"phone\":\"9158100942\",\"nid\":\"9158100942\",\"address\":\"Enayetpur, karimgonj Hur-7920, Kalkini, Madaripur\",\"father_name\":\"A. Aziz Sarder\",\"mother_name\":\"Mos. Hamida Begum\",\"spouse_name\":null},{\"name\":\"Suma Akter\",\"phone\":\"5552229147\",\"nid\":\"5552229147\",\"address\":\"Enayetpur, karimgonj Hur-7920, Kalkini, Madaripur\",\"father_name\":\"Abdul Aziz Sarder\",\"mother_name\":\"Mos. Hamida Begum\",\"spouse_name\":null}]', '2026-04-21 10:28:30', '2026-04-21 10:30:58'),
(4, 9, 50, 92, 'LA-00009, Date: 28/11/2025.', 4000000.00, 100000.00, NULL, 3900000.00, 'monthly', 60, 65000.00, 'approved', '2025-11-28 06:32:00', NULL, '2026-06-17 10:59:04', 396000.00, 10.00, 'flat', '[{\"name\":\"Suman Akon\",\"phone\":\"8801941319674\",\"nid\":\"7915843295828\",\"address\":\"Vill: Patakata, P.S: Algi Bazar-8560, Matbaria, Pirojpur.\",\"father_name\":\"Nurul Haque Akon\",\"mother_name\":\"Kohinur Begum\",\"spouse_name\":\"Sumaya Akter\"}]', '2026-04-25 06:32:00', '2026-06-17 10:59:04'),
(5, 10, 51, 91, 'LA-00010', 4000000.00, 100000.00, NULL, 3900000.00, 'monthly', 120, 32500.00, 'approved', '2025-11-28 10:07:00', NULL, '2026-06-17 11:34:02', 197500.00, 10.00, 'flat', NULL, '2026-04-25 10:07:39', '2026-06-17 11:34:02'),
(6, 22, 49, 93, 'LA-00011, Date: 28/11/25 MR-111, TK-5000/=, BT: 09/12/2025 MR: 148 TK-95,000/=', 3500000.00, 100000.00, NULL, 3400000.00, 'monthly', 144, 23611.11, 'approved', '2025-11-28 13:18:00', NULL, '2026-06-17 11:56:44', 100000.00, 0.00, 'flat', NULL, '2026-04-23 13:18:14', '2026-06-17 11:56:44'),
(7, 16, 45, 11, 'LA-00012, Dt:28/11/2025, Booking', 4000000.00, 100000.00, NULL, 3900000.00, 'monthly', 144, 27083.33, 'approved', '2025-11-28 11:48:00', NULL, NULL, NULL, 12.00, 'flat', '[{\"name\":\"Mohammad Zahiduzzaman\",\"phone\":\"2397568841\",\"nid\":\"2397568841\",\"address\":\"H# Momataj Mongil, Vill: Box Nagar, Joka, P.O: Sarulia-1361, Demra, Dhaka.\",\"father_name\":\"Mohammad Emdad Hossain\",\"mother_name\":\"Umme Salma\",\"spouse_name\":null}]', '2026-04-21 11:48:47', '2026-04-21 11:50:44'),
(8, 23, 52, 84, 'LA-00016', 2100000.00, 100000.00, NULL, 2000000.00, 'monthly', 144, 13888.89, 'approved', '2025-11-28 12:10:00', NULL, '2026-06-17 12:00:43', 114000.00, 0.00, 'flat', NULL, '2026-04-25 12:10:07', '2026-06-17 12:00:43'),
(9, 4, 53, 91, 'Ref: Mojammel Haque\r\nCUS-La-00019, 00020, 00021, 00022', 4000000.00, 100000.00, NULL, 3900000.00, 'monthly', 144, 27083.33, 'approved', '2025-11-28 09:09:00', NULL, '2026-06-17 12:03:34', 100000.00, 0.00, 'flat', NULL, '2026-04-26 09:09:25', '2026-06-17 12:03:34'),
(10, 5, 53, 91, 'Ref: Mojammel Haque, \r\nLA-00020,Date: 28/11/2025, booking', 4000000.00, 101000.00, NULL, 3899000.00, 'monthly', 144, 27076.39, 'approved', '2025-11-28 10:20:00', NULL, '2026-06-17 12:04:24', 101000.00, 0.00, 'flat', NULL, '2026-04-26 10:20:57', '2026-06-17 12:04:24'),
(11, 6, 53, 91, 'Ref: Mojammel Haque,\r\nLA-00021, Date: 28/11/2025', 4000000.00, 101000.00, NULL, 3899000.00, 'monthly', 144, 27076.39, 'approved', '2025-11-28 11:02:00', NULL, '2026-06-17 12:51:30', 101000.00, 0.00, 'flat', NULL, '2026-04-26 11:02:30', '2026-06-17 12:51:30'),
(12, 7, 53, 91, 'Ref: Mojammel Haque\r\nLA-00022,  Date: 28/11/2025', 4000000.00, 101000.00, NULL, 3899000.00, 'monthly', 144, 27076.39, 'approved', '2025-11-28 11:27:00', NULL, '2026-06-17 12:52:30', 101000.00, 0.00, 'flat', NULL, '2026-04-26 11:27:20', '2026-06-17 12:52:30'),
(13, 24, 54, 91, 'Booking Date: 29/11/2025', 2100000.00, 100000.00, NULL, 2000000.00, 'monthly', 60, 33333.33, 'approved', '2025-11-29 10:38:00', NULL, '2026-06-17 12:54:55', 233301.33, 0.00, 'flat', '[{\"name\":\"Mohammad Sayful Islam\",\"phone\":\"017123701\",\"nid\":\"7352359744\",\"address\":\"H# Mollik BAri, Vill# Choto Joydevpura, P.O: Bokubunia-8730, Bamna, Barguna.\",\"father_name\":\"A Hamid Mollik\",\"mother_name\":\"Hazera Khatun\",\"spouse_name\":null},{\"name\":\"MD. Asaduzzaman\",\"phone\":\"017223322\",\"nid\":\"8203712586\",\"address\":\"H# 208\\/2, Block# B, Nimaikachari, P.O: Sanarpara-1430, Narayangonj.\",\"father_name\":\"Md. Abdul Wajed\",\"mother_name\":\"Mst. Rabeya Khatun\",\"spouse_name\":null}]', '2026-04-27 10:38:42', '2026-06-17 12:54:55'),
(14, 20, 46, 11, 'LA-00028, Date: 29/11/25 MR128 -10,000/=, DT:9/11/25 MR-149- 50,000/=, DT: 22/01/26 MR:171 - 40,000/=\r\nPlot: Old:6', 3500000.00, 100000.00, NULL, 3400000.00, 'monthly', 144, 23611.11, 'approved', '2025-11-29 05:50:00', NULL, NULL, NULL, 10.00, 'flat', '[{\"name\":\"Mostafijul Rahman Rony\",\"phone\":\"5555\",\"nid\":\"5551290561\",\"address\":\"Vill: Panggacia, P.O: Kalkini-7920, Kalkini Pourashava, Madaripur.\",\"father_name\":\"Shahjahan Howlader\",\"mother_name\":\"Tajnehar Khanam\",\"spouse_name\":null},{\"name\":\"MD. Forhad Hossain\",\"phone\":\"42000\",\"nid\":\"420095390\",\"address\":\"Vill: Uttar Ramjanpur, P.O: Ramjanpur Hut, P.S: Kalkini, Madaripur.\",\"father_name\":\"Hafaj Rahim\",\"mother_name\":\"Shafiya Begum\",\"spouse_name\":null}]', '2026-04-23 05:50:22', '2026-04-23 06:02:26'),
(15, 21, 48, 11, 'LA-00029, Date: 29/11/25 MR129 -10,000/=, DT:05/12/25 MR-145- 50,000/=, DT: 22/01/26 MR:170 - 40,000/= Plot: Old:8', 3500000.00, 100000.00, NULL, 3400000.00, 'monthly', 144, 23611.11, 'approved', '2025-11-29 09:33:00', NULL, NULL, NULL, 10.00, 'flat', NULL, '2026-04-23 09:33:56', '2026-04-23 09:36:01'),
(16, 25, 55, 11, 'LA-00031, LA-00032, LA-00036,', 2100000.00, 100000.00, NULL, 2000000.00, 'monthly', 144, 13888.89, 'approved', '2025-11-29 10:42:00', NULL, '2026-06-17 13:16:32', 100000.00, 10.00, 'flat', '[{\"name\":\"Lamia Akter\",\"phone\":\"006580771978\",\"nid\":\"3752218499\",\"address\":\"Baghoriya, Dhuashare-7900, Baligram, Dasar, Maradipur.\",\"father_name\":\"Mo. Kabir Bappary\",\"mother_name\":\"Rekha Khanam\",\"spouse_name\":null}]', '2026-04-28 10:42:39', '2026-06-17 13:16:32'),
(17, 26, 55, 11, 'LA-00032,', 2100000.00, 100000.00, NULL, 2000000.00, 'monthly', 144, 13888.89, 'approved', '2025-11-29 12:14:00', NULL, '2026-06-17 13:17:33', 100000.00, 10.00, 'flat', '[{\"name\":\"Lamia Akter\",\"phone\":\"006580771978\",\"nid\":\"3752218499\",\"address\":\"Baghoriya, Dhuashare-7900, Baligram, Dasar, Maradipur.\",\"father_name\":\"Md. Kabir Bappary\",\"mother_name\":\"Rekha Khanum\",\"spouse_name\":null}]', '2026-04-28 12:14:20', '2026-06-17 13:17:33'),
(18, 27, 55, 11, 'LA-00036', 2100000.00, 100000.00, NULL, 2000000.00, 'monthly', 144, 13888.89, 'approved', '2025-11-28 12:47:00', NULL, '2026-06-17 13:20:02', 100000.00, 10.00, 'flat', '[{\"name\":\"Lamia Akter\",\"phone\":\"006580771978\",\"nid\":\"3752218499\",\"address\":\"Baghoriya, Dhuashare-7900, Baligram, Dasar, Maradipur.\",\"father_name\":\"Md. Kabir Bappary\",\"mother_name\":\"Rekha Khanam\",\"spouse_name\":null}]', '2026-04-28 12:47:57', '2026-06-17 13:20:02'),
(19, 28, 56, 11, 'LA-00038, \r\nBooking Date: 30/11/2025', 2450000.00, 100000.00, NULL, 2350000.00, 'monthly', 144, 16319.44, 'approved', '2025-11-30 09:28:00', NULL, NULL, NULL, 10.00, 'flat', NULL, '2026-04-29 09:28:42', '2026-04-29 09:33:37'),
(20, 29, 57, 11, 'LA-00039, Pre-Booking', 2450000.00, 100000.00, NULL, 2350000.00, 'monthly', 144, 16319.44, 'approved', '2025-12-02 11:15:00', NULL, '2026-04-29 11:29:20', 0.00, 10.00, 'flat', NULL, '2026-04-29 11:15:10', '2026-04-29 11:39:43'),
(21, 18, 40, 4, 'Booking Date:02/12/2025', 3500000.00, 100000.00, NULL, 3400000.00, 'monthly', 144, 23611.11, 'approved', '2025-12-02 13:01:00', NULL, NULL, NULL, 10.00, 'flat', NULL, '2026-04-15 13:01:22', '2026-04-15 13:02:19'),
(22, 30, 58, 4, 'LA-00042, Booking', 3500000.00, 100000.00, NULL, 3400000.00, 'monthly', 144, 23611.11, 'approved', '2025-12-09 12:42:00', NULL, NULL, NULL, 10.00, 'flat', NULL, '2026-04-29 12:42:46', '2026-04-29 12:51:49'),
(23, 31, 59, 84, 'LA-00043,', 4000000.00, 200000.00, NULL, 3800000.00, 'monthly', 144, 26388.89, 'approved', '2025-12-13 05:39:00', NULL, '2026-06-18 10:55:51', 292777.78, 0.00, 'flat', NULL, '2026-04-30 05:39:46', '2026-06-18 10:55:51'),
(24, 32, 60, 84, 'LA-00044,', 5600000.00, 200000.00, NULL, 5400000.00, 'monthly', 144, 37500.00, 'approved', '2025-12-13 08:28:00', NULL, '2026-06-18 10:56:43', 240000.00, 0.00, 'flat', NULL, '2026-04-30 08:28:28', '2026-06-18 10:56:43'),
(25, 33, 61, 84, 'LA-00045', 4000000.00, 200000.00, NULL, 3800000.00, 'monthly', 144, 26388.89, 'approved', '2025-12-17 09:45:00', NULL, '2026-06-21 05:38:04', 220000.00, 0.00, 'flat', '[{\"name\":\"Md. Tufayl Ahmed Yusuf\",\"phone\":\"8801727331510\",\"nid\":\"19896129401000002\",\"address\":\"386\\/3-A, Road# 14, Akota Sarok, Khilgaon, Dhaka.\",\"father_name\":\"Let. Moyez Uddin\",\"mother_name\":\"Mst. Nilufa Khatun\",\"spouse_name\":\"Nadira\",\"nominee_info\":\"Birth Certificate Number: 19966195526068307\"}]', '2026-04-30 09:45:26', '2026-06-21 05:38:04'),
(26, 34, 62, 84, 'LA-00046.', 4000000.00, 200000.00, NULL, 3800000.00, 'monthly', 144, 26388.89, 'approved', '2025-12-17 11:25:00', NULL, '2026-06-18 10:57:43', 292776.00, 0.00, 'flat', '[{\"name\":\"Mahmuda Akter\",\"phone\":\"8801635046777\",\"nid\":\"2375042096\",\"address\":\"527, Nayatola Shantinagor, Mog Bazar, Dhaka\",\"father_name\":\"Mohammad Golap Khan\",\"mother_name\":\"Taslima Begum\",\"spouse_name\":null,\"nominee_info\":\"Son\"}]', '2026-04-30 11:25:29', '2026-06-18 10:57:43'),
(27, 35, 63, 84, 'LA-00047.', 4800000.00, 200000.00, NULL, 4600000.00, 'monthly', 144, 31944.44, 'approved', '2025-12-17 10:22:00', NULL, '2026-06-18 10:58:55', 280000.00, 0.00, 'flat', '[{\"name\":\"Nadira\",\"phone\":\"01912354289\",\"nid\":\"19966195526068307\",\"address\":\"Trishal Namapara, Trishal, Mymansing\",\"father_name\":\"Md. Abdul Aziz\",\"mother_name\":\"Mst. Hazara Khatun\",\"spouse_name\":\"Md. Tufayl Ahmed Yusuf\",\"nominee_info\":\"Md. Tufayl Ahmed Yusuf- Husband, NID: 19896129401000002\"},{\"name\":\"Mahmuda Akter\",\"phone\":\"01456\",\"nid\":\"2375042096\",\"address\":\"527\\/A, Nayatola, Shantinagor-1217, Ramana, Dhaka\",\"father_name\":\"Mohammad Golap Khan\",\"mother_name\":\"Taslima Begum\",\"spouse_name\":null,\"nominee_info\":null}]', '2026-05-02 10:22:44', '2026-06-18 11:16:47'),
(28, 36, 64, 84, 'LA-00048.\r\nGong: Add Due', 4800000.00, 200000.00, NULL, 4600000.00, 'monthly', 144, 31944.44, 'approved', '2025-12-17 08:26:00', NULL, '2026-06-20 08:11:23', 240000.00, 0.00, 'flat', NULL, '2026-05-03 08:26:31', '2026-06-20 08:11:23'),
(29, 37, 65, 84, 'LA-00049.', 5600000.00, 200000.00, NULL, 5400000.00, 'monthly', 144, 37500.00, 'approved', '2025-12-17 10:09:00', NULL, '2026-06-20 08:12:46', 260000.00, 0.00, 'flat', '[{\"name\":\"Md. Shamim\",\"phone\":\"0174983\",\"nid\":\"5063634983\",\"address\":\"H# 1383\\/8\\/2, Natun Bagh, Khilgaon-1219, Dhaka\",\"father_name\":\"Jahir Rayhan\",\"mother_name\":\"Bilkish Begum\",\"spouse_name\":\"Zanu Begum\",\"nominee_info\":\"Zanu BAgum\"},{\"name\":\"Md. Tufayl Ahmed Yusuf\",\"phone\":\"0123644\",\"nid\":\"19896129401000002\",\"address\":\"Trishal Namapara, Trishal-2220, Maymonsing\",\"father_name\":\"Let. Moyez Uddin\",\"mother_name\":\"Mst. Nilufa Khatun\",\"spouse_name\":\"Nadira\",\"nominee_info\":\"Nadira\"}]', '2026-05-03 10:09:21', '2026-06-20 08:12:46'),
(30, 38, 66, 84, 'LA-00050. Gong -5 Per', 2100000.00, 100000.00, NULL, 2000000.00, 'monthly', 144, 13888.89, 'approved', '2025-12-17 11:30:00', NULL, '2026-06-20 08:13:51', 190000.00, 0.00, 'flat', '[{\"name\":\"Mohammad Abu Saleh\",\"phone\":\"8801787075252\",\"nid\":\"8223092811\",\"address\":\"H# 527\\/1\\/A, Nayatola, Shantinagor-1217, Ramana, Dhaka.\",\"father_name\":\"Mohammad Jamil Hossain\",\"mother_name\":\"Rashida Begum\",\"spouse_name\":\"Anju Begum\",\"nominee_info\":\"Name: Anju Begum, Spouse.\"},{\"name\":\"Rabin Khan\",\"phone\":\"013686\",\"nid\":\"6868036283\",\"address\":\"H# 10, Koratitola Len, Wary, Dhaka-1000.\",\"father_name\":\"Md. Sourov Ali\",\"mother_name\":\"Rokaya Begum\",\"spouse_name\":null,\"nominee_info\":\"Md. Rokon, Brother\"},{\"name\":\"Md. Rokon\",\"phone\":\"01733506\",\"nid\":\"5067975184\",\"address\":\"H# 10, Koratitola Len, Wary, Dhaka-1000.\",\"father_name\":\"Md. Sourov Ali\",\"mother_name\":\"Rokaya Begum\",\"spouse_name\":null,\"nominee_info\":\"Name: Rabin Khan, Khan\"},{\"name\":\"Md. Dulal Hossain Shek\",\"phone\":\"01723554546\",\"nid\":\"456123\",\"address\":\"Andurra para\",\"father_name\":null,\"mother_name\":null,\"spouse_name\":null,\"nominee_info\":null}]', '2026-05-03 11:30:51', '2026-06-20 08:13:51'),
(31, 1, 68, 83, 'LA-00053', 3500000.00, 200000.00, NULL, 3300000.00, 'monthly', 144, 22916.67, 'approved', '2025-12-31 10:05:00', NULL, '2026-06-20 08:16:03', 200000.00, 0.00, 'flat', '[{\"name\":\"MD. Abdul Latif\",\"phone\":\"8801912226871\",\"nid\":\"2613834219105\",\"address\":\"Vill: West Borishur, P.O: Brahmankitta-1310, Keranigonj, Dhaka.\",\"father_name\":\"Let. Abul Hossain Howlader\",\"mother_name\":\"Let. Riziya Begum\",\"spouse_name\":\"Rubina\",\"nominee_info\":\"Nominee Name: Rubina, Vill: West Borishur, P.O: Brahmankitta-1310, Keranigonj, Dhaka.\"}]', '2026-05-13 10:05:06', '2026-06-20 08:16:03'),
(33, 39, 67, 94, 'LA-00055, Booking Amount=60,000/-', 2100000.00, 100000.00, NULL, 2000000.00, 'monthly', 144, 13888.89, 'approved', '2025-12-31 12:18:00', NULL, '2026-06-20 10:24:31', 74167.00, 0.00, 'flat', NULL, '2026-05-05 12:18:36', '2026-06-20 10:24:31'),
(34, 40, 69, 94, 'LA-00056, Booking 60,000/=', 2100000.00, 60000.00, NULL, 2040000.00, 'monthly', 144, 14166.67, 'approved', '2025-12-31 06:28:00', NULL, '2026-06-20 10:28:08', 74167.00, 0.00, 'flat', NULL, '2026-05-19 06:28:09', '2026-06-20 10:28:08'),
(35, 41, 70, 84, NULL, 2450000.00, 200000.00, NULL, 2250000.00, 'monthly', 144, 15625.00, 'approved', '2026-01-06 11:35:00', NULL, '2026-06-20 10:35:57', 231000.00, NULL, 'flat', NULL, '2026-05-19 11:35:48', '2026-06-20 10:39:29'),
(36, 43, 71, 11, NULL, 2450000.00, 100000.00, NULL, 2350000.00, 'monthly', 144, 16319.44, 'approved', '2026-01-15 12:30:00', NULL, '2026-06-20 10:40:09', 100000.00, 10.00, 'flat', NULL, '2026-05-19 12:30:45', '2026-06-20 10:40:09'),
(37, 44, 72, 11, 'LA-00063', 2450000.00, 100000.00, NULL, 2350000.00, 'monthly', 96, 24479.17, 'approved', '2026-01-25 13:00:00', NULL, NULL, NULL, 10.00, 'flat', NULL, '2026-05-19 13:00:42', '2026-05-20 06:16:21'),
(40, 45, 73, 11, 'LA-00066', 3500000.00, 100000.00, NULL, 3400000.00, 'monthly', 96, 35416.67, 'approved', '2026-02-03 04:17:00', NULL, NULL, NULL, 10.00, 'flat', NULL, '2026-05-21 04:21:27', '2026-06-20 10:41:29'),
(41, 46, 74, 89, 'LA-00036, PLOT:A21, ( Other plot: A20 & A23)', 4000000.00, 500000.00, NULL, 3500000.00, 'monthly', 120, 29166.67, 'approved', '2026-03-01 09:04:00', NULL, '2026-06-20 10:43:51', 533000.00, 0.00, 'flat', NULL, '2026-05-21 09:06:12', '2026-06-20 10:43:51'),
(42, 47, 74, 89, 'LA-00036, PLOT:A20, ( Other plot: A21 & A23)', 4000000.00, 500000.00, NULL, 3500000.00, 'monthly', 120, 29166.67, 'approved', '2026-03-01 10:04:00', NULL, '2026-06-20 10:45:25', 534000.00, 0.00, 'flat', NULL, '2026-05-21 10:06:04', '2026-06-20 10:45:25'),
(43, 48, 74, 89, 'LA-00069, A22 (Others Plot: A21 & A20)', 4000000.00, 500000.00, NULL, 3500000.00, 'monthly', 120, 29166.67, 'approved', '2026-03-01 10:33:00', NULL, '2026-06-20 10:48:41', 533000.00, 0.00, 'flat', NULL, '2026-05-21 10:33:19', '2026-06-20 10:48:41'),
(44, 42, 70, 95, 'LA-00070, Plot:A137.', 5600000.00, 200000.00, NULL, 5400000.00, 'monthly', 144, 37500.00, 'approved', '2026-03-11 11:46:00', NULL, '2026-06-20 10:50:01', 200000.00, 0.00, 'flat', NULL, '2026-05-21 11:48:59', '2026-06-20 10:50:01'),
(46, 49, 75, 89, 'LA-00072', 2100000.00, 200000.00, NULL, 1900000.00, 'monthly', 120, 15833.33, 'approved', '2026-03-14 05:44:00', NULL, '2026-06-20 10:51:20', 216000.00, 0.00, 'flat', NULL, '2026-05-23 05:45:53', '2026-06-20 10:51:20'),
(47, 50, 76, 96, 'LA-00074.', 4000000.00, 400000.00, NULL, 3600000.00, 'monthly', 144, 25000.00, 'approved', '2026-03-15 06:25:00', NULL, '2026-06-20 11:40:42', 400000.00, 0.00, 'flat', NULL, '2026-05-23 06:25:41', '2026-06-20 11:40:42'),
(48, 51, 77, 89, 'LA-00075,', 4000000.00, 200000.00, NULL, 3800000.00, 'monthly', 120, 31666.67, 'approved', '2026-03-15 06:51:00', NULL, '2026-06-20 12:42:36', 232000.00, 0.00, 'flat', '[{\"name\":\"Md. Ariful Islam\",\"phone\":\"880\",\"nid\":\"7758886001\",\"address\":\"Vill: Malapara, P.O: Nasircot-3610, Hazigonj, Chandpur.\",\"father_name\":\"Torab Ali Oji\",\"mother_name\":\"Hanufa Begum\",\"spouse_name\":\"Sharmin Akter Keya\",\"nominee_info\":\"Relation: Wife.\\r\\nVill: Malapara, P.O: Nasircot-3610, Hazigonj, Chandpur.\"}]', '2026-05-23 06:51:34', '2026-06-20 12:42:36'),
(49, 52, 78, 89, 'LA-00076', 4000000.00, 200000.00, NULL, 3800000.00, 'monthly', 120, 31666.67, 'approved', '2026-04-03 07:19:00', NULL, '2026-06-20 12:43:58', 231670.00, 0.00, 'flat', NULL, '2026-05-23 07:21:16', '2026-06-20 12:43:58'),
(50, 53, 77, 89, 'LA-00077,', 4000000.00, 200000.00, NULL, 3800000.00, 'monthly', 120, 31666.67, 'approved', '2026-04-03 09:26:00', NULL, '2026-06-20 12:46:20', 200000.00, 0.00, 'flat', '[{\"name\":\"Farzana Yasmin\",\"phone\":\"+61404355607\",\"address\":\"H# 152, Cresent Road, New Market-1205, Dhanmondi, Dhaka.\",\"nid\":\"1923492159\",\"father_name\":\"Kamal Mohiuddin\",\"mother_name\":\"Taslima Begum\",\"spouse_name\":null,\"nominee_info\":\"Relation: Mother, Tahmina Begum, \\r\\nH# 152, Cresent Road, New Market-1205, Dhanmondi, Dhaka.\"}]', '2026-05-23 09:32:51', '2026-06-20 12:46:20'),
(51, 54, 79, 96, 'LA-00078.', 4000000.00, 300000.00, NULL, 3700000.00, 'monthly', 120, 30833.33, 'approved', '2026-04-12 10:54:00', NULL, '2026-06-21 05:35:07', 360000.00, 0.00, 'flat', '[{\"name\":\"Sheuli Akter\",\"phone\":\"8801631320544\",\"nid\":\"1466958269\",\"address\":\"ModdyaPara, Kuti-3461, Kusba, Brahmanbaria\",\"father_name\":\"Md. Mahfuzzaman\",\"mother_name\":\"Renuyara Begum\",\"spouse_name\":null,\"nominee_info\":\"Relation: Husband, Mohammad Zakir,\\r\\nMofij Uddin Member bari, Shimriyel-3460, Kusba, Brahmanbaria\"}]', '2026-05-23 10:54:57', '2026-06-21 05:35:07'),
(52, 55, 80, 96, 'LA-00079.', 4000000.00, 300000.00, NULL, 3700000.00, 'monthly', 120, 30833.33, 'approved', '2026-04-05 11:47:00', NULL, '2026-06-21 05:35:43', 331000.00, 0.00, 'flat', '[{\"name\":\"Mohammad Zakir\",\"phone\":\"880 170083\",\"address\":\"Mofij Member Bar, Shimrayeal-3460, Kusba, Brahmanbaria.\",\"nid\":\"3319476200\",\"father_name\":\"Let. Md. Sandu mia\",\"mother_name\":\"Amena Khatun\",\"spouse_name\":null,\"nominee_info\":\"Relation: Wife, Shiuli Akter, \\r\\nModdhapara, Kuti-3461, Kusba, Brahmanbaria.\"},{\"name\":\"Jasim\",\"phone\":\"880 12316\",\"address\":\"Nabinagaar, Brahmanbaria\",\"nid\":\"2847572316\",\"father_name\":\"Abdur Nur\",\"mother_name\":\"Firoza Khatun\",\"spouse_name\":null,\"nominee_info\":\"Nurjahan Begum, NID:8697645102, Lakhaura, Baghaura-3400, Brahmanbaria.\"}]', '2026-05-23 11:58:36', '2026-06-21 05:35:43'),
(53, 56, 61, 84, 'LA-00080.', 2450000.00, 200000.00, NULL, 2250000.00, 'monthly', 144, 15625.00, 'approved', '2026-05-05 12:15:00', NULL, '2026-06-21 05:38:51', 200000.00, 0.00, 'flat', NULL, '2026-05-23 12:16:54', '2026-06-21 05:38:51'),
(54, 57, 81, 91, 'LA-00081.', 2400000.00, 200000.00, NULL, 2200000.00, 'monthly', 60, 36666.67, 'approved', '2026-05-09 12:32:00', NULL, '2026-06-21 05:40:03', 200000.00, 0.00, 'flat', NULL, '2026-05-23 12:34:26', '2026-06-21 05:40:03'),
(55, 58, 60, 84, 'LA-00082', 2450000.00, 200000.00, NULL, 2250000.00, 'monthly', 144, 15625.00, 'approved', '2026-05-05 12:58:00', NULL, '2026-06-21 05:44:36', 200000.00, 0.00, 'flat', NULL, '2026-05-23 13:00:00', '2026-06-21 05:44:36'),
(56, 59, 82, 89, 'CUS-LA-00083.', 2400000.00, 200000.00, NULL, 2200000.00, 'monthly', 96, 22916.67, 'approved', '2026-05-25 08:19:00', NULL, '2026-06-15 07:38:26', 200000.00, 0.00, 'flat', '[{\"name\":\"Md. Anisur Rahman\",\"phone\":\"880174377096\",\"nid\":\"7321987476\",\"address\":\"Vill: Purbo Datta BAri. P.S: Baghbati-6700, Sirajgonj\",\"father_name\":\"Md. Manik Uddin\",\"mother_name\":\"Mst. Anowara Begum\",\"spouse_name\":null,\"nominee_info\":\"Mohammad Oshama- Son\"},{\"name\":\"Md. Anowar Hossain\",\"phone\":\"8801740551108\",\"nid\":\"1501581175\",\"address\":\"H# Gazi Bari, Vill: Kalipur, P.O: Monipur-3540, Homona, Cumilla.\",\"father_name\":\"Md. Emdad Ulla\",\"mother_name\":\"Mst: Momataj Begum\",\"spouse_name\":null,\"nominee_info\":\"Ayasha Siddika\"}]', '2026-06-09 08:19:48', '2026-06-15 07:38:26'),
(101, 17, 104, 101, 'Test Commission', 4500000.00, 100000.00, NULL, 4400000.00, 'monthly', 120, 36666.67, 'approved', '2026-06-27 07:09:00', NULL, NULL, NULL, NULL, 'hierarchy', NULL, '2026-06-27 07:12:42', '2026-06-27 07:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-setting_contact_email', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:4;s:11:\"setting_key\";s:13:\"contact_email\";s:13:\"setting_value\";s:18:\"info@londonabd.com\";s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 11:26:17\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:4;s:11:\"setting_key\";s:13:\"contact_email\";s:13:\"setting_value\";s:18:\"info@londonabd.com\";s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 11:26:17\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783403564),
('laravel-cache-setting_facebook_url', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:10;s:11:\"setting_key\";s:12:\"facebook_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:10;s:11:\"setting_key\";s:12:\"facebook_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783357242),
('laravel-cache-setting_google_map_embed', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:8;s:11:\"setting_key\";s:16:\"google_map_embed\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:8;s:11:\"setting_key\";s:16:\"google_map_embed\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783357242),
('laravel-cache-setting_google_maps_url', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:9;s:11:\"setting_key\";s:15:\"google_maps_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:9;s:11:\"setting_key\";s:15:\"google_maps_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783403564),
('laravel-cache-setting_instagram_url', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:12;s:11:\"setting_key\";s:13:\"instagram_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:12;s:11:\"setting_key\";s:13:\"instagram_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783357242),
('laravel-cache-setting_linkedin_url', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:14;s:11:\"setting_key\";s:12:\"linkedin_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:14;s:11:\"setting_key\";s:12:\"linkedin_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783357242),
('laravel-cache-setting_office_address', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:6;s:11:\"setting_key\";s:14:\"office_address\";s:13:\"setting_value\";s:81:\"House# 3, Road# Main Road, Block# H, Maradia Bazar, Banasree, Rampura, Dhaka-1219\";s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 11:29:33\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:6;s:11:\"setting_key\";s:14:\"office_address\";s:13:\"setting_value\";s:81:\"House# 3, Road# Main Road, Block# H, Maradia Bazar, Banasree, Rampura, Dhaka-1219\";s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 11:29:33\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783403564),
('laravel-cache-setting_office_hours', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:7;s:11:\"setting_key\";s:12:\"office_hours\";s:13:\"setting_value\";s:28:\"Saturday-Thursday: 9 Am-6 Pm\";s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 11:26:39\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:7;s:11:\"setting_key\";s:12:\"office_hours\";s:13:\"setting_value\";s:28:\"Saturday-Thursday: 9 Am-6 Pm\";s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 11:26:39\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783403564),
('laravel-cache-setting_phone_primary', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:1;s:11:\"setting_key\";s:13:\"phone_primary\";s:13:\"setting_value\";s:16:\"+880 1322-902986\";s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 11:26:17\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:1;s:11:\"setting_key\";s:13:\"phone_primary\";s:13:\"setting_value\";s:16:\"+880 1322-902986\";s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 11:26:17\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783403564),
('laravel-cache-setting_phone_secondary', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:2;s:11:\"setting_key\";s:15:\"phone_secondary\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:2;s:11:\"setting_key\";s:15:\"phone_secondary\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783357242),
('laravel-cache-setting_site_logo', 'N;', 1783359509),
('laravel-cache-setting_site_name', 'N;', 1783359509),
('laravel-cache-setting_support_email_contact', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:5;s:11:\"setting_key\";s:21:\"support_email_contact\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:5;s:11:\"setting_key\";s:21:\"support_email_contact\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783357242),
('laravel-cache-setting_twitter_url', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:11;s:11:\"setting_key\";s:11:\"twitter_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:11;s:11:\"setting_key\";s:11:\"twitter_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783357242),
('laravel-cache-setting_youtube_url', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:13;s:11:\"setting_key\";s:11:\"youtube_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:13;s:11:\"setting_key\";s:11:\"youtube_url\";s:13:\"setting_value\";N;s:13:\"setting_group\";s:7:\"contact\";s:10:\"created_at\";s:19:\"2026-04-09 10:55:32\";s:10:\"updated_at\";s:19:\"2026-04-09 10:55:32\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"setting_key\";i:1;s:13:\"setting_value\";i:2;s:13:\"setting_group\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1783357242),
('laravel-cache-settings_group_contact', 'O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:14:{s:13:\"phone_primary\";s:16:\"+880 1322-902986\";s:15:\"phone_secondary\";N;s:15:\"whatsapp_number\";N;s:13:\"contact_email\";s:18:\"info@londonabd.com\";s:21:\"support_email_contact\";N;s:14:\"office_address\";s:81:\"House# 3, Road# Main Road, Block# H, Maradia Bazar, Banasree, Rampura, Dhaka-1219\";s:12:\"office_hours\";s:28:\"Saturday-Thursday: 9 Am-6 Pm\";s:16:\"google_map_embed\";N;s:15:\"google_maps_url\";N;s:12:\"facebook_url\";N;s:11:\"twitter_url\";N;s:13:\"instagram_url\";N;s:11:\"youtube_url\";N;s:12:\"linkedin_url\";N;}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1783359483),
('laravel-cache-settings_group_email', 'O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:7:{s:14:\"mail_from_name\";s:13:\"London Abason\";s:15:\"mail_from_email\";s:18:\"info@londonabd.com\";s:9:\"smtp_host\";N;s:9:\"smtp_port\";s:3:\"587\";s:13:\"smtp_username\";s:19:\"admin@londonabd.com\";s:13:\"smtp_password\";s:11:\"@Admin#2026\";s:15:\"smtp_encryption\";N;}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1783359795),
('laravel-cache-settings_group_platform', 'O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:3:{s:13:\"support_email\";N;s:11:\"admin_email\";N;s:26:\"booking_notification_email\";N;}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1783359795);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commission_earnings`
--

CREATE TABLE `commission_earnings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `level` tinyint(3) UNSIGNED NOT NULL,
  `beneficiary_type` varchar(20) NOT NULL,
  `pool_type` varchar(20) NOT NULL,
  `pool_rate` decimal(5,2) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commission_earnings`
--

INSERT INTO `commission_earnings` (`id`, `payment_id`, `booking_id`, `user_id`, `seller_id`, `level`, `beneficiary_type`, `pool_type`, `pool_rate`, `percentage`, `amount`, `created_at`, `updated_at`) VALUES
(16, 191, 101, 101, 101, 0, 'ast_manager', 'booking', 50.00, 35.00, 35000.00, '2026-06-27 07:16:00', '2026-06-27 07:17:06'),
(17, 191, 101, 100, 101, 1, 'manager', 'booking', 50.00, 5.00, 5000.00, '2026-06-27 07:16:00', '2026-06-27 07:17:06'),
(18, 191, 101, 99, 101, 2, 'agm', 'booking', 50.00, 4.00, 4000.00, '2026-06-27 07:16:00', '2026-06-27 07:17:06'),
(19, 191, 101, 98, 101, 3, 'gm', 'booking', 50.00, 3.00, 3000.00, '2026-06-27 07:16:00', '2026-06-27 07:17:06'),
(20, 191, 101, 97, 101, 4, 'ed', 'booking', 50.00, 3.00, 3000.00, '2026-06-27 07:16:00', '2026-06-27 07:17:06'),
(21, 192, 101, 101, 101, 0, 'ast_manager', 'down', 20.00, 9.00, 18000.00, '2026-06-27 07:44:00', '2026-06-27 07:44:57'),
(22, 192, 101, 100, 101, 1, 'manager', 'down', 20.00, 4.00, 8000.00, '2026-06-27 07:44:00', '2026-06-27 07:44:57'),
(23, 192, 101, 99, 101, 2, 'agm', 'down', 20.00, 3.00, 6000.00, '2026-06-27 07:44:00', '2026-06-27 07:44:57'),
(24, 192, 101, 98, 101, 3, 'gm', 'down', 20.00, 2.00, 4000.00, '2026-06-27 07:44:00', '2026-06-27 07:44:57'),
(25, 192, 101, 97, 101, 4, 'ed', 'down', 20.00, 2.00, 4000.00, '2026-06-27 07:44:00', '2026-06-27 07:44:57'),
(26, 193, 101, 101, 101, 0, 'ast_manager', 'instalment', 15.00, 6.00, 2100.00, '2026-06-27 07:49:00', '2026-06-27 07:50:06'),
(27, 193, 101, 100, 101, 1, 'manager', 'instalment', 15.00, 3.00, 1050.00, '2026-06-27 07:49:00', '2026-06-27 07:50:06'),
(28, 193, 101, 99, 101, 2, 'agm', 'instalment', 15.00, 2.00, 700.00, '2026-06-27 07:49:00', '2026-06-27 07:50:06'),
(29, 193, 101, 98, 101, 3, 'gm', 'instalment', 15.00, 2.00, 700.00, '2026-06-27 07:49:00', '2026-06-27 07:50:06'),
(30, 193, 101, 97, 101, 4, 'ed', 'instalment', 15.00, 2.00, 700.00, '2026-06-27 07:49:00', '2026-06-27 07:50:06'),
(31, 194, 101, 101, 101, 0, 'ast_manager', 'instalment', 15.00, 6.00, 4200.00, '2026-06-27 07:56:00', '2026-06-27 07:59:16'),
(32, 194, 101, 100, 101, 1, 'manager', 'instalment', 15.00, 3.00, 2100.00, '2026-06-27 07:56:00', '2026-06-27 07:59:16'),
(33, 194, 101, 99, 101, 2, 'agm', 'instalment', 15.00, 2.00, 1400.00, '2026-06-27 07:56:00', '2026-06-27 07:59:16'),
(34, 194, 101, 98, 101, 3, 'gm', 'instalment', 15.00, 2.00, 1400.00, '2026-06-27 07:56:00', '2026-06-27 07:59:16'),
(35, 194, 101, 97, 101, 4, 'ed', 'instalment', 15.00, 2.00, 1400.00, '2026-06-27 07:56:00', '2026-06-27 07:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `commission_payouts`
--

CREATE TABLE `commission_payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commission_payouts`
--

INSERT INTO `commission_payouts` (`id`, `user_id`, `booking_id`, `amount`, `payment_note`, `created_at`, `updated_at`) VALUES
(1, 6, 2, 16500.00, NULL, '2026-04-12 11:46:12', '2026-04-12 11:46:12'),
(3, 4, 1, 23000.00, 'This money was given from plot number 8.', '2026-04-16 11:41:15', '2026-04-16 11:41:15'),
(4, 11, 3, 10000.00, 'Booking Payment.', '2026-04-21 11:20:06', '2026-04-21 11:20:06'),
(5, 11, 14, 10000.00, 'Mahamudul Hasan', '2026-04-23 06:36:29', '2026-04-23 06:36:29'),
(6, 6, 4, 39600.00, 'plot: A9', '2026-04-25 11:18:02', '2026-04-25 11:18:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2026_01_11_000002_create_plots_table', 1),
(3, '2026_01_11_000003_create_bookings_table', 1),
(4, '2026_01_11_095038_create_payments_table', 1),
(5, '2026_01_20_144935_create_agent_payments_table', 1),
(6, '2026_01_20_201658_create_cache_table', 1),
(7, '2026_01_21_000001_create_phone_verifications_table', 1),
(8, '2026_01_21_100000_create_website_settings_table', 1),
(9, '2026_03_02_000001_add_pre_booked_status_and_custom_booking_amount', 1),
(10, '2026_03_03_000001_make_booking_payment_nullable_on_plots', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `instalment_quantity` int(11) NOT NULL DEFAULT 0,
  `payment_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `payment_type`, `amount`, `instalment_quantity`, `payment_note`, `created_at`, `updated_at`) VALUES
(33, 1, 'Booking Payment', 100000.00, 0, 'CUS-LA-00002, Booking, MR No: 102 Date: 28/11/2025.', '2025-11-28 05:11:00', '2026-04-16 09:40:56'),
(34, 1, 'Installment Payment', 32500.00, 1, 'CUS-LA-00002, 1st Installment, MR No: 172, Date: 24/01/2026', '2026-01-24 09:31:00', '2026-04-16 09:49:37'),
(35, 1, 'Installment Payment', 32500.00, 1, 'CUS-LA-00002, 2nd Installment, MR No: 212, Date: 11/03/2026.', '2026-03-11 09:50:00', '2026-04-16 09:52:47'),
(36, 1, 'Installment Payment', 32500.00, 1, 'CUS-LA-00002, 3rd Installment, MR No: 213, Date: 11/03/2026.', '2026-03-11 09:53:00', '2026-04-16 10:03:03'),
(37, 1, 'Installment Payment', 32500.00, 1, 'CUS-LA-00002, 4th Installment, MR No: 247, Date: 15/04/2026.', '2026-04-15 12:13:00', '2026-04-16 10:16:29'),
(38, 21, 'Booking Payment', 100000.00, 0, 'CUS-LA-00040, Booking, MR No: 249, Date: 02/12/2025.', '2025-12-02 04:20:00', '2026-04-16 10:33:34'),
(39, 21, 'Installment Payment', 23611.11, 1, 'CUS-LA-00040, 1st Installment, MR No: 173, Date: 24/01/2026.', '2026-01-24 05:37:00', '2026-04-16 10:45:04'),
(40, 21, 'Installment Payment', 23611.11, 1, 'CUS-LA-00040, 2nd Installment, MR No: 249, Date: 15/04/2026', '2026-04-15 10:47:00', '2026-04-16 10:48:30'),
(41, 2, 'Booking Payment', 100000.00, 0, 'CUS-LA-00004, Booking, MR No: 139, Date: 30/11/2025.', '2025-11-30 04:55:00', '2026-04-19 05:59:07'),
(42, 2, 'Installment Payment', 65000.00, 1, 'CUS-LA-00004, Booking, MR No: 194, Date: 01/03/2026. 1st installment', '2026-03-01 05:08:00', '2026-04-19 06:10:58'),
(43, 2, 'Installment Payment', 65000.00, 1, 'CUS-LA-00004, Booking, MR No: 195, Date: 01/03/2026. 2nd installment', '2026-03-01 06:12:00', '2026-04-19 06:13:20'),
(44, 2, 'Installment Payment', 65000.00, 1, 'CUS-LA-00004, Booking, MR No: 241, Date: 11/04/2026. 3rd installment.', '2026-04-11 06:16:00', '2026-04-19 06:18:05'),
(47, 3, 'Booking Payment', 100000.00, 0, 'LA-00005, Dt:28/11/2025, MR NO-105, Booking Amount=100000/=', '2025-11-28 10:32:00', '2026-04-21 10:36:32'),
(48, 7, 'Booking Payment', 100000.00, 0, 'MR No:112, 169, DT: 28/11/2025, 22/01/2026. (50,000+50,000)', '2025-11-28 11:52:00', '2026-04-21 11:54:47'),
(50, 14, 'Booking Payment', 100000.00, 0, 'LA-00028, Date: 29/11/25 MR128 -10,000/=, DT:9/11/25 MR-149- 50,000/=, DT: 22/01/26 MR:171 - 40,000/= Plot: Old:6', '2025-11-29 06:10:00', '2026-04-23 06:13:01'),
(51, 15, 'Booking Payment', 100000.00, 0, 'LA-00029, Date: 29/11/25 MR129 -10,000/=, DT:05/12/25 MR-145- 50,000/=, DT: 22/01/26 MR:170 - 40,000/= Plot: Old:8', '2025-11-29 09:37:00', '2026-04-23 09:37:45'),
(52, 6, 'Booking Payment', 100000.00, 0, 'LA-00011, Date: 28/11/25 MR-111, TK-5000/=, BT: 09/12/2025 MR: 148 TK-95,000/=', '2025-11-28 13:21:00', '2026-04-23 13:22:03'),
(53, 4, 'Booking Payment', 100000.00, 0, 'LA-00009, Date: 28/11/2025 MR No: 109 TK: 1,00,000/=\r\nBooking', '2025-11-28 06:45:00', '2026-04-25 06:49:01'),
(60, 4, 'Installment Payment', 74000.00, 1, 'LA-00009, Date: 15/01/2026 MR No: 162 TK: 74,000/=', '2026-01-15 08:31:00', '2026-04-25 08:32:45'),
(61, 4, 'Installment Payment', 74000.00, 1, 'LA-00009, Date: 16/02/2026 MR No: 190 TK: 74,000/=', '2026-02-16 08:37:00', '2026-04-25 08:38:22'),
(62, 4, 'Installment Payment', 74000.00, 1, 'LA-00009, Date: 08/03/2026 MR No: 201 TK: 74,000/=', '2026-03-08 08:40:00', '2026-04-25 08:41:11'),
(63, 4, 'Installment Payment', 74000.00, 1, 'LA-00009, Date: 15/04/2026 MR No: 248 TK: 74,000/=', '2026-04-15 08:43:00', '2026-04-25 08:44:34'),
(64, 5, 'Booking Payment', 100000.00, 0, 'LA-00010, Date: 28/11/2025 MR:110, tk-5,000/-, dt: 13/12/2025 MR No: 150 tk-95,000/-', '2025-11-28 10:13:00', '2026-04-25 10:15:09'),
(65, 5, 'Installment Payment', 65000.00, 2, 'LA-00010, Date: 27/01/2026 MR:180, tk-65,000/-, 1st & 2nd Ins', '2026-01-27 10:15:00', '2026-04-25 10:18:33'),
(66, 5, 'Installment Payment', 32500.00, 1, 'LA-00010, Date: 10/03/2026 MR:210, tk-32,500/-, 3rd Ins', '2026-03-10 10:19:00', '2026-04-25 10:20:50'),
(67, 8, 'Booking Payment', 10000.00, 0, 'LA-00016 MR No: 116 tk: 10,000/= 28/11/2025, Booking', '2025-11-28 12:15:00', '2026-04-25 12:17:46'),
(68, 8, 'Booking Payment', 90000.00, 0, 'LA-00016 MR No: 153 tk: 90,000/= 13/12/2025', '2025-12-13 12:18:00', '2026-04-25 12:19:48'),
(69, 8, 'Installment Payment', 14000.00, 1, 'LA-00016 MR No: 183 tk: 14,000/= 07/02/2025', '2026-02-07 12:23:00', '2026-04-25 12:24:43'),
(70, 9, 'Booking Payment', 26000.00, 0, 'LA-00019, MR-122, Date: 28/11/2025', '2025-11-28 09:17:00', '2026-04-26 09:19:06'),
(71, 9, 'Booking Payment', 50000.00, 0, 'LA-00019, MR-10/03/2026, Date: 28/11/2025', '2026-03-10 09:20:00', '2026-04-26 09:22:09'),
(72, 9, 'Booking Payment', 24000.00, 0, 'LA-00019, MR-208, Date: 10/03/2025', '2026-03-10 09:23:00', '2026-04-26 10:27:09'),
(73, 10, 'Booking Payment', 26000.00, 0, 'LA-00020, MR-121, Date: 28/11/2025, Booking', '2025-11-28 10:29:00', '2026-04-26 10:31:04'),
(74, 10, 'Booking Payment', 50000.00, 0, 'LA-00020, MR-205, Date: 10/03/2026, Booking', '2026-03-10 10:31:00', '2026-04-26 10:34:54'),
(75, 10, 'Booking Payment', 25000.00, 0, 'LA-00020, MR-209, Date: 10/03/2026, Booking', '2026-03-10 10:35:00', '2026-04-26 10:36:32'),
(76, 11, 'Booking Payment', 26000.00, 0, 'LA-00021, MR-120, Date: 28/11/2025', '2025-11-28 11:05:00', '2026-04-26 11:06:42'),
(77, 11, 'Booking Payment', 25000.00, 0, 'LA-00021, MR-206, Date: 10/03/2026, tk-25,000/=', '2026-03-10 11:10:00', '2026-04-26 11:12:27'),
(78, 11, 'Booking Payment', 50000.00, 0, 'LA-00021, MR-206, Date: 10/03/2026, tk-50,000/=', '2026-03-10 11:13:00', '2026-04-26 11:13:45'),
(79, 12, 'Booking Payment', 26000.00, 0, 'LA-00022, MR-119, Date: 28/11/2025, Tk-26,000/=', '2025-11-28 11:29:00', '2026-04-26 11:30:46'),
(80, 12, 'Booking Payment', 25000.00, 0, 'LA-00022, MR-207, Date: 10/03/2026, Tk-25,000/=', '2026-03-10 11:32:00', '2026-04-26 11:34:12'),
(81, 12, 'Booking Payment', 50000.00, 0, 'LA-00022, MR-207, Date: 10/03/2026, Tk-50,000/=', '2026-03-10 11:35:00', '2026-04-26 11:35:34'),
(82, 13, 'Booking Payment', 1000.00, 0, 'LA-00026, MR- 126, DT: 29/11/25, Booking 1ST', '2025-11-29 10:49:00', '2026-04-27 10:51:30'),
(83, 13, 'Booking Payment', 99000.00, 0, 'LA-00026, MR- 146, DT: 06/12/25, Booking 2nd', '2025-12-06 10:52:00', '2026-04-27 10:53:35'),
(84, 13, 'Installment Payment', 33333.33, 1, 'LA-00026, MR- 181, DT: 01/02/2026. 1st Ins', '2026-02-01 10:55:00', '2026-04-27 10:57:29'),
(85, 13, 'Installment Payment', 33300.00, 1, 'LA-00026, MR- 198, DT: 07/03/2026. 2nd Ins', '2026-03-07 10:59:00', '2026-04-27 11:00:23'),
(86, 13, 'Installment Payment', 66668.00, 2, 'LA-00026, MR- 256, DT: 25/04/2026. 3rd & 4th Ins', '2026-04-25 11:04:00', '2026-04-27 11:08:36'),
(87, 16, 'Booking Payment', 25000.00, 0, 'LA-00031, MR No-131, TK-25,000, Date: 19/11/2025,', '2025-11-29 10:47:00', '2026-04-28 10:59:22'),
(88, 16, 'Booking Payment', 20000.00, 0, 'LA-00031, \r\nMR No-175, TK-20,000/-, Date: 25/01/2026,', '2026-01-25 11:05:00', '2026-04-28 11:06:32'),
(89, 16, 'Booking Payment', 5000.00, 0, 'LA-00031,\r\nMR No- 221, TK-5,000, Date: 12/03/2026,', '2026-03-12 11:07:00', '2026-04-28 11:09:29'),
(90, 16, 'Booking Payment', 50000.00, 0, 'LA-00031, \r\nMR No-222, TK-50,000, Date: 12/03/2026.', '2026-03-12 11:11:00', '2026-04-28 11:12:01'),
(91, 17, 'Booking Payment', 25000.00, 0, 'LA-00032, MR No-132, TK-25,000, Date: 29/11/2025,', '2025-11-29 12:19:00', '2026-04-28 12:20:35'),
(92, 17, 'Booking Payment', 75000.00, 0, 'LA-00032, \r\nMR No- 219, TK-25,000, Date: 12/03/2026,\r\nMR No-222, TK-50,000, Date: 12/03/2026.', '2026-03-12 12:24:00', '2026-04-28 12:26:15'),
(93, 18, 'Booking Payment', 10000.00, 0, 'LA-00036, MR No-136, TK-10,000, Date: 29/11/2025,', '2025-11-29 12:52:00', '2026-04-28 12:54:20'),
(94, 18, 'Booking Payment', 90000.00, 0, 'LA-00036, \r\nMR No- 218, TK-40,000, Date: 12/03/2026,\r\nMR No-217, TK-50,000, Date: 12/03/2026.', '2026-03-12 12:55:00', '2026-04-28 12:58:43'),
(95, 19, 'Booking Payment', 100000.00, 0, 'LA-00038,\r\nBooking Date: 30/11/2025.\r\nMR No: 138,', '2025-11-30 09:38:00', '2026-04-29 09:39:50'),
(96, 20, 'Booking Payment', 25000.00, 0, 'LA-00039, MR: 140, Pre-Booking, TK-25000/=', '2025-12-02 11:30:00', '2026-04-29 11:32:00'),
(97, 20, 'Booking Payment', 75000.00, 0, 'LA-00039, MR: 201, Pre-Booking, TK-25000/=\r\n MR: 202, Pre-Booking, TK-28000/=\r\n MR: 203, Pre-Booking, TK-22000/=', '2026-03-10 11:33:00', '2026-04-29 11:36:05'),
(98, 22, 'Booking Payment', 10000.00, 0, 'LA-00042, MR: 147,', '2025-12-09 12:47:00', '2026-04-29 12:48:32'),
(99, 22, 'Booking Payment', 90000.00, 0, 'LA-00032, MR: 177,', '2026-01-27 12:50:00', '2026-04-29 12:51:06'),
(100, 22, 'Installment Payment', 47224.00, 2, 'LA-00032, MR: 242. 1st & 2nd Installment.', '2026-04-12 12:52:00', '2026-04-29 12:54:57'),
(102, 23, 'Booking Payment', 200000.00, 0, 'LA-00043, MR: 151, Date: 13/12/25, tk-2,00,000/=', '2026-04-30 05:41:00', '2026-04-30 05:41:55'),
(103, 23, 'Installment Payment', 26388.89, 1, 'LA-00043, MR: 165, 1st inst.', '2026-01-20 05:46:00', '2026-04-30 05:48:09'),
(104, 23, 'Installment Payment', 26388.89, 1, 'LA-00043, MR: 188, 2nd inst.', '2026-02-10 05:51:00', '2026-04-30 05:53:24'),
(105, 23, 'Part Of Installment', 20000.00, 0, 'Partial Installment, \r\nNote: LA-00043, MR: 252, 3rd inst. TK: 20,000/=', '2026-04-17 05:54:00', '2026-04-30 05:57:02'),
(106, 23, 'Installment Payment', 20000.00, 1, 'Partial Installment, LA-00043, MR: 258, 4th inst. TK: 20,000/=', '2026-04-28 05:59:00', '2026-04-30 06:02:01'),
(107, 24, 'Booking Payment', 200000.00, 0, 'LA-00044, MR:152, Booking', '2025-12-13 08:31:00', '2026-04-30 08:32:13'),
(108, 24, 'Installment Payment', 37500.00, 1, 'LA-00044, MR:225, Inst. TK: (40,000 - 37500) = 2,500/= Advance Pay', '2026-03-13 08:33:00', '2026-04-30 08:36:16'),
(109, 24, 'Part Of Installment', 2500.00, 0, 'LA-00044, MR:225, Inst. 2,500/= Advance Pay', '2026-03-13 08:37:00', '2026-04-30 08:38:14'),
(110, 25, 'Booking Payment', 200000.00, 0, 'LA-00045, MR: 154, Booking', '2025-12-17 09:51:00', '2026-04-30 09:52:29'),
(111, 25, 'Part Of Installment', 20000.00, 0, 'LA-00045, MR: 235, Part of Inst, 1ST', '2026-03-31 09:53:00', '2026-04-30 09:55:01'),
(112, 26, 'Booking Payment', 200000.00, 0, 'LA-00046, MR: 155, Booking', '2025-12-17 11:28:00', '2026-04-30 11:29:46'),
(113, 26, 'Installment Payment', 26388.00, 1, 'LA-00046, MR: 166, 1st installment', '2026-01-20 11:34:00', '2026-04-30 11:38:48'),
(114, 26, 'Installment Payment', 26388.00, 1, 'LA-00046, MR: 187, 2nd installment', '2026-02-10 11:42:00', '2026-04-30 11:40:43'),
(115, 26, 'Installment Payment', 26388.00, 1, 'LA-00046, MR: 253 & 259, (20000+6388= 26388)    3rd installment \r\n{20000+20000=40000}', '2026-04-17 11:41:00', '2026-04-30 11:45:59'),
(116, 26, 'Part Of Installment', 13612.00, 0, 'LA-00046, MR: 253 & 259, [(20000+6388= 26388)    3rd installment \r\n{20000+20000=40000}]  (TK: 13612/= Leas Than 1 Ins}', '2026-04-28 11:47:00', '2026-04-30 11:49:19'),
(117, 27, 'Booking Payment', 200000.00, 0, 'LA-00047, MR: 156. Booking', '2025-12-17 10:36:00', '2026-05-02 10:37:10'),
(118, 27, 'Part Of Installment', 20000.00, 0, 'LA-00047. MR: 226.', '2026-03-07 10:52:00', '2026-05-02 10:58:10'),
(119, 27, 'Installment Payment', 11944.00, 1, 'LA-00047, MR:119, Tk:11944/=', '2026-03-13 10:53:00', '2026-05-02 10:57:21'),
(120, 27, 'Installment Payment', 31944.00, 1, 'LA-00047, MR:254. ( 40000-31944 ) = 8056/=', '2026-04-17 11:02:00', '2026-05-02 11:04:48'),
(121, 27, 'Part Of Installment', 16112.00, 0, 'LA-00047, \r\nMR: 254 & MR: 199, (8056+8056) = 16112/=', '2026-04-17 11:08:00', '2026-05-02 11:10:40'),
(122, 28, 'Booking Payment', 200000.00, 0, 'LA-00048, MR: 157.', '2025-12-17 08:28:00', '2026-05-03 08:29:04'),
(123, 28, 'Installment Payment', 31945.00, 1, 'LA-00048.\r\nMR: 184 & 200, (20,000+20,000=40,000)-31945=8055/=', '2026-02-07 08:29:00', '2026-05-03 08:34:06'),
(124, 28, 'Part Of Installment', 8055.00, 0, 'LA-00048.\r\nMR: 184 & 200, (20,000+20,000=40,000)-31945=8055/=', '2026-03-07 08:36:00', '2026-05-03 08:37:21'),
(125, 29, 'Booking Payment', 200000.00, 0, 'LA-00049, MR: 158. Booking', '2025-12-17 10:13:00', '2026-05-03 10:13:56'),
(126, 29, 'Installment Payment', 37500.00, 1, 'LA-00049, MR: 185, TK:20,000/=\r\nMR: 227, Date: 13/03/26, TK:(20,000-2500) = 17,500/=\r\n1st ins {20000+17500= 37500}', '2026-02-07 10:28:00', '2026-05-03 10:32:47'),
(127, 29, 'Part Of Installment', 22500.00, 0, 'LA-00049, MR: 250, TK:20,000/=\r\nMR: 227, Date: 13/03/26, TK:(20,000-17,500) = 2,500/=\r\n{20000+2500= 22500}', '2026-04-15 10:33:00', '2026-05-03 10:35:57'),
(128, 30, 'Booking Payment', 100000.00, 0, 'LA-00050, MR: 159. Booking.', '2025-12-17 11:32:00', '2026-05-03 11:33:12'),
(129, 30, 'Installment Payment', 13889.00, 1, 'LA-00050, MR: 167, (15000-13889= 1111/-)', '2026-01-20 11:34:00', '2026-05-03 11:37:50'),
(130, 30, 'Installment Payment', 13889.00, 1, 'LA-00050, MR: 186, (15000-13889= 1111/-)', '2026-02-10 11:38:00', '2026-05-03 11:43:05'),
(131, 30, 'Installment Payment', 13889.00, 1, 'LA-00050, MR: 232, (15000-13889= 1111/-)', '2026-03-30 11:55:00', '2026-05-03 11:40:32'),
(132, 30, 'Installment Payment', 13889.00, 1, 'LA-00050, MR: 251, (15000-13889= 1111/-)', '2026-04-15 12:03:00', '2026-05-03 11:46:15'),
(133, 30, 'Part Of Installment', 4444.00, 0, 'LA-00050, \r\nMR: 167, 186, 232 & 251. \r\n(15000-13889= 1111 X 4= 4,444/-)', '2026-04-15 12:13:00', '2026-05-03 11:49:24'),
(134, 33, 'Booking Payment', 60000.00, 0, 'LA-00055, MR: 164.', '2025-12-31 12:21:00', '2026-05-05 12:22:42'),
(135, 33, 'Installment Payment', 14167.00, 1, 'LA-00055, MR: 233. 1st Ins', '2026-03-30 12:24:00', '2026-05-05 12:25:33'),
(136, 31, 'Booking Payment', 200000.00, 0, 'LA-00053, Mr:162. Booking Money.', '2025-12-31 10:14:00', '2026-05-13 10:14:59'),
(137, 1, 'Installment Payment', 32500.00, 1, 'LA-00002, MR:274.', '2026-05-14 04:49:00', '2026-05-16 04:50:01'),
(139, 34, 'Booking Payment', 60000.00, 0, 'LA-00056, MR:156. \r\nPart Of Booking Amount.', '2025-12-31 06:39:00', '2026-05-19 06:41:07'),
(140, 34, 'Installment Payment', 14167.00, 1, 'LA-00056, MR:216. 1st installment,', '2026-03-11 06:44:00', '2026-05-19 06:45:46'),
(141, 35, 'Booking Payment', 200000.00, 0, 'LS-00061, MR: 160, Booking Money.', '2026-01-06 11:44:00', '2026-05-19 11:45:45'),
(142, 35, 'Installment Payment', 15500.00, 1, 'LS-00061, MR: 189, Installment Money.', '2026-02-10 11:47:00', '2026-05-19 11:54:33'),
(143, 35, 'Installment Payment', 15500.00, 1, 'LS-00061, MR: 215, 2nd Installment Money.', '2026-03-11 12:02:00', '2026-05-19 12:05:07'),
(144, 36, 'Booking Payment', 100000.00, 0, NULL, '2026-01-15 12:48:00', '2026-05-19 12:49:10'),
(145, 37, 'Booking Payment', 100000.00, 0, 'LA-00063, MR: 176, Booking Money.', '2026-01-25 06:16:00', '2026-05-20 06:17:33'),
(146, 37, 'Installment Payment', 25000.00, 1, 'LA-00063, MR: 196, 1st Installment', '2026-03-04 06:29:00', '2026-05-20 06:30:08'),
(147, 37, 'Installment Payment', 25000.00, 1, 'LA-00063, MR: 197, 2nd Installment Money.', '2026-03-04 06:34:00', '2026-05-20 06:32:57'),
(148, 37, 'Installment Payment', 50000.00, 2, 'LA-00063, MR: 255, 3th & 4th Installment.', '2026-04-22 06:41:00', '2026-05-20 06:36:48'),
(149, 40, 'Booking Payment', 100000.00, 0, 'LA-00066, MR: 182, Booking Money.', '2026-02-03 04:25:00', '2026-05-21 04:25:13'),
(150, 40, 'Installment Payment', 36000.00, 1, 'LA-00066, MR: 223, 1st Installment.', '2026-03-12 04:28:00', '2026-05-21 04:31:42'),
(152, 40, 'Installment Payment', 36000.00, 1, 'LA-00066, MR: 272, 3rd Installment.', '2026-05-11 05:17:00', '2026-05-21 05:18:54'),
(153, 40, 'Installment Payment', 36000.00, 1, 'LA-00066, MR: 246, 2nd Installment.', '2026-04-12 05:22:00', '2026-05-21 05:22:25'),
(154, 41, 'Booking Payment', 500000.00, 0, 'LA-00067, Plot: A21, MR: 191 & 238, (200000+300000{8/4/26})', '2026-03-01 09:09:00', '2026-05-21 09:12:10'),
(155, 41, 'Installment Payment', 33000.00, 1, 'LA-00067, MR-261, 1st Installment', '2026-05-02 09:13:00', '2026-05-21 09:15:11'),
(156, 42, 'Booking Payment', 500000.00, 0, 'LA-00068, MR:192 & 239,(200000+300000{8/4/26})', '2026-03-01 10:09:00', '2026-05-21 10:11:20'),
(157, 42, 'Installment Payment', 29166.67, 1, 'LA-00068, MR:262, (34000-29166.67={4833.33 Less then})', '2026-05-02 10:13:00', '2026-05-21 10:15:47'),
(158, 42, 'Part Of Installment', 4833.33, 0, 'Note: LA-00068, MR:262, (34000-29166.67={4833.33 Less then})', '2026-05-01 10:23:00', '2026-05-21 10:24:32'),
(159, 43, 'Booking Payment', 500000.00, 0, 'LA-00069, A22 ( MR: 193 & 240 {200000+300000[8/4/26]}', '2026-03-01 10:36:00', '2026-05-21 10:38:08'),
(160, 43, 'Installment Payment', 29166.67, 1, 'LA-00068, MR:263, A22, (33000-29166.67={3833.33 Less then})', '2026-05-02 10:40:00', '2026-05-21 10:42:47'),
(161, 43, 'Part Of Installment', 3833.33, 0, 'LA-00068, MR:263, A22, (33000-29166.67={3833.33 Less then})', '2026-05-02 10:43:00', '2026-05-21 10:43:34'),
(162, 44, 'Booking Payment', 200000.00, 0, 'LA-00070, Plot: A137. MR:214. Booking Money.', '2026-03-11 11:51:00', '2026-05-21 11:52:17'),
(163, 2, 'Installment Payment', 65000.00, 1, 'LA-00004, MR: 277, 4th Installment.', '2026-05-21 05:11:00', '2026-05-23 05:12:24'),
(165, 46, 'Booking Payment', 200000.00, 0, 'LA-00072, MR: 228. Booking Money', '2026-03-14 05:49:00', '2026-05-23 05:50:14'),
(167, 46, 'Installment Payment', 16000.00, 1, 'LA-00072, MR: 267, 1st Installment.', '2026-05-07 05:53:00', '2026-05-23 05:54:12'),
(168, 47, 'Booking Payment', 400000.00, 0, 'LA-00074, MR: 230, 245. [2,00,000+2,00,000]', '2026-03-15 06:29:00', '2026-05-23 06:31:03'),
(169, 48, 'Booking Payment', 200000.00, 0, 'LA-00075, MR: 231. Plot: A23. Booking Money.', '2026-03-15 06:55:00', '2026-05-23 06:56:10'),
(170, 48, 'Installment Payment', 31666.67, 1, 'LA-00075, MR: 268 [ 32000-31666.67=(333.33 Less Than Ins)]', '2026-04-07 06:56:00', '2026-05-23 06:59:03'),
(171, 48, 'Part Of Installment', 333.33, 0, 'LA-00075, MR: 268 [ 32000-31666.67=(333.33 Less Than Ins)]', '2026-05-07 06:59:00', '2026-05-23 06:59:37'),
(172, 49, 'Booking Payment', 200000.00, 0, 'LA-00076, MR: 236, Booking Money.', '2026-04-03 07:25:00', '2026-05-23 07:25:50'),
(173, 49, 'Installment Payment', 31670.00, 1, 'LA-00076, MR: 269, 1st installment', '2026-05-07 07:26:00', '2026-05-23 07:28:00'),
(174, 50, 'Booking Payment', 200000.00, 0, 'LA-00077, MR: 237 & 276. [ 100000+100000=2,00,000]', '2026-04-03 09:36:00', '2026-05-23 09:38:39'),
(175, 51, 'Booking Payment', 300000.00, 0, 'LA-00078, MR: 243, Booking Money', '2026-04-12 10:58:00', '2026-05-23 10:58:59'),
(176, 51, 'Installment Payment', 30833.00, 1, 'La-00078, MR:278, [60000-30833=29167(Less Than install)]', '2026-05-23 11:14:00', '2026-05-23 11:17:40'),
(177, 51, 'Part Of Installment', 29167.00, 0, 'La-00078, MR:278, [60000-30833=29167 (Less Than install)]', '2026-05-23 11:17:00', '2026-05-23 11:18:20'),
(178, 52, 'Booking Payment', 300000.00, 0, 'LA-00079. MR: 244, Booking Money.', '2026-04-12 12:02:00', '2026-05-23 12:03:48'),
(179, 52, 'Installment Payment', 31000.00, 1, 'LA-00079, MR: 264 1st Installment.', '2026-05-05 12:04:00', '2026-05-23 12:05:21'),
(180, 53, 'Booking Payment', 200000.00, 0, 'LA-00080. MR: 266.', '2026-05-05 12:23:00', '2026-05-23 12:24:36'),
(181, 54, 'Booking Payment', 200000.00, 0, 'LA-00081. MR: 270. Booking Money', '2026-05-09 12:37:00', '2026-05-23 12:37:57'),
(182, 55, 'Booking Payment', 200000.00, 0, 'LA-00082, MR: 273. Booking Money.', '2026-05-13 13:01:00', '2026-05-23 13:01:59'),
(183, 56, 'Booking Payment', 200000.00, 0, 'MR: 286, Booking Money.', '2026-05-25 08:24:00', '2026-06-09 08:25:25'),
(184, 30, 'Installment Payment', 15000.00, 1, 'CUS-LA-00050', '2026-06-10 10:24:00', '2026-06-10 10:25:42'),
(185, 30, 'Installment Payment', 15000.00, 1, 'CUS-LA-00050, MR: 271, 5th Ins', '2026-05-10 12:04:00', '2026-06-10 12:06:05'),
(190, 2, 'Down Payment', 5000.00, 0, 'LA-00004, MR: 104, Down Payment.', '2025-11-28 09:52:00', '2026-06-14 09:53:58'),
(191, 101, 'Booking Payment', 100000.00, 0, 'Test Commission , CID-00101.', '2026-06-27 07:16:00', '2026-06-27 07:17:06'),
(192, 101, 'Down Payment', 200000.00, 0, 'Test Dowan Payment', '2026-06-27 07:44:00', '2026-06-27 07:44:57'),
(193, 101, 'Installment Payment', 35000.00, 1, 'Test Installment Commission (CID-000101)', '2026-06-27 07:49:00', '2026-06-27 07:50:06'),
(194, 101, 'Installment Payment', 70000.00, 2, 'Test Installment 2nd & 3rd commission', '2026-06-27 07:56:00', '2026-06-27 07:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `phone_verifications`
--

CREATE TABLE `phone_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `type` enum('registration','password_reset') NOT NULL DEFAULT 'registration',
  `expires_at` timestamp NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phone_verifications`
--

INSERT INTO `phone_verifications` (`id`, `phone`, `code`, `type`, `expires_at`, `verified`, `created_at`, `updated_at`) VALUES
(1, '01322902980', '3510', 'registration', '2026-04-22 09:28:36', 1, '2026-04-22 09:23:36', '2026-04-22 09:24:23');

-- --------------------------------------------------------

--
-- Table structure for table `plots`
--

CREATE TABLE `plots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `plot_no` varchar(255) NOT NULL,
  `size_katha` decimal(8,2) NOT NULL,
  `block` varchar(255) NOT NULL,
  `road_no` varchar(255) NOT NULL,
  `facing` varchar(255) NOT NULL,
  `agent_name` varchar(255) DEFAULT NULL,
  `plot_category` varchar(255) DEFAULT NULL,
  `road_width` varchar(255) DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `booking_payment` decimal(12,2) DEFAULT 0.00,
  `remaining_payment` decimal(12,2) DEFAULT 0.00,
  `installment_plan` enum('monthly','quarterly') DEFAULT NULL,
  `total_installments` int(11) DEFAULT NULL,
  `installment_payment` decimal(12,2) DEFAULT NULL,
  `plot_map` varchar(255) DEFAULT NULL,
  `google_maps_location` text DEFAULT NULL,
  `nearby_facilities` text DEFAULT NULL,
  `status` enum('available','pending','booked','sold') NOT NULL DEFAULT 'available',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plots`
--

INSERT INTO `plots` (`id`, `title`, `plot_no`, `size_katha`, `block`, `road_no`, `facing`, `agent_name`, `plot_category`, `road_width`, `price`, `booking_payment`, `remaining_payment`, `installment_plan`, `total_installments`, `installment_payment`, `plot_map`, `google_maps_location`, `nearby_facilities`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Commercial South Corner', 'A1', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 3500000.00, 200000.00, 3300000.00, NULL, NULL, NULL, 'uploads/plots/1778655631_A1.jpg', NULL, NULL, 'booked', '(SPI Consideration)', '2026-04-09 04:37:53', '2026-05-13 10:12:10'),
(3, 'Commercial South Face', 'A8', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 100000.00, 3900000.00, NULL, NULL, NULL, 'uploads/plots/1775719021_A8.png', NULL, NULL, 'booked', NULL, '2026-04-09 07:17:01', '2026-04-09 07:50:56'),
(4, 'Commercial South Face', 'A3', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 100000.00, 3900000.00, NULL, NULL, NULL, 'uploads/plots/1777193930_A3.jpg', NULL, NULL, 'booked', NULL, '2026-04-09 12:20:29', '2026-04-26 09:15:22'),
(5, 'Commercial South Face', 'A4', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 101000.00, 3899000.00, NULL, NULL, NULL, 'uploads/plots/1777193983_A4.jpg', NULL, NULL, 'booked', NULL, '2026-04-09 12:23:03', '2026-04-26 10:28:18'),
(6, 'Commercial South Face', 'A5', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 101000.00, 3899000.00, NULL, NULL, NULL, 'uploads/plots/1777194116_A5.jpg', NULL, NULL, 'booked', 'LA-00021', '2026-04-09 12:24:22', '2026-04-26 11:03:58'),
(7, 'Commercial South Face', 'A6', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 101000.00, 3899000.00, NULL, NULL, NULL, 'uploads/plots/1777194090_A6.jpg', NULL, NULL, 'booked', NULL, '2026-04-09 12:27:53', '2026-04-26 11:29:29'),
(9, 'Commercial South Face', 'A9', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 100000.00, 3900000.00, NULL, NULL, NULL, 'uploads/plots/1777096714_A9.jpg', NULL, NULL, 'booked', NULL, '2026-04-09 12:30:42', '2026-04-25 06:35:20'),
(10, 'Commercial South Face', 'A10', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 100000.00, 3900000.00, NULL, NULL, NULL, 'uploads/plots/1777110888_A10.jpg', NULL, NULL, 'booked', NULL, '2026-04-09 12:32:09', '2026-04-25 10:12:25'),
(11, 'Commercial South Face', 'A11', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 100000.00, 3900000.00, NULL, NULL, NULL, 'uploads/plots/1775738019_A11.png', NULL, NULL, 'booked', NULL, '2026-04-09 12:33:39', '2026-04-12 10:27:20'),
(12, 'Commercial South Face', 'A12', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 0.00, 0.00, 0.00, NULL, NULL, NULL, 'uploads/plots/1776503897_LA-JpG.jpg', NULL, NULL, 'available', NULL, '2026-04-09 12:35:06', '2026-04-18 09:18:17'),
(13, 'Commercial South Face', 'A13', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 0.00, 0.00, 0.00, NULL, NULL, NULL, 'uploads/plots/1776503287_L A lay-out.jpg', NULL, NULL, 'available', NULL, '2026-04-09 12:36:18', '2026-04-18 09:08:07'),
(14, 'Commercial South Face', 'A14', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 0.00, 0.00, 0.00, NULL, NULL, NULL, 'uploads/plots/1776503339_L A lay-out.jpg', NULL, NULL, 'available', NULL, '2026-04-09 12:37:43', '2026-04-18 09:08:59'),
(15, 'Commercial South Face', 'A15', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL, '2026-04-09 12:39:10', '2026-04-15 04:13:12'),
(16, 'Commercial South Face', 'A16', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 100000.00, 3900000.00, NULL, NULL, NULL, 'uploads/plots/1776771690_A16.jpg', NULL, NULL, 'booked', NULL, '2026-04-09 12:39:53', '2026-04-21 11:50:12'),
(17, 'Commercial South Corner', 'A17', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4500000.00, 100000.00, 4400000.00, NULL, NULL, NULL, 'uploads/plots/1776502850_L A lay-out.jpg', NULL, NULL, 'booked', NULL, '2026-04-09 12:42:21', '2026-06-27 07:16:03'),
(18, 'Residential North Face', 'A260', 5.00, 'A', 'Avenue-01', 'North', NULL, 'Residential', '40 Feet', 3500000.00, 100000.00, 3400000.00, NULL, NULL, NULL, NULL, NULL, NULL, 'booked', NULL, '2026-04-15 12:55:32', '2026-04-15 13:01:53'),
(19, 'Residential South Face', 'A91', 5.00, 'A', '1', 'South', NULL, 'Residential', '25 Feet', 3500000.00, 100000.00, 3400000.00, NULL, NULL, NULL, 'uploads/plots/1776762592_A91.jpg', NULL, NULL, 'booked', 'Old# A34', '2026-04-21 09:09:52', '2026-04-21 10:30:43'),
(20, 'Residential South Face', 'A226', 5.00, 'A', '5', 'South', NULL, 'Residential', '25 Feet', 3500000.00, 100000.00, 3400000.00, NULL, NULL, NULL, 'uploads/plots/1776776900_A226.jpg', NULL, NULL, 'booked', 'Old#6', '2026-04-21 13:08:20', '2026-04-23 05:57:37'),
(21, 'Residential South Face', 'A224', 5.00, 'A', '5', 'South', NULL, 'Residential', '25 Feet', 3500000.00, 100000.00, 3400000.00, NULL, NULL, NULL, 'uploads/plots/1776936371_A224.jpg', NULL, NULL, 'booked', 'Old: 8,', '2026-04-23 09:26:11', '2026-04-23 09:36:01'),
(22, 'Residential North Face', 'A90', 5.00, 'A', '1', 'North', NULL, 'Residential', '25 Feet', 3500000.00, 100000.00, 3400000.00, NULL, NULL, NULL, 'uploads/plots/1776943565_A90.jpg', NULL, NULL, 'booked', NULL, '2026-04-23 11:26:05', '2026-04-23 13:21:02'),
(23, 'Residential South Face', 'A134', 3.00, 'A', '3', 'South', NULL, 'Residential', '25 Feet', 2100000.00, 100000.00, 2000000.00, NULL, NULL, NULL, 'uploads/plots/1777118196_A134.jpg.jpg', NULL, NULL, 'booked', NULL, '2026-04-25 11:56:36', '2026-04-25 12:11:40'),
(24, 'Residential South Face', 'A107', 3.00, 'A', '3', 'South', NULL, 'Residential', NULL, 2100000.00, 100000.00, 2000000.00, NULL, NULL, NULL, 'uploads/plots/1777283407_A107.jpg', NULL, NULL, 'booked', NULL, '2026-04-27 09:50:07', '2026-04-27 10:48:52'),
(25, 'Residential South Face', 'A141', 3.00, 'A', '4', 'South', NULL, 'Residential', '20 Feet', 2100000.00, 100000.00, 2000000.00, NULL, NULL, NULL, 'uploads/plots/1777371173_A141.jpg', NULL, NULL, 'booked', NULL, '2026-04-28 10:12:53', '2026-04-28 10:45:18'),
(26, 'Residential South Face', 'A143', 3.00, 'A', '4', 'South', NULL, 'Residential', '20 Feet', 2100000.00, 100000.00, 2000000.00, NULL, NULL, NULL, 'uploads/plots/1777371630_A143.jpg', NULL, NULL, 'booked', NULL, '2026-04-28 10:20:30', '2026-04-28 12:17:11'),
(27, 'Residential South Face', 'A145', 3.00, 'A', '4', 'South', NULL, 'Residential', '20 Feet', 2100000.00, 100000.00, 2000000.00, NULL, NULL, NULL, 'uploads/plots/1777371781_A145.jpg', NULL, NULL, 'booked', NULL, '2026-04-28 10:23:01', '2026-04-28 12:51:26'),
(28, 'Residential North Face', 'A135', 3.50, 'A', '3', 'North', NULL, 'Residential', '25 Feet', 2450000.00, 100000.00, 2350000.00, NULL, NULL, NULL, 'uploads/plots/1777444735_A135.jpg', NULL, NULL, 'booked', NULL, '2026-04-29 06:38:55', '2026-04-29 09:33:37'),
(29, 'Residential North Face', 'A132', 3.50, 'A', '3', 'North', NULL, 'Residential', '25 Feet', 2450000.00, 100000.00, 2350000.00, NULL, NULL, NULL, 'uploads/plots/1777459290_A132.jpg', NULL, NULL, 'booked', NULL, '2026-04-29 10:41:30', '2026-04-29 11:39:43'),
(30, 'Residential South Face', 'A251', 5.00, 'A', '5', 'South', NULL, 'Residential', '25 Feet', 3500000.00, 100000.00, 3400000.00, NULL, NULL, NULL, 'uploads/plots/1777466097_A251.jpg', NULL, NULL, 'booked', NULL, '2026-04-29 12:34:57', '2026-04-29 12:51:49'),
(31, 'Commercial South Face', 'B15', 5.00, 'B', 'Avenue-01 & Main Road', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 200000.00, 3800000.00, NULL, NULL, NULL, 'uploads/plots/1777525435_B15.jpg', NULL, NULL, 'booked', NULL, '2026-04-30 05:03:55', '2026-04-30 05:40:43'),
(32, 'Commercial South Face', 'A62', 7.00, 'A', '02 & Main Roda', 'South', NULL, 'Commercial', '60 Feet', 5600000.00, 200000.00, 5400000.00, NULL, NULL, NULL, 'uploads/plots/1777535021_A62.jpg', NULL, NULL, 'booked', NULL, '2026-04-30 07:43:41', '2026-04-30 08:30:27'),
(33, 'Commercial North Face', 'A272', 5.00, 'A', 'Avenue-01 & Main Road', 'North', NULL, 'Commercial', NULL, 4000000.00, 200000.00, 3800000.00, NULL, NULL, NULL, 'uploads/plots/1777540543_A272.jpg', NULL, NULL, 'booked', NULL, '2026-04-30 09:15:43', '2026-04-30 09:49:58'),
(34, 'Commercial South Face', 'A222', 5.00, 'A', '5 & Main Road', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 200000.00, 3800000.00, NULL, NULL, NULL, 'uploads/plots/1777544942_A222.jpg', NULL, NULL, 'booked', NULL, '2026-04-30 10:29:02', '2026-04-30 11:27:34'),
(35, 'Commercial South Face', 'A138', 6.00, 'A', '3 & Main Road', 'South', NULL, 'Commercial', NULL, 4800000.00, 200000.00, 4600000.00, NULL, NULL, NULL, 'uploads/plots/1777715915_A138.jpg', NULL, NULL, 'booked', NULL, '2026-05-02 09:58:35', '2026-05-02 10:35:20'),
(36, 'Commercial North Face', 'A223', 6.00, 'A', '5 & Main Road', 'North', NULL, 'Commercial', '60 Feet', 4800000.00, 200000.00, 4600000.00, NULL, NULL, NULL, 'uploads/plots/1777795789_A223.jpg', NULL, NULL, 'booked', NULL, '2026-05-03 08:09:49', '2026-05-03 08:27:52'),
(37, 'Commercial North Face', 'A140', 7.00, 'A', '4 & Main', 'North', NULL, 'Commercial', '60 Feet', 5600000.00, 200000.00, 5400000.00, NULL, NULL, NULL, 'uploads/plots/1777798971_A140N.jpg', NULL, NULL, 'booked', NULL, '2026-05-03 09:02:51', '2026-05-03 10:10:21'),
(38, 'Residential South Face', 'A136', 3.00, 'A', '3', 'South', NULL, 'Residential', '25 Feet', 2100000.00, 100000.00, 2000000.00, NULL, NULL, NULL, 'uploads/plots/1777805423_A136S.jpg', NULL, NULL, 'booked', NULL, '2026-05-03 10:50:23', '2026-05-03 11:31:53'),
(39, 'Residential South Face', 'A115', 3.00, 'A', '3', 'South', NULL, 'Residential', '25 Feet', 2100000.00, 100000.00, 2000000.00, NULL, NULL, NULL, 'uploads/plots/1777982695_A115S.jpg', NULL, NULL, 'booked', NULL, '2026-05-05 12:04:55', '2026-05-05 12:19:26'),
(40, 'Residential South Face', 'A113', 3.00, 'A', '3', 'South', NULL, 'Residential', '25 Feet', 2100000.00, 60000.00, 2040000.00, NULL, NULL, NULL, 'uploads/plots/1779170922_A113.jpg', NULL, NULL, 'booked', NULL, '2026-05-14 09:53:27', '2026-05-19 06:29:11'),
(41, 'Residential South Face', 'A73', 3.50, 'A', '1', 'South', NULL, 'Residential', '25 Feet', 2450000.00, 200000.00, 2250000.00, NULL, NULL, NULL, 'uploads/plots/1779184643_A73.jpg', NULL, NULL, 'booked', NULL, '2026-05-19 09:57:23', '2026-05-19 11:40:52'),
(42, 'Commercial North Face', 'A137', 7.00, 'A', '3 & Main Road', 'North', NULL, 'Commercial', NULL, 5600000.00, 200000.00, 5400000.00, NULL, NULL, NULL, 'uploads/plots/1779192978_A137.jpg', NULL, NULL, 'booked', NULL, '2026-05-19 12:16:18', '2026-05-21 11:48:59'),
(43, 'Residential South Face', 'A65', 3.50, 'A', '1', 'South', NULL, 'Residential', NULL, 2450000.00, 100000.00, 2350000.00, NULL, NULL, NULL, 'uploads/plots/1779193152_A137.jpg', NULL, NULL, 'booked', NULL, '2026-05-19 12:19:12', '2026-05-19 12:34:49'),
(44, 'Residential North Face', 'A124', 3.50, 'A', '3', 'North', NULL, 'Residential', NULL, 2450000.00, 100000.00, 2350000.00, NULL, NULL, NULL, 'uploads/plots/1779195446_A124.jpg', NULL, NULL, 'booked', NULL, '2026-05-19 12:57:26', '2026-05-20 05:34:36'),
(45, 'Residential North Face', 'A228', 5.00, 'A', '5', 'North', NULL, 'Residential', NULL, 3500000.00, 100000.00, 3400000.00, NULL, NULL, NULL, 'uploads/plots/1779337042_A288.jpg', NULL, NULL, 'booked', NULL, '2026-05-21 04:17:22', '2026-05-21 04:21:27'),
(46, 'Commercial South Face', 'A21', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', NULL, 4000000.00, 500000.00, 3500000.00, NULL, NULL, NULL, 'uploads/plots/1779346272_A21.jpg', NULL, NULL, 'booked', NULL, '2026-05-21 06:51:12', '2026-05-21 09:06:39'),
(47, 'Commercial South Face', 'A20', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '40 Feet', 4000000.00, 500000.00, 3500000.00, NULL, NULL, NULL, 'uploads/plots/1779357230_A20.jpg', NULL, NULL, 'booked', NULL, '2026-05-21 09:53:50', '2026-05-21 10:06:04'),
(48, 'Commercial South Face', 'A22', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '40 Feet', 4000000.00, 500000.00, 3500000.00, NULL, NULL, NULL, 'uploads/plots/1779359479_A22.jpg', NULL, NULL, 'booked', NULL, '2026-05-21 10:31:19', '2026-05-21 10:34:19'),
(49, 'Residential South Face', 'A133', 3.00, 'A', '3', 'South', NULL, 'Residential', '25 Feet', 2100000.00, 200000.00, 1900000.00, 'monthly', 120, 15833.33, 'uploads/plots/1779515021_A133.jpg', NULL, NULL, 'booked', NULL, '2026-05-23 05:43:41', '2026-05-23 05:45:53'),
(50, 'Commercial South Face', 'A28', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 400000.00, 3600000.00, NULL, NULL, NULL, 'uploads/plots/1779517324_A28.jpg', NULL, NULL, 'booked', NULL, '2026-05-23 06:22:04', '2026-05-23 06:27:34'),
(51, 'Commercial South Face', 'A23', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 200000.00, 3800000.00, NULL, NULL, NULL, 'uploads/plots/1779518721_A23.jpg', NULL, NULL, 'booked', NULL, '2026-05-23 06:45:21', '2026-05-23 06:52:20'),
(52, 'Commercial South Face', 'A25', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 200000.00, 3800000.00, NULL, NULL, NULL, 'uploads/plots/1779520761_A25.jpg', NULL, NULL, 'booked', NULL, '2026-05-23 07:19:21', '2026-05-23 07:24:55'),
(53, 'Commercial South Face', 'A24', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 200000.00, 3800000.00, NULL, NULL, NULL, 'uploads/plots/1779527239_A24.jpg', NULL, NULL, 'booked', NULL, '2026-05-23 09:07:19', '2026-05-23 09:36:07'),
(54, 'Commercial South Face', 'A26', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 300000.00, 3700000.00, NULL, NULL, NULL, 'uploads/plots/1779529463_A26.jpg', NULL, NULL, 'booked', NULL, '2026-05-23 09:44:23', '2026-05-23 10:56:59'),
(55, 'Commercial South Face', 'A27', 5.00, 'A', 'Zazira', 'South', NULL, 'Commercial', '60 Feet', 4000000.00, 300000.00, 3700000.00, NULL, NULL, NULL, 'uploads/plots/1779535625_A27.jpg', NULL, NULL, 'booked', NULL, '2026-05-23 11:27:05', '2026-05-23 12:01:40'),
(56, 'Residential South Face', 'A77', 3.50, 'A', '1', 'South', NULL, 'Residential', '25 Feet', 2450000.00, 200000.00, 2250000.00, NULL, NULL, NULL, 'uploads/plots/1779538450_A77.jpg', NULL, NULL, 'booked', NULL, '2026-05-23 12:14:10', '2026-05-23 12:23:31'),
(57, 'Residential South Face', 'A106', 3.00, 'A', '3', 'South', NULL, 'Residential', '25 Feet', 2400000.00, 200000.00, 2200000.00, NULL, NULL, NULL, 'uploads/plots/1779539488_A106.jpg', NULL, NULL, 'booked', NULL, '2026-05-23 12:31:28', '2026-05-23 12:34:26'),
(58, 'Residential South Face', 'A75', 3.50, 'A', '1', 'South', NULL, 'Residential', '25 Feet', 2450000.00, 200000.00, 2250000.00, NULL, NULL, NULL, 'uploads/plots/1779540666_A75.jpg', NULL, NULL, 'booked', NULL, '2026-05-23 12:51:06', '2026-05-23 13:01:07'),
(59, 'Residential South Face', 'A131', 3.00, 'A', '3', 'South', NULL, 'Residential', '25 Feet', 2400000.00, 200000.00, 2200000.00, NULL, NULL, NULL, NULL, NULL, NULL, 'booked', NULL, '2026-06-09 07:40:54', '2026-06-09 08:21:52');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BmZkV2DEDmkBbjD0V8CRtdrCPfpnt7hxE03aEjQC', 1, '203.99.145.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMUpQZlV6MTlyYkx4TE9zYWQzTllFTTY1ZVdQb3I2ZnpidFlLdkplWiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ0OiJodHRwczovL2FiYXNvbi50ZWNoYm9sb3kuY29tL2FkbWluL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1783401124);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spouse_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominee_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominee_nid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominee_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominee_relation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','agent','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `commission_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `commission_rate` decimal(5,2) DEFAULT NULL,
  `booking_pct` decimal(5,2) DEFAULT NULL,
  `down_pct` decimal(5,2) DEFAULT NULL,
  `instalment_pct` decimal(5,2) DEFAULT NULL,
  `referral_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `client_id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `emergency_phone`, `address`, `photo`, `profile_image`, `father_name`, `mother_name`, `spouse_name`, `nid`, `nominee_name`, `nominee_nid`, `nominee_photo`, `nominee_relation`, `role`, `commission_type`, `parent_id`, `permissions`, `status`, `commission_rate`, `booking_pct`, `down_pct`, `instalment_pct`, `referral_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Admin User', 'admin@londonabd.com', '2026-04-07 08:01:35', '$2y$12$1KMqz6R7XjtPesj61eeVD.gBVJSYXbWvDLRFghXhli8nrB9KWoKOG', '+8801322902988', NULL, NULL, NULL, 'uploads/admin/1775632564_LA-Logo.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, 'cXdKo6KhjJ1zmOVHcbt0NosZMYDVl2YmZAhGVNB1Aei4DiqHLFSPMqt1NEZm', '2026-04-07 08:01:35', '2026-04-08 07:16:04'),
(2, NULL, 'Test ED', 'ed@londonabd.com', '2026-04-07 08:01:36', '$2y$12$Ww29PhI/sBOpuB5/VzfCtOjUJX9t8dowaAl4zR7eo6qmsMbgxQfp.', '01780603328', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'ed', NULL, NULL, 'active', 12.00, 3.00, 2.00, 2.00, 'test', 'xdz6I6p7Br6kB2FE3rYUWMC9n3hy1kveLzaI93WyfvgGnA7Z7zXVM5n24f4F', '2026-04-07 08:01:36', '2026-06-14 08:17:13'),
(3, 100, 'Customer User', 'user@londonabd.com', '2026-04-07 08:01:36', '$2y$12$6fRxGgVHBDf4s07mz5hlKe8ZEgY04WbJnOpikSbpsoKMCT.WPwe8q', '01912345678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, 'H3O844MnzHPsLjKwqIzoafxCw3oArzmMlgBYayFH7RrKD4nAVsFx0ozrImbF', '2026-04-07 08:01:36', '2026-04-19 16:38:06'),
(4, NULL, 'Md Sazzad Ali', 'sazzadbd2045@gmail.com', NULL, '$2y$12$MFiMQ1xynQvfu5XAd1zDrOeQtOKUqJmSJ4Os6ydKyyFaeL56.ONbK', '+8801322902988', NULL, 'House# 3, Road# Main Road, Block# H, Banasree, Rampura, Dhaka-1219', NULL, NULL, 'WAHED ALI', 'SABIHA BEGUM', NULL, '6439498921', NULL, NULL, NULL, NULL, 'agent', 'ed', NULL, NULL, 'active', 10.00, 3.00, 2.00, 2.00, 'AG4A768C', 'W2ARhD1rr9MdUizfYPw6hERsz8oBrt2KG6f9RY8OtpS6tE06vOm5Nohqszbg', '2026-04-09 07:32:04', '2026-06-14 10:28:56'),
(5, 1, 'SHAHIDA HOQUE', 'sazubd@hotmail.com', NULL, '$2y$12$WWILEINnSCUKUjy.eOW0e.ihxjnBhzjdREA9Mcw5KAzTlaAhYBKr.', '+8801819484992', '+8801322902988', 'House# 1 (2nd Floor), Road# 10, Section# 11, Block# C, P.O# Mirpur-1216, Pallabi, Dhaka.', 'uploads/user/1775730492_02.jpeg', NULL, 'WAHED ALI', 'SABIHA BEGUM', NULL, '1021609605', 'Shakh Ahasanul Haque', '5093172608', 'uploads/user/1775730492_nominee_Untitled (1).png', 'Son', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-27 18:00:00', '2026-06-06 05:57:14'),
(6, NULL, 'Golam Morshed Shihab', 'gmorshed135@outlook.com', NULL, '$2y$12$TUKzh0l31U8qp7VaXmnFU.VrPYOzISO4YdO4JKm2v7pDu6ipF73wG', '+8801738204604', NULL, 'West Nakhalpara, Tejgaon, Dhaka-1215.', 'uploads/agent/1775973067_Resize image project.jpeg', NULL, 'Ibrahim Khalil', 'Aklima Khanum', NULL, '5542794218', NULL, NULL, NULL, NULL, 'agent', 'ed', NULL, NULL, 'active', 10.00, 3.00, 2.00, 2.00, 'AG129A9B', '3OkuQ2BzFH2lR7AaSSZCSMcubP3IH1dJmcpl2YMbh9BU8nUhSpylmodynCis', '2026-04-12 05:32:20', '2026-06-14 10:29:07'),
(7, 2, 'Abu Bakar Siddiki', 'abubakarsiddiki3200@gmail.com', NULL, '$2y$12$SBoVcGD8QGh.MG4T.uCOJO1CQF1TsAZE.IS30n/LqOdy0RjsT9Xo2', '+8801318167582', '8801301867582', '134, Lalbagh Road, Dhaka, Bangladesh', NULL, NULL, 'Let Abdul Hamid', 'Let Salima Khatun', 'Parvin Siddika', '2694069203200', 'Parvin Siddika', NULL, NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, 'BqzOStSBnUyTSgMQBcWrupT1ghk7OUs5eqYU3DeW3DMs5AeuP3jcBtTtfUTw', '2025-11-27 18:00:00', '2026-06-06 06:43:30'),
(11, NULL, 'Mohammad Shameem Howlader', 'shamimhowlader166@gmail.com', NULL, '$2y$12$ZXiBaV3jFDpj5BDJw6slBu0gvHDutiHI.p/kbfc6KyOYJEM0z.iYi', '+8801893011119', NULL, 'Banasree, Rampura, Dhaka-1219', NULL, NULL, 'Mohammad Mohasin Uddin Howlader', 'Khadija Begum', NULL, '1945213310', NULL, NULL, NULL, NULL, 'agent', 'ed', NULL, NULL, 'active', 10.00, 3.00, 2.00, 2.00, 'AG4EA259', '3asCwSv87ypiWPT5venPvnX0s8AS1vJXGecfaMEeGmGAFLUAGtfYXoj9ay92', '2026-04-15 11:53:26', '2026-06-14 10:28:42'),
(40, 16, 'Shangida Hossan', 'sazubd@gmail.com', NULL, '$2y$12$7n4LI0Is6zhOW/Y5.TiQq.zFbdrZs0IQWPJbgoOS/2CztROCFxwIG', '+8801913395267', '+8801322902988', 'House#09, Road#Ave-2, Sec#11, Block# A, Mirpur, Dhaka', 'uploads/user/1776257075_Shangida_40.png', NULL, 'WAHED ALI', 'SABIHA BEGUM', 'Tofazzal Hossan', '1489500080', 'Md. Sazzad Ali', '6439498921', NULL, 'Brother', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-01 18:00:00', '2026-06-05 05:52:32'),
(42, NULL, 'Booking Manager', 'booking.manager@londonabd.com', NULL, '$2y$12$9FHnTS3X3Qq1lqfr1kYL3uPKag2chGyPrqsL07iPTisbHfquVcDyS', '01234567890', NULL, NULL, 'uploads/admin/1776321866_user.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, '[\"manage_plots\",\"manage_bookings\"]', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-16 05:34:28', '2026-04-16 06:44:44'),
(43, NULL, 'Morshed Shihab', 'shihab@gmail.com', NULL, '$2y$12$NSelCTGZprFmn2s.SKU6wOfjIkFGlXipiTDjpTmk37vpamBKheOTm', '0132345987', NULL, 'West Nakhalpara', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, '[\"manage_payments.view\",\"manage_commission_users.view\"]', 'active', NULL, NULL, NULL, NULL, NULL, '0bG8Zm0eT6HfIqYG4cBdN9gqpjqGSGFQxQfYQrAYrYeYsNNI3fIm6VILxISN', '2026-04-19 11:25:07', '2026-06-24 13:49:03'),
(44, 3, 'Mohammad Kabiruzzaman (Gong)', 'kabiruzzaman1979@gmail.com', NULL, '$2y$12$2nfZOuVo2Ju/LzCRhVFrFuTAzsuuTc5FvE0ULbLqBLPzNIOIm/DIW', '8801879114452', NULL, 'Char-Dawlathkhan, Char-Dawlathkhan-7920,  Kalkini, Madaripur.', 'uploads/user/1776764229_20260421_151514 (1).jpg', NULL, 'Abdur Rashied Sharder', 'Mos: Munnujan Begum', NULL, '7334167371', 'Rina', '6001121760', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, 'Ai7jx2LcZWaPgPlzz99cZoYofDZjHMx9VLJKP4Vaqb5c97pTUDw0wkjxJ8lY', '2025-11-27 18:00:00', '2026-06-05 05:54:31'),
(45, 7, 'Md. Shaheduzzaman (Gong)', 'shaheduzzaman1987@gmail.com', NULL, '$2y$12$nNZWrZElbk7W162B/d4Jm.L5zISLtuZnuRf/4IactamrJp2k3eLaK', '8801877301710', NULL, 'H# Momataj Mongil, Vill: Box Nagar, Joka, P.O: Sarulia-1361, Demra, Dhaka.', NULL, NULL, 'Md. Emdad Hossain', 'Umme Salma', NULL, '2868911377', NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, '9VY3Bl1jPUNsm9fUZY5qn5pbnDwA1JJ3iLtlHJnnFklRYzKwH12gpTH5gJVV', '2025-11-27 18:00:00', '2026-06-05 05:55:23'),
(46, 11, 'Mahamudul Hasan', 'mohamudul2248@gmail.com', NULL, '$2y$12$zIqrigCsJ6j2X9MOG/6UQeQq/hwa/v96d7DqDQghi2QNeZ9M3.SFK', '88001731841355', NULL, 'Char-Dawlathkhan, C D Khan-7920, Kalkini, Madaripur.', NULL, NULL, 'Abdur Roab Howlader', 'Rashida Khanam', 'Naima Ferdous', '3301082248', 'Naima Ferdous', '3251930560', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 18:00:00', '2026-06-05 05:58:49'),
(48, 12, 'Mohammad Raisul Islam', 'mohammadraisul4902@gmail.com', NULL, '$2y$12$5CfETGuwR6AB43Jczmf5ReV3f0ZZjhmWTtVR60r/OVkrA6.UMcUim', '8801731841355', NULL, 'Vill: Char-Dawlathkhan, P.S: Char-Dawlathkhan-7920, P.O: Kalkini, Zilla: Madaripur.', NULL, NULL, 'Howlader Abdur Rouf', 'Most. Rashida Khanam', 'Monira Khondaker', '5565234902', 'Monira Khondaker', NULL, NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, 'IQcXJTo8CuXEYV3xUZeke5ftOQ4IZwiVnAJ6GJELGlGSGppkGMp95mzmJsmv', '2025-11-28 18:00:00', '2026-06-05 06:03:31'),
(49, 6, 'Md. Takbar Hossain', 'takbarhossain4660@gmail.com', NULL, '$2y$12$ohSxaX.fBKnX.FOMfMnKReDmdAy5acMNyUPJxS/C4MwwtmC7psPOC', '8801914872053', NULL, 'House# 52, Road# 10, Block# N, Banasree, Dhaka.', NULL, NULL, 'Md. Raich Uddin Molla', 'Most: Nabiran Nessa', NULL, '2915621144660', NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-27 18:00:00', '2026-06-05 06:05:45'),
(50, 4, 'Jalal Hossain', 'jalalhossain0030@gmail.com', NULL, '$2y$12$SP9PIJUNCvzBB3b4zAW6uOdwVJB51WHHKacOgFnzPmAEOYmQvuxNC', '8801941319674', '+8801322902980', 'Vill: Patakata, P.S: Matbaria-8560, Matbaria, Pirojpur.', NULL, NULL, 'Nurul Haque', 'Kohinur Begum', NULL, '1516900030', 'Mst.Rekha Begum', '8243549238', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-27 18:00:00', '2026-06-05 06:10:00'),
(51, 5, 'Mohammad Ikbal Anwarul Islam', 'ikbalanwarulislam6369@gmail.com', NULL, '$2y$12$h7jlHN9KBdOkk0XmqEPL/.wAyEmEmeVGUNr3nnxhNvSn06sx00OJe', '8801826407288', NULL, 'House# 14, Dakkhin Banasree, Block# D, Khilgaon, Dhaka.', NULL, NULL, 'Mohammad Ibrahim', 'Johra Begum', 'Mst. Ferdoshi Akter', '3317386369', 'Mst. Ferdoshi Akter', NULL, NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-27 18:00:00', '2026-06-05 06:08:11'),
(52, 8, 'Mamunur Rashid Shohag', 'mamunurrashidshohag9607@gmail.com', NULL, '$2y$12$UOSAwks0svIstUJiGZ0SqO6/EQZMIhboGHN7wIZ0Cn0h7oQNeNZCS', '8801813259262', NULL, 'Vill: Belongka, P.O: Tarail-2316, P.S: Tarail, Kishoreganj.', NULL, NULL, 'Abul Hashim Bhuyan', 'Salma Akter', NULL, '4819254759607', 'Abdul Anas', NULL, NULL, 'Son', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-27 18:00:00', '2026-06-05 08:41:01'),
(53, 9, 'Kaniz Fatema Urmi', 'kanizfatema9434@gmail.com', NULL, '$2y$12$dH3O7cjVJgGXgisHe6Vp1uynG3cQNG7EpouSn0.aW9y84IpWQnVVO', '8801799350295', NULL, 'Vill: Singrabunia, P.O: Bukabunia-8730, Bamna, Barguna.', NULL, NULL, 'Md. Nazrul Islam', 'Sahida Islam', 'Mojammel Haque', '4652349434', 'Mojammel Haque', '4166857013', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-27 18:00:00', '2026-06-05 08:41:47'),
(54, 10, 'Bondhu Association', 'bondhuassociation7013@gmail.com', NULL, '$2y$12$w0a/zN0KZ3sMYVrAYk9GyuteIJYW80CKf5Kw19QSCGjeO0fGsjSuG', '8801762420735', NULL, 'Singrabunia, Bokubunia-8730, Bamna, Barguna', NULL, NULL, 'Md Asraf Ali', 'Mst. Chanful Ftema', NULL, '4166857013', NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 18:00:00', '2026-06-05 08:43:24'),
(55, 13, 'Faysal Matubber', 'faysalmatubber0663@gmail.com', NULL, '$2y$12$JDM3z7RJ2Dy7LgjrcLXVX.znTtAkbElzHf5lzJIw3v1JVYZ2hCQGK', '8801911768617', NULL, 'Baghoriya, Dhuashare-7900, Baligram, Dasar, Maradipur.', NULL, NULL, 'A Hamed Matubber', 'Momataj Begum', NULL, '5551340663', 'Labib Bin Ferdoush', '20225414012126671', NULL, 'Son', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-28 09:12:54', '2026-04-28 13:01:27'),
(56, 14, 'Md. Saiful Islam', 'saifulislam0080@gmail.com', NULL, '$2y$12$HVRPnupnzyKtq3G4PfMmc.K45CLN6yw.FvDyHSHtfTJBX..kPFuam', '8801844265042', NULL, 'Vill: Uttar Voutoli, P.O: Birmohan. P.S: Dasar. Dis: Madaripur.', NULL, NULL, 'H. M. Mostofa Kamal', 'Mst: Myna Begum', NULL, '3258480080', 'Nazma', '1948613045', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-29 06:50:15', '2026-04-29 09:49:29'),
(57, 15, 'MD. Hemayet Hossain', 'hemayethossain4978@gmail.com', NULL, '$2y$12$/PTh0WtI0WyNI.cpJAiZmuFY.y1QPvIrtagrW0caveCoJbUG4f2jW', '013003654', NULL, 'Uttar Vaotoli, Birmohon, Kalkini, Madaripur.\r\nPassport no: EM0984978.', NULL, NULL, 'Abdul Khalek Howlader', 'Sufia Begum', NULL, '19785414063013588', 'Asia Begum', NULL, NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-29 11:11:58', '2026-04-29 11:42:30'),
(58, 17, 'Md. Bellal Beg', 'bellalbeg6013@gmail.com', NULL, '$2y$12$sJD63BQmU8fkdwr.f/s5juR2oUJ/Kva1lxEqTGTDX4j34Buq6TGV2', '8801913255039', NULL, 'H# 16, Vill: Ave-3, Len-6, Section-11, P.O: Mirpur-1216. Dhaka.', NULL, NULL, 'Wazed Beg', 'Taslima Khatun', NULL, '5543546013', 'Mst. Salma Begum', '6893474806', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-29 12:41:14', '2026-05-19 05:11:20'),
(59, 18, 'Md. Ziaur Rahman', 'ziarahman1505522@gmail.com', NULL, '$2y$12$DBEyZODrLP77q0AB02G5i.WcZOARCHBHdzMQhocKIgX5hOPJilQEa', '8801670695522', '8801723976078', '371, North Shajahanpur, Dhaka.', NULL, NULL, 'Md. Nurul Islam Akonda', 'Rahima Begum', NULL, '2833240258', NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-19 18:00:00', '2026-06-05 08:43:48'),
(60, 19, 'Md. Tufayl Ahmed Yusuf', 'tufaylahmedyusuf@gmail.com', NULL, '$2y$12$Q2hNuXfvmWsoyhcyHkElgeeqeUj98uwtNlJLOlKUy/xDo4glArHie', '8801811493667', '8801811493667', '386/3-A, Road# 14, Akota Sarok, Khilgaon, Dhaka.', NULL, NULL, 'Let. Moyez Uddin', 'Mst. Nilufa Khatun', NULL, '19896129401000002', 'Raihatul Jinan/ Muaz Ahmed Jauwad', NULL, NULL, 'Son', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, '1PtoaTp3WtZ5a0n55zYigGi6qfcE5DD1xPAdaG0rMI20lm2cPODy9JXB2LPU', '2025-12-12 18:00:00', '2026-06-10 13:41:28'),
(61, 20, 'Md. Shamin', 'mdshamin4983@gmail.com', NULL, '$2y$12$csoW6UwkAf5bW52Wb1p4nOd3EzgDhoNw8mr.lZl1u/2GJZj5B9XS.', '8801818586220', '8801727331510', 'House# 2, Road# 18, North Goran, Khilgaon-1219, Dhaka', NULL, NULL, 'Jahir Rayhan', 'Bilkis Begum', 'Zanu Begum', '5063634983', 'Zanu Begum', '9557048015', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, 'YoGcmT5K8fL8g5m8NwXtZRIHsd9LisLYfpPjjBf7JO8S2k2SgyMn8Og7Xzaz', '2025-12-16 18:00:00', '2026-06-05 08:45:07'),
(62, 21, 'Zannatul Ferdous', 'zannatulferdous7099@gmail.com', NULL, '$2y$12$IVKFy9EXzpyQcJkJLky1MugTCjHftPLIZYLyEUKHEsBJglUlq4Jwi', '8801610203086', NULL, '371, North Shahjahanpur, Dhaka', NULL, NULL, 'Md. Hasan', 'Khadija Begum', NULL, '1456387099', NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-16 18:00:00', '2026-06-05 08:45:30'),
(63, 22, 'Zanu Begum', 'zanubegum8015@gmail.com', NULL, '$2y$12$z33D5Rb3uW6rx3MPKaikJO3Dk5Ta4Mi.7fh2h7I6Xv94blEp.SDlm', '8801311944995', NULL, 'House# 1383/8/2, Natun Bag, P.O: Khilgaon-1219, Khilgaon, Dhaka.', NULL, NULL, 'Ayoub Ali', 'Nasufa BEgum', NULL, '9557048015', 'Md. Shamim', '5063634983', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-16 18:00:00', '2026-06-05 08:45:49'),
(64, 23, 'Mohammad Abu Saleh', 'mohammadabuaaleh2811@gmail.com', NULL, '$2y$12$/TSzG10TtXYdIOut/A3EbOU1hgqzysTKfCrpGCxRBXz3kbL5P5iG.', '8801787075252', '8801716375628', 'H# 527/1A, Vill: Noyatola, P.O: Shintinagor-1217, Mogbazar, Dhaka.', NULL, NULL, 'Mohammad Jamil', 'Rashida Begum', NULL, '8223092811', 'Samiha Anan, Samara Anan', NULL, NULL, 'Daughter', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-16 18:00:00', '2026-06-05 08:46:11'),
(65, 24, 'Umaer Ahmad Mollah', 'umaerahmadmollah8476@gmail.com', NULL, '$2y$12$lhR5ueUOFDN0dV6Dxx1N/OYQ/SbaJl7WZBUoGfzVd7gULnQgUCSZG', '8801848334130', NULL, 'H# Saheb Protap, Vill: Baghata, P.O: Bag Hata-1603, Narsingdi.', NULL, NULL, 'Md. Mosleh Uddin Mollah', 'Saleha Begum', NULL, '9571578476', 'Takiya', NULL, NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-16 18:00:00', '2026-06-05 08:46:29'),
(66, 25, 'Md. Babu', 'mdbabu8273175@gmail.com', NULL, '$2y$12$1Rm55HxL6ep/ZdE3EXSgtuSltHR5cqti12.yPmTjQTlPg1nNhYuaS', '8801935184238', NULL, '3/3, North Mugdapara, Dhaka', NULL, NULL, 'Ramij Uddin', 'Aklima Banu', NULL, '6868273175', 'Anju Begum', NULL, NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-16 18:00:00', '2026-06-10 10:45:31'),
(67, 28, 'Md. Shariful Islam', 'sharifulislam9350@gmail.com', NULL, '$2y$12$Tjk6aeGyYht7FgL1GcTVeuVWb1DcpjWemNw.uhGHdAoKYa1ENK4Bq', '8801405481162', '01893346573', 'Tongi Besic, Jamai Bazar, Dhaka', NULL, NULL, 'Zanab Md. Leakat Ali', 'Ms. Nasima Khatub', NULL, '654321', 'Sumiya Akter Mim', '00221000', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 18:00:00', '2026-06-05 08:47:41'),
(68, 26, 'Rubina', 'rubina1834@gmail.com', NULL, '$2y$12$7rxhKvrBYBhePUjUHQpH8u7s7ZVnvokIzFYEsO29xMCVXBB6FniWW', '8801912226871', NULL, 'Vill: Rekrozbag, P.O: Brahmankitta-1310, Keranigonj, Dhaka.', NULL, NULL, 'Md. Kuddus Faraji', 'Umme Kulsum', 'MD. Abdul Latif', '9122951834', 'MD. Abdul Latif', '2613834219105', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, 'ywXLAgdEgY1kd9ZkmRZuyaixiFnBIFLNaC7CIGI1OCKw6sKN0VBoKmB437WQ', '2025-12-30 18:00:00', '2026-06-05 08:48:09'),
(69, 29, 'Hafez Md. Ariful Islam', 'hafezmdarifulislam8873@gmail.com', NULL, '$2y$12$qN2VPUa31HVo0CWJHfgIleS/fM835veEGJc4qCuid74a0LZw/hLXG', '+8801893346573', NULL, 'Kharua, Lalahil, Mymanshing', NULL, NULL, 'Liaquet Ali', 'Nachima Khatun', NULL, '20066117247128873', NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 18:00:00', '2026-06-05 08:48:32'),
(70, 30, 'Md. Abdul Aziz', 'abdulaziz7425@gmail.com', NULL, '$2y$12$j0/58cV4C1DDqVWyzmV2BOytj4QmdeVwpg2bcudjf2XD4U8Ag1AMO', '+8801782796752', NULL, 'Alipur, Hatbari Alipur, Potol-1974, Kalihati, Tangail.', NULL, NULL, 'Md. Azgar Ali Mondol', 'Shaleha Begum', NULL, '1487027425', 'Israt Jahan', '19929314736000063', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-05 18:00:00', '2026-06-05 08:52:19'),
(71, 31, 'Bulbul Howlader Gong', 'bulbulhowlader7567@gmail.com', NULL, '$2y$12$DyDezHl4LyPYPj.ngi0rcOVFVGbtJ3XF84As5dOvzqnE7Oy2wORRa', '01387567', NULL, 'H# 158, Khilpara, Betkahat-1521, Tongipara, Monshigonj', NULL, NULL, 'Khorshed Howlader', 'Rubina Begum', NULL, '2405647567', NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-14 18:00:00', '2026-06-05 08:52:50'),
(72, 32, 'Mst. Tamanna Sadia', 'tamannasadia1254@gmail.com', NULL, '$2y$12$xyr1QABbHXl7Mt2WvfaAm.rRX4qqRpXO9/444YaidePxV1Wd/qbUa', '013451254', NULL, 'Pangasia, Kalkini, Madaripur,', NULL, NULL, 'Md. Shahabuddin Khan', 'Mst. Sultana Akter', NULL, '540002001254', 'Riad Howladear', '19955422501036208', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-24 18:00:00', '2026-06-05 08:53:17'),
(73, 35, 'Sohag Howlader', 'sohaghowlader0027@gmail.com', NULL, '$2y$12$zaKJD/i7U.dSJrOIwr9mc.rLxl1.RN2TKKrNOmCwWk1mvt7unYjsK', '+880 01730027', NULL, 'Pangiashia, Kalkini, Madaripur', NULL, NULL, 'Abdul Kader Howlader', 'Delowara Begum', NULL, '542400160027', NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 18:00:00', '2026-06-05 09:13:38'),
(74, 36, 'Kamrujjaman Patwary', 'kamrujjamanpatwary6957@gmail.com', NULL, '$2y$12$X3NwLI476VCqXC/TjJBxEOFaFv0RsL0xKDfwRGbHlw8SPayUsOBBW', '+880 0136759', NULL, 'Fazlul Karim Patwary Bari, Islampur, Natul Ranir Hut D. T M-3900, fulgazi, Feny.', NULL, NULL, 'Fazlul Karim Patwary', 'Parul Akter', NULL, '8667986957', 'FArhana Naznin', '1032108647', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-28 18:00:00', '2026-06-05 09:14:11'),
(75, 38, 'Asraful Haidur', 'asrafulhaidur5631@gmail.com', NULL, '$2y$12$xlNfPQD3i0dg4MBim2vmGevEy03h/42S.NYRpWfrPy8vcbEHPlDP6', '+880 1735668334', NULL, 'Bashundhara Abasik Alaka, Dhaka', NULL, NULL, 'Delower Hossain', 'Rahima Akter', NULL, '19845116547145631', 'Shiuly Akter', NULL, NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-13 18:00:00', '2026-06-05 09:14:34'),
(76, 39, 'G.M Jobayer Rahman', 'jobayerrahman5552@gmail.com', NULL, '$2y$12$G9MM5ijrKPYkdtEAaJsbyOZd0jdWVPdtxVGJYm4.Y2iN83W5ydxHS', '+880 1611772785', NULL, 'Duruil, Bitghar, Nabinagar, B-Baria.', NULL, NULL, 'Hasan Mia', 'Hasena Begum', NULL, '1926703015552', 'Md Junaide', '6931858077', NULL, 'Son', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-14 18:00:00', '2026-06-05 09:15:00'),
(77, 40, 'Mohammad Mustofa Kamal', 'mkmustofa1977@gmail.com', NULL, '$2y$12$dmqvSkVSSsEOf6YAziznnubYv89/oQyds07xUoyoPJPUb8m9Cks8i', '+8801920490431', '01917092570', '63, Pilkhana Road, Lalbagh, New Market, Dhaka.', NULL, NULL, 'Mohammad Beleyet Hossain', 'Mosammed Sufia Begum', NULL, '8241785412', 'Sahida Sultana', '5991805143', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-14 18:00:00', '2026-06-14 11:28:22'),
(78, 41, 'Farzana Yasmin', 'farzanayasmin2159@gmail.com', NULL, '$2y$12$llWM4BkC2AP6ReahB6v2tepR55CZhxGJqlrKUHDFMgzNrncvFaj7K', '+61404355607', '8801920490431', 'H# 152, Cresent Road, New Market-1205, Dhanmondi, Dhaka.', NULL, NULL, 'Kamal Mohiuddin', 'Taslima Begum', NULL, '1923492159', 'Tahmina Begum', '7773464750', NULL, 'Mother', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-02 18:00:00', '2026-06-05 09:15:43'),
(79, 42, 'Kakaly Aktar Gong', 'kakalyakter8633@gmail.com', NULL, '$2y$12$sj.bUhnoSTXyeIMN2d/lqOBv7nkW35MCO9f9OvOBfPF9oop876z6O', '880 1766378509', NULL, 'Purabo Para, Jumuna, Khagra-3460, Kosba, Brahmanbaria.', NULL, NULL, 'Md. Mahfuzzaman', 'Renuyara Begum', NULL, '2801628633', 'Shamim Parvej', '1216382426722', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 18:00:00', '2026-06-05 09:16:03'),
(80, 43, 'Jusna Akter Gong', 'jusnaakter8167@gmail.com', NULL, '$2y$12$t/tXtuBUbuvSYvjDoBYgkO9rryBYrg76QtRC9TIMWOCBsP5FRFwO.', '+880 1332653684', '+880174826243', 'Kuddus Master Bari, Samserpur, Bitghar-3417, Nobinagor, Brahmanbaria.', NULL, NULL, 'Md. A. Rahim', 'Rfiya', 'Md sadekur Rahman', '5503038167', 'Md sadekur Rahman', '5050017457', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 18:00:00', '2026-06-05 09:16:37'),
(81, 44, 'Md. Nasiruzzaman', 'nasiruzzaman9453@gmail.com', NULL, '$2y$12$wA4gdOjVtNiNMcVam30UXOliF6lRhyHlKavp2D/LBmFI2SXngAOu6', '+880 1713068668', NULL, 'Kalagachia, Bamona, Borguna', NULL, NULL, 'Let Abdul Jalil', 'Mst. Nachima Begum', NULL, '5983379453', 'Sayma Sharmin', '2842045110', NULL, 'Spouse', 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-08 18:00:00', '2026-06-05 09:17:00'),
(82, 45, 'Ashraf Ali', 'ashrafali100297@gmail.com', NULL, '$2y$12$8Bz68wx9gQ5cSy4LMEhoxOmj/XF4Pr/079lO6HehdfEu/skAqCvFu', '8801884156564', NULL, 'H# Natun Bari, Vill# Viktola, P.O: Elihatgonj-3519, Douthkandi, Cumilla.', NULL, NULL, 'A Halim', 'Mst. Fayzun Nesa', NULL, '6001797668', NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-24 18:00:00', '2026-06-09 07:55:07'),
(83, NULL, 'MD. Abdul Latif', 'a.lotif0909@gmail.com', NULL, '$2y$12$qp8P2kSy1XPgLUx4Fr.MZOlxSOrpbh10VLk7UOmk8AMNQ7xDR/s8m', '013123123', NULL, 'Polton', NULL, NULL, NULL, NULL, NULL, '2613834219105', NULL, NULL, NULL, NULL, 'agent', 'ed', NULL, NULL, 'active', NULL, 3.00, 2.00, 2.00, 'AGFB9A7C', NULL, '2026-06-14 10:28:18', '2026-06-15 05:59:48'),
(84, NULL, 'Md. Tufayl Ahmed Yusuf', 'testagn@gmail.com', NULL, '$2y$12$wklDKIXmcI2JQLz0YxRnruWEjTuIJJgBbSiw0HI4N3gY0xyoYwyPW', '0132654', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '19896129401000002', NULL, NULL, NULL, NULL, 'agent', 'agm', 85, NULL, 'active', NULL, 4.00, 3.00, 2.00, 'AGA10AFA', NULL, '2026-06-14 10:50:42', '2026-06-14 10:53:24'),
(85, NULL, 'Test GM', 'testgm@gmail.com', NULL, '$2y$12$sUeDNeJEyngKlVrDyXESAOw.EdVOfkdd6OOJgIxIEwPaaMyK94jvS', '041235648', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'gm', 83, NULL, 'active', NULL, 3.00, 2.00, 2.00, 'AGE6D900', NULL, '2026-06-14 10:52:38', '2026-06-14 10:52:38'),
(86, NULL, 'Test Manager', 'testmanager@gmail.com', NULL, '$2y$12$FbjbtRK6nnpWu2naqFwWJ.runD/mmWIzj17ij2qWgXAVfLg5U4x7e', '0145963258', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'manager', 84, NULL, 'active', NULL, 5.00, 4.00, 3.00, 'AGC94F44', NULL, '2026-06-14 10:55:50', '2026-06-14 10:55:50'),
(87, NULL, 'Test Ast Manager', 'testastmanager@gmail.com', NULL, '$2y$12$3dWn1tSEXLL/6j94ssea9uNHgUl9rFxXgLGApvkvi8qHNNhxpfAtq', '0135897856', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'ast_manager', 86, NULL, 'active', NULL, 35.00, 9.00, 6.00, 'AGAB9094', NULL, '2026-06-14 10:57:54', '2026-06-14 10:57:54'),
(88, NULL, 'Abdur Rashed', 'abdurrashed@gmail.com', NULL, '$2y$12$ETwCSsyLTUyag.NVQ3POZerBU0uKRsWyfwmgkszRMz2o5/DUN8blW', '0135489623', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'agm', 85, NULL, 'active', NULL, 4.00, 3.00, 2.00, 'AG1A7E7E', NULL, '2026-06-15 06:02:55', '2026-06-15 06:02:55'),
(89, NULL, 'Mohammad Mustofa Kamal', 'mk99102188@gmail.com', NULL, '$2y$12$vOVJtqMwiFTcr0EJLU3oLekvssP9JFCc7hFYhc1Okv1frECHzlp92', '0192044904', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'manager', 88, NULL, 'active', NULL, 5.00, 4.00, 3.00, 'AG6228D6', NULL, '2026-06-15 06:08:23', '2026-06-15 06:08:23'),
(90, NULL, 'Ashraf Ali', 'ashrafali26@gmail.com', NULL, '$2y$12$llWMQ7b/zSgL4p6nAHTkuuzbANmEKr8ZB88nhJ9l2dQFfXg9aL9my', '0142356789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'manager', 88, NULL, 'active', NULL, 5.00, 4.00, 3.00, 'AG35AA80', NULL, '2026-06-15 06:11:42', '2026-06-15 06:11:42'),
(91, NULL, 'Mojammel Haque', 'mojammelhaque.ed@gmail.com', NULL, '$2y$12$BuAT4nCi/SDovVcpxvpUkOKdn4oaWq9nceq2MOlgbVNsnqoq3LQHq', '0143256', NULL, 'Vill: Shingra, P.O: Bukabunia-8730, Bamuna, Borguna.', NULL, NULL, 'Md. Asharaf Ali', 'Mst. Chanful Ftema', NULL, '4166857013', NULL, NULL, NULL, NULL, 'agent', 'ed', NULL, NULL, 'active', NULL, 3.00, 2.00, 2.00, 'AG036303', NULL, '2026-06-17 10:38:28', '2026-06-17 10:38:28'),
(92, NULL, 'Md. Imran Hossain', 'imranhossain.ed@gmail.com', NULL, '$2y$12$Fia7oXMtPboGfeQRbYYIQeNPvw49uUbhSH5QmyPzNs144mmE6dyae', '013229029', NULL, 'H# 3, Maradia Bazar, Dahka,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'ed', NULL, NULL, 'active', NULL, 3.00, 2.00, 2.00, 'AG129041', NULL, '2026-06-17 10:54:57', '2026-06-17 10:54:57'),
(93, NULL, 'Md. Tokabber Hossain', 'takbarhossain.ed@gmail.com', NULL, '$2y$12$PM9mw3c6T7e2N2DR8dJQG.1g7ZGLa9sKfDT6N55UaLaHA7.kZ9AhS', '0143256', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'ed', NULL, NULL, 'active', NULL, 3.00, 2.00, 2.00, 'AG683FAE', NULL, '2026-06-17 11:47:38', '2026-06-17 11:54:02'),
(94, NULL, 'Md. Kazimul Islam', 'kazimulislam.age@gmail.com', NULL, '$2y$12$OJt0PeawHnv.TAlFnyyjkOltNNv/mOFB5UkC5LUSJCFTED/4NP3Ym', '0143692589', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'manager', 88, NULL, 'active', NULL, 5.00, 4.00, 3.00, 'AG33A2CC', NULL, '2026-06-20 10:13:34', '2026-06-20 10:13:34'),
(95, NULL, 'Abdul Aziz', 'abdulaziz.agent@gmail.com', NULL, '$2y$12$5Q5Ds.ZOQmUIrhgcws66Nu4afr3EzFnrugjMLxond1Qj732FF.0Ey', '017859623', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'ast_manager', 86, NULL, 'active', NULL, 35.00, 9.00, 6.00, 'AG03E24E', NULL, '2026-06-20 10:23:01', '2026-06-20 10:23:01'),
(96, NULL, 'G M Jobayer Rahman', 'jobayerrahman.age@gmail.com', NULL, '$2y$12$cNtbEMRvsQF7wsaO9ZNNt.7nnq8peA5s6ha2FbsL.S9VgDC9.xs8W', '014859623', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'agm', 85, NULL, 'active', NULL, 4.00, 3.00, 2.00, 'AG88F9D5', NULL, '2026-06-20 11:36:02', '2026-06-20 11:43:18'),
(97, NULL, 'Test ED Jalil Sir', 'testedjalilsir@gmail.com', NULL, '$2y$12$z6k37MACS4te7UobSBQkAeyOp3ZFjpeAKMhDbLlSaofssTBonLWDS', '8801322902981', NULL, 'London Park, Polton, Dhaka', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'ed', NULL, NULL, 'active', NULL, 3.00, 2.00, 2.00, 'AG661504', NULL, '2026-06-27 05:30:13', '2026-06-27 05:30:13'),
(98, NULL, 'Test GM Sazzad Sir', 'testgmsazzadsir@gmail.com', NULL, '$2y$12$g8Ca9pDpXInsGbmMHx.W/OcTekWdiZ385sFn/FxwQYwkfo./INCOy', '8801322902988', NULL, 'London Park, Poldon, Dhaka', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'gm', 97, NULL, 'active', NULL, 3.00, 2.00, 2.00, 'AGAF652F', NULL, '2026-06-27 05:33:48', '2026-06-27 05:33:48'),
(99, NULL, 'Test AGM Ripon Sir', 'testagmriponsir@gmail.com', NULL, '$2y$12$MxoUDs3uJcrhoDrEHlbX8uXFT6W4hsuFk23JvJPUvcC94Jz./m6GW', '8801721935452', NULL, 'London Park, Polton, Dhaka', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'agm', 98, NULL, 'active', NULL, 4.00, 3.00, 2.00, 'AGC651B5', NULL, '2026-06-27 05:36:48', '2026-06-27 05:36:48'),
(100, NULL, 'Test Manager Rasel Sir', 'testmanagerraselsir@gmail.com', NULL, '$2y$12$F7ty/MhcrfeLubTM8bDg/.DYHOBh/8jIGelJqLzXhQsWKUAU.sTni', '8801322902980', NULL, 'London Abason, Mariadia, Banasree, Dhaka', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'manager', 99, NULL, 'active', NULL, 5.00, 4.00, 3.00, 'AGE2780E', NULL, '2026-06-27 05:40:22', '2026-06-27 05:40:22'),
(101, NULL, 'Test Ast Manager Morshed', 'testastmorshed@gmail.com', NULL, '$2y$12$Jqaa6mHZAqlHvZNeXdvI4eo/jAQh/MmuQ5tVLnjwxyN/jU0qRjJjq', '8801322902986', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'agent', 'ast_manager', 100, NULL, 'active', NULL, 35.00, 9.00, 6.00, 'AGD96B66', NULL, '2026-06-27 05:43:21', '2026-06-27 05:43:21'),
(104, 101, 'Test Hridoy Khan', 'testridoykhan@gmail.com', NULL, '$2y$12$.dJsZj33qWW4Jj2/13twCu/ZxmIHMTMyUL2T3SNBn0/708rDSBpcu', '8801303946194', NULL, 'Jatrabari, Dhaka.', NULL, NULL, 'ABC', 'EFG', NULL, '8569514563', NULL, NULL, NULL, NULL, 'user', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 18:00:00', '2026-06-27 07:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `website_settings`
--

CREATE TABLE `website_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_group` varchar(50) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `website_settings`
--

INSERT INTO `website_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `created_at`, `updated_at`) VALUES
(1, 'phone_primary', '+880 1322-902986', 'contact', '2026-04-09 04:55:32', '2026-04-09 05:26:17'),
(2, 'phone_secondary', NULL, 'contact', '2026-04-09 04:55:32', '2026-04-09 04:55:32'),
(3, 'whatsapp_number', NULL, 'contact', '2026-04-09 04:55:32', '2026-04-09 04:55:32'),
(4, 'contact_email', 'info@londonabd.com', 'contact', '2026-04-09 04:55:32', '2026-04-09 05:26:17'),
(5, 'support_email_contact', NULL, 'contact', '2026-04-09 04:55:32', '2026-04-09 04:55:32'),
(6, 'office_address', 'House# 3, Road# Main Road, Block# H, Maradia Bazar, Banasree, Rampura, Dhaka-1219', 'contact', '2026-04-09 04:55:32', '2026-04-09 05:29:33'),
(7, 'office_hours', 'Saturday-Thursday: 9 Am-6 Pm', 'contact', '2026-04-09 04:55:32', '2026-04-09 05:26:39'),
(8, 'google_map_embed', NULL, 'contact', '2026-04-09 04:55:32', '2026-04-09 04:55:32'),
(9, 'google_maps_url', NULL, 'contact', '2026-04-09 04:55:32', '2026-04-09 04:55:32'),
(10, 'facebook_url', NULL, 'contact', '2026-04-09 04:55:32', '2026-04-09 04:55:32'),
(11, 'twitter_url', NULL, 'contact', '2026-04-09 04:55:32', '2026-04-09 04:55:32'),
(12, 'instagram_url', NULL, 'contact', '2026-04-09 04:55:32', '2026-04-09 04:55:32'),
(13, 'youtube_url', NULL, 'contact', '2026-04-09 04:55:32', '2026-04-09 04:55:32'),
(14, 'linkedin_url', NULL, 'contact', '2026-04-09 04:55:32', '2026-04-09 04:55:32'),
(15, 'support_email', NULL, 'platform', '2026-04-09 04:56:19', '2026-04-09 04:56:19'),
(16, 'admin_email', NULL, 'platform', '2026-04-09 04:56:19', '2026-04-09 04:56:19'),
(17, 'booking_notification_email', NULL, 'platform', '2026-04-09 04:56:19', '2026-04-09 04:56:19'),
(18, 'mail_from_name', 'London Abason', 'email', '2026-04-18 04:14:33', '2026-04-18 04:14:33'),
(19, 'mail_from_email', 'info@londonabd.com', 'email', '2026-04-18 04:14:33', '2026-04-18 04:14:33'),
(20, 'smtp_host', NULL, 'email', '2026-04-18 04:14:33', '2026-04-18 04:14:33'),
(21, 'smtp_port', '587', 'email', '2026-04-18 04:14:33', '2026-04-18 04:14:33'),
(22, 'smtp_username', 'admin@londonabd.com', 'email', '2026-04-18 04:14:33', '2026-04-18 04:14:33'),
(23, 'smtp_password', '@Admin#2026', 'email', '2026-04-18 04:14:33', '2026-04-18 04:14:33'),
(24, 'smtp_encryption', NULL, 'email', '2026-04-18 04:14:33', '2026-04-18 04:14:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_plot_id_foreign` (`plot_id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_referral_agent_id_foreign` (`referral_agent_id`),
  ADD KEY `bookings_commission_scheme_index` (`commission_scheme`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `commission_earnings`
--
ALTER TABLE `commission_earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commission_earnings_user_id_pool_type_index` (`user_id`,`pool_type`),
  ADD KEY `commission_earnings_payment_id_foreign` (`payment_id`),
  ADD KEY `commission_earnings_booking_id_foreign` (`booking_id`),
  ADD KEY `commission_earnings_seller_id_foreign` (`seller_id`);

--
-- Indexes for table `commission_payouts`
--
ALTER TABLE `commission_payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_payments_agent_id_foreign` (`user_id`),
  ADD KEY `agent_payments_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `phone_verifications`
--
ALTER TABLE `phone_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phone_verifications_phone_type_index` (`phone`,`type`);

--
-- Indexes for table `plots`
--
ALTER TABLE `plots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plots_plot_no_unique` (`plot_no`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_referral_code_unique` (`referral_code`),
  ADD UNIQUE KEY `client_id` (`client_id`),
  ADD KEY `users_commission_type_index` (`commission_type`),
  ADD KEY `users_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `website_settings`
--
ALTER TABLE `website_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `website_settings_setting_key_unique` (`setting_key`),
  ADD KEY `website_settings_setting_group_index` (`setting_group`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `commission_earnings`
--
ALTER TABLE `commission_earnings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `commission_payouts`
--
ALTER TABLE `commission_payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `phone_verifications`
--
ALTER TABLE `phone_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plots`
--
ALTER TABLE `plots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `website_settings`
--
ALTER TABLE `website_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_plot_id_foreign` FOREIGN KEY (`plot_id`) REFERENCES `plots` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_referral_agent_id_foreign` FOREIGN KEY (`referral_agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `commission_earnings`
--
ALTER TABLE `commission_earnings`
  ADD CONSTRAINT `commission_earnings_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commission_earnings_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commission_earnings_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commission_earnings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `commission_payouts`
--
ALTER TABLE `commission_payouts`
  ADD CONSTRAINT `commission_payouts_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commission_payouts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
