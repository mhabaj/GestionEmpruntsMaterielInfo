-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 08 jan. 2021 à 23:33
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
