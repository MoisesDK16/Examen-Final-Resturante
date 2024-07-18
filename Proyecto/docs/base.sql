-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-07-2024 a las 23:33:31
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestionrestaurante`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizarDetalleOrden` (IN `p_detalle_id` INT, IN `p_cantidad` INT)   BEGIN
    DECLARE suma_total DECIMAL(10, 2);
    DECLARE menu_precio_v DECIMAL(10, 2);
    DECLARE orden_id_v INT;

    -- SELECCIÓN DEL PRECIO DEL MENÚ Y EL ORDEN_ID
    SELECT m.precio, do.orden_id 
    INTO menu_precio_v, orden_id_v
    FROM detalle_ordenes AS do
    INNER JOIN menus AS m ON m.menu_id = do.menu_id
    WHERE do.detalle_id = p_detalle_id;

    -- ACTUALIZAR EL DETALLE
    UPDATE detalle_ordenes 
    SET cantidad = p_cantidad,
        subtotal = p_cantidad * menu_precio_v
    WHERE detalle_id = p_detalle_id;

    -- SELECCIÓN DE LA SUMATORIA DE LOS DETALLES DE UNA ORDEN EN ESPECÍFICO
    SELECT SUM(subtotal) 
    INTO suma_total
    FROM detalle_ordenes 
    WHERE orden_id = orden_id_v;

    -- ACTUALIZACIÓN DEL CAMPO TOTAL EN LA TABLA ORDENES
    UPDATE ordenes 
    SET total = suma_total 
    WHERE orden_id = orden_id_v;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminarDetalleOrden` (IN `p_detalle_id` INT)   BEGIN
    DECLARE p_orden_id INT;
    DECLARE suma_total DECIMAL(10,2);

    -- Obtener el orden_id del detalle a eliminar
    SELECT orden_id INTO p_orden_id
    FROM detalle_ordenes
    WHERE detalle_id = p_detalle_id;

    -- Eliminar el detalle
    DELETE FROM detalle_ordenes
    WHERE detalle_id = p_detalle_id;

    -- Calcular la nueva suma total de los detalles de la orden
    SELECT SUM(subtotal) INTO suma_total
    FROM detalle_ordenes
    WHERE orden_id = p_orden_id;

    -- Actualizar el total de la orden
    UPDATE ordenes
    SET total = COALESCE(suma_total, 0)
    WHERE orden_id = p_orden_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarDetalleOrden` (IN `p_orden_id` INT, IN `p_nombre_menu` VARCHAR(255), IN `p_cantidad` INT)   BEGIN
    DECLARE suma_total DECIMAL(10, 2);
    DECLARE v_menu_id INT;
    DECLARE v_menu_precio DECIMAL(10, 2);

    -- Obtener el ID del menú y el precio
    SELECT menu_id, precio INTO v_menu_id, v_menu_precio
    FROM menus
    WHERE nombre = p_nombre_menu;

    -- Verificar si el v_menu_id es nulo
    IF v_menu_id IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El menú especificado no existe';
    ELSE
        -- Verificar si el menú ya existe en la orden
        IF EXISTS (SELECT 1 FROM detalle_ordenes WHERE orden_id = p_orden_id AND menu_id = v_menu_id) THEN
            -- Actualizar la cantidad y el subtotal del detalle existente
            UPDATE detalle_ordenes
            SET cantidad = cantidad + p_cantidad,
                subtotal = cantidad * v_menu_precio
            WHERE orden_id = p_orden_id AND menu_id = v_menu_id;
        ELSE
            -- Inserción de nuevo detalle
            INSERT INTO detalle_ordenes (orden_id, menu_id, cantidad, subtotal) 
            VALUES (
                p_orden_id, 
                v_menu_id, 
                p_cantidad, 
                p_cantidad * v_menu_precio
            );
        END IF;

        -- Selección de la sumatoria de los detalles de una orden en específico
        SELECT SUM(d.subtotal) 
        INTO suma_total
        FROM detalle_ordenes d
        WHERE d.orden_id = p_orden_id;

        -- Actualización del campo total en la tabla ordenes
        UPDATE ordenes 
        SET total = suma_total 
        WHERE orden_id = p_orden_id;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`, `email`, `telefono`) VALUES
('223244343', 'Moises', 'Loor', 'moisesloor11@gmail.com', '091989231'),
('231910234', 'Diego', 'Zambrano', 'diegozambrano32@gmail.com', '08919283'),
('232342', 'Miguel', 'Ramirez', 'miguel31@gmail.com', '6565657887'),
('2371919234', 'Luis ', 'Llerena', 'luisllerena23@gmail.com', '06775767'),
('732231', 'Manuel', 'Gonzales', 'manuel34@gmail.com', '0182823');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ordenes`
--

CREATE TABLE `detalle_ordenes` (
  `detalle_id` int(11) NOT NULL,
  `orden_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ordenes`
--

INSERT INTO `detalle_ordenes` (`detalle_id`, `orden_id`, `menu_id`, `cantidad`, `subtotal`) VALUES
(1, 1, 1, 3, 18.00),
(2, 1, 9, 2, 40.00),
(13, 16, 14, 1, 10.00),
(14, 16, 2, 1, 6.00),
(18, 16, 15, 2, 8.00),
(22, 18, 9, 2, 40.00),
(25, 19, 1, 2, 12.00),
(27, 19, 2, 2, 12.00),
(28, 19, 9, 1, 20.00),
(29, 16, 9, 2, 40.00),
(31, 1, 2, 6, 36.00),
(36, 21, 1, 2, 12.00),
(37, 21, 2, 2, 12.00),
(38, 1, 17, 1, 7.00),
(39, 22, 17, 2, 14.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`menu_id`, `nombre`, `descripcion`, `precio`, `disponible`) VALUES
(1, 'Arroz con pollo', 'dfggdfgfdgfdgfdgdf', 6.00, 1),
(2, 'Ensalada de Pepino', 'Descripción actualizada de Ensalada de Pepino', 6.00, 1),
(5, 'Ceviche de Pollo', 'dfghhgfhfghfg', 5.00, 0),
(9, 'Ensalada de tomate', 'Descripción del menú especial', 20.00, 1),
(14, 'Ceviche de pescado', 'zzzzzzzz', 10.00, 1),
(15, 'Corvina', 'gfdgdfgdfgfdgfd', 4.00, 0),
(17, 'Guatita de Camaron', 'jhgjjghjhjhj', 7.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `orden_id` int(11) NOT NULL,
  `cliente_id` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`orden_id`, `cliente_id`, `fecha`, `total`) VALUES
(1, '223244343', '2024-07-17 21:39:00', 101.00),
(16, '231910234', '2024-07-17 22:20:10', 64.00),
(18, '732231', '2024-07-18 07:57:05', 40.00),
(19, '232342', '2024-07-18 09:42:44', 44.00),
(21, '732231', '2024-07-18 10:45:18', 24.00),
(22, '2371919234', '2024-07-18 16:28:38', 14.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `detalle_ordenes`
--
ALTER TABLE `detalle_ordenes`
  ADD PRIMARY KEY (`detalle_id`),
  ADD KEY `orden_id` (`orden_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`orden_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_ordenes`
--
ALTER TABLE `detalle_ordenes`
  MODIFY `detalle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `orden_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ordenes`
--
ALTER TABLE `detalle_ordenes`
  ADD CONSTRAINT `detalle_ordenes_ibfk_1` FOREIGN KEY (`orden_id`) REFERENCES `ordenes` (`orden_id`),
  ADD CONSTRAINT `detalle_ordenes_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`menu_id`);

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
