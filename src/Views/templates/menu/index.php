<?php
// Page de menu avec Bootstrap 5
?>

<!-- Hero Section du Menu -->
<div class="bg-primary text-white py-5 mb-0" style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.9), rgba(44, 62, 80, 0.9)), url('https://images.unsplash.com/photo-1600891964092-4316c288032e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <h1 class="display-3 fw-bold mb-3">🍽️ Notre Carte Gastronomique</h1>
                <p class="lead fs-4 mb-4">Une cuisine française raffinée par nos chefs étoilés</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <span class="badge bg-light text-dark fs-6 px-4 py-2">Produits Frais</span>
                    <span class="badge bg-light text-dark fs-6 px-4 py-2">Cuisine Traditionnelle</span>
                    <span class="badge bg-light text-dark fs-6 px-4 py-2">Chef Étoilé</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navigation des Catégories -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid justify-content-center">
                        <ul class="navbar-nav gap-3">
                            <li class="nav-item">
                                <a class="nav-link text-primary fw-bold border rounded px-4 py-2 menu-filter active"
                                    href="#" data-filter="all">
                                    <i class="fas fa-utensils me-2"></i>Tous les Plats
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-primary fw-bold border rounded px-4 py-2 menu-filter"
                                    href="#" data-filter="entrees">
                                    <i class="fas fa-leaf me-2"></i>Entrées
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-primary fw-bold border rounded px-4 py-2 menu-filter"
                                    href="#" data-filter="plats">
                                    <i class="fas fa-drumstick-bite me-2"></i>Plats Principaux
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-primary fw-bold border rounded px-4 py-2 menu-filter"
                                    href="#" data-filter="desserts">
                                    <i class="fas fa-ice-cream me-2"></i>Desserts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-primary fw-bold border rounded px-4 py-2 menu-filter"
                                    href="#" data-filter="boissons">
                                    <i class="fas fa-wine-glass me-2"></i>Boissons
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Menu Items -->
<section class="py-5">
    <div class="container">
        <!-- Entrées -->
        <div class="menu-category" data-category="entrees">
            <div class="row mb-5">
                <div class="col-12 text-center mb-4">
                    <h2 class="display-5 fw-bold text-primary mb-3">🥗 Entrées Raffinées</h2>
                    <p class="lead text-muted">Pour commencer votre expérience culinaire</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="row g-0 h-100">
                            <div class="col-md-4">
                                <img src="https://images.unsplash.com/photo-1551782450-a2132b4ba21d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                                    class="img-fluid h-100 rounded-start" style="object-fit: cover;" alt="Foie Gras">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body h-100 d-flex flex-column">
                                    <h5 class="card-title text-primary fw-bold">Foie Gras de Canard</h5>
                                    <p class="card-text text-muted flex-grow-1">Poêlé aux figues confites et pain brioché maison</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-success fw-bold mb-0">32€</span>
                                        <span class="badge bg-warning text-dark">Spécialité</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="row g-0 h-100">
                            <div class="col-md-4">
                                <img src="https://images.unsplash.com/photo-1559847844-d05ce9b68ebc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                                    class="img-fluid h-100 rounded-start" style="object-fit: cover;" alt="Tartare de Saumon">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body h-100 d-flex flex-column">
                                    <h5 class="card-title text-primary fw-bold">Tartare de Saumon</h5>
                                    <p class="card-text text-muted flex-grow-1">À l'avocat, citron vert et crème fraîche aux herbes</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-success fw-bold mb-0">24€</span>
                                        <span class="badge bg-info text-white">Frais</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plats Principaux -->
        <div class="menu-category mt-5" data-category="plats">
            <div class="row mb-5">
                <div class="col-12 text-center mb-4">
                    <h2 class="display-5 fw-bold text-primary mb-3">🥩 Plats Principaux</h2>
                    <p class="lead text-muted">Le cœur de notre art culinaire</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="row g-0 h-100">
                            <div class="col-md-4">
                                <img src="https://images.unsplash.com/photo-1546833999-b9f581a1996d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                                    class="img-fluid h-100 rounded-start" style="object-fit: cover;" alt="Boeuf Bourguignon">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body h-100 d-flex flex-column">
                                    <h5 class="card-title text-primary fw-bold">Bœuf Bourguignon</h5>
                                    <p class="card-text text-muted flex-grow-1">Mijoté 24h, légumes de saison et pommes grenaille</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-success fw-bold mb-0">42€</span>
                                        <span class="badge bg-danger text-white">Signature</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="row g-0 h-100">
                            <div class="col-md-4">
                                <img src="https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                                    class="img-fluid h-100 rounded-start" style="object-fit: cover;" alt="Saumon Grillé">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body h-100 d-flex flex-column">
                                    <h5 class="card-title text-primary fw-bold">Saumon Grillé</h5>
                                    <p class="card-text text-muted flex-grow-1">Sauce hollandaise, quinoa aux légumes croquants</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-success fw-bold mb-0">38€</span>
                                        <span class="badge bg-success text-white">Healthy</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desserts -->
        <div class="menu-category mt-5" data-category="desserts">
            <div class="row mb-5">
                <div class="col-12 text-center mb-4">
                    <h2 class="display-5 fw-bold text-primary mb-3">🍰 Desserts Gourmands</h2>
                    <p class="lead text-muted">La touche finale parfaite</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="row g-0 h-100">
                            <div class="col-md-4">
                                <img src="https://images.unsplash.com/photo-1571115764595-644a1f56a55c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                                    class="img-fluid h-100 rounded-start" style="object-fit: cover;" alt="Tarte Tatin">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body h-100 d-flex flex-column">
                                    <h5 class="card-title text-primary fw-bold">Tarte Tatin Maison</h5>
                                    <p class="card-text text-muted flex-grow-1">Pommes caramélisées, glace vanille de Madagascar</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-success fw-bold mb-0">16€</span>
                                        <span class="badge bg-warning text-dark">Traditionnel</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="row g-0 h-100">
                            <div class="col-md-4">
                                <img src="https://images.unsplash.com/photo-1587668178277-295251f900ce?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                                    class="img-fluid h-100 rounded-start" style="object-fit: cover;" alt="Mousse Chocolat">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body h-100 d-flex flex-column">
                                    <h5 class="card-title text-primary fw-bold">Mousse au Chocolat</h5>
                                    <p class="card-text text-muted flex-grow-1">Chocolat noir 70%, chantilly vanillée, biscuits</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-success fw-bold mb-0">14€</span>
                                        <span class="badge bg-dark text-white">Intense</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Menu du Jour -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold text-primary mb-4">🌟 Menu du Jour</h2>
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <h3 class="text-primary fw-bold mb-4">Menu Découverte 3 Services</h3>
                        <div class="row text-start">
                            <div class="col-md-6">
                                <h5 class="text-muted mb-3">Entrée du Jour</h5>
                                <p class="mb-4">Velouté de champignons aux truffes</p>

                                <h5 class="text-muted mb-3">Plat du Jour</h5>
                                <p class="mb-4">Magret de canard, purée de patates douces</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-muted mb-3">Dessert du Jour</h5>
                                <p class="mb-4">Crème brûlée aux fruits de saison</p>

                                <div class="text-center mt-4">
                                    <span class="h3 text-success fw-bold">48€</span>
                                    <p class="text-muted small">par personne</p>
                                </div>
                            </div>
                        </div>
                        <a href="/reservation" class="btn btn-primary btn-lg px-5 py-3">
                            <i class="fas fa-calendar-plus me-2"></i>Réserver une Table
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-6 fw-bold mb-4">Envie de Découvrir Nos Saveurs ?</h2>
                <p class="lead mb-4">Réservez votre table dès maintenant et laissez-vous séduire par notre cuisine d'exception</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="/reservation" class="btn btn-light btn-lg px-5 py-3 shadow">
                        <i class="fas fa-utensils me-2"></i>Réserver une Table
                    </a>
                    <a href="/contact" class="btn btn-outline-light btn-lg px-5 py-3">
                        <i class="fas fa-phone me-2"></i>Nous Contacter
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript pour le filtrage -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Filtrage du menu
        const filterButtons = document.querySelectorAll('.menu-filter');
        const menuCategories = document.querySelectorAll('.menu-category');

        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Retirer la classe active de tous les boutons
                filterButtons.forEach(btn => btn.classList.remove('active', 'bg-primary', 'text-white'));

                // Ajouter la classe active au bouton cliqué
                this.classList.add('active', 'bg-primary', 'text-white');

                // Obtenir le filtre
                const filter = this.getAttribute('data-filter');

                // Afficher/masquer les catégories
                menuCategories.forEach(category => {
                    if (filter === 'all' || category.getAttribute('data-category') === filter) {
                        category.style.display = 'block';
                        category.style.animation = 'fadeIn 0.5s ease-in-out';
                    } else {
                        category.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .menu-filter:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    .menu-filter.active {
        background-color: var(--bs-primary) !important;
        color: white !important;
    }
</style>