-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-01-2018 a las 18:21:59
-- Versión del servidor: 5.7.14
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `unr`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subsubcategorias`
--

CREATE TABLE `unr`.`subsubcategorias` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `cat_id` INT NOT NULL,
  `sub_cat_id` INT NOT NULL,
  PRIMARY KEY (`id`));

--
-- Alteracion de tabla `apuntes` 
--

ALTER TABLE `unr`.`apuntes` 
ADD COLUMN `subsub_cat_id` INT NOT NULL AFTER `pages`;


--
--  
--

ALTER TABLE `unr`.`subsubcategorias` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

