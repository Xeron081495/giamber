-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-11-2017 a las 09:16:57
-- Versión del servidor: 5.6.36-cll-lve
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `giamber_bd`
--
CREATE DATABASE IF NOT EXISTS `giamber_bd` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `giamber_bd`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `nombre` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`nombre`, `imagen`, `descripcion`) VALUES
('Meguiars', 'img/meguiars.png', 'No hay descripción'),
('Motul', 'img/motul.png', 'No hay descripción'),
('Sonax', 'img/sonax.png', 'No hay descripción');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contiene`
--

CREATE TABLE `contiene` (
  `id_pedido` int(11) UNSIGNED NOT NULL,
  `id_variedad` int(11) UNSIGNED NOT NULL,
  `cantidad` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `correo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `calle` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `numero` int(7) DEFAULT NULL,
  `entre` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cp` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cuit` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `otros` text COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestorMP`
--

CREATE TABLE `gestorMP` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_cliente` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_secret` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gestorMP`
--

INSERT INTO `gestorMP` (`id`, `id_cliente`, `id_secret`) VALUES
(1, '4378170849643765', '1ylsihUNy5H3cUtGQmTidpWBszcdRRec');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mayorista`
--

CREATE TABLE `mayorista` (
  `correo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `clave` text COLLATE utf8_spanish_ci NOT NULL,
  `cuit` int(10) NOT NULL,
  `fecha_reg` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_pedido` int(25) UNSIGNED NOT NULL,
  `correo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `informacion` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(10) COLLATE utf8_spanish_ci DEFAULT 'pendiente',
  `id_cliente` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_secret` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `envio` tinyint(1) DEFAULT NULL,
  `correo` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `aplicacion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `gama` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `video` text COLLATE utf8_spanish_ci,
  `ficha_pdf` text COLLATE utf8_spanish_ci,
  `modelo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish_ci,
  `fecha` datetime NOT NULL,
  `categoria` varchar(15) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `imagen`, `aplicacion`, `tipo`, `gama`, `video`, `ficha_pdf`, `modelo`, `descripcion`, `fecha`, `categoria`) VALUES
(1509829729, 'SPECIFIC 5W40 ', '1509831628.jpg', 'VENTO-AMAROK -BORA-PASSAT', 'ACEITE SINTETICO', 'Auto ', '', '', '1', '<p><strong>PRESTACIONES</strong></p>\r\n\r\n<p><strong>NORMAS ACEA C3 HOMOLOGACIONES VW 505 01 - 502 00 &ndash; 505 00 PERFORMANCE FORD WSS M2C 917A Las homologaciones oficiales de VOLKSWAGEN son la garant&iacute;a de calidad en concepto y en fabricaci&oacute;n del producto, en t&eacute;rminos de exigencia en anti-oxidaci&oacute;n, anti-desgaste, anti-espuma y anti-corrosi&oacute;n. La base 100% sint&eacute;tica proporciona un poder lubricante m&aacute;s elevado que permite resistir las fuertes prestaciones exigidas en la distribuci&oacute;n del sistema Inyector Bomba. Disminuye las fricciones y permite resistir altas temperaturas atendiendo a los motores modernos. Tecnolog&iacute;a &quot;Mid SAPS&quot; para una mayor compatibilidad con los catalizadores de &uacute;ltima generaci&oacute;n. La norma FORD WSS M2C 917&ordf; es aplicada en los veh&iacute;culos FORD Galaxy 1.9 TDI fabricados hasta 2006; as&iacute; mismo en los FORD Ka 1.2 Duratec y 1.3 Duratorq TDCi fabricados a partir de 2008.</strong></p>\r\n', '2017-11-04 17:08:49', 'Motul'),
(1509831093, 'SPECIFIC 5W40 ', '1509831383.png', 'VENTO-AMAROK -BORA-PASSAT', '100% SintÃ©tico ', 'Auto ', '', '1509831093.pdf', '0', '<p><strong>PRESTACIONES</strong></p>\r\n\r\n<p><strong>NORMAS ACEA C3 HOMOLOGACIONES VW 505 01 - 502 00 &ndash; 505 00 PERFORMANCE FORD WSS M2C 917A Las homologaciones oficiales de VOLKSWAGEN son la garant&iacute;a de calidad en concepto y en fabricaci&oacute;n del producto, en t&eacute;rminos de exigencia en anti-oxidaci&oacute;n, anti-desgaste, anti-espuma y anti-corrosi&oacute;n. La base 100% sint&eacute;tica proporciona un poder lubricante m&aacute;s elevado que permite resistir las fuertes prestaciones exigidas en la distribuci&oacute;n del sistema Inyector Bomba. Disminuye las fricciones y permite resistir altas temperaturas atendiendo a los motores modernos. Tecnolog&iacute;a &quot;Mid SAPS&quot; para una mayor compatibilidad con los catalizadores de &uacute;ltima generaci&oacute;n. La norma FORD WSS M2C 917&ordf; es aplicada en los veh&iacute;culos FORD Galaxy 1.9 TDI fabricados hasta 2006; as&iacute; mismo en los FORD Ka 1.2 Duratec y 1.3 Duratorq TDCi fabricados a partir de 2008.</strong></p>\r\n', '2017-11-04 17:31:33', 'Motul'),
(1509936380, '8100 X-CESS 5W40', '1509937239.jpg', 'BMW-VW-RANAULT-FIAT', '100% SintÃ©tico API SN/CF', 'Auto ', '', '1509936380.pdf', '1', '<p><strong>APLICACIONES:</strong></p>\r\n\r\n<p><strong>Lubricante de altas prestaciones 100% sint&eacute;tico, especialmente dise&ntilde;o para los veh&iacute;culos potentes y recientes, de gran cilindrada, Gasolina y turbo Diesel con inyecci&oacute;n directa. Las numerosas homologaciones por los fabricantes hacen de este un producto polivalente recomendado para los veh&iacute;culos bajo garant&iacute;a de los fabricantes. Recomendado para todo tipos de combustibles, gasolina con o sin plomo, gasoil y GPL. Compatible con sistemas anti-contaminantes</strong></p>\r\n', '2017-11-05 21:46:20', 'Motul'),
(1509936904, '8100 X-CESS 5W40', '1509937146.jpg', 'BMW-VW-RANAULT-FIAT', '100% SintÃ©tico API  SN / CF', 'Auto ', '', '1509936904.pdf', '', '<p><strong>APLICACIONES:</strong></p>\r\n\r\n<p><strong>Lubricante de altas prestaciones 100% sint&eacute;tico, especialmente dise&ntilde;o para los veh&iacute;culos potentes y recientes, de gran cilindrada, Gasolina y turbo Diesel con inyecci&oacute;n directa. Las numerosas homologaciones por los fabricantes hacen de este un producto polivalente recomendado para los veh&iacute;culos bajo garant&iacute;a de los fabricantes. Recomendado para todo tipos de combustibles, gasolina con o sin plomo, gasoil y GPL. Compatible con sistemas anti-contaminantes.&nbsp;<br />\r\nPRESTACIONES&nbsp;</strong></p>\r\n', '2017-11-05 21:55:04', 'Motul'),
(1509937912, '300 V 5w30 POWER RACING ', '1509938176.jpg', 'CompeticiÃ³n ', 'Tecnologia Ester Core ', 'Auto ', '', '1509937912.pdf', '1', '<p><strong>Aceite de motor 100% sint&eacute;tico para carreras basado en la tecnolog&iacute;a ESTER Core&reg;.&nbsp;A trav&eacute;s de asociaciones t&eacute;cnicas con los m&aacute;s prestigiosos equipos de carreras de autos, MOTUL ha desarrollado una amplia gama de lubricantes para autos deportivos y de carreras.&nbsp;La l&iacute;nea de 300V para deportes de motor mejora el rendimiento de los motores de &uacute;ltima generaci&oacute;n junto con una alta protecci&oacute;n contra el desgaste, la ca&iacute;da de presi&oacute;n de aceite y la oxidaci&oacute;n debido a la alta temperatura.&nbsp;Poder y Confiabilidad.&nbsp;Diluci&oacute;n media del motor&nbsp;</strong><br />\r\n&nbsp;</p>\r\n', '2017-11-05 22:11:52', 'Motul'),
(1509939178, '300V POWER 5W40', '1509939178.jpg', 'CompeticiÃ³n ', '100% SINTÃ‰TICO', 'Auto ', '', '1509939178.pdf', '', '<p><strong>Aplicacion: </strong></p>\r\n\r\n<p><strong>100% synthetic racing motor oil based on ESTER Core&reg; technology. Through technical partnerships with most prestigious Teams of car racing, MOTUL has developed a wide range of lubricants for Racing and Sport cars. The 300V motorsport line improves performance of the latest generation engines along with high protection against wear, oil pressure drop and oxidation due to high temperature. Power and Reliability. Medium engine dilution.</strong><br />\r\n<br />\r\n<strong>Type of use: Sprint / Rally&nbsp;</strong></p>\r\n', '2017-11-05 22:32:58', 'Motul'),
(1509939756, '300V CHRONO 10W40', '1509939756.jpg', 'CompeticiÃ³n ', '100% SintÃ©tico Ester ', 'Auto ', '', '1509939756.pdf', '1', '<p><strong>Aplicacion: </strong></p>\r\n\r\n<p><strong>100% synthetic racing motor oil based on ESTER Core&reg; technology. Through technical partnerships with most prestigious Teams of car racing, MOTUL has developed a wide range of lubricants for Racing and Sport cars. The 300V motorsport line improves performance of the latest generation engines along with high protection against wear, oil pressure drop and oxidation due to high temperature. High reliability. Medium engine dilution.<br />\r\n<br />\r\nType of use: Sprint / Rally / GT</strong></p>\r\n', '2017-11-05 22:42:36', 'Motul'),
(1509970266, '4100  Turbolight 10w40', '1509970266.jpg', 'Varios ', 'Semi-Sintetico API SN / CF', 'Auto ', '', '1509970266.pdf', '1', '<p><strong>Lubricante Technosynthese&nbsp;&reg;&nbsp;especialmente dise&ntilde;ado para autom&oacute;viles potentes y recientes</strong>, equipado con motores de gran cilindrada, inyecci&oacute;n directa turbo Diesel o inyecci&oacute;n de gasolina y convertidor catal&iacute;tico.</p>\r\n\r\n<p>Adecuado para todo tipo de combustibles, gasolina con o sin plomo, etanol, GLP, diesel y biocombustibles.</p>\r\n\r\n<p>Compatible con convertidores catal&iacute;ticos.</p>\r\n\r\n<p>PERFORMANCES NORMES ACEA A3 / B4 API SERVICE SN HOMOLOGATIONS MB-Approval 229.1 RENAULT RN0700 VW 501 01 / 505 00 PERFORMANCES PSA B71 2300</p>\r\n', '2017-11-06 07:11:06', 'Motul'),
(1510100620, '4100  Turbolight 10w40', '1510100620.jpg', 'Varios ', 'Semi-Sintetico API SN / CF', 'Auto ', '', '', '1', '<p><strong>Lubricante Technosynthese&nbsp;&reg;&nbsp;especialmente dise&ntilde;ado para autom&oacute;viles potentes y recientes</strong>, equipado con motores de gran cilindrada, inyecci&oacute;n directa turbo Diesel o inyecci&oacute;n de gasolina y convertidor catal&iacute;tico.</p>\r\n\r\n<p>Adecuado para todo tipo de combustibles, gasolina con o sin plomo, etanol, GLP, diesel y biocombustibles.</p>\r\n\r\n<p>Compatible con convertidores catal&iacute;ticos.</p>\r\n\r\n<p>PERFORMANCES NORMES ACEA A3 / B4 API SERVICE SN HOMOLOGATIONS MB-Approval 229.1 RENAULT RN0700 VW 501 01 / 505 00 PERFORMANCES PSA B71 2300</p>\r\n', '2017-11-07 19:23:40', 'Motul'),
(1510101388, '8100 Eco-Nergy 5w30', '1510101659.jpg', ' Ford 913 C, Renault RN 0700', '100% SINTÃ‰TICO', 'Auto ', '', '1510101388.pdf', '1', '<p><strong>APLICACIONES Aceite motor &ldquo;Fuel Economy&rdquo; 100% formula especialmente para los motores gasolina o turbo di&eacute;sel inyecci&oacute;n directa previstos para utilizar aceites de baja fricci&oacute;n y baja viscosidad HTHS (High Temperature High Shear). Recomendado para todo tipo de motores gasolina y di&eacute;sel donde un lubricante &quot;Fuel Economy&quot; este solicitado: Est&aacute;ndares ACEA A1/B1 o A5/B5. Compatible con sistemas post catal&iacute;ticos. Ciertos motores no puede utilizar este tipo de lubricantes, antes de su utilizaci&oacute;n verificar con el manual de mantenimiento del veh&iacute;culo. PRESTACIONES NORMAS ACEA A5 / B5 API SERVICES SL / CF HOMOLOGACIONES FORD WSS M2C 913D JAGUAR LAND ROVER STJLR.03.5003 RENAULT RN0700 con n&deg; RN700-10-69</strong></p>\r\n', '2017-11-07 19:36:28', 'Motul'),
(1510143377, '8100 Eco-Nergy 5w30', '1510143377.jpg', 'Ford 913 C, Renault RN 0700', '100% SintÃ©tico ', 'Auto ', '', '1510143377.pdf', '1', '<h1><strong>8100 ECO-NERGY 5W30</strong></h1>\r\n\r\n<p><strong>Lubricante 100% sint&eacute;tico de &uacute;ltima generaci&oacute;n. Formulado especialmente para obtener la calificaci&oacute;n Energy Saving. Para las exigencias de los motores modernos que requieren baja fricci&oacute;n y baja viscosidad HTHS. Es decir, econom&iacute;a en su movimiento, pero manteniendo la pel&iacute;cula lubricante. Aplicable en aquellos requerimientos ACEA A1/B1 o A5/B5. Compatible con sistemas catalizadores de gases de escape. Homologaciones Ford 913 C, Renault RN 0700.</strong></p>\r\n\r\n<p><strong>Formato: 1L-5L</strong></p>\r\n', '2017-11-08 07:16:17', 'Motul'),
(1510144298, '8100 5W30 X-CLEAN  5w30', '1510144298.jpg', 'BMW LL-04 - VW 502.00/505.00', '100% SintÃ©tico ', 'Auto ', '', '1510144298.pdf', '1', '<h1><strong>8100 X-Clean Power Racing 5w30</strong></h1>\r\n\r\n<p><strong>Lubricante 100% Sint&eacute;tico de viscosidad HTHS alta. ACEA C3 lo hace compatible con filtros de part&iacute;culas y catalizadores, orientada su aplicaci&oacute;n a motores de alta performance donde se solicite baja viscosidad SAE y alta presi&oacute;n de pel&iacute;cula lubricante. Utilizable donde se requiera ACEA A3/B4, combinado con el uso de combustibles modernos. SAE 5w30 &ndash; BMW LL-04, MB 229.51</strong></p>\r\n\r\n<p><strong>Recomendado por numerosos constructores, como FIAT, HYUNDAI / KIA, NISSAN, RENAULT, SSANGYONG, SUZUKI,&hellip;etc., que reconocen un nivel ACEA C3 para todos sus veh&iacute;culos, especialmente Diesel con FAP. La norma BMW Long Life-04 exige al lubricante elevadas prestaciones, cubriendo adem&aacute;s toda la gama de motores a partir de 2004. El nivel LL-04 cubre todos los niveles anteriores, (BMW LL-98 y BMW LL-01). Atenci&oacute;n, el nivel BMW LL-04 en motores a Gasolina s&oacute;lo puede ser usado en la Uni&oacute;n Europea, Suiza, Noruega y Liechtenstein. Para otras &aacute;reas, el nivel BMW LL-01 es la prescripci&oacute;n m&aacute;s com&uacute;n: MOTUL 8100 X-cess 5W-40)</strong></p>\r\n', '2017-11-08 07:31:38', 'Motul'),
(1510196063, '6100 Synergie  10w40', '1510196063.jpg', 'RENAULT-VW-PSA-MB', 'API SERVICES SN / CF ', 'Auto ', '', '1510196063.pdf', '1', '<p><strong>Innovaci&oacute;n mundial: MOTUL 6100 SYNERGIE+ 10W-40 es el primer lubricante del mundo homologado con la norma MB 229.3 en grado de viscosidad 10W-40. La norma MB 229.3 es mucho m&aacute;s exigente que la 229.1 en t&eacute;rminos de resistencia al envejecimiento (intervalos de mantenimiento: ordenador a bordo) y exige propiedades de econom&iacute;a de energ&iacute;a: 1.2% de ganancia respecto a un lubricante 15W-40 de referencia. La especificaci&oacute;n MB 229.3 es aplicada en la mayor&iacute;a de los motores Gasolina y la mayor&iacute;a de los Diesel sin FAP (filtros de part&iacute;culas) de MERCEDES.La performance API SN garantiza un nivel muy elevado de prestaciones para el lubricante en t&eacute;rminos de prestaciones del motor y protecci&oacute;n contra el desgaste. PSA para su norma B71 2300 impone al lubricante de responder a condiciones t&eacute;rmicas muy severas con el fin de ser compatible con todas sus motorizaciones Gasolina (incluidas 1.8L, 2.0L y 2.2L) y Diesel sin FAP. La especificaci&oacute;n Renault RN0700 exige a los lubricantes que respondan a condiciones t&eacute;rmicas muy severas y compatibilidad con los sistemas de post tratamiento. La norma RN0700 es aplicada especialmente en los motores Gasolina atmosf&eacute;ricos (excepto Renault Sport) del grupo RENAULT (Renault, Dacia, Samsung). La norma RN0700 es aplicada as&iacute; mismo en todos los modelos Diesel de RENAULT equipados con motor 1.5 dCi sin FAP &lt; 100 CV con un intervalo de mantenimiento de 20 000 km o 1 a&ntilde;o. Antes de su utilizaci&oacute;n, siempre hacer referencia a las recomendaciones del manual de mantenimiento del veh&iacute;culo</strong></p>\r\n', '2017-11-08 21:54:23', 'Motul'),
(1510196396, '6100 Synergie  10w40', '1510196396.jpg', 'RENAULT-VW-PSA-MB', 'Semi-Sintetico API SN / CF', 'Auto ', '', '1510196396.pdf', '1', '<p><strong>Innovaci&oacute;n mundial: MOTUL 6100 SYNERGIE+ 10W-40 es el primer lubricante del mundo homologado con la norma MB 229.3 en grado de viscosidad 10W-40. La norma MB 229.3 es mucho m&aacute;s exigente que la 229.1 en t&eacute;rminos de resistencia al envejecimiento (intervalos de mantenimiento: ordenador a bordo) y exige propiedades de econom&iacute;a de energ&iacute;a: 1.2% de ganancia respecto a un lubricante 15W-40 de referencia. La especificaci&oacute;n MB 229.3 es aplicada en la mayor&iacute;a de los motores Gasolina y la mayor&iacute;a de los Diesel sin FAP (filtros de part&iacute;culas) de MERCEDES.La performance API SN garantiza un nivel muy elevado de prestaciones para el lubricante en t&eacute;rminos de prestaciones del motor y protecci&oacute;n contra el desgaste. PSA para su norma B71 2300 impone al lubricante de responder a condiciones t&eacute;rmicas muy severas con el fin de ser compatible con todas sus motorizaciones Gasolina (incluidas 1.8L, 2.0L y 2.2L) y Diesel sin FAP. La especificaci&oacute;n Renault RN0700 exige a los lubricantes que respondan a condiciones t&eacute;rmicas muy severas y compatibilidad con los sistemas de post tratamiento. La norma RN0700 es aplicada especialmente en los motores Gasolina atmosf&eacute;ricos (excepto Renault Sport) del grupo RENAULT (Renault, Dacia, Samsung). La norma RN0700 es aplicada as&iacute; mismo en todos los modelos Diesel de RENAULT equipados con motor 1.5 dCi sin FAP &lt; 100 CV con un intervalo de mantenimiento de 20 000 km o 1 a&ntilde;o. Antes de su utilizaci&oacute;n, siempre hacer referencia a las recomendaciones del manual de mantenimiento del veh&iacute;culo.</strong></p>\r\n', '2017-11-08 21:59:56', 'Motul'),
(1510197133, '6100 Flexlite 0w20', '1510197133.png', 'Honada-Toyota-kia-Isuzu-Subaru', 'SAE 0W20 API SN ILSAC GF-5', 'Auto ', '', '1510197133.pdf', '1', '<p><strong>APLICACIONES:</strong></p>\r\n\r\n<p><strong>Lubricante Technosynthese&reg; &ldquo;Fuel economy&rdquo; proyectado para motores a gasolina o flex modernos, concebidos para emplear lubricantes de ultra baja fricci&oacute;n, con viscosidad HTHS baja (&ge; 2,6 mPa.s) y de tecnolog&iacute;a &ldquo;Mid SAPS&rdquo; con bajo contenido de Cenizas Sulfatadas (&le;0,8%), F&oacute;sforo (0,07%&le; x &le; 0.09%) y Azufre (&le;0,3%). Puede aplicarse tambi&eacute;n en veh&iacute;culos h&iacute;bridos de origen americano o asi&aacute;tico. Este lubricante es compatible con Sistemas Catal&iacute;ticos de Post-Tratamiento de Gases. PERFORMANCE STANDARDS API Performance SN ILSAC GF-5 Este lubricante es recomendado tambi&eacute;n para veh&iacute;culos que requieren otras normas, tales como: Chrysler MS-6395, Ford WSS-M2C 946-A, GM 6094M as&iacute; como tambi&eacute;n algunos Honda, Toyota, Hyundai, Isuzu, Kia, Mazda, Mitsubishi, Nissan, Subaru, Suzuki, etc La norma API SN es totalmente retrocompatible con la API SM y anteriores.</strong></p>\r\n', '2017-11-08 22:12:13', 'Motul'),
(1510197662, '4100 Power 15w50', '1510197662.jpg', 'MB 229.01-VW 50101-50500', 'ACEA A3/B4 API SL/CF', 'Auto ', '', '1510197662.pdf', '1', '<p><strong>APLICACIONES:</strong></p>\r\n\r\n<p><strong>Lubricante Technosynthese&reg; para motores de 4 tiempos a Gasolina, GNC/GLP, Flex,Diesel, sobrealimentados o no, con inyecci&oacute;n directa o sistema cl&aacute;sico de inyecci&oacute;n. El produto es compatible com sistemas catalizadores Especialmente recomendado para motores nuevos y semi-nuevos. Compatible com todo tipo de condici&oacute;n de servicio: severo urbano, mixto y leve en carreteras. PRESTACIONES NORMAS ACEA A3/ B4 API SL/ CF HOMOLOGACIONES MB-Approval 229.1 VW 501 01 - 505 00 La norma API SL es m&aacute;s exigente que la API SJ, en cuanto a su resistencia a la oxidaci&oacute;n (incremento de los intervalos de cambio), permitiendo asimismo una mayor estabilidad de la viscosidad durante el servicio, desplazando adem&aacute;s, la formaci&oacute;n de dep&oacute;sitos y lodos en todas las zonas del motor. El nivel de servicio ACEA B4 introduce una mejora en la gesti&oacute;n de los residuos formados por el sistema de inyecci&oacute;n directa diesel manteniendo el motor m&aacute;s limpio y libre de residuos s&oacute;lidos, a&uacute;n en aquellos motores que poseen v&aacute;lvula EGR. La base sint&eacute;tica Technosynthese&reg; proporciona un elevado poder lubricante, protegiendo perfectamente el motor en uso intensivo tanto en carretera, autopista o ciudad. Las elevadas prestaciones de su aditivaci&oacute;n anti-desgaste permiten disminuir el rozamiento interno del motor, reduciendo el desgaste y aumentando su vida &uacute;til. La elevada viscosidad a alta temperatura (SAE 50) se adapta perfectamente a los motores que poseen una tendencia al consumo de aceite Protecci&oacute;n antiherrumbre, antiespumante, antioxidante y anticorrosivo.</strong></p>\r\n', '2017-11-08 22:21:02', 'Motul');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `correo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `clave` text COLLATE utf8_spanish_ci NOT NULL,
  `dni` int(10) NOT NULL,
  `fecha_reg` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variedades`
--

CREATE TABLE `variedades` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_producto` int(11) UNSIGNED NOT NULL,
  `envase` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio_unidad` float DEFAULT NULL,
  `cantidad_mayorista` int(11) DEFAULT NULL,
  `precio_mayorista` float DEFAULT NULL,
  `stock` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `variedades`
--

INSERT INTO `variedades` (`id`, `id_producto`, `envase`, `precio_unidad`, `cantidad_mayorista`, `precio_mayorista`, `stock`) VALUES
(6, 1509829729, '5 lITROS ', 1430.15, 4, 1072.61, 1),
(7, 1509831093, '1 litro', 329.15, 4, 246.86, 4),
(8, 1509936380, '5 lITROS ', 1141.19, 4, 855.89, 10),
(9, 1509936904, '2 Litros ', 500.35, 12, 375.26, 100),
(10, 1509937912, '2 Litros ', 914.26, 12, 685.69, 100),
(11, 1509939178, '2 Litros ', 914.26, 12, 685.69, 100),
(12, 1509939756, '2 Litros ', 914.26, 12, 685.69, 100),
(13, 1509970266, '4 Litros ', 604.3, 4, 453.22, 100),
(14, 1510100620, '1 litro', 169.99, 12, 127.49, 100),
(15, 1510101388, '5 lITROS ', 1252.85, 4, 939.65, 100),
(16, 1510143377, '1 litro', 325.75, 12, 244.31, 100),
(17, 1510144298, '5 lITROS ', 1186.15, 4, 889.61, 100),
(18, 1510196063, '5 Litros ', 986.75, 4, 740.05, 100),
(19, 1510196396, '1 litro', 387.25, 4, 290.43, 100),
(20, 1510197133, '4 Litros ', 771.75, 4, 578.81, 100),
(21, 1510197662, '5 lITROS ', 964.5, 4, 723.37, 100);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`nombre`);

--
-- Indices de la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`id_pedido`,`id_variedad`),
  ADD KEY `id_variedad` (`id_variedad`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`correo`);

--
-- Indices de la tabla `gestorMP`
--
ALTER TABLE `gestorMP`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mayorista`
--
ALTER TABLE `mayorista`
  ADD PRIMARY KEY (`correo`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `correo` (`correo`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `correo` (`correo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria` (`categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`correo`);

--
-- Indices de la tabla `variedades`
--
ALTER TABLE `variedades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gestorMP`
--
ALTER TABLE `gestorMP`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `variedades`
--
ALTER TABLE `variedades`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `contiene_ibfk_2` FOREIGN KEY (`id_variedad`) REFERENCES `variedades` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `usuarios` (`correo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `usuarios` (`correo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `usuarios` (`correo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`nombre`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `variedades`
--
ALTER TABLE `variedades`
  ADD CONSTRAINT `variedades_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
