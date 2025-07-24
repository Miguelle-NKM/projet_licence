<?php
require_once 'vendor/autoload.php';

use App\Services\DatabaseService;

try {
    echo "🌱 Début du seeding de la base de données...\n";

    $db = DatabaseService::getInstance()->getConnection();

    // Créer un utilisateur admin
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT IGNORE INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Administrateur Hôtel', 'admin@hotel-cameroun.com', $adminPassword, 'admin']);
    echo "✅ Utilisateur admin créé (email: admin@hotel-cameroun.com, mot de passe: admin123)\n";

    // Créer un utilisateur normal
    $userPassword = password_hash('user123', PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT IGNORE INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Jean Mballa', 'client@hotel-cameroun.com', $userPassword, 'user']);
    echo "✅ Utilisateur client créé (email: client@hotel-cameroun.com, mot de passe: user123)\n";

    // Créer quelques chambres avec prix en FCFA
    $rooms = [
        ['101', 'Standard', 2, 45000.00, 'Chambre standard climatisée avec vue sur jardin tropical'],
        ['102', 'Standard', 2, 45000.00, 'Chambre standard climatisée avec vue sur jardin tropical'],
        ['103', 'Standard', 2, 45000.00, 'Chambre standard climatisée avec vue sur jardin tropical'],
        ['201', 'Deluxe', 3, 75000.00, 'Chambre deluxe avec balcon et vue sur la ville de Douala'],
        ['202', 'Deluxe', 3, 75000.00, 'Chambre deluxe avec balcon et vue sur la ville de Yaoundé'],
        ['203', 'Deluxe', 3, 75000.00, 'Chambre deluxe avec balcon et climatisation premium'],
        ['301', 'Suite', 4, 125000.00, 'Suite présidentielle avec salon séparé et vue panoramique'],
        ['302', 'Suite', 4, 125000.00, 'Suite royale avec kitchenette et terrasse privée'],
        ['401', 'Suite Présidentielle', 6, 200000.00, 'Suite présidentielle avec service personnalisé 24h/7j']
    ];

    $stmt = $db->prepare("INSERT IGNORE INTO rooms (number, type, capacity, price_per_night, description) VALUES (?, ?, ?, ?, ?)");
    foreach ($rooms as $room) {
        $stmt->execute($room);
    }
    echo "✅ " . count($rooms) . " chambres créées\n";

    // Créer des éléments de menu camerounais avec prix en FCFA
    $menuItems = [
        // Entrées
        ['Salade d\'avocat à la camerounaise', 'Avocat frais avec tomates, oignons et vinaigrette locale', 3500.00, 'Entrées', '/assets/images/macedoine.jpg'],
        ['Beignets de crevettes', 'Beignets croustillants aux crevettes fraîches du littoral', 4500.00, 'Entrées', '/assets/images/fruit.jpg'],
        ['Salade de fruits tropicaux', 'Mangue, papaye, ananas et fruit de la passion', 2500.00, 'Entrées', '/assets/images/fruit.jpg'],

        // Plats principaux
        ['Ndolé au poisson', 'Plat traditionnel aux arachides avec poisson fumé et légumes', 6500.00, 'Plats', '/assets/images/Mbongo.jpg'],
        ['Mbongo Tchobi', 'Ragoût de porc aux épices noires traditionnelles', 7500.00, 'Plats', '/assets/images/Mbongo.jpg'],
        ['Poisson braisé', 'Poisson frais grillé aux épices camerounaises', 5500.00, 'Plats', '/assets/images/chamb.jpg'],
        ['Poulet DG', 'Poulet directeur général aux plantains et légumes', 8000.00, 'Plats', '/assets/images/chamb.jpg'],
        ['Eru', 'Légumes verts traditionnels du Sud-Ouest avec stockfish', 6000.00, 'Plats', '/assets/images/Mbongo.jpg'],
        ['Koki de haricots', 'Gâteau de haricots pilés cuit à la vapeur', 4000.00, 'Plats', '/assets/images/macedoine.jpg'],

        // Accompagnements
        ['Riz sauté camerounais', 'Riz parfumé aux légumes locaux', 2500.00, 'Accompagnements', '/assets/images/images1.jpg'],
        ['Plantains mûrs frits', 'Plantains dorés à la perfection', 2000.00, 'Accompagnements', '/assets/images/images1.jpg'],
        ['Miondo', 'Bâtons de manioc cuits à la vapeur', 1500.00, 'Accompagnements', '/assets/images/images1.jpg'],

        // Desserts
        ['Tarte à la noix de coco', 'Tarte crémeuse à la noix de coco fraîche', 3000.00, 'Desserts', '/assets/images/macedoine.jpg'],
        ['Salade de fruits exotiques', 'Mélange de fruits tropicaux de saison', 2500.00, 'Desserts', '/assets/images/fruit.jpg'],
        ['Beignets sucrés', 'Beignets traditionnels saupoudrés de sucre', 2000.00, 'Desserts', '/assets/images/fruit.jpg'],

        // Boissons
        ['Jus de bissap', 'Boisson rafraîchissante à l\'hibiscus', 1500.00, 'Boissons', '/assets/images/fruit.jpg'],
        ['Jus de gingembre', 'Jus de gingembre frais épicé', 1500.00, 'Boissons', '/assets/images/fruit.jpg'],
        ['Bière Castel', 'Bière locale camerounaise bien fraîche', 2000.00, 'Boissons', '/assets/images/images1.jpg'],
        ['33 Export', 'Bière premium camerounaise', 2500.00, 'Boissons', '/assets/images/images1.jpg'],
        ['Vin de palme', 'Boisson traditionnelle fermentée (non-alcoolisée)', 1800.00, 'Boissons', '/assets/images/fruit.jpg'],
        ['Café arabica local', 'Café des hautes terres de l\'Ouest Cameroun', 1200.00, 'Boissons', '/assets/images/images1.jpg']
    ];

    $stmt = $db->prepare("INSERT IGNORE INTO menus (name, description, price, category, image_path) VALUES (?, ?, ?, ?, ?)");
    foreach ($menuItems as $item) {
        $stmt->execute($item);
    }
    echo "✅ " . count($menuItems) . " éléments de menu camerounais créés\n";

    echo "🎉 Seeding terminé avec succès !\n";
    echo "\n📋 Comptes créés :\n";
    echo "   Admin: admin@hotel-cameroun.com / admin123\n";
    echo "   Client: client@hotel-cameroun.com / user123\n";
    echo "\n💰 Prix en FCFA (Franc CFA)\n";
    echo "   Chambres Standard: 45,000 FCFA/nuit\n";
    echo "   Chambres Deluxe: 75,000 FCFA/nuit\n";
    echo "   Suites: 125,000 - 200,000 FCFA/nuit\n";
} catch (Exception $e) {
    echo "❌ Erreur lors du seeding : " . $e->getMessage() . "\n";
    exit(1);
}
