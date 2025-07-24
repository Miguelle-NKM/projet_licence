// Fonction pour gérer les messages flash
function handleFlashMessages() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
}

// Fonction pour la validation des formulaires
function initFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
}

// Fonction pour gérer le menu mobile
function initMobileMenu() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    if (navbarToggler) {
        navbarToggler.addEventListener('click', () => {
            document.querySelector('.navbar-collapse').classList.toggle('show');
        });
    }
}

// Fonction pour gérer le défilement doux
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Fonction pour gérer les confirmations de suppression
function initDeleteConfirmations() {
    document.querySelectorAll('.confirm-delete').forEach(button => {
        button.addEventListener('click', (e) => {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                e.preventDefault();
            }
        });
    });
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    handleFlashMessages();
    initFormValidation();
    initMobileMenu();
    initSmoothScroll();
    initDeleteConfirmations();
});

// Fonction utilitaire pour les requêtes AJAX
async function fetchApi(url, options = {}) {
    try {
        const response = await fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            ...options
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}

// Fonction pour afficher les messages d'erreur
function showError(message, container = 'error-container') {
    const errorDiv = document.getElementById(container);
    if (errorDiv) {
        errorDiv.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }
}

// Fonction pour afficher les messages de succès
function showSuccess(message, container = 'success-container') {
    const successDiv = document.getElementById(container);
    if (successDiv) {
        successDiv.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }
} 