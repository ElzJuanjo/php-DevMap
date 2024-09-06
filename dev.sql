SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `comentario` (
  `id_comentario` int(11) NOT NULL,
  `comentario` varchar(100) NOT NULL,
  `correo_usuario` varchar(100) NOT NULL,
  `id_publicacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `likes` (
  `id_like` int(11) NOT NULL,
  `correo_usuario` varchar(100) NOT NULL,
  `id_publicacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `publicacion` (
  `id_publicacion` int(11) NOT NULL,
  `correo_usuario` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` text NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `resena` (
  `id_resena` int(11) NOT NULL,
  `correo_autor` varchar(100) NOT NULL,
  `correo_resenado` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `comentario` varchar(300) NOT NULL,
  `puntuacion` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `seguidor` (
  `id_seguidor` int(11) NOT NULL,
  `seguido` varchar(100) NOT NULL,
  `seguidor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `usuario` (
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `ubicacion` text NOT NULL,
  `bio` text NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `repositorio` text NOT NULL,
  `imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `correo_usuario` (`correo_usuario`),
  ADD KEY `id_publicacion` (`id_publicacion`);

ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `correo_usuario` (`correo_usuario`),
  ADD KEY `id_publicacion` (`id_publicacion`);

ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`id_publicacion`),
  ADD KEY `correo_usuario` (`correo_usuario`);

ALTER TABLE `resena`
  ADD PRIMARY KEY (`id_resena`),
  ADD KEY `correo_autor` (`correo_autor`),
  ADD KEY `correo_resenado` (`correo_resenado`);

ALTER TABLE `seguidor`
  ADD PRIMARY KEY (`id_seguidor`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`correo`);

ALTER TABLE `comentario`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

ALTER TABLE `likes`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

ALTER TABLE `publicacion`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

ALTER TABLE `resena`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `seguidor`
  MODIFY `id_seguidor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`correo_usuario`) REFERENCES `usuario` (`correo`),
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id_publicacion`);

ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`correo_usuario`) REFERENCES `usuario` (`correo`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id_publicacion`);

ALTER TABLE `publicacion`
  ADD CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`correo_usuario`) REFERENCES `usuario` (`correo`);

ALTER TABLE `resena`
  ADD CONSTRAINT `resena_ibfk_1` FOREIGN KEY (`correo_autor`) REFERENCES `usuario` (`correo`),
  ADD CONSTRAINT `resena_ibfk_2` FOREIGN KEY (`correo_resenado`) REFERENCES `usuario` (`correo`);
COMMIT;