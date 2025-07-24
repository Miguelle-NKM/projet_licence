<?php
// Vue d'accueil de l'hôtel avec Bootstrap 5
?>

<!-- Hero Section -->
<div class="hero-section bg-primary text-white py-5" style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.9), rgba(44, 62, 80, 0.9)), url('https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center; min-height: 70vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <h1 class="display-2 fw-bold mb-4 animate__animated animate__fadeInUp">
                    🏨 Hôtel Prestige
                </h1>
                <p class="lead fs-3 mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    Découvrez l'excellence de l'hospitalité française dans un cadre d'exception
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="/reservation" class="btn btn-light btn-lg px-5 py-3 shadow animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                        <i class="fas fa-calendar-alt me-2"></i>Réserver Maintenant
                    </a>
                    <a href="/menu" class="btn btn-outline-light btn-lg px-5 py-3 animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                        <i class="fas fa-utensils me-2"></i>Découvrir le Menu
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Chambres -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-4 fw-bold text-primary mb-3">Nos Chambres d'Exception</h2>
                <p class="lead text-muted mb-0">Confort, élégance et service personnalisé pour un séjour inoubliable</p>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($featuredRooms as $index => $room): ?>
                <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                    <div class="card h-100 shadow-lg border-0 overflow-hidden">
                        <div class="row g-0 h-100">
                            <div class="col-md-6">
                                <div class="position-relative h-100">
                                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                        class="img-fluid h-100 w-100"
                                        style="object-fit: cover;"
                                        alt="<?= htmlspecialchars($room['name']) ?>">
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-success fs-6 px-3 py-2">Disponible</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body h-100 d-flex flex-column p-4">
                                    <h3 class="card-title text-primary fw-bold mb-3"><?= htmlspecialchars($room['name']) ?></h3>
                                    <p class="card-text text-muted mb-4 flex-grow-1"><?= htmlspecialchars($room['description']) ?></p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="h4 text-success fw-bold"><?= number_format($room['price'], 0) ?>€</span>
                                            <small class="text-muted">/nuit</small>
                                        </div>
                                        <a href="/reservation?room=<?= $room['id'] ?>" class="btn btn-primary btn-lg">
                                            <i class="fas fa-calendar-plus me-2"></i>Réserver
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Section Restaurant -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <h2 class="display-4 fw-bold text-primary mb-4">Notre Cuisine Gastronomique</h2>
                <p class="lead text-muted mb-4">
                    Découvrez les saveurs authentiques de la cuisine française dans un cadre raffiné.
                    Nos chefs étoilés vous proposent une expérience culinaire exceptionnelle.
                </p>
                <a href="/menu" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-book-open me-2"></i>Voir le Menu Complet
                </a>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <?php foreach ($specialMenus as $index => $menu): ?>
                        <div class="col-sm-6" data-aos="zoom-in" data-aos-delay="<?= $index * 200 ?>">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                        <i class="fas <?= $index === 0 ? 'fa-crown' : 'fa-heart' ?> fs-3"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-primary"><?= htmlspecialchars($menu['name']) ?></h5>
                                    <p class="card-text text-muted small mb-3"><?= htmlspecialchars($menu['description']) ?></p>
                                    <span class="h5 text-success fw-bold"><?= number_format($menu['price'], 0) ?>€</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Services -->
<section class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-4 fw-bold mb-3">Services & Équipements</h2>
                <p class="lead mb-0">Tout pour rendre votre séjour parfait</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="text-center p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-swimming-pool text-white fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Piscine & Spa</h4>
                    <p class="text-light">Piscine chauffée, jacuzzi, sauna et centre de bien-être avec soins personnalisés</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-utensils text-white fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Restaurant Étoilé</h4>
                    <p class="text-light">Cuisine gastronomique française avec chef étoilé et service en chambre 24h/24</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-concierge-bell text-white fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Conciergerie Premium</h4>
                    <p class="text-light">Service de conciergerie personnalisé, réservations spectacles et excursions</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="text-center p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-wifi text-white fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3">WiFi Haut Débit</h4>
                    <p class="text-light">Connexion internet très haut débit gratuite dans tout l'établissement</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="800">
                <div class="text-center p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-car text-white fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Parking Privé</h4>
                    <p class="text-light">Parking sécurisé gratuit et service voiturier disponible</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="1000">
                <div class="text-center p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-dumbbell text-white fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Salle de Sport</h4>
                    <p class="text-light">Équipements modernes de fitness et cours collectifs avec coach personnel</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-4">Prêt pour une Expérience Inoubliable ?</h2>
                <p class="lead mb-4">Réservez dès maintenant et profitez de nos offres exclusives</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="/reservation" class="btn btn-light btn-lg px-5 py-3 shadow">
                        <i class="fas fa-calendar-check me-2"></i>Réserver Maintenant
                    </a>
                    <a href="/contact" class="btn btn-outline-light btn-lg px-5 py-3">
                        <i class="fas fa-phone me-2"></i>Nous Contacter
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts d'animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 1000,
            once: true
        });
    });
</script>