<?php

namespace App\Controllers;

use App\Services\RoomService;
use App\Services\MenuService;
use App\Models\Room;
use App\Models\MenuItem;

class AdminController
{
    private RoomService $roomService;
    private MenuService $menuService;

    public function __construct()
    {
        $this->roomService = new RoomService();
        $this->menuService = new MenuService();

        // Vérifier que l'utilisateur est admin
        $this->requireAdmin();
    }

    // Dashboard principal admin
    public function dashboard()
    {
        try {
            $title = 'Dashboard Admin';

            // Statistiques rapides
            $stats = [
                'total_rooms' => count($this->roomService->getAllRooms()),
                'available_rooms' => count($this->roomService->getAvailableRooms()),
                'total_menu_items' => count($this->menuService->getAllMenus()),
                'menu_categories' => count($this->menuService->getAllCategories())
            ];

            ob_start();
            require __DIR__ . '/../Views/templates/admin/dashboard.php';
            $content = ob_get_clean();
            require __DIR__ . '/../Views/templates/layout.php';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors du chargement du dashboard: ' . $e->getMessage();
            $this->redirect('/');
        }
    }

    // === GESTION DES CHAMBRES ===

    // Liste des chambres
    public function roomsList()
    {
        try {
            $title = 'Gestion des Chambres';
            $rooms = $this->roomService->getAllRooms();

            // Convertir en objets Room
            $roomObjects = array_map(function ($room) {
                return Room::fromArray($room);
            }, $rooms);

            ob_start();
            require __DIR__ . '/../Views/templates/admin/rooms/list.php';
            $content = ob_get_clean();
            require __DIR__ . '/../Views/templates/layout.php';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors du chargement des chambres: ' . $e->getMessage();
            $this->redirect('/admin/dashboard');
        }
    }

