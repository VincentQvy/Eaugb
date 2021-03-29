-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 26 mars 2021 à 12:13
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `eaugb`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` tinytext NOT NULL,
  `first_name` tinytext NOT NULL,
  `email` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `last_name`, `first_name`, `email`) VALUES
(1, 'Quivy', 'Vincent', 'v.quivy@gmail.com'),
(2, 'Nugier', 'Batiste', 'bnugier@gaming.tech');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `picture` text NOT NULL,
  `date_trip` date NOT NULL,
  `date` timestamp NOT NULL,
  `text` text NOT NULL,
  `country_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin2_id` (`admin_id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `name`, `picture`, `date_trip`, `date`, `text`, `country_id`, `admin_id`) VALUES
(1, 'Le plus beau au cameroun', '5e236d2c421e8dfcc1e2f5dc6ad8898f', '2021-03-02', '2021-03-24 09:56:38', 'Coucou c\'est bien', 4, 1),
(2, 'erogihykjh', 'trzsydsxhjckhtyfr', '2021-03-02', '2021-03-24 10:04:12', 'gfdsgreazgdsges', 3, 2),
(3, 'zrrtyjuhefgaeqthtr', 'iqkdurytlkqdjhvliu', '2021-03-03', '2021-03-24 12:33:26', 'yujtfrqkuzresytoqikudflhoiukhb', 3, 1),
(4, 'Wow la Lozère !', 'wir.skyrock', '2021-02-09', '2021-03-24 12:53:47', 'Je m\'attendais pas a voir ça il y a de bien étranges animaux en Lozère.', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL,
  `name` tinytext NOT NULL,
  `comment` text NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `date`, `name`, `comment`, `article_id`) VALUES
(1, '2021-03-26 09:11:34', 'Woojys', 'la bulgarie c\'est tro kool', 2),
(2, '2021-03-26 09:45:03', 'Batiste', 'Cet animal est vraiment hiiii', 2),
(3, '2021-03-26 10:02:20', 'Lucas', 'Il a une tête de requin', 4),
(4, '2021-03-26 11:05:01', 'Woojys', 'bogoss wola', 4),
(6, '2021-03-26 11:07:50', 'Woojys', 'Ohhh ca a l\'air trop beau', 3),
(9, '2021-03-26 11:12:32', 'esska', 'Il est magnifiquement con', 1);

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `admin_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `countries`
--

INSERT INTO `countries` (`id`, `name`, `admin_id`) VALUES
(2, 'France', 1),
(3, 'Bulgarie', 2),
(4, 'Cameroun', 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `admin2_id` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `country_id` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `article_id` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`);

--
-- Contraintes pour la table `countries`
--
ALTER TABLE `countries`
  ADD CONSTRAINT `admin_id` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
