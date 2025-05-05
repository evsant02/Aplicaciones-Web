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
(1, 'Clase de Baile', 'Centro Cultural', '2025-05-10 18:00:00', 'Disfruta bailando al ritmo de la música.', 30, 1, 3, 'img/baile.jpg'),
(2, 'Taller de Costura', 'Casa de la Cultura', '2025-05-12 16:00:00', 'Aprende a coser tus propias prendas.', 15, 1, 1, 'img/costura.jpg'),
(3, 'Taller de Informática', 'Biblioteca Municipal', '2025-04-15 10:00:00', 'Iníciate en el mundo de la informática.', 20, 1, 2, 'img/informatica.jpg'),
(4, 'Cocina Saludable', 'Centro de Mayores', '2025-04-20 11:00:00', 'Recetas fáciles para una vida más saludable.', 10, 0, 0, 'img/cocina.jpg'),
(5, 'Manualidades', 'Asociación Vecinal', '2025-04-22 15:00:00', 'Apúntate para exprimir al máximo tu creatividad.', 30, 0, 0, 'img/manualidades.jpg'),
(6, 'Club de Lectura', 'Librería El Rincón', '2025-05-25 17:30:00', 'Comparte con otras personas tus opiniones sobre la lectura propuesta cada mes.', 35, 1, 0, 'img/lectura.jpg'),
(7, 'Excursión al Palacio Real', 'Palacio Real', '2025-04-28 08:00:00', 'Apúntate a visitar uno de los lugares más turísticos de Madrid.', 40, 0, 0, 'img/excursionPR.jpg'),
(8, 'Visita al Teatro Real', 'Teatro Real', '2025-04-28 10:00:00', 'Visita el Teatro Real por dentro como nunca antes lo habías visto.', 35, 0, 0, 'img/excursionTR.jpg'),
(9, 'Torneo de Ajedrez', 'Universidad Complutense de Madrid (UCM)', '2025-05-07 10:00:00', 'Pon a prueba tus estrategias y desafía a más de 30 personas en un campeonato de Ajedrez como nunca se ha visto.', 20, 0, 0, 'img/ajedrez.jpg'),
(10, 'Huerto Urbano', 'Parque Central', '2025-04-18 09:00:00', 'Crea un huerto urbano en tu comunidad.', 10, 1, 1, 'img/huerto.jpg'),
(11, 'Yoga al Aire Libre', 'Parque del Retiro', '2025-05-15 09:00:00', 'Sesión de yoga para todos los niveles en plena naturaleza.', 25, 1, 0, 'img/yoga.jpg'),
(12, 'Taller de Fotografía', 'Centro Cultural', '2025-05-18 16:00:00', 'Aprende técnicas básicas de fotografía con tu móvil.', 15, 1, 0, 'img/fotografia.jpg'),
(13, 'Concierto de Música Clásica', 'Auditorio Municipal', '2025-06-02 20:00:00', 'Disfruta de las mejores piezas de música clásica.', 100, 0, 0, 'img/concierto.jpg'),
(14, 'Taller de Jardinería', 'Viveros Municipales', '2025-05-22 10:00:00', 'Aprende a cuidar tus plantas y diseño de jardines.', 12, 1, 0, 'img/jardineria.jpg'),
(15, 'Cine Fórum', 'Filmoteca Española', '2025-06-10 18:30:00', 'Proyección y debate de películas clásicas.', 50, 1, 0, 'img/cineforum.jpg'),
(16, 'Taller de Pintura', 'Escuela de Arte', '2025-05-30 17:00:00', 'Expresa tu creatividad con acuarelas y óleos.', 18, 1, 0, 'img/pintura.jpg'),
(17, 'Excursión a Toledo', 'Salida desde Plaza Mayor', '2025-06-12 08:30:00', 'Visita guiada por la ciudad histórica de Toledo.', 45, 0, 0, 'img/toledo.jpg'),
(18, 'Taller de Redes Sociales', 'Biblioteca Municipal', '2025-05-20 11:00:00', 'Aprende a usar Facebook, Instagram y Twitter de forma segura.', 20, 1, 0, 'img/redes.jpg'),
(19, 'Conferencia: Historia de Madrid', 'Museo de Historia', '2025-06-05 19:00:00', 'Descubre los secretos históricos de la capital.', 60, 0, 0, 'img/historia.jpg'),
(20, 'Taller de Reciclaje', 'Centro de Educación Ambiental', '2025-05-25 12:00:00', 'Aprende a dar una segunda vida a tus residuos.', 15, 1, 0, 'img/reciclaje.jpg'),
(21, 'Clase de Tai Chi', 'Parque de Berlín', '2025-05-14 08:30:00', 'Mejora tu equilibrio y relájate con esta disciplina.', 20, 1, 0, 'img/taichi.jpg'),
(22, 'Visita al Museo del Prado', 'Museo del Prado', '2025-06-08 10:00:00', 'Recorrido guiado por las obras maestras del museo.', 30, 0, 0, 'img/prado.jpg'),
(23, 'Taller de Escritura Creativa', 'Casa del Lector', '2025-05-28 17:00:00', 'Desarrolla tu talento literario con ejercicios prácticos.', 12, 1, 0, 'img/escritura.jpg'),
(24, 'Ruta de Senderismo', 'Sierra de Guadarrama', '2025-06-15 08:00:00', 'Disfruta de la naturaleza en esta ruta de dificultad media.', 25, 0, 0, 'img/senderismo.jpg'),
(25, 'Taller de Repostería', 'Escuela de Cocina', '2025-05-23 16:00:00', 'Aprende a hacer deliciosos postres caseros.', 10, 1, 0, 'img/reposteria.jpg'),
(26, 'Concierto de Jazz', 'Café Central', '2025-06-18 21:00:00', 'Noche de jazz en el mítico local madrileño.', 40, 0, 0, 'img/jazz.jpg'),
(27, 'Taller de Autoestima', 'Centro de Psicología', '2025-05-19 18:00:00', 'Mejora tu autoconcepto y habilidades sociales.', 15, 1, 0, 'img/autoestima.jpg'),
(28, 'Visita al Planetario', 'Planetario de Madrid', '2025-06-22 19:30:00', 'Viaje por las estrellas y el sistema solar.', 50, 0, 0, 'img/planetario.jpg'),
(29, 'Taller de Risoterapia', 'Centro de Bienestar', '2025-05-27 17:30:00', 'Libera tensiones a través de la risa.', 20, 1, 0, 'img/risoterapia.jpg'),
(30, 'Clase de Pilates', 'Gimnasio Municipal', '2025-05-16 19:00:00', 'Fortalece tu cuerpo y mejora tu postura.', 15, 1, 0, 'img/pilates.jpg'),
(31, 'Taller de Podcast', 'Medialab Prado', '2025-06-11 16:00:00', 'Aprende a crear y editar tu propio podcast.', 10, 1, 0, 'img/podcast.jpg'),
(32, 'Visita al Palacio de Cristal', 'Parque del Retiro', '2025-06-14 12:00:00', 'Descubre este emblemático edificio y sus exposiciones.', 25, 0, 0, 'img/cristal.jpg'),
(33, 'Taller de Mindfulness', 'Centro de Meditación', '2025-05-21 18:30:00', 'Aprende técnicas de relajación y atención plena.', 18, 1, 0, 'img/mindfulness.jpg'),
(34, 'Concurso de Poesía', 'Círculo de Bellas Artes', '2025-06-20 19:00:00', 'Participa o disfruta de la lectura de poemas.', 40, 0, 0, 'img/poesia.jpg'),
(35, 'Exhibición de Danza', 'Teatro Circo Price', '2025-06-25 20:00:00', 'Espectáculo de danza contemporánea.', 80, 0, 0, 'img/danza.jpg'),
(36, 'Taller de Primeros Auxilios', 'Cruz Roja', '2025-05-29 17:00:00', 'Aprende técnicas básicas de primeros auxilios.', 20, 1, 0, 'img/auxilios.jpg'),
(37, 'Ruta en Bicicleta', 'Madrid Río', '2025-06-13 10:00:00', 'Recorrido guiado por los principales parques de Madrid.', 15, 0, 0, 'img/bicicleta.jpg'),
(38, 'Taller de Teatro', 'Sala Mirador', '2025-06-17 18:00:00', 'Iniciación al teatro con ejercicios prácticos.', 15, 1, 0, 'img/teatro.jpg');

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
  `cantidad` decimal(6,2) NOT NULL DEFAULT '0.00',
  `fecha` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar datos de prueba para 2025 (enero-mayo)
INSERT INTO `donaciones` (`id_donacion`, `cantidad`, `fecha`) VALUES
-- Enero 2025
(1, 150.00, '2025-01-05 10:30:00'),
(2, 230.50, '2025-01-15 14:45:00'),
(3, 75.25,  '2025-01-22 09:15:00'),
(4, 420.00, '2025-01-28 16:20:00'),

-- Febrero 2025
(5, 180.00, '2025-02-03 11:10:00'),
(6, 95.50,  '2025-02-10 13:25:00'),
(7, 310.75, '2025-02-18 15:30:00'),

-- Marzo 2025
(8, 250.00, '2025-03-07 10:00:00'),
(9, 125.25, '2025-03-12 12:45:00'),
(10, 360.50, '2025-03-19 14:15:00'),
(11, 80.00,  '2025-03-25 09:30:00'),

-- Abril 2025
(12, 200.00, '2025-04-05 11:20:00'),
(13, 140.75, '2025-04-15 13:40:00'),

-- Mayo 2025
(14, 275.50, '2025-05-02 10:50:00'),
(15, 190.00, '2025-05-10 15:10:00');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `id_donacion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
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
