<?php
namespace App\Controllers;

use App\Services\MenuService;
use Exception;

class MenuController
{
    private MenuService $menuService;

    public function __construct()
    {
        $this->menuService = new MenuService();
    }

    public function index()
    {
        $title = 'Notre Menu';
        $categories = $this->menuService->getAllCategories();
        $menus = $this->menuService->getAllMenus();
        
        // Organiser les menus par catégorie
        $menusByCategory = [];
        foreach ($menus as $menu) {
            $menusByCategory[$menu['category']][] = $menu;
        }
        
        ob_start();
        require __DIR__ . '/../Views/templates/menu/index.php';
        $content = ob_get_clean();
        
        require __DIR__ . '/../Views/templates/layout.php';
    }

    public function show(int $id)
    {
        try {
            $menu = $this->menuService->getMenuById($id);
            if (!$menu) {
                throw new Exception('Menu non trouvé');
            }

            $title = $menu['name'];
            
            ob_start();
            require __DIR__ . '/../Views/templates/menu/show.php';
            $content = ob_get_clean();
            
            require __DIR__ . '/../Views/templates/layout.php';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /menu');
            exit;
        }
    }

    public function create()
    {
        // Vérification des droits d'administration
        if (!isset($_SESSION['is_admin'])) {
            $_SESSION['error'] = 'Accès non autorisé';
            header('Location: /menu');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = $this->validateMenuData($_POST);
                
                // Gestion de l'upload d'image
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $data['image_path'] = $this->handleImageUpload($_FILES['image']);
                }

                $this->menuService->createMenu($data);
                
                $_SESSION['success'] = 'Menu créé avec succès';
                header('Location: /menu');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }

        $title = 'Créer un menu';
        $categories = $this->menuService->getAllCategories();
        
        ob_start();
        require __DIR__ . '/../Views/templates/menu/create.php';
        $content = ob_get_clean();
        
        require __DIR__ . '/../Views/templates/layout.php';
    }

    public function edit(int $id)
    {
        // Vérification des droits d'administration
        if (!isset($_SESSION['is_admin'])) {
            $_SESSION['error'] = 'Accès non autorisé';
            header('Location: /menu');
            exit;
        }

        try {
            $menu = $this->menuService->getMenuById($id);
            if (!$menu) {
                throw new Exception('Menu non trouvé');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = $this->validateMenuData($_POST);
                
                // Gestion de l'upload d'image
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $data['image_path'] = $this->handleImageUpload($_FILES['image']);
                    // Supprimer l'ancienne image si elle existe
                    if ($menu['image_path']) {
                        @unlink(__DIR__ . '/../../public' . $menu['image_path']);
                    }
                } else {
                    $data['image_path'] = $menu['image_path'];
                }

                $this->menuService->updateMenu($id, $data);
                
                $_SESSION['success'] = 'Menu mis à jour avec succès';
                header('Location: /menu');
                exit;
            }

            $title = 'Modifier le menu';
            $categories = $this->menuService->getAllCategories();
            
            ob_start();
            require __DIR__ . '/../Views/templates/menu/edit.php';
            $content = ob_get_clean();
            
            require __DIR__ . '/../Views/templates/layout.php';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /menu');
            exit;
        }
    }

    public function delete(int $id)
    {
        // Vérification des droits d'administration
        if (!isset($_SESSION['is_admin'])) {
            $_SESSION['error'] = 'Accès non autorisé';
            header('Location: /menu');
            exit;
        }

        try {
            $menu = $this->menuService->getMenuById($id);
            if (!$menu) {
                throw new Exception('Menu non trouvé');
            }

            // Suppression de l'image associée
            if ($menu['image_path']) {
                @unlink(__DIR__ . '/../../public' . $menu['image_path']);
            }

            $this->menuService->deleteMenu($id);
            
            $_SESSION['success'] = 'Menu supprimé avec succès';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /menu');
        exit;
    }

    private function validateMenuData(array $data): array
    {
        $errors = [];

        // Validation du nom
        if (empty($data['name']) || strlen($data['name']) > 100) {
            $errors[] = 'Le nom du menu doit contenir entre 1 et 100 caractères';
        }

        // Validation du prix
        $price = filter_var($data['price'], FILTER_VALIDATE_FLOAT);
        if ($price === false || $price <= 0) {
            $errors[] = 'Le prix doit être un nombre positif';
        }

        // Validation de la catégorie
        if (empty($data['category'])) {
            $errors[] = 'La catégorie est requise';
        }

        if (!empty($errors)) {
            throw new Exception(implode('<br>', $errors));
        }

        return [
            'name' => strip_tags($data['name']),
            'description' => strip_tags($data['description'] ?? ''),
            'price' => $price,
            'category' => strip_tags($data['category']),
            'is_available' => isset($data['is_available']) ? 1 : 0
        ];
    }

    private function handleImageUpload(array $file): string
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Type de fichier non autorisé. Utilisez JPG, PNG ou WebP.');
        }

        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file['size'] > $maxSize) {
            throw new Exception('L\'image ne doit pas dépasser 5MB');
        }

        $uploadDir = __DIR__ . '/../../public/assets/images/menu/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $uploadPath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Erreur lors de l\'upload de l\'image');
        }

        return '/assets/images/menu/' . $fileName;
    }
} 