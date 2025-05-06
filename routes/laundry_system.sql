-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 07:59 AM
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
-- Database: `laundry_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `laundress_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `scheduled_date` date NOT NULL,
  `scheduled_time` time NOT NULL,
  `pickup_required` tinyint(1) NOT NULL DEFAULT 0,
  `delivery_required` tinyint(1) NOT NULL DEFAULT 0,
  `pickup_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `selected_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`selected_items`)),
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(191) NOT NULL DEFAULT 'pending',
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `processing_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `washing_started_at` timestamp NULL DEFAULT NULL,
  `drying_started_at` timestamp NULL DEFAULT NULL,
  `ironing_started_at` timestamp NULL DEFAULT NULL,
  `packaging_started_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `customer_id`, `laundress_id`, `service_id`, `scheduled_date`, `scheduled_time`, `pickup_required`, `delivery_required`, `pickup_fee`, `delivery_fee`, `total_amount`, `selected_items`, `status`, `payment_status`, `transaction_id`, `notes`, `created_at`, `updated_at`, `confirmed_at`, `processing_at`, `completed_at`, `cancelled_at`, `washing_started_at`, `drying_started_at`, `ironing_started_at`, `packaging_started_at`) VALUES
(2, NULL, 6, 10, 1, '2025-05-05', '08:00:00', 1, 1, 0.00, 0.00, 11500.00, '[{\"serviceId\":\"1\",\"itemName\":\"Trousers\",\"price\":2500},{\"serviceId\":\"1\",\"itemName\":\"Shirt\",\"price\":2000}]', 'confirmed', 'paid', 2, NULL, '2025-04-30 19:34:51', '2025-05-01 04:37:37', '2025-05-01 04:37:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, 6, 10, 1, '2025-05-07', '08:00:00', 1, 0, 0.00, 0.00, 11000.00, '[{\"serviceId\":\"1\",\"itemName\":\"Bed Sheets\",\"price\":4000}]', 'cancelled', 'pending', NULL, NULL, '2025-05-01 05:07:51', '2025-05-01 05:08:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, 6, 10, 1, '2025-05-06', '08:00:00', 0, 0, 0.00, 0.00, 13500.00, '[{\"serviceId\":\"1\",\"itemName\":\"Trousers\",\"price\":2500},{\"serviceId\":\"1\",\"itemName\":\"Bed Sheets\",\"price\":4000}]', 'confirmed', 'pending', NULL, NULL, '2025-05-01 05:20:39', '2025-05-04 11:56:38', '2025-05-04 11:56:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, NULL, 6, 10, 1, '2025-05-05', '08:00:00', 1, 1, 3500.00, 3500.00, 13500.00, '[{\"serviceId\":\"1\",\"itemName\":\"Trousers\",\"price\":2500},{\"serviceId\":\"1\",\"itemName\":\"Bed Sheets\",\"price\":4000}]', 'completed', 'paid', NULL, NULL, '2025-05-01 06:12:02', '2025-05-01 18:35:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, NULL, 6, 10, 1, '2025-05-08', '08:00:00', 1, 1, 3500.00, 3500.00, 11000.00, '[{\"serviceId\":\"1\",\"itemName\":\"T-Shirt\",\"price\":1500},{\"serviceId\":\"1\",\"itemName\":\"Trousers\",\"price\":2500}]', 'confirmed', 'paid', NULL, NULL, '2025-05-03 09:15:03', '2025-05-03 09:17:59', '2025-05-03 09:17:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, NULL, 6, 10, 1, '2025-05-07', '08:00:00', 0, 1, 0.00, 3500.00, 39500.00, '[{\"serviceId\":\"1\",\"itemName\":\"T-Shirt\",\"price\":1500},{\"serviceId\":\"1\",\"itemName\":\"Trousers\",\"price\":2500},{\"serviceId\":\"6\",\"itemName\":\"Carpet\",\"price\":20000},{\"serviceId\":\"6\",\"itemName\":\"Sofa Cover\",\"price\":12000}]', 'completed', 'paid', NULL, NULL, '2025-05-04 11:21:48', '2025-05-04 11:55:26', '2025-05-04 11:53:55', NULL, '2025-05-04 11:55:26', NULL, NULL, NULL, NULL, NULL),
(12, NULL, 6, 10, 1, '2025-05-07', '08:00:00', 0, 0, 0.00, 0.00, 5500.00, '[{\"serviceId\":\"1\",\"itemName\":\"T-Shirt\",\"price\":1500},{\"serviceId\":\"1\",\"itemName\":\"Bed Sheets\",\"price\":4000}]', 'packaging', 'paid', NULL, NULL, '2025-05-04 11:22:37', '2025-05-05 10:58:55', '2025-05-05 10:57:56', NULL, NULL, NULL, '2025-05-05 10:58:20', '2025-05-05 10:58:37', '2025-05-05 10:58:45', '2025-05-05 10:58:55'),
(13, NULL, 6, 10, 1, '2025-05-06', '08:00:00', 1, 1, 3500.00, 3500.00, 11500.00, '[{\"serviceId\":\"1\",\"itemName\":\"Shirt\",\"price\":2000},{\"serviceId\":\"1\",\"itemName\":\"Trousers\",\"price\":2500}]', 'pending', 'paid', NULL, NULL, '2025-05-05 19:01:22', '2025-05-05 19:01:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, 6, 10, 1, '2025-05-06', '08:00:00', 1, 0, 3500.00, 0.00, 10000.00, '[{\"serviceId\":\"1\",\"itemName\":\"Trousers\",\"price\":2500},{\"serviceId\":\"1\",\"itemName\":\"Bed Sheets\",\"price\":4000}]', 'pending', 'paid', NULL, NULL, '2025-05-06 02:41:20', '2025-05-06 02:41:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone_number` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `name`, `phone_number`, `address`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 5, 'Mariam Mushi', '012346789', 'Dar es salaam', 'avatars/RJyr8MaDVH1muZZwZGymwloUR00utVb8ImtPOtm5.jpg', '2025-04-26 17:33:35', '2025-04-26 17:33:35'),
(2, 6, 'Ndyamukama Deo', '0987654334', 'Dar es salaam', 'avatars/21E3UuLfSb6qjJi96hRkFWJ41dedI9dSAOmYjInt.jpg', '2025-04-26 17:40:09', '2025-04-26 17:40:09'),
(3, 11, 'Meck', '0673128464', 'Dar es salaam', 'avatars/vA5kMf0PpaMWz1UqSrgdeQyImz3WieTqhNcIIyYW.jpg', '2025-05-03 08:12:08', '2025-05-03 08:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `laundress_details`
--

CREATE TABLE `laundress_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone_number` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `availability_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `current_location` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laundress_details`
--

INSERT INTO `laundress_details` (`id`, `user_id`, `phone_number`, `address`, `avatar`, `availability_status`, `created_at`, `updated_at`, `latitude`, `longitude`, `current_location`) VALUES
(2, 8, '(123) 456-7876', 'Ubungo', NULL, 1, '2025-04-27 18:01:43', '2025-04-27 18:01:43', -6.76393292, 39.20624006, 'Ubungo'),
(3, 9, '123456789', 'ubungo', NULL, 1, '2025-04-27 18:31:00', '2025-04-27 18:31:00', -6.79120970, 39.20029163, 'ubungo'),
(4, 10, '0987322112', 'Sinza', NULL, 1, '2025-04-28 22:15:19', '2025-04-28 22:15:19', -6.77900057, 39.22444559, 'Sinza');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_04_25_151653_add_role_and_avatar_to_users_table', 1),
(2, '2024_04_26_add_theme_settings_to_users_table', 2),
(3, '2025_04_25_220042_create_customers_table', 3),
(4, '2025_04_25_221822_create_laundress_details_table', 4),
(5, '2025_04_25_222441_create_service_categories_table', 5),
(6, '2025_04_26_192451_update_laundress_details_table', 6),
(7, '2024_04_28_create_orders_table', 7),
(8, '2025_04_28_061623_create_notifications_table', 8),
(9, '2025_04_28_080204_add_payment_fields_to_orders_table', 9),
(10, '2025_04_28_000001_create_payment_transactions_table', 10),
(11, '2024_04_30_000000_create_services_table', 11),
(12, '2024_05_01_000000_create_schedules_table', 12),
(13, '2025_04_30_173929_create_bookings_table', 13),
(14, '2024_05_01_create_wallets_table', 14),
(15, '2025_04_30_211843_create_transactions_table', 15),
(16, '2025_04_30_215755_add_laundress_id_to_bookings_table', 16),
(17, '2025_04_30_220250_add_pickup_delivery_to_bookings_table', 17),
(18, '2025_04_30_220715_add_amount_fields_to_bookings_table', 18),
(19, '2025_04_30_222426_add_user_id_to_bookings_table', 19),
(20, '2025_04_30_223300_add_transaction_id_to_bookings_table', 20),
(21, '2025_05_01_071059_add_status_timestamps_to_bookings_table', 21),
(22, '2025_05_01_090800_add_phone_number_to_transactions_table', 22),
(23, '2025_05_01_215344_create_settings_table', 23),
(24, '2025_05_05_134514_add_process_timestamps_to_bookings_table', 24),
(25, '2025_05_05_180743_create_reviews_table', 25),
(26, '2025_05_05_205403_create_review_likes_table', 26),
(27, '2025_05_05_205517_create_review_replies_table', 27);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0153469c-b49b-4392-823c-46b153997c04', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":2,\"status\":\"confirmed\",\"message\":\"Order #2 has been confirmed\"}', NULL, '2025-05-01 04:37:39', '2025-05-01 04:37:39'),
('0b1b3227-63a3-445f-a5af-50d45144fc92', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":4,\"status\":\"confirmed\",\"message\":\"Order #4 has been confirmed\"}', NULL, '2025-05-04 11:56:40', '2025-05-04 11:56:40'),
('0f203d31-6e1d-40d5-a586-fb984e5a32f4', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"packaging\",\"message\":\"Order #12 has been packaging\"}', NULL, '2025-05-05 10:58:55', '2025-05-05 10:58:55'),
('167a2c17-2192-418b-bc94-478896696ac4', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"washing\",\"message\":\"Order #12 has been washing\"}', NULL, '2025-05-05 10:58:22', '2025-05-05 10:58:22'),
('4ec1e9ab-978c-472c-a559-2cd87bfd2b8a', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":11,\"status\":\"completed\",\"message\":\"Order #11 has been completed\"}', NULL, '2025-05-04 11:55:26', '2025-05-04 11:55:26'),
('55172ff8-f45a-4e91-b13d-91fea3bb9577', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":11,\"status\":\"confirmed\",\"message\":\"Order #11 has been confirmed\"}', NULL, '2025-05-04 11:53:55', '2025-05-04 11:53:55'),
('59a60c3e-ba20-4581-a115-0567a1896285', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"confirmed\",\"message\":\"Order #12 has been confirmed\"}', NULL, '2025-05-05 10:58:02', '2025-05-05 10:58:02'),
('5f917f6b-b09f-440f-b68e-a82b60a27ccf', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"confirmed\",\"message\":\"Order #12 has been confirmed\"}', NULL, '2025-05-04 11:52:43', '2025-05-04 11:52:43'),
('63cd7a48-ec1a-4293-94d1-d42ceef83f3f', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"washing\",\"message\":\"Order #12 has been washing\"}', NULL, '2025-05-05 10:58:21', '2025-05-05 10:58:21'),
('71875c51-72c7-4acc-a4f7-8a2a7e1f466f', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":2,\"status\":\"confirmed\",\"message\":\"Order #2 has been confirmed\"}', NULL, '2025-05-01 04:37:37', '2025-05-01 04:37:37'),
('7ca28bfc-cd7e-4715-96af-f0d08a820fa6', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":2,\"status\":\"confirmed\",\"message\":\"Order #2 has been confirmed\"}', NULL, '2025-05-01 04:35:13', '2025-05-01 04:35:13'),
('7cc593bf-3cf7-472f-b184-9e3a15029d80', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"drying\",\"message\":\"Order #12 has been drying\"}', NULL, '2025-05-05 10:58:37', '2025-05-05 10:58:37'),
('852c118a-35d1-4477-b75e-091ac86369cd', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":10,\"status\":\"confirmed\",\"message\":\"Order #10 has been confirmed\"}', NULL, '2025-05-03 09:18:30', '2025-05-03 09:18:30'),
('8a6a2681-c095-4f1c-ba58-b02aab27d656', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"confirmed\",\"message\":\"Order #12 has been confirmed\"}', NULL, '2025-05-05 10:57:59', '2025-05-05 10:57:59'),
('8df52389-5de4-45f2-a5f1-d51f48943d67', 'App\\Notifications\\CustomerPasswordChangeNotification', 'App\\Models\\User', 2, '{\"title\":\"Password Change Alert\",\"message\":\"Customer Ndyamukama Deo has changed their password\",\"customer_id\":6,\"type\":\"password_change\",\"time\":\"2025-04-28 06:29:45\",\"icon\":\"bx bx-lock-alt\",\"color\":\"warning\"}', NULL, '2025-04-28 03:29:45', '2025-04-28 03:29:45'),
('9212c220-eb86-47f3-bdba-64022805ec01', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"drying\",\"message\":\"Order #12 has been drying\"}', NULL, '2025-05-05 10:58:39', '2025-05-05 10:58:39'),
('aa42b764-0124-4d6f-9b93-1481468b30da', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"ironing\",\"message\":\"Order #12 has been ironing\"}', NULL, '2025-05-05 10:58:46', '2025-05-05 10:58:46'),
('ae8b87f7-8faf-4de8-8d85-2b6c7c999b57', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":11,\"status\":\"completed\",\"message\":\"Order #11 has been completed\"}', NULL, '2025-05-04 11:55:28', '2025-05-04 11:55:28'),
('b7e824b7-4c36-464f-b5bb-e046556e71cc', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"packaging\",\"message\":\"Order #12 has been packaging\"}', NULL, '2025-05-05 10:58:56', '2025-05-05 10:58:56'),
('bd84ca8d-03e3-4912-b2d4-1d2a4d548690', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"confirmed\",\"message\":\"Order #12 has been confirmed\"}', NULL, '2025-05-04 11:52:48', '2025-05-04 11:52:48'),
('c5e7fe46-0c2b-4010-9b4e-70e3b5812e2e', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":4,\"status\":\"confirmed\",\"message\":\"Order #4 has been confirmed\"}', NULL, '2025-05-04 11:56:39', '2025-05-04 11:56:39'),
('d02b50ec-5e15-47f6-aaf0-58bd2867babc', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":12,\"status\":\"ironing\",\"message\":\"Order #12 has been ironing\"}', NULL, '2025-05-05 10:58:47', '2025-05-05 10:58:47'),
('dd8b0bc7-de92-41c0-b8e6-7194beaf6c42', 'App\\Notifications\\CustomerPasswordChangeNotification', 'App\\Models\\User', 1, '{\"title\":\"Password Change Alert\",\"message\":\"Customer Ndyamukama Deo has changed their password\",\"customer_id\":6,\"type\":\"password_change\",\"time\":\"2025-04-28 06:29:45\",\"icon\":\"bx bx-lock-alt\",\"color\":\"warning\"}', '2025-04-28 03:31:43', '2025-04-28 03:29:45', '2025-04-28 03:31:43'),
('e8408dc7-385f-4542-bf33-728b60348306', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":11,\"status\":\"confirmed\",\"message\":\"Order #11 has been confirmed\"}', NULL, '2025-05-04 11:53:57', '2025-05-04 11:53:57'),
('f47292aa-91d4-4f5c-8c26-790f24630b49', 'App\\Notifications\\OrderStatusChanged', 'App\\Models\\User', 6, '{\"order_id\":10,\"status\":\"confirmed\",\"message\":\"Order #10 has been confirmed\"}', NULL, '2025-05-03 09:18:23', '2025-05-03 09:18:23');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(191) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `laundress_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(191) NOT NULL,
  `payment_status` varchar(191) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(191) NOT NULL,
  `control_number` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL,
  `transaction_reference` varchar(191) NOT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `laundress_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` int(11) NOT NULL COMMENT 'Rating from 1-5',
  `comment` text DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `customer_id`, `laundress_id`, `booking_id`, `rating`, `comment`, `is_published`, `created_at`, `updated_at`) VALUES
(5, 6, 9, NULL, 3, 'Please enter a review with at least 10 characters.', 1, '2025-05-05 18:24:59', '2025-05-05 18:24:59'),
(6, 6, 9, NULL, 3, 'Hi, This is so nice', 1, '2025-05-05 18:30:22', '2025-05-05 18:30:22'),
(8, 6, 9, NULL, 4, 'ddsd ssdsfvsfvs svsdvsvsf', 1, '2025-05-05 18:39:55', '2025-05-05 18:39:55');

-- --------------------------------------------------------

--
-- Table structure for table `review_likes`
--

CREATE TABLE `review_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_replies`
--

CREATE TABLE `review_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'System Administrator', NULL, NULL),
(2, 'customer', 'Regular Customer', NULL, NULL),
(3, 'laundress', 'Laundry Service Provider', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `working_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`working_days`)),
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `user_id`, `working_days`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 10, '{\"monday\":{\"is_available\":\"0\",\"start_time\":\"08:00\",\"end_time\":\"17:00\"},\"tuesday\":{\"is_available\":\"1\",\"start_time\":\"08:00\",\"end_time\":\"17:00\"},\"wednesday\":{\"is_available\":\"0\",\"start_time\":\"08:00\",\"end_time\":\"17:00\"},\"thursday\":{\"is_available\":\"1\",\"start_time\":\"08:00\",\"end_time\":\"17:00\"},\"friday\":{\"is_available\":\"0\",\"start_time\":\"08:00\",\"end_time\":\"17:00\"},\"saturday\":{\"is_available\":\"0\",\"start_time\":\"08:00\",\"end_time\":\"17:00\"},\"sunday\":{\"is_available\":\"0\",\"start_time\":\"08:00\",\"end_time\":\"17:00\"}}', 1, '2025-04-30 14:36:31', '2025-05-04 12:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(191) NOT NULL,
  `category_icon` varchar(191) DEFAULT NULL,
  `category_is_active` tinyint(1) NOT NULL DEFAULT 1,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `price_structure` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`price_structure`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `user_id`, `category_name`, `category_icon`, `category_is_active`, `name`, `description`, `price_structure`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 10, 'Washing', 'las la-tshirt', 1, 'Washing', 'Charges will be based on your number of selected items.', '[{\"item\":\"Suit\",\"price\":\"5000\"},{\"item\":\"Shirt\",\"price\":\"2000\"},{\"item\":\"T-Shirt\",\"price\":\"1500\"},{\"item\":\"Trousers\",\"price\":\"2500\"},{\"item\":\"Jeans\",\"price\":\"3000\"},{\"item\":\"Bed Sheets\",\"price\":\"4000\"},{\"item\":\"Towels\",\"price\":\"1500\"},{\"item\":\"Curtains\",\"price\":\"6000\"},{\"item\":\"Pillow Cases\",\"price\":\"1000\"},{\"item\":\"Blankets\",\"price\":\"5000\"}]', 1, '2025-04-30 13:16:22', '2025-04-30 13:16:22'),
(6, 10, 'Dry Cleaning', 'las la-spray-can', 1, 'Drying', 'My change', '[{\"item\":\"Wedding Dress\",\"price\":\"15000\"},{\"item\":\"Blazer\",\"price\":\"8000\"},{\"item\":\"Suit\",\"price\":\"10000\"},{\"item\":\"Curtains\",\"price\":\"10000\"},{\"item\":\"Carpet\",\"price\":\"20000\"},{\"item\":\"Sofa Cover\",\"price\":\"12000\"},{\"item\":\"Leather Jacket\",\"price\":\"15000\"},{\"item\":\"Gown\",\"price\":\"12000\"},{\"item\":\"Heavy Coat\",\"price\":\"10000\"},{\"item\":\"Blanket\",\"price\":\"8000\"}]', 1, '2025-04-30 13:53:02', '2025-04-30 13:53:02'),
(7, 10, 'Ironing', 'las la-iron', 0, 'Ironing', 'Changes', '[{\"item\":\"Shirt\",\"price\":\"1000\"},{\"item\":\"Dress\",\"price\":\"2000\"},{\"item\":\"Suit\",\"price\":\"3000\"},{\"item\":\"Skirt\",\"price\":\"1500\"},{\"item\":\"Jeans\",\"price\":\"1500\"},{\"item\":\"Bedsheet\",\"price\":\"2500\"},{\"item\":\"Pillow Case\",\"price\":\"500\"},{\"item\":\"Uniform\",\"price\":\"1500\"},{\"item\":\"Jacket\",\"price\":\"2000\"}]', 0, '2025-04-30 13:54:54', '2025-04-30 14:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(191) NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL,
  `provider` varchar(191) NOT NULL,
  `phone_number` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `reference`, `wallet_id`, `booking_id`, `amount`, `type`, `status`, `provider`, `phone_number`, `description`, `created_at`, `updated_at`) VALUES
(2, 'TXN-6812A58B12502', 1, 2, 11500.00, 'payment', 'completed', 'vodacom', NULL, 'Payment for booking #2', '2025-04-30 19:34:51', '2025-04-30 19:34:51'),
(3, 'TXN-68132BD71186C', 1, 3, 11000.00, 'payment', 'completed', 'vodacom', NULL, 'Payment for booking #3', '2025-05-01 05:07:51', '2025-05-01 05:07:51'),
(4, 'TXN-68132ED790DAD', 1, 4, 13500.00, 'payment', 'completed', 'vodacom', NULL, 'Payment for booking #4', '2025-05-01 05:20:39', '2025-05-01 05:20:39'),
(5, 'TXN-68133AE296D0E', 1, 8, 13500.00, 'payment', 'completed', 'vodacom', '255754318464', 'Payment for booking #8', '2025-05-01 06:12:02', '2025-05-01 06:12:02'),
(6, 'TXN-681608C748157', 1, 10, 11000.00, 'payment', 'completed', 'vodacom', '255754318464', 'Payment for booking #10', '2025-05-03 09:15:03', '2025-05-03 09:15:03'),
(7, 'TXN-681777FD0C6F5', 1, 11, 39500.00, 'payment', 'completed', 'vodacom', '255754318465', 'Payment for booking #11', '2025-05-04 11:21:49', '2025-05-04 11:21:49'),
(8, 'TXN-6817782D9A62B', 1, 12, 5500.00, 'payment', 'completed', 'vodacom', '255762767692', 'Payment for booking #12', '2025-05-04 11:22:37', '2025-05-04 11:22:37'),
(9, 'TXN-6819353274245', 1, 13, 11500.00, 'payment', 'completed', 'vodacom', '255754318464', 'Payment for booking #13', '2025-05-05 19:01:22', '2025-05-05 19:01:22'),
(10, 'TXN-6819A100593CC', 1, 14, 10000.00, 'payment', 'completed', 'vodacom', '255754318464', 'Payment for booking #14', '2025-05-06 02:41:20', '2025-05-06 02:41:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `theme_settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`theme_settings`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `avatar`, `role_id`, `is_active`, `remember_token`, `theme_settings`, `created_at`, `updated_at`) VALUES
(1, 'Doreen', 'doreen@admin.com', NULL, '$2y$10$IQP2ilHlGFrtK9SajjxejO/g2qrzXJnIlAsuoxXK8oyFt5um9ijry', NULL, 1, 1, NULL, '{\"theme\":\"dark\",\"layoutStyle\":\"default\",\"sidebar\":\"gradient\",\"sidebarSize\":\"lg\",\"sidebarImage\":\"img-3\"}', '2025-04-25 12:29:26', '2025-04-28 12:10:52'),
(2, 'Belinda', 'belinda@admin.com', NULL, '$2y$10$8cMwuTG5/Aw9enuijWBVv.Ltct9VShoQ3uQ39J9XaKl6xuU.D0t.i', NULL, 1, 1, NULL, NULL, '2025-04-25 12:29:26', '2025-04-25 12:29:26'),
(3, 'Poka', 'poka@customer.com', NULL, '$2y$10$DNZfCEv0dzlROxVsPsze2.F.mUSXNj5G0GPIXnFCPnbepx6yFSrmu', NULL, 2, 1, NULL, NULL, '2025-04-25 12:29:26', '2025-04-25 12:29:26'),
(5, 'Mariam Mushi', 'maria@gmail.com', NULL, '$2y$10$IQP2ilHlGFrtK9SajjxejO/g2qrzXJnIlAsuoxXK8oyFt5um9ijry', 'avatars/RJyr8MaDVH1muZZwZGymwloUR00utVb8ImtPOtm5.jpg', 2, 1, NULL, NULL, '2025-04-26 17:33:34', '2025-04-26 17:33:35'),
(6, 'Ndyamukama Deo', 'ndyamukama@gmail.com', NULL, '$2y$10$lA0n3v4oySlfcFqBVKGFR.xYMJhlRseEfhMI3ebbvr9r7DRoQnBVm', 'avatars/avatar_6_1746018325.jpg', 2, 1, NULL, '{\"theme\":\"dark\",\"layoutStyle\":\"default\",\"sidebar\":\"gradient-3\",\"sidebarSize\":\"lg\",\"sidebarImage\":\"img-3\"}', '2025-04-26 17:40:09', '2025-05-05 15:02:25'),
(8, 'Keko Laundry', 'keko@gmail.com', NULL, '$2y$10$IQP2ilHlGFrtK9SajjxejO/g2qrzXJnIlAsuoxXK8oyFt5um9ijry', 'avatars/RwHmKXblhZtE6LFznyG0b6nrkA9ql5QAqGz73GdK.jpg', 3, 1, NULL, NULL, '2025-04-27 18:01:43', '2025-04-27 18:01:43'),
(9, 'Mage Laundry', 'mage@gmail.com', NULL, '$2y$10$IQP2ilHlGFrtK9SajjxejO/g2qrzXJnIlAsuoxXK8oyFt5um9ijry', 'avatars/Face6gqvBuatSD1OfWfzN1Eo69xRao7O0859yCw4.jpg', 3, 1, NULL, NULL, '2025-04-27 18:31:00', '2025-04-27 18:31:00'),
(10, 'Walkers Laundry', 'walker@gmail.com', NULL, '$2y$10$IQP2ilHlGFrtK9SajjxejO/g2qrzXJnIlAsuoxXK8oyFt5um9ijry', 'avatars/KElbtyWr5AaOSTKW5Fn62mQLczkzUO9jQo97h6tw.jpg', 3, 1, NULL, '{\"theme\":\"light\",\"layoutStyle\":\"default\",\"sidebar\":\"gradient-4\",\"sidebarSize\":\"lg\",\"sidebarImage\":\"img-2\"}', '2025-04-28 22:15:19', '2025-05-06 02:47:44'),
(11, 'Meck', 'mecky@gmail.com', NULL, '$2y$10$LQQieVvHh13.LYDu2mtz.uUmFMx29RHARTo5CklhlubfHmFAWOyhG', 'avatars/avatar_11_1746270854.jpg', 2, 1, NULL, '{\"theme\":\"light\",\"layoutStyle\":\"default\",\"sidebar\":\"gradient-4\",\"sidebarSize\":\"lg\",\"sidebarImage\":\"img-3\"}', '2025-05-03 08:12:07', '2025-05-03 09:03:49');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone_number` varchar(191) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `provider` varchar(191) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `phone_number`, `balance`, `provider`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 6, '255754318464', 1964000.00, 'vodacom', 1, '2025-04-30 18:45:18', '2025-05-01 05:20:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_customer_id_foreign` (`customer_id`),
  ADD KEY `bookings_service_id_foreign` (`service_id`),
  ADD KEY `bookings_scheduled_date_scheduled_time_index` (`scheduled_date`,`scheduled_time`),
  ADD KEY `bookings_laundress_id_foreign` (`laundress_id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

--
-- Indexes for table `laundress_details`
--
ALTER TABLE `laundress_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laundress_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_laundress_id_foreign` (`laundress_id`);

--
-- Indexes for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_transactions_transaction_reference_unique` (`transaction_reference`),
  ADD KEY `payment_transactions_order_id_foreign` (`order_id`),
  ADD KEY `payment_transactions_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_customer_id_foreign` (`customer_id`),
  ADD KEY `reviews_laundress_id_foreign` (`laundress_id`),
  ADD KEY `reviews_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `review_likes`
--
ALTER TABLE `review_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `review_likes_review_id_user_id_unique` (`review_id`,`user_id`),
  ADD KEY `review_likes_user_id_foreign` (`user_id`);

--
-- Indexes for table `review_replies`
--
ALTER TABLE `review_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_replies_review_id_foreign` (`review_id`),
  ADD KEY `review_replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_user_id_foreign` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_user_id_foreign` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_reference_unique` (`reference`),
  ADD KEY `transactions_wallet_id_foreign` (`wallet_id`),
  ADD KEY `transactions_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wallets_phone_number_unique` (`phone_number`),
  ADD KEY `wallets_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `laundress_details`
--
ALTER TABLE `laundress_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `review_likes`
--
ALTER TABLE `review_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `review_replies`
--
ALTER TABLE `review_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_laundress_id_foreign` FOREIGN KEY (`laundress_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laundress_details`
--
ALTER TABLE `laundress_details`
  ADD CONSTRAINT `laundress_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_laundress_id_foreign` FOREIGN KEY (`laundress_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD CONSTRAINT `payment_transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_laundress_id_foreign` FOREIGN KEY (`laundress_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_likes`
--
ALTER TABLE `review_likes`
  ADD CONSTRAINT `review_likes_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_replies`
--
ALTER TABLE `review_replies`
  ADD CONSTRAINT `review_replies_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`);

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
