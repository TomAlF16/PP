-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2024 a las 05:08:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base4`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `cantidad` int(11) NOT NULL,
  `idCarrito` int(11) NOT NULL,
  `idLibro` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`cantidad`, `idCarrito`, `idLibro`, `idCliente`) VALUES
(1, 21, 11, 2),
(1, 22, 10, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nombre`) VALUES
(1, 'Ficcion'),
(2, 'Ciencia'),
(3, 'Amor'),
(4, 'Historia'),
(5, 'Finanzas'),
(6, 'Policiales\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `NumeroTarjeta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nombre`, `idUsuario`, `NumeroTarjeta`) VALUES
(2, 'Escroto McBolas', 1, 0),
(7, 'John Salchichon', 2, 0),
(1223, 'facundo', 2, 0),
(1224, 'Test', 1235, 0),
(1225, 'Tomás', 1236, 0),
(1226, 'Gordo', 1238, 1),
(1227, 'MoriteFacundo', 1239, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idCompra` int(11) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idCompra`, `idCliente`, `total`, `fecha`) VALUES
(1, 2, 32000.00, '2024-11-20 03:58:07'),
(2, 2, 32040.00, '2024-11-20 04:01:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `idDetalleCompra` int(11) NOT NULL,
  `idCompra` int(11) NOT NULL,
  `idLibro` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`idDetalleCompra`, `idCompra`, `idLibro`, `cantidad`, `precio`) VALUES
(0, 1, 11, 1, 32000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorito`
--

CREATE TABLE `favorito` (
  `IDfavorito` int(11) NOT NULL,
  `IDcliente` int(11) NOT NULL,
  `IDlibro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `idLibro` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `NombreAutor` varchar(50) NOT NULL,
  `stockAlquiler` int(11) NOT NULL,
  `stockVenta` tinyint(1) NOT NULL,
  `PrecioVenta` int(11) NOT NULL,
  `PrecioAlquiler` int(11) NOT NULL,
  `Descripcion` text NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `idCategoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`idLibro`, `titulo`, `NombreAutor`, `stockAlquiler`, `stockVenta`, `PrecioVenta`, `PrecioAlquiler`, `Descripcion`, `imagen`, `idCategoria`) VALUES
(10, 'El inversor inteligente', 'Benjamin Graham', 20, 50, 27000, 4, 'A lo largo de los años, la evolución del mercado ha comprobado lo sabias que han sido las estrategias enseñadas por Graham. A la vez que conserva la integridad del texto original, esta edición revisada incluye comentarios actualizados del famoso periodista financiero Jason Zweig, cuya perspectiva incorpora las realidades del mercado presente, traza paralelismos entre los ejemplos de Graham y los titulares financieros actuales, y brinda a los lectores una comprensión más plena de cómo hacer para aplicar dichos principios.', '/PP/imagenes/el inversor inteligente.jpg', 5),
(11, 'Piense y hagase rico', 'Napoleon Hill', 20, 50, 32000, 7000, 'Es asi de sencillo: la riqueza, la realizacion personal, estan al alcance de todas aquellas personas que lo desean; basta simplemente con develar el secreto del exito. Y para ello sencillamente hay que estar dispuesto a develarlo. Del famoso industrial, filantropo y escritor Daniel Carnegie, aprendio Napoleon Hill del secreto del exito y lo sistematizo para hacerlo accesible a cualquier persona de cualquier clase social.\"', '/PP/imagenes/piense y hagase rico.jpg', 5),
(14, 'El Juego del Ángel', 'Carlos Ruiz Zafón', 0, 0, 20, 0, '', '/PP/imagenes/test.jpg', 1),
(15, 'Cien Años de Soledad', 'Gabriel García Márquez', 0, 0, 23, 0, '', 'imagen2.jpg', 1),
(16, 'La Sombra del Viento', 'Carlos Ruiz Zafón', 0, 0, 19, 0, '', 'imagen3.jpg', 1),
(17, '1984', 'George Orwell', 0, 0, 16, 0, '', 'imagen4.jpg', 1),
(18, 'Harry Potter y la Piedra Filosofal', 'J.K. Rowling', 0, 0, 13, 0, '', 'imagen5.jpg', 1),
(19, 'El Alquimista', 'Paulo Coelho', 0, 0, 11, 0, '', 'imagen6.jpg', 1),
(20, 'Matar a un Ruiseñor', 'Harper Lee', 0, 0, 15, 0, '', 'imagen7.jpg', 1),
(21, 'Los Miserables', 'Victor Hugo', 0, 0, 21, 0, '', 'imagen8.jpg', 1),
(22, 'Don Quijote de la Mancha', 'Miguel de Cervantes', 0, 0, 17, 0, '', 'imagen9.jpg', 1),
(23, 'Orgullo y Prejuicio', 'Jane Austen', 0, 0, 12, 0, '', 'imagen10.jpg', 1),
(24, 'El Gran Gatsby', 'F. Scott Fitzgerald', 0, 0, 14, 0, '', 'imagen11.jpg', 1),
(25, 'Crónica de una Muerte Anunciada', 'Gabriel García Márquez', 0, 0, 16, 0, '', 'imagen12.jpg', 1),
(26, 'La Casa de los Espíritus', 'Isabel Allende', 0, 0, 19, 0, '', 'imagen13.jpg', 1),
(27, 'Fahrenheit 451', 'Ray Bradbury', 0, 0, 14, 0, '', 'imagen14.jpg', 1),
(28, 'El Hobbit', 'J.R.R. Tolkien', 0, 0, 21, 0, '', 'imagen15.jpg', 1),
(29, 'Bajo la Misma Estrella', 'John Green', 0, 0, 13, 0, '', 'imagen1.jpg', 3),
(30, 'Orgullo y Prejuicio', 'Jane Austen', 0, 0, 16, 0, '', 'imagen2.jpg', 3),
(31, 'Cumbres Borrascosas', 'Emily Brontë', 0, 0, 17, 0, '', 'imagen3.jpg', 3),
(32, 'El Amor en los Tiempos del Cólera', 'Gabriel García Márquez', 0, 0, 18, 0, '', 'imagen4.jpg', 3),
(33, 'Nosotros en la Noche', 'Diane Chamberlain', 0, 0, 15, 0, '', 'imagen5.jpg', 3),
(34, 'La Casa de los Espíritus', 'Isabel Allende', 0, 0, 20, 0, '', 'imagen6.jpg', 3),
(35, 'El Cuaderno de Maya', 'Isabel Allende', 0, 0, 20, 0, '', 'imagen7.jpg', 3),
(36, 'A Todos los Chicos de los que Me Enamoré', 'Jenny Han', 0, 0, 14, 0, '', 'imagen8.jpg', 3),
(37, 'Eleanor & Park', 'Rainbow Rowell', 0, 0, 16, 0, '', 'imagen9.jpg', 3),
(38, 'Yo Antes de Ti', 'Jojo Moyes', 0, 0, 18, 0, '', 'imagen10.jpg', 3),
(39, 'El Diario de Noa', 'Nicholas Sparks', 0, 0, 18, 0, '', 'imagen11.jpg', 3),
(40, 'P.S. I Love You', 'Cecelia Ahern', 0, 0, 13, 0, '', 'imagen12.jpg', 3),
(41, 'Querido John', 'Nicholas Sparks', 0, 0, 15, 0, '', 'imagen13.jpg', 3),
(42, 'Todo lo que Necesito Sabes de Ti', 'David Levithan', 0, 0, 16, 0, '', 'imagen14.jpg', 3),
(43, 'Te Lo Dije', 'Paula Gallego', 0, 0, 12, 0, '', 'imagen15.jpg', 3),
(44, 'La Teoría del Todo', 'Stephen Hawking', 0, 0, 23, 0, '', 'imagen1.jpg', 2),
(45, 'Breve Historia del Tiempo', 'Stephen Hawking', 0, 0, 19, 0, '', 'imagen2.jpg', 2),
(46, 'El Origen de las Especies', 'Charles Darwin', 0, 0, 17, 0, '', 'imagen3.jpg', 2),
(47, 'Sapiens: De Animales a Dioses', 'Yuval Noah Harari', 0, 0, 20, 0, '', 'imagen4.jpg', 2),
(48, 'Cosmos', 'Carl Sagan', 0, 0, 20, 0, '', 'imagen5.jpg', 2),
(49, 'Física para Universitarios', 'Hugh D. Young', 0, 0, 30, 0, '', 'imagen6.jpg', 2),
(50, 'La Historia de la Ciencia', 'John Gribbin', 0, 0, 26, 0, '', 'imagen7.jpg', 2),
(51, 'El Gen: Una Historia Personal', 'Siddhartha Mukherjee', 0, 0, 22, 0, '', 'imagen8.jpg', 2),
(52, 'Los Detectives del Cosmos', 'Peter Coles', 0, 0, 18, 0, '', 'imagen9.jpg', 2),
(53, 'Una Breve Historia del Mundo', 'Christopher Lascelles', 0, 0, 19, 0, '', 'imagen10.jpg', 2),
(54, 'El Universo en una Cáscara de Nuez', 'Stephen Hawking', 0, 0, 18, 0, '', 'imagen11.jpg', 2),
(55, 'El Universo Elegante', 'Brian Greene', 0, 0, 24, 0, '', 'imagen12.jpg', 2),
(56, 'La Vida Secreta de los Árboles', 'Peter Wohlleben', 0, 0, 23, 0, '', 'imagen13.jpg', 2),
(57, 'La Partícula al Final del Universo', 'Sean Carroll', 0, 0, 24, 0, '', 'imagen14.jpg', 2),
(58, 'El Último Teorema de Fermat', 'Simon Singh', 0, 0, 20, 0, '', 'imagen15.jpg', 2),
(59, 'Historia de la Segunda Guerra Mundial', 'Winston Churchill', 0, 0, 26, 0, '', 'imagen1.jpg', 4),
(60, 'Los Pilares de la Tierra', 'Ken Follett', 0, 0, 23, 0, '', 'imagen2.jpg', 4),
(61, 'Sapiens: De Animales a Dioses', 'Yuval Noah Harari', 0, 0, 20, 0, '', 'imagen3.jpg', 4),
(62, 'La Historia de la Guerra del Peloponeso', 'Tucídides', 0, 0, 19, 0, '', 'imagen4.jpg', 4),
(63, 'El Ascenso y la Caída del Tercer Reich', 'William L. Shirer', 0, 0, 28, 0, '', 'imagen5.jpg', 4),
(64, 'La Conquista de América', 'Juan de Mariana', 0, 0, 20, 0, '', 'imagen6.jpg', 4),
(65, 'Historia de la Revolución Francesa', 'Georges Lefebvre', 0, 0, 24, 0, '', 'imagen7.jpg', 4),
(66, 'La Historia del Imperio Romano', 'Theodor Mommsen', 0, 0, 21, 0, '', 'imagen8.jpg', 4),
(67, 'Historia de las Civilizaciones Antiguas', 'Will Durant', 0, 0, 24, 0, '', 'imagen9.jpg', 4),
(68, 'Los Miserables', 'Victor Hugo', 0, 0, 21, 0, '', 'imagen10.jpg', 4),
(69, 'El Siglo de las Luces', 'Alejo Carpentier', 0, 0, 18, 0, '', 'imagen11.jpg', 4),
(70, 'El Gran Juego', 'Peter Hopkirk', 0, 0, 29, 0, '', 'imagen12.jpg', 4),
(71, 'Breve Historia del Mundo', 'Christopher Lascelles', 0, 0, 20, 0, '', 'imagen13.jpg', 4),
(72, 'Las Venas Abiertas de América Latina', 'Eduardo Galeano', 0, 0, 18, 0, '', 'imagen14.jpg', 4),
(73, 'El Pueblo del Sol', 'Gary Jennings', 0, 0, 23, 0, '', 'imagen15.jpg', 4),
(74, 'El Código Da Vinci', 'Dan Brown', 0, 0, 19, 0, '', 'imagen1.jpg', 6),
(75, 'La Chica del Tren', 'Paula Hawkins', 0, 0, 21, 0, '', 'imagen2.jpg', 6),
(76, 'Los Hombres que no Amaban a las Mujeres', 'Stieg Larsson', 0, 0, 22, 0, '', 'imagen3.jpg', 6),
(77, 'Sherlock Holmes: Estudio en Escarlata', 'Arthur Conan Doyle', 0, 0, 16, 0, '', 'imagen4.jpg', 6),
(78, 'Perdida', 'Gillian Flynn', 0, 0, 20, 0, '', 'imagen5.jpg', 6),
(79, 'El Silencio de los Corderos', 'Thomas Harris', 0, 0, 22, 0, '', 'imagen6.jpg', 6),
(80, 'Asesinato en el Orient Express', 'Agatha Christie', 0, 0, 18, 0, '', 'imagen7.jpg', 6),
(81, 'El Hombre de los Ojos Grises', 'John Verdon', 0, 0, 21, 0, '', 'imagen8.jpg', 6),
(82, 'La Sombra del Viento', 'Carlos Ruiz Zafón', 0, 0, 23, 0, '', 'imagen9.jpg', 6),
(83, 'La Verdad sobre el Caso Harry Quebert', 'Joël Dicker', 0, 0, 25, 0, '', 'imagen10.jpg', 6),
(84, 'El Ladrón de Almas', 'John Connolly', 0, 0, 23, 0, '', 'imagen11.jpg', 6),
(85, 'La Muerte Llama a la Puerta', 'Juan Gómez-Jurado', 0, 0, 21, 0, '', 'imagen12.jpg', 6),
(86, 'Criminales Imprudentes', 'Michael Connelly', 0, 0, 19, 0, '', 'imagen13.jpg', 6),
(87, 'El Secreto del Hombre Muerto', 'Antonio Gómez', 0, 0, 18, 0, '', 'imagen14.jpg', 6),
(88, 'El Último Caso de Hercule Poirot', 'Agatha Christie', 0, 0, 21, 0, '', 'imagen15.jpg', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metododepago`
--

CREATE TABLE `metododepago` (
  `nombreMetodo` varchar(60) NOT NULL,
  `numero` int(11) NOT NULL,
  `idMetodo` int(11) NOT NULL,
  `vencimiento` date NOT NULL,
  `idCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `email` varchar(60) NOT NULL,
  `contraseña` varchar(60) NOT NULL,
  `rol` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Numero` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`email`, `contraseña`, `rol`, `idUsuario`, `Numero`) VALUES
('Test@gmail.com', '2313133122', 1, 1, 'password'),
('email', 'contraseña', 1, 2, '23131331222342342342'),
('tafavereau@gmail.com', '$2y$10$2yTz9VXtYCciqgOf2vPIgucnKTQBecF3wwT3JwYNi1UNVnfjcZTV2', 1, 1235, '23'),
('correo@mueranse.cor', '$2y$10$XZkn7Z7y08OLQ9V6giiku.9v0YIa83/xSihReHW4mCwfrBkw90yeC', 1, 1236, '23'),
('correo@correo.net', '$2y$10$ggk4hJaM48F.SV1p8GX/Q.q9FRsPSlBCO4D1JW69EX0SpeHC5SNce', 1, 1237, '1'),
('correo@correo.com', '$2y$10$u.lic8Q3NuplRWjnqj.e/ONaEnsRhgBjm/12i3q5K5OGCuBktDLNC', 1, 1238, '2'),
('Morit@Maico.com', '$2y$10$BrGicXQ1M0iq52mF4t0.weztM39xO3aY3302kB9tssQWP0HVUSrAe', 1, 1239, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `IDventa` int(11) NOT NULL,
  `IDcliente` int(11) NOT NULL,
  `IDcarrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`idCarrito`),
  ADD KEY `idLibro` (`idLibro`,`idCliente`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`),
  ADD KEY `cliente_ibfk_1` (`idUsuario`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idCompra`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`idDetalleCompra`),
  ADD KEY `idCompra` (`idCompra`),
  ADD KEY `idLibro` (`idLibro`);

--
-- Indices de la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD PRIMARY KEY (`IDfavorito`),
  ADD KEY `favorito_ibfk_2` (`IDlibro`),
  ADD KEY `favorito_ibfk_3` (`IDcliente`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`idLibro`),
  ADD KEY `fk_categoria` (`idCategoria`);

--
-- Indices de la tabla `metododepago`
--
ALTER TABLE `metododepago`
  ADD PRIMARY KEY (`idMetodo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`IDventa`),
  ADD KEY `venta_ibfk_1` (`IDcliente`),
  ADD KEY `venta_ibfk_2` (`IDcarrito`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `idCarrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1228;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idCompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `favorito`
--
ALTER TABLE `favorito`
  MODIFY `IDfavorito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `idLibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `metododepago`
--
ALTER TABLE `metododepago`
  MODIFY `idMetodo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1240;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `IDventa` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`idLibro`) REFERENCES `libro` (`idLibro`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idUsuario`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`idCompra`) REFERENCES `compra` (`idCompra`),
  ADD CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`idLibro`) REFERENCES `libro` (`idLibro`);

--
-- Filtros para la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `favorito_ibfk_1` FOREIGN KEY (`IDcliente`) REFERENCES `cliente` (`idCliente`),
  ADD CONSTRAINT `favorito_ibfk_2` FOREIGN KEY (`IDlibro`) REFERENCES `libro` (`idLibro`),
  ADD CONSTRAINT `favorito_ibfk_3` FOREIGN KEY (`IDcliente`) REFERENCES `cliente` (`idCliente`);

--
-- Filtros para la tabla `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`IDcliente`) REFERENCES `cliente` (`idCliente`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`IDcarrito`) REFERENCES `carrito` (`idCarrito`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
