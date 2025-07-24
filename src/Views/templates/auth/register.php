<?php
$title = 'Inscription';
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Créer un compte</h2>
            </div>
            <div class="card-body">
                <form action="/register" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom complet</label>
                        <input type="text" class="form-control" id="name" name="name" required minlength="3">
                        <div class="invalid-feedback">
                            Le nom doit contenir au moins 3 caractères.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback">
                            Veuillez entrer une adresse email valide.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               required minlength="8" 
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                        <div class="invalid-feedback">
                            Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                        <div class="invalid-feedback">
                            Les mots de passe ne correspondent pas.
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            J'accepte les <a href="/terms" target="_blank">conditions d'utilisation</a>
                        </label>
                        <div class="invalid-feedback">
                            Vous devez accepter les conditions d'utilisation.
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">S'inscrire</button>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <p>Déjà un compte ? <a href="/login">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validation des formulaires Bootstrap
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            // Vérification de la correspondance des mots de passe
            var password = document.getElementById('password')
            var confirm = document.getElementById('password_confirm')
            if (password.value !== confirm.value) {
                confirm.setCustomValidity('Les mots de passe ne correspondent pas')
                event.preventDefault()
                event.stopPropagation()
            } else {
                confirm.setCustomValidity('')
            }

            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?> 