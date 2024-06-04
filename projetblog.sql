-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 29 Janvier 2023 à 17:21
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_blog`
--
CREATE DATABASE IF NOT EXISTS `projet_blog` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `projet_blog`;

-- --------------------------------------------------------

--
-- Structure de la table `billet`
--

CREATE TABLE `billet` (
  `id` int(11) NOT NULL,
  `titre` varchar(60) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `billet`
--

INSERT INTO `billet` (`id`, `titre`, `content`, `date`, `image`) VALUES
(42, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nibh dolor, viverra sed consectetur in, sodales nec tortor. Proin non massa metus. Cras suscipit molAlis porttitor. Pellentesque viverra aliquet nunc et tristique. Nullam faucibus aliquet orci, sit amet rhoncus mi maximus sit amet. Cras rhoncus luctus libero, id imperdiet eros lacinia ut. Proin et sapien ut leo faucibus laoreet quis id lectus.\n<br><br>\nCras vitae sem dui. Fusce at turpis orci. Sed consequat auctor justo in fringilla. Praesent justo sem, bibendum a efficitur eget, porta id est. Fusce interdum eros non turpis lacinia rutrum. Ut vehicula urna vehicula accumsan faucibus. Nullam elit nunc, fringilla a felis ac, sagittis lobortis metus. Nam nec sagittis leo.\n<br><br>\nPraesent lobortis augue nisl, interdum aliquam nisi rutrum a. Sed malesuada sit amet odio ut ullamcorper. Aliquam commodo sed quam quis placerat. Quisque viverra, turpis eget consectetur vestibulum, nisl orci rutrum est, vestibulum sollicitudin augue tortor id lacus. Nam congue tristique dolor, ac faucibus ipsum aliquam eget. Donec nec nisl bibendum, aliquet sapien eu, euismod nisl. Aliquam erat volutpat. Praesent sed suscipit velit, sed maximus quam. In eu ullamcorper dolor, in cursus neque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris ut velit viverra, efficitur erat tempor, dapibus quam. Donec id porta purus. Pellentesque quis tellus ullamcorper augue rutrum placerat. Cras quis quam enim. Phasellus laoreet turpis ac lobortis varius. Ut rhoncus orci id nibh faucibus porttitor.\n<br><br>\nAliquam convallis porttitor dui ut ultricies. Duis et consectetur eros. Vivamus vel pulvinar enim, quis vestibulum magna. Donec aliquam eleifend rutrum. Duis rhoncus odio nisi, in laoreet est pulvinar at. Phasellus et libero id lacus scelerisque mattis vitae sit amet ipsum. Donec eu dui vehicula, dignissim urna ac, tristique leo. Etiam eget eros lectus. In sed pharetra ante. Maecenas ullamcorper nulla et sollicitudin dictum. Aenean eget tincidunt ipsum. In sit amet imperdiet diam. Curabitur placerat ac massa id dictum. Donec nec auctor magna. Curabitur blandit ornare dictum. Quisque efficitur pulvinar ligula.\n<br><br>\nProin hendrerit nulla eu ornare bibendum. Curabitur pellentesque gravida nunc quis ullamcorper. Etiam vel sodales lacus. Vestibulum vulputate mi blandit elit accumsan interdum. Suspendisse venenatis tincidunt tincidunt. Donec quis orci auctor, tincidunt ante quis, tempus dui. Pellentesque non maximus libero. Maecenas dictum, eros quis ornare dignissim, tortor libero congue nisl, eu tristique dui orci sed purus. In faucibus pellentesque dolor, ut lobortis velit maximus vel. Sed lorem ligula, consequat non posuere a, ultricies in quam. Pellentesque non nulla et nunc egestas pharetra nec eu est. Nulla facilisis condimentum sem et ultricies.', '2023-01-13 14:39:51', NULL),
(43, 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nibh dolor, viverra sed consectetur in, sodales nec tortor. Proin non massa metus. Cras suscipit molAlis porttitor. Pellentesque viverra aliquet nunc et tristique. Nullam faucibus aliquet orci, sit amet rhoncus mi maximus sit amet. Cras rhoncus luctus libero, id imperdiet eros lacinia ut. Proin et sapien ut leo faucibus laoreet quis id lectus.\n<br><br>\nCras vitae sem dui. Fusce at turpis orci. Sed consequat auctor justo in fringilla. Praesent justo sem, bibendum a efficitur eget, porta id est. Fusce interdum eros non turpis lacinia rutrum. Ut vehicula urna vehicula accumsan faucibus. Nullam elit nunc, fringilla a felis ac, sagittis lobortis metus. Nam nec sagittis leo.\n<br><br>\nPraesent lobortis augue nisl, interdum aliquam nisi rutrum a. Sed malesuada sit amet odio ut ullamcorper. Aliquam commodo sed quam quis placerat. Quisque viverra, turpis eget consectetur vestibulum, nisl orci rutrum est, vestibulum sollicitudin augue tortor id lacus. Nam congue tristique dolor, ac faucibus ipsum aliquam eget. Donec nec nisl bibendum, aliquet sapien eu, euismod nisl. Aliquam erat volutpat. Praesent sed suscipit velit, sed maximus quam. In eu ullamcorper dolor, in cursus neque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris ut velit viverra, efficitur erat tempor, dapibus quam. Donec id porta purus. Pellentesque quis tellus ullamcorper augue rutrum placerat. Cras quis quam enim. Phasellus laoreet turpis ac lobortis varius. Ut rhoncus orci id nibh faucibus porttitor.\n<br><br>\nAliquam convallis porttitor dui ut ultricies. Duis et consectetur eros. Vivamus vel pulvinar enim, quis vestibulum magna. Donec aliquam eleifend rutrum. Duis rhoncus odio nisi, in laoreet est pulvinar at. Phasellus et libero id lacus scelerisque mattis vitae sit amet ipsum. Donec eu dui vehicula, dignissim urna ac, tristique leo. Etiam eget eros lectus. In sed pharetra ante. Maecenas ullamcorper nulla et sollicitudin dictum. Aenean eget tincidunt ipsum. In sit amet imperdiet diam. Curabitur placerat ac massa id dictum. Donec nec auctor magna. Curabitur blandit ornare dictum. Quisque efficitur pulvinar ligula.\n<br><br>\nProin hendrerit nulla eu ornare bibendum. Curabitur pellentesque gravida nunc quis ullamcorper. Etiam vel sodales lacus. Vestibulum vulputate mi blandit elit accumsan interdum. Suspendisse venenatis tincidunt tincidunt. Donec quis orci auctor, tincidunt ante quis, tempus dui. Pellentesque non maximus libero. Maecenas dictum, eros quis ornare dignissim, tortor libero congue nisl, eu tristique dui orci sed purus. In faucibus pellentesque dolor, ut lobortis velit maximus vel. Sed lorem ligula, consequat non posuere a, ultricies in quam. Pellentesque non nulla et nunc egestas pharetra nec eu est. Nulla facilisis condimentum sem et ultricies.', '2023-01-13 14:40:27', '43.jpg'),
(45, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc non cursus ligula. Suspendisse et eros et ipsum feugiat fermentum vitae sed ante. Sed felis ex, consequat eu sem sit amet, hendrerit tempus mauris. Donec consectetur semper viverra. Morbi non consectetur nunc. Quisque lacinia dui in est lobortis iaculis. Duis varius ac quam pulvinar consequat. Nam tincidunt metus vel nibh maximus, sit amet condimentum dui euismod.', '2023-01-13 16:41:56', NULL),
(46, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc non cursus ligula. Suspendisse et eros et ipsum feugiat fermentum vitae sed ante. Sed felis ex, consequat eu sem sit amet, hendrerit tempus mauris. Donec consectetur semper viverra. Morbi non consectetur nunc. Quisque lacinia dui in est lobortis iaculis. Duis varius ac quam pulvinar consequat. Nam tincidunt metus vel nibh maximus, sit amet condimentum dui euismod.', '2023-01-13 16:42:04', NULL),
(47, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc non cursus ligula. Suspendisse et eros et ipsum feugiat fermentum vitae sed ante. Sed felis ex, consequat eu sem sit amet, hendrerit tempus mauris. Donec consectetur semper viverra. Morbi non consectetur nunc. Quisque lacinia dui in est lobortis iaculis. Duis varius ac quam pulvinar consequat. Nam tincidunt metus vel nibh maximus, sit amet condimentum dui euismod.', '2023-01-13 16:42:10', NULL),
(51, 'Lorem Ipsum', '### Lorem Ipsum\nLorem ipsum dolor sit amet, consectetur *adipiscing* **elit.**  \nNunc non cursus ligula. Suspendisse et eros et ipsum  \nfeugiat fermentum vitae sed ante.\n\n* ipsum\n* lorem\n* dolor', '2023-01-17 15:28:39', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `commentaire` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `billet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(2, 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `billet`
--
ALTER TABLE `billet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billet_id` (`billet_id`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `billet`
--
ALTER TABLE `billet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`billet_id`) REFERENCES `billet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
