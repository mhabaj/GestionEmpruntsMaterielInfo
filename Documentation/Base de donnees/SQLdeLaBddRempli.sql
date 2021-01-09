-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 09 jan. 2021 à 01:20
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
-- Déchargement des données de la table `borrow`
--

INSERT INTO `borrow` (`id_user`, `id_device`, `id_borrow`) VALUES
(7, 989, 251),
(7, 990, 252),
(7, 991, 253),
(7, 992, 254),
(7, 993, 255),
(7, 994, 256),
(7, 995, 257),
(7, 996, 258),
(7, 997, 259),
(7, 998, 260),
(6, 1019, 250),
(6, 1069, 248),
(6, 1070, 249);

-- --------------------------------------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `borrow_info`
--

INSERT INTO `borrow_info` (`id_borrow`, `startdate_borrow`, `enddate_borrow`, `isActive`) VALUES
(248, '2021-01-09', '2021-01-28', 1),
(249, '2021-01-09', '2021-01-28', 1),
(250, '2021-01-09', '2021-01-28', 1),
(251, '2021-01-09', '2021-02-07', 1),
(252, '2021-01-09', '2021-02-07', 1),
(253, '2021-01-09', '2021-02-07', 1),
(254, '2021-01-09', '2021-02-07', 1),
(255, '2021-01-09', '2021-02-07', 1),
(256, '2021-01-09', '2021-02-07', 1),
(257, '2021-01-09', '2021-02-07', 1),
(258, '2021-01-09', '2021-02-07', 1),
(259, '2021-01-09', '2021-02-07', 1),
(260, '2021-01-09', '2021-02-07', 1);

-- --------------------------------------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=1074 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `device`
--

INSERT INTO `device` (`id_device`, `isAvailable`, `ref_equip`) VALUES
(959, 1, 'AN552'),
(960, 1, 'AN552'),
(961, 1, 'AN552'),
(962, 1, 'AN552'),
(963, 1, 'AN552'),
(964, 1, 'AN552'),
(965, 1, 'AN552'),
(966, 1, 'AN552'),
(967, 1, 'AN552'),
(968, 1, 'AN552'),
(969, 1, 'AN552'),
(970, 1, 'AN552'),
(971, 1, 'AN552'),
(972, 1, 'AN552'),
(973, 1, 'AN552'),
(974, 1, 'AN552'),
(975, 1, 'AN552'),
(976, 1, 'AN552'),
(977, 1, 'AN552'),
(978, 1, 'AN552'),
(979, 1, 'AP368'),
(980, 1, 'AP368'),
(981, 1, 'AP368'),
(982, 1, 'AP368'),
(983, 1, 'AP368'),
(984, 1, 'AP368'),
(985, 1, 'AP368'),
(986, 1, 'AP368'),
(987, 1, 'AP368'),
(988, 1, 'AP368'),
(989, 0, 'AN756'),
(990, 0, 'AN756'),
(991, 0, 'AN756'),
(992, 0, 'AN756'),
(993, 0, 'AN756'),
(994, 0, 'AN756'),
(995, 0, 'AN756'),
(996, 0, 'AN756'),
(997, 0, 'AN756'),
(998, 0, 'AN756'),
(999, 1, 'AN756'),
(1000, 1, 'AN756'),
(1001, 1, 'AN756'),
(1002, 1, 'AN756'),
(1003, 1, 'AN756'),
(1004, 1, 'AN756'),
(1005, 1, 'AN756'),
(1006, 1, 'AN756'),
(1007, 1, 'AN756'),
(1008, 1, 'AN756'),
(1009, 1, 'AN756'),
(1010, 1, 'AN756'),
(1011, 1, 'AN756'),
(1012, 1, 'AN756'),
(1013, 1, 'AN756'),
(1014, 1, 'AN756'),
(1015, 1, 'AN756'),
(1016, 1, 'AN756'),
(1017, 1, 'AN756'),
(1018, 1, 'AN756'),
(1019, 0, 'XX123'),
(1020, 1, 'XX123'),
(1021, 1, 'XX123'),
(1022, 1, 'XX123'),
(1023, 1, 'XX123'),
(1024, 1, 'XX123'),
(1025, 1, 'XX123'),
(1026, 1, 'XX123'),
(1027, 1, 'XX123'),
(1028, 1, 'XX123'),
(1029, 1, 'XX123'),
(1030, 1, 'XX123'),
(1031, 1, 'XX123'),
(1032, 1, 'XX123'),
(1033, 1, 'XX123'),
(1034, 1, 'XX123'),
(1035, 1, 'XX123'),
(1036, 1, 'XX123'),
(1037, 1, 'XX123'),
(1038, 1, 'XX123'),
(1039, 1, 'XX123'),
(1040, 1, 'XX123'),
(1041, 1, 'XX123'),
(1042, 1, 'XX123'),
(1043, 1, 'XX123'),
(1044, 1, 'XX123'),
(1045, 1, 'XX123'),
(1046, 1, 'XX123'),
(1047, 1, 'XX123'),
(1048, 1, 'XX123'),
(1049, 1, 'XX123'),
(1050, 1, 'XX123'),
(1051, 1, 'XX123'),
(1052, 1, 'XX123'),
(1053, 1, 'XX123'),
(1054, 1, 'XX123'),
(1055, 1, 'XX123'),
(1056, 1, 'XX123'),
(1057, 1, 'XX123'),
(1058, 1, 'XX123'),
(1059, 1, 'XX123'),
(1060, 1, 'XX123'),
(1061, 1, 'XX123'),
(1062, 1, 'XX123'),
(1063, 1, 'XX123'),
(1064, 1, 'XX123'),
(1065, 1, 'XX123'),
(1066, 1, 'XX123'),
(1067, 1, 'XX123'),
(1068, 1, 'XX123'),
(1069, 0, 'XX456'),
(1070, 0, 'XX456'),
(1071, 1, 'XX456'),
(1072, 1, 'XX456'),
(1073, 1, 'XX456');

