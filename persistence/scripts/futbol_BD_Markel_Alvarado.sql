-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.12.0.7122
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para futbol_db
CREATE DATABASE IF NOT EXISTS `futbol_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `futbol_db`;

-- Volcando estructura para tabla futbol_db.equipos
CREATE TABLE IF NOT EXISTS `equipos` (
  `id_equipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `estadio` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_equipo`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla futbol_db.equipos: ~6 rows (aproximadamente)
INSERT INTO `equipos` (`id_equipo`, `nombre`, `estadio`) VALUES
	(1, 'Real Madrid', 'Santiago Bernabéu'),
	(2, 'FC Barcelona', 'Camp Nou'),
	(3, 'Atlético de Madrid', 'Wanda Metropolitano'),
	(4, 'Sevilla FC', 'Ramón Sánchez-Pizjuán'),
	(5, 'Osasuna', 'Sadar'),
	(6, 'Albacete', 'Estadio Municipal Carlos Belmonte'),
	(18, 'Girona', 'Estadio Montilivi');

-- Volcando estructura para tabla futbol_db.partidos
CREATE TABLE IF NOT EXISTS `partidos` (
  `id_partido` int(11) NOT NULL AUTO_INCREMENT,
  `id_local` int(11) NOT NULL,
  `id_visitante` int(11) NOT NULL,
  `resultado` enum('1','X','2') DEFAULT NULL,
  `jornada` int(11) NOT NULL,
  PRIMARY KEY (`id_partido`),
  KEY `fk_local` (`id_local`),
  KEY `fk_visitante` (`id_visitante`),
  CONSTRAINT `fk_local` FOREIGN KEY (`id_local`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_visitante` FOREIGN KEY (`id_visitante`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla futbol_db.partidos: ~5 rows (aproximadamente)
INSERT INTO `partidos` (`id_partido`, `id_local`, `id_visitante`, `resultado`, `jornada`) VALUES
	(1, 1, 2, '1', 1),
	(2, 3, 4, 'X', 1),
	(3, 2, 3, '2', 2),
	(4, 4, 1, '1', 2),
	(5, 6, 5, '2', 2),
	(12, 6, 2, '1', 3);

-- Volcando estructura para tabla futbol_db.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_unico` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla futbol_db.usuarios: ~0 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nombre`, `password`) VALUES
	(1, 'admin', 'admin'),
	(2, 'markel.alvarado@gmail.com', '1234');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
