--
-- Base de datos: `acme`
--
CREATE DATABASE IF NOT EXISTS `acme` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;


--
-- Estructura de tabla para la tabla `conductores`
--

CREATE TABLE `conductores` (
  `id_conductor` bigint(12) NOT NULL AUTO_INCREMENT COMMENT 'LLave primaria',
  `identificacion` varchar(25) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'cedula del conductor',
  `primer_nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL COMMENT 'primer nombre',
  `segundo_nombre` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'segundo nombre',
  `apellidos` varchar(50) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'apellidos',
  `direccion` varchar(50) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'direcciòn',
  `telefono` varchar(13) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'telèfono del conductor',
  `ciudad` varchar(30) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'ciudad del conductor',
  PRIMARY KEY (`id_conductor`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='Registra de los conductores'



--
-- Estructura de tabla para la tabla `propietarios`
--

CREATE TABLE `propietarios` (
  `id_propietario` bigint(12) NOT NULL AUTO_INCREMENT COMMENT 'LLave primaria',
  `identificacion` varchar(25) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'cedula',
  `primer_nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL COMMENT 'primer nombre',
  `segundo_nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'segundo nombre',
  `apellidos` varchar(50) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'apellidos',
  `direccion` varchar(50) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'direcciòn',
  `telefono` varchar(13) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'telèfono',
  `ciudad` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_propietario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='Registra de los propietarios'

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT COMMENT 'LLave primaria',
  `placa` varchar(7) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'placa vehiculo',
  `color` varchar(20) CHARACTER SET utf16 COLLATE utf16_spanish2_ci NOT NULL COMMENT 'color',
  `tipo_vehiculo` char(2) COLLATE utf8_spanish2_ci NOT NULL COMMENT '1-particular y 2-publico',
  `marca` varchar(20) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'marca',
  `conductor` bigint(12) NOT NULL COMMENT 'id del la tabla conductor',
  `propietario` bigint(12) NOT NULL COMMENT 'id de la tabla propietarios',
  PRIMARY KEY (`id`),
  KEY `conductor` (`conductor`),
  KEY `vehiculos_propietario_IDX` (`propietario`) USING BTREE,
  CONSTRAINT `fk_conductores` FOREIGN KEY (`conductor`) REFERENCES `conductores` (`id_conductor`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vehiculos_FK` FOREIGN KEY (`propietario`) REFERENCES `propietarios` (`id_propietario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='Registra de vehiuclos con su propietario y conductor'


--
-- Estructura de tabla para la tabla `vehiculos_asignados`
--

CREATE TABLE `vehiculos_asignados` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT COMMENT 'llave prmaria',
  `id_vehiculos` bigint(12) NOT NULL COMMENT 'llave primaria de vehiculos',
  `id_conductor` bigint(12) NOT NULL COMMENT 'LLave primaria de la tabla conductores',
  `id_propietario` bigint(20) NOT NULL COMMENT 'Llave primaria de la tabla propietarios',
  `estado` char(1) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Estados: 0->activo , 1->Inactivo',
  `fecharegistro` datetime NOT NULL COMMENT 'fecha en que se registra la asignación',
  PRIMARY KEY (`id`),
  KEY `vehiculos_asignados_id_vehciulos_IDX` (`id_vehiculos`) USING BTREE,
  KEY `vehiculos_asignados_id_conductor_IDX` (`id_conductor`) USING BTREE,
  KEY `vehiculos_asignados_id_propietario_IDX` (`id_propietario`) USING BTREE,
  CONSTRAINT `vehiculos_asignados_FK` FOREIGN KEY (`id_conductor`) REFERENCES `conductores` (`id_conductor`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vehiculos_asignados_FK_1` FOREIGN KEY (`id_propietario`) REFERENCES `propietarios` (`id_propietario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='Se registra histricamente las asiganciones de vehiculos a determinado propietario y conductor'


