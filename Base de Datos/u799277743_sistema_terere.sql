-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 10, 2022 at 04:13 AM
-- Server version: 10.5.16-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u799277743_sistema_terere`
--

-- --------------------------------------------------------

--
-- Table structure for table `caja_chica`
--

CREATE TABLE `caja_chica` (
  `id_caja` int(11) NOT NULL,
  `referencia_caja` varchar(255) NOT NULL,
  `monto_caja` double NOT NULL,
  `descripcion_caja` varchar(255) NOT NULL,
  `tipo_caja` tinyint(4) NOT NULL,
  `users_caja` int(11) NOT NULL,
  `date_added_caja` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `nombre_cargo` varchar(255) NOT NULL,
  `estado_cargo` varchar(11) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `fiscal_cliente` varchar(255) NOT NULL,
  `telefono_cliente` char(30) NOT NULL,
  `email_cliente` varchar(64) NOT NULL,
  `direccion_cliente` varchar(255) NOT NULL,
  `status_cliente` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `fiscal_cliente`, `telefono_cliente`, `email_cliente`, `direccion_cliente`, `status_cliente`, `date_added`) VALUES
(1, 'ANTONIO ELECTRO NACHO', '', '5555555555', '', 'HERNANDARIAS', 1, '2022-07-09 08:26:34'),
(2, 'BLAS ANTONIO BRITOS MORENO', '4333132-7', '0985640670', '', 'SAN LORENZO', 1, '2022-07-09 12:17:22'),
(3, 'CHRISTIAN LOPEZ MACIEL', '321456987', '365214', '', 'A 50 MTS CALLE 2000 BO. CIUDAD NUEVA', 1, '2022-07-09 16:04:13'),
(4, 'DERLIS JAVIER AGUERO AQUINO', '45654565', '54653212', '', 'BO CATEDRAL', 1, '2022-07-09 16:34:43'),
(5, 'CONFORPES PARAGUAY S.A.', '56987545', '0992577325', '', '', 1, '2022-07-09 16:43:45'),
(6, 'JULIO QUINTANA', '546598781232', '32156848', '', '', 1, '2022-07-09 16:49:06'),
(7, 'MANUEL GONZALEZ', '123456', '32165488', '', 'KM 9', 1, '2022-07-09 16:55:19'),
(8, 'MARCELO INTERESADO EN COMPRESOR', '521478963', '365241', '', '', 1, '2022-07-09 16:59:51'),
(9, 'MIGUEL RIVAROLA', '1245', '6545', '', '', 1, '2022-07-09 17:06:35'),
(10, 'MIGUEL ROMERO', '526341', '526341', '', '', 1, '2022-07-09 17:08:51'),
(11, 'NACHO MECANICO', '654321', '65412255', '', '', 1, '2022-07-09 17:18:37'),
(12, 'MAURA BRITOS ROMERO', '654789', '061-550522', '', '', 1, '2022-07-09 19:28:20'),
(13, 'WALTER INSAURRALDE REFRIGERACION', '6352634180', '3256', '', '', 1, '2022-07-09 19:36:45'),
(14, 'EDGAR LUIS AGUIRRE PEREZ', '951753', '951753', '', '', 1, '2022-07-09 19:39:01'),
(15, 'ELVIO BRITOS ROMERO', '891846', '0983596504', '', 'SANTA FE', 1, '2022-07-09 19:56:53');

-- --------------------------------------------------------

--
-- Table structure for table `comprobantes`
--

CREATE TABLE `comprobantes` (
  `id_comp` int(11) NOT NULL,
  `nombre_comp` varchar(100) NOT NULL,
  `serie_comp` varchar(100) NOT NULL,
  `desde_comp` int(11) NOT NULL,
  `hasta_comp` int(11) NOT NULL,
  `long_comp` int(11) NOT NULL,
  `actual_comp` int(11) NOT NULL,
  `vencimiento_comp` date NOT NULL,
  `estado_comp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comprobantes`
--

INSERT INTO `comprobantes` (`id_comp`, `nombre_comp`, `serie_comp`, `desde_comp`, `hasta_comp`, `long_comp`, `actual_comp`, `vencimiento_comp`, `estado_comp`) VALUES
(1, 'FACTURA UNO', '001-001-', 1, 999999, 6, 0, '2021-12-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `creditos`
--

CREATE TABLE `creditos` (
  `id_credito` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_credito` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `monto_credito` double NOT NULL,
  `saldo_credito` double NOT NULL,
  `estado_credito` tinyint(1) NOT NULL,
  `id_users_credito` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `creditos`
--

