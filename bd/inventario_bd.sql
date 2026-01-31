-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-01-2026 a las 17:58:15
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
-- Base de datos: `inventario_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Hardware', '2026-01-31 04:22:52', '2026-01-31 04:22:52'),
(2, 'Periféricos', '2026-01-31 04:22:52', '2026-01-31 04:22:52'),
(3, 'Software', '2026-01-31 04:22:52', '2026-01-31 04:22:52'),
(4, 'Accesorios', '2026-01-31 04:22:52', '2026-01-31 04:22:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL DEFAULT 'DNI',
  `document_number` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `total_spent` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `customers`
--

INSERT INTO `customers` (`id`, `document_type`, `document_number`, `name`, `phone`, `email`, `points`, `total_spent`, `created_at`, `updated_at`) VALUES
(1, 'DNI', '00000000', 'PÚBLICO GENERAL', NULL, NULL, 0, 0.00, '2026-01-31 04:22:52', '2026-01-31 04:22:52'),
(2, 'DNI', '87654321', 'JHON', '978 768 962', 'admin@tecnosoluciones.com', 532, 42323.00, '2026-01-31 04:27:19', '2026-01-31 05:21:00'),
(3, 'DNI', '12345678', 'ANA MARIA DE LA CRUZ', '978 768 962', 'anamaria@stockmaster.com', 75, 3757.00, '2026-01-31 04:43:26', '2026-01-31 04:56:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `venta_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `venta_id`, `producto_id`, `cantidad`, `precio_unitario`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 320.00, 320.00, '2026-01-31 04:26:55', '2026-01-31 04:26:55'),
(2, 1, 1, 2, 4500.00, 9000.00, '2026-01-31 04:26:55', '2026-01-31 04:26:55'),
(3, 2, 4, 1, 320.00, 320.00, '2026-01-31 04:27:28', '2026-01-31 04:27:28'),
(4, 3, 4, 5, 320.00, 1600.00, '2026-01-31 04:36:11', '2026-01-31 04:36:11'),
(5, 3, 1, 7, 4500.00, 31500.00, '2026-01-31 04:36:11', '2026-01-31 04:36:11'),
(6, 3, 5, 4, 1000.00, 4000.00, '2026-01-31 04:36:11', '2026-01-31 04:36:11'),
(7, 3, 2, 1, 120.00, 120.00, '2026-01-31 04:36:11', '2026-01-31 04:36:11'),
(8, 5, 4, 1, 320.00, 320.00, '2026-01-31 04:43:28', '2026-01-31 04:43:28'),
(9, 5, 5, 3, 1000.00, 3000.00, '2026-01-31 04:43:28', '2026-01-31 04:43:28'),
(10, 5, 2, 1, 120.00, 120.00, '2026-01-31 04:43:28', '2026-01-31 04:43:28'),
(11, 6, 4, 1, 320.00, 320.00, '2026-01-31 04:53:09', '2026-01-31 04:53:09'),
(12, 7, 4, 1, 320.00, 320.00, '2026-01-31 04:55:45', '2026-01-31 04:55:45'),
(13, 8, 5, 1, 1000.00, 1000.00, '2026-01-31 05:20:40', '2026-01-31 05:20:40'),
(14, 8, 2, 1, 120.00, 120.00, '2026-01-31 05:20:40', '2026-01-31 05:20:40'),
(15, 9, 1, 1, 4500.00, 4500.00, '2026-01-31 05:21:00', '2026-01-31 05:21:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_10_000010_create_customers_table', 1),
(6, '2026_01_10_001002_create_categorias_table', 1),
(7, '2026_01_10_005856_create_proveedores_table', 1),
(8, '2026_01_10_051151_create_productos_table', 1),
(9, '2026_01_27_000151_create_movimientos_table', 1),
(10, '2026_01_27_093748_create_ventas_table', 1),
(11, '2026_01_29_013821_create_settings_table', 1),
(12, '2026_01_31_110606_add_default_value_to_settings_table', 2),
(13, '2026_01_31_115153_add_extra_fields_to_users_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED DEFAULT NULL,
  `producto_nombre` varchar(255) DEFAULT NULL,
  `cantidad` decimal(12,2) NOT NULL DEFAULT 0.00,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `proveedor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proveedor_name` varchar(255) DEFAULT NULL,
  `categoria_id` bigint(20) UNSIGNED DEFAULT NULL,
  `categoria_name` varchar(255) DEFAULT NULL,
  `accion` varchar(255) NOT NULL,
  `detalle` varchar(255) DEFAULT NULL,
  `color_badge` varchar(255) NOT NULL DEFAULT 'blue',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `user_id`, `producto_id`, `producto_nombre`, `cantidad`, `customer_id`, `customer_name`, `proveedor_id`, `proveedor_name`, `categoria_id`, `categoria_name`, `accion`, `detalle`, `color_badge`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 0.00, NULL, NULL, 1, 'Proveedor ABC', NULL, NULL, 'NUEVO_PROVEEDOR', 'Nuevo proveedor registrado: **Proveedor ABC** (RUC/Doc: ).', 'bg-blue-600', '2026-01-31 04:22:52', '2026-01-31 04:22:52'),
