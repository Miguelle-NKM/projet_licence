<?php
namespace App\Models;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $role;
    private string $createdAt;

    public function __construct(array $data)
    {
        $this->id = (int) $data['id'];
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->role = $data['role'];
        $this->createdAt = $data['created_at'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'created_at' => $this->createdAt
        ];
    }
} 