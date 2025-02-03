-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 03 fév. 2025 à 17:53
-- Version du serveur : 8.0.40
-- Version de PHP : 8.1.0

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
  `flag` varchar(200) NOT NULL,
  PRIMARY KEY (`id_exercice`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `exercices`
--

INSERT INTO `exercices` (`id_exercice`, `niveau`, `lien`, `flag`) VALUES
(1, 1, 'https://www.youtube.com/embed/CgX0-aA0iSE?si=EOePdEiq3KH5kVJY', 'OWASP{basique_sql}'),
(2, 2, '/', 'OWASP{SQL_UNION_trop_bien}'),
(3, 1, '/', 'OWASP{LFI_trop_FACILE}'),
(4, 2, '/', 'OWASP{LFI_bypass_filtre}'),
(5, 1, '/', 'OWASP{xss_stored_basique}'),
(6, 1, '/', 'OWASP{crack_hash}'),
(7, 1, '/', 'OWASP{upload_basique_no_filters}'),
(8, 2, '/', 'OWASP{upload_filters}'),
(9, 1, '/', 'OWASP{Attention_MISCONFIG}'),
(10, 2, '/', 'OWASP{CSRF_token}'),
(11, 1, '/', 'OWASP{Insecure_Deserialization}'),
(12, 1, '/', 'OWASP{JWT_HACKED_LEVEL_1}'),
(13, 2, '/', 'OWASP{JWT_HACKED_LEVEL_2}');

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

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `login`) VALUES
(1, 'leo'),
(4, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `validation`
--

DROP TABLE IF EXISTS `validation`;
CREATE TABLE IF NOT EXISTS `validation` (
  `id_user` int NOT NULL,
  `id_exercice` int NOT NULL,
  PRIMARY KEY (`id_user`,`id_exercice`),
  KEY `id_exercice` (`id_exercice`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `validation`
--

INSERT INTO `validation` (`id_user`, `id_exercice`) VALUES
(1, 1),
(1, 2),
(1, 8),
(1, 9),
(4, 8),
(4, 10);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
