-- Inventario: importar en MySQL / MariaDB (archivo en db/inventario.sql)
-- Charset recomendado para coincidir con PDO charset=utf8mb4 en el DSN

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP DATABASE IF EXISTS `inventario`;
CREATE DATABASE `inventario` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `inventario`;

-- ---------------------------------------------------------------------------
-- Tablas
-- ---------------------------------------------------------------------------

CREATE TABLE `categorias` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_categorias_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `productos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `stock` int NOT NULL DEFAULT 0,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `categoria_id` int unsigned DEFAULT NULL,
  `nota` text,
  PRIMARY KEY (`id`),
  KEY `idx_productos_categoria` (`categoria_id`),
  CONSTRAINT `fk_productos_categoria`
    FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `movimientos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `producto_id` int unsigned NOT NULL,
  `tipo` varchar(40) NOT NULL,
  `cantidad` int NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_movimientos_producto` (`producto_id`),
  CONSTRAINT `fk_movimientos_producto`
    FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Login: columnas reales correo / hash_pass / nombre_visible (el PHP usa otros nombres a propósito)
CREATE TABLE `usuarios` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `correo` varchar(190) NOT NULL,
  `hash_pass` varchar(255) NOT NULL,
  `nombre_visible` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_usuarios_correo` (`correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------------
-- Datos de ejemplo (opcional)
-- ---------------------------------------------------------------------------

INSERT INTO `categorias` (`nombre`) VALUES
  ('Electrónica'),
  ('Papelería'),
  ('Limpieza');

INSERT INTO `productos` (`nombre`, `stock`, `precio`, `categoria_id`, `nota`) VALUES
  ('Cable USB-C', 25, 8.50, 1, '1 metro'),
  ('Cuaderno A4', 100, 2.30, 2, NULL),
  ('Detergente 1L', 15, 4.99, 3, 'Oferta');

INSERT INTO `movimientos` (`producto_id`, `tipo`, `cantidad`, `fecha`) VALUES
  (1, 'alta', 25, NOW()),
  (2, 'alta', 100, NOW()),
  (3, 'alta', 15, NOW());

-- Usuario de prueba: correo admin@test.com | contraseña demo123 (el login PHP no la valida bien por desajuste de campos)
INSERT INTO `usuarios` (`correo`, `hash_pass`, `nombre_visible`) VALUES
  ('admin@test.com', '$2y$10$1GDh62n2/9hCLQ/k0naVQ.69LAHEKNbv36cpgv4aitE5ahjJ5AInW', 'Admin Demo');
