-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 09 Avril 2019 à 20:24
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
(1, '1234567891234', 'coucou ', 'salut', 'hey', NULL),
(4, '1111', 'jh', 'salutcdeced', 'heyutjycdecd', 'téléchargement.jpg'),
(5, '1234567891011', 'Un appartement à Paris', 'Guillaume Musso', 'Pocket', NULL),
(6, 'vrfe', 'coucou cec', 'salutcdeced', 'heyutjycdecd', NULL),
(7, 'isbn12345', 'Ta deuxième vie commence quand tu comprends que tu n\'en as qu\'une', 'Raphaëlle Giordano ', 'Pocket', NULL),
(8, 'isbn23456', 'La jeune fille et la nuit', 'Guillaume Musso', 'Calmann-Lévy', NULL),
(9, 'ISBN3579', 'La disparition de Stéphanie Mailer', 'Joël Dicker ', 'Editions de Fallois', NULL),
(10, 'ISBN2485', 'La Tresse', 'Laetitia Colombani', 'Le Livre de Poche', NULL),
(11, 'ISNB086421', 'Famille parfaite', 'Lisa Gardner ', 'Le livre de poche', NULL),
(12, 'ISBN805731', 'La dernière des Stanfield', 'Marc Lévy ', 'Pocket', NULL);

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
(1, 'admin', 'c6aa01bd261e501b1fea93c41fe46dc7', 'Administrateur', 'admin@test.com', NULL, 'admin'),
(14, 'Fabien3', 'f0cb425d8629e0167c97b45c802e2672', 'Fabien H', 'piperley@hotmail.com', '2019-01-10', 'member'),
(38, 'Fabien1', 'cfc22bce25c416e6bddb277393aa7e12', 'Fabien1', 'Fabien1@1.com', NULL, 'admin'),
(81, 'Fabien7', '10243c8ead6c5dd9318eaab6833066b8', 'Fabien6', 'Fabien7@6.com', '2019-04-17', 'member'),
(82, 'Fabien2', '74ed877d96ce494ebad26b835bbbe089', 'Fabien2', 'Fabien2@2.com', '2019-04-18', 'member'),
(83, 'Fabien4', 'f10a4fe70d807b3b0177ee85c3696c22', 'Fabien4', 'Fabien4@4.com', NULL, 'member');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `rental`
--
ALTER TABLE `rental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
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
