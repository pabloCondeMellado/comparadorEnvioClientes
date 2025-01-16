-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-01-2025 a las 08:16:33
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30
CREATE DATABASE IF NOT EXISTS tarifas_envio_cliente;
USE tarifas_envio_cliente;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tarifas_envio`
--

--
-- Estructura de tabla para la tabla `paqestandar`
--

CREATE TABLE `paqestandar` (
  `id` int(11) NOT NULL,
  `peso` varchar(50) DEFAULT NULL,
  `zona1` decimal(5,2) DEFAULT NULL,
  `zona2` decimal(5,2) DEFAULT NULL,
  `zona3` decimal(5,2) DEFAULT NULL,
  `zona3_plus` decimal(5,2) DEFAULT NULL,
  `zona4` decimal(5,2) DEFAULT NULL,
  `zona5` decimal(5,2) DEFAULT NULL,
  `zona6` decimal(5,2) DEFAULT NULL,
  `zona7` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `paqestandar`
--

INSERT INTO `paqestandar` (`id`, `peso`, `zona1`, `zona2`, `zona3`, `zona3_plus`, `zona4`, `zona5`, `zona6`, `zona7`) VALUES
(1,'1',5.26,6.02,6.18,6.18,7.88,14.06,6.18,8.05),
(2,'2',5.55,6.33,6.50,6.50,9.04,15.44,6.50,8.44),
(3,'3',5.92,6.73,6.94,6.94,10.85,17.85,6.94,9.01),
(4,'4',6.24,7.03,7.24,7.24,11.75,19.43,7.24,9.41),
(5,'5',6.44,7.24,7.45,7.45,12.67,20.95,7.45,9.68),
(6,'10',8.45,9.26,9.57,9.57,17.21,29.38,9.57,12.42),
(7,'15',10.83,11.94,12.24,12.24,22.46,44.63,12.24,15.94),
(8,'Kg adicional', 0.42,0.45,0.55,0.55,1.64,3.87,0.55,0.70);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paqligero`
--

CREATE TABLE `paqligero` (
  `id` int(11) NOT NULL,
  `peso` varchar(50) DEFAULT NULL,
  `zona1` decimal(5,2) DEFAULT NULL,
  `zona2` decimal(5,2) DEFAULT NULL,
  `zona3` decimal(5,2) DEFAULT NULL,
  `zona3_plus` decimal(5,2) DEFAULT NULL,
  `zona4` decimal(5,2) DEFAULT NULL,
  `zona5` decimal(5,2) DEFAULT NULL,
  `zona6` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `paqligero`
--

INSERT INTO `paqligero` (`id`, `peso`, `zona1`, `zona2`, `zona3`, `zona3_plus`, `zona4`, `zona5`, `zona6`) VALUES
(1,'250',4.04,4.61,4.73,4.73,6.03,10.75,4.73),
(2,'500',4.44,5.09,5.23,5.23,6.67,11.88,5.23),
(3,'1000',5.03,5.76,5.91,5.91,7.54,13.43,5.91),
(4,'2000',5.30,6.05,6.23,6.23,8.64,13.86,6.23);

--
-- Estructura de tabla para la tabla `paqpremium`
--

CREATE TABLE `paqpremium` (
  `id` int(11) NOT NULL,
  `peso` varchar(50) DEFAULT NULL,
  `zona1` decimal(5,2) DEFAULT NULL,
  `zona2` decimal(5,2) DEFAULT NULL,
  `zona3` decimal(5,2) DEFAULT NULL,
  `zona3_plus` decimal(5,2) DEFAULT NULL,
  `zona4` decimal(5,2) DEFAULT NULL,
  `zona5` decimal(5,2) DEFAULT NULL,
  `zona6` decimal(5,2) DEFAULT NULL,
  `zona7` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `paqpremium`
--

INSERT INTO `paqpremium` (`id`, `peso`, `zona1`, `zona2`, `zona3`, `zona3_plus`, `zona4`, `zona5`, `zona6`, `zona7`) VALUES
(1,'1',6.18,7.09,7.26,7.26,10.25,16.52,7.26,9.46),
(2,'2',6.52,7.45,7.65,7.65,12.66,18.17,7.65,9.93),
(3,'3',6.97,7.93,8.15,8.15,15.18,20.98,8.15,10.6),
(4,'4',7.34,8.28,8.52,8.52,17.65,22.87,8.52,11.08),
(5,'5',7.57,8.52,8.76,8.76,19.01,24.66,8.76,11.39),
(6,'10',9.94,10.90,11.25,11.25,25.92,34.56,11.25,14.62),
(7,'15',12.72,14.06,14.40,14.40,35.92,52.50,14.40,18.74),
(8,'Kg adicional',0.48,0.52,0.64,0.64,2.40,4.55,0.64,0.82);


--
-- Indices de la tabla `paqestandar`
--
ALTER TABLE `paqestandar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paqligero`
--
ALTER TABLE `paqligero`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paqpremium`
--
ALTER TABLE `paqpremium`
  ADD PRIMARY KEY (`id`);
