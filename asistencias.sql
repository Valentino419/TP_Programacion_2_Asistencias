-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para asistencias
CREATE DATABASE IF NOT EXISTS `asistencias` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `asistencias`;

-- Volcando estructura para tabla asistencias.alumnos
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id_alumno` bigint NOT NULL AUTO_INCREMENT,
  `apellido` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `nombre` text,
  `dni` int DEFAULT NULL,
  `correo_electronico` text,
  `telefono` text,
  `fecha_nacimiento` date DEFAULT NULL,
  PRIMARY KEY (`id_alumno`) USING BTREE,
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla asistencias.asistencias
CREATE TABLE IF NOT EXISTS `asistencias` (
  `id_asistencias` bigint NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `id_alumno` bigint NOT NULL,
  `id_materia` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_asistencias`) USING BTREE,
  KEY `materia_id` (`id_materia`) USING BTREE,
  KEY `FK_asistencias_alumnos` (`id_alumno`) USING BTREE,
  CONSTRAINT `FK_asistencias_alumnos` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE,
  CONSTRAINT `FK_asistencias_materia` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla asistencias.cursadasalumnos
CREATE TABLE IF NOT EXISTS `cursadasalumnos` (
  `id_cursadasalumnos` bigint NOT NULL AUTO_INCREMENT,
  `id_alumno` bigint NOT NULL,
  `id_materia` bigint NOT NULL,
  PRIMARY KEY (`id_cursadasalumnos`) USING BTREE,
  UNIQUE KEY `id_alumno_id_materia` (`id_alumno`,`id_materia`),
  KEY `id_alumno` (`id_alumno`),
  KEY `FK_cursadas_materia` (`id_materia`),
  CONSTRAINT `FK_cursadas_materia` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`) ON DELETE CASCADE,
  CONSTRAINT `FK_cursadasalumnos_alumnos` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla asistencias.instancias_evaluativas
CREATE TABLE IF NOT EXISTS `instancias_evaluativas` (
  `id_instancias_evaluativas` bigint NOT NULL AUTO_INCREMENT,
  `id_materia` bigint DEFAULT NULL,
  `titulo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `fecha` date DEFAULT NULL,
  `id_recuperatorio` bigint DEFAULT '0',
  PRIMARY KEY (`id_instancias_evaluativas`) USING BTREE,
  KEY `FK_instancias_evaluativas_instancias_evaluativas` (`id_recuperatorio`),
  KEY `FK_instancias_evaluativas_materia` (`id_materia`),
  CONSTRAINT `FK_instancias_evaluativas_materia` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla asistencias.instituto
CREATE TABLE IF NOT EXISTS `instituto` (
  `id_instituto` bigint NOT NULL AUTO_INCREMENT,
  `CUE` bigint NOT NULL DEFAULT '0',
  `nombre` char(50) NOT NULL DEFAULT '',
  `direccion` char(50) DEFAULT NULL,
  `telefono` text,
  `correo_electronico` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`CUE`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `id` (`id_instituto`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla asistencias.materia
CREATE TABLE IF NOT EXISTS `materia` (
  `id_materia` bigint NOT NULL AUTO_INCREMENT,
  `nombre` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_instituto` bigint DEFAULT NULL,
  `id_profesor` bigint DEFAULT NULL,
  KEY `FK_materia_instituto` (`id_instituto`) USING BTREE,
  KEY `FK_materia_profesores` (`id_profesor`) USING BTREE,
  KEY `ID` (`id_materia`) USING BTREE,
  CONSTRAINT `FK_materia_instituto` FOREIGN KEY (`id_instituto`) REFERENCES `instituto` (`id_instituto`) ON DELETE CASCADE,
  CONSTRAINT `FK_materia_profesores` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesores`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla asistencias.notas
CREATE TABLE IF NOT EXISTS `notas` (
  `id_notas` bigint NOT NULL AUTO_INCREMENT,
  `id_alumno` bigint NOT NULL DEFAULT '0',
  `id_instanciaEvaluativa` bigint NOT NULL DEFAULT '0',
  `calificacion` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_notas`) USING BTREE,
  UNIQUE KEY `id_alumno_id_instanciaEvaluativa` (`id_alumno`,`id_instanciaEvaluativa`),
  KEY `FK_notas_instancias_evaluativas` (`id_instanciaEvaluativa`),
  CONSTRAINT `FK_notas_alumnos` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE,
  CONSTRAINT `FK_notas_instancias_evaluativas` FOREIGN KEY (`id_instanciaEvaluativa`) REFERENCES `instancias_evaluativas` (`id_instancias_evaluativas`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla asistencias.profesores
CREATE TABLE IF NOT EXISTS `profesores` (
  `id_profesores` bigint NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `apellido` text,
  `dni` text,
  `correo_electronico` text,
  `telefono` text,
  `legajo` text,
  KEY `Índice 1` (`id_profesores`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla asistencias.ram
CREATE TABLE IF NOT EXISTS `ram` (
  `id_ram` int NOT NULL AUTO_INCREMENT,
  `id_instituto` bigint DEFAULT NULL,
  `notaPromocion` int DEFAULT NULL,
  `notaRegularizacion` int DEFAULT NULL,
  `pAsisPromocion` int DEFAULT NULL,
  `pAsisRegularizacion` int DEFAULT NULL,
  PRIMARY KEY (`id_ram`),
  KEY `FK__instituto` (`id_instituto`),
  CONSTRAINT `FK__instituto` FOREIGN KEY (`id_instituto`) REFERENCES `instituto` (`id_instituto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla asistencias.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuarios` bigint NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `apellido` text,
  `correo_electronico` text,
  `telefono` text,
  `usuario` varchar(255) DEFAULT NULL,
  `contrasena` text,
  PRIMARY KEY (`id_usuarios`) USING BTREE,
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.
INSERT INTO alumnos (nombre, apellido, fecha_nacimiento, dni) VALUES 
('Valentino', 'Andrade', '1999-03-12', 35123456),
('Lucas', 'Cedres', '1998-09-07', 34876543),
('Facundo', 'Figun', '2000-11-25', 40123789),
('Luca', 'Giordano', '1997-06-02', 32456789),
('Bruno', 'Godoy', '1999-01-18', 36789123),
('Agustin', 'Gomez', '1996-04-30', 33567890),
('Brian', 'Gonzalez', '1997-12-05', 35678901),
('Federico', 'Guigou Scottini', '1998-08-15', 37890123),
('Luna', 'Marrano', '1999-03-10', 38901234),
('Giuliana', 'Mercado Aviles', '1995-10-22', 33345678),
('Lucila', 'Mercado Ruiz', '1996-12-08', 32567890),
('Angel', 'Murillo', '1998-02-27', 34890123),
('Juan', 'Nissero', '1999-07-17', 36123456),
('Fausto', 'Parada', '1997-11-06', 35234567),
('Ignacio', 'Piter', '1996-05-19', 32789012),
('Tomas', 'Planchon', '2000-09-03', 40456789),
('Elisa', 'Ronconi', '1995-01-24', 31678123),
('Exequiel', 'Sanchez', '1998-04-11', 33234567),
('Melina', 'Schimpf Baldo', '1996-10-09', 33789456),
('Diego', 'Segovia', '1997-02-13', 34567890),
('Camila', 'Sittner', '1999-08-20', 36456789),
('Yamil', 'Villa', '1998-06-28', 35345678);
/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
