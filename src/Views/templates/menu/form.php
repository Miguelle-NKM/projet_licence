<?php
// Ce template est utilisé à la fois pour la création et la modification
$isEdit = isset($menu);
$formAction = $isEdit ? "/menu/edit/{$menu['id']}" : "/menu/create";
?>

<div class="container py-5">
    <h1 class="text-center mb-5">
        <?= $isEdit ? 'Modifier le menu' : 'Ajouter un menu' ?>
    </h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="<?= $formAction ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <!-- Nom du menu -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom du menu *</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="<?= $isEdit ? htmlspecialchars($menu['name']) : '' ?>"
                                   required maxlength="100">
                            <div class="invalid-feedback">
                                Le nom du menu est requis et doit contenir moins de 100 caractères.
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= $isEdit ? htmlspecialchars($menu['description']) : '' ?></textarea>
                        </div>

                        <!-- Prix -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Prix (€) *</label>
                            <input type="number" class="form-control" id="price" name="price"
                                   value="<?= $isEdit ? htmlspecialchars($menu['price']) : '' ?>"
                                   required min="0" step="0.01">
                            <div class="invalid-feedback">
                                Le prix doit être un nombre positif.
                            </div>
                        </div>

                        <!-- Catégorie -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Catégorie *</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Choisir une catégorie</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category) ?>"
                                            <?= $isEdit && $menu['category'] === $category ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category) ?>
                                    </option>
                                <?php endforeach; ?>
                                <option value="new">+ Nouvelle catégorie</option>
                            </select>
                            <div class="invalid-feedback">
                                Veuillez sélectionner une catégorie.
                            </div>
                        </div>

                        <!-- Nouvelle catégorie (initialement cachée) -->
                        <div class="mb-3" id="newCategoryGroup" style="display: none;">
                            <label for="newCategory" class="form-label">Nouvelle catégorie *</label>
                            <input type="text" class="form-control" id="newCategory" name="new_category">
                            <div class="invalid-feedback">
                                Le nom de la catégorie est requis.
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <?php if ($isEdit && $menu['image_path']): ?>
                                <div class="mb-2">
                                    <img src="<?= htmlspecialchars($menu['image_path']) ?>" 
                                         alt="Image actuelle" 
                                         class="img-thumbnail" 
                                         style="max-width: 200px;">
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">
                                Formats acceptés : JPG, PNG, WebP. Taille maximale : 5MB
                            </div>
                        </div>

                        <!-- Disponibilité -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_available" name="is_available"
                                       <?= (!$isEdit || $menu['is_available']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_available">
                                    Menu disponible
                                </label>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between">
                            <a href="/menu" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <?= $isEdit ? 'Mettre à jour' : 'Créer' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const newCategoryGroup = document.getElementById('newCategoryGroup');
    const newCategoryInput = document.getElementById('newCategory');
    
    // Gestion de la nouvelle catégorie
    categorySelect.addEventListener('change', function() {
        if (this.value === 'new') {
            newCategoryGroup.style.display = 'block';
            newCategoryInput.required = true;
        } else {
            newCategoryGroup.style.display = 'none';
            newCategoryInput.required = false;
        }
    });
    
    // Validation du formulaire
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        // Validation personnalisée pour la nouvelle catégorie
        if (categorySelect.value === 'new' && !newCategoryInput.value.trim()) {
            event.preventDefault();
            newCategoryInput.classList.add('is-invalid');
        }
        
        form.classList.add('was-validated');
    });
    
    // Prévisualisation de l'image
    const imageInput = document.getElementById('image');
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('L\'image ne doit pas dépasser 5MB');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.maxWidth = '200px';
                
                const container = imageInput.parentElement;
                const oldPreview = container.querySelector('img');
                if (oldPreview) {
                    container.removeChild(oldPreview);
                }
                container.insertBefore(img, imageInput);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?> 