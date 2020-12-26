-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 26 déc. 2020 à 22:09
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
(2, 27, 1),
(2, 28, 2),
(2, 29, 3),
(2, 30, 4),
(2, 31, 5),
(2, 32, 6),
(2, 33, 7),
(2, 34, 8),
(2, 35, 9),
(2, 36, 10),
(2, 37, 11),
(2, 38, 12),
(2, 39, 13),
(2, 40, 14),
(2, 41, 15),
(2, 42, 16),
(2, 43, 17),
(2, 44, 18),
(2, 45, 19),
(2, 46, 20),
(2, 47, 21),
(2, 48, 22),
(2, 49, 23),
(2, 50, 24),
(2, 51, 25),
(2, 52, 26),
(2, 53, 27),
(2, 54, 28),
(2, 55, 29),
(2, 56, 30),
(2, 151, 31),
(2, 152, 32),
(2, 153, 33),
(2, 154, 34),
(2, 155, 35),
(2, 156, 36),
(2, 157, 37),
(2, 158, 38),
(2, 159, 39),
(2, 160, 40),
(2, 161, 41),
(2, 162, 42),
(2, 163, 43),
(2, 164, 44),
(2, 165, 45),
(2, 166, 46),
(2, 167, 47),
(2, 168, 48),
(2, 169, 49),
(2, 170, 50),
(2, 171, 51),
(2, 172, 52),
(2, 173, 53),
(2, 174, 54),
(2, 175, 55),
(2, 176, 56),
(2, 177, 57),
(2, 178, 58),
(2, 179, 59),
(2, 180, 60),
(2, 181, 61),
(2, 182, 62),
(2, 183, 63),
(2, 184, 64),
(2, 185, 65),
(2, 186, 66),
(2, 187, 67),
(2, 188, 68),
(2, 189, 69),
(2, 190, 70),
(2, 191, 71),
(2, 192, 72),
(2, 193, 73),
(2, 194, 74),
(2, 195, 75),
(2, 196, 76),
(2, 197, 77),
(2, 198, 78),
(2, 199, 79),
(2, 200, 80),
(2, 201, 81),
(2, 202, 82),
(2, 203, 83),
(2, 204, 84),
(2, 205, 85),
(2, 206, 86),
(2, 207, 87),
(2, 208, 88),
(2, 209, 89),
(2, 210, 90);

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
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `borrow_info`
--

