<?php
// Formulaire de création/édition d'élément de menu
$isEdit = $menuItem->getId() !== null;
$pageTitle = $isEdit ? 'Modifier l\'Élément' : 'Nouvel Élément du Menu';
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
                            <li class="breadcrumb-item"><a href="/admin/menu">Menu</a></li>
                            <li class="breadcrumb-item active"><?= $isEdit ? 'Modifier' : 'Nouveau' ?></li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="/admin/menu" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Formulaire principal -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-utensils me-2"></i>
                        Informations de l'Élément
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
                            <!-- Nom du plat -->
                            <div class="col-12">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-signature text-primary me-1"></i>
                                    Nom du Plat *
                                </label>
                                <input type="text"
                                    class="form-control form-control-lg"
                                    id="name"
                                    name="name"
                                    value="<?= htmlspecialchars($_SESSION['old_data']['name'] ?? $menuItem->getName()) ?>"
                                    placeholder="Ex: Poulet DG, Salade César..."
                                    required>
                                <div class="invalid-feedback">
                                    Veuillez saisir le nom du plat.
                                </div>
                            </div>

                            <!-- Catégorie et Prix -->
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-bold">
                                    <i class="fas fa-tags text-primary me-1"></i>
                                    Catégorie *
                                </label>
                                <select class="form-select form-select-lg" id="category" name="category" required>
                                    <option value="">Choisir une catégorie...</option>
                                    <?php
                                    $selectedCategory = $_SESSION['old_data']['category'] ?? $menuItem->getCategory();
                                    ?>
                                    <?php foreach ($categories as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= $selectedCategory === $value ? 'selected' : '' ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner une catégorie.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="price" class="form-label fw-bold">
                                    <i class="fas fa-money-bill-wave text-primary me-1"></i>
                                    Prix *
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="number"
                                        class="form-control"
                                        id="price"
                                        name="price"
                                        value="<?= $_SESSION['old_data']['price'] ?? $menuItem->getPrice() ?>"
                                        min="0"
                                        step="500"
                                        placeholder="5000"
                                        required>
                                    <span class="input-group-text">FCFA</span>
                                </div>
                                <div class="invalid-feedback">
                                    Veuillez saisir un prix valide.
                                </div>
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
                                    placeholder="Décrivez les ingrédients, la préparation, les accompagnements..."><?= htmlspecialchars($_SESSION['old_data']['description'] ?? $menuItem->getDescription() ?? '') ?></textarea>
                                <small class="form-text text-muted">
                                    Une description attrayante aide les clients à faire leur choix
                                </small>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <span id="charCount">0</span>/1000 caractères
                                    </small>
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="col-12">
                                <label for="image_path" class="form-label fw-bold">
                                    <i class="fas fa-image text-primary me-1"></i>
                                    URL de l'Image
                                </label>
                                <input type="url"
                                    class="form-control"
                                    id="image_path"
                                    name="image_path"
                                    value="<?= htmlspecialchars($_SESSION['old_data']['image_path'] ?? $menuItem->getImagePath() ?? '') ?>"
                                    placeholder="https://exemple.com/image.jpg">
                                <small class="form-text text-muted">
                                    URL vers une image du plat (optionnel)
                                </small>
                            </div>

                            <!-- Disponibilité -->
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_available"
                                        name="is_available"
                                        <?= ($_SESSION['old_data']['is_available'] ?? $menuItem->isAvailable()) ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-bold" for="is_available">
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        Élément disponible sur le menu
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    Décochez pour retirer temporairement cet élément du menu
                                </small>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="/admin/menu" class="btn btn-outline-secondary btn-lg">
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
        </div>

        <!-- Aperçu et conseils -->
        <div class="col-lg-4">
            <!-- Aperçu en temps réel -->
            <div class="card shadow mb-4" id="previewCard">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>
                        Aperçu
                    </h5>
                </div>
                <div class="card-body">
                    <div class="position-relative">
                        <img id="previewImage"
                            src="<?= $menuItem->getImageUrl() ?>"
                            class="card-img-top rounded"
                            alt="Aperçu"
                            style="height: 150px; object-fit: cover;"
                            onerror="this.src='/assets/images/default-menu.jpg'">

                        <div class="position-absolute top-0 end-0 p-2">
                            <span id="previewStatus" class="badge bg-success">Disponible</span>
                        </div>

                        <div class="position-absolute top-0 start-0 p-2">
                            <span id="previewCategory" class="badge bg-primary">Catégorie</span>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 id="previewName" class="card-title mb-1">
                                <?= htmlspecialchars($menuItem->getName() ?: 'Nom du plat') ?>
                            </h6>
                            <span id="previewPrice" class="text-success fw-bold">
                                <?= $menuItem->getFormattedPrice() ?: '0 FCFA' ?>
                            </span>
                        </div>
                        <p id="previewDescription" class="text-muted small">
                            <?= htmlspecialchars($menuItem->getDescription() ?: 'Aucune description') ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Conseils -->
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        Conseils
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary">📸 Images</h6>
                        <small class="text-muted">
                            Utilisez des images de haute qualité qui mettent en valeur le plat.
                            Évitez les images floues ou mal éclairées.
                        </small>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-primary">📝 Description</h6>
                        <small class="text-muted">
                            Mentionnez les ingrédients principaux, la méthode de cuisson,
                            et ce qui rend ce plat spécial.
                        </small>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-primary">💰 Prix</h6>
                        <small class="text-muted">
                            Assurez-vous que le prix est compétitif et reflète
                            la qualité et la quantité du plat.
                        </small>
                    </div>

                    <div>
                        <h6 class="text-primary">🏷️ Catégorie</h6>
                        <small class="text-muted">
                            Choisissez la catégorie appropriée pour aider
                            les clients à naviguer facilement dans le menu.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.needs-validation');
        const nameInput = document.getElementById('name');
        const categorySelect = document.getElementById('category');
        const priceInput = document.getElementById('price');
        const descriptionTextarea = document.getElementById('description');
        const imageInput = document.getElementById('image_path');
        const availabilityCheckbox = document.getElementById('is_available');

        // Éléments de l'aperçu
        const previewName = document.getElementById('previewName');
        const previewCategory = document.getElementById('previewCategory');
        const previewPrice = document.getElementById('previewPrice');
        const previewDescription = document.getElementById('previewDescription');
        const previewImage = document.getElementById('previewImage');
        const previewStatus = document.getElementById('previewStatus');

        // Couleurs des badges par catégorie
        const categoryColors = {
            'entree': 'primary',
            'plat': 'warning',
            'dessert': 'success',
            'boisson': 'info',
            'alcool': 'danger',
            'vin': 'danger'
        };

        // Mise à jour de l'aperçu en temps réel
        function updatePreview() {
            previewName.textContent = nameInput.value || 'Nom du plat';

            const selectedCategory = categorySelect.value;
            if (selectedCategory) {
                const categoryText = categorySelect.options[categorySelect.selectedIndex].text;
                const categoryColor = categoryColors[selectedCategory] || 'secondary';
                previewCategory.textContent = categoryText;
                previewCategory.className = `badge bg-${categoryColor}`;
            }

            const price = parseFloat(priceInput.value) || 0;
            previewPrice.textContent = price.toLocaleString('fr-FR') + ' FCFA';

            previewDescription.textContent = descriptionTextarea.value || 'Aucune description';

            if (imageInput.value) {
                previewImage.src = imageInput.value;
            }

            previewStatus.textContent = availabilityCheckbox.checked ? 'Disponible' : 'Indisponible';
            previewStatus.className = availabilityCheckbox.checked ? 'badge bg-success' : 'badge bg-danger';
        }

        // Compteur de caractères
        function updateCharCount() {
            const count = descriptionTextarea.value.length;
            document.getElementById('charCount').textContent = count;

            const charCountElement = document.getElementById('charCount');
            if (count > 1000) {
                charCountElement.classList.add('text-danger');
            } else if (count > 800) {
                charCountElement.classList.add('text-warning');
            } else {
                charCountElement.classList.remove('text-danger', 'text-warning');
            }
        }

        // Écouteurs d'événements pour l'aperçu
        nameInput.addEventListener('input', updatePreview);
        categorySelect.addEventListener('change', updatePreview);
        priceInput.addEventListener('input', updatePreview);
        descriptionTextarea.addEventListener('input', function() {
            updatePreview();
            updateCharCount();
        });
        imageInput.addEventListener('input', updatePreview);
        availabilityCheckbox.addEventListener('change', updatePreview);

        // Validation du formulaire
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Auto-formatage du prix
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

        // Initialiser l'aperçu et le compteur
        updatePreview();
        updateCharCount();

        // Animation de chargement
        form.addEventListener('submit', function() {
            const submitBtn = document.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enregistrement...';
            submitBtn.disabled = true;

            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });
    });
</script>

<?php
// Nettoyer les données de session
unset($_SESSION['old_data']);
?>