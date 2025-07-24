<?php

namespace App\Models;

class Room
{
    private ?int $id;
    private string $number;
    private string $type;
    private int $capacity;
    private float $pricePerNight;
    private ?string $description;
    private bool $isAvailable;
    private ?string $createdAt;
    private ?string $updatedAt;

    public function __construct(
        ?int $id = null,
        string $number = '',
        string $type = '',
        int $capacity = 1,
        float $pricePerNight = 0.0,
        ?string $description = null,
        bool $isAvailable = true,
        ?string $createdAt = null,
        ?string $updatedAt = null
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->type = $type;
        $this->capacity = $capacity;
        $this->pricePerNight = $pricePerNight;
        $this->description = $description;
        $this->isAvailable = $isAvailable;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Créer une instance depuis un array de données de base de données
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['number'] ?? '',
            $data['type'] ?? '',
            (int) ($data['capacity'] ?? 1),
            (float) ($data['price_per_night'] ?? 0.0),
            $data['description'] ?? null,
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
            'number' => $this->number,
            'type' => $this->type,
            'capacity' => $this->capacity,
            'price_per_night' => $this->pricePerNight,
            'description' => $this->description,
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

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getPricePerNight(): float
    {
        return $this->pricePerNight;
    }

    public function getDescription(): ?string
    {
        return $this->description;
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

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }

    public function setPricePerNight(float $pricePerNight): void
    {
        $this->pricePerNight = $pricePerNight;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setIsAvailable(bool $isAvailable): void
    {
        $this->isAvailable = $isAvailable;
    }

    // Méthodes utilitaires
    public function getFormattedPrice(): string
    {
        return number_format($this->pricePerNight, 0, ',', ' ') . ' FCFA';
    }

    public function getStatusBadge(): string
    {
        return $this->isAvailable
            ? '<span class="badge bg-success">Disponible</span>'
            : '<span class="badge bg-danger">Indisponible</span>';
    }

    public function getTypeBadge(): string
    {
        $colors = [
            'standard' => 'primary',
            'deluxe' => 'warning',
            'suite' => 'success',
            'presidential' => 'danger'
        ];

        $color = $colors[strtolower($this->type)] ?? 'secondary';
        return '<span class="badge bg-' . $color . '">' . ucfirst($this->type) . '</span>';
    }

    // Validation
    public function validate(): array
    {
        $errors = [];

        if (empty($this->number)) {
            $errors['number'] = 'Le numéro de chambre est requis';
        }

        if (empty($this->type)) {
            $errors['type'] = 'Le type de chambre est requis';
        }

        if ($this->capacity < 1 || $this->capacity > 10) {
            $errors['capacity'] = 'La capacité doit être entre 1 et 10 personnes';
        }

        if ($this->pricePerNight <= 0) {
            $errors['price_per_night'] = 'Le prix par nuit doit être supérieur à 0';
        }

        return $errors;
    }
}
