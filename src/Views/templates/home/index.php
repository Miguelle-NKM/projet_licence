<?php
// Protection contre l'accès direct au fichier
defined('BASE_PATH') or die('Accès direct au fichier non autorisé');
?>

<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 mb-4">Bienvenue à l'Hôtel</h1>
                <p class="lead mb-4">Découvrez le confort et le luxe dans notre établissement. Profitez de nos services haut de gamme et de notre hospitalité exceptionnelle.</p>
                <a href="/reservation" class="btn btn-primary btn-lg">Réserver maintenant</a>
            </div>
            <div class="col-md-6">
                <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/assets/images/chamb.jpg" class="d-block w-100" alt="Chambre luxueuse">
                        </div>
                        <div class="carousel-item">
                            <img src="/assets/images/Chamtar.jpg" class="d-block w-100" alt="Restaurant">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="featured-rooms py-5">
    <div class="container">
        <h2 class="text-center mb-5">Nos Chambres</h2>
        <div class="row">
            <?php foreach ($featuredRooms as $room): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($room['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($room['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($room['name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($room['description']) ?></p>
                        <p class="card-text"><strong>Prix: <?= number_format($room['price'], 2) ?> €/nuit</strong></p>
                        <a href="/rooms/<?= $room['id'] ?>" class="btn btn-outline-primary">Voir les détails</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="special-menus py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Notre Restaurant</h2>
        <div class="row">
            <?php foreach ($specialMenus as $menu): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($menu['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($menu['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($menu['name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($menu['description']) ?></p>
                        <p class="card-text"><strong>Prix: <?= number_format($menu['price'], 2) ?> €</strong></p>
                        <a href="/menu/<?= $menu['id'] ?>" class="btn btn-outline-primary">Voir le menu</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="features py-5">
    <div class="container">
        <h2 class="text-center mb-5">Nos Services</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-wifi fa-3x mb-3"></i>
                    <h4>WiFi Gratuit</h4>
                    <p>Connexion haut débit dans tout l'établissement</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-parking fa-3x mb-3"></i>
                    <h4>Parking Privé</h4>
                    <p>Stationnement sécurisé pour nos clients</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-concierge-bell fa-3x mb-3"></i>
                    <h4>Service en Chambre</h4>
                    <p>24/7 à votre disposition</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="mb-4">Réservez Votre Séjour Dès Maintenant</h2>
        <p class="lead mb-4">Profitez de nos offres spéciales et de nos tarifs préférentiels</p>
        <a href="/reservation" class="btn btn-light btn-lg">Réserver</a>
    </div>
</section>

<!-- Ajout des scripts Font Awesome -->
<script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script> 