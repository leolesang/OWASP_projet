-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 21 jan. 2025 à 17:16
-- Version du serveur : 8.0.40
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `owasp`
--

-- --------------------------------------------------------

--
-- Structure de la table `exercices`
--

DROP TABLE IF EXISTS `exercices`;
CREATE TABLE IF NOT EXISTS `exercices` (
  `id_exercice` int NOT NULL AUTO_INCREMENT,
  `niveau` int DEFAULT NULL,
  `lien` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_exercice`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `exercices`
--

INSERT INTO `exercices` (`id_exercice`, `niveau`, `lien`) VALUES
(1, 1, 'https://www.youtube.com/embed/CgX0-aA0iSE?si=EOePdEiq3KH5kVJY');

-- --------------------------------------------------------

--
-- Structure de la table `exo1_sql`
--

DROP TABLE IF EXISTS `exo1_sql`;
CREATE TABLE IF NOT EXISTS `exo1_sql` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `exo1_sql`
--

INSERT INTO `exo1_sql` (`id`, `login`, `password`) VALUES
(1, 'toto', 'Toto1234');

-- --------------------------------------------------------

--
-- Structure de la table `exo2_sql`
--

DROP TABLE IF EXISTS `exo2_sql`;
CREATE TABLE IF NOT EXISTS `exo2_sql` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ville` varchar(100) NOT NULL,
  `superheros` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `exo2_sql`
--

INSERT INTO `exo2_sql` (`id`, `ville`, `superheros`) VALUES
(1, 'Paris', 'SpiderMan'),
(2, 'Lisbonne', 'Thor'),
(3, 'Zigma_B', 'Jean'),
(4, 'Madrid', 'Aquaman');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
