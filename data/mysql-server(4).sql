-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql-server
-- Temps de generació: 07-05-2021 a les 15:17:33
-- Versió del servidor: 8.0.19
-- Versió de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `contact-manager`
--
CREATE DATABASE IF NOT EXISTS `contact-manager` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `contact-manager`;

-- --------------------------------------------------------

--
-- Estructura de la taula `contact`
--

CREATE TABLE `contact` (
  `id` int NOT NULL,
  `firstname` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `phone` varchar(9) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `city` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `zipcode` char(5) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `province` char(5) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Bolcament de dades per a la taula `contact`
--

INSERT INTO `contact` (`id`, `firstname`, `lastname`, `phone`, `email`, `city`, `address`, `zipcode`, `province`, `photo`) VALUES
(1, 'Bill', 'Gates', '666666666', 'bill@5g.com', '', '', '', 'ES-S', NULL),
(2, 'Frank', 'Bauer', '645554454', 'frank@24.de', '', '', '', 'ES-CC', 'photo608004db617a4.jpg');

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
