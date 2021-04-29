-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 29 avr. 2021 à 21:13
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bugbuster`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `dateCreation` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nomCategorie`, `description`, `dateCreation`) VALUES
(4, 'cfgf', 'dgg', '2021-04-23'),
(5, 'musique ball', 'juste de la musique', '2021-04-23'),
(6, 'zsf', 'khh', '2021-04-23');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210422180828', '2021-04-22 18:17:40', 291),
('DoctrineMigrations\\Version20210422183636', '2021-04-22 18:38:23', 3705);

-- --------------------------------------------------------

--
-- Structure de la table `oeuvre`
--

DROP TABLE IF EXISTS `oeuvre`;
CREATE TABLE IF NOT EXISTS `oeuvre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `datePub` datetime NOT NULL,
  `nomArtiste` varchar(30) NOT NULL,
  `titre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `duree` time NOT NULL,
  `categorie_id` int DEFAULT NULL,
  `image_size` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_35FE2EFEBCF5E72D` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `oeuvre`
--

INSERT INTO `oeuvre` (`id`, `datePub`, `nomArtiste`, `titre`, `image`, `duree`, `categorie_id`, `image_size`) VALUES
(12, '2021-04-28 15:38:34', 'zt', 'gzet', '2.jpg', '21:00:00', 4, 8451),
(13, '2021-04-28 15:49:34', 'dze', 'dfte', '1.jpeg', '00:03:00', 4, 4886),
(14, '2021-04-28 17:14:12', 'tryjfg', 'ft,h', 'accueil.jpg', '00:14:00', 4, 31670),
(15, '2021-04-28 17:15:09', 'thdf', 'ikh', 'accueil.jpg', '00:16:00', 4, 31670),
(16, '2021-04-28 17:16:30', 'ffd', 'kg', 'logo.png', '00:00:00', 5, 16146);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomUser` varchar(100) NOT NULL,
  `categorieedit` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nomUser`, `categorieedit`) VALUES
(1, 'TH', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `oeuvre`
--
ALTER TABLE `oeuvre`
  ADD CONSTRAINT `FK_35FE2EFEBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
