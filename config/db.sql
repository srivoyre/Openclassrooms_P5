--
-- Base de données : `p5`
--
DROP DATABASE IF EXISTS `p5`;
CREATE DATABASE `p5` CHARACTER SET utf8;

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
-- Structure de la table `saved-joke`
--
CREATE TABLE `savedJoke` (
                        `id` smallint(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                        `joke_api_id` smallint(11) NOT NULL,
                        `user_id` smallint(11) UNSIGNED NOT NULL,
                        `createdAt` datetime NOT NULL,
                        CONSTRAINT      `savedJoke_fk_user_id`  FOREIGN KEY (`user_id`)    REFERENCES  `user`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------
--
-- Structure de la table `flagged-joke`
--
CREATE TABLE `flaggedJoke` (
                        `id` smallint(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                        `joke_api_id` smallint(11) NOT NULL,
                        `flag_count` smallint(11) NOT NULL,
                        `filtered` tinyint(1) NOT NULL DEFAULT '0',
                        `createdAt` datetime NOT NULL
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
(1, 'admin', '$2y$10$spsXmA73UvHzNzAJN6qVke9nppqH39ZkRZLOf4/QY7AhsxynZIq0K', '2020-06-05 15:00:17', 1, 'admin@admin.com');