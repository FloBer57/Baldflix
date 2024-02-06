-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 04 fév. 2024 à 23:22
-- Version du serveur : 10.11.4-MariaDB-1~deb12u1
-- Version de PHP : 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `baldflix_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `categorie_ID` int(11) NOT NULL,
  `categorie_nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`categorie_ID`, `categorie_nom`) VALUES
(1, 'Anime'),
(2, 'Film'),
(3, 'Serie'),
(4, 'Spectacle'),
(5, 'Bald'),
(6, 'Action'),
(7, 'Comedies'),
(8, 'Courts-Metrages'),
(9, 'Documentaires'),
(10, 'Drames'),
(11, 'Européen'),
(12, 'Fantastique'),
(13, 'Français'),
(14, 'Horreur'),
(15, 'Indépendants'),
(16, 'Guerre'),
(17, 'Jeunesse et famille'),
(18, 'Musique et comédies musicales'),
(19, 'Noël'),
(20, 'Policier'),
(21, 'Thriller'),
(22, 'Romance'),
(23, 'SF'),
(24, 'Animation'),
(25, 'Westerns'),
(26, 'Dessin animé');

-- --------------------------------------------------------

--
-- Structure de la table `episode`
--

CREATE TABLE `episode` (
  `episode_ID` int(11) NOT NULL,
  `episode_title` varchar(255) NOT NULL,
  `episode_duree` time DEFAULT NULL,
  `episode_saison_ID` int(11) DEFAULT NULL,
  `episode_path` varchar(255) DEFAULT NULL,
  `episode_miniature_path` varchar(255) DEFAULT NULL,
  `episode_date_ajout` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

CREATE TABLE `film` (
  `film_ID` int(11) NOT NULL,
  `film_title` varchar(255) NOT NULL,
  `film_synopsis` text DEFAULT NULL,
  `film_duree` time DEFAULT NULL,
  `film_tags` varchar(255) DEFAULT NULL,
  `film_path` varchar(255) DEFAULT NULL,
  `film_image_path` varchar(255) DEFAULT NULL,
  `film_miniature_path` varchar(255) DEFAULT NULL,
  `film_date_ajout` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `film_categorie`
--

CREATE TABLE `film_categorie` (
  `filmXcategorie_ID` int(11) NOT NULL,
  `filmXcategorie_categorie_ID` int(11) DEFAULT NULL,
  `filmXcategorie_film_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `role_ID` int(11) NOT NULL,
  `role_nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role_ID`, `role_nom`) VALUES
(1, 'utilisateur'),
(2, 'admin'),
(3, 'démo');

-- --------------------------------------------------------

--
-- Structure de la table `saison`
--

CREATE TABLE `saison` (
  `saison_ID` int(11) NOT NULL,
  `saison_number` int(11) NOT NULL,
  `saison_serie_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `serie`
--

CREATE TABLE `serie` (
  `serie_ID` int(11) NOT NULL,
  `serie_title` varchar(255) NOT NULL,
  `serie_tags` varchar(255) DEFAULT NULL,
  `serie_image_path` varchar(255) DEFAULT NULL,
  `serie_synopsis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `serie_categorie`
--

CREATE TABLE `serie_categorie` (
  `serieXcategorie_ID` int(11) NOT NULL,
  `serieXcategorie_categorie_ID` int(11) DEFAULT NULL,
  `serieXcategorie_serie_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT '../image/users_icon/default.png',
  `user_role_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_film`
--

CREATE TABLE `user_film` (
  `userXfilm_ID` int(11) NOT NULL,
  `userXfilm_user_ID` int(11) DEFAULT NULL,
  `userXfilm_film_ID` int(11) DEFAULT NULL,
  `userXfilm_aime` tinyint(1) DEFAULT NULL,
  `userXfilm_watchTime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_serie`
--

CREATE TABLE `user_serie` (
  `userXserie_ID` int(11) NOT NULL,
  `userXserie_user_ID` int(11) DEFAULT NULL,
  `userXserie_serie_ID` int(11) DEFAULT NULL,
  `userXserie_aime` tinyint(1) DEFAULT NULL,
  `userXserie_watchTime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`categorie_ID`);

--
-- Index pour la table `episode`
--
ALTER TABLE `episode`
  ADD PRIMARY KEY (`episode_ID`),
  ADD KEY `episode_saison_ID` (`episode_saison_ID`);

--
-- Index pour la table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`film_ID`);

--
-- Index pour la table `film_categorie`
--
ALTER TABLE `film_categorie`
  ADD PRIMARY KEY (`filmXcategorie_ID`),
  ADD KEY `filmXcategorie_categorie_ID` (`filmXcategorie_categorie_ID`),
  ADD KEY `filmXcategorie_film_ID` (`filmXcategorie_film_ID`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_ID`);

--
-- Index pour la table `saison`
--
ALTER TABLE `saison`
  ADD PRIMARY KEY (`saison_ID`),
  ADD KEY `saison_serie_ID` (`saison_serie_ID`);

--
-- Index pour la table `serie`
--
ALTER TABLE `serie`
  ADD PRIMARY KEY (`serie_ID`);

--
-- Index pour la table `serie_categorie`
--
ALTER TABLE `serie_categorie`
  ADD PRIMARY KEY (`serieXcategorie_ID`),
  ADD KEY `serieXcategorie_categorie_ID` (`serieXcategorie_categorie_ID`),
  ADD KEY `serieXcategorie_serie_ID` (`serieXcategorie_serie_ID`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`),
  ADD KEY `id_role` (`user_role_ID`);

--
-- Index pour la table `user_film`
--
ALTER TABLE `user_film`
  ADD PRIMARY KEY (`userXfilm_ID`),
  ADD KEY `userXfilm_user_ID` (`userXfilm_user_ID`),
  ADD KEY `userXfilm_film_ID` (`userXfilm_film_ID`);

--
-- Index pour la table `user_serie`
--
ALTER TABLE `user_serie`
  ADD PRIMARY KEY (`userXserie_ID`),
  ADD KEY `userXserie_user_ID` (`userXserie_user_ID`),
  ADD KEY `userXserie_serie_ID` (`userXserie_serie_ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorie_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `episode`
--
ALTER TABLE `episode`
  MODIFY `episode_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=317;

--
-- AUTO_INCREMENT pour la table `film`
--
ALTER TABLE `film`
  MODIFY `film_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `film_categorie`
--
ALTER TABLE `film_categorie`
  MODIFY `filmXcategorie_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `saison`
--
ALTER TABLE `saison`
  MODIFY `saison_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT pour la table `serie`
--
ALTER TABLE `serie`
  MODIFY `serie_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT pour la table `serie_categorie`
--
ALTER TABLE `serie_categorie`
  MODIFY `serieXcategorie_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `user_film`
--
ALTER TABLE `user_film`
  MODIFY `userXfilm_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user_serie`
--
ALTER TABLE `user_serie`
  MODIFY `userXserie_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `episode`
--
ALTER TABLE `episode`
  ADD CONSTRAINT `episode_ibfk_1` FOREIGN KEY (`episode_saison_ID`) REFERENCES `saison` (`saison_ID`);

--
-- Contraintes pour la table `film_categorie`
--
ALTER TABLE `film_categorie`
  ADD CONSTRAINT `film_categorie_ibfk_1` FOREIGN KEY (`filmXcategorie_categorie_ID`) REFERENCES `categorie` (`categorie_ID`),
  ADD CONSTRAINT `film_categorie_ibfk_2` FOREIGN KEY (`filmXcategorie_film_ID`) REFERENCES `film` (`film_ID`);

--
-- Contraintes pour la table `saison`
--
ALTER TABLE `saison`
  ADD CONSTRAINT `saison_ibfk_1` FOREIGN KEY (`saison_serie_ID`) REFERENCES `serie` (`serie_ID`);

--
-- Contraintes pour la table `serie_categorie`
--
ALTER TABLE `serie_categorie`
  ADD CONSTRAINT `serie_categorie_ibfk_1` FOREIGN KEY (`serieXcategorie_categorie_ID`) REFERENCES `categorie` (`categorie_ID`),
  ADD CONSTRAINT `serie_categorie_ibfk_2` FOREIGN KEY (`serieXcategorie_serie_ID`) REFERENCES `serie` (`serie_ID`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_role_ID`) REFERENCES `role` (`role_ID`);

--
-- Contraintes pour la table `user_film`
--
ALTER TABLE `user_film`
  ADD CONSTRAINT `user_film_ibfk_1` FOREIGN KEY (`userXfilm_user_ID`) REFERENCES `user` (`user_ID`),
  ADD CONSTRAINT `user_film_ibfk_2` FOREIGN KEY (`userXfilm_film_ID`) REFERENCES `film` (`film_ID`);

--
-- Contraintes pour la table `user_serie`
--
ALTER TABLE `user_serie`
  ADD CONSTRAINT `user_serie_ibfk_1` FOREIGN KEY (`userXserie_user_ID`) REFERENCES `user` (`user_ID`),
  ADD CONSTRAINT `user_serie_ibfk_2` FOREIGN KEY (`userXserie_serie_ID`) REFERENCES `serie` (`serie_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
