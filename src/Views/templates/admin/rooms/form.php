<?php
// Formulaire de création/édition de chambre
$isEdit = $room->getId() !== null;
$pageTitle = $isEdit ? 'Modifier la Chambre' : 'Nouvelle Chambre';
$submitText = $isEdit ? 'Mettre à jour' : 'Créer';
$submitIcon = $isEdit ? 'fa-save' : 'fa-plus';
?>

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas <?= $isEdit ? 'fa-edit' : 'fa-plus' ?> me-2 text-primary"></i>
                        <?= $pageTitle ?>
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/rooms">Chambres</a></li>
                            <li class="breadcrumb-item active"><?= $isEdit ? 'Modifier' : 'Nouvelle' ?></li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="/admin/rooms" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bed me-2"></i>
                        Informations de la Chambre
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['errors'])): ?>
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Erreurs de validation :</h6>
                            <ul class="mb-0">
                                <?php foreach ($_SESSION['errors'] as $field => $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php unset($_SESSION['errors']); ?>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <!-- Numéro de chambre -->
                            <div class="col-md-6">
                                <label for="number" class="form-label fw-bold">
                                    <i class="fas fa-hashtag text-primary me-1"></i>
                                    Numéro de Chambre *
                                </label>
                                <input type="text"
                                    class="form-control form-control-lg"
                                    id="number"
                                    name="number"
                                    value="<?= htmlspecialchars($_SESSION['old_data']['number'] ?? $room->getNumber()) ?>"
                                    placeholder="Ex: 101, A-5, Suite-1"
                                    required>
                                <div class="invalid-feedback">
                                    Veuillez saisir un numéro de chambre.
                                </div>
                                <small class="form-text text-muted">
                                    Numéro unique d'identification de la chambre
                                </small>
                            </div>

                            <!-- Type de chambre -->
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-bold">
                                    <i class="fas fa-tag text-primary me-1"></i>
                                    Type de Chambre *
                                </label>
                                <select class="form-select form-select-lg" id="type" name="type" required>
                                    <option value="">Choisir un type...</option>
                                    <?php
                                    $selectedType = $_SESSION['old_data']['type'] ?? $room->getType();
                                    $types = [
                                        'standard' => 'Standard',
                                        'deluxe' => 'Deluxe',
                                        'suite' => 'Suite',
                                        'presidential' => 'Présidentielle'
                                    ];
                                    ?>
                                    <?php foreach ($types as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= $selectedType === $value ? 'selected' : '' ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner un type de chambre.
                                </div>
                            </div>

                            <!-- Capacité -->
                            <div class="col-md-6">
                                <label for="capacity" class="form-label fw-bold">
                                    <i class="fas fa-users text-primary me-1"></i>
                                    Capacité *
                                </label>
                                <div class="input-group input-group-lg">
                                    <button class="btn btn-outline-secondary" type="button" onclick="changeCapacity(-1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number"
                                        class="form-control text-center"
                                        id="capacity"
                                        name="capacity"
                                        value="<?= $_SESSION['old_data']['capacity'] ?? $room->getCapacity() ?>"
                                        min="1"
                                        max="10"
                                        required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="changeCapacity(1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <span class="input-group-text">personnes</span>
                                </div>
                                <div class="invalid-feedback">
                                    La capacité doit être entre 1 et 10 personnes.
                                </div>
                            </div>

                            <!-- Prix par nuit -->
                            <div class="col-md-6">
                                <label for="price_per_night" class="form-label fw-bold">
                                    <i class="fas fa-money-bill-wave text-primary me-1"></i>
                                    Prix par Nuit *
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="number"
                                        class="form-control"
                                        id="price_per_night"
                                        name="price_per_night"
                                        value="<?= $_SESSION['old_data']['price_per_night'] ?? $room->getPricePerNight() ?>"
                                        min="0"
                                        step="1000"
                                        placeholder="50000"
                                        required>
                                    <span class="input-group-text">FCFA</span>
                                </div>
                                <div class="invalid-feedback">
                                    Veuillez saisir un prix valide.
                                </div>
                                <small class="form-text text-muted">
                                    Prix en Francs CFA
                                </small>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-bold">
                                    <i class="fas fa-align-left text-primary me-1"></i>
                                    Description
                                </label>
                                <textarea class="form-control"
                                    id="description"
                                    name="description"
                                    rows="4"
                                    placeholder="Description détaillée de la chambre..."><?= htmlspecialchars($_SESSION['old_data']['description'] ?? $room->getDescription() ?? '') ?></textarea>
                                <small class="form-text text-muted">
                                    Décrivez les équipements, la vue, les services inclus...
                                </small>
                            </div>

                            <!-- Disponibilité -->
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_available"
                                        name="is_available"
                                        <?= ($_SESSION['old_data']['is_available'] ?? $room->isAvailable()) ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-bold" for="is_available">
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        Chambre disponible pour les réservations
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    Décochez pour rendre la chambre indisponible temporairement
                                </small>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="/admin/rooms" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times me-2"></i>Annuler
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas <?= $submitIcon ?> me-2"></i><?= $submitText ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Aperçu de la chambre -->
            <?php if ($isEdit): ?>
                <div class="card shadow mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-eye me-2"></i>
                            Aperçu de la Chambre
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <i class="fas fa-bed fa-3x text-primary mb-2"></i>
                                    <h4 class="text-primary"><?= htmlspecialchars($room->getNumber()) ?></h4>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h5><?= $room->getTypeBadge() ?> <?= $room->getStatusBadge() ?></h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-users me-2"></i>Capacité: <?= $room->getCapacity() ?> personnes
                                </p>
                                <p class="text-success mb-2">
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    <strong><?= $room->getFormattedPrice() ?></strong> par nuit
                                </p>
                                <?php if ($room->getDescription()): ?>
                                    <p class="text-muted small">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <?= htmlspecialchars($room->getDescription()) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Validation du formulaire
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.needs-validation');

        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Auto-formatage du prix
        const priceInput = document.getElementById('price_per_night');
        priceInput.addEventListener('input', function() {
            let value = this.value.replace(/\s/g, '');
            if (value) {
                this.value = parseInt(value).toLocaleString('fr-FR');
            }
        });

        // Formatage avant soumission
        form.addEventListener('submit', function() {
            priceInput.value = priceInput.value.replace(/\s/g, '');
        });
    });

    // Fonction pour changer la capacité
    function changeCapacity(change) {
        const input = document.getElementById('capacity');
        let currentValue = parseInt(input.value) || 1;
        let newValue = currentValue + change;

        if (newValue >= 1 && newValue <= 10) {
            input.value = newValue;
        }
    }

    // Animation de chargement
    document.querySelector('form').addEventListener('submit', function() {
        const submitBtn = document.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enregistrement...';
        submitBtn.disabled = true;

        // Restaurer après 5 secondes en cas d'erreur
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });
</script>

<?php
// Nettoyer les données de session
unset($_SESSION['old_data']);
?>