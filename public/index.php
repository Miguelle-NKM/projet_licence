<?php

declare(strict_types=1);

// Gestion des erreurs en développement
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Autoloading des classes
require_once __DIR__ . '/../vendor/autoload.php';

// Chargement des variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configuration de base
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => ($_ENV['APP_ENV'] ?? 'development') === 'production',
    'cookie_samesite' => 'Lax'
]);

// Gestion des routes
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Router basique
try {
    switch ($uri) {
        case '/':
            (new App\Controllers\HomeController())->index();
            break;
        case '/login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                if (!empty($email) && !empty($password)) {
                    try {
                        $authService = new App\Services\AuthService();
                        $user = $authService->login($email, $password);

                        $_SESSION['user_id'] = $user->getId();
                        $_SESSION['user_role'] = $user->getRole();
                        $_SESSION['user_email'] = $user->getEmail();
                        $_SESSION['user_name'] = $user->getName();
                        $_SESSION['success'] = 'Connexion réussie !';

                        // Redirection selon le rôle
                        if ($user->getRole() === 'admin') {
                            header('Location: /admin/dashboard');
                        } else {
                            header('Location: /dashboard');
                        }
                        exit();
                    } catch (Exception $e) {
                        $_SESSION['error'] = $e->getMessage();
                    }
                } else {
                    $_SESSION['error'] = 'Veuillez remplir tous les champs';
                }
            }

            $title = 'Connexion';
            ob_start();
            require __DIR__ . '/../src/Views/templates/auth/login.php';
            $content = ob_get_clean();
            require __DIR__ . '/../src/Views/templates/layout.php';
            break;
        case '/register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'] ?? '';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';

                if (!empty($name) && !empty($email) && !empty($password) && !empty($confirmPassword)) {
                    if ($password === $confirmPassword) {
                        try {
                            $authService = new App\Services\AuthService();
                            $user = $authService->register([
                                'name' => $name,
                                'email' => $email,
                                'password' => $password
                            ]);

                            $_SESSION['user_id'] = $user->getId();
                            $_SESSION['user_role'] = $user->getRole();
                            $_SESSION['user_email'] = $user->getEmail();
                            $_SESSION['user_name'] = $user->getName();
                            $_SESSION['success'] = 'Inscription réussie ! Bienvenue ' . $user->getName();

                            // Redirection vers le dashboard selon le rôle
                            if ($user->getRole() === 'admin') {
                                header('Location: /admin/dashboard');
                            } else {
                                header('Location: /dashboard');
                            }
                            exit();
                        } catch (Exception $e) {
                            $_SESSION['error'] = $e->getMessage();
                        }
                    } else {
                        $_SESSION['error'] = 'Les mots de passe ne correspondent pas';
                    }
                } else {
                    $_SESSION['error'] = 'Veuillez remplir tous les champs';
                }
            }

            $title = 'Inscription';
            ob_start();
            require __DIR__ . '/../src/Views/templates/auth/register.php';
            $content = ob_get_clean();
            require __DIR__ . '/../src/Views/templates/layout.php';
            break;
        case '/logout':
            try {
                $authService = new App\Services\AuthService();
                $authService->logout();

                session_start();
                $_SESSION['success'] = 'Vous avez été déconnecté avec succès';
                header('Location: /');
                exit();
            } catch (Exception $e) {
                session_start();
                $_SESSION['error'] = 'Erreur lors de la déconnexion';
                header('Location: /');
                exit();
            }
            break;
        case '/dashboard':
            // Page dashboard temporaire pour les clients
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['error'] = 'Vous devez être connecté pour accéder à cette page';
                header('Location: /login');
                exit();
            }
            $title = 'Tableau de Bord';
            ob_start();
