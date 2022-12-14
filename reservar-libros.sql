-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 14, 2022 at 02:37 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservar-libros`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AUMENTAR_DISPONIBILIDAD` (IN `IDLIBRO` INT, IN `CANTIDAD` INT)  BEGIN

SET @DISP = (SELECT disponibilidad FROM Existencia WHERE Libros_idLibros = IDLIBRO) + CANTIDAD;
UPDATE Existencia SET disponibilidad = @DISP WHERE Libros_idLibros = IDLIBRO;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RESTAR_DISPONIBILIDAD` (IN `IDLIBRO` INT, IN `CANTIDAD` INT)  BEGIN

SET @DISP = (SELECT disponibilidad FROM Existencia WHERE Libros_idLibros = IDLIBRO) - CANTIDAD;
UPDATE Existencia SET disponibilidad = @DISP WHERE Libros_idLibros = IDLIBRO;

END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `TOTAL_A_PAGAR` (`IDUSUARIO` INT) RETURNS DOUBLE BEGIN
 RETURN (SELECT SUM((R.cantidad * L.precio)) FROM Reserva as R 
 INNER JOIN Libros as L ON L.idLibros = R.Libros_idLibros 
 INNER JOIN Usuarios AS U ON U.idUsuarios = R.Usuarios_idUsuarios 
 WHERE U.idUsuarios = IDUSUARIO);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Categoria`
--

