<?php
// Page d'inscription avec Bootstrap 5
?>

<!-- Section d'Inscription -->
<div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-success text-white text-center py-4">
                        <h2 class="mb-0 fw-bold">
                            <i class="fas fa-user-plus me-2"></i>Inscription
                        </h2>
                        <p class="mb-0 mt-2">Créez votre compte en quelques minutes</p>
                    </div>

                    <div class="card-body p-5">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?= htmlspecialchars($_SESSION['error']) ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <form method="POST" action="/register" class="needs-validation" novalidate>
                            <!-- Informations Personnelles -->
                            <div class="mb-4">
                                <h5 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-user me-2"></i>Informations Personnelles
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="firstName" class="form-label fw-bold">Prénom *</label>
                                        <input type="text" class="form-control form-control-lg" id="firstName" name="firstName"
                                            placeholder="Jean" required>
                                        <div class="invalid-feedback">
                                            Veuillez saisir votre prénom.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label fw-bold">Nom *</label>
                                        <input type="text" class="form-control form-control-lg" id="lastName" name="lastName"
                                            placeholder="Dupont" required>
                                        <div class="invalid-feedback">
                                            Veuillez saisir votre nom.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="mb-4">
                                <h5 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-envelope me-2"></i>Contact
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-bold">Email *</label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email"
                                            placeholder="jean@example.com" required>
                                        <div class="invalid-feedback">
                                            Veuillez saisir une adresse email valide.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-bold">Téléphone</label>
                                        <input type="tel" class="form-control form-control-lg" id="phone" name="phone"
                                            placeholder="06 12 34 56 78">
                                    </div>
                                </div>
                            </div>

                            <!-- Sécurité -->
                            <div class="mb-4">
                                <h5 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-shield-alt me-2"></i>Sécurité
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-bold">Mot de Passe *</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                                placeholder="••••••••" required minlength="8">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">
                                            <small>
                                                <i class="fas fa-info-circle me-1"></i>
                                                Minimum 8 caractères, incluant majuscules, minuscules et chiffres
                                            </small>
                                        </div>
                                        <div class="invalid-feedback">
                                            Le mot de passe doit contenir au moins 8 caractères.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="confirmPassword" class="form-label fw-bold">Confirmation *</label>
                                        <input type="password" class="form-control form-control-lg" id="confirmPassword" name="confirmPassword"
                                            placeholder="••••••••" required>
                                        <div class="invalid-feedback">
                                            Les mots de passe ne correspondent pas.
                                        </div>
                                    </div>
                                </div>

                                <!-- Indicateur de force du mot de passe -->
                                <div class="mt-2">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small id="passwordStrengthText" class="text-muted"></small>
                                </div>
                            </div>

                            <!-- Préférences -->
                            <div class="mb-4">
                                <h5 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-cog me-2"></i>Préférences
                                </h5>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" checked>
                                    <label class="form-check-label" for="newsletter">
                                        <i class="fas fa-newspaper me-2"></i>
                                        Recevoir les offres spéciales et la newsletter
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="sms" name="sms">
                                    <label class="form-check-label" for="sms">
                                        <i class="fas fa-sms me-2"></i>
                                        Recevoir les notifications par SMS
                                    </label>
                                </div>
                            </div>

                            <!-- Conditions -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                    <label class="form-check-label" for="terms">
                                        J'accepte les
                                        <a href="/terms" class="text-primary" target="_blank">conditions d'utilisation</a>
                                        et la
                                        <a href="/privacy" class="text-primary" target="_blank">politique de confidentialité</a>
                                    </label>
                                    <div class="invalid-feedback">
                                        Vous devez accepter les conditions d'utilisation.
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Créer mon Compte
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer bg-light text-center py-4">
                        <p class="mb-0">
                            Déjà un compte ?
                            <a href="/login" class="text-primary fw-bold text-decoration-none">
                                <i class="fas fa-sign-in-alt me-1"></i>Se connecter
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

<!-- Avantages Membre -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-12 mb-5">
                <h3 class="fw-bold text-success">Avantages Membre</h3>
                <p class="text-muted">Rejoignez notre communauté et profitez d'avantages exclusifs</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-percentage fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Réductions Exclusives</h5>
                        <p class="text-muted">Jusqu'à 20% de réduction sur vos séjours</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card border-0 h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-gift fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Surprises de Bienvenue</h5>
                        <p class="text-muted">Cadeaux et attentions spéciales lors de votre arrivée</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card border-0 h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-crown fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Accès Prioritaire</h5>
                        <p class="text-muted">Réservations prioritaires et check-in express</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.needs-validation');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const togglePassword = document.getElementById('togglePassword');
        const strengthBar = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('passwordStrengthText');

        // Toggle password visibility
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        // Password strength checker
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let feedback = '';

            // Length check
            if (password.length >= 8) strength += 25;

            // Lowercase check
            if (/[a-z]/.test(password)) strength += 25;

            // Uppercase check
            if (/[A-Z]/.test(password)) strength += 25;

            // Number check
            if (/\d/.test(password)) strength += 25;

            // Update progress bar
            strengthBar.style.width = strength + '%';

            if (strength < 25) {
                strengthBar.className = 'progress-bar bg-danger';
                feedback = 'Très faible';
            } else if (strength < 50) {
                strengthBar.className = 'progress-bar bg-warning';
                feedback = 'Faible';
            } else if (strength < 75) {
                strengthBar.className = 'progress-bar bg-info';
                feedback = 'Moyen';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                feedback = 'Fort';
            }

            strengthText.textContent = password.length > 0 ? `Force: ${feedback}` : '';
        });

        // Confirm password validation
        function validatePasswords() {
            if (confirmPasswordInput.value && passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Les mots de passe ne correspondent pas');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        }

        passwordInput.addEventListener('input', validatePasswords);
        confirmPasswordInput.addEventListener('input', validatePasswords);

        // Form validation
        form.addEventListener('submit', function(event) {
            validatePasswords();

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>