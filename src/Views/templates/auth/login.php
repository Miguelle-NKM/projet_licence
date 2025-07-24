<?php
// Page de connexion avec Bootstrap 5
?>

<!-- Section de Connexion -->
<div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h2 class="mb-0 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>Connexion
                        </h2>
                        <p class="mb-0 mt-2">Accédez à votre espace personnel</p>
                    </div>

                    <div class="card-body p-5">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?= htmlspecialchars($_SESSION['error']) ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <?= htmlspecialchars($_SESSION['success']) ?>
                            </div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>

                        <form method="POST" action="/login" class="needs-validation" novalidate>
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">
                                    <i class="fas fa-envelope text-primary me-2"></i>Adresse Email
                                </label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email"
                                    placeholder="votre@email.com" required>
                                <div class="invalid-feedback">
                                    Veuillez saisir une adresse email valide.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">
                                    <i class="fas fa-lock text-primary me-2"></i>Mot de Passe
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg" id="password" name="password"
                                        placeholder="••••••••" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    Veuillez saisir votre mot de passe.
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                    <label class="form-check-label" for="rememberMe">
                                        Se souvenir de moi
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Se Connecter
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="/forgot-password" class="text-decoration-none">
                                    <i class="fas fa-question-circle me-1"></i>Mot de passe oublié ?
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer bg-light text-center py-4">
                        <p class="mb-0">
                            Pas encore de compte ?
                            <a href="/register" class="text-primary fw-bold text-decoration-none">
                                <i class="fas fa-user-plus me-1"></i>Créer un compte
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Retour à l'accueil -->
                <div class="text-center mt-4">
                    <a href="/" class="text-white text-decoration-none">
                        <i class="fas fa-arrow-left me-2"></i>Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Avantages de la Connexion -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-12 mb-5">
                <h3 class="fw-bold text-primary">Pourquoi Créer un Compte ?</h3>
                <p class="text-muted">Découvrez tous les avantages de notre espace membre</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="text-center p-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-bolt fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Réservation Express</h5>
                    <p class="text-muted small">Réservez en un clic avec vos informations sauvegardées</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="text-center p-3">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-star fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Offres Exclusives</h5>
                    <p class="text-muted small">Accédez à des tarifs préférentiels et promotions spéciales</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="text-center p-3">
                    <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-history fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Historique</h5>
                    <p class="text-muted small">Consultez et gérez facilement vos réservations passées</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="text-center p-3">
                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-bell fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Notifications</h5>
                    <p class="text-muted small">Recevez des alertes sur les nouvelles offres et événements</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validation du formulaire
        const form = document.querySelector('.needs-validation');
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        // Toggle password visibility
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        // Form validation
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>