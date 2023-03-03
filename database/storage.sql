-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 03, 2023 lúc 09:50 AM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `storage`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `file_systems`
--

CREATE TABLE `file_systems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(5, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(6, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(7, '2016_06_01_000004_create_oauth_clients_table', 1),
(8, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(9, '2018_08_08_100000_create_telescope_entries_table', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1),
(11, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(12, '2022_09_29_045912_create_file_systems_table', 1),
(13, '2022_09_29_050110_create_user_files_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('05dc0cff1a063380338188ce04ab0dda1c7b21a93f9817d2da0691d660ae341fab39ad68a176e681', NULL, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 09:59:34', '2023-03-02 09:59:34', '2023-04-02 16:59:34'),
('0a49ebd2e8e8ee83166a75e3c87eba9456e030d6efda97290c6acac4318a3f80c04abd981a6814fc', 1, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 12:54:17', '2023-03-02 12:54:17', '2023-04-02 19:54:17'),
('10987c9aae563cfa0253cc373c4eeb351242034fafd7085ae5fb131e0afa4b246433fd45dae4e0be', NULL, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 0, '2023-03-03 01:03:42', '2023-03-03 01:03:42', '2023-04-03 08:03:42'),
('1400052c176ebed75fbded6d52c575dbf0843293b01c5f018cf34f9c352ac19e3a84ae3de51030f1', NULL, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 09:29:40', '2023-03-02 09:29:40', '2023-04-02 16:29:40'),
('359bf746dbd13273bfc1fc7e63627923f82d25f2d87741847d8a0cbe9035379af3fa9c8e43fbd2ed', 1, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 10:10:51', '2023-03-02 10:10:51', '2023-04-02 17:10:51'),
('72cd9de7bd9570ea81c12fe110e402b3ddc4d06c517366fa6f029367847356bc524f54546775a093', 1, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 09:42:38', '2023-03-02 09:45:13', '2023-04-02 16:42:38'),
('9e33bb7e0f75ba868a87b289d7d1eccb7f88c94b4a613c6afacd92154928df4f110c33fc8cb472d9', 1, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 09:38:38', '2023-03-02 09:38:38', '2023-04-02 16:38:38'),
('a0401ed5b36176101aff66d731efae7e4d0286d71f21dfc4ffb10a0f71b60a2b49ae7a8ea2c5f6f3', 1, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 09:45:18', '2023-03-02 09:45:18', '2023-04-02 16:45:18'),
('a2111a9066ea122131dd158c22871fb2812945bacfebd7c0605f7f1a18754d0eee495a68f3fedd87', NULL, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 10:25:36', '2023-03-02 10:25:36', '2023-04-02 17:25:36'),
('af042e10d05bc1089bf70da96a5b25c8967a5fffdde5010bc70964d94a4ef851304c21bd6949419c', 1, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 09:40:15', '2023-03-02 09:40:15', '2023-04-02 16:40:15'),
('ca2b416ba90d5fcad3519b3da8738601e2840bd0036e1d0cb7f770c21ed05fd68b4ac1d7244eacb8', 1, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 12:54:49', '2023-03-02 12:54:49', '2023-04-02 19:54:49'),
('d32306225b000c31f4907ae440a800f7587ef025208677ec0e4c0838cfe9840e9b64ffecbfb4aed7', 1, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 09:32:34', '2023-03-02 09:42:31', '2023-04-02 16:32:34'),
('dd2a44fe5aac57c2b3f04a9a8251013f88dff24847b02010495ec4864ea3eacc94940439f36dc666', 1, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 09:40:23', '2023-03-02 09:40:23', '2023-04-02 16:40:23'),
('e9f1dc400ea1ada257c09b595b7ea12db4bf8a84acfa151dac4cb5d1af2c607d350513dea26fc7e3', 1, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 0, '2023-03-03 01:24:59', '2023-03-03 01:24:59', '2023-04-03 08:24:59'),
('ecdb89990f996d537ded9ec028a478ea2bb2860f10d94de24a72b699fe0d134b5edd1bef1cf9b316', NULL, '978b4967-7174-4d89-a7ad-bc288a63099b', NULL, '[\"storage\"]', 1, '2023-03-02 12:05:45', '2023-03-02 12:05:45', '2023-04-02 19:05:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
('978b495c-a985-4a28-838c-0d74e6af49f1', NULL, 'Storage Service Personal Access Client', '38Slg3WqGf9VvO0Z8eid64RNUIHA4NMmeMnBgohW', NULL, 'http://localhost', 1, 0, 0, '2022-10-19 15:47:50', '2022-10-19 15:47:50'),
('978b495c-ba27-435f-b05f-e8ed3893803e', NULL, 'Storage Service Password Grant Client', 'kvd8OJE9ekBcIWNK63e360CTSZQEvkoTay7l6iZK', 'users', 'http://localhost', 0, 1, 0, '2022-10-19 15:47:50', '2022-10-19 15:47:50'),
('978b4967-7174-4d89-a7ad-bc288a63099b', 1, 'Storage', 'wtW2i7lb8U5QZSBWdGnO65clXiib7bZAAW8tCyib', 'users', '', 1, 1, 0, '2022-10-19 15:47:57', '2022-10-19 15:47:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `oauth_refresh_tokens`
--

INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `revoked`, `expires_at`) VALUES
('21ecbc0f5e444a1052d60866da74713e0eab61e46a54b6293da577dd230403a87ca8b5be33847b49', 'e9f1dc400ea1ada257c09b595b7ea12db4bf8a84acfa151dac4cb5d1af2c607d350513dea26fc7e3', 0, '2024-03-03 08:24:59'),
('3f11b9547f0c883ac29232f985b2de4a0f6b51862dd92a4936f74f3a0b89fbe8a67b32a6fef72b8d', 'dd2a44fe5aac57c2b3f04a9a8251013f88dff24847b02010495ec4864ea3eacc94940439f36dc666', 0, '2024-03-02 16:40:23'),
('5264c59268214da235a5f8f79b7412b88fcceef3f14e1dff3854563e28cbb3a941d7c8adcb7736be', 'ca2b416ba90d5fcad3519b3da8738601e2840bd0036e1d0cb7f770c21ed05fd68b4ac1d7244eacb8', 0, '2024-03-02 19:54:49'),
('61d656e5b8a0a180a8f4a1d07fdc485c9e303ae3a33076d76083f66790c3c3aa29bea74558849d8b', '0a49ebd2e8e8ee83166a75e3c87eba9456e030d6efda97290c6acac4318a3f80c04abd981a6814fc', 0, '2024-03-02 19:54:17'),
('7cd2a7fc775a8a72cd654ea55b6abf95acfbcb4a35a334a7f92609c659b97be4f626fc1e4f743dbe', 'd32306225b000c31f4907ae440a800f7587ef025208677ec0e4c0838cfe9840e9b64ffecbfb4aed7', 0, '2024-03-02 16:32:34'),
('803997dd5ab14ef020a5e3ccea7042099e9e2ee50f171ab5d67cf80530f22eef98dbc81809ae6a93', 'af042e10d05bc1089bf70da96a5b25c8967a5fffdde5010bc70964d94a4ef851304c21bd6949419c', 0, '2024-03-02 16:40:15'),
('8ad4862cc7ac75d87aeff383a5e88d50550881fc2f1874b1a5a85410666c9e831c22f095b020c7ce', '9e33bb7e0f75ba868a87b289d7d1eccb7f88c94b4a613c6afacd92154928df4f110c33fc8cb472d9', 0, '2024-03-02 16:38:38'),
('931be411e939730e6d7dc9e9f8df8638d9c590b6f405a40a5d2a0fbbcb573bcb8c8fd2c439ef9d30', '359bf746dbd13273bfc1fc7e63627923f82d25f2d87741847d8a0cbe9035379af3fa9c8e43fbd2ed', 0, '2024-03-02 17:10:51'),
('a7ed893c36cdf7700945c95e61e963136b374cf2cf73b206d360a5d886ed4c48000217a692f27b84', 'a0401ed5b36176101aff66d731efae7e4d0286d71f21dfc4ffb10a0f71b60a2b49ae7a8ea2c5f6f3', 0, '2024-03-02 16:45:18'),
('c5f0808dc71d0888ee901d2dde5fa237a60345cd1bb2621147b142795a57d9513130cff124530a78', '72cd9de7bd9570ea81c12fe110e402b3ddc4d06c517366fa6f029367847356bc524f54546775a093', 0, '2024-03-02 16:42:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `telescope_entries`
--

CREATE TABLE `telescope_entries` (
  `sequence` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `telescope_entries_tags`
--

CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `telescope_monitoring`
--

CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'Hieumin9802@gmail.com', NULL, '$2y$10$oRCCwNP3nYdsgWBv0R.8Q./zBu0Hi4ZKvJKIEgGT/SVzriygdee0W', NULL, '2023-03-02 09:28:58', '2023-03-02 09:28:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_files`
--

CREATE TABLE `user_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `file_systems`
--
ALTER TABLE `file_systems`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `telescope_entries`
--
ALTER TABLE `telescope_entries`
  ADD PRIMARY KEY (`sequence`),
  ADD UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  ADD KEY `telescope_entries_batch_id_index` (`batch_id`),
  ADD KEY `telescope_entries_family_hash_index` (`family_hash`),
  ADD KEY `telescope_entries_created_at_index` (`created_at`),
  ADD KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`);

--
-- Chỉ mục cho bảng `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD KEY `telescope_entries_tags_entry_uuid_tag_index` (`entry_uuid`,`tag`),
  ADD KEY `telescope_entries_tags_tag_index` (`tag`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `user_files`
--
ALTER TABLE `user_files`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `file_systems`
--
ALTER TABLE `file_systems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `telescope_entries`
--
ALTER TABLE `telescope_entries`
  MODIFY `sequence` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `user_files`
--
ALTER TABLE `user_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
