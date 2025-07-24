<?php
$title = 'Notre Menu';
ob_start();
?>

<div class="container py-5">
    <h1 class="text-center mb-5">Notre Menu</h1>

    <?php if (isset($_SESSION['is_admin'])): ?>
    <div class="mb-4">
        <a href="/menu/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un menu
        </a>
    </div>
    <?php endif; ?>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" id="menuSearch" class="form-control" placeholder="Rechercher un plat...">
                <button class="btn btn-outline-secondary" type="button" id="searchButton">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-6">
            <select id="categoryFilter" class="form-select">
                <option value="">Toutes les catégories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category) ?>">
                        <?= htmlspecialchars($category) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Affichage des menus par catégorie -->
    <?php foreach ($menusByCategory as $category => $categoryMenus): ?>
    <div class="menu-category mb-5" data-category="<?= htmlspecialchars($category) ?>">
        <h2 class="h3 mb-4"><?= htmlspecialchars($category) ?></h2>
        
        <div class="row">
            <?php foreach ($categoryMenus as $menu): ?>
            <div class="col-md-6 col-lg-4 mb-4 menu-item">
                <div class="card h-100">
                    <?php if ($menu['image_path']): ?>
                        <img src="<?= htmlspecialchars($menu['image_path']) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($menu['name']) ?>">
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($menu['name']) ?></h5>
                        
                        <?php if (!$menu['is_available']): ?>
                            <div class="badge bg-danger mb-2">Non disponible</div>
                        <?php endif; ?>
                        
                        <p class="card-text"><?= htmlspecialchars($menu['description']) ?></p>
                        <p class="card-text">
                            <strong class="text-primary">
                                <?= number_format($menu['price'], 2) ?> €
                            </strong>
                        </p>
                        
                        <?php if (isset($_SESSION['is_admin'])): ?>
                            <div class="btn-group">
                                <a href="/menu/edit/<?= $menu['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger delete-menu"
                                        data-id="<?= $menu['id'] ?>">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-secondary toggle-availability"
                                        data-id="<?= $menu['id'] ?>">
                                    <i class="fas fa-toggle-on"></i> 
                                    <?= $menu['is_available'] ? 'Désactiver' : 'Activer' ?>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce menu ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Recherche de menus
    const searchInput = document.getElementById('menuSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const menuItems = document.querySelectorAll('.menu-item');
    
    function filterMenus() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value.toLowerCase();
        
        menuItems.forEach(item => {
            const title = item.querySelector('.card-title').textContent.toLowerCase();
            const description = item.querySelector('.card-text').textContent.toLowerCase();
            const category = item.closest('.menu-category').dataset.category.toLowerCase();
            
            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesCategory = !selectedCategory || category === selectedCategory;
            
            item.style.display = matchesSearch && matchesCategory ? '' : 'none';
        });
        
        // Masquer les catégories vides
        document.querySelectorAll('.menu-category').forEach(category => {
            const hasVisibleItems = Array.from(category.querySelectorAll('.menu-item'))
                .some(item => item.style.display !== 'none');
            category.style.display = hasVisibleItems ? '' : 'none';
        });
    }
    
    searchInput.addEventListener('input', filterMenus);
    categoryFilter.addEventListener('change', filterMenus);
    
    // Gestion de la suppression
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    
    document.querySelectorAll('.delete-menu').forEach(button => {
        button.addEventListener('click', function() {
            const menuId = this.dataset.id;
            deleteForm.action = `/menu/delete/${menuId}`;
            deleteModal.show();
        });
    });
    
    // Gestion de la disponibilité
    document.querySelectorAll('.toggle-availability').forEach(button => {
        button.addEventListener('click', async function() {
            const menuId = this.dataset.id;
            try {
                const response = await fetch(`/menu/toggle/${menuId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (response.ok) {
                    location.reload();
                } else {
                    throw new Error('Erreur lors de la mise à jour');
                }
            } catch (error) {
                alert('Une erreur est survenue: ' + error.message);
            }
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?> 