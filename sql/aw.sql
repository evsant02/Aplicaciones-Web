-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-03-2025 a las 16:54:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aw`
--
CREATE DATABASE IF NOT EXISTS `aw` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `aw`;
--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `localizacion` varchar(70) NOT NULL,
  `fecha_hora` datetime(6) NOT NULL,
  `descripcion` text NOT NULL,
  `aforo` tinyint(3) NOT NULL,
  `dirigida` tinyint(1) NOT NULL,
  `ocupacion` tinyint(3) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `nombre`, `localizacion`, `fecha_hora`, `descripcion`, `aforo`, `dirigida`, `ocupacion`, `foto`) VALUES
(1, 'Clase de Baile', 'Centro Cultural', '2025-05-10 18:00:00.000000', 'Disfruta bailando al ritmo de la música.', 30, 1, 3, 'img/baile.jpg'),
(2, 'Taller de Costura', 'Casa de la Cultural', '2025-05-12 16:00:00.000000', 'Aprende a coser tus propias prendas.', 15, 1, 1, 'img/costura.jpg'),
(3, 'Taller de Informática', 'Biblioteca Municipal', '2025-04-15 10:00:00.000000', 'Iníciate en el mundo de la informática.', 20, 1, 2, 'img/informatica.jpg'),
(4, 'Cocina Saludable', 'Centro de Mayores', '2025-04-20 11:00:00.000000', 'Recetas fáciles para una vida más saludable.', 10, 0, 0, 'img/cocina.jpg'),
(5, 'Manualidades', 'Asociación Vecinal', '2025-04-22 15:00:00.000000', 'Apúntate para exprimir al máximo tu creatividad.', 30, 0, 0, 'img/manualidades.jpg'),
(6, 'Club de Lectura', 'Librería El Rincón', '2025-05-25 17:30:00.000000', 'Comparte con otras personas tus opiniones sobre la lectura propuesta cada mes.', 35, 1, 0, 'img/lectura.jpg'),
(7, 'Excursión al Palacio Real', 'Palacio Real', '2025-04-28 08:00:00.000000', 'Apúntate a visitar uno de los lugares más turísticos de Madrid.', 40, 0, 0, 'img/excursionPR.jpg'),
(8, 'Visita al Teatro Real', 'Teatro Real', '2025-04-28 10:00:00.000000', 'Visita el Teatro Real por dentro como nunca antes lo habias visto.', 35, 0, 0, 'img/excursionTR.jpg'),
(9, 'Torneo de Ajedrez', 'Universidad Complutense de Madrid (UCM)', '2025-05-07 10:00:00.000000', 'Pon a prueba tus estrategias y desafía a más de 30 personas en un campeonato de Ajedrez como nunca se ha visto.', 20, 0, 0, 'img/ajedrez.jpg'),
(10, 'Huerto Urbano', 'Parque Central', '2025-04-18 09:00:00.000000', 'Crea un huerto urbano en tu comunidad.', 10, 1, 1, 'img/huerto.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades-mensajes`
--

CREATE TABLE `actividades-mensajes` (
  `id_actividad` int(10) UNSIGNED NOT NULL,
  `id_usuario` varchar(50) NOT NULL,
  `mensaje` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades-usuario`
--

CREATE TABLE `actividades-usuario` (
  `id_usuario` varchar(50) NOT NULL,
  `id_actividad` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividades-usuario`
--

INSERT INTO `actividades-usuario` (`id_usuario`, `id_actividad`) VALUES
('22222', 1),
('22222', 2),
('22222', 10),
('33333', 1),
('antonl11', 1),
('antonl11', 3),
('debb1601', 6),
('evsant02', 10),
('javiga', 1),
('javiga', 3),
('martia01', 3),
('uchaoui', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones`
--

CREATE TABLE `donaciones` (
  `id_donacion` int(10) UNSIGNED NOT NULL,
  `cantidad` int(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `nombre` varchar(20) NOT NULL,
  `id_rol` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`nombre`, `id_rol`) VALUES
('admin', 0),
('usuario', 1),
('voluntario', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` varchar(50) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `correo` varchar(40) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `fecha_nacimiento`, `tipo`, `correo`, `password`) VALUES
('11111', 'admin1', 'primer administrador', '1995-03-15', 0, 'correoadmin1@gmail.com', 'admin1'),
('22222', 'usuario1', 'primer usuario', '1945-07-18', 1, 'correousuario1@gmail.com', 'usuario1'),
('33333', 'voluntario1', 'primer voluntario', '2006-10-19', 2, 'correovoluntario1@gmail.com', 'voluntario1'),
('antonl11', 'Antonio', 'López Belinchón', '1940-04-04', 1, 'antonl11@ucm.es', 'antonio'),
('debb1601', 'Débora', 'Rubio Galindo', '2002-01-16', 2, 'deborarubiogalindo@gmail.com', '$2y$10$5Hg4RZYOpb7muCO6pj8SSeav30iKGC9/NGfda.FGFbCm8WRt.HJja'),
('debrubio', 'Débora', 'Rubio Galindo', '1940-10-10', 1, 'debrubio@ucm.es', 'debora'),
('evsant02', 'Eva', 'Santos Sánchez', '2003-02-01', 2, 'evsant02@ucm.es', 'eva'),
('javiga', 'Javier', 'García Sánchez', '1956-04-20', 1, 'javiga22@ucm.es', 'javier'),
('martia01', 'Martina', 'Águeda García', '2000-05-11', 2, 'martia01@ucm.es', 'martina'),
('uchaoui', 'Umaima', 'Chaoui Benmousa', '2003-07-15', 2, 'uchaoui@ucm.es', 'umaima');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividades-mensajes`
--
ALTER TABLE `actividades-mensajes`
  ADD PRIMARY KEY (`id_actividad`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `actividades-usuario`
--
ALTER TABLE `actividades-usuario`
  ADD PRIMARY KEY (`id_usuario`,`id_actividad`),
  ADD KEY `id_actividad` (`id_actividad`);

--
-- Indices de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  ADD PRIMARY KEY (`id_donacion`) USING BTREE;

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`) USING BTREE,
  ADD UNIQUE KEY `id_rol` (`nombre`) USING BTREE;

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `password` (`password`),
  ADD KEY `rol` (`tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12347;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades-mensajes`
--
ALTER TABLE `actividades-mensajes`
  ADD CONSTRAINT `actividades-mensajes_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividades-mensajes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `actividades-usuario`
--
ALTER TABLE `actividades-usuario`
  ADD CONSTRAINT `actividades-usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividades-usuario_ibfk_2` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
