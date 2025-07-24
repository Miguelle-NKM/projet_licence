<?php
// Page de réservation avec Bootstrap 5
?>

<!-- Hero Section Réservation -->
<div class="bg-primary text-white py-5 mb-0" style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.9), rgba(44, 62, 80, 0.9)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <h1 class="display-3 fw-bold mb-3">📅 Réservation</h1>
                <p class="lead fs-4 mb-4">Réservez votre séjour dans notre établissement d'exception</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <span class="badge bg-light text-dark fs-6 px-4 py-2">Réservation Instantanée</span>
                    <span class="badge bg-light text-dark fs-6 px-4 py-2">Meilleur Prix Garanti</span>
                    <span class="badge bg-light text-dark fs-6 px-4 py-2">Annulation Gratuite</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulaire de Réservation -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Formulaire -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-primary text-white py-4">
                        <h3 class="mb-0 fw-bold">
                            <i class="fas fa-calendar-alt me-2"></i>Formulaire de Réservation
                        </h3>
                    </div>
                    <div class="card-body p-5">
                        <form id="reservationForm" method="POST" action="/reservation/create">
                            <!-- Informations Personnelles -->
                            <div class="mb-5">
                                <h4 class="text-primary fw-bold mb-4">
                                    <i class="fas fa-user me-2"></i>Informations Personnelles
                                </h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="firstName" class="form-label fw-bold">Prénom *</label>
                                        <input type="text" class="form-control form-control-lg" id="firstName" name="firstName" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label fw-bold">Nom *</label>
                                        <input type="text" class="form-control form-control-lg" id="lastName" name="lastName" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-bold">Email *</label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-bold">Téléphone *</label>
                                        <input type="tel" class="form-control form-control-lg" id="phone" name="phone" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Détails du Séjour -->
                            <div class="mb-5">
                                <h4 class="text-primary fw-bold mb-4">
                                    <i class="fas fa-bed me-2"></i>Détails du Séjour
                                </h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="checkIn" class="form-label fw-bold">Date d'arrivée *</label>
                                        <input type="date" class="form-control form-control-lg" id="checkIn" name="checkIn" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="checkOut" class="form-label fw-bold">Date de départ *</label>
                                        <input type="date" class="form-control form-control-lg" id="checkOut" name="checkOut" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="guests" class="form-label fw-bold">Nombre de personnes *</label>
                                        <select class="form-select form-select-lg" id="guests" name="guests" required>
                                            <option value="">Sélectionner...</option>
                                            <option value="1">1 personne</option>
                                            <option value="2">2 personnes</option>
                                            <option value="3">3 personnes</option>
                                            <option value="4">4 personnes</option>
                                            <option value="5">5 personnes</option>
                                            <option value="6">6 personnes ou plus</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="roomType" class="form-label fw-bold">Type de chambre *</label>
                                        <select class="form-select form-select-lg" id="roomType" name="roomType" required>
                                            <option value="">Sélectionner...</option>
                                            <option value="standard">Chambre Standard - 120€/nuit</option>
                                            <option value="deluxe">Chambre Deluxe - 180€/nuit</option>
                                            <option value="suite">Suite Junior - 250€/nuit</option>
                                            <option value="presidential">Suite Présidentielle - 450€/nuit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Options Supplémentaires -->
                            <div class="mb-5">
                                <h4 class="text-primary fw-bold mb-4">
                                    <i class="fas fa-plus-circle me-2"></i>Options Supplémentaires
                                </h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card h-100 border-primary">
                                            <div class="card-body text-center">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="breakfast" name="options[]" value="breakfast">
                                                    <label class="form-check-label fw-bold" for="breakfast">
                                                        <i class="fas fa-coffee text-warning me-2"></i>Petit-déjeuner<br>
                                                        <small class="text-muted">+25€/jour/personne</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card h-100 border-primary">
                                            <div class="card-body text-center">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="spa" name="options[]" value="spa">
                                                    <label class="form-check-label fw-bold" for="spa">
                                                        <i class="fas fa-spa text-success me-2"></i>Accès Spa<br>
                                                        <small class="text-muted">+50€/jour/personne</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card h-100 border-primary">
                                            <div class="card-body text-center">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="parking" name="options[]" value="parking">
                                                    <label class="form-check-label fw-bold" for="parking">
                                                        <i class="fas fa-car text-info me-2"></i>Parking Privé<br>
                                                        <small class="text-muted">+15€/jour</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card h-100 border-primary">
                                            <div class="card-body text-center">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="dinner" name="options[]" value="dinner">
                                                    <label class="form-check-label fw-bold" for="dinner">
                                                        <i class="fas fa-utensils text-danger me-2"></i>Dîner Gastronomique<br>
                                                        <small class="text-muted">+65€/jour/personne</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Demandes Spéciales -->
                            <div class="mb-5">
                                <h4 class="text-primary fw-bold mb-4">
                                    <i class="fas fa-comments me-2"></i>Demandes Spéciales
                                </h4>
                                <textarea class="form-control" rows="4" id="specialRequests" name="specialRequests" placeholder="Décrivez vos demandes spéciales (lit bébé, anniversaire, allergies alimentaires, etc.)"></textarea>
                            </div>

                            <!-- Bouton de Soumission -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                    <i class="fas fa-calendar-check me-2"></i>Confirmer la Réservation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Résumé de la Réservation -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-lg sticky-top" style="top: 20px;">
                    <div class="card-header bg-dark text-white py-4">
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-receipt me-2"></i>Résumé de Réservation
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div id="reservationSummary">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-info-circle fs-1 mb-3"></i>
                                <p>Veuillez remplir le formulaire pour voir le résumé de votre réservation</p>
                            </div>
                        </div>

                        <!-- Informations Utiles -->
                        <div class="mt-4 pt-4 border-top">
                            <h5 class="fw-bold text-primary mb-3">Informations Utiles</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-clock text-success me-2"></i>
                                    <small>Check-in: 15h00</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-clock text-danger me-2"></i>
                                    <small>Check-out: 11h00</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-ban text-warning me-2"></i>
                                    <small>Annulation gratuite 48h avant</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-shield-alt text-info me-2"></i>
                                    <small>Paiement sécurisé</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Garanties -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-12 mb-5">
                <h2 class="display-5 fw-bold text-primary">Nos Garanties</h2>
                <p class="lead text-muted">Réservez en toute confiance</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-shield-alt fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Paiement Sécurisé</h5>
                        <p class="text-muted small">Transactions protégées par cryptage SSL</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-undo fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Annulation Flexible</h5>
                        <p class="text-muted small">Annulation gratuite jusqu'à 48h avant</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-medal fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Meilleur Prix</h5>
                        <p class="text-muted small">Nous garantissons le meilleur tarif</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-headset fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Support 24/7</h5>
                        <p class="text-muted small">Assistance disponible à tout moment</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript pour calcul dynamique -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('reservationForm');
        const summaryDiv = document.getElementById('reservationSummary');

        // Prix des chambres
        const roomPrices = {
            'standard': 120,
            'deluxe': 180,
            'suite': 250,
            'presidential': 450
        };

        // Prix des options
        const optionPrices = {
            'breakfast': 25,
            'spa': 50,
            'parking': 15,
            'dinner': 65
        };

        function calculateTotal() {
            const checkIn = new Date(document.getElementById('checkIn').value);
            const checkOut = new Date(document.getElementById('checkOut').value);
            const guests = parseInt(document.getElementById('guests').value) || 0;
            const roomType = document.getElementById('roomType').value;
            const selectedOptions = Array.from(document.querySelectorAll('input[name="options[]"]:checked'));

            if (!checkIn || !checkOut || !roomType || guests === 0) {
                summaryDiv.innerHTML = `
                <div class="text-center text-muted py-4">
                    <i class="fas fa-info-circle fs-1 mb-3"></i>
                    <p>Veuillez remplir le formulaire pour voir le résumé</p>
                </div>
            `;
                return;
            }

            const timeDiff = checkOut.getTime() - checkIn.getTime();
            const days = Math.ceil(timeDiff / (1000 * 3600 * 24));

            if (days <= 0) {
                summaryDiv.innerHTML = `
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    La date de départ doit être postérieure à la date d'arrivée
                </div>
            `;
                return;
            }

            const roomPrice = roomPrices[roomType] || 0;
            const roomTotal = roomPrice * days;

            let optionsTotal = 0;
            let optionsHtml = '';

            selectedOptions.forEach(option => {
                const optionValue = option.value;
                const optionPrice = optionPrices[optionValue] || 0;
                let optionTotal = 0;

                if (optionValue === 'parking') {
                    optionTotal = optionPrice * days;
                } else {
                    optionTotal = optionPrice * days * guests;
                }

                optionsTotal += optionTotal;

                const optionNames = {
                    'breakfast': 'Petit-déjeuner',
                    'spa': 'Accès Spa',
                    'parking': 'Parking Privé',
                    'dinner': 'Dîner Gastronomique'
                };

                optionsHtml += `
                <div class="d-flex justify-content-between mb-2">
                    <span>${optionNames[optionValue]}</span>
                    <span>${optionTotal}€</span>
                </div>
            `;
            });

            const total = roomTotal + optionsTotal;

            summaryDiv.innerHTML = `
            <div class="reservation-details">
                <h5 class="fw-bold mb-3 text-primary">Détails du Séjour</h5>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Dates:</span>
                        <span class="fw-bold">${checkIn.toLocaleDateString('fr-FR')} - ${checkOut.toLocaleDateString('fr-FR')}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Durée:</span>
                        <span class="fw-bold">${days} nuit${days > 1 ? 's' : ''}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Personnes:</span>
                        <span class="fw-bold">${guests}</span>
                    </div>
                </div>
                
                <hr>
                
                <h5 class="fw-bold mb-3 text-primary">Tarification</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span>Chambre (${days} nuit${days > 1 ? 's' : ''})</span>
                    <span>${roomTotal}€</span>
                </div>
                ${optionsHtml}
                
                <hr>
                
                <div class="d-flex justify-content-between mb-3">
                    <span class="h5 fw-bold">Total</span>
                    <span class="h5 fw-bold text-success">${total}€</span>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>Prix TTC, taxe de séjour incluse</small>
                </div>
            </div>
        `;
        }

        // Écouteurs d'événements pour recalculer automatiquement
        ['checkIn', 'checkOut', 'guests', 'roomType'].forEach(id => {
            document.getElementById(id).addEventListener('change', calculateTotal);
        });

        document.querySelectorAll('input[name="options[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', calculateTotal);
        });

        // Validation des dates
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('checkIn').min = today;

        document.getElementById('checkIn').addEventListener('change', function() {
            const checkInDate = this.value;
            if (checkInDate) {
                const nextDay = new Date(checkInDate);
                nextDay.setDate(nextDay.getDate() + 1);
                document.getElementById('checkOut').min = nextDay.toISOString().split('T')[0];
            }
        });
    });
</script>