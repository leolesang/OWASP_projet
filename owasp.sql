-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 10 fév. 2025 à 21:50
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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `exercices`
--

INSERT INTO `exercices` (`id_exercice`, `niveau`, `lien`, `flag`) VALUES
(1, 1, 'https://www.youtube.com/embed/CgX0-aA0iSE?si=EOePdEiq3KH5kVJY', 'OWASP{basique_sql}'),
(2, 2, 'https://www.youtube.com/embed/rP42ibRSCt0?si=ZHtC2X7210cmCt5b', 'OWASP{SQL_UNION_trop_bien}'),
(3, 1, 'https://www.youtube.com/embed/pjY-C78Pahw?si=cr7kEz8ee3Qiwt0O', 'OWASP{LFI_trop_FACILE}'),
(4, 2, 'https://www.youtube.com/embed/9OZ0wHr9zLU?si=aQcUvTFuygW7C3PG', 'OWASP{LFI_bypass_filtre}'),
(5, 1, 'https://www.youtube.com/embed/yW6kw-T5ly8?si=EDDAjLXvKzh7VsTi', 'OWASP{xss_stored_basique}'),
(6, 1, 'https://www.youtube.com/embed/UmjaJPV5JFk?si=YwI8_FoZrRSQFrV1', 'OWASP{crack_hash}'),
(7, 1, 'https://www.youtube.com/embed/yP33tDvHWx4?si=26tNaS9I334ELkuw', 'OWASP{upload_basique_no_filters}'),
(8, 2, 'https://www.youtube.com/embed/a6hno1ZlqiQ?si=oJnkyYM0sD9v_pMr', 'OWASP{upload_filters}'),
(9, 1, 'https://www.youtube.com/embed/gJ97cckL6Rs?si=whwuVKXqzNJmTZTI', 'OWASP{Attention_MISCONFIG}'),
(10, 3, 'https://www.youtube.com/embed/v3zkEz5vBWc?si=0hvndQvAKsZU6Jc4', 'OWASP{CSRF_token}'),
(11, 1, 'https://www.youtube.com/embed/Ch8ETDeP56g?si=8moNUA7IgVoSx4bB', 'OWASP{Insecure_Deserialization}'),
(12, 1, 'https://www.youtube.com/embed/lam_lUMMM9s?si=oVvUtAJ4Ucaw0nFJ', 'OWASP{JWT_HACKED_LEVEL_1}'),
(13, 2, 'https://www.youtube.com/embed/bhqDZBAGtuU?si=-V54X1x2dp0i8Sek', 'OWASP{JWT_HACKED_LEVEL_2}'),
(14, 3, 'https://www.youtube.com/embed/V-CrEi_9KBI?si=VIkJrsWADyNEErfA', 'OWASP{INJECTION_BYPASS_HARD}'),
(15, 2, 'https://www.youtube.com/embed/-OyDD1bJqZ8?si=ufSH4PCcS9ORqctm', 'OWASP{OUT_DATED_module}'),
(16, 1, 'https://www.youtube.com/embed/7cIuN5HIrso?si=iTf5zIFdLyqdhrxc', 'OWASP{PRIV_ESC_SUDO}');

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
(1, 15),
(4, 8),
(4, 10);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
