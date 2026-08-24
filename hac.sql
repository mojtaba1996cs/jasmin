-- Adminer 4.8.4 MySQL 8.4.8 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_office_id` bigint unsigned NOT NULL,
  `to_office_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `doc_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `archived_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_from_office_id_foreign` (`from_office_id`),
  KEY `documents_to_office_id_foreign` (`to_office_id`),
  KEY `documents_created_by_foreign` (`created_by`),
  CONSTRAINT `documents_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `documents_from_office_id_foreign` FOREIGN KEY (`from_office_id`) REFERENCES `offices` (`id`),
  CONSTRAINT `documents_to_office_id_foreign` FOREIGN KEY (`to_office_id`) REFERENCES `offices` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'0000_01_01_000000_create_offices_table',	1),
(2,	'0001_01_01_000000_create_users_table',	1),
(3,	'0001_01_01_000001_create_cache_table',	1),
(4,	'0001_01_01_000002_create_jobs_table',	1),
(5,	'2026_04_13_205916_create_roles_table',	1),
(6,	'2026_04_13_205959_create_documents_table',	1),
(7,	'2026_04_13_212945_add_role_and_office_to_users_table',	2),
(8,	'2026_04_15_195511_add_archived_at_to_documents_table',	2);

DROP TABLE IF EXISTS `offices`;
CREATE TABLE `offices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `offices` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1,	'المدير',	'ADM',	NULL,	NULL),
(2,	'التنفيذي ',	'EXE',	NULL,	NULL),
(3,	'الاجراءات الامنية',	'SEC',	NULL,	NULL),
(4,	' التخطيط الاستراتيجي ',	'STR',	NULL,	NULL),
(5,	' البرامج والمنظمات الاجنبية',	'INT',	NULL,	NULL),
(6,	'المنظمات الوطنية',	'NAT',	NULL,	NULL),
(7,	'الشؤون المالية',	'FIN',	NULL,	NULL),
(8,	'الحالات الطارئة',	'EMR',	NULL,	NULL),
(9,	'الارشيف',	'ARC',	NULL,	NULL);

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1,	'2026-05-02 08:48:00',	'2026-05-02 08:48:00',	'مدير'),
(2,	NULL,	NULL,	'موظف');

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bH46BQIemLXjONvQDaaaadR0rpOjlk1GArtWfwZC',	10,	'127.0.0.100',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36',	'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTkNXelFkYjVhY2huSlBoNWlMaG0yWkZNcENiYXVNOGxHWmtNQlFtdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHBzOi8vamFzbWluLXByb2plY3Qud2FzbWVyLmFwcC9kYXNoYm9hcmQiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwO30=',	1787008693),
('fI6tcgf1MGTTr12E5c5DC8eNcncfHWiJBluPjBnn',	10,	'127.0.0.100',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36',	'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSGN0ZmNrRXZST0hvbVhxUmVjMm1ZNmR1djd5RzVBOW1zN3ZYV0NENyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vamFzbWluLW1vanRhYmExOTk2Y3Mud2FzbWVyLmFwcC9hZG1pbi91c2VycyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7fQ==',	1787008495);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_id` bigint unsigned DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint unsigned NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_office_id_foreign` (`office_id`),
  CONSTRAINT `users_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `office_id`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
(10,	'admin',	'admin@test.com',	NULL,	'$2y$12$4A/nKAADIajTJ2/P3CrAIOu9poPvLG1IY1L66ByiNCmnQHl6vsyAW',	1,	NULL,	'2026-04-15 14:08:30',	'2026-04-15 14:08:30',	1),
(11,	'office2',	'office2@test.com',	NULL,	'$2y$12$RO3CXGDEw/NdfacqhmPHlOFWw59VehwD4wqCx/mziDDLgdO1qntAG',	2,	NULL,	'2026-04-15 16:08:31',	'2026-04-15 16:08:31',	2),
(12,	'office3',	'office3@test.com',	NULL,	'$2y$12$tQE2PPX0mNcJYroYQKiso.4n7N0nK6VBPnSiYNFhYJ4tNuMinG1dK',	3,	NULL,	'2026-04-15 16:08:32',	'2026-04-15 16:08:32',	2),
(13,	'office4',	'office4@test.com',	NULL,	'$2y$12$f7aHIjw35VsgZ825F0pkD.C4Gf05aX3u1pLr/OcugpstDJybDknfO',	4,	NULL,	'2026-04-15 16:08:32',	'2026-04-15 16:08:32',	2),
(14,	'office5',	'office5@test.com',	NULL,	'$2y$12$LGpS0S6BlYD7en1P12Bw5u8TJgUPntVLXvvGDfQtaLsqYx/dYmJci',	5,	NULL,	'2026-04-15 16:08:33',	'2026-04-15 16:08:33',	2),
(15,	'office6',	'office6@test.com',	NULL,	'$2y$12$hj9ZmbCTuQACaLwojl6Mke96.n5hplXPcH0kTdLyrbSLfruMbz2qu',	6,	NULL,	'2026-04-15 16:08:34',	'2026-04-15 16:08:34',	2),
(16,	'office7',	'office7@test.com',	NULL,	'$2y$12$ZNpnz4L5qOwxYjKTbKevPeof5yhhsgNHbaoEMMfmMcBNhSG4UeIAu',	7,	NULL,	'2026-04-15 16:08:34',	'2026-04-15 16:08:34',	2),
(17,	'office8',	'office8@test.com',	NULL,	'$2y$12$R6I2FV6V1oz55TlIwqhMmOYDsI1mIUxydcqpHKVTvA4gNKzUksmFG',	8,	NULL,	'2026-04-15 16:08:35',	'2026-04-15 16:08:35',	2),
(18,	'office9',	'office9@test.com',	NULL,	'$2y$12$2u2WZkZJVYhapbFgVgxS9.wVI06aqeaP88CRaB2ETYDy7Ixw6qpC2',	9,	NULL,	'2026-04-15 16:08:44',	'2026-04-15 16:08:44',	2),
(20,	'jasmin',	'jj@test.com',	NULL,	'$2y$12$wdanrDpJCHSmskETFNkTPODeUvHhFzW6swrXfx9QPvyvnF/LB6xKe',	6,	NULL,	'2026-04-16 00:14:29',	'2026-04-16 00:14:29',	2),
(21,	'jasmin',	'yasmin@test.com',	NULL,	'$2y$12$1NgB0V1xxZncdO8d6VKepe8PGcnAvhSHk7OpvVpzVWZYvXh0z7FXC',	7,	NULL,	'2026-04-16 07:31:47',	'2026-04-16 07:31:47',	2),
(22,	'احمد عبدالله',	'ahmad@test.com',	NULL,	'$2y$12$kwz6rgIx3FRoWJBLe97EeebRSkNKdi80Z9O0v7ZHSx0wHOf6FrrtK',	3,	NULL,	'2026-05-02 06:48:55',	'2026-05-02 06:48:55',	2),
(38,	'Mohammad Al-Mojtaba',	'mojtaba1996cs@gmail.com',	NULL,	'$2y$12$ronSyCqijslBu/x00TGsAOa4S4C/1VTXwe3W/9zc/mWnXVlv49ARu',	2,	NULL,	'2026-08-17 08:51:08',	'2026-08-17 23:04:45',	2),
(39,	'sroo',	'sroo@test.com',	NULL,	'$2y$12$uI6pZq0SubW12.EXw2yIUuejHhUyJyw.yNTWSV023C6W2qYkAmesm',	9,	NULL,	'2026-08-17 23:16:27',	'2026-08-17 23:16:27',	2);

-- 2026-08-17 23:19:40
