/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS `gestion-hotel`;
CREATE DATABASE IF NOT EXISTS `gestion-hotel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gestion-hotel`;

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `menus` (`id`, `name`, `description`, `price`, `category`, `image_path`, `is_available`, `created_at`, `updated_at`) VALUES
	(16, 'Salade d\'avocat à la camerounaise', 'Avocat frais avec tomates, oignons et vinaigrette locale', 3500.00, 'Entrées', '/assets/images/macedoine.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(17, 'Beignets de crevettes', 'Beignets croustillants aux crevettes fraîches du littoral', 4500.00, 'Entrées', '/assets/images/fruit.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(18, 'Salade de fruits tropicaux', 'Mangue, papaye, ananas et fruit de la passion', 2500.00, 'Entrées', '/assets/images/fruit.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(19, 'Ndolé au poisson', 'Plat traditionnel aux arachides avec poisson fumé et légumes', 6500.00, 'Plats', '/assets/images/Mbongo.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(20, 'Mbongo Tchobi', 'Ragoût de porc aux épices noires traditionnelles', 7500.00, 'Plats', '/assets/images/Mbongo.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(21, 'Poisson braisé', 'Poisson frais grillé aux épices camerounaises', 5500.00, 'Plats', '/assets/images/chamb.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(22, 'Poulet DG', 'Poulet directeur général aux plantains et légumes', 8000.00, 'Plats', '/assets/images/chamb.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(23, 'Eru', 'Légumes verts traditionnels du Sud-Ouest avec stockfish', 6000.00, 'Plats', '/assets/images/Mbongo.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(24, 'Koki de haricots', 'Gâteau de haricots pilés cuit à la vapeur', 4000.00, 'Plats', '/assets/images/macedoine.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(25, 'Riz sauté camerounais', 'Riz parfumé aux légumes locaux', 2500.00, 'Accompagnements', '/assets/images/images1.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(26, 'Plantains mûrs frits', 'Plantains dorés à la perfection', 2000.00, 'Accompagnements', '/assets/images/images1.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(27, 'Miondo', 'Bâtons de manioc cuits à la vapeur', 1500.00, 'Accompagnements', '/assets/images/images1.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(28, 'Tarte à la noix de coco', 'Tarte crémeuse à la noix de coco fraîche', 3000.00, 'Desserts', '/assets/images/macedoine.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(29, 'Salade de fruits exotiques', 'Mélange de fruits tropicaux de saison', 2500.00, 'Desserts', '/assets/images/fruit.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(30, 'Beignets sucrés', 'Beignets traditionnels saupoudrés de sucre', 2000.00, 'Desserts', '/assets/images/fruit.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(31, 'Jus de bissap', 'Boisson rafraîchissante à l\'hibiscus', 1500.00, 'Boissons', '/assets/images/fruit.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(32, 'Jus de gingembre', 'Jus de gingembre frais épicé', 1500.00, 'Boissons', '/assets/images/fruit.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(33, 'Bière Castel', 'Bière locale camerounaise bien fraîche', 2000.00, 'Boissons', '/assets/images/images1.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(34, '33 Export', 'Bière premium camerounaise', 2500.00, 'Boissons', '/assets/images/images1.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(35, 'Vin de palme', 'Boisson traditionnelle fermentée (non-alcoolisée)', 1800.00, 'Boissons', '/assets/images/fruit.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(36, 'Café arabica local', 'Café des hautes terres de l\'Ouest Cameroun', 1200.00, 'Boissons', '/assets/images/images1.jpg', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  `executed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `num_guests` int NOT NULL,
  `status` enum('pending','confirmed','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `total_price` decimal(10,2) NOT NULL,
  `special_requests` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_dates` (`date_start`,`date_end`),
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `reservation_rooms`;
CREATE TABLE IF NOT EXISTS `reservation_rooms` (
  `reservation_id` int NOT NULL,
  `room_id` int NOT NULL,
  PRIMARY KEY (`reservation_id`,`room_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `reservation_rooms_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservation_rooms_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_available` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`),
  KEY `idx_type` (`type`),
  KEY `idx_capacity` (`capacity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rooms` (`id`, `number`, `type`, `capacity`, `price_per_night`, `description`, `is_available`, `created_at`, `updated_at`) VALUES
	(13, '101', 'Standard', 2, 45000.00, 'Chambre standard climatisée avec vue sur jardin tropical', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(14, '102', 'Standard', 2, 45000.00, 'Chambre standard climatisée avec vue sur jardin tropical', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(15, '103', 'Standard', 2, 45000.00, 'Chambre standard climatisée avec vue sur jardin tropical', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(16, '201', 'Deluxe', 3, 75000.00, 'Chambre deluxe avec balcon et vue sur la ville de Douala', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(17, '202', 'Deluxe', 3, 75000.00, 'Chambre deluxe avec balcon et vue sur la ville de Yaoundé', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(18, '203', 'Deluxe', 3, 75000.00, 'Chambre deluxe avec balcon et climatisation premium', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(19, '301', 'Suite', 4, 125000.00, 'Suite présidentielle avec salon séparé et vue panoramique', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(20, '302', 'Suite', 4, 125000.00, 'Suite royale avec kitchenette et terrasse privée', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(21, '401', 'Suite Présidentielle', 6, 200000.00, 'Suite présidentielle avec service personnalisé 24h/7j', 1, '2025-07-24 17:17:23', '2025-07-24 17:17:23');

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
	(2, 'Administrateur Hôtel', 'admin@hotel-cameroun.com', '$2y$10$.yRAWWkQOYeEfMrtVP3Wney1uHvM.q14oGTJaAtbKwToJswsF2s1.', 'admin', '2025-07-24 17:17:23', '2025-07-24 17:17:23'),
	(3, 'Jean Mballa', 'client@hotel-cameroun.com', '$2y$10$sC/uO1WKBQGwoMIvB9V7XeOLgW6uNprUtRjhIwajOHjhu/FxhL.9K', 'user', '2025-07-24 17:17:23', '2025-07-24 17:17:23');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
