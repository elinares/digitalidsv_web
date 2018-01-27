-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-01-2018 a las 13:45:51
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `digitalidsv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entities`
--

CREATE TABLE `entities` (
  `id_entity` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_e_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entities_types`
--

CREATE TABLE `entities_types` (
  `id_e_type` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entities_types`
--

INSERT INTO `entities_types` (`id_e_type`, `name`) VALUES
(1, 'General'),
(2, 'Tributaria'),
(3, 'Pensiones'),
(4, 'Seguro Social'),
(5, 'Contacto'),
(6, 'Médico'),
(7, 'Académica'),
(8, 'Laboral');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fragments`
--

CREATE TABLE `fragments` (
  `id_fragment` int(11) NOT NULL,
  `hash` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `secure_code` varchar(10) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_fragments`
--

CREATE TABLE `users_fragments` (
  `id_u_fragment` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_fragment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `entities`
--
ALTER TABLE `entities`
  ADD PRIMARY KEY (`id_entity`);

--
-- Indices de la tabla `entities_types`
--
ALTER TABLE `entities_types`
  ADD PRIMARY KEY (`id_e_type`);

--
-- Indices de la tabla `fragments`
--
ALTER TABLE `fragments`
  ADD PRIMARY KEY (`id_fragment`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `users_fragments`
--
ALTER TABLE `users_fragments`
  ADD PRIMARY KEY (`id_u_fragment`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `entities`
--
ALTER TABLE `entities`
  MODIFY `id_entity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `entities_types`
--
ALTER TABLE `entities_types`
  MODIFY `id_e_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `fragments`
--
ALTER TABLE `fragments`
  MODIFY `id_fragment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `users_fragments`
--
ALTER TABLE `users_fragments`
  MODIFY `id_u_fragment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
