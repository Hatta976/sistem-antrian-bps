-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2026 at 09:52 PM
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
-- Database: `db_sistem_antrian_bps`
--

-- --------------------------------------------------------

--
-- Table structure for table `antrians`
--

CREATE TABLE `antrians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_antrian` varchar(20) NOT NULL,
  `pengunjung_id` bigint(20) UNSIGNED DEFAULT NULL,
  `layanan_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Menunggu','Dipanggil','Selesai') NOT NULL DEFAULT 'Menunggu',
  `waktu_panggil` timestamp NULL DEFAULT NULL,
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `antrians`
--

INSERT INTO `antrians` (`id`, `nomor_antrian`, `pengunjung_id`, `layanan_id`, `user_id`, `tanggal`, `status`, `waktu_panggil`, `waktu_selesai`, `created_at`, `updated_at`) VALUES
(1, 'A-001', NULL, 1, NULL, '2026-08-04', 'Selesai', NULL, NULL, '2026-08-04 09:27:59', '2026-08-04 10:34:35'),
(2, 'A-002', NULL, 1, NULL, '2026-08-04', 'Selesai', NULL, NULL, '2026-08-04 10:37:48', '2026-08-04 10:38:20'),
(3, 'A-001', NULL, 2, NULL, '2026-08-04', 'Selesai', NULL, NULL, '2026-08-04 10:38:43', '2026-08-04 10:39:54'),
(4, 'A-001', NULL, 3, NULL, '2026-08-04', 'Selesai', NULL, NULL, '2026-08-04 10:38:55', '2026-08-04 10:40:48'),
(5, 'A-003', NULL, 1, NULL, '2026-08-04', 'Selesai', NULL, NULL, '2026-08-04 10:50:34', '2026-08-04 10:51:36'),
(6, 'A-004', NULL, 1, NULL, '2026-08-04', 'Selesai', NULL, NULL, '2026-08-04 10:57:44', '2026-08-04 10:58:28'),
(7, 'A-002', NULL, 2, NULL, '2026-08-04', 'Selesai', NULL, NULL, '2026-08-04 11:00:14', '2026-08-04 11:01:03'),
(8, 'A-005', NULL, 1, NULL, '2026-08-04', 'Selesai', NULL, NULL, '2026-08-04 11:11:46', '2026-08-04 11:12:30'),
(9, 'A-006', NULL, 1, NULL, '2026-08-04', 'Menunggu', NULL, NULL, '2026-08-04 11:11:49', '2026-08-04 11:11:49'),
(10, 'C-002', NULL, 3, NULL, '2026-08-04', 'Selesai', NULL, NULL, '2026-08-04 11:23:52', '2026-08-04 11:24:57'),
(11, 'B-003', NULL, 2, NULL, '2026-08-04', 'Selesai', NULL, NULL, '2026-08-04 11:32:58', '2026-08-04 11:33:27'),
(12, 'D-001', NULL, 4, NULL, '2026-08-04', 'Selesai', NULL, NULL, '2026-08-04 11:35:51', '2026-08-04 11:36:41'),
(13, 'A-001', NULL, 1, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 18:43:19', '2026-08-04 18:43:57'),
(14, 'D-001', NULL, 4, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 18:44:12', '2026-08-04 18:55:32'),
(15, 'C-001', NULL, 3, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 18:44:18', '2026-08-04 18:56:10'),
(16, 'B-001', NULL, 2, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 18:44:27', '2026-08-04 18:58:29'),
(17, 'A-002', NULL, 1, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 18:44:38', '2026-08-04 18:55:40'),
(18, 'A-003', NULL, 1, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 18:54:32', '2026-08-04 18:58:03'),
(19, 'A-004', NULL, 1, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 18:58:35', '2026-08-04 19:00:07'),
(20, 'A-005', NULL, 1, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 19:01:14', '2026-08-04 19:02:34'),
(21, 'A-006', NULL, 1, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 19:01:31', '2026-08-04 19:05:54'),
(22, 'B-002', NULL, 2, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 19:02:25', '2026-08-04 19:08:40'),
(23, 'A-007', NULL, 1, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 19:05:19', '2026-08-04 19:09:18'),
(24, 'A-008', NULL, 1, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 19:10:06', '2026-08-04 19:13:14'),
(25, 'A-009', NULL, 1, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 19:21:01', '2026-08-04 19:31:56'),
(26, 'B-003', NULL, 2, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 19:28:45', '2026-08-04 19:32:55'),
(27, 'A-010', NULL, 1, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 19:33:02', '2026-08-04 19:36:47'),
(28, 'A-011', NULL, 1, NULL, '2026-08-05', 'Selesai', NULL, NULL, '2026-08-04 19:36:39', '2026-08-04 19:37:19');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `layanans`
--

CREATE TABLE `layanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_layanan` varchar(10) NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `layanans`
--

INSERT INTO `layanans` (`id`, `kode_layanan`, `nama_layanan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'A', 'Konsultasi Statistik', 1, '2026-08-04 08:33:52', '2026-08-04 08:33:52'),
(2, 'B', 'Pelayanan Statistik Terpadu (PST)', 1, '2026-08-04 08:33:52', '2026-08-04 08:33:52'),
(3, 'C', 'Permintaan Data', 1, '2026-08-04 08:33:52', '2026-08-04 08:33:52'),
(4, 'D', 'Rekomendasi Statistik', 1, '2026-08-04 08:33:52', '2026-08-04 08:33:52'),
(5, 'E', 'Lainnya', 1, '2026-08-04 08:33:52', '2026-08-04 08:33:52');

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
(1, '2026_01_01_000001_create_roles_table', 1),
(2, '2026_01_01_000002_create_users_table', 1),
(3, '2026_01_01_000003_create_layanans_table', 1),
(4, '2026_01_01_000004_create_pengunjungs_table', 1),
(5, '2026_01_01_000005_create_antrians_table', 1),
(6, '2026_08_04_153332_create_sessions_table', 1),
(7, '2026_08_04_162540_make_pengunjung_id_nullable_in_antrians_table', 2),
(8, '2026_08_04_163321_add_role_to_users_table', 3),
(9, '2026_08_04_165107_create_cache_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pengunjungs`
--

CREATE TABLE `pengunjungs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `instansi` varchar(150) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_role` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nama_role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2026-08-04 08:33:51', '2026-08-04 08:33:51'),
(2, 'Petugas', '2026-08-04 08:33:51', '2026-08-04 08:33:51');

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
('IYoWtMvhb6gpQRbIMSVTQnNXMiYEbyAeQnq3y1hw', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibjZzTTVrRENaeGtaRFZrZFZocVRMOHVST0Fqdkk4NGt0a1h2Rmp4TCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXR1Z2FzL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNzoicGV0dWdhcy5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1785872796),
('Je4V7b7AR6OsZQyP8bqy3TvXNMO0UqJq8po0eJfl', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidlF5ZHNRaHFWZjg3Q1c3N3JBaWxVWHRWOUpqS00zVWpUY1Z1M0tvQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9sb2NhbGhvc3Qvc2lzdGVtLWFudHJpYW4tYnBzL3B1YmxpYy9wZXR1Z2FzL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNzoicGV0dWdhcy5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1785873142);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'Petugas',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Administrator BPS', 'admin@bpsprabumulih.go.id', 'Petugas', NULL, '$2y$12$GuYG84Mxcg6VWI.QVdX/gOHqpn525LziknMLDrbFasoRA1F8ma13O', NULL, '2026-08-04 08:33:52', '2026-08-04 08:33:52'),
(2, 2, 'Petugas Loket 1', 'petugas@bpsprabumulih.go.id', 'Petugas', NULL, '$2y$12$80u03N.z2r4tL99v9isbOeWrvT3P2r2CZIrpiX2nOptVshe9cy1EW', NULL, '2026-08-04 08:33:52', '2026-08-04 08:33:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antrians`
--
ALTER TABLE `antrians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `antrians_pengunjung_id_foreign` (`pengunjung_id`),
  ADD KEY `antrians_layanan_id_foreign` (`layanan_id`),
  ADD KEY `antrians_user_id_foreign` (`user_id`),
  ADD KEY `antrians_tanggal_index` (`tanggal`),
  ADD KEY `antrians_status_index` (`status`);

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
-- Indexes for table `layanans`
--
ALTER TABLE `layanans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `layanans_kode_layanan_unique` (`kode_layanan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengunjungs`
--
ALTER TABLE `pengunjungs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `antrians`
--
ALTER TABLE `antrians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `layanans`
--
ALTER TABLE `layanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pengunjungs`
--
ALTER TABLE `pengunjungs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antrians`
--
ALTER TABLE `antrians`
  ADD CONSTRAINT `antrians_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `antrians_pengunjung_id_foreign` FOREIGN KEY (`pengunjung_id`) REFERENCES `pengunjungs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `antrians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
