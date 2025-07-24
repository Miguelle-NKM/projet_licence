<?php
// Page de contact avec Bootstrap 5
?>

<!-- Hero Section Contact -->
<div class="bg-primary text-white py-5 mb-0" style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.9), rgba(44, 62, 80, 0.9)), url('https://images.unsplash.com/photo-1577563908411-5077b6dc7624?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <h1 class="display-3 fw-bold mb-3">📞 Contactez-Nous</h1>
                <p class="lead fs-4 mb-4">Notre équipe est à votre écoute pour répondre à toutes vos questions</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <span class="badge bg-light text-dark fs-6 px-4 py-2">Réponse sous 24h</span>
                    <span class="badge bg-light text-dark fs-6 px-4 py-2">Support 7j/7</span>
                    <span class="badge bg-light text-dark fs-6 px-4 py-2">Conseils Personnalisés</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section principale -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Formulaire de contact -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-primary text-white py-4">
                        <h3 class="mb-0 fw-bold">
                            <i class="fas fa-envelope me-2"></i>Envoyez-nous un Message
                        </h3>
                    </div>
                    <div class="card-body p-5">
                        <form id="contactForm" method="POST" action="/contact/send" class="needs-validation" novalidate>
                            <!-- Informations de contact -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label fw-bold">
                                        <i class="fas fa-user text-primary me-2"></i>Prénom *
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="firstName" name="firstName"
                                        placeholder="Jean" required>
                                    <div class="invalid-feedback">
                                        Veuillez saisir votre prénom.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label fw-bold">
                                        <i class="fas fa-user text-primary me-2"></i>Nom *
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="lastName" name="lastName"
                                        placeholder="Dupont" required>
                                    <div class="invalid-feedback">
                                        Veuillez saisir votre nom.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold">
                                        <i class="fas fa-envelope text-primary me-2"></i>Email *
                                    </label>
                                    <input type="email" class="form-control form-control-lg" id="email" name="email"
                                        placeholder="jean@example.com" required>
                                    <div class="invalid-feedback">
                                        Veuillez saisir une adresse email valide.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-bold">
                                        <i class="fas fa-phone text-primary me-2"></i>Téléphone
                                    </label>
                                    <input type="tel" class="form-control form-control-lg" id="phone" name="phone"
                                        placeholder="06 12 34 56 78">
                                </div>
                            </div>

                            <!-- Sujet -->
                            <div class="mb-4">
                                <label for="subject" class="form-label fw-bold">
                                    <i class="fas fa-tag text-primary me-2"></i>Sujet *
                                </label>
                                <select class="form-select form-select-lg" id="subject" name="subject" required>
                                    <option value="">Sélectionnez un sujet...</option>
                                    <option value="reservation">Demande de réservation</option>
                                    <option value="information">Demande d'information</option>
                                    <option value="event">Organisation d'événement</option>
                                    <option value="complaint">Réclamation</option>
                                    <option value="compliment">Compliment</option>
                                    <option value="other">Autre</option>
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner un sujet.
                                </div>
                            </div>

                            <!-- Message -->
                            <div class="mb-4">
                                <label for="message" class="form-label fw-bold">
                                    <i class="fas fa-comments text-primary me-2"></i>Votre Message *
                                </label>
                                <textarea class="form-control" id="message" name="message" rows="6"
                                    placeholder="Décrivez votre demande en détail..." required></textarea>
                                <div class="form-text">
                                    <small><span id="charCount">0</span>/1000 caractères</small>
                                </div>
                                <div class="invalid-feedback">
                                    Veuillez saisir votre message.
                                </div>
                            </div>

                            <!-- Options -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        <i class="fas fa-newspaper me-2"></i>
                                        J'aimerais recevoir la newsletter avec les offres spéciales
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="callback" name="callback">
                                    <label class="form-check-label" for="callback">
                                        <i class="fas fa-phone me-2"></i>
                                        Je souhaite être rappelé(e) par téléphone
                                    </label>
                                </div>
                            </div>

                            <!-- Bouton d'envoi -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                    <i class="fas fa-paper-plane me-2"></i>Envoyer le Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Informations de contact -->
            <div class="col-lg-4">
                <!-- Coordonnées -->
                <div class="card border-0 shadow-lg mb-4">
                    <div class="card-header bg-dark text-white py-4">
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-map-marker-alt me-2"></i>Nos Coordonnées
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-building me-2"></i>Adresse
                            </h5>
                            <p class="mb-0">
                                Hôtel Prestige<br>
                                123 Rue du Luxe<br>
                                75001 Paris, France
                            </p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-phone me-2"></i>Téléphone
                            </h5>
                            <p class="mb-0">
                                <a href="tel:+33123456789" class="text-decoration-none">
                                    +33 1 23 45 67 89
                                </a>
                            </p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-envelope me-2"></i>Email
                            </h5>
                            <p class="mb-0">
                                <a href="mailto:contact@hotel-prestige.com" class="text-decoration-none">
                                    contact@hotel-prestige.com
                                </a>
                            </p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-clock me-2"></i>Horaires d'Accueil
                            </h5>
                            <p class="mb-1">Lundi - Dimanche</p>
                            <p class="mb-0"><strong>24h/24</strong></p>
                        </div>

                        <div>
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-share-alt me-2"></i>Réseaux Sociaux
                            </h5>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-tripadvisor"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Horaires des services -->
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-success text-white py-4">
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-concierge-bell me-2"></i>Horaires des Services
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-utensils text-warning me-2"></i>Restaurant</span>
                                <span class="text-muted">12h-14h / 19h-22h</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-spa text-success me-2"></i>Spa</span>
                                <span class="text-muted">9h-21h</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-swimming-pool text-info me-2"></i>Piscine</span>
                                <span class="text-muted">6h-23h</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-dumbbell text-danger me-2"></i>Salle de Sport</span>
                                <span class="text-muted">24h/24</span>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-headset text-primary me-2"></i>Conciergerie</span>
                                <span class="text-muted">24h/24</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Carte -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 fw-bold text-primary">🗺️ Comment Nous Trouver</h2>
                <p class="lead text-muted">Idéalement situé au cœur de Paris</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Carte intégrée (exemple avec OpenStreetMap) -->
                        <div style="height: 400px; background: linear-gradient(45deg, #f8f9fa, #e9ecef); display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                            <div class="text-center">
                                <i class="fas fa-map-marked-alt fs-1 text-primary mb-3"></i>
                                <h4 class="text-primary">Carte Interactive</h4>
                                <p class="text-muted">Intégration Google Maps ou OpenStreetMap</p>
                                <a href="https://maps.google.com/?q=Paris" target="_blank" class="btn btn-primary">
                                    <i class="fas fa-external-link-alt me-2"></i>Voir sur Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-lg h-100">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-primary mb-4">
                            <i class="fas fa-route me-2"></i>Comment S'y Rendre
                        </h4>

                        <div class="mb-4">
                            <h5 class="fw-bold">
                                <i class="fas fa-subway text-primary me-2"></i>En Métro
                            </h5>
                            <p class="text-muted">
                                Ligne 1 : Station Louvre-Rivoli<br>
                                Ligne 7 : Station Pont Neuf<br>
                                <small>À 5 minutes à pied</small>
                            </p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold">
                                <i class="fas fa-car text-success me-2"></i>En Voiture
                            </h5>
                            <p class="text-muted">
                                Parking privé disponible<br>
                                Service voiturier<br>
                                <small>15€/jour</small>
                            </p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold">
                                <i class="fas fa-plane text-info me-2"></i>Depuis l'Aéroport
                            </h5>
                            <p class="text-muted">
                                CDG : 45 minutes en RER B<br>
                                Orly : 35 minutes en Orlyval<br>
                                <small>Navette sur demande</small>
                            </p>
                        </div>

                        <div class="text-center">
                            <a href="/contact" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-phone me-2"></i>Nous Appeler
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 fw-bold text-primary">❓ Questions Fréquentes</h2>
                <p class="lead text-muted">Les réponses aux questions les plus courantes</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="fas fa-clock text-primary me-3"></i>
                                Quels sont les horaires de check-in et check-out ?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Le check-in est possible à partir de 15h00 et le check-out jusqu'à 11h00.
                                Un service de bagagerie gratuit est disponible si vous arrivez plus tôt ou repartez plus tard.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="fas fa-wifi text-primary me-3"></i>
                                Le WiFi est-il inclus ?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Oui, le WiFi haut débit est gratuit dans tout l'établissement,
                                y compris dans les chambres, espaces communs et zones de détente.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="fas fa-paw text-primary me-3"></i>
                                Les animaux sont-ils acceptés ?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Oui, nous accueillons vos compagnons à quatre pattes avec plaisir.
                                Un supplément de 20€/nuit s'applique avec des services dédiés (panier, gamelles, etc.).
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                <i class="fas fa-ban text-primary me-3"></i>
                                Quelle est la politique d'annulation ?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Annulation gratuite jusqu'à 48h avant l'arrivée.
                                Au-delà, une nuit sera facturée. Les réservations non remboursables bénéficient de tarifs préférentiels.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        const messageField = document.getElementById('message');
        const charCount = document.getElementById('charCount');

        // Compteur de caractères
        messageField.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;

            if (count > 1000) {
                charCount.style.color = '#dc3545';
                this.setCustomValidity('Le message ne peut pas dépasser 1000 caractères');
            } else {
                charCount.style.color = '#6c757d';
                this.setCustomValidity('');
            }
        });

        // Validation du formulaire
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>