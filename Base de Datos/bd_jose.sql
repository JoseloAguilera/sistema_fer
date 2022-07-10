-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.21 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para sist_ventas
DROP DATABASE IF EXISTS `sist_ventas`;
CREATE DATABASE IF NOT EXISTS `sist_ventas` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sist_ventas`;

-- Volcando estructura para tabla sist_ventas.caja_chica
DROP TABLE IF EXISTS `caja_chica`;
CREATE TABLE IF NOT EXISTS `caja_chica` (
  `id_caja` int NOT NULL AUTO_INCREMENT,
  `referencia_caja` varchar(255) NOT NULL,
  `monto_caja` double NOT NULL,
  `descripcion_caja` varchar(255) NOT NULL,
  `tipo_caja` tinyint NOT NULL,
  `users_caja` int NOT NULL,
  `date_added_caja` datetime NOT NULL,
  PRIMARY KEY (`id_caja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.caja_chica: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sist_ventas.cargo
DROP TABLE IF EXISTS `cargo`;
CREATE TABLE IF NOT EXISTS `cargo` (
  `id_cargo` int NOT NULL AUTO_INCREMENT,
  `nombre_cargo` varchar(255) NOT NULL,
  `estado_cargo` varchar(11) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.cargo: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sist_ventas.clientes
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(255) NOT NULL,
  `fiscal_cliente` varchar(255) NOT NULL,
  `telefono_cliente` char(30) NOT NULL,
  `email_cliente` varchar(64) NOT NULL,
  `direccion_cliente` varchar(255) NOT NULL,
  `status_cliente` tinyint NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `codigo_producto` (`nombre_cliente`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.clientes: 9 rows
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `fiscal_cliente`, `telefono_cliente`, `email_cliente`, `direccion_cliente`, `status_cliente`, `date_added`) VALUES
	(1, 'FABIAN RODRIGUEZ', '4316085', '098763235', 'a@a.com', 'Km 6 Av. Blas Garay\r\nAv. San José, a una cuadra', 1, '2021-08-07 10:18:21'),
	(2, 'José Aguilera', '5971557-0', '0973118404', 'joseaguilera1709@gmail.com', 'KM 6 AV. BLAS GARAY', 1, '2021-08-16 14:13:10'),
	(3, 'ssss', '55555', '0973118404', 'hy@hy.com', 'Km 6 Av. Blas Garay\r\nAv. San José, a una cuadra', 1, '2021-08-20 10:13:04'),
	(4, 'Alltech Paraguay S.R.L.', '80081276-0', '0986547812', 'alltech@alltech.com', 'Km 8 1/2 Acaray', 1, '2021-09-21 11:58:37'),
	(5, 'JULIAN CASTRO', '1049362-0', '0983608720', 'julian@julian.com', 'AV. BLAS GARAY', 1, '2021-09-23 17:33:25'),
	(6, 'ELVIO FERNANDO BRITOS MORENO', '3431302', '0981355533', '', 'BO SAN ISIDRO', 1, '2021-11-26 15:08:25'),
	(7, 'luz escobar', '2587415', '0973152516', 'asd@asd.com', 'XAX', 1, '2022-02-16 13:33:01'),
	(8, 'rolando moriconi', '24234', '3423423423', 'rol@gmail.com', 'csaasdas', 1, '2022-03-06 08:37:42'),
	(9, 'Carlos Vallejos', '5971577', '0973148520', 'carlos@carlos.com', 'alksdiasjdsaw', 1, '2022-05-21 22:17:56');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.comprobantes
DROP TABLE IF EXISTS `comprobantes`;
CREATE TABLE IF NOT EXISTS `comprobantes` (
  `id_comp` int NOT NULL AUTO_INCREMENT,
  `nombre_comp` varchar(100) NOT NULL,
  `serie_comp` varchar(100) NOT NULL,
  `desde_comp` int NOT NULL,
  `hasta_comp` int NOT NULL,
  `long_comp` int NOT NULL,
  `actual_comp` int NOT NULL,
  `vencimiento_comp` date NOT NULL,
  `estado_comp` int NOT NULL,
  PRIMARY KEY (`id_comp`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.comprobantes: ~0 rows (aproximadamente)
INSERT INTO `comprobantes` (`id_comp`, `nombre_comp`, `serie_comp`, `desde_comp`, `hasta_comp`, `long_comp`, `actual_comp`, `vencimiento_comp`, `estado_comp`) VALUES
	(1, 'FACTURA UNO', '001-001-', 1, 999999, 6, 0, '2021-12-20', 1);

-- Volcando estructura para tabla sist_ventas.creditos
DROP TABLE IF EXISTS `creditos`;
CREATE TABLE IF NOT EXISTS `creditos` (
  `id_credito` int NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_credito` datetime NOT NULL,
  `id_cliente` int NOT NULL,
  `id_vendedor` int NOT NULL,
  `monto_credito` double NOT NULL,
  `saldo_credito` double NOT NULL,
  `estado_credito` tinyint(1) NOT NULL,
  `id_users_credito` int NOT NULL,
  `id_sucursal` int NOT NULL,
  PRIMARY KEY (`id_credito`),
  UNIQUE KEY `numero_cotizacion` (`numero_factura`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.creditos: 17 rows
/*!40000 ALTER TABLE `creditos` DISABLE KEYS */;
INSERT INTO `creditos` (`id_credito`, `numero_factura`, `fecha_credito`, `id_cliente`, `id_vendedor`, `monto_credito`, `saldo_credito`, `estado_credito`, `id_users_credito`, `id_sucursal`) VALUES
	(1, '001-001-000001', '2021-08-16 17:07:42', 2, 1, 15000, 5000, 1, 1, 1),
	(2, '001-001-000002', '2021-08-17 06:14:10', 2, 1, 22500, 17500, 1, 1, 1),
	(3, '001-001-000004', '2021-08-17 07:30:56', 2, 1, 15000, 0, 2, 1, 1),
	(4, '001-001-000005', '2021-08-17 07:33:16', 2, 1, 15000, 10000, 1, 1, 1),
	(5, '001-001-000006', '2021-08-17 07:34:36', 2, 1, 15000, 15000, 1, 1, 1),
	(6, '001-001-000007', '2021-08-17 07:37:06', 2, 1, 7500, 7500, 1, 1, 1),
	(7, '001-001-000012', '2021-09-09 13:04:26', 2, 1, 143100, 143100, 1, 1, 1),
	(8, '001-001-000014', '2021-09-21 12:32:20', 2, 1, 72000, 72000, 1, 1, 1),
	(9, '001-001-000022', '2021-09-23 17:36:47', 2, 1, 619200, 340001.01, 1, 1, 1),
	(10, '001-001-000026', '2022-02-16 12:17:37', 2, 1, 719210, 719210, 1, 1, 1),
	(11, '001-001-000027', '2022-02-16 13:07:27', 5, 1, 0, 0, 1, 1, 1),
	(12, '001-001-000032', '2022-03-02 13:12:21', 7, 1, 1054800, 1054800, 1, 1, 1),
	(13, '001-001-000034', '2022-03-06 08:38:16', 8, 1, 527400, 0, 2, 1, 1),
	(14, '001-001-000035', '2022-04-18 17:23:38', 2, 1, 527400, 527200, 1, 1, 1),
	(15, '001-001-000037', '2022-04-18 17:43:15', 2, 1, 1366875, 499334, 1, 1, 1),
	(16, '001-001-000043', '2022-06-14 10:01:41', 7, 1, 60000, 0, 2, 1, 1),
	(17, '001-001-000054', '2022-06-27 14:46:05', 9, 1, 15000, 15000, 1, 1, 1);
/*!40000 ALTER TABLE `creditos` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.creditos_abonos
DROP TABLE IF EXISTS `creditos_abonos`;
CREATE TABLE IF NOT EXISTS `creditos_abonos` (
  `id_abono` int NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_abono` datetime NOT NULL,
  `id_cliente` int NOT NULL,
  `monto_abono` double NOT NULL,
  `abono` double NOT NULL,
  `saldo_abono` double NOT NULL,
  `id_users_abono` int NOT NULL,
  `id_sucursal` int NOT NULL,
  `concepto_abono` varchar(255) NOT NULL,
  PRIMARY KEY (`id_abono`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.creditos_abonos: 30 rows
/*!40000 ALTER TABLE `creditos_abonos` DISABLE KEYS */;
INSERT INTO `creditos_abonos` (`id_abono`, `numero_factura`, `fecha_abono`, `id_cliente`, `monto_abono`, `abono`, `saldo_abono`, `id_users_abono`, `id_sucursal`, `concepto_abono`) VALUES
	(1, '001-001-000001', '2021-08-16 17:07:42', 2, 15000, 0, 15000, 1, 1, 'CREDITO INICAL'),
	(2, '001-001-000002', '2021-08-17 06:14:10', 2, 22500, 5000, 17500, 1, 1, 'CREDITO INICAL'),
	(3, '001-001-000004', '2021-08-17 07:30:56', 2, 15000, 0, 15000, 1, 1, 'CREDITO INICAL'),
	(4, '001-001-000005', '2021-08-17 07:33:16', 2, 15000, 0, 15000, 1, 1, 'CREDITO INICAL'),
	(5, '001-001-000006', '2021-08-17 07:34:36', 2, 15000, 0, 15000, 1, 1, 'CREDITO INICAL'),
	(6, '001-001-000007', '2021-08-17 07:37:06', 2, 7500, 0, 7500, 1, 1, 'CREDITO INICAL'),
	(7, '001-001-000012', '2021-09-09 13:04:26', 2, 143100, 0, 143100, 1, 1, 'CREDITO INICAL'),
	(8, '001-001-000001', '2021-09-09 13:57:29', 2, 15000, 10000, 5000, 1, 1, 'BISDBFV'),
	(9, '001-001-000014', '2021-09-21 12:32:20', 2, 72000, 0, 72000, 1, 1, 'CREDITO INICAL'),
	(10, '001-001-000022', '2021-09-23 17:36:47', 2, 619200, 0, 619200, 1, 1, 'CREDITO INICAL'),
	(11, '001-001-000022', '2021-11-26 15:10:17', 2, 619200, 19200, 600000, 1, 1, 'AMORTIZACION'),
	(12, '001-001-000022', '2021-11-26 15:11:20', 2, 619200, 60000, 540000, 1, 1, 'PAGO TOTAL'),
	(13, '001-001-000022', '2021-11-26 15:11:50', 2, 619200, 99999, 440001, 1, 1, 'PAGO'),
	(14, '001-001-000022', '2021-11-26 15:12:13', 2, 619200, 99999.99, 340001.01, 1, 1, 'GGG'),
	(15, '001-001-000026', '2022-02-16 12:17:37', 2, 719210, 0, 719210, 1, 1, 'CREDITO INICAL'),
	(16, '001-001-000027', '2022-02-16 13:07:27', 5, 0, 0, 0, 1, 1, 'CREDITO INICAL'),
	(17, '001-001-000032', '2022-03-02 13:12:21', 7, 1054800, 0, 1054800, 1, 1, 'CREDITO INICAL'),
	(18, '001-001-000034', '2022-03-06 08:38:16', 8, 527400, 100000, 427400, 1, 1, 'CREDITO INICAL'),
	(19, '001-001-000034', '2022-03-06 08:38:47', 8, 527400, 100, 427300, 1, 1, 'PAGO 2'),
	(20, '001-001-000035', '2022-04-18 17:23:38', 2, 527400, 0, 527400, 1, 1, 'CREDITO INICAL'),
	(21, '001-001-000035', '2022-04-18 17:25:44', 2, 527400, 200, 527200, 1, 1, 'RECIBO 008'),
	(22, '001-001-000037', '2022-04-18 17:43:15', 2, 1366875, 366875, 1000000, 1, 1, 'CREDITO INICAL'),
	(23, '001-001-000037', '2022-04-18 17:44:41', 2, 1366875, 666, 999334, 1, 1, '1ER PAGO'),
	(24, '001-001-000004', '2022-05-21 22:41:04', 2, 15000, 15000, 0, 1, 1, 'RECIBO 005'),
	(25, '001-001-000005', '2022-05-21 22:41:28', 2, 15000, 5000, 10000, 1, 1, 'RECIBO 006'),
	(26, '001-001-000043', '2022-06-14 10:01:41', 7, 60000, 0, 60000, 1, 1, 'CREDITO INICAL'),
	(27, '001-001-000043', '2022-06-15 07:20:21', 7, 60000, 60000, 0, 1, 1, 'RR'),
	(28, '001-001-000037', '2022-06-15 07:21:10', 2, 1366875, 500000, 499334, 1, 1, 'FFFF'),
	(29, '001-001-000034', '2022-06-25 17:09:57', 8, 527400, 427300, 0, 1, 1, 'HNGHNGH'),
	(30, '001-001-000054', '2022-06-27 14:46:05', 9, 15000, 0, 15000, 1, 1, 'CREDITO INICAL');
/*!40000 ALTER TABLE `creditos_abonos` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.creditos_abonos_prov
DROP TABLE IF EXISTS `creditos_abonos_prov`;
CREATE TABLE IF NOT EXISTS `creditos_abonos_prov` (
  `id_abono` int NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_abono` datetime NOT NULL,
  `id_proveedor` int NOT NULL,
  `monto_abono` double NOT NULL,
  `abono` double NOT NULL,
  `saldo_abono` double NOT NULL,
  `id_users_abono` int NOT NULL,
  `id_sucursal` int NOT NULL,
  `concepto_abono` varchar(255) NOT NULL,
  PRIMARY KEY (`id_abono`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.creditos_abonos_prov: 5 rows
/*!40000 ALTER TABLE `creditos_abonos_prov` DISABLE KEYS */;
INSERT INTO `creditos_abonos_prov` (`id_abono`, `numero_factura`, `fecha_abono`, `id_proveedor`, `monto_abono`, `abono`, `saldo_abono`, `id_users_abono`, `id_sucursal`, `concepto_abono`) VALUES
	(1, 'FC-000002', '2021-08-29 08:36:12', 1, 90000, 0, 90000, 1, 1, 'CREDITO INICAL'),
	(2, 'FC-000004', '2022-05-21 22:36:44', 5, 300000, 0, 300000, 1, 1, 'CREDITO INICAL'),
	(3, 'FC-000004', '2022-05-21 22:43:42', 5, 300000, 300, 299700, 1, 1, 'RECIBO '),
	(4, 'FC-000004', '2022-06-15 07:26:35', 5, 300000, 299700, 0, 1, 1, 'GGG'),
	(5, 'FC-000008', '2022-06-25 17:03:05', 6, 100000, 0, 100000, 1, 1, 'CREDITO INICAL');
/*!40000 ALTER TABLE `creditos_abonos_prov` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.credito_proveedor
DROP TABLE IF EXISTS `credito_proveedor`;
CREATE TABLE IF NOT EXISTS `credito_proveedor` (
  `id_credito` int NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_credito` datetime NOT NULL,
  `id_proveedor` int NOT NULL,
  `monto_credito` double NOT NULL,
  `saldo_credito` double NOT NULL,
  `estado_credito` tinyint(1) NOT NULL,
  `id_users_credito` int NOT NULL,
  `id_sucursal` int NOT NULL,
  PRIMARY KEY (`id_credito`),
  UNIQUE KEY `numero_cotizacion` (`numero_factura`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.credito_proveedor: 3 rows
/*!40000 ALTER TABLE `credito_proveedor` DISABLE KEYS */;
INSERT INTO `credito_proveedor` (`id_credito`, `numero_factura`, `fecha_credito`, `id_proveedor`, `monto_credito`, `saldo_credito`, `estado_credito`, `id_users_credito`, `id_sucursal`) VALUES
	(1, 'FC-000002', '2021-08-29 08:36:12', 1, 90000, 90000, 1, 1, 1),
	(2, 'FC-000004', '2022-05-21 22:36:44', 5, 300000, 0, 2, 1, 1),
	(3, 'FC-000008', '2022-06-25 17:03:05', 6, 100000, 100000, 1, 1, 1);
/*!40000 ALTER TABLE `credito_proveedor` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.currencies
DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `precision` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `thousand_separator` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `decimal_separator` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.currencies: ~5 rows (aproximadamente)
INSERT INTO `currencies` (`id`, `name`, `symbol`, `precision`, `thousand_separator`, `decimal_separator`, `code`) VALUES
	(1, 'US Dollar', '$', '2', ',', '.', 'USD'),
	(2, 'Libra Esterlina', '&pound;', '2', ',', '.', 'GBP'),
	(3, 'Euro', 'â‚¬', '2', '.', ',', 'EUR'),
	(4, 'South African Rand', 'R', '2', '.', ',', 'ZAR'),
	(5, 'Guarani Paraguayo', 'Gs', '0', '.', ',', 'PYG');

-- Volcando estructura para tabla sist_ventas.detalle_fact_compra
DROP TABLE IF EXISTS `detalle_fact_compra`;
CREATE TABLE IF NOT EXISTS `detalle_fact_compra` (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `id_factura` int NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` double NOT NULL,
  `precio_costo` double NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `numero_cotizacion` (`numero_factura`,`id_producto`),
  KEY `id_factura` (`id_factura`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.detalle_fact_compra: 8 rows
/*!40000 ALTER TABLE `detalle_fact_compra` DISABLE KEYS */;
INSERT INTO `detalle_fact_compra` (`id_detalle`, `id_factura`, `numero_factura`, `id_producto`, `cantidad`, `precio_costo`) VALUES
	(11, 5, 'FC-000002', 11, 10, 9000),
	(10, 1, 'FC-000001', 10, 500, 10000),
	(12, 6, 'FC-000003', 18, 4, 999999.99),
	(13, 7, 'FC-000004', 17, 1, 300000),
	(14, 8, 'FC-000005', 15, 3, 25000),
	(15, 9, 'FC-000006', 15, 1, 25000),
	(16, 10, 'FC-000007', 16, 1, 90000),
	(17, 11, 'FC-000008', 10, 10, 10000);
/*!40000 ALTER TABLE `detalle_fact_compra` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.detalle_fact_cot
DROP TABLE IF EXISTS `detalle_fact_cot`;
CREATE TABLE IF NOT EXISTS `detalle_fact_cot` (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `id_factura` int NOT NULL,
  `numero_factura` varchar(25) NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` int NOT NULL,
  `desc_venta` int NOT NULL,
  `precio_venta` double NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `numero_cotizacion` (`numero_factura`,`id_producto`),
  KEY `id_factura` (`id_factura`),
  KEY `numero_factura` (`numero_factura`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.detalle_fact_cot: 17 rows
/*!40000 ALTER TABLE `detalle_fact_cot` DISABLE KEYS */;
INSERT INTO `detalle_fact_cot` (`id_detalle`, `id_factura`, `numero_factura`, `id_producto`, `cantidad`, `desc_venta`, `precio_venta`) VALUES
	(1, 1, 'COT-000001', 15, 1, 0, 0),
	(2, 1, 'COT-000001', 16, 1, 0, 0),
	(3, 1, 'COT-000001', 17, 2, 0, 0),
	(4, 1, 'COT-000001', 11, 1, 0, 0),
	(5, 2, 'COT-000002', 17, 2, 0, 0),
	(6, 2, 'COT-000002', 16, 2, 0, 0),
	(7, 2, 'COT-000002', 15, 2, 0, 0),
	(8, 3, 'COT-000003', 17, 3, 0, 332500),
	(9, 3, 'COT-000003', 16, 3, 0, 38700),
	(10, 3, 'COT-000003', 15, 3, 0, 156200),
	(11, 4, 'COT-000004', 17, 1, 0, 332500),
	(12, 4, 'COT-000004', 16, 1, 0, 38700),
	(13, 4, 'COT-000004', 15, 1, 0, 156200),
	(14, 5, 'COT-000005', 10, 12, 0, 15000),
	(15, 6, 'COT-000006', 15, 1, 0, 156200),
	(16, 6, 'COT-000006', 16, 7, 0, 100000),
	(17, 6, 'COT-000006', 10, 3, 0, 15000);
/*!40000 ALTER TABLE `detalle_fact_cot` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.detalle_fact_ventas
DROP TABLE IF EXISTS `detalle_fact_ventas`;
CREATE TABLE IF NOT EXISTS `detalle_fact_ventas` (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `id_factura` int NOT NULL,
  `numero_factura` varchar(25) NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` int NOT NULL,
  `desc_venta` int NOT NULL,
  `precio_venta` double NOT NULL,
  `importe_venta` double NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `numero_cotizacion` (`numero_factura`,`id_producto`),
  KEY `id_factura` (`id_factura`),
  KEY `numero_factura` (`numero_factura`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.detalle_fact_ventas: 109 rows
/*!40000 ALTER TABLE `detalle_fact_ventas` DISABLE KEYS */;
INSERT INTO `detalle_fact_ventas` (`id_detalle`, `id_factura`, `numero_factura`, `id_producto`, `cantidad`, `desc_venta`, `precio_venta`, `importe_venta`) VALUES
	(4, 1, '001-001-000000', 10, 2, 0, 15000, 30000),
	(5, 5, '001-001-000001', 10, 1, 0, 15000, 15000),
	(6, 6, '001-001-000002', 10, 2, 0, 15000, 22500),
	(7, 7, '001-001-000003', 10, 1, 0, 15000, 15000),
	(8, 8, '001-001-000004', 10, 1, 0, 15000, 15000),
	(9, 9, '001-001-000005', 10, 1, 0, 15000, 15000),
	(10, 10, '001-001-000006', 10, 1, 0, 15000, 15000),
	(11, 11, '001-001-000007', 10, 1, 0, 15000, 7500),
	(12, 12, '001-001-000008', 10, 1, 0, 15000, 15000),
	(13, 13, '001-001-000009', 10, 3, 0, 15000, 45000),
	(14, 13, '001-001-000009', 11, 1, 0, 18000, 18000),
	(15, 14, '001-001-000010', 10, 1, 0, 15000, 15000),
	(16, 14, '001-001-000010', 11, 1, 0, 15000, 15000),
	(17, 15, '001-001-000011', 10, 1, 0, 15000, 15000),
	(18, 16, '001-001-000012', 12, 15, 0, 8000, 120000),
	(19, 16, '001-001-000012', 10, 1, 25, 18000, 18000),
	(20, 16, '001-001-000012', 11, 1, 0, 9600, 9600),
	(21, 17, '001-001-000013', 12, 1, 0, 8000, 8000),
	(22, 18, '001-001-000014', 12, 9, 0, 8000, 72000),
	(23, 20, '001-001-000016', 11, 4, 0, 9600, 38400),
	(24, 21, '001-001-000017', 10, 2, 0, 15000, 30000),
	(25, 22, '001-001-000018', 10, 17, 0, 15000, 255000),
	(26, 23, '001-001-000019', 10, 1, 0, 15000, 15000),
	(27, 24, '001-001-000020', 10, 1, 0, 15000, 15000),
	(28, 25, '001-001-000021', 10, 9, 0, 15000, 135000),
	(29, 26, '001-001-000022', 11, 2, 0, 9600, 19200),
	(30, 26, '001-001-000022', 10, 12, 0, 50000, 600000),
	(31, 27, '001-001-000023', 10, 2, 0, 15000, 30000),
	(32, 28, '001-001-000024', 10, 3, 0, 15000, 45000),
	(33, 29, '001-001-000025', 16, 1, 0, 38700, 38700),
	(34, 29, '001-001-000025', 15, 1, 0, 156200, 156200),
	(35, 29, '001-001-000025', 17, 2, 0, 285000, 780000),
	(36, 30, '001-001-000026', 17, 1, 0, 300000, 300000),
	(37, 30, '001-001-000026', 16, 1, 0, 38700, 38700),
	(38, 30, '001-001-000026', 10, 2, 0, 15000, 30000),
	(39, 30, '001-001-000026', 15, 2, 0, 156200, 312400),
	(40, 31, '001-001-000027', 17, 1, 0, 332500, 0),
	(41, 31, '001-001-000027', 16, 1, 0, 38700, 0),
	(42, 31, '001-001-000027', 15, 1, 0, 156200, 0),
	(47, 34, '001-001-000030', 15, 2, 0, 156200, 312400),
	(44, 33, '001-001-000029', 17, 2, 0, 285000, 332500),
	(45, 33, '001-001-000029', 16, 1, 0, 36000, 38700),
	(46, 33, '001-001-000029', 15, 1, 0, 130000, 156200),
	(48, 34, '001-001-000030', 16, 1, 0, 38700, 38700),
	(49, 34, '001-001-000030', 17, 2, 0, 332500, 665000),
	(50, 35, '001-001-000031', 15, 5, 0, 156200, 781000),
	(51, 36, '001-001-000032', 17, 2, 0, 332500, 665000),
	(55, 37, '001-001-000033', 16, 3, 0, 0, 0),
	(54, 37, '001-001-000033', 15, 3, 0, 0, 0),
	(56, 37, '001-001-000033', 17, 3, 0, 0, 0),
	(57, 38, '001-001-000034', 17, 1, 0, 332500, 332500),
	(58, 38, '001-001-000034', 16, 1, 0, 38700, 38700),
	(59, 38, '001-001-000034', 15, 1, 0, 156200, 156200),
	(60, 39, '001-001-000035', 17, 1, 0, 332500, 332500),
	(61, 39, '001-001-000035', 16, 1, 0, 38700, 38700),
	(62, 39, '001-001-000035', 15, 1, 0, 156200, 156200),
	(63, 40, '001-001-000036', 10, 3, 0, 15000, 45000),
	(65, 41, '001-001-000037', 15, 4, 0, 156200, 624800),
	(66, 41, '001-001-000037', 17, 6, 0, 332500, 1995000),
	(67, 41, '001-001-000037', 16, 4, 0, 38700, 154800),
	(68, 43, '001-001-000038', 17, 2, 0, 332500, 665000),
	(69, 44, '001-001-000039', 10, 12, 0, 15000, 180000),
	(70, 45, '001-001-000040', 15, 1, 50, 156200, 156200),
	(83, 52, '001-001-000046', 13, 2, 0, 6800, 13600),
	(72, 47, '001-001-000041', 10, 12, 0, 15000, 180000),
	(73, 48, '001-001-000042', 10, 12, 0, 15000, 180000),
	(74, 49, '', 10, 12, 0, 15000, 180000),
	(75, 49, '001-001-000043', 10, 4, 0, 15000, 60000),
	(76, 50, '', 10, 12, 0, 15000, 180000),
	(77, 50, '001-001-000044', 10, 12, 0, 15000, 180000),
	(78, 51, '001-001-000044', 10, 12, 0, 15000, 180000),
	(79, 51, '001-001-000044', 10, 12, 0, 15000, 180000),
	(80, 51, '001-001-000044', 10, 12, 0, 15000, 180000),
	(81, 51, '001-001-000044', 10, 12, 0, 15000, 180000),
	(82, 51, '001-001-000045', 10, 12, 0, 15000, 180000),
	(84, 52, '001-001-000046', 11, 3, 0, 9600, 28800),
	(85, 52, '001-001-000046', 10, 7, 0, 15000, 105000),
	(86, 53, '001-001-000047', 10, 2, 0, 15000, 30000),
	(87, 54, '001-001-000048', 14, 1, 0, 13300, 13300),
	(88, 55, '001-001-000049', 13, 1, 0, 6800, 6800),
	(89, 56, '001-001-000050', 14, 1, 0, 13300, 13300),
	(90, 57, '001-001-000051', 16, 1, 0, 100000, 100000),
	(91, 57, '001-001-000051', 15, 1, 0, 156200, 156200),
	(92, 58, '001-001-000052', 10, 17, 0, 15000, 255000),
	(93, 59, '001-001-000053', 10, 2, 0, 15000, 30000),
	(94, 60, '001-001-000054', 10, 1, 0, 15000, 15000),
	(95, 61, '001-001-000055', 10, 1, 0, 15000, 15000),
	(96, 62, '001-001-000056', 10, 1, 0, 15000, 15000),
	(97, 63, '001-001-000057', 10, 1, 0, 15000, 15000),
	(98, 64, '001-001-000058', 10, 1, 0, 15000, 15000),
	(99, 65, '001-001-000059', 10, 1, 0, 15000, 15000),
	(100, 66, '001-001-000060', 10, 1, 0, 15000, 15000),
	(101, 67, '001-001-000061', 10, 1, 0, 15000, 15000),
	(102, 68, '001-001-000062', 10, 1, 0, 15000, 15000),
	(103, 69, '001-001-000063', 10, 1, 0, 15000, 15000),
	(104, 70, '001-001-000064', 10, 1, 0, 15000, 15000),
	(105, 71, '001-001-000065', 10, 1, 0, 15000, 15000),
	(106, 72, '001-001-000066', 10, 1, 0, 15000, 15000),
	(107, 73, '001-001-000067', 14, 2, 0, 13300, 26600),
	(108, 74, '001-001-000068', 19, 6, 0, 35500, 213000),
	(109, 74, '001-001-000068', 18, 3, 0, 1518750, 4556250),
	(110, 75, '001-001-000069', 18, 1, 0, 1518750, 1518750),
	(111, 76, '001-001-000070', 18, 1, 0, 1518750, 1518750),
	(112, 77, '001-001-000071', 14, 2, 0, 13300, 26600),
	(113, 78, '001-001-000072', 14, 2, 0, 13300, 26600),
	(114, 79, '001-001-000073', 14, 1, 0, 13300, 13300),
	(115, 80, '001-001-000074', 13, 1, 0, 6800, 6800),
	(116, 81, '001-001-000075', 10, 1, 0, 15000, 15000),
	(117, 82, '001-001-000076', 10, 1, 0, 15000, 15000);
/*!40000 ALTER TABLE `detalle_fact_ventas` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.detalle_traslado
DROP TABLE IF EXISTS `detalle_traslado`;
CREATE TABLE IF NOT EXISTS `detalle_traslado` (
  `id_detalle_traslado` int NOT NULL AUTO_INCREMENT,
  `id_traslado` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_venta` double NOT NULL,
  `num_transaccion` varchar(50) NOT NULL,
  PRIMARY KEY (`id_detalle_traslado`),
  KEY `id_traslado` (`id_traslado`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.detalle_traslado: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sist_ventas.egresos
DROP TABLE IF EXISTS `egresos`;
CREATE TABLE IF NOT EXISTS `egresos` (
  `id_egreso` int NOT NULL AUTO_INCREMENT,
  `referencia_egreso` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `monto` double NOT NULL,
  `descripcion_egreso` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_added` datetime NOT NULL,
  `users` int NOT NULL,
  PRIMARY KEY (`id_egreso`),
  KEY `users` (`users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.egresos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sist_ventas.facturas_compras
DROP TABLE IF EXISTS `facturas_compras`;
CREATE TABLE IF NOT EXISTS `facturas_compras` (
  `id_factura` int NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(50) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_proveedor` int NOT NULL,
  `id_vendedor` int NOT NULL,
  `condiciones` int NOT NULL,
  `monto_factura` double NOT NULL,
  `estado_factura` tinyint NOT NULL,
  `id_users_factura` int NOT NULL,
  `id_sucursal` int NOT NULL,
  `ref_factura` varchar(50) NOT NULL,
  PRIMARY KEY (`id_factura`),
  UNIQUE KEY `numero_cotizacion` (`numero_factura`),
  KEY `id_sucursal` (`id_sucursal`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `id_vendedor` (`id_vendedor`),
  KEY `id_users_factura` (`id_users_factura`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.facturas_compras: 8 rows
/*!40000 ALTER TABLE `facturas_compras` DISABLE KEYS */;
INSERT INTO `facturas_compras` (`id_factura`, `numero_factura`, `fecha_factura`, `id_proveedor`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `id_sucursal`, `ref_factura`) VALUES
	(4, 'FC-000001', '2021-08-26 00:00:00', 1, 1, 1, 5000000, 1, 1, 1, 'qqqqww'),
	(5, 'FC-000002', '2021-08-29 00:00:00', 1, 1, 4, 90000, 2, 1, 1, '24'),
	(6, 'FC-000003', '2022-04-18 00:00:00', 4, 1, 1, 3999999.96, 1, 1, 1, ''),
	(7, 'FC-000004', '2022-05-22 00:00:00', 5, 1, 4, 300000, 1, 1, 1, '001-005-00025'),
	(8, 'FC-000005', '2022-06-10 00:00:00', 6, 1, 1, 75000, 1, 1, 1, '123123'),
	(9, 'FC-000006', '2022-06-10 00:00:00', 6, 1, 1, 25000, 1, 1, 1, '4434343'),
	(10, 'FC-000007', '2022-06-10 00:00:00', 1, 1, 1, 90000, 1, 1, 1, '444455'),
	(11, 'FC-000008', '2022-06-25 00:00:00', 6, 1, 4, 100000, 2, 1, 1, 'dfvdsfgv');
/*!40000 ALTER TABLE `facturas_compras` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.facturas_cot
DROP TABLE IF EXISTS `facturas_cot`;
CREATE TABLE IF NOT EXISTS `facturas_cot` (
  `id_factura` int NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_cliente` int NOT NULL,
  `id_vendedor` int NOT NULL,
  `condiciones` varchar(30) NOT NULL,
  `monto_factura` double NOT NULL,
  `estado_factura` tinyint(1) NOT NULL,
  `id_users_factura` int NOT NULL,
  `validez` double NOT NULL,
  `id_sucursal` int NOT NULL,
  PRIMARY KEY (`id_factura`),
  UNIQUE KEY `numero_cotizacion` (`numero_factura`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.facturas_cot: 6 rows
/*!40000 ALTER TABLE `facturas_cot` DISABLE KEYS */;
INSERT INTO `facturas_cot` (`id_factura`, `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`) VALUES
	(1, 'COT-000001', '2022-03-04 12:45:36', 2, 1, '1', 869500, 1, 1, 1, 1),
	(2, 'COT-000002', '2022-03-04 12:53:13', 7, 1, '1', 1054800, 1, 1, 1, 1),
	(3, 'COT-000003', '2022-03-04 12:54:20', 2, 1, '1', 1582200, 1, 1, 1, 1),
	(4, 'COT-000004', '2022-05-21 22:19:13', 9, 1, '1', 527400, 1, 1, 1, 1),
	(5, 'COT-000005', '2022-06-11 16:54:54', 9, 1, '1', 180000, 1, 1, 5, 1),
	(6, 'COT-000006', '2022-06-27 13:18:52', 9, 1, '1', 901200, 1, 1, 1, 1);
/*!40000 ALTER TABLE `facturas_cot` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.facturas_ventas
DROP TABLE IF EXISTS `facturas_ventas`;
CREATE TABLE IF NOT EXISTS `facturas_ventas` (
  `id_factura` int NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_cliente` int NOT NULL,
  `id_vendedor` int NOT NULL,
  `condiciones` varchar(30) NOT NULL,
  `monto_factura` double NOT NULL,
  `estado_factura` tinyint(1) NOT NULL,
  `id_users_factura` int NOT NULL,
  `dinero_resibido_fac` double NOT NULL,
  `id_sucursal` int NOT NULL,
  `id_comp_factura` int NOT NULL,
  `num_trans_factura` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_factura`),
  UNIQUE KEY `numero_cotizacion` (`numero_factura`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.facturas_ventas: 76 rows
/*!40000 ALTER TABLE `facturas_ventas` DISABLE KEYS */;
INSERT INTO `facturas_ventas` (`id_factura`, `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `dinero_resibido_fac`, `id_sucursal`, `id_comp_factura`, `num_trans_factura`) VALUES
	(4, '001-001-000000', '2021-08-16 14:48:49', 2, 1, '1', 30000, 1, 1, 30000, 1, 1, 'T000001'),
	(5, '001-001-000001', '2021-08-16 17:07:42', 2, 1, '4', 15000, 2, 1, 0, 1, 1, 'T000002'),
	(6, '001-001-000002', '2021-08-17 06:14:10', 2, 1, '4', 22500, 2, 1, 5000, 1, 1, 'T000003'),
	(7, '001-001-000003', '2021-08-17 07:15:51', 2, 1, '1', 15000, 1, 1, 15000, 1, 1, ''),
	(8, '001-001-000004', '2021-08-17 07:30:56', 2, 1, '4', 15000, 1, 1, 0, 1, 1, ''),
	(9, '001-001-000005', '2021-08-17 07:33:16', 2, 1, '4', 15000, 2, 1, 0, 1, 1, ''),
	(10, '001-001-000006', '2021-08-17 07:34:36', 2, 1, '4', 15000, 2, 1, 0, 1, 1, ''),
	(11, '001-001-000007', '2021-08-17 07:37:06', 2, 1, '4', 7500, 2, 1, 0, 1, 1, ''),
	(12, '001-001-000008', '2021-08-20 10:13:17', 2, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(13, '001-001-000009', '2021-08-26 12:39:32', 2, 1, '1', 63000, 1, 1, 100000, 1, 1, ''),
	(14, '001-001-000010', '2021-08-29 08:38:24', 2, 1, '1', 30000, 1, 1, 50000, 1, 1, ''),
	(15, '001-001-000011', '2021-09-06 13:20:46', 2, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(16, '001-001-000012', '2021-09-09 13:04:26', 2, 1, '4', 143100, 2, 1, 0, 1, 1, ''),
	(17, '001-001-000013', '2021-09-21 12:00:11', 4, 1, '1', 8000, 1, 1, 10000, 1, 1, ''),
	(18, '001-001-000014', '2021-09-21 12:32:20', 2, 1, '4', 72000, 2, 1, 0, 1, 1, ''),
	(19, '001-001-000015', '2021-09-21 12:50:10', 4, 1, '1', 30000, 1, 1, 50000, 1, 1, ''),
	(20, '001-001-000016', '2021-09-21 12:51:23', 4, 1, '1', 38400, 1, 1, 50000, 1, 1, ''),
	(21, '001-001-000017', '2021-09-21 12:55:48', 2, 1, '1', 30000, 1, 1, 100000, 1, 1, ''),
	(22, '001-001-000018', '2021-09-21 13:56:31', 2, 1, '1', 255000, 1, 1, 300000, 1, 1, ''),
	(23, '001-001-000019', '2021-09-21 13:58:18', 4, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(24, '001-001-000020', '2021-09-21 13:59:26', 4, 1, '1', 15000, 1, 1, 50000, 1, 1, ''),
	(25, '001-001-000021', '2021-09-23 15:41:16', 2, 1, '1', 135000, 1, 1, 200000, 1, 1, ''),
	(26, '001-001-000022', '2021-09-23 17:36:47', 2, 1, '4', 619200, 2, 1, 0, 1, 1, ''),
	(27, '001-001-000023', '2021-09-23 17:38:04', 5, 1, '1', 30000, 1, 1, 50000, 1, 1, ''),
	(28, '001-001-000024', '2021-09-23 17:40:15', 2, 1, '1', 45000, 1, 1, 50000, 1, 1, ''),
	(29, '001-001-000025', '2022-02-16 11:59:34', 4, 1, '1', 764900, 1, 1, 1000000, 1, 1, ''),
	(30, '001-001-000026', '2022-02-16 12:17:37', 2, 1, '4', 719210, 2, 1, 0, 1, 1, ''),
	(31, '001-001-000027', '2022-02-16 13:07:27', 5, 1, '4', 0, 2, 1, 0, 1, 1, ''),
	(34, '001-001-000030', '2022-03-02 13:10:20', 2, 1, '1', 1016100, 1, 1, 1100000, 1, 1, ''),
	(33, '001-001-000029', '2022-02-16 13:33:28', 7, 1, '2', 736000, 1, 1, 527400, 1, 1, ''),
	(35, '001-001-000031', '2022-03-02 13:11:48', 5, 1, '1', 781000, 1, 1, 820000, 1, 1, ''),
	(36, '001-001-000032', '2022-03-02 13:12:21', 7, 1, '4', 665000, 2, 1, 0, 1, 1, ''),
	(37, '001-001-000033', '2022-03-04 12:55:13', 2, 1, '1', 0, 1, 1, 1600000, 1, 1, 'T000004'),
	(38, '001-001-000034', '2022-03-06 08:38:16', 8, 1, '4', 527400, 1, 1, 100000, 1, 1, ''),
	(39, '001-001-000035', '2022-04-18 17:23:38', 2, 1, '4', 527400, 2, 1, 0, 1, 1, ''),
	(40, '001-001-000036', '2022-04-18 17:29:47', 8, 1, '2', 45000, 1, 1, 45000, 1, 1, ''),
	(42, '001-001-000037', '2022-05-21 22:30:38', 9, 1, '1', 2774600, 1, 1, 3000000, 1, 1, ''),
	(43, '001-001-000038', '2022-05-21 22:39:05', 2, 1, '1', 665000, 1, 1, 700000, 1, 1, ''),
	(44, '001-001-000039', '2022-06-11 16:57:31', 9, 1, '1', 180000, 1, 1, 200000, 1, 1, ''),
	(45, '001-001-000040', '2022-06-14 09:14:12', 4, 1, '1', 78100, 1, 1, 80000, 1, 1, ''),
	(52, '001-001-000046', '2022-06-15 08:54:00', 9, 1, '1', 147400, 1, 1, 150000, 1, 1, ''),
	(47, '001-001-000041', '2022-06-14 09:51:11', 9, 1, '1', 180000, 1, 1, 200000, 1, 1, ''),
	(48, '001-001-000042', '2022-06-14 09:52:04', 9, 1, '1', 180000, 1, 1, 250000, 1, 1, ''),
	(49, '001-001-000043', '2022-06-14 10:01:41', 7, 1, '4', 60000, 1, 1, 0, 1, 1, ''),
	(50, '001-001-000044', '2022-06-14 10:20:12', 9, 1, '1', 180000, 1, 1, 200000, 1, 1, ''),
	(51, '001-001-000045', '2022-06-14 10:21:10', 9, 1, '1', 180000, 1, 1, 200000, 1, 1, ''),
	(53, '001-001-000047', '2022-06-27 12:52:32', 9, 1, '1', 30000, 1, 1, 50000, 1, 1, ''),
	(54, '001-001-000048', '2022-06-27 12:54:36', 2, 1, '3', 13300, 1, 1, 13300, 1, 1, ''),
	(55, '001-001-000049', '2022-06-27 12:58:01', 9, 1, '1', 6800, 1, 1, 20000, 1, 1, ''),
	(56, '001-001-000050', '2022-06-27 12:58:54', 9, 1, '1', 13300, 1, 1, 50000, 1, 1, ''),
	(57, '001-001-000051', '2022-06-27 13:16:14', 9, 1, '1', 256200, 1, 1, 300000, 1, 1, ''),
	(58, '001-001-000052', '2022-06-27 14:43:17', 2, 1, '1', 255000, 1, 1, 260000, 1, 1, ''),
	(59, '001-001-000053', '2022-06-27 14:45:05', 9, 1, '1', 30000, 1, 1, 50000, 1, 1, ''),
	(60, '001-001-000054', '2022-06-27 14:46:05', 9, 1, '4', 15000, 2, 1, 0, 1, 1, ''),
	(61, '001-001-000055', '2022-06-27 14:48:32', 9, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(62, '001-001-000056', '2022-06-27 14:54:36', 2, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(63, '001-001-000057', '2022-06-27 14:55:24', 9, 1, '1', 15000, 1, 1, 36000, 1, 1, ''),
	(64, '001-001-000058', '2022-06-27 14:55:49', 9, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(65, '001-001-000059', '2022-06-27 14:59:02', 9, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(66, '001-001-000060', '2022-06-27 15:17:35', 9, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(67, '001-001-000061', '2022-06-27 15:43:33', 9, 1, '1', 15000, 1, 1, 22000, 1, 1, ''),
	(68, '001-001-000062', '2022-06-29 12:46:04', 9, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(69, '001-001-000063', '2022-06-30 08:04:32', 9, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(70, '001-001-000064', '2022-06-30 08:07:39', 2, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(71, '001-001-000065', '2022-06-30 08:15:22', 9, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(72, '001-001-000066', '2022-06-30 08:16:20', 9, 1, '1', 15000, 1, 1, 50000, 1, 1, ''),
	(73, '001-001-000067', '2022-06-30 08:17:26', 2, 1, '1', 26600, 1, 1, 32000, 1, 1, ''),
	(74, '001-001-000068', '2022-06-30 08:18:37', 6, 1, '1', 4769250, 1, 1, 5000000, 1, 1, ''),
	(75, '001-001-000069', '2022-06-30 08:21:12', 9, 1, '1', 1518750, 1, 1, 1600000, 1, 1, ''),
	(76, '001-001-000070', '2022-06-30 08:21:50', 2, 1, '1', 1518750, 1, 1, 1600000, 1, 1, ''),
	(77, '001-001-000071', '2022-06-30 08:30:12', 6, 1, '1', 26600, 1, 1, 29000, 1, 1, ''),
	(78, '001-001-000072', '2022-06-30 08:30:52', 6, 1, '1', 26600, 1, 1, 30000, 1, 1, ''),
	(79, '001-001-000073', '2022-06-30 08:31:40', 9, 1, '1', 13300, 1, 1, 30000, 1, 1, ''),
	(80, '001-001-000074', '2022-06-30 08:40:54', 6, 1, '1', 6800, 1, 1, 8000, 1, 1, ''),
	(81, '001-001-000075', '2022-06-30 10:26:53', 9, 1, '1', 15000, 1, 1, 20000, 1, 1, ''),
	(82, '001-001-000076', '2022-06-30 10:28:16', 9, 1, '1', 15000, 1, 1, 15550, 1, 1, '');
/*!40000 ALTER TABLE `facturas_ventas` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.historial_productos
DROP TABLE IF EXISTS `historial_productos`;
CREATE TABLE IF NOT EXISTS `historial_productos` (
  `id_historial` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `id_users` int NOT NULL,
  `fecha_historial` datetime NOT NULL,
  `nota_historial` varchar(255) NOT NULL,
  `referencia_historial` varchar(100) NOT NULL,
  `cantidad_historial` double NOT NULL,
  `tipo_historial` int NOT NULL,
  PRIMARY KEY (`id_historial`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla sist_ventas.historial_productos: ~3 rows (aproximadamente)
INSERT INTO `historial_productos` (`id_historial`, `id_producto`, `id_users`, `fecha_historial`, `nota_historial`, `referencia_historial`, `cantidad_historial`, `tipo_historial`) VALUES
	(1, 17, 1, '2022-05-21 22:32:33', 'eliminó 10000 producto(s) al inventario', 'Inventario 005', 10000, 2),
	(2, 15, 1, '2022-06-10 10:24:52', 'eliminó 979 producto(s) al inventario', 'sdfsdf', 979, 2),
	(3, 16, 1, '2022-06-10 10:25:07', 'eliminó 1186 producto(s) al inventario', 'werwer', 1186, 2),
	(4, 17, 1, '2022-06-10 10:25:51', 'eliminó 2555 producto(s) al inventario', 'fsdf', 2555, 2),
	(5, 23, 1, '2022-06-25 16:57:57', 'agregó 20 producto(s) al inventario', 'invrntat', 20, 1);

-- Volcando estructura para tabla sist_ventas.impuestos
DROP TABLE IF EXISTS `impuestos`;
CREATE TABLE IF NOT EXISTS `impuestos` (
  `id_imp` int NOT NULL AUTO_INCREMENT,
  `nombre_imp` varchar(100) NOT NULL,
  `valor_imp` double NOT NULL,
  `estado_imp` int NOT NULL,
  PRIMARY KEY (`id_imp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.impuestos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sist_ventas.ingresos
DROP TABLE IF EXISTS `ingresos`;
CREATE TABLE IF NOT EXISTS `ingresos` (
  `id_ingreso` int NOT NULL AUTO_INCREMENT,
  `id_consulta` int NOT NULL,
  `id_paciente` int NOT NULL,
  `monto` double NOT NULL,
  `fecha_added` datetime NOT NULL,
  `users` int NOT NULL,
  PRIMARY KEY (`id_ingreso`),
  KEY `id_consulta` (`id_consulta`),
  KEY `id_paciente` (`id_paciente`),
  KEY `users` (`users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.ingresos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sist_ventas.kardex
DROP TABLE IF EXISTS `kardex`;
CREATE TABLE IF NOT EXISTS `kardex` (
  `id_kardex` int NOT NULL AUTO_INCREMENT,
  `fecha_kardex` date NOT NULL,
  `cant_entrada` double NOT NULL,
  `producto_kardex` int NOT NULL,
  `costo_entrada` double NOT NULL,
  `total_entrada` double NOT NULL,
  `cant_salida` double NOT NULL DEFAULT '0',
  `costo_salida` double NOT NULL DEFAULT '0',
  `total_salida` double NOT NULL DEFAULT '0',
  `cant_saldo` double NOT NULL,
  `costo_saldo` double NOT NULL,
  `total_saldo` double NOT NULL,
  `added_kardex` datetime NOT NULL,
  `users_kardex` int NOT NULL,
  `tipo_movimiento` int NOT NULL,
  PRIMARY KEY (`id_kardex`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.kardex: ~134 rows (aproximadamente)
INSERT INTO `kardex` (`id_kardex`, `fecha_kardex`, `cant_entrada`, `producto_kardex`, `costo_entrada`, `total_entrada`, `cant_salida`, `costo_salida`, `total_salida`, `cant_saldo`, `costo_saldo`, `total_saldo`, `added_kardex`, `users_kardex`, `tipo_movimiento`) VALUES
	(1, '2021-08-10', 10, 1, 10000, 100000, 0, 0, 0, 10, 10000, 100000, '2021-08-10 10:26:31', 1, 5),
	(2, '2021-08-10', 5, 1, 15000, 75000, 0, 0, 0, 15, 11666.666666667, 175000, '2021-08-10 12:14:26', 1, 5),
	(3, '2021-08-10', 9, 1, 4000, 36000, 0, 0, 0, 24, 8791.6666666667, 211000, '2021-08-10 12:26:39', 1, 5),
	(4, '2021-08-10', 9, 1, 500, 4500, 0, 0, 0, 33, 6530.303030303, 215500, '2021-08-10 12:27:54', 1, 5),
	(5, '2021-08-10', 9, 1, 4000, 36000, 0, 0, 0, 42, 5988.0952380952, 251500, '2021-08-10 12:32:26', 1, 5),
	(6, '2021-08-10', 9, 1, 7000, 63000, 0, 0, 0, 51, 6166.6666666667, 314500, '2021-08-10 12:33:14', 1, 5),
	(7, '2021-08-10', 999, 1, 5000, 4995000, 0, 0, 0, 1050, 5056.6666666667, 5309500, '2021-08-10 12:35:03', 1, 5),
	(8, '2021-08-10', 80, 1, 5555, 444400, 0, 0, 0, 1130, 5091.9469026549, 5753900, '2021-08-10 12:36:27', 1, 5),
	(9, '2021-08-10', 9, 2, 5900, 53100, 0, 0, 0, 9, 5900, 53100, '2021-08-10 12:39:18', 1, 5),
	(10, '2021-08-13', 10, 3, 20000, 200000, 0, 0, 0, 10, 20000, 200000, '2021-08-13 14:13:02', 1, 5),
	(11, '2021-08-16', 78, 4, 5000, 390000, 0, 0, 0, 78, 5000, 390000, '2021-08-16 14:30:05', 1, 5),
	(12, '2021-08-16', 70, 5, 7000, 490000, 0, 0, 0, 70, 7000, 490000, '2021-08-16 14:34:42', 1, 5),
	(13, '2021-08-16', 9, 7, 50000, 450000, 0, 0, 0, 9, 50000, 450000, '2021-08-16 14:38:38', 1, 5),
	(14, '2021-08-16', 10, 8, 60000, 600000, 0, 0, 0, 10, 60000, 600000, '2021-08-16 14:40:37', 1, 5),
	(15, '2021-08-16', 10, 9, 9000, 90000, 0, 0, 0, 10, 9000, 90000, '2021-08-16 14:42:31', 1, 5),
	(16, '2021-08-16', 10, 10, 10000, 100000, 0, 0, 0, 10, 10000, 100000, '2021-08-16 14:47:43', 1, 5),
	(17, '2021-08-17', 10, 11, 4000, 40000, 0, 0, 0, 10, 4000, 40000, '2021-08-17 07:39:07', 1, 5),
	(18, '2021-08-17', 8, 12, 9000, 72000, 0, 0, 0, 8, 9000, 72000, '2021-08-17 08:24:03', 1, 5),
	(19, '2021-08-17', 2, 13, 5000, 10000, 0, 0, 0, 2, 5000, 10000, '2021-08-17 08:28:05', 1, 5),
	(20, '2021-08-17', 1, 13, 5000, 5000, 0, 0, 0, 3, 5000, 15000, '2021-08-17 00:00:00', 1, 1),
	(21, '2021-08-17', 2, 14, 5000, 10000, 0, 0, 0, 2, 5000, 10000, '2021-08-17 08:35:47', 1, 5),
	(22, '2021-08-31', 3, 14, 5000, 15000, 0, 0, 0, 5, 5000, 25000, '2021-08-31 00:00:00', 1, 1),
	(23, '2021-08-17', 9, 15, 5000, 45000, 0, 0, 0, 9, 5000, 45000, '2021-08-17 09:10:51', 1, 5),
	(24, '2021-08-17', 2, 15, 5000, 10000, 0, 0, 0, 11, 5000, 55000, '2021-08-17 00:00:00', 1, 1),
	(25, '2021-08-26', 500, 10, 10000, 5000000, 0, 0, 0, 510, 10000, 5100000, '2021-08-26 00:00:00', 1, 1),
	(26, '2021-08-26', 18, 11, 6000, 108000, 0, 0, 0, 28, 5285.7142857143, 148000, '2021-08-26 09:41:44', 1, 5),
	(27, '2021-08-29', 10, 11, 9000, 90000, 0, 0, 0, 38, 6263.1578947368, 238000, '2021-08-29 00:00:00', 1, 1),
	(28, '2021-09-09', 25, 12, 5000, 125000, 0, 0, 0, 33, 5969.696969697, 197000, '2021-09-09 13:00:47', 1, 5),
	(29, '2022-02-14', 28, 13, 3400, 95200, 0, 0, 0, 31, 3554.8387096774, 110200, '2022-02-14 07:36:07', 1, 5),
	(30, '2022-02-14', 28, 14, 9500, 266000, 0, 0, 0, 33, 8818.1818181818, 291000, '2022-02-14 08:58:52', 1, 5),
	(31, '2022-02-14', 1000, 15, 110000, 110000000, 0, 0, 0, 1011, 108857.56676558, 110055000, '2022-02-14 09:06:54', 1, 5),
	(32, '2022-02-14', 1200, 16, 30000, 36000000, 0, 0, 0, 1200, 30000, 36000000, '2022-02-14 09:07:48', 1, 5),
	(33, '2022-02-14', 12580, 17, 250000, 3145000000, 0, 0, 0, 12580, 250000, 3145000000, '2022-02-14 09:08:37', 1, 5),
	(34, '2022-02-16', 0, 16, 0, 0, 1, 30000, 30000, 1199, 30000, 35970000, '2022-02-16 11:59:34', 1, 2),
	(35, '2022-02-16', 0, 15, 0, 0, 1, 110000, 110000, 1010, 108857.56676558, 111100000, '2022-02-16 11:59:34', 1, 2),
	(36, '2022-02-16', 0, 17, 0, 0, 2, 250000, 500000, 12578, 250000, 3144500000, '2022-02-16 11:59:34', 1, 2),
	(37, '2022-02-16', 0, 17, 0, 0, 1, 250000, 250000, 12577, 250000, 3144250000, '2022-02-16 12:17:37', 1, 2),
	(38, '2022-02-16', 0, 16, 0, 0, 1, 30000, 30000, 1198, 30000, 35940000, '2022-02-16 12:17:37', 1, 2),
	(39, '2022-02-16', 0, 10, 0, 0, 2, 10000, 20000, 508, 10000, 5080000, '2022-02-16 12:17:37', 1, 2),
	(40, '2022-02-16', 0, 15, 0, 0, 2, 110000, 220000, 1008, 108857.56676558, 110880000, '2022-02-16 12:17:37', 1, 2),
	(41, '2022-02-16', 0, 17, 0, 0, 1, 250000, 250000, 12576, 250000, 3144000000, '2022-02-16 13:07:27', 1, 2),
	(42, '2022-02-16', 0, 16, 0, 0, 1, 30000, 30000, 1197, 30000, 35910000, '2022-02-16 13:07:27', 1, 2),
	(43, '2022-02-16', 0, 15, 0, 0, 1, 110000, 110000, 1007, 108857.56676558, 110770000, '2022-02-16 13:07:27', 1, 2),
	(44, '2022-02-16', 0, 17, 0, 0, 3, 250000, 750000, 12573, 250000, 3143250000, '2022-02-16 13:08:32', 1, 2),
	(45, '2022-02-16', 0, 17, 0, 0, 1, 250000, 250000, 12572, 250000, 3143000000, '2022-02-16 13:33:28', 1, 2),
	(46, '2022-02-16', 0, 16, 0, 0, 1, 30000, 30000, 1196, 30000, 35880000, '2022-02-16 13:33:28', 1, 2),
	(47, '2022-02-16', 0, 15, 0, 0, 1, 110000, 110000, 1006, 108857.56676558, 110660000, '2022-02-16 13:33:28', 1, 2),
	(48, '2022-03-02', 0, 15, 0, 0, 2, 110000, 220000, 1004, 108857.56676558, 110440000, '2022-03-02 13:10:20', 1, 2),
	(49, '2022-03-02', 0, 16, 0, 0, 1, 30000, 30000, 1195, 30000, 35850000, '2022-03-02 13:10:20', 1, 2),
	(50, '2022-03-02', 0, 17, 0, 0, 2, 250000, 500000, 12570, 250000, 3142500000, '2022-03-02 13:10:20', 1, 2),
	(51, '2022-03-02', 0, 15, 0, 0, 5, 110000, 550000, 999, 108857.56676558, 109890000, '2022-03-02 13:11:48', 1, 2),
	(52, '2022-03-02', 0, 17, 0, 0, 2, 250000, 500000, 12568, 250000, 3142000000, '2022-03-02 13:12:21', 1, 2),
	(53, '2022-03-02', 0, 16, 0, 0, 2, 30000, 60000, 1193, 30000, 35790000, '2022-03-02 13:12:21', 1, 2),
	(54, '2022-03-02', 0, 15, 0, 0, 2, 110000, 220000, 997, 108857.56676558, 109670000, '2022-03-02 13:12:21', 1, 2),
	(55, '2022-03-04', 0, 15, 0, 0, 3, 110000, 330000, 994, 108857.56676558, 109340000, '2022-03-04 12:55:13', 1, 2),
	(56, '2022-03-04', 0, 16, 0, 0, 3, 30000, 90000, 1190, 30000, 35700000, '2022-03-04 12:55:13', 1, 2),
	(57, '2022-03-04', 0, 17, 0, 0, 3, 250000, 750000, 12565, 250000, 3141250000, '2022-03-04 12:55:13', 1, 2),
	(58, '2022-03-06', 0, 17, 0, 0, 1, 250000, 250000, 12564, 250000, 3141000000, '2022-03-06 08:38:16', 1, 2),
	(59, '2022-03-06', 0, 16, 0, 0, 1, 30000, 30000, 1189, 30000, 35670000, '2022-03-06 08:38:16', 1, 2),
	(60, '2022-03-06', 0, 15, 0, 0, 1, 110000, 110000, 993, 108857.56676558, 109230000, '2022-03-06 08:38:16', 1, 2),
	(61, '2022-04-18', 0, 17, 0, 0, 1, 250000, 250000, 12563, 250000, 3140750000, '2022-04-18 17:23:38', 1, 2),
	(62, '2022-04-18', 0, 16, 0, 0, 1, 30000, 30000, 1188, 30000, 35640000, '2022-04-18 17:23:38', 1, 2),
	(63, '2022-04-18', 0, 15, 0, 0, 1, 110000, 110000, 992, 108857.56676558, 109120000, '2022-04-18 17:23:38', 1, 2),
	(64, '2022-04-18', 0, 10, 0, 0, 3, 10000, 30000, 505, 10000, 5050000, '2022-04-18 17:29:47', 1, 2),
	(65, '2022-04-18', 0, 18, 1125000, 0, 0, 0, 0, 0, 0, 0, '2022-04-18 17:40:03', 1, 5),
	(66, '2022-04-18', 4, 18, 999999.99, 3999999.96, 0, 0, 0, 4, 999999.99, 3999999.96, '2022-04-18 00:00:00', 1, 1),
	(67, '2022-04-18', 0, 18, 0, 0, 1, 999999.99, 999999.99, 3, 999999.99, 2999999.97, '2022-04-18 17:43:15', 1, 2),
	(68, '2022-05-21', 0, 15, 0, 0, 4, 110000, 440000, 988, 108857.56676558, 108680000, '2022-05-21 22:30:38', 1, 2),
	(69, '2022-05-21', 0, 17, 0, 0, 6, 250000, 1500000, 12557, 250000, 3139250000, '2022-05-21 22:30:38', 1, 2),
	(70, '2022-05-21', 0, 16, 0, 0, 4, 30000, 120000, 1184, 30000, 35520000, '2022-05-21 22:30:38', 1, 2),
	(71, '2022-05-21', 0, 17, 0, 0, 10000, 250000, 2500000000, 2557, 250000, 639250000, '2022-05-21 22:32:33', 1, 4),
	(72, '2022-05-22', 1, 17, 300000, 300000, 0, 0, 0, 2558, 250019.54652072, 639550000, '2022-05-22 00:00:00', 1, 1),
	(73, '2022-05-21', 0, 17, 0, 0, 2, 300000, 600000, 2556, 250019.54652072, 766800000, '2022-05-21 22:39:05', 1, 2),
	(74, '2022-06-07', 369.5, 19, 25000, 9237500, 0, 0, 0, 369.5, 25000, 9237500, '2022-06-07 15:29:34', 1, 5),
	(75, '2022-06-10', 0, 15, 0, 0, 979, 108857.56676558, 106571557.8635, 9, 108857.56676558, 979718.10089022, '2022-06-10 10:24:52', 1, 4),
	(76, '2022-06-10', 0, 16, 0, 0, 1186, 30000, 35580000, -2, 30000, -60000, '2022-06-10 10:25:07', 1, 4),
	(77, '2022-06-10', 0, 17, 0, 0, 2555, 250019.54652072, 638799941.36044, 1, 250019.54652072, 250019.54652072, '2022-06-10 10:25:51', 1, 4),
	(78, '2022-06-10', 3, 15, 25000, 75000, 0, 0, 0, 12, 87893.175074185, 1054718.1008902, '2022-06-10 00:00:00', 1, 1),
	(79, '2022-06-10', 1, 15, 25000, 25000, 0, 0, 0, 13, 83055.238530015, 1079718.1008902, '2022-06-10 00:00:00', 1, 1),
	(80, '2022-06-10', 1, 16, 90000, 90000, 0, 0, 0, -1, -30000, 30000, '2022-06-10 00:00:00', 1, 1),
	(81, '2022-06-11', 0, 10, 0, 0, 12, 10000, 120000, 493, 10000, 4930000, '2022-06-11 16:57:31', 1, 2),
	(82, '2022-06-14', 0, 15, 0, 0, 1, 25000, 25000, 12, 83055.238530015, 300000, '2022-06-14 09:14:12', 1, 2),
	(83, '2022-06-14', 0, 10, 0, 0, 12, 10000, 120000, 481, 10000, 4810000, '2022-06-14 09:50:54', 1, 2),
	(84, '2022-06-14', 0, 10, 0, 0, 12, 10000, 120000, 469, 10000, 4690000, '2022-06-14 09:51:11', 1, 2),
	(85, '2022-06-14', 0, 10, 0, 0, 12, 10000, 120000, 457, 10000, 4570000, '2022-06-14 09:52:04', 1, 2),
	(86, '2022-06-14', 0, 10, 0, 0, 12, 10000, 120000, 445, 10000, 4450000, '2022-06-14 09:56:53', 1, 2),
	(87, '2022-06-14', 0, 10, 0, 0, 4, 10000, 40000, 441, 10000, 4410000, '2022-06-14 10:01:41', 1, 2),
	(88, '2022-06-14', 0, 10, 0, 0, 12, 10000, 120000, 429, 10000, 4290000, '2022-06-14 10:05:10', 1, 2),
	(89, '2022-06-14', 0, 10, 0, 0, 12, 10000, 120000, 417, 10000, 4170000, '2022-06-14 10:20:12', 1, 2),
	(90, '2022-06-14', 0, 10, 0, 0, 12, 10000, 120000, 405, 10000, 4050000, '2022-06-14 10:20:40', 1, 2),
	(91, '2022-06-14', 0, 10, 0, 0, 12, 10000, 120000, 393, 10000, 3930000, '2022-06-14 10:20:43', 1, 2),
	(92, '2022-06-14', 0, 10, 0, 0, 12, 10000, 120000, 381, 10000, 3810000, '2022-06-14 10:20:51', 1, 2),
	(93, '2022-06-14', 0, 10, 0, 0, 12, 10000, 120000, 369, 10000, 3690000, '2022-06-14 10:20:55', 1, 2),
	(94, '2022-06-14', 0, 10, 0, 0, 12, 10000, 120000, 357, 10000, 3570000, '2022-06-14 10:21:10', 1, 2),
	(95, '2022-06-15', 45545, 21, 24234, 1103737530, 0, 0, 0, 45545, 24234, 1103737530, '2022-06-15 08:51:25', 1, 5),
	(96, '2022-06-15', 0, 13, 0, 0, 2, 3400, 6800, 29, 3554.8387096774, 98600, '2022-06-15 08:54:00', 1, 2),
	(97, '2022-06-15', 0, 11, 0, 0, 3, 9000, 27000, 35, 6263.1578947368, 315000, '2022-06-15 08:54:00', 1, 2),
	(98, '2022-06-15', 0, 10, 0, 0, 7, 10000, 70000, 350, 10000, 3500000, '2022-06-15 08:54:00', 1, 2),
	(99, '2022-06-20', 0, 22, 4545455, 0, 0, 0, 0, 0, 0, 0, '2022-06-20 10:20:58', 1, 5),
	(100, '2022-06-25', 80, 23, 50000, 4000000, 0, 0, 0, 80, 50000, 4000000, '2022-06-25 16:56:45', 1, 5),
	(101, '2022-06-25', 20, 23, 50000, 1000000, 0, 0, 0, 100, 50000, 5000000, '2022-06-25 16:57:57', 1, 3),
	(102, '2022-06-25', 10, 10, 10000, 100000, 0, 0, 0, 360, 10000, 3600000, '2022-06-25 00:00:00', 1, 1),
	(103, '2022-06-27', 0, 10, 0, 0, 2, 10000, 20000, 358, 10000, 3580000, '2022-06-27 12:52:32', 1, 2),
	(104, '2022-06-27', 0, 14, 0, 0, 1, 9500, 9500, 32, 8818.1818181818, 304000, '2022-06-27 12:54:36', 1, 2),
	(105, '2022-06-27', 0, 13, 0, 0, 1, 3400, 3400, 28, 3554.8387096774, 95200, '2022-06-27 12:58:01', 1, 2),
	(106, '2022-06-27', 0, 14, 0, 0, 1, 9500, 9500, 31, 8818.1818181818, 294500, '2022-06-27 12:58:54', 1, 2),
	(107, '2022-06-27', 0, 16, 0, 0, 1, 90000, 90000, -2, -30000, -180000, '2022-06-27 13:16:14', 1, 2),
	(108, '2022-06-27', 0, 15, 0, 0, 1, 25000, 25000, 11, 83055.238530015, 275000, '2022-06-27 13:16:14', 1, 2),
	(109, '2022-06-27', 0, 10, 0, 0, 17, 10000, 170000, 341, 10000, 3410000, '2022-06-27 14:43:17', 1, 2),
	(110, '2022-06-27', 0, 10, 0, 0, 2, 10000, 20000, 339, 10000, 3390000, '2022-06-27 14:45:05', 1, 2),
	(111, '2022-06-27', 0, 10, 0, 0, 1, 10000, 10000, 338, 10000, 3380000, '2022-06-27 14:46:05', 1, 2),
	(112, '2022-06-27', 0, 10, 0, 0, 1, 10000, 10000, 337, 10000, 3370000, '2022-06-27 14:48:32', 1, 2),
	(113, '2022-06-27', 0, 10, 0, 0, 1, 10000, 10000, 336, 10000, 3360000, '2022-06-27 14:54:36', 1, 2),
	(114, '2022-06-27', 0, 10, 0, 0, 1, 10000, 10000, 335, 10000, 3350000, '2022-06-27 14:55:24', 1, 2),
	(115, '2022-06-27', 0, 10, 0, 0, 1, 10000, 10000, 334, 10000, 3340000, '2022-06-27 14:55:49', 1, 2),
	(116, '2022-06-27', 0, 10, 0, 0, 1, 10000, 10000, 333, 10000, 3330000, '2022-06-27 14:59:02', 1, 2),
	(117, '2022-06-27', 0, 10, 0, 0, 1, 10000, 10000, 332, 10000, 3320000, '2022-06-27 15:17:35', 1, 2),
	(118, '2022-06-27', 0, 10, 0, 0, 1, 10000, 10000, 331, 10000, 3310000, '2022-06-27 15:43:33', 1, 2),
	(119, '2022-06-29', 0, 10, 0, 0, 1, 10000, 10000, 330, 10000, 3300000, '2022-06-29 12:46:04', 1, 2),
	(120, '2022-06-30', 0, 10, 0, 0, 1, 10000, 10000, 329, 10000, 3290000, '2022-06-30 08:04:32', 1, 2),
	(121, '2022-06-30', 0, 10, 0, 0, 1, 10000, 10000, 328, 10000, 3280000, '2022-06-30 08:07:39', 1, 2),
	(122, '2022-06-30', 0, 10, 0, 0, 1, 10000, 10000, 327, 10000, 3270000, '2022-06-30 08:15:22', 1, 2),
	(123, '2022-06-30', 0, 10, 0, 0, 1, 10000, 10000, 326, 10000, 3260000, '2022-06-30 08:16:20', 1, 2),
	(124, '2022-06-30', 0, 14, 0, 0, 2, 9500, 19000, 29, 8818.1818181818, 275500, '2022-06-30 08:17:26', 1, 2),
	(125, '2022-06-30', 0, 19, 0, 0, 6, 25000, 150000, 363.5, 25000, 9087500, '2022-06-30 08:18:37', 1, 2),
	(126, '2022-06-30', 0, 18, 0, 0, 3, 999999.99, 2999999.97, 0, 999999.99, 0, '2022-06-30 08:18:37', 1, 2),
	(127, '2022-06-30', 0, 18, 0, 0, 1, 999999.99, 999999.99, -1, 999999.99, -999999.99, '2022-06-30 08:21:12', 1, 2),
	(128, '2022-06-30', 0, 18, 0, 0, 1, 999999.99, 999999.99, -2, 999999.99, -1999999.98, '2022-06-30 08:21:50', 1, 2),
	(129, '2022-06-30', 0, 14, 0, 0, 2, 9500, 19000, 27, 8818.1818181818, 256500, '2022-06-30 08:30:12', 1, 2),
	(130, '2022-06-30', 0, 14, 0, 0, 2, 9500, 19000, 25, 8818.1818181818, 237500, '2022-06-30 08:30:52', 1, 2),
	(131, '2022-06-30', 0, 14, 0, 0, 1, 9500, 9500, 24, 8818.1818181818, 228000, '2022-06-30 08:31:40', 1, 2),
	(132, '2022-06-30', 0, 13, 0, 0, 1, 3400, 3400, 27, 3554.8387096774, 91800, '2022-06-30 08:40:54', 1, 2),
	(133, '2022-06-30', 0, 10, 0, 0, 1, 10000, 10000, 325, 10000, 3250000, '2022-06-30 10:26:53', 1, 2),
	(134, '2022-06-30', 0, 10, 0, 0, 1, 10000, 10000, 324, 10000, 3240000, '2022-06-30 10:28:16', 1, 2),
	(135, '2022-07-02', 2, 24, 25000, 50000, 0, 0, 0, 2, 25000, 50000, '2022-07-02 09:46:32', 1, 5),
	(136, '2022-07-02', 2, 25, 10000, 20000, 0, 0, 0, 2, 10000, 20000, '2022-07-02 10:13:27', 1, 5),
	(137, '2022-07-02', 2, 26, 25000, 50000, 0, 0, 0, 2, 25000, 50000, '2022-07-02 10:14:40', 1, 5);

-- Volcando estructura para tabla sist_ventas.lineas
DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int NOT NULL AUTO_INCREMENT,
  `nombre_linea` varchar(255) NOT NULL,
  `descripcion_linea` text NOT NULL,
  `estado_linea` int NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id_linea`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.lineas: ~2 rows (aproximadamente)
INSERT INTO `lineas` (`id_linea`, `nombre_linea`, `descripcion_linea`, `estado_linea`, `date_added`) VALUES
	(1, 'POXIPOL', '', 1, '2021-08-07 10:18:38'),
	(2, 'TERERE', '', 1, '2021-08-13 09:46:33');

-- Volcando estructura para tabla sist_ventas.modulos
DROP TABLE IF EXISTS `modulos`;
CREATE TABLE IF NOT EXISTS `modulos` (
  `id_modulo` int NOT NULL AUTO_INCREMENT,
  `nombre_modulo` varchar(30) NOT NULL,
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.modulos: ~11 rows (aproximadamente)
INSERT INTO `modulos` (`id_modulo`, `nombre_modulo`) VALUES
	(1, 'Inicio'),
	(2, 'Productos'),
	(3, 'Proveedores'),
	(4, 'Clientes'),
	(5, 'Reportes'),
	(6, 'Configuracion'),
	(7, 'Usuarios'),
	(8, 'Permisos'),
	(9, 'Categorias'),
	(10, 'Ventas'),
	(11, 'Compras');

-- Volcando estructura para tabla sist_ventas.perfil
DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `id_perfil` int NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `giro_empresa` text NOT NULL,
  `fiscal_empresa` varchar(25) NOT NULL,
  `direccion` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ciudad` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `codigo_postal` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estado` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `telefono` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `impuesto` int NOT NULL,
  `nom_impuesto` varchar(50) NOT NULL,
  `moneda` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `logo_url` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.perfil: ~0 rows (aproximadamente)
INSERT INTO `perfil` (`id_perfil`, `nombre_empresa`, `giro_empresa`, `fiscal_empresa`, `direccion`, `ciudad`, `codigo_postal`, `estado`, `telefono`, `email`, `impuesto`, `nom_impuesto`, `moneda`, `logo_url`) VALUES
	(1, 'VIAWEB SOFT', 'SISTEMA DE VENTAS', '5971557-0', 'AV. SAN BLAS', 'CIUDAD DEL ESTE', '7000', 'ALTO PARANA', '0973 118 404', 'info@softys.com', 10, 'IVA', 'Gs', '../../img/1655304455_Logo-oroty.png');

-- Volcando estructura para tabla sist_ventas.productos
DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `codigo_producto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `descripcion_producto` text NOT NULL,
  `id_linea_producto` int NOT NULL,
  `id_med_producto` int DEFAULT NULL,
  `id_proveedor` int NOT NULL,
  `inv_producto` tinyint DEFAULT NULL,
  `iva_producto` tinyint DEFAULT NULL,
  `estado_producto` tinyint DEFAULT NULL,
  `costo_producto` double DEFAULT NULL,
  `utilidad_producto` double DEFAULT NULL,
  `moneda_producto` int DEFAULT NULL,
  `valor1_producto` double DEFAULT NULL,
  `valor2_producto` double DEFAULT NULL,
  `valor3_producto` double DEFAULT NULL,
  `stock_producto` double DEFAULT NULL,
  `stock_min_producto` double DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `image_path` varchar(300) DEFAULT NULL,
  `id_imp_producto` int DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `id_cat_producto` (`id_linea_producto`),
  KEY `id_proveedor` (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Volcando datos para la tabla sist_ventas.productos: ~12 rows (aproximadamente)
INSERT INTO `productos` (`id_producto`, `codigo_producto`, `nombre_producto`, `descripcion_producto`, `id_linea_producto`, `id_med_producto`, `id_proveedor`, `inv_producto`, `iva_producto`, `estado_producto`, `costo_producto`, `utilidad_producto`, `moneda_producto`, `valor1_producto`, `valor2_producto`, `valor3_producto`, `stock_producto`, `stock_min_producto`, `date_added`, `image_path`, `id_imp_producto`) VALUES
	(10, '12222', 'POXIPOL', 'POXIPOL', 1, NULL, 1, 0, 10, 1, 10000, 50, NULL, 15000, 14000, 13000, 259, 1, '2021-08-16 14:47:43', '../../img/productos/1629386610_500px-General_Electric_logo.svg.png', 0),
	(11, '12223', 'EFFFFF', 'EFEF', 2, NULL, 1, 0, 10, 1, 9000, 60, NULL, 9600, 9500, 9000, 16, 1, '2021-08-26 09:41:44', NULL, 0),
	(12, '12224', 'VARILLA DE 4,2 MM', 'ASDASD', 2, NULL, 1, 0, 10, 1, 5000, 60, NULL, 8000, 7500, 7000, 0, 1, '2021-09-09 13:00:47', NULL, 0),
	(13, '12225', 'DFSF', 'LMDPWMDPWE', 1, NULL, 1, 0, 10, 1, 3400, 100, NULL, 6800, 6500, 6200, 24, 3, '2022-02-14 07:36:07', NULL, 0),
	(14, '12226', 'EEEEEEEE', 'MAKLDJLKAS', 2, NULL, 1, 0, 0, 1, 9500, 40, NULL, 13300, 12000, 11000, 19, 1, '2022-02-14 08:58:52', NULL, 0),
	(15, '12227', 'PRODUCTO IVA 10', 'IVA 10', 2, NULL, 1, 0, 10, 1, 25000, 42, NULL, 156200, 150000, 130000, 2, 1, '2022-02-14 09:06:54', NULL, 0),
	(16, '12228', 'PRODUCTO IVA 5', 'IVA 5', 1, NULL, 2, 0, 5, 1, 90000, 29, NULL, 38700, 37000, 36000, 0, 1, '2022-02-14 09:07:48', NULL, 0),
	(17, '12229', 'PRODUCTO EXENTO', 'EXENTO DE IVA', 2, NULL, 1, 0, 0, 1, 300000, 33, NULL, 332500, 300000, 285000, 0, 1, '2022-02-14 09:08:37', NULL, 0),
	(18, '12230', 'COMPRESOR 50 LTS', 'COMPRESOR 50 LTS DAEWOO', 2, NULL, 4, 1, 10, 1, 999999.99, 35, NULL, 1518750, 1250000, 0, 4, 1, '2022-04-18 17:40:03', NULL, 0),
	(19, '12231', 'PISO LOCO', 'PISO LOCO LUME', 2, NULL, 1, 0, 10, 1, 25000, 42, NULL, 35500, 33000, 31500, 363.5, 1, '2022-06-07 15:29:34', NULL, 0),
	(20, '12232', '', '', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-06-15 08:51:23', '../../img/productos/1655304683_oferta-celite-36.png', NULL),
	(21, '12232', 'FDD', 'FDGDFGFD', 1, NULL, 2, 0, 10, 1, 24234, 34, NULL, 32474, 34, 3434, 45545, 1, '2022-06-15 08:51:25', NULL, 0),
	(22, '12233', '345435', '345345345', 1, NULL, 2, 1, 10, 1, 4545455, 45, NULL, 6590910, 23333333, 33343434, 0, 1, '2022-06-20 10:20:58', NULL, 0),
	(23, '12234', 'GRGREG', 'DFGDFGDFG', 1, NULL, 1, 0, 10, 1, 50000, 50, NULL, 75000, 72000, 65000, 100, 1, '2022-06-25 16:56:45', NULL, 0),
	(24, '558-9', 'ALKHDSA', 'ASDJASDSA', 1, NULL, 2, 0, 10, 1, 25000, 42, NULL, 35500, 35500, 35500, 2, 1, '2022-07-02 09:46:32', NULL, 0),
	(25, '5555-55', 'TTTTTTTTTTTTTTTTTTTTTTT', 'TTTTTTTTTTTTT', 2, NULL, 6, 0, 10, 1, 10000, 42, NULL, 14200, 14200, 14200, 2, 1, '2022-07-02 10:13:27', NULL, 0),
	(26, '55588-99', 'HUIOASHD', 'ASDASDAS', 1, NULL, 6, 0, 10, 1, 25000, 42, NULL, 35500, 35000, 35000, 2, 1, '2022-07-02 10:14:40', NULL, 0);

-- Volcando estructura para tabla sist_ventas.proveedores
DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id_proveedor` int NOT NULL AUTO_INCREMENT,
  `nombre_proveedor` varchar(255) NOT NULL,
  `fiscal_proveedor` varchar(100) NOT NULL,
  `web_proveedor` varchar(255) NOT NULL,
  `direccion_proveedor` text NOT NULL,
  `contacto_proveedor` varchar(255) NOT NULL,
  `email_proveedor` varchar(255) NOT NULL,
  `telefono_proveedor` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `estado_proveedor` tinyint NOT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.proveedores: ~3 rows (aproximadamente)
INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`, `fiscal_proveedor`, `web_proveedor`, `direccion_proveedor`, `contacto_proveedor`, `email_proveedor`, `telefono_proveedor`, `date_added`, `estado_proveedor`) VALUES
	(1, 'ELECTROPARANA', '23423432', 'sdfds', 'SFSDFS', 'SDFDS', '23423432@asdasd.com', '234234', '2021-08-07 10:20:16', 1),
	(2, 'ASDADAS', '12312312', 'wwwwwww', 'ZXCZXCZXCX', 'ADASDSAD', 'asadasd@adsadas.com', '13123123', '2021-08-10 09:57:16', 1),
	(3, 'yyyyyy', '55666', 'ghhgh', 'fgfhfghgfh', 'fhfghfg', 'adsad@ssd.com', '56567657', '2021-08-20 09:44:16', 1),
	(4, 'CASA DE LOS COMPRESORES', '452145222', 'MELLA.COM', 'KM 9', 'ALBERTO', 'MELLA@MELLA.COM', '5959876352541', '2022-04-18 17:37:55', 1),
	(5, 'Distrisool', '80087596-0', '', 'asdasdsad', 'MArcos', 'asdasdsad@jhasdjh.com', '0987565745', '2022-05-21 22:35:36', 1),
	(6, 'Alltech Paraguay S.R.L.', '80081276-0', 'alltech.com', 'Parque Emp. San Juan - Bloque F - Deposito 9', 'Luis', 'l@alltech.com', '098884475', '2022-06-10 07:55:18', 1);

-- Volcando estructura para tabla sist_ventas.stock
DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id_stock` int NOT NULL AUTO_INCREMENT,
  `id_producto_stock` int NOT NULL,
  `id_sucursal_stock` int NOT NULL,
  `cantidad_stock` double NOT NULL,
  PRIMARY KEY (`id_stock`),
  KEY `id_producto_stock` (`id_producto_stock`),
  KEY `id_sucursal_stock` (`id_sucursal_stock`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.stock: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sist_ventas.sucursales
DROP TABLE IF EXISTS `sucursales`;
CREATE TABLE IF NOT EXISTS `sucursales` (
  `id_sucursal` int NOT NULL AUTO_INCREMENT,
  `codigo_sucursal` varchar(50) NOT NULL,
  `nombre_sucursal` varchar(255) NOT NULL,
  `direccion_sucursal` text NOT NULL,
  `limite_sucursal` double NOT NULL,
  `estado_sucursal` tinyint NOT NULL,
  `fecha_added` datetime NOT NULL,
  PRIMARY KEY (`id_sucursal`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.sucursales: ~0 rows (aproximadamente)
INSERT INTO `sucursales` (`id_sucursal`, `codigo_sucursal`, `nombre_sucursal`, `direccion_sucursal`, `limite_sucursal`, `estado_sucursal`, `fecha_added`) VALUES
	(1, 'SC001', 'CASA MATRIZ', 'AV. SAN BLAS', 40, 1, '2018-01-05 11:09:49');

-- Volcando estructura para tabla sist_ventas.tmp_compra
DROP TABLE IF EXISTS `tmp_compra`;
CREATE TABLE IF NOT EXISTS `tmp_compra` (
  `id_tmp` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `cantidad_tmp` double NOT NULL,
  `costo_tmp` double(8,2) DEFAULT NULL,
  `session_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_tmp`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.tmp_compra: 6 rows
/*!40000 ALTER TABLE `tmp_compra` DISABLE KEYS */;
INSERT INTO `tmp_compra` (`id_tmp`, `id_producto`, `cantidad_tmp`, `costo_tmp`, `session_id`) VALUES
	(9, 10, 22, 10000.00, 'g4bvpv44lf3gfb1u7f021esur5'),
	(10, 10, 9, 10000.00, 'l9n5qpp44dp6ldsdimijbgc1j3'),
	(13, 10, 3, 10000.00, 'li496q7hqvugkuh8hvu8cj3jkm'),
	(14, 15, 1, 110000.00, 'sprq66peakr21o3dv2cvot13r9'),
	(15, 16, 1, 30000.00, 'sprq66peakr21o3dv2cvot13r9'),
	(16, 17, 3, 250000.00, 'sprq66peakr21o3dv2cvot13r9');
/*!40000 ALTER TABLE `tmp_compra` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.tmp_cotizacion
DROP TABLE IF EXISTS `tmp_cotizacion`;
CREATE TABLE IF NOT EXISTS `tmp_cotizacion` (
  `id_tmp` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `cantidad_tmp` double NOT NULL,
  `precio_tmp` double DEFAULT NULL,
  `desc_tmp` int NOT NULL,
  `session_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id_tmp`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla sist_ventas.tmp_cotizacion: 2 rows
/*!40000 ALTER TABLE `tmp_cotizacion` DISABLE KEYS */;
INSERT INTO `tmp_cotizacion` (`id_tmp`, `id_producto`, `cantidad_tmp`, `precio_tmp`, `desc_tmp`, `session_id`) VALUES
	(3, 10, 1, 14000, 0, '2fvlpd19e02gfnlvq04vnk4412'),
	(4, 11, 1, 9600, 0, '2fvlpd19e02gfnlvq04vnk4412');
/*!40000 ALTER TABLE `tmp_cotizacion` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.tmp_ventas
DROP TABLE IF EXISTS `tmp_ventas`;
CREATE TABLE IF NOT EXISTS `tmp_ventas` (
  `id_tmp` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `cantidad_tmp` double NOT NULL,
  `precio_tmp` double DEFAULT NULL,
  `desc_tmp` int NOT NULL,
  `session_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_tmp`)
) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla sist_ventas.tmp_ventas: 6 rows
/*!40000 ALTER TABLE `tmp_ventas` DISABLE KEYS */;
INSERT INTO `tmp_ventas` (`id_tmp`, `id_producto`, `cantidad_tmp`, `precio_tmp`, `desc_tmp`, `session_id`) VALUES
	(25, 10, 1, 14000, 0, '52pc1sg1s5v0vfkvg77u4clak0'),
	(72, 17, 2, 332500, 0, 'li496q7hqvugkuh8hvu8cj3jkm'),
	(71, 16, 1, 38700, 0, 'li496q7hqvugkuh8hvu8cj3jkm'),
	(70, 15, 1, 156200, 0, 'li496q7hqvugkuh8hvu8cj3jkm'),
	(88, 10, 1, 14000, 0, '39ac4kcpfgohuuomqacpsbhjue'),
	(117, 10, 3, 15000, 100, '2br5cc355c9jjfl5a40qfcn63v');
/*!40000 ALTER TABLE `tmp_ventas` ENABLE KEYS */;

-- Volcando estructura para tabla sist_ventas.traslados
DROP TABLE IF EXISTS `traslados`;
CREATE TABLE IF NOT EXISTS `traslados` (
  `id_traslado` int NOT NULL AUTO_INCREMENT,
  `referencia_traslado` varchar(50) NOT NULL,
  `origen_traslado` int NOT NULL,
  `destino_traslado` int NOT NULL,
  `monto_traslado` int NOT NULL,
  `fecha_added` datetime NOT NULL,
  `id_users` int NOT NULL,
  `num_transaccion` varchar(50) NOT NULL,
  `estado_traslado` tinyint NOT NULL,
  PRIMARY KEY (`id_traslado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.traslados: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sist_ventas.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_users` int NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `nombre_users` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `apellido_users` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usuario_users` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `con_users` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `email_users` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `tipo_users` tinyint NOT NULL,
  `cargo_users` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sucursal_users` tinyint NOT NULL,
  `date_added` datetime NOT NULL,
  `comision_users` double NOT NULL,
  PRIMARY KEY (`id_users`),
  UNIQUE KEY `user_name` (`usuario_users`),
  UNIQUE KEY `user_email` (`email_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

-- Volcando datos para la tabla sist_ventas.users: ~0 rows (aproximadamente)
INSERT INTO `users` (`id_users`, `nombre_users`, `apellido_users`, `usuario_users`, `con_users`, `email_users`, `tipo_users`, `cargo_users`, `sucursal_users`, `date_added`, `comision_users`) VALUES
	(0, 'STELLA', 'PALACIOS', 'ventas', '$2y$10$IrzX8Zz02PVpECKBFKAeh.6xO8K56o7x92XxP.h/0TD4OOt8rX5q6', 'stella@stella.com', 0, '3', 1, '2022-06-15 13:34:11', 0),
	(1, 'SUPER', 'ADMINISTRADOR', 'admin', '$2y$10$MPVHzZ2ZPOWmtUUGCq3RXu31OTB.jo7M9LZ7PmPQYmgETSNn19ejO', 'root@admin.com', 0, '1', 1, '2016-05-21 15:06:00', 0);

-- Volcando estructura para tabla sist_ventas.user_group
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE IF NOT EXISTS `user_group` (
  `user_group_id` int NOT NULL,
  `name` varchar(64) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `permission` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`user_group_id`),
  KEY `user_group_id` (`user_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sist_ventas.user_group: ~4 rows (aproximadamente)
INSERT INTO `user_group` (`user_group_id`, `name`, `permission`, `date_added`) VALUES
	(1, 'Super Administrador', 'Inicio,1,1,1;Productos,1,1,1;Proveedores,1,1,1;Clientes,1,1,1;Reportes,1,1,1;Configuracion,1,1,1;Usuarios,1,1,1;Permisos,1,1,1;Categorias,1,1,1;Ventas,1,1,1;Compras,1,1,1;', '2017-08-09 10:22:15'),
	(2, 'GERENTE', 'Inicio,1,0,0;Productos,1,0,0;Proveedores,1,0,0;Clientes,1,0,0;Reportes,1,0,0;Configuracion,1,0,0;Usuarios,1,0,0;Permisos,1,0,0;Categorias,1,0,0;Ventas,1,1,0;Compras,1,0,0;', '2017-08-09 11:31:34'),
	(3, 'FACTURADOR', 'Inicio,0,0,0;Productos,1,0,0;Proveedores,1,0,0;Clientes,1,0,0;Reportes,0,0,0;Configuracion,0,0,0;Usuarios,0,0,0;Permisos,0,0,0;Categorias,0,0,0;Ventas,1,0,0;Compras,0,0,0;', '2017-09-15 22:44:50'),
	(4, 'ADMINISTRADOR', 'Inicio,1,1,1;Productos,1,1,1;Proveedores,1,1,1;Clientes,1,1,1;Reportes,1,1,1;Configuracion,1,1,1;Usuarios,1,1,1;Permisos,1,1,1;Categorias,1,1,1;Ventas,1,1,1;Compras,1,1,1;', '2017-11-21 11:33:36');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
