<?php
// Dashboard Admin Principal
?>

<div class="container-fluid py-4">
    <!-- En-tête du Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard Administrateur
                    </h1>
                    <p class="text-muted mb-0">Gérez les chambres et le menu de votre hôtel</p>
                </div>
                <div>
                    <span class="badge bg-success fs-6">
                        <i class="fas fa-user-shield me-1"></i>Administrateur: <?= htmlspecialchars($_SESSION['user_email'] ?? 'Admin') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cartes de Statistiques -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Chambres Totales
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $stats['total_rooms'] ?? 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bed fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Chambres Disponibles
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $stats['available_rooms'] ?? 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Éléments du Menu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $stats['total_menu_items'] ?? 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Catégories Menu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $stats['menu_categories'] ?? 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Rapides -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bed me-2"></i>Gestion des Chambres
                    </h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/admin/rooms/create">
                                    <i class="fas fa-plus me-2"></i>Nouvelle Chambre
                                </a></li>
                            <li><a class="dropdown-item" href="/admin/rooms">
                                    <i class="fas fa-list me-2"></i>Voir Toutes
                                </a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Gérez les chambres de votre hôtel : ajoutez, modifiez ou supprimez des chambres.
                    </p>
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="/admin/rooms" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-list me-1"></i>Liste des Chambres
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/admin/rooms/create" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-plus me-1"></i>Nouvelle Chambre
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-utensils me-2"></i>Gestion du Menu
                    </h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/admin/menu/create">
                                    <i class="fas fa-plus me-2"></i>Nouvel Élément
                                </a></li>
                            <li><a class="dropdown-item" href="/admin/menu">
                                    <i class="fas fa-list me-2"></i>Voir Tout le Menu
                                </a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Gérez le menu de votre restaurant : ajoutez de nouveaux plats, modifiez les prix.
                    </p>
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="/admin/menu" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-list me-1"></i>Liste du Menu
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/admin/menu/create" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-plus me-1"></i>Nouvel Élément
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accès Rapide aux Autres Fonctionnalités -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tools me-2"></i>Outils d'Administration
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                <h6 class="mb-1">Gestion Utilisateurs</h6>
                                <p class="text-muted small mb-2">Gérer les comptes clients</p>
                                <a href="#" class="btn btn-sm btn-outline-primary">Bientôt</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <i class="fas fa-calendar-alt fa-2x text-success mb-2"></i>
                                <h6 class="mb-1">Réservations</h6>
                                <p class="text-muted small mb-2">Voir toutes les réservations</p>
                                <a href="/reservation" class="btn btn-sm btn-outline-success">Voir</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <i class="fas fa-chart-bar fa-2x text-info mb-2"></i>
                                <h6 class="mb-1">Statistiques</h6>
                                <p class="text-muted small mb-2">Rapports et analyses</p>
                                <a href="#" class="btn btn-sm btn-outline-info">Bientôt</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <i class="fas fa-cog fa-2x text-warning mb-2"></i>
                                <h6 class="mb-1">Paramètres</h6>
                                <p class="text-muted small mb-2">Configuration générale</p>
                                <a href="#" class="btn btn-sm btn-outline-warning">Bientôt</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }

    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }

    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }

    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }

    .text-gray-800 {
        color: #5a5c69 !important;
    }

    .text-gray-300 {
        color: #dddfeb !important;
    }
</style>