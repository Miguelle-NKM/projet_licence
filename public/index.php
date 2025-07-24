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
    'cookie_secure' => $_ENV['APP_ENV'] === 'production',
    'cookie_samesite' => 'Lax'
]);

// Gestion des routes
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Router basique
try {
    switch ($uri) {
        case '/':
            (new App\Controllers\HomeController())->index();
            break;
        case '/login':
            (new App\Controllers\AuthController())->login();
            break;
        case '/register':
            (new App\Controllers\AuthController())->register();
            break;
        case '/menu':
            (new App\Controllers\MenuController())->index();
            break;
        case '/reservation':
            (new App\Controllers\ReservationController())->index();
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/../src/Views/templates/404.php';
    }
} catch (Exception $e) {
    if ($_ENV['APP_ENV'] === 'development') {
        throw $e;
    }
    http_response_code(500);
    require __DIR__ . '/../src/Views/templates/500.php';
} 