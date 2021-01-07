-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 07 jan. 2021 à 23:27
-- Version du serveur :  8.0.21
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bddprojet`
--

-- --------------------------------------------------------

--
-- Structure de la table `borrow`
--

DROP TABLE IF EXISTS `borrow`;
CREATE TABLE IF NOT EXISTS `borrow` (
  `id_user` int NOT NULL,
  `id_device` int NOT NULL,
  `id_borrow` int NOT NULL,
  PRIMARY KEY (`id_user`,`id_device`,`id_borrow`),
  KEY `borrow_device0_FK` (`id_device`),
  KEY `borrow_borrow_info1_FK` (`id_borrow`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Structure de la table `borrow_info`
--

DROP TABLE IF EXISTS `borrow_info`;
CREATE TABLE IF NOT EXISTS `borrow_info` (
  `id_borrow` int NOT NULL AUTO_INCREMENT,
  `startdate_borrow` date NOT NULL,
  `enddate_borrow` date NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_borrow`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Structure de la table `device`
--

DROP TABLE IF EXISTS `device`;
CREATE TABLE IF NOT EXISTS `device` (
  `id_device` int NOT NULL AUTO_INCREMENT,
  `isAvailable` tinyint(1) NOT NULL,
  `ref_equip` varchar(5) NOT NULL,
  PRIMARY KEY (`id_device`),
  KEY `device_equipment_FK` (`ref_equip`)
) ENGINE=InnoDB AUTO_INCREMENT=959 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Structure de la table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE IF NOT EXISTS `equipment` (
  `ref_equip` varchar(5) NOT NULL,
  `type_equip` varchar(30) NOT NULL,
  `brand_equip` varchar(30) NOT NULL,
  `name_equip` varchar(30) NOT NULL,
  `version_equip` varchar(15) NOT NULL,
  PRIMARY KEY (`ref_equip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Structure de la table `stock_photo`
--

DROP TABLE IF EXISTS `stock_photo`;
CREATE TABLE IF NOT EXISTS `stock_photo` (
  `link_photo` varchar(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ref_equip` varchar(5) NOT NULL,
  PRIMARY KEY (`link_photo`,`ref_equip`) USING BTREE,
  KEY `stock_photo_equipment_FK` (`ref_equip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `matricule_user` varchar(50) NOT NULL,
  `email_user` varchar(50) NOT NULL,
  `password_user` varchar(50) NOT NULL,
  `name_user` varchar(30) NOT NULL,
  `lastname_user` varchar(30) NOT NULL,
  `phone_user` varchar(13) DEFAULT NULL,
  `isAdmin_user` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `matricule_user`, `email_user`, `password_user`, `name_user`, `lastname_user`, `phone_user`, `isAdmin_user`) VALUES
(2, 'admin12', 'adad@adad.xn--adeez-fsa', '6c7ca345f63f835cb353ff15bd6c5e052ec08e7a', 'adminName', 'adminnLastNamesss', '', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrow_borrow_info1_FK` FOREIGN KEY (`id_borrow`) REFERENCES `borrow_info` (`id_borrow`),
  ADD CONSTRAINT `borrow_device0_FK` FOREIGN KEY (`id_device`) REFERENCES `device` (`id_device`),
  ADD CONSTRAINT `borrow_users_FK` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `device`
--
ALTER TABLE `device`
  ADD CONSTRAINT `device_equipment_FK` FOREIGN KEY (`ref_equip`) REFERENCES `equipment` (`ref_equip`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `stock_photo`
--
ALTER TABLE `stock_photo`
  ADD CONSTRAINT `stock_photo_equipment_FK` FOREIGN KEY (`ref_equip`) REFERENCES `equipment` (`ref_equip`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
