<?php
namespace App\Controllers;

class HomeController
{
    public function index()
    {
        $title = 'Accueil';
        $featuredRooms = $this->getFeaturedRooms();
        $specialMenus = $this->getSpecialMenus();
        
        ob_start();
        require __DIR__ . '/../Views/templates/home/index.php';
        $content = ob_get_clean();
        
        require __DIR__ . '/../Views/templates/layout.php';
    }

    private function getFeaturedRooms(): array
    {
        // TODO: Implémenter la récupération depuis la base de données
        return [
            [
                'id' => 1,
                'name' => 'Chambre Luxe',
                'description' => 'Une chambre spacieuse avec vue sur la ville',
                'price' => 150.00,
                'image' => '/assets/images/chamb.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Suite Royale',
                'description' => 'Notre meilleure suite avec service personnalisé',
                'price' => 300.00,
                'image' => '/assets/images/Chamtar.jpg'
            ]
        ];
    }

    private function getSpecialMenus(): array
    {
        // TODO: Implémenter la récupération depuis la base de données
        return [
            [
                'id' => 1,
                'name' => 'Menu Gastronomique',
                'description' => 'Une sélection de nos meilleurs plats',
                'price' => 45.00,
                'image' => '/assets/images/fruit.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Menu Traditionnel',
                'description' => 'Découvrez nos spécialités locales',
                'price' => 35.00,
                'image' => '/assets/images/macedoine.jpg'
            ]
        ];
    }
} 