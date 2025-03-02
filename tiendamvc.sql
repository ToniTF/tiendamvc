-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 02-03-2025 a las 20:07:43
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tiendamvc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `address_id` int NOT NULL AUTO_INCREMENT,
  `street` varchar(255) DEFAULT NULL,
  `zip_code` int DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `provider_id` int DEFAULT NULL,
  PRIMARY KEY (`address_id`),
  KEY `fk_address_customer_idx` (`customer_id`),
  KEY `fk_address_provider1_idx` (`provider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `address`
--

INSERT INTO `address` (`address_id`, `street`, `zip_code`, `city`, `country`, `created_at`, `updated_at`, `customer_id`, `provider_id`) VALUES
(1, 'Calle Alcalá 123', 28014, 'Madrid', 'España', '2025-03-02 19:38:44', '2025-03-02 19:38:44', 1, NULL),
(2, 'Avenida Paulista 456', 380, 'São Paulo', 'Brasil', '2025-03-02 19:38:44', '2025-03-02 19:38:44', 2, NULL),
(3, 'Calle Corrientes 789', 1043, 'Buenos Aires', 'Argentina', '2025-03-02 19:38:44', '2025-03-02 19:38:44', 3, NULL),
(4, 'Avenida Reforma 012', 1010, 'Ciudad de México', 'México', '2025-03-02 19:38:44', '2025-03-02 19:38:44', 4, NULL),
(5, 'Calle Florida 345', 1005, 'Montevideo', 'Uruguay', '2025-03-02 19:38:44', '2025-03-02 19:38:44', 5, NULL),
(6, 'Calle Industrial 10', 8005, 'Barcelona', 'España', '2025-03-02 19:38:44', '2025-03-02 19:38:44', NULL, 1),
(7, 'Avenida Comercial 20', 11000, 'Cádiz', 'España', '2025-03-02 19:38:44', '2025-03-02 19:38:44', NULL, 2),
(8, 'Calle Mayor 30', 29001, 'Málaga', 'España', '2025-03-02 19:38:44', '2025-03-02 19:38:44', NULL, 3),
(9, 'Avenida del Puerto 40', 46001, 'Valencia', 'España', '2025-03-02 19:38:44', '2025-03-02 19:38:44', NULL, 4),
(10, 'Calle de la Fábrica 50', 48001, 'Bilbao', 'España', '2025-03-02 19:38:44', '2025-03-02 19:38:44', NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`category_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Electrónicos', 'Productos electrónicos', '2025-03-02 19:37:28', '2025-03-02 19:37:28'),
(2, 'Ropa', 'Prendas de vestir', '2025-03-02 19:37:28', '2025-03-02 19:37:28'),
(3, 'Libros', 'Libros de diferentes géneros', '2025-03-02 19:37:28', '2025-03-02 19:37:28'),
(4, 'Hogar', 'Artículos para el hogar', '2025-03-02 19:37:28', '2025-03-02 19:37:28'),
(5, 'Deportes', 'Equipamiento deportivo', '2025-03-02 19:37:28', '2025-03-02 19:37:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Juan Gabriel', '2025-03-02 19:36:50', '2025-03-02 19:36:50'),
(2, 'Felipe González', '2025-03-02 19:36:50', '2025-03-02 19:36:50'),
(3, 'Marisol Gutiérrez', '2025-03-02 19:36:50', '2025-03-02 19:36:50'),
(4, 'Julio Iglesias', '2025-03-02 19:36:50', '2025-03-02 19:36:50'),
(5, 'Isabel Pantoja', '2025-03-02 19:36:50', '2025-03-02 19:36:50'),
(6, 'Rafael Hernández', '2025-03-02 19:36:50', '2025-03-02 19:36:50'),
(7, 'Eugenia Martín', '2025-03-02 19:36:50', '2025-03-02 19:36:50'),
(8, 'Nuria Casal', '2025-03-02 19:36:50', '2025-03-02 19:36:50'),
(9, 'Jorge Enrique Vizcaya', '2025-03-02 19:36:50', '2025-03-02 19:36:50'),
(10, 'Rubén Sans', '2025-03-02 19:36:50', '2025-03-02 19:36:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `customer_id` int NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_order_customer1_idx` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `order`
--

INSERT INTO `order` (`order_id`, `date`, `discount`, `updated_at`, `created_at`, `customer_id`) VALUES
(1, '2025-03-02 00:00:00', 5.00, '2025-03-02 19:01:11', '2025-03-02 19:01:11', 3),
(2, '2025-03-02 00:00:00', 15.00, '2025-03-02 19:04:37', '2025-03-02 19:02:18', 8),
(3, '2025-03-02 00:00:00', 25.00, '2025-03-02 19:04:56', '2025-03-02 19:04:56', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_has_product`
--

DROP TABLE IF EXISTS `order_has_product`;
CREATE TABLE IF NOT EXISTS `order_has_product` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `fk_order_has_product_product1_idx` (`product_id`),
  KEY `fk_order_has_product_order1_idx` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `order_has_product`
--

INSERT INTO `order_has_product` (`order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 25.00, '2025-03-02 19:01:12', '2025-03-02 19:01:12'),
(1, 3, 1, 15.00, '2025-03-02 19:01:11', '2025-03-02 19:01:11'),
(1, 13, 1, 22.00, '2025-03-02 19:01:12', '2025-03-02 19:01:12'),
(2, 1, 1, 1200.00, '2025-03-02 19:04:37', '2025-03-02 19:04:37'),
(2, 6, 1, 800.00, '2025-03-02 19:04:37', '2025-03-02 19:04:37'),
(2, 11, 1, 300.00, '2025-03-02 19:04:37', '2025-03-02 19:04:37'),
(3, 5, 1, 20.00, '2025-03-02 19:04:56', '2025-03-02 19:04:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phone`
--

DROP TABLE IF EXISTS `phone`;
CREATE TABLE IF NOT EXISTS `phone` (
  `phone_id` int NOT NULL AUTO_INCREMENT,
  `number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `provider_id` int DEFAULT NULL,
  PRIMARY KEY (`phone_id`),
  KEY `fk_phone_customer1_idx` (`customer_id`),
  KEY `fk_phone_provider1_idx` (`provider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `phone`
--

INSERT INTO `phone` (`phone_id`, `number`, `created_at`, `updated_at`, `customer_id`, `provider_id`) VALUES
(1, '123-456-7890', '2025-03-02 19:38:00', '2025-03-02 19:38:00', 1, NULL),
(2, '987-654-3210', '2025-03-02 19:38:00', '2025-03-02 19:38:00', 2, NULL),
(3, '555-123-4567', '2025-03-02 19:38:00', '2025-03-02 19:38:00', 3, NULL),
(4, '111-222-3333', '2025-03-02 19:38:00', '2025-03-02 19:38:00', 4, NULL),
(5, '444-555-6666', '2025-03-02 19:38:00', '2025-03-02 19:38:00', 5, NULL),
(6, '999-888-7777', '2025-03-02 19:38:00', '2025-03-02 19:38:00', NULL, 1),
(7, '666-777-8888', '2025-03-02 19:38:00', '2025-03-02 19:38:00', NULL, 2),
(8, '333-444-5555', '2025-03-02 19:38:00', '2025-03-02 19:38:00', NULL, 3),
(9, '777-999-1111', '2025-03-02 19:38:00', '2025-03-02 19:38:00', NULL, 4),
(10, '222-333-4444', '2025-03-02 19:38:00', '2025-03-02 19:38:00', NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` int NOT NULL,
  `provider_id` int NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_product_category1_idx` (`category_id`),
  KEY `fk_product_provider1_idx` (`provider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`product_id`, `name`, `description`, `img`, `stock`, `price`, `created_at`, `updated_at`, `category_id`, `provider_id`) VALUES
(1, 'Laptop X', 'Laptop de alta gama', 'laptop_x.jpg', 10, 1200.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 1, 1),
(2, 'Camiseta Y', 'Camiseta de algodón', 'camiseta_y.jpg', 50, 25.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 2, 2),
(3, 'Libro Z', 'Novela de ciencia ficción', 'libro_z.jpg', 20, 15.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 3, 3),
(4, 'Lámpara A', 'Lámpara de mesa', 'lampara_a.jpg', 30, 30.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 4, 4),
(5, 'Balón B', 'Balón de fútbol', 'balon_b.jpg', 40, 20.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 5, 5),
(6, 'Smartphone C', 'Teléfono inteligente', 'smartphone_c.jpg', 15, 800.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 1, 6),
(7, 'Pantalón D', 'Pantalón vaquero', 'pantalon_d.jpg', 25, 40.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 2, 7),
(8, 'Libro E', 'Libro de historia', 'libro_e.jpg', 10, 18.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 3, 8),
(9, 'Silla F', 'Silla de oficina', 'silla_f.jpg', 12, 50.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 4, 9),
(10, 'Raqueta G', 'Raqueta de tenis', 'raqueta_g.jpg', 18, 60.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 5, 10),
(11, 'Tablet H', 'Tableta electrónica', 'tablet_h.jpg', 8, 300.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 1, 1),
(12, 'Vestido I', 'Vestido de fiesta', 'vestido_i.jpg', 22, 75.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 2, 2),
(13, 'Libro J', 'Libro de cocina', 'libro_j.jpg', 14, 22.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 3, 3),
(14, 'Mesa K', 'Mesa de centro', 'mesa_k.jpg', 9, 90.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 4, 4),
(15, 'Bicicleta L', 'Bicicleta de montaña', 'bicicleta_l.jpg', 5, 250.00, '2025-03-02 19:37:41', '2025-03-02 19:37:41', 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provider`
--

DROP TABLE IF EXISTS `provider`;
CREATE TABLE IF NOT EXISTS `provider` (
  `provider_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`provider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `provider`
--

INSERT INTO `provider` (`provider_id`, `name`, `web`, `created_at`, `updated_at`) VALUES
(1, 'Proveedor Alfa', 'www.alfa.com', '2025-03-02 19:37:16', '2025-03-02 19:37:16'),
(2, 'Proveedor Beta', 'www.beta.com', '2025-03-02 19:37:16', '2025-03-02 19:37:16'),
(3, 'Proveedor Gamma', 'www.gamma.com', '2025-03-02 19:37:16', '2025-03-02 19:37:16'),
(4, 'Proveedor Delta', 'www.delta.com', '2025-03-02 19:37:16', '2025-03-02 19:37:16'),
(5, 'Proveedor Epsilon', 'www.epsilon.com', '2025-03-02 19:37:16', '2025-03-02 19:37:16'),
(6, 'Proveedor Zeta', 'www.zeta.com', '2025-03-02 19:37:16', '2025-03-02 19:37:16'),
(7, 'Proveedor Eta', 'www.eta.com', '2025-03-02 19:37:16', '2025-03-02 19:37:16'),
(8, 'Proveedor Theta', 'www.theta.com', '2025-03-02 19:37:16', '2025-03-02 19:37:16'),
(9, 'Proveedor Iota', 'www.iota.com', '2025-03-02 19:37:16', '2025-03-02 19:37:16'),
(10, 'Proveedor Kappa', 'www.kappa.com', '2025-03-02 19:37:16', '2025-03-02 19:37:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'pepe', '$2y$10$B6YsvS9cCVNNyvJjtDDXIe5UKbocqOwIgHO2Nx23W8lMMnSFUAYha', '2025-02-24 17:10:05', '2025-02-24 17:10:05'),
(2, 'admin', '$2y$10$ZmTxiQiAzqWIEpYvf3/gGeLT4tg6w8A2lHe2c8jJvaKUIiCns3CZ.', '2025-03-02 18:40:47', '2025-03-02 18:40:47');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_address_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `fk_address_provider1` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`provider_id`);

--
-- Filtros para la tabla `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Filtros para la tabla `order_has_product`
--
ALTER TABLE `order_has_product`
  ADD CONSTRAINT `fk_order_has_product_order1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
  ADD CONSTRAINT `fk_order_has_product_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Filtros para la tabla `phone`
--
ALTER TABLE `phone`
  ADD CONSTRAINT `fk_phone_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `fk_phone_provider1` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`provider_id`);

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `fk_product_provider1` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`provider_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
