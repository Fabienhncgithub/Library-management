-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 17 Juin 2019 à 07:47
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `prwb_1819_pg08`
--
CREATE DATABASE IF NOT EXISTS `prwb_1819_pg08` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `prwb_1819_pg08`;

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `isbn` char(13) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `editor` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `book`
--

INSERT INTO `book` (`id`, `isbn`, `title`, `author`, `editor`, `picture`) VALUES
(10, '1234567890234', 'La Tresse', 'Laetitia Colombani', 'Le Livre de Poche', NULL),
(11, '1111111111123', 'LA famille parfaite', 'Lisa Gardne', 'Le livre de poch', NULL),
(12, '1111111111161', 'La dernière des Stanfield', 'Marc Lévy2 ', 'Pocket', NULL),
(15, '1111111111101', 'Symfony 1.2', 'Fabien Potencier', 'Les cahiers du Programmeur', NULL),
(16, '1111111111102', 'Réussir son site e-commerce', 'Sandrine Burriel', 'Avec osCommerce', NULL),
(17, '1111111111109', 'PHP/MySQL et JavaScript', 'Jean-René Rouet', 'Les cahiers du Programmeur', NULL),
(18, '1111111111104', 'PHP5', 'Stéphane Mariel', 'Les Cahiers du programmeur', NULL),
(19, '1111111111108', 'TYPO3', 'Maik Caro', 'Publication de contenus', NULL),
(20, '1111111111185', 'PHP à 200%', 'Jack-D Herrington', 'Le guide complet', NULL),
(21, '1111111111132', 'PHP et SQL', 'Guillaume Ponçon', 'Mémento', NULL),
(26, '9782746053533', 'Joomla! 1.5 - Coffret de 2 livres', 'Jean-Noël Anderruthy', 'Didier Mazier', NULL),
(38, '9782841772315', 'PHP en action', 'David Sklar ', '1111111111148', NULL),
(59, '9782744015069', 'PHP 4.X', 'Michel Dreyfus', 'Le tout en poche', NULL),
(87, '9782746404038', 'Vos premiers pas avec PHP 4', 'Jean Engels', 'Droit au but', NULL),
(88, '9782746040571', 'PHP 5 - MySQL 5 - AJAX', 'Arnaud GUÉRIN', 'Entraînez-vous', NULL),
(89, '9782212133394', 'Sécurité PHP 5 et MySQL', 'Damien Seguy', '3ème édition', NULL),
(90, '9782212128000', 'Performances PHP', 'Guillaume Plessis', 'LAMP', NULL),
(91, '9782742984473', 'Site web marchand', 'Marc Herellier', 'de A à Z', NULL),
(92, '7822121348037', 'PHP 5 Industrialisation', 'François Lépine', 'Outils', NULL),
(93, '9781904811404', 'Smarty', 'Lucian Gheorghe', 'Applications', NULL),
(94, '9781904811824', 'AJAX and PHP', 'Mihai Bucica', 'Building Responsive', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rental`
--

DROP TABLE IF EXISTS `rental`;
CREATE TABLE `rental` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `book` int(11) NOT NULL,
  `rentaldate` datetime DEFAULT NULL,
  `returndate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `rental`
--

INSERT INTO `rental` (`id`, `user`, `book`, `rentaldate`, `returndate`) VALUES
(445, 82, 11, '2019-05-16 17:17:46', '2019-06-13 06:50:46'),
(861, 99, 10, '2019-05-15 21:29:45', '2019-05-25 00:00:00'),
(869, 97, 12, '2019-05-26 21:31:47', '2019-06-13 16:40:24'),
(870, 97, 10, '2019-05-26 21:31:47', '2019-06-17 09:45:06'),
(872, 82, 12, '2019-05-16 17:17:46', '2019-06-13 17:43:55'),
(874, 97, 17, '2019-03-11 21:31:47', '2019-06-13 06:51:05'),
(910, 83, 21, '2019-04-24 00:00:00', '2019-05-29 00:00:00'),
(911, 83, 19, '2019-05-14 00:00:00', '2019-06-18 00:00:00'),
(931, 95, 18, '2019-06-03 07:56:13', NULL),
(950, 97, 20, NULL, NULL),
(976, 96, 20, NULL, NULL),
(1020, 97, 21, '2019-05-14 00:00:00', NULL),
(1021, 38, 87, '2019-05-20 00:00:00', NULL),
(1022, 99, 12, '2019-05-15 21:29:45', NULL),
(1023, 99, 26, '2019-05-15 21:29:45', '2019-06-17 09:45:08'),
(1024, 82, 59, NULL, NULL),
(1026, 95, 19, '2019-01-01 00:00:00', '2019-01-16 00:00:00'),
(1027, 99, 89, '2019-05-15 21:29:45', NULL),
(1028, 99, 87, '2019-05-15 21:29:45', NULL),
(1029, 99, 19, '2019-03-12 00:00:00', '2019-03-31 00:00:00'),
(1030, 99, 91, '2019-05-14 00:00:00', '2019-05-30 00:00:00'),
(1031, 83, 20, '2019-01-23 00:00:00', '2019-04-15 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(64) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `role` enum('admin','manager','member') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `email`, `birthdate`, `role`) VALUES
(14, 'Fabien4', 'f0cb425d8629e0167c97b45c802e2672', 'Fabien Hance', 'piperley@hotmail.com', '2019-01-10', 'member'),
(38, 'Fabien1', 'cfc22bce25c416e6bddb277393aa7e12', 'Fabien1', 'Fabien1@1.com', NULL, 'admin'),
(81, 'Fabien7', '10243c8ead6c5dd9318eaab6833066b8', 'Fabien6', 'Fabien7@6.com', '2019-04-17', 'member'),
(82, 'Fabien35', '74ed877d96ce494ebad26b835bbbe089', 'Fabien23', 'Fabien2@2.com', '2019-04-18', 'admin'),
(83, 'Fabien44', 'f10a4fe70d807b3b0177ee85c3696c22', 'Fabien4', 'Fabien4@2.com', '2019-04-17', 'member'),
(95, 'Fabien232', 'd27c65e0d68943a5ed4142163e58908e', 'Fabien23', 'Fabien23@23.com', '2019-04-11', 'member'),
(96, 'Fabien23', '9ff23d02b78d98fab3dd22333ed5f322', 'Fabien2', 'Manager1@13.com', '2019-05-15', 'admin'),
(97, 'Manager1', 'b9b69b246c5f6c31d5e5be15c3f42c77', 'Manager1', 'Manager1@1.com', NULL, 'manager'),
(98, 'Member1', 'eaf2c4d16994650fe74b93e9057cff50', 'Member1', 'Member1@1.com', NULL, 'member'),
(99, 'Administrateur2', '7cfb848098b5eaf68af1a715af61515d', 'Administrateur2', 'Administrateur2@2.com', '2019-05-17', 'admin'),
(100, 'Manager2', 'f8803a360962a7eadbbd1a13521e3270', 'Manager2', 'Manager2@2.com', '2019-05-18', 'manager'),
(101, 'Member2', '6db68f8d0760b3ccd0b6d916e978c031', 'Member2', 'Member2@2.com', NULL, 'member'),
(109, 'Fabien16', 'cfc22bce25c416e6bddb277393aa7e12', 'Fabien1', 'Fabien1@12.com', NULL, 'admin'),
(114, 'Fabien111', '7390ba562708c22faa32260aa91f69f7', 'Fabien111', 'fabien.hance@sky-hero.com', NULL, 'admin'),
(115, 'test', '71172e6db44b3949d5ff72c3729eb00d', 'testeur', 'test@gmail.com', NULL, 'member'),
(116, 'Administrateur1', '5501a287fd4ae1b4c2e98182aa37e570', 'Administrateur1', 'Administrateur1@1.com', NULL, 'admin');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn_UNIQUE` (`isbn`);

--
-- Index pour la table `rental`
--
ALTER TABLE `rental`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rentalitem_book1_idx` (`book`),
  ADD KEY `fk_rentalitem_user1_idx` (`user`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_unique` (`username`) USING BTREE,
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT pour la table `rental`
--
ALTER TABLE `rental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1032;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `rental`
--
ALTER TABLE `rental`
  ADD CONSTRAINT `fk_rentalitem_book` FOREIGN KEY (`book`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rentalitem_user1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
