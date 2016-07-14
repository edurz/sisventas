-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 17-05-2015 a las 00:16:52
-- Versión del servidor: 5.6.12-log
-- Versión de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sisventa`
--
CREATE DATABASE IF NOT EXISTS `sisventa` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sisventa`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnotad`
--

CREATE TABLE IF NOT EXISTS `mnotad` (
  `Id_Nota_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Nota_Venta` int(11) NOT NULL,
  `Codigo_Producto` int(11) NOT NULL,
  `Cantidad_Producto` int(11) NOT NULL,
  `Precio_Unitario_Venta` int(11) NOT NULL,
  `Porcentaje_Descuento` int(11) NOT NULL,
  `Monto_Descuento` int(11) NOT NULL,
  PRIMARY KEY (`Id_Nota_detalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Volcado de datos para la tabla `mnotad`
--

INSERT INTO `mnotad` (`Id_Nota_detalle`, `Id_Nota_Venta`, `Codigo_Producto`, `Cantidad_Producto`, `Precio_Unitario_Venta`, `Porcentaje_Descuento`, `Monto_Descuento`) VALUES
(1, 1, 23, 2, 34, 0, 0),
(24, 15, 23, 1, 3, 3, 0),
(25, 16, 23, 7, 3, 3, 0),
(26, 17, 23, 14, 3, 3, 0),
(27, 18, 23, 4, 3, 3, 0),
(28, 18, 23, 4, 3, 3, 0),
(29, 19, 23, 3, 3, 3, 0),
(30, 20, 23, 3, 3, 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnotae`
--

CREATE TABLE IF NOT EXISTS `mnotae` (
  `Id_Nota_Venta` int(11) NOT NULL,
  `Fecha_Nota_Venta` date NOT NULL,
  `Tipo_Venta` varchar(10) NOT NULL,
  `Codigo_Vendedor` int(11) NOT NULL,
  `Codigo_Despacho` int(11) NOT NULL,
  `Total_Venta` int(11) NOT NULL,
  `Efectivo` int(11) NOT NULL,
  `Vuelto` int(11) NOT NULL,
  PRIMARY KEY (`Id_Nota_Venta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mnotae`
--

INSERT INTO `mnotae` (`Id_Nota_Venta`, `Fecha_Nota_Venta`, `Tipo_Venta`, `Codigo_Vendedor`, `Codigo_Despacho`, `Total_Venta`, `Efectivo`, `Vuelto`) VALUES
(15, '2015-05-13', 'Debito', 321, 111, 3, 0, 0),
(16, '2015-05-14', 'Efectivo', 321, 111, 21, 0, 0),
(17, '2015-05-14', 'Efectivo', 321, 111, 42, 50, 8),
(18, '2015-05-16', 'Efectivo', 321, 111, 0, 30, 0),
(19, '2015-05-16', 'Efectivo', 321, 111, 9, 10, 1),
(20, '2015-05-16', 'Efectivo', 321, 111, 9, 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `Codigo_Producto` int(11) NOT NULL,
  `Descripcion` varchar(1000) NOT NULL,
  `Tipo_Producto` varchar(100) NOT NULL,
  `Stock_Producto` int(11) NOT NULL,
  `Porcentaje_Descuento` int(11) NOT NULL,
  `Descuento` int(11) NOT NULL,
  `Precio_S_IVA` int(11) NOT NULL,
  `Precio_C_IVA` int(11) NOT NULL,
  `Valor_IVA` int(11) NOT NULL,
  PRIMARY KEY (`Codigo_Producto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Codigo_Producto`, `Descripcion`, `Tipo_Producto`, `Stock_Producto`, `Porcentaje_Descuento`, `Descuento`, `Precio_S_IVA`, `Precio_C_IVA`, `Valor_IVA`) VALUES
(23, 'SDF', 'SDF', 2, 3, 0, 3, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `Codigo_Usuario` int(11) NOT NULL AUTO_INCREMENT,
  `Rut_Usuario` int(11) NOT NULL,
  `Nombre_Usuario` varchar(50) NOT NULL,
  `Apellido_Usuario` varchar(50) NOT NULL,
  `Clave_Acceso` varchar(50) NOT NULL,
  `Tipo_Usuario` varchar(20) NOT NULL,
  PRIMARY KEY (`Codigo_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
