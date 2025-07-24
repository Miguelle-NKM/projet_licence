<?php
// Liste des chambres - Administration
?>

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-bed me-2 text-primary"></i>Gestion des Chambres
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chambres</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="/admin/rooms/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nouvelle Chambre
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
                    <div class="display-6"><?= count($roomObjects) ?></div>
                    <small>Chambres Totales</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <div class="display-6">
                        <?= count(array_filter($roomObjects, function ($room) {
                            return $room->isAvailable();
                        })) ?>
                    </div>
                    <small>Disponibles</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <div class="display-6">
                        <?= count(array_filter($roomObjects, function ($room) {
                            return !$room->isAvailable();
                        })) ?>
                    </div>
                    <small>Indisponibles</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <div class="display-6">
                        <?= count(array_unique(array_map(function ($room) {
                            return $room->getType();
                        }, $roomObjects))) ?>
                    </div>
                    <small>Types</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des chambres -->
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Liste des Chambres
            </h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm" id="searchRooms"
                    placeholder="Rechercher une chambre..." style="max-width: 200px;">
                <select class="form-select form-select-sm" id="filterType" style="max-width: 150px;">
                    <option value="">Tous les types</option>
                    <option value="standard">Standard</option>
                    <option value="deluxe">Deluxe</option>
                    <option value="suite">Suite</option>
                    <option value="presidential">Présidentielle</option>
                </select>
            </div>
        </div>
        <div class="card-body p-0">
            <?php if (empty($roomObjects)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune chambre trouvée</h5>
                    <p class="text-muted">Commencez par ajouter votre première chambre.</p>
                    <a href="/admin/rooms/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Ajouter une Chambre
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="roomsTable">
                        <thead class="table-light">
                            <tr>
                                <th width="10%">Numéro</th>
                                <th width="15%">Type</th>
                                <th width="10%">Capacité</th>
                                <th width="15%">Prix/Nuit</th>
                                <th width="20%">Description</th>
                                <th width="10%">Statut</th>
                                <th width="10%">Créée</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($roomObjects as $room): ?>
                                <tr data-type="<?= strtolower($room->getType()) ?>" data-number="<?= $room->getNumber() ?>">
                                    <td>
                                        <strong class="text-primary">
                                            <?= htmlspecialchars($room->getNumber()) ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <?= $room->getTypeBadge() ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-users me-1 text-muted"></i>
                                        <?= $room->getCapacity() ?> pers.
                                    </td>
                                    <td>
                                        <strong class="text-success">
                                            <?= $room->getFormattedPrice() ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="text-muted" title="<?= htmlspecialchars($room->getDescription() ?? '') ?>">
                                            <?= $room->getDescription() ?
                                                (strlen($room->getDescription()) > 50 ?
                                                    substr(htmlspecialchars($room->getDescription()), 0, 50) . '...' :
                                                    htmlspecialchars($room->getDescription())
                                                ) :
                                                '<em>Aucune description</em>'
                                            ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= $room->getStatusBadge() ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= $room->getCreatedAt() ? date('d/m/Y', strtotime($room->getCreatedAt())) : 'N/A' ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="/admin/rooms/edit/<?= $room->getId() ?>"
                                                class="btn btn-outline-primary btn-sm"
                                                title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="deleteRoom(<?= $room->getId() ?>, '<?= htmlspecialchars($room->getNumber()) ?>')"
                                                title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
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
                <p>Êtes-vous sûr de vouloir supprimer la chambre <strong id="roomToDelete"></strong> ?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    Cette action est irréversible et supprimera toutes les données liées à cette chambre.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Supprimer
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Recherche en temps réel
        const searchInput = document.getElementById('searchRooms');
        const filterType = document.getElementById('filterType');
        const table = document.getElementById('roomsTable');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedType = filterType.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const number = row.dataset.number.toLowerCase();
                const type = row.dataset.type.toLowerCase();
                const description = row.querySelector('td:nth-child(5)').textContent.toLowerCase();

                const matchesSearch = number.includes(searchTerm) || description.includes(searchTerm);
                const matchesType = selectedType === '' || type === selectedType;

                row.style.display = matchesSearch && matchesType ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterType.addEventListener('change', filterTable);
    });

    function deleteRoom(id, number) {
        document.getElementById('roomToDelete').textContent = number;
        document.getElementById('confirmDelete').href = `/admin/rooms/delete/${id}`;

        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Animation des cartes de statistiques
    document.querySelectorAll('.card').forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('animate__animated', 'animate__fadeInUp');
    });
</script>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 40px, 0);
        }

        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    .animate__animated {
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }

    .animate__fadeInUp {
        animation-name: fadeInUp;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .badge {
        font-size: 0.8em;
    }
</style>