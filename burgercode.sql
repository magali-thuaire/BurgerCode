-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 30 mai 2018 à 21:00
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `burgercode`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Menus'),
(2, 'Burgers'),
(3, 'Snacks'),
(4, 'Salades'),
(5, 'Boissons'),
(6, 'Desserts');

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `image`, `category`) VALUES
(1, 'Menu Classic', 'Sandwich: Burger, Salade, Tomates, Cornichon + Frites + Boisson', 8.9, 'm1.png', 1),
(2, 'Menu Bacon', 'Sandwich: Burger, Fromage, Bacon, Salade, Tomates + Frites + Boisson', 9.5, 'm2.png', 1),
(3, 'Menu Big', 'Sandwich: Double Burger, Fromage, Cornichon, Salade + Frites + Boisson', 10.9, 'm3.png', 1),
(4, 'Menu Chicken', 'Sandwich: Poulet Frit, Tomates, Salade, Mayonnaise + Frites + Boisson', 9.9, 'm4.png', 1),
(5, 'Menu Fish', 'Sandwich: Poisson, Salade, Mayonnaise, Cornichon + Frites + Boisson', 10.9, 'm5.png', 1),
(6, 'Menu Double Steak', 'Sandwich: Double Burger, Fromage, Bacon, Salade, Tomates + Frites + Boisson', 11.9, 'm6.png', 1),
(7, 'Classic', 'Sandwich: Burger, Salade, Tomates, Cornichon', 5.9, 'b1.png', 2),
(8, 'Bacon', 'Sandwich: Burger, Fromage, Bacon, Salade, Tomates', 6.5, 'b2.png', 2),
(9, 'Big', 'Sandwich: Double Burger, Fromage, Cornichon, Salade', 6.9, 'b3.png', 2),
(10, 'Chicken', 'Sandwich: Poulet Frit, Tomates, Salade, Mayonnaise', 5.9, 'b4.png', 2),
(11, 'Fish', 'Sandwich: Poisson Pané, Salade, Mayonnaise, Cornichon', 6.5, 'b5.png', 2),
(12, 'Double Steak', 'Sandwich: Double Burger, Fromage, Bacon, Salade, Tomates', 7.5, 'b6.png', 2),
(13, 'Frites', 'Pommes de terre frites', 3.9, 's1.png', 3),
(14, 'Onion Rings', 'Rondelles d\'oignons frits', 3.4, 's2.png', 3),
(15, 'Nuggets', 'Nuggets de poulet frits', 5.9, 's3.png', 3),
(16, 'Nuggets Fromage', 'Nuggets de fromage frits', 3.5, 's4.png', 3),
(17, 'Ailes de Poulet', 'Ailes de poulet sauce barbecue', 5.9, 's5.png', 3),
(18, 'César Poulet Pané', 'Poulet Pané, Salade, Tomates et la fameuse sauce César', 8.9, 'sa1.png', 4),
(19, 'César Poulet Grillé', 'Poulet Grillé, Salade, Tomates et la fameuse sauce César', 8.9, 'sa2.png', 4),
(20, 'Salade Light', 'Salade, Tomates, Concombres, Maïs et Vinaigre balsamique', 5.9, 'sa3.png', 4),
(21, 'Poulet Pané', 'Poulet Pané, Salade, Tomates et la sauce de votre choix', 7.9, 'sa4.png', 4),
(22, 'Poulet Grillé', 'Poulet Grillé, Salade, Tomates et la sauce de votre choix', 7.9, 'sa5.png', 4),
(23, 'Coca-Cola', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo1.png', 5),
(24, 'Coca-Cola Light', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo2.png', 5),
(25, 'Coca-Cola Zéro', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo3.png', 5),
(26, 'Fanta', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo4.png', 5),
(27, 'Sprite', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo5.png', 5),
(28, 'Nestea', 'Au choix: Petit, Moyen ou Grand', 1.9, 'bo6.png', 5),
(29, 'Fondant au chocolat', 'Au choix: Noir ou Blanc', 4.9, 'd1.png', 6),
(30, 'Muffin', 'Au choix: fruits ou chocolat', 2.9, 'd2.png', 6),
(31, 'Beignet', 'Au choix: Chocolat ou Vanille', 2.9, 'd3.png', 6),
(32, 'Milkshake', 'Au choix: Fraise, Vanille ou Chocolat', 3.9, 'd4.png', 6),
(33, 'Sundae', 'Au choix: Fraise, Caramel ou Chocolat', 4.9, 'd5.png', 6);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
