-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 19 juin 2020 à 09:11
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet5_da_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `mini_content` varchar(225) NOT NULL,
  `title` varchar(70) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_category` (`id_category`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `id_category`, `id_user`, `mini_content`, `title`, `content`, `creation_date`, `update_date`) VALUES
(2, 3, 4, 'Vivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendrerit', 'titre', 'Vivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauVivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendreritris quis henVivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendreritdrerit', '2020-06-03 08:19:19', NULL),
(3, 2, 2, 'Vivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris...', 'titre', '<p>Vivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendreritVivamus egestas turpis aliquam consequat ullamcorper.</p>', '2020-06-03 10:14:10', '2020-06-13 16:01:21'),
(5, 2, 2, 'Vivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendrerit', 'titre', 'Vivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendreritVivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendreritVivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendrerit', '2020-06-03 06:19:22', NULL),
(6, 3, 3, 'Vivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendrerit', 'titre', 'Vivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendreritVivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendreritVivamus egestas turpis aliquam consequat ullamcorper. Donec vestibulum eleifend mauris quis hendrerit', '2020-06-03 05:17:18', NULL),
(11, 2, 2, 'iuytre', 'oiuytre', '<p>oiuytrez</p>', '2020-06-09 08:01:06', NULL),
(12, 3, 2, 'un chapo', 'un titre', '<p>un beau texte!</p>', '2020-06-09 08:04:26', NULL),
(13, 1, 2, 'Un nouveau chapo bla bla bla...', 'Un super titre!', '<p>yessssss &ccedil;a fonctionne!</p>', '2020-06-09 17:18:28', NULL),
(14, 2, 2, 'un autre chapo', 'super le titre!', '<p>En format paragraphe?</p>\r\n<p>&ccedil;a fonctionne?</p>', '2020-06-09 17:46:06', NULL),
(15, 2, 2, 'bla... bla... bla...', 'Un autre titre', '<p>C\'est un problème d\'encodage : ça craint!</p>\r\n<p>grave...</p>', '2020-06-09 18:09:12', '2020-06-13 12:18:25'),
(16, 3, 2, 'J\'avais un problème d\'encodage et...', 'Encodage Tiny', '<p>J\'avais un problème d\'encodage et comme toujours en cherchant sur goolgle : j\'ai eu ma réponse et ça passe!!!</p>', '2020-06-09 18:17:25', NULL),
(17, 2, 2, 'Alors que je réfléchissais...', 'Réflexion', '<p>Alors que je réfléchissais à mon avenir!!!</p>', '2020-06-13 10:05:26', '2020-06-18 17:28:02');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `category` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Activiés'),
(2, 'Objectifs'),
(3, 'Astuces');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `content` text NOT NULL,
  `valid` tinyint(1) DEFAULT 0,
  `comment_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_article` (`id_article`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `id_article`, `id_user`, `content`, `valid`, `comment_date`) VALUES
(7, 17, 4, 'encore un commentaire ...', 1, '2020-06-12 13:37:16'),
(8, 17, 4, 'allez encore un essais!', 1, '2020-06-12 16:34:06'),
(9, 17, 4, 'et encore un!', 1, '2020-06-12 16:52:53'),
(13, 17, 4, 'Ca marche pas pfff...', 1, '2020-06-13 20:44:09'),
(14, 17, 4, 'le message du jour!!!!', 1, '2020-06-16 15:56:04'),
(15, 17, 4, 'un joli message', 1, '2020-06-16 16:35:01'),
(16, 16, 2, 'et un commentaire de bubu!un !!!', 1, '2020-06-16 18:32:06'),
(21, 12, 4, 'kjhgfddfghjklmlkjhgfdsdfghjk', 1, '2020-06-17 14:37:44'),
(22, 17, 4, 'oiuytrekjhgf,nbvc', 1, '2020-06-17 14:49:49'),
(23, 17, 4, 'nouvo commentaire?', 1, '2020-06-18 08:14:07'),
(24, 17, 4, 'oiuytrezkjhgfds', 0, '2020-06-18 18:00:57');

-- --------------------------------------------------------

--
-- Structure de la table `homepage`
--

DROP TABLE IF EXISTS `homepage`;
CREATE TABLE IF NOT EXISTS `homepage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `homepage`
--

INSERT INTO `homepage` (`id`, `username`, `mail`, `content`, `creation_date`) VALUES
(1, 'Francky', 'francky@fra.com', 'choubidou bidou bidou ouap!', '0000-00-00 00:00:00'),
(2, 'Franck Boutot', 'mimile@mimile.fr', 'mon message', '0000-00-00 00:00:00'),
(3, 'Francky', 'francky@fra.com', 'poiuytrekjhgfnbvcx', '0000-00-00 00:00:00'),
(4, 'Franck Boutot', 'bubu@bubu.fr', 'lkjhgfdfghjbv', '0000-00-00 00:00:00'),
(5, 'Francky', 'bubu@bubu.fr', 'Voyons voir la date!', '2020-06-19 11:04:43');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(70) NOT NULL,
  `mail` varchar(70) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `droits` tinyint(1) DEFAULT 0,
  `avatar` varchar(30) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `mail`, `pass`, `droits`, `avatar`, `create_date`) VALUES
(2, 'bubu', 'bubu@bubu.fr', '$2y$10$Yk0L90VfaSUDitflrQ8HSOkL78zEKa77QxE.XE8yg8/ogEAR3EQq6', 0, '2.jpg', '2020-06-01 12:21:22'),
(3, 'jojo', 'jojo@jojo.fr', '$2y$10$ErjTiY0PVqNEAK3yzHwRqu31wG8/olIAhJQl8sjZ6/QpsrdeHSOJe', 0, 'default.jpg', '2020-06-17 11:26:22'),
(4, 'bibi', 'bibi@bibi.fr', '$2y$10$QwDgjak/ChRgp2RxNO18MO8TSNnS0/OB5Gg45Z5B72Dmqic2azWUS', 1, '4.jpg', '2020-06-11 18:25:19'),
(5, 'juju', 'juju@juju.fr', '$2y$10$t3hZs8cOWdR707.X1MteLecltweeY.4GZKinI2zcoQ1Fh.O.aLiiK', 0, 'default.jpg', '2020-06-16 13:08:20'),
(8, 'bibou', 'bibou@bibou.fr', '$2y$10$cGwYSKvRV7s4bH2v2sV42OuY2Hmg8IbF49WF5EoPEztCvMk/qPdGO', 0, '8.jpg', '2020-06-15 10:21:56'),
(11, 'mimile', 'mimile@mimile.fr', '$2y$10$ppjATld9eKmux8xNOSIkG.Uzw8kVC7JyAHQa8DDoYUzCyoToQTViK', 0, 'default.jpg', '2020-06-16 13:36:07');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