INSERT INTO `creditos` (`id_credito`, `numero_factura`, `fecha_credito`, `id_cliente`, `id_vendedor`, `monto_credito`, `saldo_credito`, `estado_credito`, `id_users_credito`, `id_sucursal`) VALUES
(1, '001-001-000000', '2022-07-09 08:40:47', 1, 1, 800000, 400000, 1, 1, 1),
(2, '001-001-000001', '2022-07-09 16:13:33', 3, 1, 3650000, 600000, 1, 1, 1),
(3, '001-001-000002', '2022-07-09 16:24:13', 3, 1, 150000, 150000, 1, 1, 1),
(4, '001-001-000003', '2022-07-09 16:35:41', 4, 1, 1950000, 450000, 1, 1, 1),
(5, '001-001-000004', '2022-07-09 16:44:56', 5, 1, 1890000, 630000, 1, 1, 1),
(6, '001-001-000005', '2022-07-09 16:50:31', 6, 1, 6300000, 2900000, 1, 1, 1),
(7, '001-001-000006', '2022-07-09 16:55:40', 7, 1, 900000, 400000, 1, 1, 1),
(8, '001-001-000007', '2022-07-09 17:00:57', 8, 1, 3600000, 1200000, 1, 1, 1),
(9, '001-001-000008', '2022-07-09 17:07:30', 9, 1, 8300000, 3400000, 1, 1, 1),
(10, '001-001-000009', '2022-07-09 17:14:26', 10, 1, 1100000, 150000, 1, 1, 1),
(11, '001-001-000010', '2022-07-09 17:24:54', 11, 1, 5295000, 4380000, 1, 1, 1),
(12, '001-001-000011', '2022-07-09 19:32:03', 12, 1, 2000000, 1000000, 1, 1, 1),
(13, '001-001-000012', '2022-07-09 19:37:21', 13, 1, 2000000, 700000, 1, 1, 1),
(14, '001-001-000013', '2022-07-09 19:43:08', 14, 1, 3450000, -335000, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `creditos_abonos`
--

CREATE TABLE `creditos_abonos` (
  `id_abono` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_abono` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `monto_abono` double NOT NULL,
  `abono` double NOT NULL,
  `saldo_abono` double NOT NULL,
  `id_users_abono` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `concepto_abono` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `creditos_abonos`
--

INSERT INTO `creditos_abonos` (`id_abono`, `numero_factura`, `fecha_abono`, `id_cliente`, `monto_abono`, `abono`, `saldo_abono`, `id_users_abono`, `id_sucursal`, `concepto_abono`) VALUES
(1, '001-001-000000', '2022-07-09 08:40:47', 1, 800000, 100000, 700000, 1, 1, 'CREDITO INICAL'),
(2, '001-001-000000', '2022-07-09 08:49:19', 1, 800000, 300000, 400000, 1, 1, 'PAGO'),
(3, '001-001-000001', '2022-07-09 16:13:33', 3, 3650000, 3050000, 600000, 1, 1, 'CREDITO INICAL'),
(4, '001-001-000002', '2022-07-09 16:24:13', 3, 150000, 0, 150000, 1, 1, 'CREDITO INICAL'),
(5, '001-001-000003', '2022-07-09 16:35:41', 4, 1950000, 1500000, 450000, 1, 1, 'CREDITO INICAL'),
(6, '001-001-000004', '2022-07-09 16:44:56', 5, 1890000, 1260000, 630000, 1, 1, 'CREDITO INICAL'),
(7, '001-001-000005', '2022-07-09 16:50:31', 6, 6300000, 3400000, 2900000, 1, 1, 'CREDITO INICAL'),
(8, '001-001-000006', '2022-07-09 16:55:40', 7, 900000, 500000, 400000, 1, 1, 'CREDITO INICAL'),
(9, '001-001-000007', '2022-07-09 17:00:57', 8, 3600000, 2400000, 1200000, 1, 1, 'CREDITO INICAL'),
(10, '001-001-000008', '2022-07-09 17:07:30', 9, 8300000, 4900000, 3400000, 1, 1, 'CREDITO INICAL'),
(11, '001-001-000009', '2022-07-09 17:14:26', 10, 1100000, 800000, 300000, 1, 1, 'CREDITO INICAL'),
(12, '001-001-000010', '2022-07-09 17:24:54', 11, 5295000, 915000, 4380000, 1, 1, 'CREDITO INICAL'),
(13, '001-001-000009', '2022-07-09 19:22:27', 10, 1100000, 150, 299850, 1, 1, 'CUOTA 5'),
(14, '001-001-000009', '2022-07-09 19:23:40', 10, 1100000, 149850, 150000, 1, 1, 'CUOTA 5'),
(15, '001-001-000011', '2022-07-09 19:32:03', 12, 2000000, 1000000, 1000000, 1, 1, 'CREDITO INICAL'),
(16, '001-001-000012', '2022-07-09 19:37:21', 13, 2000000, 0, 2000000, 1, 1, 'CREDITO INICAL'),
(17, '001-001-000012', '2022-07-09 19:38:05', 13, 2000000, 1300000, 700000, 1, 1, 'ANTICIPO'),
(18, '001-001-000013', '2022-07-09 19:43:08', 14, 3450000, 3785000, -335000, 1, 1, 'CREDITO INICAL'),
(19, '001-001-000013', '2022-07-09 19:48:42', 14, 3450000, 3115000, 335000, 1, 1, 'CREDITO INICAL');

-- --------------------------------------------------------

--
-- Table structure for table `creditos_abonos_prov`
--

CREATE TABLE `creditos_abonos_prov` (
  `id_abono` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_abono` datetime NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `monto_abono` double NOT NULL,
  `abono` double NOT NULL,
  `saldo_abono` double NOT NULL,
  `id_users_abono` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `concepto_abono` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `credito_proveedor`
--

CREATE TABLE `credito_proveedor` (
  `id_credito` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_credito` datetime NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `monto_credito` double NOT NULL,
  `saldo_credito` double NOT NULL,
  `estado_credito` tinyint(1) NOT NULL,
  `id_users_credito` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `precision` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `thousand_separator` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `decimal_separator` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `precision`, `thousand_separator`, `decimal_separator`, `code`) VALUES
(1, 'US Dollar', '$', '2', ',', '.', 'USD'),
(2, 'Libra Esterlina', '&pound;', '2', ',', '.', 'GBP'),
(3, 'Euro', 'â‚¬', '2', '.', ',', 'EUR'),
(4, 'South African Rand', 'R', '2', '.', ',', 'ZAR'),
(5, 'Guarani Paraguayo', 'Gs', '0', '.', ',', 'PYG');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_fact_compra`
--

CREATE TABLE `detalle_fact_compra` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` double NOT NULL,
  `precio_costo` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detalle_fact_compra`
--

INSERT INTO `detalle_fact_compra` (`id_detalle`, `id_factura`, `numero_factura`, `id_producto`, `cantidad`, `precio_costo`) VALUES
(1, 1, 'FC-000001', 20, 1, 182600);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_fact_cot`
--

CREATE TABLE `detalle_fact_cot` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(25) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `desc_venta` int(11) NOT NULL,
  `precio_venta` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_fact_ventas`
--

CREATE TABLE `detalle_fact_ventas` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(25) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `desc_venta` int(11) NOT NULL,
  `precio_venta` double NOT NULL,
  `importe_venta` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detalle_fact_ventas`
--

INSERT INTO `detalle_fact_ventas` (`id_detalle`, `id_factura`, `numero_factura`, `id_producto`, `cantidad`, `desc_venta`, `precio_venta`, `importe_venta`) VALUES
(1, 1, '001-001-000000', 1, 1, 0, 800000, 800000),
(2, 2, '001-001-000001', 3, 1, 0, 3650000, 3650000),
(3, 3, '001-001-000002', 4, 1, 0, 71000, 71000),
(4, 3, '001-001-000002', 5, 1, 0, 75000, 75000),
(5, 3, '001-001-000002', 6, 1, 0, 4000, 4000),
(6, 4, '001-001-000003', 7, 1, 0, 1950000, 1950000),
(7, 5, '001-001-000004', 8, 1, 0, 1890000, 1890000),
(8, 6, '001-001-000005', 9, 1, 0, 6300000, 6300000),
(9, 7, '001-001-000006', 10, 1, 0, 900000, 900000),
(10, 8, '001-001-000007', 11, 1, 0, 3600000, 3600000),
(11, 9, '001-001-000008', 12, 1, 0, 8300000, 8300000),
(12, 10, '001-001-000009', 13, 1, 0, 1100000, 1100000),
(13, 11, '001-001-000010', 16, 1, 0, 295000, 295000),
(14, 11, '001-001-000010', 15, 1, 0, 4200000, 4200000),
(15, 11, '001-001-000010', 14, 1, 0, 800000, 800000),
(16, 12, '001-001-000011', 17, 1, 0, 2000000, 2000000),
(17, 13, '001-001-000012', 18, 1, 0, 2000000, 2000000),
(19, 14, '001-001-000013', 19, 1, 0, 3450000, 3450000),
(20, 16, '001-001-000014', 20, 1, 0, 350000, 350000);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_traslado`
--

CREATE TABLE `detalle_traslado` (
  `id_detalle_traslado` int(11) NOT NULL,
  `id_traslado` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` double NOT NULL,
  `num_transaccion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `egresos`
--

CREATE TABLE `egresos` (
  `id_egreso` int(11) NOT NULL,
  `referencia_egreso` varchar(100) CHARACTER SET latin1 NOT NULL,
  `monto` double NOT NULL,
  `descripcion_egreso` text CHARACTER SET latin1 NOT NULL,
  `fecha_added` datetime NOT NULL,
  `users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `facturas_compras`
--

CREATE TABLE `facturas_compras` (
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` int(11) NOT NULL,
  `monto_factura` double NOT NULL,
  `estado_factura` tinyint(4) NOT NULL,
  `id_users_factura` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `ref_factura` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `facturas_compras`
--

INSERT INTO `facturas_compras` (`id_factura`, `numero_factura`, `fecha_factura`, `id_proveedor`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `id_sucursal`, `ref_factura`) VALUES
(1, 'FC-000001', '2022-07-09 00:00:00', 8, 1, 1, 182600, 1, 1, 1, '0090010001067');

-- --------------------------------------------------------

--
-- Table structure for table `facturas_cot`
--

CREATE TABLE `facturas_cot` (
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` varchar(30) NOT NULL,
  `monto_factura` double NOT NULL,
  `estado_factura` tinyint(1) NOT NULL,
  `id_users_factura` int(11) NOT NULL,
  `validez` double NOT NULL,
  `id_sucursal` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `facturas_ventas`
--

CREATE TABLE `facturas_ventas` (
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(20) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` varchar(30) NOT NULL,
  `monto_factura` double NOT NULL,
  `estado_factura` tinyint(1) NOT NULL,
  `id_users_factura` int(11) NOT NULL,
  `dinero_resibido_fac` double NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_comp_factura` int(11) NOT NULL,
  `num_trans_factura` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `facturas_ventas`
--

INSERT INTO `facturas_ventas` (`id_factura`, `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `dinero_resibido_fac`, `id_sucursal`, `id_comp_factura`, `num_trans_factura`) VALUES
(1, '001-001-000000', '2022-07-09 08:40:47', 1, 1, '4', 800000, 2, 1, 100000, 1, 1, ''),
(2, '001-001-000001', '2022-07-09 16:13:33', 3, 1, '4', 3650000, 2, 1, 3050000, 1, 1, ''),
(3, '001-001-000002', '2022-07-09 16:24:13', 3, 1, '4', 150000, 2, 1, 0, 1, 1, ''),
(4, '001-001-000003', '2022-07-09 16:35:41', 4, 1, '4', 1950000, 2, 1, 1500000, 1, 1, ''),
(5, '001-001-000004', '2022-07-09 16:44:56', 5, 1, '4', 1890000, 2, 1, 1260000, 1, 1, ''),
(6, '001-001-000005', '2022-07-09 16:50:31', 6, 1, '4', 6300000, 2, 1, 3400000, 1, 1, ''),
(7, '001-001-000006', '2022-07-09 16:55:40', 7, 1, '4', 900000, 2, 1, 500000, 1, 1, ''),
(8, '001-001-000007', '2022-07-09 17:00:57', 8, 1, '4', 3600000, 2, 1, 2400000, 1, 1, ''),
(9, '001-001-000008', '2022-07-09 17:07:30', 9, 1, '4', 8300000, 2, 1, 4900000, 1, 1, ''),
(10, '001-001-000009', '2022-07-09 17:14:26', 10, 1, '4', 1100000, 2, 1, 800000, 1, 1, ''),
(11, '001-001-000010', '2022-07-09 17:24:54', 11, 1, '4', 5295000, 2, 1, 915000, 1, 1, ''),
(12, '001-001-000011', '2022-07-09 19:32:03', 12, 1, '4', 2000000, 2, 1, 1000000, 1, 1, ''),
(13, '001-001-000012', '2022-07-09 19:37:21', 13, 1, '4', 2000000, 2, 1, 0, 1, 1, ''),
(15, '001-001-000013', '2022-07-09 19:48:42', 14, 1, '4', 3450000, 2, 1, 3115000, 1, 1, ''),
(16, '001-001-000014', '2022-07-09 19:57:50', 15, 1, '1', 350000, 1, 1, 350000, 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `historial_productos`
--

CREATE TABLE `historial_productos` (
  `id_historial` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `fecha_historial` datetime NOT NULL,
  `nota_historial` varchar(255) NOT NULL,
  `referencia_historial` varchar(100) NOT NULL,
  `cantidad_historial` double NOT NULL,
  `tipo_historial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `impuestos`
--

CREATE TABLE `impuestos` (
  `id_imp` int(11) NOT NULL,
  `nombre_imp` varchar(100) NOT NULL,
  `valor_imp` double NOT NULL,
  `estado_imp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ingresos`
--

CREATE TABLE `ingresos` (
  `id_ingreso` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `monto` double NOT NULL,
  `fecha_added` datetime NOT NULL,
  `users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kardex`
--

CREATE TABLE `kardex` (
  `id_kardex` int(11) NOT NULL,
  `fecha_kardex` date NOT NULL,
  `cant_entrada` double NOT NULL,
  `producto_kardex` int(11) NOT NULL,
  `costo_entrada` double NOT NULL,
  `total_entrada` double NOT NULL,
  `cant_salida` double NOT NULL DEFAULT 0,
  `costo_salida` double NOT NULL DEFAULT 0,
  `total_salida` double NOT NULL DEFAULT 0,
  `cant_saldo` double NOT NULL,
  `costo_saldo` double NOT NULL,
  `total_saldo` double NOT NULL,
  `added_kardex` datetime NOT NULL,
  `users_kardex` int(11) NOT NULL,
  `tipo_movimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kardex`
--

INSERT INTO `kardex` (`id_kardex`, `fecha_kardex`, `cant_entrada`, `producto_kardex`, `costo_entrada`, `total_entrada`, `cant_salida`, `costo_salida`, `total_salida`, `cant_saldo`, `costo_saldo`, `total_saldo`, `added_kardex`, `users_kardex`, `tipo_movimiento`) VALUES
(1, '2022-07-09', 1, 1, 350000, 350000, 0, 0, 0, 1, 350000, 350000, '2022-07-09 08:38:40', 1, 5),
(2, '2022-07-09', 0, 1, 0, 0, 1, 350000, 350000, 0, 350000, 0, '2022-07-09 08:40:47', 1, 2),
(3, '2022-07-09', 0, 2, 1, 0, 0, 0, 0, 0, 0, 0, '2022-07-09 12:21:05', 1, 5),
(4, '2022-07-09', 1, 3, 1893000, 1893000, 0, 0, 0, 1, 1893000, 1893000, '2022-07-09 16:09:22', 1, 5),
(5, '2022-07-09', 0, 3, 0, 0, 1, 1893000, 1893000, 0, 1893000, 0, '2022-07-09 16:13:33', 1, 2),
(6, '2022-07-09', 1, 4, 46400, 46400, 0, 0, 0, 1, 46400, 46400, '2022-07-09 16:18:56', 1, 5),
(7, '2022-07-09', 1, 5, 50000, 50000, 0, 0, 0, 1, 50000, 50000, '2022-07-09 16:20:57', 1, 5),
(8, '2022-07-09', 1, 6, 40, 40, 0, 0, 0, 1, 40, 40, '2022-07-09 16:22:52', 1, 5),
(9, '2022-07-09', 0, 4, 0, 0, 1, 46400, 46400, 0, 46400, 0, '2022-07-09 16:24:13', 1, 2),
(10, '2022-07-09', 0, 5, 0, 0, 1, 50000, 50000, 0, 50000, 0, '2022-07-09 16:24:13', 1, 2),
(11, '2022-07-09', 0, 6, 0, 0, 1, 40, 40, 0, 40, 0, '2022-07-09 16:24:13', 1, 2),
(12, '2022-07-09', 1, 7, 1300000, 1300000, 0, 0, 0, 1, 1300000, 1300000, '2022-07-09 16:31:28', 1, 5),
(13, '2022-07-09', 0, 7, 0, 0, 1, 1300000, 1300000, 0, 1300000, 0, '2022-07-09 16:35:41', 1, 2),
(14, '2022-07-09', 1, 8, 1187000, 1187000, 0, 0, 0, 1, 1187000, 1187000, '2022-07-09 16:42:26', 1, 5),
(15, '2022-07-09', 0, 8, 0, 0, 1, 1187000, 1187000, 0, 1187000, 0, '2022-07-09 16:44:56', 1, 2),
(16, '2022-07-09', 1, 9, 4030000, 4030000, 0, 0, 0, 1, 4030000, 4030000, '2022-07-09 16:48:37', 1, 5),
(17, '2022-07-09', 0, 9, 0, 0, 1, 4030000, 4030000, 0, 4030000, 0, '2022-07-09 16:50:31', 1, 2),
(18, '2022-07-09', 1, 10, 210000, 210000, 0, 0, 0, 1, 210000, 210000, '2022-07-09 16:53:52', 1, 5),
(19, '2022-07-09', 0, 10, 0, 0, 1, 210000, 210000, 0, 210000, 0, '2022-07-09 16:55:40', 1, 2),
(20, '2022-07-09', 1, 11, 2300000, 2300000, 0, 0, 0, 1, 2300000, 2300000, '2022-07-09 16:58:30', 1, 5),
(21, '2022-07-09', 0, 11, 0, 0, 1, 2300000, 2300000, 0, 2300000, 0, '2022-07-09 17:00:57', 1, 2),
(22, '2022-07-09', 1, 12, 6361000, 6361000, 0, 0, 0, 1, 6361000, 6361000, '2022-07-09 17:06:15', 1, 5),
(23, '2022-07-09', 0, 12, 0, 0, 1, 6361000, 6361000, 0, 6361000, 0, '2022-07-09 17:07:30', 1, 2),
(24, '2022-07-09', 1, 13, 550000, 550000, 0, 0, 0, 1, 550000, 550000, '2022-07-09 17:12:28', 1, 5),
(25, '2022-07-09', 0, 13, 0, 0, 1, 550000, 550000, 0, 550000, 0, '2022-07-09 17:14:26', 1, 2),
(26, '2022-07-09', 1, 14, 100000, 100000, 0, 0, 0, 1, 100000, 100000, '2022-07-09 17:16:13', 1, 5),
(27, '2022-07-09', 1, 15, 2990000, 2990000, 0, 0, 0, 1, 2990000, 2990000, '2022-07-09 17:18:12', 1, 5),
(28, '2022-07-09', 1, 16, 260000, 260000, 0, 0, 0, 1, 260000, 260000, '2022-07-09 17:23:00', 1, 5),
(29, '2022-07-09', 0, 16, 0, 0, 1, 260000, 260000, 0, 260000, 0, '2022-07-09 17:24:54', 1, 2),
(30, '2022-07-09', 0, 15, 0, 0, 1, 2990000, 2990000, 0, 2990000, 0, '2022-07-09 17:24:54', 1, 2),
(31, '2022-07-09', 0, 14, 0, 0, 1, 100000, 100000, 0, 100000, 0, '2022-07-09 17:24:54', 1, 2),
(32, '2022-07-09', 1, 17, 1023000, 1023000, 0, 0, 0, 1, 1023000, 1023000, '2022-07-09 19:30:52', 1, 5),
(33, '2022-07-09', 0, 17, 0, 0, 1, 1023000, 1023000, 0, 1023000, 0, '2022-07-09 19:32:03', 1, 2),
(34, '2022-07-09', 1, 18, 1025000, 1025000, 0, 0, 0, 1, 1025000, 1025000, '2022-07-09 19:35:14', 1, 5),
(35, '2022-07-09', 0, 18, 0, 0, 1, 1025000, 1025000, 0, 1025000, 0, '2022-07-09 19:37:21', 1, 2),
(36, '2022-07-09', 1, 19, 1915000, 1915000, 0, 0, 0, 1, 1915000, 1915000, '2022-07-09 19:42:04', 1, 5),
(37, '2022-07-09', 0, 19, 0, 0, 1, 1915000, 1915000, 0, 1915000, 0, '2022-07-09 19:43:08', 1, 2),
(38, '2022-07-09', 0, 19, 0, 0, 1, 1915000, 1915000, -1, 1915000, -1915000, '2022-07-09 19:48:42', 1, 2),
(39, '2022-07-09', 0, 20, 1, 0, 0, 0, 0, 0, 0, 0, '2022-07-09 19:54:29', 1, 5),
(40, '2022-07-09', 1, 20, 182600, 182600, 0, 0, 0, 1, 182600, 182600, '2022-07-09 00:00:00', 1, 1),
(41, '2022-07-09', 0, 20, 0, 0, 1, 182600, 182600, 0, 182600, 0, '2022-07-09 19:57:50', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `lineas`
--

CREATE TABLE `lineas` (
  `id_linea` int(11) NOT NULL,
  `nombre_linea` varchar(255) NOT NULL,
  `descripcion_linea` text NOT NULL,
  `estado_linea` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lineas`
--

INSERT INTO `lineas` (`id_linea`, `nombre_linea`, `descripcion_linea`, `estado_linea`, `date_added`) VALUES
(1, 'LLAVES', '', 1, '2022-07-09 08:26:58'),
(2, 'VARIOS', '', 1, '2022-07-09 12:17:40'),
(3, 'COMPRESORES', 'COMPRESORES', 1, '2022-07-09 16:05:25'),
(4, 'VENTAS ESPECIALES', 'VENTAS ESPECIALES', 1, '2022-07-09 16:29:51'),
(5, 'PRECISION', '', 1, '2022-07-09 16:37:41'),
(6, 'LIMPIEZA VEHICULAR', '', 1, '2022-07-09 16:57:11'),
(7, 'SOLDADORES', '', 1, '2022-07-09 17:01:38'),
(8, 'HERRAMIENTAS ELECTRICAS', '', 1, '2022-07-09 17:09:19'),
(9, 'HERRAMIENTAS INALAMBRICAS', '', 1, '2022-07-09 19:33:24');

-- --------------------------------------------------------

--
-- Table structure for table `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `nombre_modulo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modulos`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `nombre_empresa` varchar(150) CHARACTER SET latin1 NOT NULL,
  `giro_empresa` text NOT NULL,
  `fiscal_empresa` varchar(25) NOT NULL,
  `direccion` varchar(255) CHARACTER SET latin1 NOT NULL,
  `ciudad` varchar(100) CHARACTER SET latin1 NOT NULL,
  `codigo_postal` varchar(100) CHARACTER SET latin1 NOT NULL,
  `estado` varchar(100) CHARACTER SET latin1 NOT NULL,
  `telefono` varchar(20) CHARACTER SET latin1 NOT NULL,
  `email` varchar(64) CHARACTER SET latin1 NOT NULL,
  `impuesto` int(11) NOT NULL,
  `nom_impuesto` varchar(50) NOT NULL,
  `moneda` varchar(6) CHARACTER SET latin1 NOT NULL,
  `logo_url` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombre_empresa`, `giro_empresa`, `fiscal_empresa`, `direccion`, `ciudad`, `codigo_postal`, `estado`, `telefono`, `email`, `impuesto`, `nom_impuesto`, `moneda`, `logo_url`) VALUES
(1, 'AJAKA SYSTEM', 'SISTEMA DE VENTAS', '5971557-0', 'AV. BLAS GARAY', 'CIUDAD DEL ESTE', '7000', 'ALTO PARANA', '0973 118 404', 'joseaguilera1709@gmail.com', 10, 'IVA', 'Gs', '../../img/1657371270_ajaka.png');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` varchar(255) CHARACTER SET latin1 NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `descripcion_producto` text NOT NULL,
  `id_linea_producto` int(11) NOT NULL,
  `id_med_producto` int(11) DEFAULT NULL,
  `id_proveedor` int(11) NOT NULL,
  `inv_producto` tinyint(4) DEFAULT NULL,
  `iva_producto` tinyint(4) DEFAULT NULL,
  `estado_producto` tinyint(4) DEFAULT NULL,
  `costo_producto` double DEFAULT NULL,
  `utilidad_producto` double DEFAULT NULL,
  `moneda_producto` int(11) DEFAULT NULL,
  `valor1_producto` double DEFAULT NULL,
  `valor2_producto` double DEFAULT NULL,
  `valor3_producto` double DEFAULT NULL,
  `stock_producto` double DEFAULT NULL,
  `stock_min_producto` double DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `image_path` varchar(300) DEFAULT NULL,
  `id_imp_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo_producto`, `nombre_producto`, `descripcion_producto`, `id_linea_producto`, `id_med_producto`, `id_proveedor`, `inv_producto`, `iva_producto`, `estado_producto`, `costo_producto`, `utilidad_producto`, `moneda_producto`, `valor1_producto`, `valor2_producto`, `valor3_producto`, `stock_producto`, `stock_min_producto`, `date_added`, `image_path`, `id_imp_producto`) VALUES
(1, '10001', 'JUEGO DE LLAVES COMBINADAS 25 PIEZAS MAKAGUA', 'JUEGO DE LLAVES COMBINADAS 25 PIEZAS MAKAGUA', 1, NULL, 1, 1, 10, 1, 350000, 129, NULL, 800000, 0, 0, 1, 1, '2022-07-09 08:38:40', NULL, 0),
(2, '00000', 'DEUDAS VARIAS', 'DEUDAS VARIAS', 2, NULL, 2, 1, 10, 1, 1, 1, NULL, 1, 0, 0, 0, 1, '2022-07-09 12:21:05', NULL, 0),
(3, '20001', 'COMPRESOR GAMMA 100 LTS MOTOR 3HP ', 'COMPRESOR GAMMA 100 LTS MOTOR 3HP ', 3, NULL, 3, 1, 10, 1, 1893000, 93, NULL, 3650000, 0, 0, 1, 1, '2022-07-09 16:09:22', NULL, 0),
(4, '11001', 'LLAVE GEDORE MULTIDENTADA NRO 12', 'UTILIZADA PARA VOLANTE MERCDES BENZ', 1, NULL, 4, 1, 10, 1, 46400, 50, NULL, 71000, 0, 0, 1, 1, '2022-07-09 16:18:56', NULL, 0),
(5, '11002', 'LLAVE TUBO GEDORE TORX T55', 'LLAVE TUBO GEDORE TORX T55', 1, NULL, 4, 1, 10, 1, 50000, 50, NULL, 75000, 0, 0, 1, 1, '2022-07-09 16:20:57', NULL, 0),
(6, '00001', 'RECARGOS VARIOS', 'RECARGOS VARIOS', 2, NULL, 2, 1, 10, 1, 40, 100, NULL, 4000, 0, 0, 1, 1, '2022-07-09 16:22:52', NULL, 0),
(7, '20001', 'PARRILLA MR SOLUCIONES 7 ESPETOS ', 'PARRILLA MR SOLUCIONES 7 ESPETOS ', 4, NULL, 5, 1, 10, 1, 1300000, 100, NULL, 1950000, 0, 0, 1, 1, '2022-07-09 16:31:28', NULL, 0),
(8, '30001', 'NIVEL LASER DEWALT DW088K-AR', 'NIVEL LASER DEWALT DW088K-AR', 5, NULL, 4, 1, 10, 1, 1187000, 50, NULL, 1890000, 0, 0, 1, 1, '2022-07-09 16:42:26', NULL, 0),
(9, '30002', 'MAQ. PRUEBA LIMP DE INYECT KITEST KA-201', '', 5, NULL, 4, 1, 10, 1, 4030000, 50, NULL, 6300000, 0, 0, 1, 1, '2022-07-09 16:48:37', NULL, 0),
(10, '30003', 'CALIBRE MAKAWA DIGITAL 15 CMTS', 'CALIBRE MAKAWA DIGITAL 15 CMTS', 5, NULL, 6, 1, 10, 1, 210000, 100, NULL, 900000, 0, 0, 1, 1, '2022-07-09 16:53:52', NULL, 0),
(11, '40001', 'LAVAASPIRADORA KARCHER 4001', 'LAVAASPIRADORA KARCHER 4001', 6, NULL, 7, 1, 10, 1, 2300000, 50, NULL, 3600000, 0, 0, 1, 1, '2022-07-09 16:58:30', NULL, 0),
(12, '50001', 'SOLDADOR TELWIN MIG/TIG/MMA', '', 7, NULL, 4, 1, 10, 1, 6361000, 50, NULL, 8300000, 0, 0, 1, 1, '2022-07-09 17:06:15', NULL, 0),
(13, '60001', 'ROTOMARTILLO DAEWOO 1500 W', '', 8, NULL, 3, 1, 10, 1, 550000, 100, NULL, 1100000, 0, 0, 1, 1, '2022-07-09 17:12:28', NULL, 0),
(14, '20002', 'ESTANTE MADERA USADO', '', 4, NULL, 2, 0, 10, 1, 100000, 100, NULL, 800000, 0, 0, 0, 1, '2022-07-09 17:16:13', NULL, 0),
(15, '40002', 'HIDROLAVADORA PRESSURE 28 LTS/M MOTOR 2HP', '', 6, NULL, 9, 1, 10, 1, 2990000, 50, NULL, 4200000, 0, 0, 1, 1, '2022-07-09 17:18:12', NULL, 0),
(16, '10002', 'JG LLAVE TORX HEMBRA', '', 1, NULL, 6, 1, 10, 1, 260000, 50, NULL, 295000, 0, 0, 1, 1, '2022-07-09 17:23:00', NULL, 0),
(17, '20003', 'IMPRESORA BROTHER LASER 1212W', '', 4, NULL, 2, 1, 10, 1, 1023000, 100, NULL, 2000000, 0, 0, 1, 1, '2022-07-09 19:30:52', NULL, 0),
(18, '70001', 'TALADRO INAL. STANLEY 2 BATERIAS', '', 9, NULL, 10, 1, 10, 1, 1025000, 100, NULL, 2000000, 0, 0, 1, 1, '2022-07-09 19:35:14', NULL, 0),
(19, '300004', 'BOMBA DE TRANF DE COMBS CON MEDIDOR 220V', '', 5, NULL, 4, 1, 10, 1, 1915000, 100, NULL, 3450000, 0, 0, 1, 1, '2022-07-09 19:42:04', NULL, 0),
(20, '60002', 'AMOLADORA DAEWOO 4.5', '', 8, NULL, 8, 1, 10, 1, 182600, 100, NULL, 350000, 300000, 280000, 1, 1, '2022-07-09 19:54:29', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(255) NOT NULL,
  `fiscal_proveedor` varchar(100) NOT NULL,
  `web_proveedor` varchar(255) NOT NULL,
  `direccion_proveedor` text NOT NULL,
  `contacto_proveedor` varchar(255) NOT NULL,
  `email_proveedor` varchar(255) NOT NULL,
  `telefono_proveedor` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `estado_proveedor` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`, `fiscal_proveedor`, `web_proveedor`, `direccion_proveedor`, `contacto_proveedor`, `email_proveedor`, `telefono_proveedor`, `date_added`, `estado_proveedor`) VALUES
(1, 'OSCAR HERRAMINETAS CHINAS', '852369741', '', 'BO BOQUERON', 'OSCAR JIMENEZ', '', '0973507877', '2022-07-09 08:31:16', 1),
(2, 'FERNANDO BRITOS', '3431302-5', '', 'BO SAN ISIDRO', 'FERNANDO BRITOS', '', '0981355533', '2022-07-09 12:19:17', 1),
(3, 'LINCOLN S.A.', '800545652', '', 'ASUNCION', 'LUIS', '', '', '2022-07-09 16:06:16', 1),
(4, 'MELLA S.A.', '52634184', '', '', 'ALBERTO', '', '', '2022-07-09 16:14:25', 1),
(5, 'MR SOLUCIONES', '8574963210', '', '', 'MIGUEL RIVAROLA', '', '123456', '2022-07-09 16:27:21', 1),
(6, 'LA CASA DEL TORNERO', '123456', '', '', 'ANTONIO', '', '528963', '2022-07-09 16:52:04', 1),
(7, 'CENTRAL MOTOS', '52634152', '', '', 'CENTRAL MOTOS', '', '963147', '2022-07-09 16:59:05', 1),
(8, 'COMAGRO S.A.', '524152', '', '', 'GUSTAVO', '', '54659878', '2022-07-09 17:10:40', 1),
(9, 'CENTRO DE LOS COMPRESORES', '123654', '', '', 'PEDRO', '', '321546', '2022-07-09 17:16:42', 1),
(10, 'THE TOOLS DEPOT', '30000', '', '', 'PEDRO', '', '564128', '2022-07-09 19:32:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id_stock` int(11) NOT NULL,
  `id_producto_stock` int(11) NOT NULL,
  `id_sucursal_stock` int(11) NOT NULL,
  `cantidad_stock` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sucursales`
--

CREATE TABLE `sucursales` (
  `id_sucursal` int(11) NOT NULL,
  `codigo_sucursal` varchar(50) NOT NULL,
  `nombre_sucursal` varchar(255) NOT NULL,
  `direccion_sucursal` text NOT NULL,
  `limite_sucursal` double NOT NULL,
  `estado_sucursal` tinyint(4) NOT NULL,
  `fecha_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sucursales`
--

INSERT INTO `sucursales` (`id_sucursal`, `codigo_sucursal`, `nombre_sucursal`, `direccion_sucursal`, `limite_sucursal`, `estado_sucursal`, `fecha_added`) VALUES
(1, 'SC001', 'CASA MATRIZ', 'AV. SAN BLAS', 40, 1, '2018-01-05 11:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_compra`
--

CREATE TABLE `tmp_compra` (
  `id_tmp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_tmp` double NOT NULL,
  `costo_tmp` double(8,2) DEFAULT NULL,
  `session_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_cotizacion`
--

CREATE TABLE `tmp_cotizacion` (
  `id_tmp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_tmp` double NOT NULL,
  `precio_tmp` double DEFAULT NULL,
  `desc_tmp` int(11) NOT NULL,
  `session_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_ventas`
--

CREATE TABLE `tmp_ventas` (
  `id_tmp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_tmp` double NOT NULL,
  `precio_tmp` double DEFAULT NULL,
  `desc_tmp` int(11) NOT NULL,
  `session_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `traslados`
--

CREATE TABLE `traslados` (
  `id_traslado` int(11) NOT NULL,
  `referencia_traslado` varchar(50) NOT NULL,
  `origen_traslado` int(11) NOT NULL,
  `destino_traslado` int(11) NOT NULL,
  `monto_traslado` int(11) NOT NULL,
  `fecha_added` datetime NOT NULL,
  `id_users` int(11) NOT NULL,
  `num_transaccion` varchar(50) NOT NULL,
  `estado_traslado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `nombre_users` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `apellido_users` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_users` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `con_users` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `email_users` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `tipo_users` tinyint(4) NOT NULL,
  `cargo_users` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sucursal_users` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `comision_users` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `nombre_users`, `apellido_users`, `usuario_users`, `con_users`, `email_users`, `tipo_users`, `cargo_users`, `sucursal_users`, `date_added`, `comision_users`) VALUES
(1, 'SUPER', 'ADMINISTRADOR', 'admin', '$2y$10$MPVHzZ2ZPOWmtUUGCq3RXu31OTB.jo7M9LZ7PmPQYmgETSNn19ejO', 'root@admin.com', 0, '1', 1, '2016-05-21 15:06:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `user_group_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `permission` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`user_group_id`, `name`, `permission`, `date_added`) VALUES
(1, 'Super Administrador', 'Inicio,1,1,1;Productos,1,1,1;Proveedores,1,1,1;Clientes,1,1,1;Reportes,1,1,1;Configuracion,1,1,1;Usuarios,1,1,1;Permisos,1,1,1;Categorias,1,1,1;Ventas,1,1,1;Compras,1,1,1;', '2017-08-09 10:22:15'),
(2, 'GERENTE', 'Inicio,1,0,0;Productos,1,0,0;Proveedores,1,0,0;Clientes,1,0,0;Reportes,1,0,0;Configuracion,1,0,0;Usuarios,1,0,0;Permisos,1,0,0;Categorias,1,0,0;Ventas,1,1,0;Compras,1,0,0;', '2017-08-09 11:31:34'),
(3, 'FACTURADOR', 'Inicio,0,0,0;Productos,1,0,0;Proveedores,1,0,0;Clientes,1,0,0;Reportes,0,0,0;Configuracion,0,0,0;Usuarios,0,0,0;Permisos,0,0,0;Categorias,0,0,0;Ventas,1,0,0;Compras,0,0,0;', '2017-09-15 22:44:50'),
(4, 'ADMINISTRADOR', 'Inicio,1,1,1;Productos,1,1,1;Proveedores,1,1,1;Clientes,1,1,1;Reportes,1,1,1;Configuracion,1,1,1;Usuarios,1,1,1;Permisos,1,1,1;Categorias,1,1,1;Ventas,1,1,1;Compras,1,1,1;', '2017-11-21 11:33:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `caja_chica`
--
ALTER TABLE `caja_chica`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `codigo_producto` (`nombre_cliente`);

--
-- Indexes for table `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD PRIMARY KEY (`id_comp`);

--
-- Indexes for table `creditos`
--
ALTER TABLE `creditos`
  ADD PRIMARY KEY (`id_credito`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`);

--
-- Indexes for table `creditos_abonos`
--
ALTER TABLE `creditos_abonos`
  ADD PRIMARY KEY (`id_abono`);

--
-- Indexes for table `creditos_abonos_prov`
--
ALTER TABLE `creditos_abonos_prov`
  ADD PRIMARY KEY (`id_abono`);

--
-- Indexes for table `credito_proveedor`
--
ALTER TABLE `credito_proveedor`
  ADD PRIMARY KEY (`id_credito`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detalle_fact_compra`
--
ALTER TABLE `detalle_fact_compra`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`numero_factura`,`id_producto`),
  ADD KEY `id_factura` (`id_factura`);

--
-- Indexes for table `detalle_fact_cot`
--
ALTER TABLE `detalle_fact_cot`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`numero_factura`,`id_producto`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `numero_factura` (`numero_factura`);

--
-- Indexes for table `detalle_fact_ventas`
--
ALTER TABLE `detalle_fact_ventas`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`numero_factura`,`id_producto`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `numero_factura` (`numero_factura`);

--
-- Indexes for table `detalle_traslado`
--
ALTER TABLE `detalle_traslado`
  ADD PRIMARY KEY (`id_detalle_traslado`),
  ADD KEY `id_traslado` (`id_traslado`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `egresos`
--
ALTER TABLE `egresos`
  ADD PRIMARY KEY (`id_egreso`),
  ADD KEY `users` (`users`);

--
-- Indexes for table `facturas_compras`
--
ALTER TABLE `facturas_compras`
  ADD PRIMARY KEY (`id_factura`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_vendedor` (`id_vendedor`),
  ADD KEY `id_users_factura` (`id_users_factura`);

--
-- Indexes for table `facturas_cot`
--
ALTER TABLE `facturas_cot`
  ADD PRIMARY KEY (`id_factura`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`);

--
-- Indexes for table `facturas_ventas`
--
ALTER TABLE `facturas_ventas`
  ADD PRIMARY KEY (`id_factura`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`);

--
-- Indexes for table `historial_productos`
--
ALTER TABLE `historial_productos`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `impuestos`
--
ALTER TABLE `impuestos`
  ADD PRIMARY KEY (`id_imp`);

--
-- Indexes for table `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD KEY `id_consulta` (`id_consulta`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `users` (`users`);

--
-- Indexes for table `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`id_kardex`);

--
-- Indexes for table `lineas`
--
ALTER TABLE `lineas`
  ADD PRIMARY KEY (`id_linea`);

--
-- Indexes for table `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indexes for table `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_cat_producto` (`id_linea_producto`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`),
  ADD KEY `id_producto_stock` (`id_producto_stock`),
  ADD KEY `id_sucursal_stock` (`id_sucursal_stock`);

--
-- Indexes for table `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id_sucursal`);

--
-- Indexes for table `tmp_compra`
--
ALTER TABLE `tmp_compra`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indexes for table `tmp_cotizacion`
--
ALTER TABLE `tmp_cotizacion`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indexes for table `tmp_ventas`
--
ALTER TABLE `tmp_ventas`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indexes for table `traslados`
--
ALTER TABLE `traslados`
  ADD PRIMARY KEY (`id_traslado`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `user_name` (`usuario_users`),
  ADD UNIQUE KEY `user_email` (`email_users`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`user_group_id`),
  ADD KEY `user_group_id` (`user_group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `caja_chica`
--
ALTER TABLE `caja_chica`
  MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `comprobantes`
--
ALTER TABLE `comprobantes`
  MODIFY `id_comp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `creditos`
--
ALTER TABLE `creditos`
  MODIFY `id_credito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `creditos_abonos`
--
ALTER TABLE `creditos_abonos`
  MODIFY `id_abono` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `creditos_abonos_prov`
--
ALTER TABLE `creditos_abonos_prov`
  MODIFY `id_abono` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credito_proveedor`
--
ALTER TABLE `credito_proveedor`
  MODIFY `id_credito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `detalle_fact_compra`
--
ALTER TABLE `detalle_fact_compra`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detalle_fact_cot`
--
ALTER TABLE `detalle_fact_cot`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_fact_ventas`
--
ALTER TABLE `detalle_fact_ventas`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `detalle_traslado`
--
ALTER TABLE `detalle_traslado`
  MODIFY `id_detalle_traslado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `egresos`
--
ALTER TABLE `egresos`
  MODIFY `id_egreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facturas_compras`
--
ALTER TABLE `facturas_compras`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facturas_cot`
--
ALTER TABLE `facturas_cot`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facturas_ventas`
--
ALTER TABLE `facturas_ventas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `historial_productos`
--
ALTER TABLE `historial_productos`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `impuestos`
--
ALTER TABLE `impuestos`
  MODIFY `id_imp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kardex`
--
ALTER TABLE `kardex`
  MODIFY `id_kardex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `lineas`
--
ALTER TABLE `lineas`
  MODIFY `id_linea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tmp_compra`
--
ALTER TABLE `tmp_compra`
  MODIFY `id_tmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tmp_cotizacion`
--
ALTER TABLE `tmp_cotizacion`
  MODIFY `id_tmp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_ventas`
--
ALTER TABLE `tmp_ventas`
  MODIFY `id_tmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `traslados`
--
ALTER TABLE `traslados`
  MODIFY `id_traslado` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
