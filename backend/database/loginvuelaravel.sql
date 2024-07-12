-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Jul-2024 às 01:32
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loginvuelaravel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `failed_jobs`
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
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `personal_access_tokens`
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

--
-- Extraindo dados da tabela `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'authToken', '91b35b2d28572d53cf04d0ea3e95a538ad946eb090bb2b647c419d418c4af08e', '[\"*\"]', NULL, NULL, '2024-07-11 18:15:30', '2024-07-11 18:15:30'),
(2, 'App\\Models\\User', 1, 'authToken', '223d1ce43afea7197b53a23692c529435ce6ec027754afe30abee52f8ac29b48', '[\"*\"]', NULL, NULL, '2024-07-11 18:15:30', '2024-07-11 18:15:30'),
(3, 'App\\Models\\User', 1, 'authToken', '082119b1588cad99902eb03735e733a60a5b2c5216d8acfd6b95dda2e4af9884', '[\"*\"]', NULL, NULL, '2024-07-11 18:18:00', '2024-07-11 18:18:00'),
(4, 'App\\Models\\User', 1, 'authToken', '28a7b5bc15cd74b57073ec20bceea62b0a86bcbb1dfdfa11697964dd47738278', '[\"*\"]', NULL, NULL, '2024-07-11 18:18:05', '2024-07-11 18:18:05'),
(5, 'App\\Models\\User', 1, 'authToken', 'a2cbbf1723773c5a41de235db4ffd41219027f78457873daac51a2095dc29b3a', '[\"*\"]', NULL, NULL, '2024-07-11 18:18:17', '2024-07-11 18:18:17'),
(6, 'App\\Models\\User', 1, 'authToken', 'd317bde59cb33ec1134400692d1e5380b7b0f87ed2af5d46fc0840515bc412c3', '[\"*\"]', NULL, NULL, '2024-07-11 18:49:55', '2024-07-11 18:49:55'),
(7, 'App\\Models\\User', 1, 'authToken', '2240831ce24655cbdb0a2c15b94f8ba0bfa93a40ae7e4b39f880963c8c45b8fd', '[\"*\"]', NULL, NULL, '2024-07-11 18:51:53', '2024-07-11 18:51:53'),
(8, 'App\\Models\\User', 1, 'authToken', 'f338368843e97f7a238e64faae0578fe3a436d3189cf56ba577f468b0431df1a', '[\"*\"]', NULL, NULL, '2024-07-11 18:51:53', '2024-07-11 18:51:53'),
(9, 'App\\Models\\User', 1, 'authToken', 'dcb7c5379d56b0a5c3c337bc2171abd5d3d74e941c49a319f002f884341ead1a', '[\"*\"]', NULL, NULL, '2024-07-11 18:54:15', '2024-07-11 18:54:15'),
(10, 'App\\Models\\User', 1, 'authToken', 'e624999885ff41ca30cfdac76f3376fc2d3d68413b1aad42e5a99b940f4ff254', '[\"*\"]', NULL, NULL, '2024-07-11 19:27:49', '2024-07-11 19:27:49'),
(11, 'App\\Models\\User', 1, 'authToken', '153323c43bd666980df9e31ec3356ddd7c871ce46def9ad94c7eb22c862e22fa', '[\"*\"]', NULL, NULL, '2024-07-11 19:45:20', '2024-07-11 19:45:20'),
(12, 'App\\Models\\User', 1, 'authToken', '451702ff49bd75376b1edb5536d61eff23e87bb9c139275904c790d4b523646a', '[\"*\"]', NULL, NULL, '2024-07-11 19:55:04', '2024-07-11 19:55:04'),
(13, 'App\\Models\\User', 1, 'authToken', '27e118983a63325722cf62423ad444218437043cd47eb54985719a19666435b5', '[\"*\"]', NULL, NULL, '2024-07-11 20:39:58', '2024-07-11 20:39:58'),
(16, 'App\\Models\\User', 1, 'authToken', '9408a23f52dff7bb6ac729c5a00b204ff67c51b44297df9782becc63a0dc07fb', '[\"*\"]', NULL, NULL, '2024-07-13 01:46:13', '2024-07-13 01:46:13'),
(19, 'App\\Models\\User', 1, 'authToken', '4a8f00ee3114d0bd4637018266efbceef592fb2b145c52c809cb5454eeef74b8', '[\"*\"]', NULL, NULL, '2024-07-13 01:54:53', '2024-07-13 01:54:53');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', NULL, '$2y$12$v0INXakSzHEOVCOwxv9RUe5UzwH/m.WLOvOH5FHV/hiELaKNqLnuC', NULL, '2024-07-11 17:20:06', '2024-07-11 17:20:06'),
(2, 'Another User', 'another@example.com', NULL, '$2y$12$Xp0CqQCg6OcncuMSA3DX2OSy.jbDDw1jIPAYrNq8dGHE4Em0onjaW', NULL, '2024-07-11 17:20:07', '2024-07-11 17:20:07');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices para tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