?>
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="card border-0 shadow-lg">
                            <div class="card-header bg-primary text-white py-4">
                                <h2 class="mb-0 fw-bold">
                                    <i class="fas fa-tachometer-alt me-2"></i>Tableau de Bord Client
                                </h2>
                            </div>
                            <div class="card-body p-5">
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Bienvenue !</strong> Vous êtes connecté avec succès.
                                </div>

                                <h4 class="text-primary mb-4">Informations de Session</h4>
                                <ul class="list-group list-group-flush mb-4">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="fas fa-user me-2"></i>ID Utilisateur:</span>
                                        <strong><?= htmlspecialchars($_SESSION['user_id'] ?? 'Non défini') ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="fas fa-envelope me-2"></i>Email:</span>
                                        <strong><?= htmlspecialchars($_SESSION['user_email'] ?? 'Non défini') ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="fas fa-shield-alt me-2"></i>Rôle:</span>
                                        <strong><?= htmlspecialchars($_SESSION['user_role'] ?? 'Non défini') ?></strong>
                                    </li>
                                </ul>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <a href="/reservation" class="btn btn-primary btn-lg w-100">
                                            <i class="fas fa-calendar-alt me-2"></i>Mes Réservations
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="/menu" class="btn btn-info btn-lg w-100">
                                            <i class="fas fa-utensils me-2"></i>Menu
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="/logout" class="btn btn-outline-danger btn-lg w-100">
                                            <i class="fas fa-sign-out-alt me-2"></i>Se Déconnecter
                                        </a>
                                    </div>
                                </div>

                                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                    <div class="alert alert-info mt-4">
                                        <h5><i class="fas fa-crown me-2"></i>Accès Administrateur</h5>
                                        <p class="mb-2">Vous avez des privilèges administrateur.</p>
                                        <a href="/admin/dashboard" class="btn btn-warning">
                                            <i class="fas fa-tools me-2"></i>Aller au Dashboard Admin
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
            $content = ob_get_clean();
            require __DIR__ . '/../src/Views/templates/layout.php';
            break;

        // === ROUTES ADMIN ===
        case '/admin/dashboard':
            (new App\Controllers\AdminController())->dashboard();
            break;

        // Routes des chambres
        case '/admin/rooms':
            (new App\Controllers\AdminController())->roomsList();
            break;
        case '/admin/rooms/create':
            (new App\Controllers\AdminController())->roomCreate();
            break;

        // Routes du menu
        case '/admin/menu':
            (new App\Controllers\AdminController())->menuList();
            break;
        case '/admin/menu/create':
            (new App\Controllers\AdminController())->menuCreate();
            break;

        case '/menu':
            (new App\Controllers\MenuController())->index();
            break;
        case '/reservation':
            (new App\Controllers\ReservationController())->index();
            break;
        case '/contact':
            $title = 'Contact';
            ob_start();
            require __DIR__ . '/../src/Views/templates/contact/index.php';
            $content = ob_get_clean();
            require __DIR__ . '/../src/Views/templates/layout.php';
            break;
        default:
            // Gestion des routes dynamiques avec paramètres
            if (preg_match('#^/admin/rooms/edit/(\d+)$#', $uri, $matches)) {
                (new App\Controllers\AdminController())->roomEdit((int)$matches[1]);
            } elseif (preg_match('#^/admin/rooms/delete/(\d+)$#', $uri, $matches)) {
                (new App\Controllers\AdminController())->roomDelete((int)$matches[1]);
            } elseif (preg_match('#^/admin/menu/edit/(\d+)$#', $uri, $matches)) {
                (new App\Controllers\AdminController())->menuEdit((int)$matches[1]);
            } elseif (preg_match('#^/admin/menu/delete/(\d+)$#', $uri, $matches)) {
                (new App\Controllers\AdminController())->menuDelete((int)$matches[1]);
            } else {
                http_response_code(404);
                require __DIR__ . '/../src/Views/templates/404.php';
            }
    }
} catch (Exception $e) {
    if (($_ENV['APP_ENV'] ?? 'development') === 'development') {
        echo "<h1>Erreur de développement</h1>";
        echo "<pre>" . $e->getMessage() . "\n\n" . $e->getTraceAsString() . "</pre>";
    } else {
        http_response_code(500);
        require __DIR__ . '/../src/Views/templates/500.php';
    }
}
