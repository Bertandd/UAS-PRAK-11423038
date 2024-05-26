-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Bulan Mei 2024 pada 15.23
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `badminton_court`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fields`
--

CREATE TABLE `fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `field_location_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 55000,
  `description` text NOT NULL,
  `open` time NOT NULL,
  `close` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `fields`
--

INSERT INTO `fields` (`id`, `name`, `field_location_id`, `image`, `price`, `description`, `open`, `close`, `created_at`, `updated_at`) VALUES
(4, 'Lapangan Sitoluama', 1004, '9Nvp09qXhuhMK6P1SQcF2B5LctLETpgTcaU84pcs.jpg', 55000, 'Lapangan Badminton di Sitoluama', '08:00:00', '22:00:00', '2024-05-22 00:38:24', '2024-05-25 05:47:07'),
(5, 'Lapangan Sitoluama 2', 1004, '2KG5C0P4fzWGMcbEOVInZhXpma96xKSzPyESwlEg.jpg', 60000, 'Lapangan 2 di Sitoluama', '07:00:00', '20:00:00', '2024-05-22 00:40:15', '2024-05-25 05:40:20'),
(6, 'Lapangan Porsea', 1005, 'Bfhw00uCm1ErRqUJcAOOaIuOLrBKrNc0lzzFwjxR.jpg', 70000, 'Lapangan Porsea', '09:00:00', '19:00:00', '2024-05-22 00:47:14', '2024-05-25 05:40:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `field_bookings`
--

CREATE TABLE `field_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `field_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `field_bookings`
--

INSERT INTO `field_bookings` (`id`, `user_id`, `field_id`, `date`, `start_time`, `end_time`, `total_price`, `created_at`, `updated_at`, `status`) VALUES
(2, 1004, 4, '2024-05-22', '15:00:00', '17:00:00', 110000, '2024-05-22 00:43:16', '2024-05-22 00:44:06', 'approved'),
(3, 1004, 5, '2024-05-22', '17:00:00', '19:00:00', 120000, '2024-05-22 00:43:41', '2024-05-22 00:44:08', 'approved'),
(4, 1004, 6, '2024-05-22', '15:00:00', '17:00:00', 129998, '2024-05-22 00:50:15', '2024-05-22 00:50:36', 'rejected'),
(5, 1004, 6, '2024-05-26', '10:00:00', '14:00:00', 280000, '2024-05-25 05:43:32', '2024-05-25 06:19:49', 'approved');

-- --------------------------------------------------------

--
-- Struktur dari tabel `field_locations`
--

CREATE TABLE `field_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `field_locations`
--

INSERT INTO `field_locations` (`id`, `user_id`, `name`, `address`, `slug`, `created_at`, `updated_at`) VALUES
(999, 999, 'Lokasi Lapangan', 'default', 'default', NULL, NULL),
(1004, 1003, 'Sitoluama', 'Jl.Sisingamangaraja Kecamatan Sitoluama', 'sitoluama', '2024-05-22 00:38:24', '2024-05-22 00:38:24'),
(1005, 1005, 'Porsea', 'Jl.Sisingamangaraja Porsea', 'porsea', '2024-05-22 00:47:14', '2024-05-22 00:47:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2014_10_12_000000_create_users_table', 1),
(9, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1),
(11, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(12, '2024_03_22_192706_create_field_locations_table', 1),
(13, '2024_03_22_193141_create_fields_table', 1),
(14, '2024_03_22_193407_create_field_bookings_table', 1),
(15, '2024_05_16_144951_add_status_to_table_field_bookings', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Super Admin', 'admin@gmail.com', NULL, '$2y$10$Vsr7chuGTFqK7Mr7YSx85uhjF2J2CM6RDwepjVZHx.YmXTYb99p7u', 'admin', NULL, '2024-05-16 01:31:40', '2024-05-22 00:37:17'),
(999, 'Pengelola Lapangan', 'pengeloladefault@gmail.com', NULL, '$2y$10$luaRsmDttny2XmtN.Ib03eJ7lXHxpKPLKxewI70j27ESt8atNrVbe', 'operator', NULL, NULL, NULL),
(1000, 'Member Penyewa', 'memberdefault@gmail.com', NULL, '$2y$10$luaRsmDttny2XmtN.Ib03eJ7lXHxpKPLKxewI70j27ESt8atNrVbe', 'user', NULL, NULL, NULL),
(1003, 'Abet', 'abet@gmail.com', NULL, '$2y$10$LB6ynZ6kKezOE7Mk1Awg/ejAwjd1/9ik0oiMhQjSTJVwSYXGFOklm', 'operator', 'JtF6Zw1MTr9FnJECn7qSHj1CiuQLCUovAGZdHIFDZnDOCJbr2HueOkstFhL2', '2024-05-22 00:37:40', '2024-05-22 00:37:54'),
(1004, 'Bertand', 'bertand@gmail.com', NULL, '$2y$10$vAxQskgzeYZG4pRFND.i1O.leKPB9rigMn1Ejp3x.oqvQtN.emnCi', 'user', NULL, '2024-05-22 00:42:46', '2024-05-22 00:42:46'),
(1005, 'Domu', 'domu@gmail.com', NULL, '$2y$10$HFoHp6LInlLCR9o9HiVrAeCX60KUj3Dg0jNs0dvr/KNG6SYkNIkPq', 'operator', NULL, '2024-05-22 00:46:46', '2024-05-22 00:46:46');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fields_field_location_id_foreign` (`field_location_id`);

--
-- Indeks untuk tabel `field_bookings`
--
ALTER TABLE `field_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `field_bookings_user_id_foreign` (`user_id`),
  ADD KEY `field_bookings_field_id_foreign` (`field_id`);

--
-- Indeks untuk tabel `field_locations`
--
ALTER TABLE `field_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `field_locations_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `fields`
--
ALTER TABLE `fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `field_bookings`
--
ALTER TABLE `field_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `field_locations`
--
ALTER TABLE `field_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `fields_field_location_id_foreign` FOREIGN KEY (`field_location_id`) REFERENCES `field_locations` (`id`);

--
-- Ketidakleluasaan untuk tabel `field_bookings`
--
ALTER TABLE `field_bookings`
  ADD CONSTRAINT `field_bookings_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `fields` (`id`),
  ADD CONSTRAINT `field_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `field_locations`
--
ALTER TABLE `field_locations`
  ADD CONSTRAINT `field_locations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
