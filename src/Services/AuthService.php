<?php
namespace App\Services;

use App\Models\User;
use PDO;

class AuthService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DatabaseService::getInstance()->getConnection();
    }

    public function login(string $email, string $password): User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            throw new \Exception('Identifiants invalides');
        }

        return new User($user);
    }

    public function register(array $data): User
    {
        // Vérification si l'email existe déjà
        $stmt = $this->db->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$data['email']]);
        if ($stmt->fetch()) {
            throw new \Exception('Cet email est déjà utilisé');
        }

        // Hachage du mot de passe
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        // Insertion de l'utilisateur
        $stmt = $this->db->prepare('
            INSERT INTO users (name, email, password, role, created_at) 
            VALUES (?, ?, ?, ?, NOW())
        ');

        $stmt->execute([
            $data['name'],
            $data['email'],
            $hashedPassword,
            'user' // Rôle par défaut
        ]);

        // Récupération de l'utilisateur créé
        return $this->getUserById($this->db->lastInsertId());
    }

    public function getUserById(string $id): User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new \Exception('Utilisateur non trouvé');
        }

        return new User($user);
    }

    public function logout(): void
    {
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
    }
} 