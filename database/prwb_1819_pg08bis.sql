-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 26 Mai 2019 à 20:11
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
(6, '1111111111113', 'coucou cec', 'salutcdeced', 'heyutjycdecd', NULL),
(8, '1111111111145', 'La jeune fille et la nuit', 'Guillaume Musso', 'Calmann-Lévy', NULL),
(10, 'ISBN2485', 'La Tresse', 'Laetitia Colombani', 'Le Livre de Poche', 'php6.jpg'),
(11, '1111111111142', 'Famille parfaite', 'Lisa Gardner ', 'Le livre de poche', NULL),
(12, '1111111111143', 'La dernière des Stanfield', 'Marc Lévy2 ', 'Pocket', NULL),
(15, '1111111111101', 'Symfony 1.2', 'Fabien Potencier', 'Les cahiers du Programmeur', NULL),
(16, '1111111111102', 'Réussir son site e-commerce', 'Sandrine Burriel', 'Avec osCommerce', NULL),
(17, '1111111111105', 'PHP/MySQL et JavaScript', 'Jean-René Rouet', 'Les cahiers du Programmeur', NULL),
(18, '1111111111104', 'PHP5', 'Stéphane Mariel', 'Les Cahiers du programmeur', NULL),
(19, '1111111111108', 'TYPO3', 'Maik Caro', 'Publication de contenus', NULL),
(20, '1111111111167', 'PHP à 200%', 'Jack-D Herrington', 'Le guide complet', NULL),
(21, '1111111111132', 'PHP et SQL', 'Guillaume Ponçon', 'Mémento', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rental`
--

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
(445, 82, 11, '2019-05-16 17:17:46', '2019-04-18 00:00:00'),
(789, 81, 12, '2019-05-25 16:34:24', '2019-05-23 00:00:00'),
(819, 38, 8, '2019-02-07 10:34:17', '2019-05-26 05:20:00'),
(825, 81, 12, NULL, NULL),
(826, 81, 10, NULL, NULL),
(833, 38, 10, '2019-01-17 10:34:17', '2019-01-31 00:00:00'),
(835, 96, 10, '2019-05-26 13:44:08', '2019-05-26 01:44:47'),
(842, 96, 11, '2019-05-26 13:44:08', NULL),
(845, 1, 8, NULL, NULL),
(847, 38, 6, '2018-10-10 10:34:17', '2019-04-08 00:00:00'),
(855, 82, 6, '2019-02-11 17:17:46', NULL),
(857, 14, 8, NULL, NULL),
(859, 99, 11, '2019-03-20 21:29:45', NULL),
(860, 99, 6, '2019-05-26 21:29:45', NULL),
(861, 99, 10, '2019-05-15 21:29:45', '2019-05-25 00:00:00'),
(863, 101, 12, NULL, NULL),
(864, 100, 11, '2019-05-26 21:30:12', NULL),
(865, 100, 6, '2019-05-26 21:30:12', NULL),
(866, 95, 11, NULL, NULL),
(867, 101, 10, NULL, NULL),
(868, 97, 6, '2019-03-11 21:31:47', '2019-04-09 00:00:00'),
(869, 97, 12, '2019-05-26 21:31:47', NULL),
(870, 97, 10, '2019-05-26 21:31:47', NULL),
(871, 99, 8, '2019-01-01 21:29:45', '2019-03-11 00:00:00'),
(872, 82, 12, '2019-05-16 17:17:46', NULL),
(873, 38, 15, '2019-02-07 10:34:17', NULL),
(874, 97, 17, '2019-03-11 21:31:47', NULL),
(875, 97, 11, '2019-03-11 21:31:47', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

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
(1, 'Administrateur1', 'c6aa01bd261e501b1fea93c41fe46dc7', 'Administrateur1', 'Administrateur1@1.com', '2019-05-24', 'admin'),
(14, 'Fabien3', 'f0cb425d8629e0167c97b45c802e2672', 'Fabien H3', 'piperley@hotmail.com', '2019-01-10', 'member'),
(38, 'Fabien1', 'cfc22bce25c416e6bddb277393aa7e12', 'Fabien1', 'Fabien1@1.com', NULL, 'admin'),
(81, 'Fabien7', '10243c8ead6c5dd9318eaab6833066b8', 'Fabien6', 'Fabien7@6.com', '2019-04-17', 'member'),
(82, 'Fabien2', '74ed877d96ce494ebad26b835bbbe089', 'Fabien23', 'Fabien2@2.com', '2019-04-18', 'manager'),
(83, 'Fabien44', 'f10a4fe70d807b3b0177ee85c3696c22', 'Fabien4', 'Fabien4@4.com', '2019-04-17', 'member'),
(95, 'Fabien2325', 'd27c65e0d68943a5ed4142163e58908e', 'Fabien23', 'Fabien23@23.com', '2019-04-11', 'member'),
(96, 'Fabien23', '9ff23d02b78d98fab3dd22333ed5f322', 'Fabien23', 'Fabien23@2323.com', '2019-05-15', 'admin'),
(97, 'Manager1', 'b9b69b246c5f6c31d5e5be15c3f42c77', 'Manager1', 'Manager1@1.com', NULL, 'manager'),
(98, 'Member1', 'eaf2c4d16994650fe74b93e9057cff50', 'Member1', 'Member1@1.com', NULL, 'member'),
(99, 'Administrateur2', '7cfb848098b5eaf68af1a715af61515d', 'Administrateur2', 'Administrateur2@2.com', '2019-05-17', 'admin'),
(100, 'Manager2', 'f8803a360962a7eadbbd1a13521e3270', 'Manager2', 'Manager2@2.com', '2019-05-18', 'manager'),
(101, 'Member2', '6db68f8d0760b3ccd0b6d916e978c031', 'Member2', 'Member2@2.com', NULL, 'member');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `rental`
--
ALTER TABLE `rental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=876;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
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
