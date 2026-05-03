-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.4.3 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour gestionsalles
CREATE DATABASE IF NOT EXISTS `gestionsalles` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gestionsalles`;

-- Listage de la structure de table gestionsalles. cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestionsalles.cache : ~6 rows (environ)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-aammiinneehayouni@gmail.com|127.0.0.1', 'i:2;', 1777242676),
	('laravel-cache-aammiinneehayouni@gmail.com|127.0.0.1:timer', 'i:1777242676;', 1777242676),
	('laravel-cache-mdamine.hayouni1@gmail.com|127.0.0.1', 'i:1;', 1777576141),
	('laravel-cache-mdamine.hayouni1@gmail.com|127.0.0.1:timer', 'i:1777576141;', 1777576141),
	('laravel-cache-mdamine.hni@gmail.com|127.0.0.1', 'i:1;', 1777242658),
	('laravel-cache-mdamine.hni@gmail.com|127.0.0.1:timer', 'i:1777242658;', 1777242658);

-- Listage de la structure de table gestionsalles. cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestionsalles.cache_locks : ~0 rows (environ)

-- Listage de la structure de table gestionsalles. classe
CREATE TABLE IF NOT EXISTS `classe` (
  `id` int NOT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  `niveau` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestionsalles.classe : ~5 rows (environ)
INSERT INTO `classe` (`id`, `libelle`, `niveau`) VALUES
	(1, 'Informatique L1', 1),
	(2, 'Informatique L2', 2),
	(3, 'Informatique L3', 3),
	(4, 'Math L1', 1),
	(5, 'Math L2', 2);

-- Listage de la structure de table gestionsalles. enseignants
CREATE TABLE IF NOT EXISTS `enseignants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `enseignants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestionsalles.enseignants : ~0 rows (environ)
INSERT INTO `enseignants` (`id`, `user_id`, `nom`, `prenom`) VALUES
	(3, 15, 'Ksouri', 'LeParfait'),
	(4, 16, 'hayouni', 'med'),
	(5, 17, 'mokrani', 'salim'),
	(6, 18, 'lamouchi', 'Macha'),
	(7, 19, 'Aidoudi', 'Amine');

-- Listage de la structure de table gestionsalles. etudiant
CREATE TABLE IF NOT EXISTS `etudiant` (
  `carteEtudiant` int NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `idclasse` int DEFAULT NULL,
  `idUser` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`carteEtudiant`),
  KEY `FK_etudiant_classe` (`idclasse`),
  KEY `FK_userId` (`idUser`),
  CONSTRAINT `FK_etudiant_classe` FOREIGN KEY (`idclasse`) REFERENCES `classe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_userId` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestionsalles.etudiant : ~0 rows (environ)

-- Listage de la structure de table gestionsalles. failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestionsalles.failed_jobs : ~0 rows (environ)

-- Listage de la structure de table gestionsalles. jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestionsalles.jobs : ~0 rows (environ)

-- Listage de la structure de table gestionsalles. job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestionsalles.job_batches : ~0 rows (environ)

-- Listage de la structure de table gestionsalles. migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestionsalles.migrations : ~4 rows (environ)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_04_26_122914_create_etudiants_table', 2),
	(5, '2026_04_26_164147_add_role_to_users_table', 3);

-- Listage de la structure de table gestionsalles. password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestionsalles.password_reset_tokens : ~0 rows (environ)
INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
	('mdamine.hayouni@gmail.com', '$2y$12$ueJRkDT65wUsyygKF5qmMO3PZC655fwhiqAu7S6IdzLsX.VlX9QrS', '2026-04-28 18:48:32');

-- Listage de la structure de table gestionsalles. reclamations
CREATE TABLE IF NOT EXISTS `reclamations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `description` text,
  `type` varchar(50) DEFAULT NULL,
  `statut` varchar(20) DEFAULT 'en_attente',
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reclamations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestionsalles.reclamations : ~0 rows (environ)
INSERT INTO `reclamations` (`id`, `titre`, `description`, `type`, `statut`, `user_id`, `created_at`) VALUES
	(6, 'Projecteur en panne - Salle A12', 'Le projecteur ne fonctionne pas depuis ce matin, impossible d’assurer le cours.', 'materiel', 'traite', 19, '2026-05-02 23:53:04'),
	(7, 'Climatisation HS - Salle B05', 'La clim ne marche pas, la salle est très chaude pendant les cours.', 'materiel', 'archive', 15, '2026-05-02 23:53:04'),
	(8, 'Retard de cours récurrent', 'Le professeur arrive souvent avec 20 minutes de retard.', 'organisation', 'traite', 16, '2026-05-02 23:53:04'),
	(9, 'Chaise cassée en salle TP', 'Plusieurs chaises sont cassées dans la salle TP C2.', 'materiel', 'traite', 17, '2026-05-02 23:53:04'),
	(10, 'Problème d’emploi du temps', 'Deux cours sont planifiés en même temps pour la même classe.', 'planning', 'archive', 18, '2026-05-02 23:53:04');

