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

-- Listage de la structure de table gestionsalles. classe
CREATE TABLE IF NOT EXISTS `classe` (
  `id` int NOT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  `niveau` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestionsalles.classe : ~0 rows (environ)
INSERT INTO `classe` (`id`, `libelle`, `niveau`) VALUES
	(1, 'Informatique L1', 1),
	(2, 'Informatique L2', 2),
	(3, 'Informatique L3', 3),
	(4, 'Math L1', 1),
	(5, 'Math L2', 2);

-- Listage de la structure de table gestionsalles. enseignant
CREATE TABLE IF NOT EXISTS `enseignant` (
  `id` int NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestionsalles.enseignant : ~0 rows (environ)
INSERT INTO `enseignant` (`id`, `nom`, `prenom`) VALUES
	(1, 'Ben Ali', 'Ahmed'),
	(2, 'Trabelsi', 'Sana'),
	(3, 'Masmoudi', 'Khaled'),
	(4, 'Jaziri', 'Noura');

-- Listage de la structure de table gestionsalles. etudiant
CREATE TABLE IF NOT EXISTS `etudiant` (
  `carteEtudiant` int NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `idclasse` int DEFAULT NULL,
  PRIMARY KEY (`carteEtudiant`),
  KEY `FK_etudiant_classe` (`idclasse`),
  CONSTRAINT `FK_etudiant_classe` FOREIGN KEY (`idclasse`) REFERENCES `classe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestionsalles.etudiant : ~0 rows (environ)
INSERT INTO `etudiant` (`carteEtudiant`, `nom`, `prenom`, `idclasse`) VALUES
	(1001, 'Ali', 'Youssef', 1),
	(1002, 'Khelifi', 'Amira', 1),
	(1003, 'Haddad', 'Omar', 2),
	(1004, 'Mansour', 'Leila', 2),
	(1005, 'Zouari', 'Mohamed', 3),
	(1006, 'Ben Salah', 'Sara', 4),
	(1007, 'Feki', 'Aymen', 5);

-- Listage de la structure de table gestionsalles. salle
CREATE TABLE IF NOT EXISTS `salle` (
  `id` int NOT NULL,
  `nomSalle` varchar(50) DEFAULT NULL,
  `capacite` int DEFAULT NULL,
  `type` enum('EMPHI','TP','STANDAR') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestionsalles.salle : ~0 rows (environ)
INSERT INTO `salle` (`id`, `nomSalle`, `capacite`, `type`) VALUES
	(1, 'I1', 40, 'STANDAR'),
	(2, 'I2', 40, 'TP'),
	(3, 'I3', 40, 'STANDAR'),
	(4, 'I4', 40, 'TP'),
	(5, 'I5', 40, 'TP'),
	(6, 'I6', 40, 'STANDAR'),
	(7, 'I7', 40, 'STANDAR'),
	(8, 'I8', 40, 'STANDAR'),
	(9, 'I9', 40, 'STANDAR'),
	(10, 'I10', 40, 'STANDAR'),
	(11, 'Amphi 1', 200, 'EMPHI'),
	(12, 'Amphi 2', 200, 'EMPHI'),
	(13, 'Amphi 3', 200, 'EMPHI'),
	(14, 'Amphi 4', 200, 'EMPHI'),
	(15, 'Amphi 5', 200, 'EMPHI');

-- Listage de la structure de table gestionsalles. seance
CREATE TABLE IF NOT EXISTS `seance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matiere` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure_deb` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `enseignantId` int DEFAULT NULL,
  `chefDepartement` int DEFAULT NULL,
  `classeId` int DEFAULT NULL,
  `salleId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__enseignant` (`enseignantId`),
  KEY `FK__classe` (`classeId`),
  KEY `FK_seance_salle` (`salleId`),
  CONSTRAINT `FK__classe` FOREIGN KEY (`classeId`) REFERENCES `classe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK__enseignant` FOREIGN KEY (`enseignantId`) REFERENCES `enseignant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_seance_salle` FOREIGN KEY (`salleId`) REFERENCES `salle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestionsalles.seance : ~8 rows (environ)
INSERT INTO `seance` (`id`, `matiere`, `date`, `heure_deb`, `heure_fin`, `enseignantId`, `chefDepartement`, `classeId`, `salleId`) VALUES
	(1, 'Base de données', '2026-04-21', '08:30:00', '11:30:00', 1, NULL, 1, 1),
	(2, 'Algorithmique', '2026-04-21', '11:30:00', '13:30:00', 2, NULL, 1, 2),
	(3, 'Web Development', '2026-04-22', '14:00:00', '17:00:00', 3, NULL, 2, 4),
	(4, 'POO Java', '2026-04-22', '08:30:00', '10:30:00', 1, NULL, 2, 5),
	(5, 'Réseaux', '2026-04-23', '10:30:00', '12:30:00', 2, NULL, 3, 1),
	(6, 'Math Discrete', '2026-04-23', '14:30:00', '17:30:00', 4, NULL, 4, 3),
	(7, 'Analyse', '2026-04-24', '08:30:00', '12:30:00', 4, NULL, 5, 11),
	(8, 'Systemes', '2026-04-25', '09:00:00', '12:00:00', 3, NULL, 3, 12);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