INSERT INTO `borrow_info` (`id_borrow`, `startdate_borrow`, `enddate_borrow`, `isActive`) VALUES
(1, '2020-12-25', '2020-12-31', 1),
(2, '2020-12-25', '2020-12-31', 1),
(3, '2020-12-25', '2020-12-31', 1),
(4, '2020-12-25', '2021-01-09', 1),
(5, '2020-12-25', '2021-01-09', 1),
(6, '2020-12-25', '2020-12-30', 1),
(7, '2020-12-25', '2020-12-30', 1),
(8, '2020-12-25', '2020-12-30', 1),
(9, '2020-12-25', '2021-02-19', 1),
(10, '2020-12-25', '2021-02-19', 1),
(11, '2020-12-25', '2020-12-11', 1),
(12, '2020-12-25', '2020-12-19', 1),
(13, '2020-12-25', '2020-12-19', 1),
(14, '2020-12-25', '2020-12-19', 1),
(15, '2020-12-25', '2020-12-19', 1),
(16, '2020-12-25', '2020-12-19', 1),
(17, '2020-12-25', '2020-12-19', 1),
(18, '2020-12-25', '2020-12-19', 1),
(19, '2020-12-25', '2020-12-19', 1),
(20, '2020-12-25', '2020-12-23', 1),
(21, '2020-12-25', '2020-12-23', 1),
(22, '2020-12-25', '2020-12-17', 1),
(23, '2020-12-25', '2020-12-17', 1),
(24, '2020-12-25', '2020-12-17', 1),
(25, '2020-12-25', '2020-12-17', 1),
(26, '2020-12-25', '2020-12-17', 1),
(27, '2020-12-25', '2020-12-17', 1),
(28, '2020-12-25', '2020-12-17', 1),
(29, '2020-12-25', '2020-12-26', 1),
(30, '2020-12-25', '2020-12-26', 1),
(31, '2020-12-26', '2020-12-31', 1),
(32, '2020-12-26', '2020-12-31', 1),
(33, '2020-12-26', '2020-12-31', 1),
(34, '2020-12-26', '2020-12-31', 1),
(35, '2020-12-26', '2020-12-31', 1),
(36, '2020-12-26', '2020-12-31', 1),
(37, '2020-12-26', '2020-12-31', 1),
(38, '2020-12-26', '2020-12-30', 1),
(39, '2020-12-26', '2020-12-30', 1),
(40, '2020-12-26', '2020-12-30', 1),
(41, '2020-12-26', '2020-12-30', 1),
(42, '2020-12-26', '2020-12-30', 1),
(43, '2020-12-26', '2020-12-30', 1),
(44, '2020-12-26', '2020-12-30', 1),
(45, '2020-12-26', '2020-12-30', 1),
(46, '2020-12-26', '2020-12-30', 1),
(47, '2020-12-26', '2020-12-30', 1),
(48, '2020-12-26', '2020-12-30', 1),
(49, '2020-12-26', '2020-12-30', 1),
(50, '2020-12-26', '2020-12-30', 1),
(51, '2020-12-26', '2020-12-30', 1),
(52, '2020-12-26', '2020-12-30', 1),
(53, '2020-12-26', '2020-12-30', 1),
(54, '2020-12-26', '2020-12-30', 1),
(55, '2020-12-26', '2020-12-30', 1),
(56, '2020-12-26', '2020-12-30', 1),
(57, '2020-12-26', '2020-12-30', 1),
(58, '2020-12-26', '2020-12-30', 1),
(59, '2020-12-26', '2020-12-30', 1),
(60, '2020-12-26', '2020-12-30', 1),
(61, '2020-12-26', '2020-12-30', 1),
(62, '2020-12-26', '2020-12-30', 1),
(63, '2020-12-26', '2020-12-30', 1),
(64, '2020-12-26', '2020-12-30', 1),
(65, '2020-12-26', '2020-12-30', 1),
(66, '2020-12-26', '2020-12-30', 1),
(67, '2020-12-26', '2020-12-30', 1),
(68, '2020-12-26', '2020-12-30', 1),
(69, '2020-12-26', '2020-12-30', 1),
(70, '2020-12-26', '2020-12-30', 1),
(71, '2020-12-26', '2020-12-29', 1),
(72, '2020-12-26', '2020-12-29', 1),
(73, '2020-12-26', '2020-12-29', 1),
(74, '2020-12-26', '2020-12-29', 1),
(75, '2020-12-26', '2020-12-29', 1),
(76, '2020-12-26', '2020-12-29', 1),
(77, '2020-12-26', '2020-12-29', 1),
(78, '2020-12-26', '2020-12-29', 1),
(79, '2020-12-26', '2020-12-29', 1),
(80, '2020-12-26', '2020-12-29', 1),
(81, '2020-12-26', '2020-12-28', 1),
(82, '2020-12-26', '2020-12-28', 1),
(83, '2020-12-26', '2020-12-28', 1),
(84, '2020-12-26', '2020-12-28', 1),
(85, '2020-12-26', '2020-12-28', 1),
(86, '2020-12-26', '2020-12-28', 1),
(87, '2020-12-26', '2020-12-28', 1),
(88, '2020-12-26', '2020-12-28', 1),
(89, '2020-12-26', '2020-12-28', 1),
(90, '2020-12-26', '2020-12-28', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=361 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `device`
--

INSERT INTO `device` (`id_device`, `isAvailable`, `ref_equip`) VALUES
(27, 0, 'XX554'),
(28, 0, 'XX554'),
(29, 0, 'XX554'),
(30, 0, 'XX554'),
(31, 0, 'XX554'),
(32, 0, 'XX554'),
(33, 0, 'XX554'),
(34, 0, 'XX554'),
(35, 0, 'XX554'),
(36, 0, 'XX554'),
(37, 0, 'XX554'),
(38, 0, 'XX554'),
(39, 0, 'XX554'),
(40, 0, 'XX554'),
(41, 0, 'XX554'),
(42, 0, 'XX554'),
(43, 0, 'XX554'),
(44, 0, 'XX554'),
(45, 0, 'XX554'),
(46, 0, 'XX554'),
(47, 0, 'XX554'),
(48, 0, 'XX554'),
(49, 0, 'XX554'),
(50, 0, 'XX554'),
(51, 0, 'XX554'),
(52, 0, 'XX554'),
(53, 0, 'XX554'),
(54, 0, 'XX554'),
(55, 0, 'XX554'),
(56, 0, 'XX554'),
(151, 0, 'XX554'),
(152, 0, 'XX554'),
(153, 0, 'XX554'),
(154, 0, 'XX554'),
(155, 0, 'XX554'),
(156, 0, 'XX554'),
(157, 0, 'XX554'),
(158, 0, 'XX554'),
(159, 0, 'XX554'),
(160, 0, 'XX554'),
(161, 0, 'XX554'),
(162, 0, 'XX554'),
(163, 0, 'XX554'),
(164, 0, 'XX554'),
(165, 0, 'XX554'),
(166, 0, 'XX554'),
(167, 0, 'XX554'),
(168, 0, 'XX554'),
(169, 0, 'XX554'),
(170, 0, 'XX554'),
(171, 0, 'XX554'),
(172, 0, 'XX554'),
(173, 0, 'XX554'),
(174, 0, 'XX554'),
(175, 0, 'XX554'),
(176, 0, 'XX554'),
(177, 0, 'XX554'),
(178, 0, 'XX554'),
(179, 0, 'XX554'),
(180, 0, 'XX554'),
(181, 0, 'XX554'),
(182, 0, 'XX554'),
(183, 0, 'XX554'),
(184, 0, 'XX554'),
(185, 0, 'XX554'),
(186, 0, 'XX554'),
(187, 0, 'XX554'),
(188, 0, 'XX554'),
(189, 0, 'XX554'),
(190, 0, 'XX554'),
(191, 0, 'XX554'),
(192, 0, 'XX554'),
(193, 0, 'XX554'),
(194, 0, 'XX554'),
(195, 0, 'XX554'),
(196, 0, 'XX554'),
(197, 0, 'XX554'),
(198, 0, 'XX554'),
(199, 0, 'XX554'),
(200, 0, 'XX554'),
(201, 0, 'XX554'),
(202, 0, 'XX554'),
(203, 0, 'XX554'),
(204, 0, 'XX554'),
(205, 0, 'XX554'),
(206, 0, 'XX554'),
(207, 0, 'XX554'),
(208, 0, 'XX554'),
(209, 0, 'XX554'),
(210, 0, 'XX554'),
(211, 1, 'XX554'),
(212, 1, 'XX554'),
(213, 1, 'XX554'),
(214, 1, 'XX554'),
(215, 1, 'XX554'),
(216, 1, 'XX554'),
(217, 1, 'XX554'),
(218, 1, 'XX554'),
(219, 1, 'XX554'),
(220, 1, 'XX554'),
(221, 1, 'XX554'),
(222, 1, 'XX554'),
(223, 1, 'XX554'),
(224, 1, 'XX554'),
(225, 1, 'XX554'),
(226, 1, 'XX554'),
(227, 1, 'XX554'),
(228, 1, 'XX554'),
(229, 1, 'XX554'),
(230, 1, 'XX554'),
(231, 1, 'XX554'),
(232, 1, 'XX554'),
(233, 1, 'XX554'),
(234, 1, 'XX554'),
(235, 1, 'XX554'),
(236, 1, 'XX554'),
(237, 1, 'XX554'),
(238, 1, 'XX554'),
(239, 1, 'XX554'),
(240, 1, 'XX554'),
(241, 1, 'XX554'),
(242, 1, 'XX554'),
(243, 1, 'XX554'),
(244, 1, 'XX554'),
(245, 1, 'XX554'),
(246, 1, 'XX554'),
(247, 1, 'XX554'),
(248, 1, 'XX554'),
(249, 1, 'XX554'),
(250, 1, 'XX554'),
(251, 1, 'XX554'),
(252, 1, 'XX554'),
(253, 1, 'XX554'),
(254, 1, 'XX554'),
(255, 1, 'XX554'),
(256, 1, 'XX554'),
(257, 1, 'XX554'),
(258, 1, 'XX554'),
(259, 1, 'XX554'),
(260, 1, 'XX554'),
(261, 1, 'XX554'),
(262, 1, 'XX554'),
(263, 1, 'XX554'),
(264, 1, 'XX554'),
(265, 1, 'XX554'),
(266, 1, 'XX554'),
(267, 1, 'XX554'),
(268, 1, 'XX554'),
(269, 1, 'XX554'),
(270, 1, 'XX554'),
(271, 1, 'XX554'),
(272, 1, 'XX554'),
(273, 1, 'XX554'),
(274, 1, 'XX554'),
(275, 1, 'XX554'),
(276, 1, 'XX554'),
(277, 1, 'XX554'),
(278, 1, 'XX554'),
(279, 1, 'XX554'),
(280, 1, 'XX554'),
(281, 1, 'XX111'),
(282, 1, 'XX111'),
(283, 1, 'XX111'),
(284, 1, 'XX111'),
(285, 1, 'XX999'),
(286, 1, 'XX999'),
(287, 1, 'XX999'),
(288, 1, 'XX999'),
(289, 1, 'XX999'),
(290, 1, 'XX999'),
(291, 1, 'XX999'),
(292, 1, 'XX999'),
(293, 1, 'XX999'),
(294, 1, 'XX999'),
(295, 1, 'XX125'),
(296, 1, 'XX125'),
(297, 1, 'XX125'),
(298, 1, 'XX125'),
(299, 1, 'XX125'),
(310, 1, 'XX564'),
(311, 1, 'XX568'),
(312, 1, 'XX426'),
(313, 1, 'XX426'),
(314, 1, 'XX426'),
(315, 1, 'XX426'),
(316, 1, 'XX426'),
(317, 1, 'XX426'),
(318, 1, 'XX426'),
(319, 1, 'XX422'),
(320, 1, 'XX422'),
(321, 1, 'XX422'),
(322, 1, 'XX422'),
(323, 1, 'XX422'),
(324, 1, 'XX422'),
(325, 1, 'XX422'),
(326, 1, 'XX421'),
(327, 1, 'XX421'),
(328, 1, 'XX421'),
(329, 1, 'XX421'),
(330, 1, 'XX421'),
(331, 1, 'XX421'),
(332, 1, 'XX421'),
(333, 1, 'AP154'),
(334, 1, 'AP154'),
(335, 1, 'AP154'),
(336, 1, 'AP154'),
(337, 1, 'AP154'),
(338, 1, 'AP154'),
(339, 1, 'AP154'),
(340, 1, 'AP154'),
(341, 1, 'XX587'),
(342, 1, 'XX587'),
(343, 1, 'XX587'),
(344, 1, 'XX587'),
(345, 1, 'XX587'),
(346, 1, 'XX587'),
(347, 1, 'XX587'),
(348, 1, 'XX587'),
(349, 1, 'XX587'),
(350, 1, 'XX587'),
(351, 1, 'XX584'),
(352, 1, 'XX584'),
(353, 1, 'XX584'),
(354, 1, 'XX584'),
(355, 1, 'XX584'),
(356, 1, 'XX584'),
(357, 1, 'XX584'),
(358, 1, 'XX584'),
(359, 1, 'XX584'),
(360, 1, 'XX584');

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
('AP154', 'Laptop', 'Apple', 'Macbook Air', '1.0'),
('XX111', 'smartphone', 'Samsung', 'GalaxyS10', 'PLUS'),
('XX125', 'Tablette.', 'Microsoft-.', 'Surface-Pro.', '13p-.'),
('XX126', 'Tablette', 'Microsoft', 'Surface Pro', '15p'),
('XX421', 'Souris', 'Razer', 'DeathAdder', '1.0'),
('XX422', 'ConsoleNextGen', 'Razer', 'DeathAdder', '1.0'),
('XX426', 'Mouse', 'Razer', 'DeathAdder', '1.0'),
('XX554', 'Console', 'Sony', 'PlayStation 5', '1.0'),
('XX564', 'Console', 'Sony', 'PS5 pro', 'FAT'),
('XX568', 'Console', 'Sony', 'PS5 pro', 'FAT'),
('XX584', 'Voiture', 'Ford', 'Fiesta', '2019'),
('XX587', 'Voiture', 'Ford', 'Fiesta', '2018'),
('XX999', 'Laptop', 'Dell', 'Inspiron 7577', 'GTX1060 15p');

-- --------------------------------------------------------

--
-- Structure de la table `stock_photo`
--

DROP TABLE IF EXISTS `stock_photo`;
CREATE TABLE IF NOT EXISTS `stock_photo` (
  `link_photo` varchar(50) NOT NULL,
  `ref_equip` varchar(5) NOT NULL,
  PRIMARY KEY (`link_photo`),
  KEY `stock_photo_equipment_FK` (`ref_equip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `stock_photo`
--

INSERT INTO `stock_photo` (`link_photo`, `ref_equip`) VALUES
('assets/photos/ps5.jpg', 'XX554');

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
  `phone_user` int DEFAULT NULL,
  `isAdmin_user` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `matricule_user`, `email_user`, `password_user`, `name_user`, `lastname_user`, `phone_user`, `isAdmin_user`) VALUES
(2, 'admin12', 'adad@adad.ad', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'adminName', 'adminnLastName', NULL, 1);

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
