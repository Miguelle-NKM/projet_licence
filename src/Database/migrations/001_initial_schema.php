<?php
namespace App\Database\Migrations;

use PDO;

class InitialSchema {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function up(): void {
        // Table des utilisateurs
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role ENUM('user', 'admin') DEFAULT 'user',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_email (email)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Table des menus
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS menus (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                description TEXT,
                price DECIMAL(10,2) NOT NULL,
                category VARCHAR(50) NOT NULL,
                image_path VARCHAR(255),
                is_available BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_category (category)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Table des réservations
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS reservations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                date_start DATE NOT NULL,
                date_end DATE NOT NULL,
                num_guests INT NOT NULL,
                status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
                total_price DECIMAL(10,2) NOT NULL,
                special_requests TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                INDEX idx_user_id (user_id),
                INDEX idx_dates (date_start, date_end)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Table des chambres
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS rooms (
                id INT AUTO_INCREMENT PRIMARY KEY,
                number VARCHAR(10) NOT NULL UNIQUE,
                type VARCHAR(50) NOT NULL,
                capacity INT NOT NULL,
                price_per_night DECIMAL(10,2) NOT NULL,
                description TEXT,
                is_available BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_type (type),
                INDEX idx_capacity (capacity)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Table de liaison réservations-chambres
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS reservation_rooms (
                reservation_id INT NOT NULL,
                room_id INT NOT NULL,
                PRIMARY KEY (reservation_id, room_id),
                FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
                FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    }

    public function down(): void {
        // Suppression des tables dans l'ordre inverse de leur création
        $this->pdo->exec("DROP TABLE IF EXISTS reservation_rooms;");
        $this->pdo->exec("DROP TABLE IF EXISTS rooms;");
        $this->pdo->exec("DROP TABLE IF EXISTS reservations;");
        $this->pdo->exec("DROP TABLE IF EXISTS menus;");
        $this->pdo->exec("DROP TABLE IF EXISTS users;");
    }
} 