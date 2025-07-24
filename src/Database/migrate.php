<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Services\DatabaseService;
use App\Database\Migrations\InitialSchema;

try {
    // Chargement des variables d'environnement
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
    $dotenv->load();

    // Connexion à la base de données
    $db = DatabaseService::getInstance()->getConnection();

    // Création de la table des migrations si elle n'existe pas
    $db->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            batch INT NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Exécution des migrations
    $migrations = [
        'InitialSchema' => new InitialSchema($db)
    ];

    foreach ($migrations as $name => $migration) {
        // Vérification si la migration a déjà été exécutée
        $stmt = $db->prepare("SELECT id FROM migrations WHERE migration = ?");
        $stmt->execute([$name]);
        
        if (!$stmt->fetch()) {
            // Exécution de la migration
            $migration->up();
            
            // Enregistrement de la migration
            $stmt = $db->prepare("INSERT INTO migrations (migration, batch) VALUES (?, 1)");
            $stmt->execute([$name]);
            
            echo "Migration $name exécutée avec succès.\n";
        } else {
            echo "Migration $name déjà exécutée.\n";
        }
    }

    echo "Toutes les migrations ont été exécutées avec succès.\n";
} catch (Exception $e) {
    echo "Erreur lors de l'exécution des migrations : " . $e->getMessage() . "\n";
    exit(1);
} 