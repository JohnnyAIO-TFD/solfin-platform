-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2019 a las 14:23:42
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crud`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `ID` int(11) NOT NULL,
  `user` varchar(20) CHARACTER SET latin1 NOT NULL,
  `password` varchar(20) CHARACTER SET latin1 NOT NULL,
  `departamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`ID`, `user`, `password`, `departamento`) VALUES
(1, 'admin', 'abc123', 'Planificación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_docs`
--

CREATE TABLE `tbl_docs` (
  `docID` int(11) NOT NULL,
  `docType` varchar(20) NOT NULL,
  `docFile` varchar(200) NOT NULL,
  `docDate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_docs`
--

INSERT INTO `tbl_docs` (`docID`, `docType`, `docFile`, `docDate`) VALUES
(18, 'Planificadores', 'BD-III.xls', '2019-10-23 05:38:47'),
(17, 'Contadurias', 'ProcessExplorer.zip', '2019-10-20 20:35:04'),
(19, 'Requerimientos', 'DM-III.xls', '2019-10-23 05:39:02'),
(20, 'Contadurias', 'AA-III.xls', '2019-10-23 05:39:19'),
(21, 'Contadurias', 'BI_KP16_S7.pdf', '2019-10-23 05:39:41'),
(23, 'Contadurias', 'Print tab.pdf', '2019-10-23 08:08:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_docs`
--
ALTER TABLE `tbl_docs`
  ADD PRIMARY KEY (`docID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_docs`
--
ALTER TABLE `tbl_docs`
  MODIFY `docID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
