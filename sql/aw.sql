-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2025 a las 16:22:14
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
--
CREATE DATABASE IF NOT EXISTS `aw` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `aw`;
--
-- --------------------------------------------------------

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
  `foto` varchar(50) NOT NULL,
  `categoria` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `nombre`, `localizacion`, `fecha_hora`, `descripcion`, `aforo`, `dirigida`, `ocupacion`, `foto`, `categoria`) VALUES
(1, 'Clase de Baile', 'Centro Cultural', '2025-08-10 18:00:00.000000', 'Disfruta bailando al ritmo de la música.', 30, 1, 3, 'img/baile.jpg', 3),
(2, 'Taller de Costura', 'Casa de la Cultura', '2025-05-12 16:00:00.000000', 'Aprende a coser tus propias prendas.', 15, 0, 0, 'img/costura.jpg', 4),
(3, 'Taller de Informática', 'Biblioteca Municipal', '2025-09-15 10:00:00.000000', 'Iníciate en el mundo de la informática.', 20, 0, 0, 'img/informatica.jpg', 2),
(4, 'Cocina Saludable', 'Centro de Mayores', '2025-07-20 11:00:00.000000', 'Recetas fáciles para una vida más saludable.', 10, 1, 2, 'img/cocina.jpg', 0),
(5, 'Manualidades', 'Asociación Vecinal', '2025-07-22 15:00:00.000000', 'Apúntate para exprimir al máximo tu creatividad.', 30, 1, 3, 'img/manualidades.jpg', 4),
(6, 'Club de Lectura', 'Librería El Rincón', '2025-10-25 17:30:00.000000', 'Comparte con otras personas tus opiniones sobre la lectura propuesta cada mes.', 35, 0, 0, 'img/lectura.jpg', 1),
(7, 'Excursión al Palacio Real', 'Palacio Real', '2025-04-28 08:00:00.000000', 'Apúntate a visitar uno de los lugares más turísticos de Madrid.', 40, 0, 0, 'img/excursionPR.jpg', 1),
(8, 'Visita al Teatro Real', 'Teatro Real', '2025-07-28 10:00:00.000000', 'Visita el Teatro Real por dentro como nunca antes lo habías visto.', 35, 1, 0, 'img/excursionTR.jpg', 1),
(9, 'Torneo de Ajedrez', 'Universidad Complutense de Madrid (UCM)', '2025-09-07 10:00:00.000000', 'Pon a prueba tus estrategias y desafía a más de 30 personas en un campeonato de Ajedrez como nunca se ha visto.', 20, 0, 0, 'img/ajedrez.jpg', 3),
(10, 'Huerto Urbano', 'Parque Central', '2025-04-18 09:00:00.000000', 'Crea un huerto urbano en tu comunidad.', 10, 0, 0, 'img/huerto.jpg', 0),
(11, 'Yoga al Aire Libre', 'Parque del Retiro', '2025-06-15 09:00:00.000000', 'Sesión de yoga para todos los niveles en plena naturaleza.', 25, 0, 0, 'img/yoga.jpg', 3),
(12, 'Taller de Fotografía', 'Centro Cultural', '2025-07-18 16:00:00.000000', 'Aprende técnicas básicas de fotografía con tu móvil.', 15, 0, 0, 'img/fotografia.jpg', 4),
(13, 'Concierto de Música Clásica', 'Auditorio Municipal', '2025-06-02 20:00:00.000000', 'Disfruta de las mejores piezas de música clásica.', 100, 1, 1, 'img/concierto.jpg', 1),
(14, 'Taller de Jardinería', 'Viveros Municipales', '2025-05-22 10:00:00.000000', 'Aprende a cuidar tus plantas y diseño de jardines.', 12, 1, 2, 'img/jardineria.jpg', 4),
(15, 'Cine Fórum', 'Filmoteca Española', '2025-08-10 18:30:00.000000', 'Proyección y debate de películas clásicas.', 50, 1, 1, 'img/cineforum.jpg', 1),
(16, 'Taller de Pintura', 'Escuela de Arte', '2025-11-30 17:00:00.000000', 'Expresa tu creatividad con acuarelas y óleos.', 18, 1, 1, 'img/pintura.jpg', 4),
(17, 'Excursión a Toledo', 'Salida desde Plaza Mayor', '2025-06-12 08:30:00.000000', 'Visita guiada por la ciudad histórica de Toledo.', 45, 1, 4, 'img/toledo.jpg', 1),
(18, 'Taller de Redes Sociales', 'Biblioteca Municipal', '2025-05-20 11:00:00.000000', 'Aprende a usar Facebook, Instagram y Twitter de forma segura.', 20, 0, 0, 'img/redes.jpg', 2),
(19, 'Conferencia: Historia de Madrid', 'Museo de Historia', '2025-06-05 19:00:00.000000', 'Descubre los secretos históricos de la capital.', 60, 0, 0, 'img/historia.jpg', 1),
(20, 'Taller de Reciclaje', 'Centro de Educación Ambiental', '2025-05-25 12:00:00.000000', 'Aprende a dar una segunda vida a tus residuos.', 15, 0, 0, 'img/reciclaje.jpg', 4),
(21, 'Clase de Tai Chi', 'Parque de Berlín', '2025-07-14 08:30:00.000000', 'Mejora tu equilibrio y relájate con esta disciplina.', 20, 1, 3, 'img/taichi.jpg', 3),
(22, 'Visita al Museo del Prado', 'Museo del Prado', '2025-10-08 10:00:00.000000', 'Recorrido guiado por las obras maestras del museo.', 30, 1, 0, 'img/prado.jpg', 1),
(23, 'Taller de Escritura Creativa', 'Casa del Lector', '2025-11-28 17:00:00.000000', 'Desarrolla tu talento literario con ejercicios prácticos.', 12, 0, 0, 'img/escritura.jpg', 4),
(24, 'Ruta de Senderismo', 'Sierra de Guadarrama', '2025-06-15 08:00:00.000000', 'Disfruta de la naturaleza en esta ruta de dificultad media.', 25, 0, 0, 'img/senderismo.jpg', 3),
(25, 'Taller de Repostería', 'Escuela de Cocina', '2025-10-23 16:00:00.000000', 'Aprende a hacer deliciosos postres caseros.', 10, 0, 0, 'img/reposteria.jpg', 4),
(26, 'Concierto de Jazz', 'Café Central', '2025-11-18 21:00:00.000000', 'Noche de jazz en el mítico local madrileño.', 40, 0, 0, 'img/jazz.jpg', 1),
(27, 'Taller de Autoestima', 'Centro de Psicología', '2025-12-19 18:00:00.000000', 'Mejora tu autoconcepto y habilidades sociales.', 15, 0, 0, 'img/autoestima.jpg', 0),
(28, 'Visita al Planetario', 'Planetario de Madrid', '2025-12-22 19:30:00.000000', 'Viaje por las estrellas y el sistema solar.', 50, 0, 0, 'img/planetario.jpg', 1),
(29, 'Taller de Risoterapia', 'Centro de Bienestar', '2025-09-27 17:30:00.000000', 'Libera tensiones a través de la risa.', 20, 0, 0, 'img/risoterapia.jpg', 0),
(30, 'Clase de Pilates', 'Gimnasio Municipal', '2025-06-16 19:00:00.000000', 'Fortalece tu cuerpo y mejora tu postura.', 15, 0, 0, 'img/pilates.jpg', 3),
(31, 'Taller de Podcast', 'Medialab Prado', '2025-09-11 16:00:00.000000', 'Aprende a crear y editar tu propio podcast.', 10, 0, 0, 'img/podcast.jpg', 2),
(32, 'Visita al Palacio de Cristal', 'Parque del Retiro', '2025-06-14 12:00:00.000000', 'Descubre este emblemático edificio y sus exposiciones.', 25, 1, 2, 'img/cristal.jpg', 1),
(33, 'Taller de Mindfulness', 'Centro de Meditación', '2025-02-21 18:30:00.000000', 'Aprende técnicas de relajación y atención plena.', 18, 0, 0, 'img/mindfulness.jpg', 0),
(34, 'Concurso de Poesía', 'Círculo de Bellas Artes', '2025-01-20 19:00:00.000000', 'Participa o disfruta de la lectura de poemas.', 40, 0, 0, 'img/poesia.jpg', 1),
(35, 'Exhibición de Danza', 'Teatro Circo Price', '2025-06-25 20:00:00.000000', 'Espectáculo de danza contemporánea.', 80, 1, 0, 'img/danza.jpg', 1),
(36, 'Taller de Primeros Auxilios', 'Cruz Roja', '2025-08-29 17:00:00.000000', 'Aprende técnicas básicas de primeros auxilios.', 20, 1, 0, 'img/auxilios.jpg', 0),
(37, 'Ruta en Bicicleta', 'Madrid Río', '2025-06-13 10:00:00.000000', 'Recorrido guiado por los principales parques de Madrid.', 15, 0, 0, 'img/bicicleta.jpg', 3),
(38, 'Taller de Teatro', 'Sala Mirador', '2025-06-17 18:00:00.000000', 'Iniciación al teatro con ejercicios prácticos.', 15, 0, 0, 'img/teatro.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades-mensajes`
--

CREATE TABLE `actividades-mensajes` (
  `id_actividad` int(10) UNSIGNED NOT NULL,
  `id_usuario` varchar(50) NOT NULL,
  `mensaje` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividades-mensajes`
--

INSERT INTO `actividades-mensajes` (`id_actividad`, `id_usuario`, `mensaje`) VALUES
(5, 'antonl11', 1),
(37, 'javiga', 1),
(3, 'javiga', 1),
(22, 'javiga', 1),
(37, 'antonl11', 0),
(12, 'debrubio', 0),
(3, 'antonl11', 0),
(3, 'debrubio', 0),
(3, 'javiga', 0),
(16, 'javiga', 0),
(18, 'debrubio', 0),
(18, 'javiga', 0),
(13, 'antonl11', 1),
(35, 'antonl11', 1),
(35, 'debrubio', 1),
(19, 'debrubio', 0),
(6, 'debrubio', 0),
(8, 'antonl11', 1),
(8, 'debrubio', 1),
(8, 'javiga', 1),
(16, 'antonl11', 1),
(16, 'debrubio', 1),
(16, 'javiga', 1);

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
('22222', 5),
('22222', 17),
('22222', 21),
('22222', 32),
('33333', 4),
('33333', 15),
('33333', 21),
('33333', 35),
('33333', 36),
('antonl11', 1),
('antonl11', 4),
('antonl11', 5),
('antonl11', 17),
('antonl11', 21),
('antonl11', 32),
('debrubio', 4),
('debrubio', 5),
('debrubio', 13),
('debrubio', 14),
('debrubio', 17),
('evsant02', 14),
('evsant02', 32),
('javiga', 1),
('javiga', 14),
('javiga', 15),
('javiga', 16),
('javiga', 17),
('javiga', 21),
('martia01', 13),
('martia01', 22),
('uchaoui', 1),
('uchaoui', 5),
('uchaoui', 8),
('uchaoui', 16),
('uchaoui', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `Nombre` varchar(20) NOT NULL,
  `Id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`Nombre`, `Id`) VALUES
('Salud', 0),
('Cultura', 1),
('Tecnologia', 2),
('Deporte', 3),
('Habilidades', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones`
--

CREATE TABLE `donaciones` (
  `id_donacion` int(10) UNSIGNED NOT NULL,
  `cantidad` decimal(6,2) NOT NULL DEFAULT 0.00,
  `fecha` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `donaciones`
--

INSERT INTO `donaciones` (`id_donacion`, `cantidad`, `fecha`) VALUES
(1, 150.00, '2025-01-05 10:30:00.000000'),
(2, 230.50, '2025-01-15 14:45:00.000000'),
(3, 75.25, '2025-01-22 09:15:00.000000'),
(4, 420.00, '2025-01-28 16:20:00.000000'),
(5, 180.00, '2025-02-03 11:10:00.000000'),
(6, 95.50, '2025-02-10 13:25:00.000000'),
(7, 310.75, '2025-02-18 15:30:00.000000'),
(8, 250.00, '2025-03-07 10:00:00.000000'),
(9, 125.25, '2025-03-12 12:45:00.000000'),
(10, 360.50, '2025-03-19 14:15:00.000000'),
(11, 80.00, '2025-03-25 09:30:00.000000'),
(12, 200.00, '2025-04-05 11:20:00.000000'),
(13, 140.75, '2025-04-15 13:40:00.000000'),
(14, 275.50, '2025-05-02 10:50:00.000000'),
(15, 190.00, '2025-05-10 15:10:00.000000');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria` (`categoria`),
  ADD KEY `categoria_2` (`categoria`);

--
-- Indices de la tabla `actividades-mensajes`
--
ALTER TABLE `actividades-mensajes`
  ADD KEY `actividades-mensajes_ibfk_1` (`id_actividad`),
  ADD KEY `actividades-mensajes_ibfk_2` (`id_usuario`);

--
-- Indices de la tabla `actividades-usuario`
--
ALTER TABLE `actividades-usuario`
  ADD PRIMARY KEY (`id_usuario`,`id_actividad`),
  ADD KEY `id_actividad` (`id_actividad`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`Id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `id_donacion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
