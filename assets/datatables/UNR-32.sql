-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-02-2018 a las 17:51:08
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

--
-- Volcado de datos para la tabla `apuntes`
--

INSERT INTO `apuntes` (`id`, `name`, `cat_id`, `sub_cat_id`, `file`, `pages`, `subsub_cat_id`) VALUES
(13, 'otra', 2, 2, '../uploads/Categoria 2/SubCategoria 2/Presupuesto Megasorteo.pdf', 1000, 0),
(12, 'mucha', 2, 2, '../uploads/Categoria 4/sdad123123123/afip_vep_cuit_27340875309_nrovep_238144146.pdf', 250, 0),
(14, 'test', 2, 2, '../uploads/Categoria 2/SubCategoria 2/1.pdf', 321, 2),
(15, 'test2', 2, 2, '../uploads/Categoria 2/SubCategoria 2/1.pdf', 322, 2),
(16, 'nvarg.com', 2, 2, '../uploads/Categoria 2/SubCategoria 2/1.pdf', 31232, 3),
(17, 'Apunte 1', 2, 2, '../uploads/Admin de Empresas/2do Año/Matemáticas 2/1.pdf', 500, 3);

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `name`, `habilitada`) VALUES
(1, 'Categoria 1', 1),
(2, 'Admin de Empresas', 1),
(4, 'Categoria 3', 1),
(5, 'Categoria 4', 1),
(7, 'Categoria 5', 1);

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `price_pages`, `ringed`, `double_fas`) VALUES
(1, 0.5, 150, 0.48);

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id`, `id_usuario`, `admin`, `mov`, `amount`, `date`, `estado`, `cantidad`, `id_pedido`) VALUES
(22, 6, 'admin', 'acreditacion', 500, '2018-01-29 20:03:50', 2, 1, 0),
(23, 6, 'root', 'pedido', 275, '2018-01-29 20:19:49', 1, 1, 28),
(24, 6, 'root', 'pedido', 250, '2018-01-29 20:21:07', 1, 1, 29),
(25, 6, 'root', 'pedido', 250, '2018-01-29 20:21:56', 1, 1, 30),
(26, 6, 'root', 'pedido', 250, '2018-01-29 20:26:28', 1, 1, 31);

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `nombre`, `archivo`, `cantidad`, `total`, `estado`, `date`, `usr_id`, `anillado`, `doblefaz`) VALUES
(31, 'mucha', '../uploads/Categoria 4/sdad123123123/afip_vep_cuit_27340875309_nrovep_238144146.pdf', 1, 250, 1, '2018-01-29 20:26:28', 6, 0, 0),
(30, 'mucha', '../uploads/Categoria 4/sdad123123123/afip_vep_cuit_27340875309_nrovep_238144146.pdf', 1, 250, 1, '2018-01-29 20:21:56', 6, 0, 0),
(29, 'mucha', '../uploads/Categoria 4/sdad123123123/afip_vep_cuit_27340875309_nrovep_238144146.pdf', 1, 250, 1, '2018-01-29 20:21:07', 6, 0, 0),
(28, 'mucha', '../uploads/Categoria 4/sdad123123123/afip_vep_cuit_27340875309_nrovep_238144146.pdf', 1, 275, 1, '2018-01-29 20:19:49', 6, 1, 1);

--
-- Volcado de datos para la tabla `saldos`
--

INSERT INTO `saldos` (`id_usuario`, `saldo`) VALUES
(6, 200);

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`id`, `name`, `cat_id`) VALUES
(1, '5to Año', 2),
(2, '2do Año', 2),
(4, '3er Año', 2),
(5, '4to Año', 2);

--
-- Volcado de datos para la tabla `subsubcategorias`
--

INSERT INTO `subsubcategorias` (`id`, `name`, `cat_id`, `sub_cat_id`) VALUES
(1, 'Matemáticas 5', 2, 1),
(2, 'Materia 2', 2, 2),
(3, 'Matemáticas 2', 2, 2),
(4, 'otra', 2, 2),
(5, 'otra2', 2, 2),
(6, 'otra3', 2, 2),
(7, 'otra4', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(8) NOT NULL,
  `email` text NOT NULL,
  `pass` text NOT NULL,
  `valid` int(1) NOT NULL DEFAULT '0',
  `grup` int(11) NOT NULL DEFAULT '0',
  `code` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `pass`, `valid`, `grup`, `code`) VALUES
(1, 'admin@iga-la.com', 'Demo001', 0, 0, ''),
(8, 'mucha2', 'adsdds', 1, 2, '1'),
(3, 'flor@goaoiads.com', 'hola1234', 0, 0, ''),
(6, 'user', 'user', 1, 0, 'e5y5qV9ZgF'),
(9, 'nuevo', 'nuevo', 1, 1, '1'),
(7, 'admin', 'admin', 1, 2, 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
