<?php
// Liste des éléments du menu - Administration
?>

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-utensils me-2 text-primary"></i>Gestion du Menu
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Menu</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="/admin/menu/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nouvel Élément
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <div class="display-6"><?= count($menuObjects) ?></div>
                    <small>Éléments Totaux</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <div class="display-6">
                        <?= count(array_filter($menuObjects, function ($item) {
                            return $item->isAvailable();
                        })) ?>
                    </div>
                    <small>Disponibles</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <div class="display-6">
                        <?= count(array_unique(array_map(function ($item) {
                            return $item->getCategory();
                        }, $menuObjects))) ?>
                    </div>
                    <small>Catégories</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <div class="display-6">
                        <?php
                        $total = array_sum(array_map(function ($item) {
                            return $item->getPrice();
                        }, $menuObjects));
                        echo number_format($total / 1000, 0) . 'K';
                        ?>
                    </div>
                    <small>Total Prix (K FCFA)</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="searchMenu" class="form-label">Rechercher</label>
                    <input type="text" class="form-control" id="searchMenu"
                        placeholder="Nom, description...">
                </div>
                <div class="col-md-3">
                    <label for="filterCategory" class="form-label">Catégorie</label>
                    <select class="form-select" id="filterCategory">
                        <option value="">Toutes les catégories</option>
                        <?php
                        $categories = array_unique(array_map(function ($item) {
                            return $item->getCategory();
                        }, $menuObjects));
                        foreach ($categories as $category):
                        ?>
                            <option value="<?= strtolower($category) ?>"><?= ucfirst($category) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterAvailability" class="form-label">Disponibilité</label>
                    <select class="form-select" id="filterAvailability">
                        <option value="">Tous</option>
                        <option value="available">Disponibles</option>
                        <option value="unavailable">Indisponibles</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class="fas fa-undo me-1"></i>Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des éléments du menu -->
    <?php if (empty($menuObjects)): ?>
        <div class="card shadow">
            <div class="card-body">
                <div class="text-center py-5">
                    <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun élément dans le menu</h5>
                    <p class="text-muted">Commencez par ajouter votre premier plat.</p>
                    <a href="/admin/menu/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Ajouter un Élément
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4" id="menuGrid">
            <?php foreach ($menuObjects as $menuItem): ?>
                <div class="col-lg-4 col-md-6 menu-item"
                    data-category="<?= strtolower($menuItem->getCategory()) ?>"
                    data-name="<?= strtolower($menuItem->getName()) ?>"
                    data-description="<?= strtolower($menuItem->getDescription() ?? '') ?>"
                    data-available="<?= $menuItem->isAvailable() ? 'available' : 'unavailable' ?>">
                    <div class="card shadow-sm h-100">
                        <!-- Image du plat -->
                        <div class="position-relative">
                            <img src="<?= $menuItem->getImageUrl() ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($menuItem->getName()) ?>"
                                style="height: 200px; object-fit: cover;"
                                onerror="this.src='/assets/images/default-menu.jpg'">

                            <!-- Badges de statut -->
                            <div class="position-absolute top-0 end-0 p-2">
                                <?= $menuItem->getStatusBadge() ?>
                            </div>

                            <!-- Badge catégorie -->
                            <div class="position-absolute top-0 start-0 p-2">
                                <?= $menuItem->getCategoryBadge() ?>
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <!-- Nom et prix -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">
                                    <?= htmlspecialchars($menuItem->getName()) ?>
                                </h5>
                                <span class="text-success fw-bold">
                                    <?= $menuItem->getFormattedPrice() ?>
                                </span>
                            </div>

                            <!-- Description -->
                            <p class="card-text text-muted flex-grow-1">
                                <?= $menuItem->getTruncatedDescription(80) ?: 'Aucune description disponible' ?>
                            </p>

                            <!-- Métadonnées -->
                            <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                                <span>
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?= $menuItem->getCreatedAt() ? date('d/m/Y', strtotime($menuItem->getCreatedAt())) : 'N/A' ?>
                                </span>
                                <span>ID: <?= $menuItem->getId() ?></span>
                            </div>

                            <!-- Actions -->
                            <div class="btn-group w-100" role="group">
                                <a href="/admin/menu/edit/<?= $menuItem->getId() ?>"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit me-1"></i>Modifier
                                </a>
                                <button type="button"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="deleteMenuItem(<?= $menuItem->getId() ?>, '<?= htmlspecialchars($menuItem->getName()) ?>')">
                                    <i class="fas fa-trash me-1"></i>Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Message quand aucun résultat après filtrage -->
        <div class="card shadow mt-4" id="noResults" style="display: none;">
            <div class="card-body">
                <div class="text-center py-4">
                    <i class="fas fa-search fa-2x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun résultat trouvé</h5>
                    <p class="text-muted">Essayez de modifier vos critères de recherche.</p>
                    <button type="button" class="btn btn-outline-primary" onclick="resetFilters()">
                        <i class="fas fa-undo me-2"></i>Réinitialiser les filtres
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer l'élément <strong id="menuItemToDelete"></strong> ?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    Cette action est irréversible et supprimera définitivement cet élément du menu.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="#" id="confirmDeleteMenu" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Supprimer
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchMenu');
        const categoryFilter = document.getElementById('filterCategory');
        const availabilityFilter = document.getElementById('filterAvailability');
        const menuGrid = document.getElementById('menuGrid');
        const noResults = document.getElementById('noResults');

        function filterMenu() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value.toLowerCase();
            const selectedAvailability = availabilityFilter.value;

            const menuItems = document.querySelectorAll('.menu-item');
            let visibleCount = 0;

            menuItems.forEach(item => {
                const name = item.dataset.name;
                const description = item.dataset.description;
                const category = item.dataset.category;
                const availability = item.dataset.available;

                const matchesSearch = name.includes(searchTerm) || description.includes(searchTerm);
                const matchesCategory = selectedCategory === '' || category === selectedCategory;
                const matchesAvailability = selectedAvailability === '' || availability === selectedAvailability;

                const shouldShow = matchesSearch && matchesCategory && matchesAvailability;

                item.style.display = shouldShow ? '' : 'none';
                if (shouldShow) visibleCount++;
            });

            // Afficher/cacher le message "aucun résultat"
            if (menuGrid) {
                menuGrid.style.display = visibleCount > 0 ? '' : 'none';
                noResults.style.display = visibleCount === 0 ? '' : 'none';
            }
        }

        // Écouteurs d'événements
        searchInput.addEventListener('input', filterMenu);
        categoryFilter.addEventListener('change', filterMenu);
        availabilityFilter.addEventListener('change', filterMenu);
    });

    function resetFilters() {
        document.getElementById('searchMenu').value = '';
        document.getElementById('filterCategory').value = '';
        document.getElementById('filterAvailability').value = '';

        // Réafficher tous les éléments
        document.querySelectorAll('.menu-item').forEach(item => {
            item.style.display = '';
        });

        document.getElementById('menuGrid').style.display = '';
        document.getElementById('noResults').style.display = 'none';
    }

    function deleteMenuItem(id, name) {
        document.getElementById('menuItemToDelete').textContent = name;
        document.getElementById('confirmDeleteMenu').href = `/admin/menu/delete/${id}`;

        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Animation d'entrée des cartes
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.menu-item .card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';

            setTimeout(() => {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>

<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .menu-item .card-img-top {
        transition: transform 0.3s ease;
    }

    .menu-item:hover .card-img-top {
        transform: scale(1.05);
    }

    .position-absolute .badge {
        font-size: 0.75em;
    }

    @media (max-width: 768px) {
        .btn-group {
            flex-direction: column;
        }

        .btn-group .btn {
            border-radius: 0.375rem !important;
            margin-bottom: 0.25rem;
        }
    }
</style>