-- --------------------------------------------------------

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
-- Déchargement des données de la table `equipment`
--

INSERT INTO `equipment` (`ref_equip`, `type_equip`, `brand_equip`, `name_equip`, `version_equip`) VALUES
('AN552', 'Smartphone', 'Samsung', 'Samsung Galaxy S10', '8.0'),
('AN756', 'Tablette', 'Samsung', 'Samsung Galaxy Tab 2', '2.6.4'),
('AP368', 'Smartphone', 'Apple', 'Iphone 16', '15.0'),
('XX123', 'Camera', 'Logitech', 'Camera HD C920', '3.4.1'),
('XX456', 'Ecran', 'OAC', 'Ecran OAC 24 pouces 144Hz', '1.3.8');

-- --------------------------------------------------------

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
-- Déchargement des données de la table `stock_photo`
--

INSERT INTO `stock_photo` (`link_photo`, `ref_equip`) VALUES
('', 'AN552'),
('assets/images/Smartphone/samsungS10.jpg', 'AN552'),
('', 'AN756'),
('assets/images/Tablette/samsunggalaxytab2.jpg', 'AN756'),
('', 'AP368'),
('assets/images/Smartphone/iphone11.jpg', 'AP368'),
('', 'XX123'),
('assets/images/Camera/logitechc920.jpg', 'XX123'),
('', 'XX456'),
('assets/images/Ecran/ecranOAC24pouces.jpg', 'XX456');

-- --------------------------------------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `matricule_user`, `email_user`, `password_user`, `name_user`, `lastname_user`, `phone_user`, `isAdmin_user`) VALUES
(5, 'admin12', 'admindu21@gmail.com', '38f078a81a2b033d197497af5b77f95b50bfcfb8', 'Mahmoud', 'Alhabaj', NULL, 1),
(6, 'client1', 'client@hotmail.com', 'd642fef420c5baa4c72f53de9426f1ed699899e2', 'Nahcute', 'Mahoufal', NULL, 0),
(7, 'client2', 'client2@gmail.com', '0cf3a452af4baf920c5e381be5f542007639a275', 'dupont', 'tom', '0766666666', 0),
(8, 'admin34', 'admin34@gmail.com', '1d9f16659dc79165f49f7ece7aff1742ac68a906', 'anica', 'sean', '0212345678', 1);

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
