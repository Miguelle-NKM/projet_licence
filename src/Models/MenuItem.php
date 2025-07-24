<?php

namespace App\Models;

class MenuItem
{
    private ?int $id;
    private string $name;
    private ?string $description;
    private float $price;
    private string $category;
    private ?string $imagePath;
    private bool $isAvailable;
    private ?string $createdAt;
    private ?string $updatedAt;

    public function __construct(
        ?int $id = null,
        string $name = '',
        ?string $description = null,
        float $price = 0.0,
        string $category = '',
        ?string $imagePath = null,
        bool $isAvailable = true,
        ?string $createdAt = null,
        ?string $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->imagePath = $imagePath;
        $this->isAvailable = $isAvailable;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Créer une instance depuis un array de données de base de données
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['name'] ?? '',
            $data['description'] ?? null,
            (float) ($data['price'] ?? 0.0),
            $data['category'] ?? '',
            $data['image_path'] ?? null,
            (bool) ($data['is_available'] ?? true),
            $data['created_at'] ?? null,
            $data['updated_at'] ?? null
        );
    }

    // Convertir vers un array pour la base de données
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category' => $this->category,
            'image_path' => $this->imagePath,
            'is_available' => $this->isAvailable,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function setImagePath(?string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function setIsAvailable(bool $isAvailable): void
    {
        $this->isAvailable = $isAvailable;
    }

    // Méthodes utilitaires
    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, ',', ' ') . ' FCFA';
    }

    public function getStatusBadge(): string
    {
        return $this->isAvailable
            ? '<span class="badge bg-success">Disponible</span>'
            : '<span class="badge bg-danger">Indisponible</span>';
    }

    public function getCategoryBadge(): string
    {
        $colors = [
            'entree' => 'primary',
            'entrée' => 'primary',
            'plat' => 'warning',
            'plats' => 'warning',
            'dessert' => 'success',
            'desserts' => 'success',
            'boisson' => 'info',
            'boissons' => 'info',
            'alcool' => 'danger',
            'vin' => 'danger'
        ];

        $color = $colors[strtolower($this->category)] ?? 'secondary';
        return '<span class="badge bg-' . $color . '">' . ucfirst($this->category) . '</span>';
    }

    public function getImageUrl(): string
    {
        if ($this->imagePath && file_exists('public' . $this->imagePath)) {
            return $this->imagePath;
        }

        // Image par défaut selon la catégorie
        $defaultImages = [
            'entree' => '/assets/images/default-entree.jpg',
            'entrée' => '/assets/images/default-entree.jpg',
            'plat' => '/assets/images/default-plat.jpg',
            'plats' => '/assets/images/default-plat.jpg',
            'dessert' => '/assets/images/default-dessert.jpg',
            'desserts' => '/assets/images/default-dessert.jpg',
            'boisson' => '/assets/images/default-boisson.jpg',
            'boissons' => '/assets/images/default-boisson.jpg',
        ];

        return $defaultImages[strtolower($this->category)] ?? '/assets/images/default-menu.jpg';
    }

    public function getTruncatedDescription(int $maxLength = 100): string
    {
        if (!$this->description) {
            return '';
        }

        if (strlen($this->description) <= $maxLength) {
            return $this->description;
        }

        return substr($this->description, 0, $maxLength) . '...';
    }

    // Validation
    public function validate(): array
    {
        $errors = [];

        if (empty($this->name)) {
            $errors['name'] = 'Le nom du plat est requis';
        }

        if (empty($this->category)) {
            $errors['category'] = 'La catégorie est requise';
        }

        if ($this->price <= 0) {
            $errors['price'] = 'Le prix doit être supérieur à 0';
        }

        if ($this->description && strlen($this->description) > 1000) {
            $errors['description'] = 'La description ne peut pas dépasser 1000 caractères';
        }

        return $errors;
    }

    // Catégories disponibles
    public static function getAvailableCategories(): array
    {
        return [
            'entree' => 'Entrées',
            'plat' => 'Plats principaux',
            'dessert' => 'Desserts',
            'boisson' => 'Boissons',
            'alcool' => 'Boissons alcoolisées',
            'vin' => 'Vins'
        ];
    }
}
