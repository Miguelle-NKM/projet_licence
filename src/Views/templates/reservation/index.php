<?php
$title = 'Réservation';
ob_start();
?>

<div class="container py-5">
    <h1 class="text-center mb-5">Réservation de Chambre</h1>

    <div class="row">
        <div class="col-md-8">
            <form action="/reservation/create" method="POST" class="needs-validation" novalidate>
                <!-- Dates de séjour -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title h5 mb-0">Dates de séjour</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_start" class="form-label">Date d'arrivée</label>
                                <input type="date" class="form-control" id="date_start" name="date_start" 
                                       min="<?= date('Y-m-d') ?>" required>
                                <div class="invalid-feedback">
                                    Veuillez choisir une date d'arrivée.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_end" class="form-label">Date de départ</label>
                                <input type="date" class="form-control" id="date_end" name="date_end" 
                                       min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                                <div class="invalid-feedback">
                                    Veuillez choisir une date de départ.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations sur les voyageurs -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title h5 mb-0">Informations sur les voyageurs</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="num_guests" class="form-label">Nombre de personnes</label>
                            <select class="form-select" id="num_guests" name="num_guests" required>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?> personne<?= $i > 1 ? 's' : '' ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="invalid-feedback">
                                Veuillez sélectionner le nombre de personnes.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sélection des chambres -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title h5 mb-0">Sélection des chambres</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($availableRooms)): ?>
                            <div class="alert alert-warning">
                                Aucune chambre n'est disponible pour les dates sélectionnées.
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($availableRooms as $room): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= htmlspecialchars($room['type']) ?></h5>
                                                <p class="card-text">
                                                    <small>Chambre <?= htmlspecialchars($room['number']) ?></small><br>
                                                    Capacité: <?= $room['capacity'] ?> personnes<br>
                                                    Prix: <?= number_format($room['price_per_night'], 2) ?> €/nuit
                                                </p>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="rooms[]" value="<?= $room['id'] ?>" 
                                                           id="room_<?= $room['id'] ?>">
                                                    <label class="form-check-label" for="room_<?= $room['id'] ?>">
                                                        Sélectionner cette chambre
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Demandes spéciales -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title h5 mb-0">Demandes spéciales</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="special_requests" class="form-label">Avez-vous des demandes particulières ?</label>
                            <textarea class="form-control" id="special_requests" name="special_requests" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Réserver maintenant</button>
                </div>
            </form>
        </div>

        <div class="col-md-4">
            <!-- Résumé de la réservation -->
            <div class="card mb-4 sticky-top" style="top: 2rem;">
                <div class="card-header">
                    <h3 class="card-title h5 mb-0">Résumé de votre réservation</h3>
                </div>
                <div class="card-body">
                    <div id="booking-summary">
                        <p class="mb-2">Dates: <span id="summary-dates">-</span></p>
                        <p class="mb-2">Durée: <span id="summary-duration">-</span></p>
                        <p class="mb-2">Chambres: <span id="summary-rooms">-</span></p>
                        <p class="mb-2">Personnes: <span id="summary-guests">-</span></p>
                        <hr>
                        <p class="h5">Total estimé: <span id="summary-total">-</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const dateStart = document.getElementById('date_start');
    const dateEnd = document.getElementById('date_end');
    const numGuests = document.getElementById('num_guests');
    const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
    
    // Mise à jour du résumé
    function updateSummary() {
        const start = dateStart.value ? new Date(dateStart.value) : null;
        const end = dateEnd.value ? new Date(dateEnd.value) : null;
        const guests = numGuests.value;
        const selectedRooms = Array.from(roomCheckboxes).filter(cb => cb.checked);
        
        // Mise à jour des dates
        document.getElementById('summary-dates').textContent = 
            start && end ? `${start.toLocaleDateString()} - ${end.toLocaleDateString()}` : '-';
        
        // Calcul de la durée
        let duration = '-';
        if (start && end) {
            const nights = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            duration = `${nights} nuit${nights > 1 ? 's' : ''}`;
        }
        document.getElementById('summary-duration').textContent = duration;
        
        // Mise à jour des chambres
        document.getElementById('summary-rooms').textContent = 
            selectedRooms.length > 0 ? `${selectedRooms.length} chambre(s)` : '-';
        
        // Mise à jour des personnes
        document.getElementById('summary-guests').textContent = 
            `${guests} personne${guests > 1 ? 's' : ''}`;
        
        // Calcul du total
        let total = 0;
        if (start && end && selectedRooms.length > 0) {
            const nights = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            selectedRooms.forEach(room => {
                const price = parseFloat(room.closest('.card').querySelector('.card-text').textContent.match(/Prix: ([\d.]+)/)[1]);
                total += price * nights;
            });
        }
        document.getElementById('summary-total').textContent = 
            total > 0 ? `${total.toFixed(2)} €` : '-';
    }
    
    // Événements pour la mise à jour du résumé
    [dateStart, dateEnd, numGuests].forEach(el => {
        el.addEventListener('change', updateSummary);
    });
    
    roomCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSummary);
    });
    
    // Validation du formulaire
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        const selectedRooms = Array.from(roomCheckboxes).filter(cb => cb.checked);
        if (selectedRooms.length === 0) {
            event.preventDefault();
            alert('Veuillez sélectionner au moins une chambre.');
        }
        
        form.classList.add('was-validated');
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?> 