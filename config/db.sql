SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `p5`
--
DROP DATABASE IF EXISTS `p5`;
CREATE DATABASE `blog` CHARACTER SET utf8;

USE `p5`;

-- --------------------------------------------------------
--
-- Structure de la table `role`
--
CREATE TABLE `role` (
                        `id` smallint(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                        `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------
--
-- Structure de la table `user`
--
CREATE TABLE `user` (
                        `id` smallint(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                        `pseudo` varchar(100) NOT NULL,
                        `password` varchar(60) NOT NULL,
                        `createdAt` datetime NOT NULL,
                        `role_id` smallint(11) UNSIGNED NOT NULL,
                        `email` varchar(255) NOT NULL,
                        CONSTRAINT      `user_fk_role_id`  FOREIGN KEY (`role_id`)    REFERENCES  `role`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------
--
-- Déchargement des données de la table `role`
--
INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'standard');
-- --------------------------------------------------------
--
-- Déchargement des données de la table `user`
--
INSERT INTO `user` (`id`, `pseudo`, `password`, `createdAt`, `role_id`, `email`) VALUES
(1, 'admin', '$2y$10$spsXmA73UvHzNzAJN6qVke9nppqH39ZkRZLOf4/QY7AhsxynZIq0K', '2020-06-05 15:00:17', 1, 'admin@admin.com'),
(16, 'Jean Forteroche', '$2y$10$tPu8hJik/.Q1vWpaevwDHeA5swX9pFCe2VMJcMAdqAZ2HvDgNnHGa', '2020-06-15 08:22:30', 1, 'jeanforteroche@email.com'),
(17, 'Lucille Marillion', '$2y$10$cxcgnAwFeRtY8FXm2kcdgekV5sLR83klAKsvY60VxwV.U9KmkjLfG', '2020-07-05 08:24:04', 2, 'lucillemarillion@email.com'),
(18, '@n0nym0u5', '$2y$10$1MS8xi3Rb66pMppJmMgrwOsUyoxNlvJYqyHmCBxkgDcSK/2SB80g2', '2020-07-08 08:24:33', 2, 'gae50@vmani.com'),
(19, 'nicolas-lepetit', '$2y$10$FOlUypI3dI.v44ccLlF70uz5pV9oiQQpoVHYzLYrcnc5kmdN3mMHW', '2020-08-01 08:27:13', 2, 'lepetitnicolas@email.com'),
(20, 'jeangiono', '$2y$10$fHPYzsPA8xt61D/WEOSiHORTOKpx/qNjMGewPtwSF7YS/5fsWoDGu', '2020-07-27 08:27:41', 2, 'jeangiono@email.com');