CREATE TABLE `Categoria` (
  `idCategoria` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Categoria`
--

INSERT INTO `Categoria` (`idCategoria`, `nombre`, `descripcion`) VALUES
(1, 'Diseño Web', 'El diseño web es una actividad que consiste en la planificación, diseño, implementación y mantenimiento de sitios web'),
(2, 'Anatomia', 'La anatomía humana incluye el estudio de las células, los tejidos y los órganos que componen el cuerpo y el modo en que se organizan en el mismo.'),
(5, 'Matematicas', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Existencia`
--

CREATE TABLE `Existencia` (
  `idExistencia` int(10) UNSIGNED NOT NULL,
  `Libros_idLibros` int(10) UNSIGNED NOT NULL,
  `cantidad` int(10) UNSIGNED DEFAULT NULL,
  `disponibilidad` int(11) NOT NULL
) ;

--
-- Dumping data for table `Existencia`
--

INSERT INTO `Existencia` (`idExistencia`, `Libros_idLibros`, `cantidad`, `disponibilidad`) VALUES
(1, 1, 10, 10),
(2, 2, 10, 4),
(9, 19, 100, 10);

-- --------------------------------------------------------

--
-- Table structure for table `Libros`
--

CREATE TABLE `Libros` (
  `idLibros` int(10) UNSIGNED NOT NULL,
  `Categoria_idCategoria` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `resumen` longtext DEFAULT NULL,
  `fotos` varchar(255) DEFAULT NULL,
  `precio` double UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Libros`
--

INSERT INTO `Libros` (`idLibros`, `Categoria_idCategoria`, `titulo`, `autor`, `resumen`, `fotos`, `precio`) VALUES
(1, 2, 'Enciclopedia de Anatomía del Ejercicio 2', 'Hollis Lance Liebman', 'La Enciclopedia de anatomía del ejercicio, de Hollis Lance Liebman, es una completa guía de referencia y consulta sobre ejercicio y forma física, con instrucciones precisas y profusamente ilustrada con fotografías y dibujos anatómicos.', 'libro1.jpg', 10000),
(2, 2, 'Atlas de Anatomía Palpatoria', 'Serge Tixa', 'Este libro presenta un método de anatomía palpatoria: la IMS (investigación manual de superficie). La IMS es un método de exploración de estructuras anatómicas (huesos, ligamentos, tendones, vientres musculares, elementos vasculonerviosos) muy visual.', 'libro2.jpg', 22000),
(19, 1, 'SQL', 'Juan R', 'En las últimas décadas, se han desarrollado muchos lenguajes de programación, y solo algunos se han mantenido. Algunos ejemplos son C, que es un sistema operativo y de desarrollo de servidores popular para sistemas integrados. Cuando se trata de bases de datos, el lenguaje de consulta estructurado (SQL) ha existido desde la década de 1970.Puede usar SQL para crear, generar, administrar y manipular desde bases de datos relacionales. La mayoría de las empresas prefieren utilizar una base de datos relacional, ya que puede almacenar cientos y miles de filas de datos.En este libro, recopilará información sobre qué es SQL y por qué es importante aprender SQL. Este libro también cubre algunos de los comandos básicos que se usan en SQL y explica cómo puede usar esos comandos para manipular información en tablas y conjuntos de datos. Este libro cubre información sobre diferentes tipos de datos, operadores y funciones que puede utilizar para trabajar con datos y analizarlos.Debes continuar practicando si quieres dominar SQL. Está bien no saber qué código usar cuando empiezas a aprender a codificar en un idioma. Solo cuando practique, sabrá dónde debe aplicar un operador o función específica.Así que empieza a aprender a ser un maestro de SQL y toma este libro para comenzar tu viaje', 'libro3.jpeg', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `Reserva`
--

CREATE TABLE `Reserva` (
  `idReserva` int(10) UNSIGNED NOT NULL,
  `Libros_idLibros` int(10) UNSIGNED NOT NULL,
  `Usuarios_idUsuarios` int(10) UNSIGNED NOT NULL,
  `fecha_reserva` date DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `cantidad` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Reserva`
--

INSERT INTO `Reserva` (`idReserva`, `Libros_idLibros`, `Usuarios_idUsuarios`, `fecha_reserva`, `fecha_entrega`, `cantidad`) VALUES
(7, 1, 4, '2022-12-12', '2022-12-19', 2),
(21, 2, 4, '2022-12-12', '2022-12-19', 2);

--
-- Triggers `Reserva`
--
DELIMITER $$
CREATE TRIGGER `FECHA_ENTREGA_LIBRO` BEFORE INSERT ON `Reserva` FOR EACH ROW BEGIN

SET @HOY = (SELECT CURRENT_DATE);
SET @DIA_ENTREGA =  (SELECT DATE_ADD(@HOY, INTERVAL 7 DAY));

SET NEW.fecha_reserva = @HOY, NEW.fecha_entrega = @DIA_ENTREGA;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Usuarios`
--

CREATE TABLE `Usuarios` (
  `idUsuarios` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_` varchar(255) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Usuarios`
--

INSERT INTO `Usuarios` (`idUsuarios`, `nombre`, `email`, `password_`, `fecha_creacion`) VALUES
(4, 'demo', 'demo@gmail.com', '$2y$10$TMOz1YqUm2RMomZtvKLvGOOp1RAVM/GsMgKk8kMmJxVZPUix1juzC', NULL),
(5, 'mateo', 'mateo@gmail.com', '$2y$10$iTnxLkGLP0v2pNToobJfq.PoX/bLxolbdPp/AetEa.qjiRpCTxMbe', NULL),
(10, 'admin', 'admin@gmail.com', '$2y$10$xXqOEDBtjR3AfFLoniUzFuQCLYiguMl7QUt/qIWTUqrHHa30CZ91e', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Categoria`
--
ALTER TABLE `Categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indexes for table `Existencia`
--
ALTER TABLE `Existencia`
  ADD PRIMARY KEY (`idExistencia`),
  ADD KEY `Existencia_FKIndex1` (`Libros_idLibros`);

--
-- Indexes for table `Libros`
--
ALTER TABLE `Libros`
  ADD PRIMARY KEY (`idLibros`),
  ADD KEY `Libros_FKIndex1` (`Categoria_idCategoria`);

--
-- Indexes for table `Reserva`
--
ALTER TABLE `Reserva`
  ADD PRIMARY KEY (`idReserva`),
  ADD KEY `Reserva_FKIndex1` (`Usuarios_idUsuarios`),
  ADD KEY `Reserva_FKIndex2` (`Libros_idLibros`);

--
-- Indexes for table `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`idUsuarios`),
  ADD UNIQUE KEY `USUARIO_REGISTRADO` (`nombre`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Categoria`
--
ALTER TABLE `Categoria`
  MODIFY `idCategoria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Existencia`
--
ALTER TABLE `Existencia`
  MODIFY `idExistencia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Libros`
--
ALTER TABLE `Libros`
  MODIFY `idLibros` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Reserva`
--
ALTER TABLE `Reserva`
  MODIFY `idReserva` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `idUsuarios` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Existencia`
--
ALTER TABLE `Existencia`
  ADD CONSTRAINT `Existencia_ibfk_1` FOREIGN KEY (`Libros_idLibros`) REFERENCES `Libros` (`idLibros`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Libros`
--
ALTER TABLE `Libros`
  ADD CONSTRAINT `Libros_ibfk_1` FOREIGN KEY (`Categoria_idCategoria`) REFERENCES `Categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Reserva`
--
ALTER TABLE `Reserva`
  ADD CONSTRAINT `Reserva_ibfk_1` FOREIGN KEY (`Usuarios_idUsuarios`) REFERENCES `Usuarios` (`idUsuarios`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Reserva_ibfk_2` FOREIGN KEY (`Libros_idLibros`) REFERENCES `Libros` (`idLibros`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
