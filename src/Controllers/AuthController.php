<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Models\User;
use Respect\Validation\Validator as v;

class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'] ?? '';

                // Validation
                if (!v::email()->validate($email)) {
                    throw new \Exception('Email invalide');
                }

                if (empty($password)) {
                    throw new \Exception('Mot de passe requis');
                }

                // Tentative de connexion
                $user = $this->authService->login($email, $password);

                // Création de la session
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_role'] = $user->getRole();

                // Redirection selon le rôle
                $this->redirect('/dashboard');
            } catch (\Exception $e) {
                // Gestion des erreurs
                $_SESSION['error'] = $e->getMessage();
                $this->redirect('/login');
            }
        }

        // Affichage du formulaire de connexion
        require __DIR__ . '/../Views/templates/auth/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Validation et assainissement des entrées
                $data = [
                    'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
                    'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                    'password' => $_POST['password'] ?? '',
                    'password_confirm' => $_POST['password_confirm'] ?? ''
                ];

                // Validation des données
                $this->validateRegistration($data);

                // Création de l'utilisateur
                $user = $this->authService->register($data);

                // Message de succès et redirection
                $_SESSION['success'] = 'Compte créé avec succès';
                $this->redirect('/login');
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                $this->redirect('/register');
            }
        }

        // Affichage du formulaire d'inscription
        require __DIR__ . '/../Views/templates/auth/register.php';
    }

    private function validateRegistration(array $data): void
    {
        if (!v::stringType()->length(3, 50)->validate($data['name'])) {
            throw new \Exception('Le nom doit contenir entre 3 et 50 caractères');
        }

        if (!v::email()->validate($data['email'])) {
            throw new \Exception('Email invalide');
        }

        if (!v::stringType()->length(8, null)->validate($data['password'])) {
            throw new \Exception('Le mot de passe doit contenir au moins 8 caractères');
        }

        if ($data['password'] !== $data['password_confirm']) {
            throw new \Exception('Les mots de passe ne correspondent pas');
        }
    }

    private function redirect(string $path): void
    {
        header("Location: $path");
        exit();
    }
} 