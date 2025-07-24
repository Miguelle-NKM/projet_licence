<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gestion Hôtelière' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">🏨 Hôtel Prestige</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/menu">
                            <i class="fas fa-utensils me-1"></i>Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/reservation">
                            <i class="fas fa-calendar-alt me-1"></i>Réservation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">
                            <i class="fas fa-phone me-1"></i>Contact
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-tools me-1"></i>Administration
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/admin/dashboard">
                                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="/admin/rooms">
                                            <i class="fas fa-bed me-2"></i>Gestion Chambres
                                        </a></li>
                                    <li><a class="dropdown-item" href="/admin/menu">
                                            <i class="fas fa-utensils me-2"></i>Gestion Menu
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="/admin/rooms/create">
                                            <i class="fas fa-plus me-2"></i>Nouvelle Chambre
                                        </a></li>
                                    <li><a class="dropdown-item" href="/admin/menu/create">
                                            <i class="fas fa-plus me-2"></i>Nouvel Élément
                                        </a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">
                                <i class="fas fa-tachometer-alt me-1"></i>Tableau de bord
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">
                                <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">
                                <i class="fas fa-sign-in-alt me-1"></i>Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">
                                <i class="fas fa-user-plus me-1"></i>Inscription
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <footer class="bg-dark text-white mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-hotel me-2"></i>Hôtel Prestige</h5>
                    <p>Notre hôtel vous accueille dans un cadre chaleureux et confortable pour un séjour d'exception.</p>
                </div>
                <div class="col-md-4">
                    <h5><i class="fas fa-phone me-2"></i>Contact</h5>
                    <p>
                        <i class="fas fa-envelope me-2"></i>contact@hotel-prestige.com<br>
                        <i class="fas fa-phone me-2"></i>+33 1 23 45 67 89<br>
                        <i class="fas fa-map-marker-alt me-2"></i>123 Rue du Luxe, Paris
                    </p>
                </div>
                <div class="col-md-4">
                    <h5><i class="fas fa-link me-2"></i>Liens utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="/mentions-legales" class="text-white"><i class="fas fa-file-alt me-2"></i>Mentions légales</a></li>
                        <li><a href="/politique-confidentialite" class="text-white"><i class="fas fa-shield-alt me-2"></i>Politique de confidentialité</a></li>
                        <li><a href="/cgv" class="text-white"><i class="fas fa-file-contract me-2"></i>CGV</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2025 Hôtel Prestige. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fs-4"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fs-4"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fs-4"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-tripadvisor fs-4"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="/assets/js/main.js"></script>

    <script>
        // Initialisation des animations AOS
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>

</html>