(2, 1, NULL, NULL, 0.00, NULL, NULL, 2, 'Proveedor XYZ', NULL, NULL, 'NUEVO_PROVEEDOR', 'Nuevo proveedor registrado: **Proveedor XYZ** (RUC/Doc: ).', 'bg-blue-600', '2026-01-31 04:22:52', '2026-01-31 04:22:52'),
(3, 1, NULL, NULL, 0.00, NULL, NULL, 3, 'Proveedor Demo', NULL, NULL, 'NUEVO_PROVEEDOR', 'Nuevo proveedor registrado: **Proveedor Demo** (RUC/Doc: ).', 'bg-blue-600', '2026-01-31 04:22:52', '2026-01-31 04:22:52'),
(4, 1, 4, 'Auriculares Gamer', 1.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D848F9039C', 'indigo', '2026-01-31 04:26:55', '2026-01-31 04:26:55'),
(5, 1, 1, 'Laptop Gamer', 2.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D848F9039C', 'indigo', '2026-01-31 04:26:55', '2026-01-31 04:26:55'),
(6, 1, NULL, NULL, 0.00, 2, 'JHON', NULL, NULL, NULL, NULL, 'NUEVO_CLIENTE', 'Se registró un nuevo cliente: **JHON** con Documento: 87654321.', 'bg-emerald-500', '2026-01-31 04:27:19', '2026-01-31 04:27:19'),
(7, 1, 4, 'Auriculares Gamer', 1.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D84B0E70CF', 'indigo', '2026-01-31 04:27:28', '2026-01-31 04:27:28'),
(8, 1, 4, 'Auriculares Gamer', 5.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D86BBDE06F', 'indigo', '2026-01-31 04:36:11', '2026-01-31 04:36:11'),
(9, 1, 1, 'Laptop Gamer', 7.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D86BBDE06F', 'indigo', '2026-01-31 04:36:11', '2026-01-31 04:36:11'),
(10, 1, 5, 'Monitor 24 pulgadas', 4.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D86BBDE06F', 'indigo', '2026-01-31 04:36:11', '2026-01-31 04:36:11'),
(11, 1, 2, 'Mouse Inalámbrico', 1.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D86BBDE06F', 'indigo', '2026-01-31 04:36:11', '2026-01-31 04:36:11'),
(12, 1, NULL, NULL, 0.00, 3, 'ANA MARIA DE LA CRUZ', NULL, NULL, NULL, NULL, 'NUEVO_CLIENTE', 'Se registró un nuevo cliente: **ANA MARIA DE LA CRUZ** con Documento: 12345678.', 'bg-emerald-500', '2026-01-31 04:43:26', '2026-01-31 04:43:26'),
(13, 1, 4, 'Auriculares Gamer', 1.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D8870908A5', 'indigo', '2026-01-31 04:43:28', '2026-01-31 04:43:28'),
(14, 1, 5, 'Monitor 24 pulgadas', 3.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D8870908A5', 'indigo', '2026-01-31 04:43:28', '2026-01-31 04:43:28'),
(15, 1, 2, 'Mouse Inalámbrico', 1.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D8870908A5', 'indigo', '2026-01-31 04:43:28', '2026-01-31 04:43:28'),
(16, 1, 4, 'Auriculares Gamer', 1.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D8AB50123E', 'indigo', '2026-01-31 04:53:09', '2026-01-31 04:53:09'),
(17, 1, 4, 'Auriculares Gamer', 1.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D8B510E753', 'indigo', '2026-01-31 04:55:45', '2026-01-31 04:55:45'),
(18, 1, NULL, NULL, 0.00, 3, 'ANA MARIA DE LA CRUZ', NULL, NULL, NULL, NULL, 'ACTUALIZACIÓN', 'Se actualizaron datos generales del cliente: ANA MARIA DE LA CRUZ.', 'bg-blue-500', '2026-01-31 04:56:47', '2026-01-31 04:56:47'),
(19, 1, 5, 'Monitor 24 pulgadas', 1.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D91285ECC9', 'indigo', '2026-01-31 05:20:40', '2026-01-31 05:20:40'),
(20, 1, 2, 'Mouse Inalámbrico', 1.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D91285ECC9', 'indigo', '2026-01-31 05:20:40', '2026-01-31 05:20:40'),
(21, 1, 1, 'Laptop Gamer', 1.00, NULL, NULL, NULL, NULL, NULL, NULL, 'VENTA', 'VENTA #V-697D913C19B67', 'indigo', '2026-01-31 05:21:00', '2026-01-31 05:21:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `proveedor_id` bigint(20) UNSIGNED NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `stock_actual` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `descripcion`, `imagen`, `categoria_id`, `proveedor_id`, `precio_compra`, `precio_venta`, `stock_actual`, `stock_minimo`, `created_at`, `updated_at`) VALUES
(1, 'LAP-G01', 'Laptop Gamer', 'Laptop potente para juegos con tarjeta gráfica dedicada.', 'productos/laptop_gamer.jpg', 1, 1, 3800.00, 4500.00, 0, 3, '2026-01-31 04:22:52', '2026-01-31 05:21:00'),
(2, 'MOU-W02', 'Mouse Inalámbrico', 'Mouse ergonómico sin cables, ideal para oficina y gaming.', 'productos/mouse.jpg', 2, 2, 80.00, 120.00, 47, 10, '2026-01-31 04:22:52', '2026-01-31 05:20:40'),
(3, 'TEC-M03', 'Teclado Mecánico', 'Teclado mecánico con retroiluminación RGB.', 'productos/teclado.jpg', 2, 2, 210.00, 300.00, 2, 5, '2026-01-31 04:22:52', '2026-01-31 04:22:52'),
(4, 'AUR-M01', 'Auriculares Gamer', 'Auriculares con micrófono y sonido envolvente 7.1.', 'productos/auriculares.jpg', 2, 2, 250.00, 320.00, 0, 5, '2026-01-31 04:22:52', '2026-01-31 04:55:45'),
(5, 'MON-M01', 'Monitor 24 pulgadas', 'Monitor Full HD, ideal para juegos y trabajo.', 'productos/auriculares.jpg', 1, 1, 800.00, 1000.00, 4, 5, '2026-01-31 04:22:52', '2026-01-31 05:20:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `email`, `telefono`, `direccion`, `created_at`, `updated_at`) VALUES
(1, 'Proveedor ABC', 'abc@proveedores.com', '987654321', 'Av. Principal 123', '2026-01-31 04:22:52', '2026-01-31 04:22:52'),
(2, 'Proveedor XYZ', 'xyz@proveedores.com', '912345678', 'Calle Secundaria 456', '2026-01-31 04:22:52', '2026-01-31 04:22:52'),
(3, 'Proveedor Demo', 'demo@proveedores.com', '900123456', 'Av. Demo 789', '2026-01-31 04:22:52', '2026-01-31 04:22:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `default_value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `type` varchar(255) NOT NULL DEFAULT 'string',
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `default_value`, `group`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'store_name', 'STOCK MASTER POS', 'STOCK MASTER POS', 'empresa', 'string', 'Nombre comercial de la tienda', '2026-01-31 04:22:51', '2026-01-31 16:13:38'),
(2, 'store_ruc', '20123456789', '20123456789', 'empresa', 'string', 'Número de RUC de la empresa', '2026-01-31 04:22:51', '2026-01-31 04:22:51'),
(3, 'store_address', 'Jr. Libertad 123, Ayacucho', 'Jr. Libertad 123, Ayacucho', 'empresa', 'string', 'Dirección física del establecimiento', '2026-01-31 04:22:51', '2026-01-31 04:22:51'),
(4, 'store_phone', '966123456', '966123456', 'empresa', 'string', 'Teléfono o WhatsApp de contacto', '2026-01-31 04:22:51', '2026-01-31 04:22:51'),
(5, 'store_email', 'ventas@stockmaster.com', 'ventas@stockmaster.com', 'empresa', 'string', 'Email de contacto', '2026-01-31 04:22:51', '2026-01-31 04:22:51'),
(6, 'puntos_factor_ganancia', '10', '10', 'fidelizacion', 'number', 'Soles necesarios para ganar 1 punto (Ej: S/ 10 = 1 pto)', '2026-01-31 04:22:51', '2026-01-31 04:22:51'),
(7, 'puntos_equivalencia', '100', '100', 'fidelizacion', 'number', 'Cuántos puntos equivalen a S/ 1.00 de descuento', '2026-01-31 04:22:51', '2026-01-31 04:22:51'),
(8, 'puntos_minimo_canje', '50', '50', 'fidelizacion', 'number', 'Mínimo de puntos acumulados para permitir un canje', '2026-01-31 04:22:51', '2026-01-31 04:22:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'vendedor',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `password`, `role`, `is_active`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Quispe Perez Jhon B.', NULL, 'admin@stockmaster.com', NULL, NULL, '$2y$12$zwUVbUq3RvHu1yrQfrru5uUmzRyoa3QN1C7pM98px/u8p2Zj.f39W', 'vendedor', 1, NULL, NULL, '2026-01-31 04:22:52', '2026-01-31 04:26:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo_factura` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `puntos_canjeados` int(11) NOT NULL DEFAULT 0,
  `impuesto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `metodo_pago` varchar(255) NOT NULL DEFAULT 'efectivo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `codigo_factura`, `user_id`, `customer_id`, `total`, `descuento`, `puntos_canjeados`, `impuesto`, `metodo_pago`, `created_at`, `updated_at`) VALUES
(1, 'V-697D848F9039C', 1, 1, 9320.00, 0.00, 0, 0.00, 'efectivo', '2026-01-31 04:26:55', '2026-01-31 04:26:55'),
(2, 'V-697D84B0E70CF', 1, 2, 320.00, 0.00, 0, 0.00, 'efectivo', '2026-01-31 04:27:28', '2026-01-31 04:27:28'),
(3, 'V-697D86BBDE06F', 1, 2, 37220.00, 0.00, 0, 0.00, 'efectivo', '2026-01-31 04:36:11', '2026-01-31 04:36:11'),
(5, 'V-697D8870908A5', 1, 3, 3440.00, 0.00, 0, 0.00, 'efectivo', '2026-01-31 04:43:28', '2026-01-31 04:43:28'),
(6, 'V-697D8AB50123E', 1, 2, 283.00, 37.00, 3700, 0.00, 'efectivo', '2026-01-31 04:53:09', '2026-01-31 04:53:09'),
(7, 'V-697D8B510E753', 1, 3, 317.00, 3.00, 300, 0.00, 'efectivo', '2026-01-31 04:55:45', '2026-01-31 04:55:45'),
(8, 'V-697D91285ECC9', 1, 1, 1120.00, 0.00, 0, 0.00, 'efectivo', '2026-01-31 05:20:40', '2026-01-31 05:20:40'),
(9, 'V-697D913C19B67', 1, 2, 4500.00, 0.00, 0, 0.00, 'efectivo', '2026-01-31 05:21:00', '2026-01-31 05:21:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_document_number_unique` (`document_number`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ventas_venta_id_foreign` (`venta_id`),
  ADD KEY `detalle_ventas_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movimientos_user_id_foreign` (`user_id`),
  ADD KEY `movimientos_producto_id_foreign` (`producto_id`),
  ADD KEY `movimientos_customer_id_foreign` (`customer_id`),
  ADD KEY `movimientos_proveedor_id_foreign` (`proveedor_id`),
  ADD KEY `movimientos_categoria_id_foreign` (`categoria_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productos_codigo_unique` (`codigo`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`),
  ADD KEY `productos_proveedor_id_foreign` (`proveedor_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ventas_codigo_factura_unique` (`codigo_factura`),
  ADD KEY `ventas_user_id_foreign` (`user_id`),
  ADD KEY `ventas_customer_id_foreign` (`customer_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `detalle_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movimientos_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movimientos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movimientos_proveedor_id_foreign` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movimientos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_proveedor_id_foreign` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ventas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