    // Formulaire de création de chambre
    public function roomCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->roomStore();
        }

        $title = 'Nouvelle Chambre';
        $room = new Room(); // Chambre vide pour le formulaire

        ob_start();
        require __DIR__ . '/../Views/templates/admin/rooms/form.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/templates/layout.php';
    }

    // Sauvegarde d'une nouvelle chambre
    public function roomStore()
    {
        try {
            $data = [
                'number' => $_POST['number'] ?? '',
                'type' => $_POST['type'] ?? '',
                'capacity' => (int) ($_POST['capacity'] ?? 1),
                'price_per_night' => (float) ($_POST['price_per_night'] ?? 0),
                'description' => $_POST['description'] ?? null,
                'is_available' => isset($_POST['is_available']) ? 1 : 0
            ];

            $room = Room::fromArray($data);
            $errors = $room->validate();

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $data;
                $this->redirect('/admin/rooms/create');
                return;
            }

            $roomId = $this->roomService->createRoom($data);
            $_SESSION['success'] = 'Chambre créée avec succès!';
            $this->redirect('/admin/rooms');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la création: ' . $e->getMessage();
            $this->redirect('/admin/rooms/create');
        }
    }

    // Formulaire d'édition de chambre
    public function roomEdit(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->roomUpdate($id);
        }

        try {
            $roomData = $this->roomService->getRoomById($id);
            if (!$roomData) {
                $_SESSION['error'] = 'Chambre non trouvée';
                $this->redirect('/admin/rooms');
                return;
            }

            $title = 'Modifier la Chambre';
            $room = Room::fromArray($roomData);

            ob_start();
            require __DIR__ . '/../Views/templates/admin/rooms/form.php';
            $content = ob_get_clean();
            require __DIR__ . '/../Views/templates/layout.php';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors du chargement: ' . $e->getMessage();
            $this->redirect('/admin/rooms');
        }
    }

    // Mise à jour d'une chambre
    public function roomUpdate(int $id)
    {
        try {
            $data = [
                'number' => $_POST['number'] ?? '',
                'type' => $_POST['type'] ?? '',
                'capacity' => (int) ($_POST['capacity'] ?? 1),
                'price_per_night' => (float) ($_POST['price_per_night'] ?? 0),
                'description' => $_POST['description'] ?? null,
                'is_available' => isset($_POST['is_available']) ? 1 : 0
            ];

            $room = Room::fromArray($data);
            $errors = $room->validate();

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $data;
                $this->redirect("/admin/rooms/edit/$id");
                return;
            }

            $this->roomService->updateRoom($id, $data);
            $_SESSION['success'] = 'Chambre mise à jour avec succès!';
            $this->redirect('/admin/rooms');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la mise à jour: ' . $e->getMessage();
            $this->redirect("/admin/rooms/edit/$id");
        }
    }

    // Suppression d'une chambre
    public function roomDelete(int $id)
    {
        try {
            $this->roomService->deleteRoom($id);
            $_SESSION['success'] = 'Chambre supprimée avec succès!';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la suppression: ' . $e->getMessage();
        }

        $this->redirect('/admin/rooms');
    }

    // === GESTION DU MENU ===

    // Liste des éléments du menu
    public function menuList()
    {
        try {
            $title = 'Gestion du Menu';
            $menus = $this->menuService->getAllMenus();

            // Convertir en objets MenuItem
            $menuObjects = array_map(function ($menu) {
                return MenuItem::fromArray($menu);
            }, $menus);

            ob_start();
            require __DIR__ . '/../Views/templates/admin/menu/list.php';
            $content = ob_get_clean();
            require __DIR__ . '/../Views/templates/layout.php';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors du chargement du menu: ' . $e->getMessage();
            $this->redirect('/admin/dashboard');
        }
    }

    // Formulaire de création d'élément de menu
    public function menuCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->menuStore();
        }

        $title = 'Nouvel Élément du Menu';
        $menuItem = new MenuItem(); // Élément vide pour le formulaire
        $categories = MenuItem::getAvailableCategories();

        ob_start();
        require __DIR__ . '/../Views/templates/admin/menu/form.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/templates/layout.php';
    }

    // Sauvegarde d'un nouvel élément de menu
    public function menuStore()
    {
        try {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? null,
                'price' => (float) ($_POST['price'] ?? 0),
                'category' => $_POST['category'] ?? '',
                'image_path' => $_POST['image_path'] ?? null,
                'is_available' => isset($_POST['is_available']) ? 1 : 0
            ];

            $menuItem = MenuItem::fromArray($data);
            $errors = $menuItem->validate();

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $data;
                $this->redirect('/admin/menu/create');
                return;
            }

            $menuId = $this->menuService->createMenu($data);
            $_SESSION['success'] = 'Élément du menu créé avec succès!';
            $this->redirect('/admin/menu');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la création: ' . $e->getMessage();
            $this->redirect('/admin/menu/create');
        }
    }

    // Formulaire d'édition d'élément de menu
    public function menuEdit(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->menuUpdate($id);
        }

        try {
            $menuData = $this->menuService->getMenuById($id);
            if (!$menuData) {
                $_SESSION['error'] = 'Élément du menu non trouvé';
                $this->redirect('/admin/menu');
                return;
            }

            $title = 'Modifier l\'Élément du Menu';
            $menuItem = MenuItem::fromArray($menuData);
            $categories = MenuItem::getAvailableCategories();

            ob_start();
            require __DIR__ . '/../Views/templates/admin/menu/form.php';
            $content = ob_get_clean();
            require __DIR__ . '/../Views/templates/layout.php';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors du chargement: ' . $e->getMessage();
            $this->redirect('/admin/menu');
        }
    }

    // Mise à jour d'un élément de menu
    public function menuUpdate(int $id)
    {
        try {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? null,
                'price' => (float) ($_POST['price'] ?? 0),
                'category' => $_POST['category'] ?? '',
                'image_path' => $_POST['image_path'] ?? null,
                'is_available' => isset($_POST['is_available']) ? 1 : 0
            ];

            $menuItem = MenuItem::fromArray($data);
            $errors = $menuItem->validate();

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $data;
                $this->redirect("/admin/menu/edit/$id");
                return;
            }

            $this->menuService->updateMenu($id, $data);
            $_SESSION['success'] = 'Élément du menu mis à jour avec succès!';
            $this->redirect('/admin/menu');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la mise à jour: ' . $e->getMessage();
            $this->redirect("/admin/menu/edit/$id");
        }
    }

    // Suppression d'un élément de menu
    public function menuDelete(int $id)
    {
        try {
            $this->menuService->deleteMenu($id);
            $_SESSION['success'] = 'Élément du menu supprimé avec succès!';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la suppression: ' . $e->getMessage();
        }

        $this->redirect('/admin/menu');
    }

    // === MÉTHODES UTILITAIRES ===

    // Vérification des droits admin
    private function requireAdmin(): void
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
            $_SESSION['error'] = 'Accès refusé. Droits administrateur requis.';
            $this->redirect('/login');
            exit();
        }
    }

    // Redirection
    private function redirect(string $path): void
    {
        header("Location: $path");
        exit();
    }
}