-- Listage de la structure de table gestionsalles. salle
CREATE TABLE IF NOT EXISTS `salle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomSalle` varchar(50) DEFAULT NULL,
  `capacite` int DEFAULT NULL,
  `type` enum('AMPHI','TP','NORMAL') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `disponibilite` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestionsalles.salle : ~3 rows (environ)
INSERT INTO `salle` (`id`, `nomSalle`, `capacite`, `type`, `disponibilite`) VALUES
	(1, 'I10', 50, 'AMPHI', 1),
	(2, 'I12', 200, 'NORMAL', 1),
	(3, 'I6', 20, 'TP', 1),
	(9, 'I8', 50, 'NORMAL', 0);

-- Listage de la structure de table gestionsalles. seance
CREATE TABLE IF NOT EXISTS `seance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matiere` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure_deb` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `enseignantId` int DEFAULT NULL,
  `classeId` int DEFAULT NULL,
  `salleId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__enseignant` (`enseignantId`),
  KEY `FK__classe` (`classeId`),
  KEY `FK_seanceSalle` (`salleId`),
  CONSTRAINT `FK__classe` FOREIGN KEY (`classeId`) REFERENCES `classe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_seanceSalle` FOREIGN KEY (`salleId`) REFERENCES `salle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestionsalles.seance : ~8 rows (environ)
INSERT INTO `seance` (`id`, `matiere`, `date`, `heure_deb`, `heure_fin`, `enseignantId`, `classeId`, `salleId`) VALUES
	(16, 'SID', '2026-05-09', '08:30:00', '10:30:00', 5, 1, 1),
	(17, 'Francais', '2026-05-08', '08:30:00', '10:30:00', 7, 1, 1),
	(18, 'Anglais', '2026-05-08', '08:30:00', '10:30:00', 6, 2, 2);

-- Listage de la structure de table gestionsalles. sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestionsalles.sessions : ~1 rows (environ)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('OheZOBzmJbyvSRdZwjPtUICuMtnEYTMMjdnycgQ9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaFByTk9SWmZTYWx1eWQ5ZVdUWlU2YkdpYWpPSUVYOWVnUnJvY0k2VyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWNsYW1hdGlvbj9wYWdlPTEiO3M6NToicm91dGUiO3M6MTY6ImNoZWYucmVjbGFtYXRpb24iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1777766391);

-- Listage de la structure de table gestionsalles. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'etudiant',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestionsalles.users : ~7 rows (environ)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
	(1, 'Mohamed Amine Hayouni', 'mdamine.hayouni@gmail.com', NULL, '$2y$12$TbLTzw8Os5PBTm7qEiLcMeWkbPB8eUIm/FqrhDEaL7cGFR7xeDsx.', NULL, '2026-04-26 20:34:48', '2026-04-26 20:34:48', 'chef'),
	(15, 'Ksouri', 'KsouriLeParfait@gmail', NULL, '$2y$12$QvUXKdjMmPTTjQaVoMF0MeNskFxqX1mLRIE/K3Huh3ZKhBk927D.K', NULL, '2026-05-02 16:38:03', '2026-05-02 16:38:03', 'enseignant'),
	(16, 'hayouni', 'hayouni@gmail.com', NULL, '$2y$12$eQ47kbK9SZk4FqOo8LTBQ.wtGuQt0HCzwE174LGWMLnv/AB4wgVaO', NULL, '2026-05-02 16:38:19', '2026-05-02 16:38:19', 'enseignant'),
	(17, 'mokrani', 'salim@gmail.com', NULL, '$2y$12$R1EKzrVAY4HyLpfaDk/yZO9gFfy7HsUevnBQ7EqmBumy74NaNpXFi', NULL, '2026-05-02 16:39:16', '2026-05-02 16:39:16', 'enseignant'),
	(18, 'lamouchi Macha', 'lamouchi@gmail.com', NULL, '$2y$12$agG3ojTcapaeG3dZ5p2JBuTKl9CZJ9i8/r35oI8LTc9gN5osJ8NKq', NULL, '2026-05-02 16:39:45', '2026-05-02 21:11:36', 'enseignant'),
	(19, 'Aidoudi', 'aidoudi@gmail.com', NULL, '$2y$12$s4NYdCkvl1pQePcftATKkuHctEYniIPVRjzpcoy47q5lx/hBgM8ne', NULL, '2026-05-02 16:40:16', '2026-05-02 16:40:16', 'enseignant');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
