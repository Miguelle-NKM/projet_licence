<?php
namespace App\Services;

use PDO;
use Exception;

class MenuService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DatabaseService::getInstance()->getConnection();
    }

    public function getAllMenus(): array
    {
        $stmt = $this->db->query("
            SELECT *
            FROM menus
            ORDER BY category, name
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMenuById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM menus
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getAllCategories(): array
    {
        $stmt = $this->db->query("
            SELECT DISTINCT category
            FROM menus
            ORDER BY category
        ");
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getMenusByCategory(string $category): array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM menus
            WHERE category = ?
            ORDER BY name
        ");
        $stmt->execute([$category]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createMenu(array $data): int
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO menus (
                    name, description, price, category,
                    image_path, is_available
                ) VALUES (
                    :name, :description, :price, :category,
                    :image_path, :is_available
                )
            ");

            $stmt->execute([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'category' => $data['category'],
                'image_path' => $data['image_path'] ?? null,
                'is_available' => $data['is_available']
            ]);

            return (int)$this->db->lastInsertId();
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la création du menu: ' . $e->getMessage());
        }
    }

    public function updateMenu(int $id, array $data): void
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE menus
                SET name = :name,
                    description = :description,
                    price = :price,
                    category = :category,
                    image_path = :image_path,
                    is_available = :is_available
                WHERE id = :id
            ");

            $stmt->execute([
                'id' => $id,
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'category' => $data['category'],
                'image_path' => $data['image_path'] ?? null,
                'is_available' => $data['is_available']
            ]);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la mise à jour du menu: ' . $e->getMessage());
        }
    }

    public function deleteMenu(int $id): void
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM menus WHERE id = ?");
            $stmt->execute([$id]);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la suppression du menu: ' . $e->getMessage());
        }
    }

    public function searchMenus(string $query): array
    {
        $searchTerm = "%$query%";
        
        $stmt = $this->db->prepare("
            SELECT *
            FROM menus
            WHERE name LIKE :query
            OR description LIKE :query
            OR category LIKE :query
            ORDER BY category, name
        ");
        
        $stmt->execute(['query' => $searchTerm]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toggleAvailability(int $id): void
    {
        $stmt = $this->db->prepare("
            UPDATE menus
            SET is_available = NOT is_available
            WHERE id = ?
        ");
        
        $stmt->execute([$id]);
    }

    public function getAvailableMenus(): array
    {
        $stmt = $this->db->query("
            SELECT *
            FROM menus
            WHERE is_available = 1
            ORDER BY category, name
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 