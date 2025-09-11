-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         11.8.2-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para rrhh
DROP DATABASE IF EXISTS `rrhh`;
CREATE DATABASE IF NOT EXISTS `rrhh` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `rrhh`;

-- Volcando estructura para tabla rrhh.cargo
DROP TABLE IF EXISTS `cargo`;
CREATE TABLE IF NOT EXISTS `cargo` (
  `id_cargo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_cargo` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='cargos de los empleados';

-- Volcando datos para la tabla rrhh.cargo: ~8 rows (aproximadamente)
REPLACE INTO `cargo` (`id_cargo`, `descripcion_cargo`) VALUES
	(1, 'VENDEDOR'),
	(2, 'ENCARGADO 1'),
	(3, 'ENCARGADO 2'),
	(4, 'SUPERVISOR'),
	(5, 'RRHH'),
	(6, 'GERENCIA'),
	(7, 'COORDINADOR'),
	(8, 'SISTEMAS');

-- Volcando estructura para tabla rrhh.estado
DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_estado` varchar(50) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='estado de los empleados';

-- Volcando datos para la tabla rrhh.estado: ~2 rows (aproximadamente)
REPLACE INTO `estado` (`id_estado`, `descripcion_estado`) VALUES
	(1, 'ACTIVO'),
	(2, 'INACTIVO');

-- Volcando estructura para tabla rrhh.estado_solicitud
DROP TABLE IF EXISTS `estado_solicitud`;
CREATE TABLE IF NOT EXISTS `estado_solicitud` (
  `id_estado_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_estado_solicitud` varchar(50) NOT NULL,
  PRIMARY KEY (`id_estado_solicitud`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla rrhh.estado_solicitud: ~4 rows (aproximadamente)
REPLACE INTO `estado_solicitud` (`id_estado_solicitud`, `descripcion_estado_solicitud`) VALUES
	(1, 'INGRESADA'),
	(2, 'EN REVISION'),
	(3, 'APROBADA'),
	(4, 'DENEGADA');

-- Volcando estructura para tabla rrhh.permiso
DROP TABLE IF EXISTS `permiso`;
CREATE TABLE IF NOT EXISTS `permiso` (
  `id_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT 0,
  `fecha_solicitud` datetime NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `total_tiempo` int(11) NOT NULL DEFAULT 0,
  `id_estado_solicitud` int(11) DEFAULT NULL,
  `id_usuario_aprobador` int(11) DEFAULT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  `fecha_cambio_estado` datetime DEFAULT NULL,
  `id_tipo_permiso` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_permiso`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla rrhh.permiso: ~8 rows (aproximadamente)
REPLACE INTO `permiso` (`id_permiso`, `id_usuario`, `fecha_solicitud`, `hora_inicio`, `hora_fin`, `total_tiempo`, `id_estado_solicitud`, `id_usuario_aprobador`, `observaciones`, `fecha_cambio_estado`, `id_tipo_permiso`, `fecha_registro`) VALUES
	(1, 1, '2025-09-09 00:00:00', '12:44:00', '15:44:00', 3, 1, NULL, 'aaa', NULL, NULL, NULL),
	(2, 1, '2025-09-12 00:00:00', '10:36:00', '14:00:00', 3, 1, NULL, 'etrgyg', NULL, NULL, NULL),
	(3, 2, '2025-09-22 00:00:00', '09:51:00', '13:48:00', 3, 1, NULL, 'Voy al odontologo', NULL, NULL, '2025-09-03 13:49:07'),
	(4, 2, '2025-09-15 00:00:00', '14:30:00', '17:20:00', 2, 1, NULL, 'Tengo que hacer algo', NULL, NULL, '2025-09-04 13:27:01'),
	(5, 1, '2025-09-10 00:00:00', '13:26:00', '19:26:00', 6, 4, 1, 'hfdrfghj', '2025-09-09 15:22:38', 2, '2025-09-08 13:26:59'),
	(6, 1, '2025-09-26 00:00:00', '14:19:00', '17:19:00', 3, 2, 1, 'awafgfg', '2025-09-09 13:46:09', 4, '2025-09-09 11:20:03'),
	(7, 1, '2025-09-21 00:00:00', '10:20:00', '16:20:00', 6, 3, 1, 'ssadasd', '2025-09-09 13:45:09', 7, '2025-09-09 11:20:49'),
	(8, 1, '2025-09-11 00:00:00', '11:22:00', '19:22:00', 8, 4, 1, 'asddg', '2025-09-09 13:44:41', 1, '2025-09-09 11:22:26');

-- Volcando estructura para tabla rrhh.tipo_permiso
DROP TABLE IF EXISTS `tipo_permiso`;
CREATE TABLE IF NOT EXISTS `tipo_permiso` (
  `id_tipo_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_tipo_permiso` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tipo_permiso`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla rrhh.tipo_permiso: ~8 rows (aproximadamente)
REPLACE INTO `tipo_permiso` (`id_tipo_permiso`, `descripcion_tipo_permiso`) VALUES
	(1, 'PARTICULAR'),
	(2, 'CITA MEDICA'),
	(3, 'MATRIMONIO O UNION DE HECHO'),
	(4, 'CALAMIDAD DOMESTICA'),
	(5, 'MATERNIDAD O PATERNIDAD'),
	(6, 'ESTUDIOS O VIAJE'),
	(7, 'ENFERMEDAD'),
	(8, 'OTRO');

-- Volcando estructura para tabla rrhh.ubicacion
DROP TABLE IF EXISTS `ubicacion`;
CREATE TABLE IF NOT EXISTS `ubicacion` (
  `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_ubicacion` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_ubicacion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='ubicaciones de los empleados';

-- Volcando datos para la tabla rrhh.ubicacion: ~2 rows (aproximadamente)
REPLACE INTO `ubicacion` (`id_ubicacion`, `descripcion_ubicacion`) VALUES
	(1, 'OFICINA'),
	(2, 'QUICENTRO NORTE'),
	(3, 'JARDIN');

-- Volcando estructura para tabla rrhh.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(100) NOT NULL DEFAULT '',
  `cedula_usuario` varchar(10) NOT NULL DEFAULT '',
  `correo_usuario` varchar(200) NOT NULL DEFAULT '',
  `clave_usuario` varchar(200) NOT NULL DEFAULT '',
  `id_ubicacion` int(11) NOT NULL DEFAULT 0,
  `id_cargo` int(11) NOT NULL DEFAULT 0,
  `id_estado` int(11) NOT NULL DEFAULT 0,
  `direccion_usuario` varchar(250) NOT NULL DEFAULT '0',
  `telefono_usuario` varchar(15) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='tabla de usuarios para acceso al sistema';

-- Volcando datos para la tabla rrhh.usuario: ~2 rows (aproximadamente)
REPLACE INTO `usuario` (`id_usuario`, `nombre_usuario`, `cedula_usuario`, `correo_usuario`, `clave_usuario`, `id_ubicacion`, `id_cargo`, `id_estado`, `direccion_usuario`, `telefono_usuario`) VALUES
	(1, 'JUAN LOPEZ', '1759031543', 'sistemas@sempersa.com', '123456', 1, 8, 1, '0', '0'),
	(2, 'MARIA ZAMBRANO', '1741466328', 'comercial@sempersa.com', '123456', 2, 2, 1, '0', '0');

-- Volcando estructura para tabla rrhh.vacacion
DROP TABLE IF EXISTS `vacacion`;
CREATE TABLE IF NOT EXISTS `vacacion` (
  `id_vacacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT 0,
  `fecha_solicitud` datetime NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `cantidad_dias` int(11) NOT NULL DEFAULT 0,
  `id_estado_solicitud` int(11) NOT NULL DEFAULT 0,
  `id_usuario_aprobador` int(11) NOT NULL DEFAULT 0,
  `observaciones` varchar(250) NOT NULL DEFAULT '0',
  `fecha_cambio_estado` datetime DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_vacacion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla rrhh.vacacion: ~2 rows (aproximadamente)
REPLACE INTO `vacacion` (`id_vacacion`, `id_usuario`, `fecha_solicitud`, `fecha_inicio`, `fecha_fin`, `cantidad_dias`, `id_estado_solicitud`, `id_usuario_aprobador`, `observaciones`, `fecha_cambio_estado`, `fecha_registro`) VALUES
	(1, 1, '2025-09-01 00:00:00', '2025-09-03', '2025-09-09', -6, 1, 0, 'aaa', NULL, NULL),
	(2, 1, '2025-09-01 00:00:00', '2025-09-17', '2025-09-22', -5, 1, 0, 'saa', NULL, NULL),
	(3, 2, '2025-09-03 00:00:00', '2025-09-10', '2025-09-18', 8, 1, 0, 'gfgfdhg', NULL, '2025-09-04 13:28:32');

-- Volcando estructura para vista rrhh.v_permiso
DROP VIEW IF EXISTS `v_permiso`;
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `v_permiso` (
	`id_usuario` INT(11) NOT NULL,
	`id_permiso` INT(11) NOT NULL,
	`nombre_usuario` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`cedula_usuario` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`correo_usuario` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`descripcion_cargo` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`descripcion_ubicacion` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`descripcion_estado_solicitud` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`usuario_aprobador` VARCHAR(1) NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`fecha_solicitud` VARCHAR(1) NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`hora_inicio` TIME NOT NULL,
	`hora_fin` TIME NOT NULL,
	`total_tiempo` INT(11) NOT NULL,
	`observaciones` VARCHAR(1) NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`fecha_registro` VARCHAR(1) NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`tipo_permiso` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`fecha_estado` DATETIME NULL
) ENGINE=MyISAM;

-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `v_permiso`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_permiso` AS SELECT 
	u.id_usuario,
	p.id_permiso,
	u.nombre_usuario,
	u.cedula_usuario,
	u.correo_usuario,
	c.descripcion_cargo,
	ub.descripcion_ubicacion,
	e.descripcion_estado_solicitud,
	u2.nombre_usuario AS usuario_aprobador,
	DATE_FORMAT(p.fecha_solicitud, '%Y-%m-%d') AS fecha_solicitud,
	p.hora_inicio,
	p.hora_fin,
	p.total_tiempo,
	p.observaciones,
	DATE_FORMAT(p.fecha_registro, '%Y-%m-%d') AS fecha_registro,
	tp.descripcion_tipo_permiso AS tipo_permiso,
	p.fecha_cambio_estado AS fecha_estado
FROM
	permiso p INNER JOIN
	usuario u ON u.id_usuario = p.id_usuario INNER JOIN
	cargo c ON c.id_cargo = u.id_cargo INNER JOIN 
	ubicacion ub ON ub.id_ubicacion = u.id_ubicacion INNER JOIN 
	estado_solicitud e ON e.id_estado_solicitud = p.id_estado_solicitud LEFT JOIN 
	usuario u2 ON u2.id_usuario = p.id_usuario_aprobador INNER JOIN
	tipo_permiso tp ON tp.id_tipo_permiso = p.id_tipo_permiso 
;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
