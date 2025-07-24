// Optionnel : JavaScript pour la validation ou des interactions simples
        document.addEventListener('DOMContentLoaded', function() {
            const checkInInput = document.getElementById('check-in');
            const checkOutInput = document.getElementById('check-out');

            // Définir la date d'aujourd'hui comme date par défaut pour l'enregistrement
            const today = new Date();
            const todayString = today.toISOString().split('T')[0];
            checkInInput.value = todayString;
            checkInInput.min = todayString; // Empêcher la sélection de dates passées

            // Fixer le départ au plus tard demain
            const tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 1);
            const tomorrowString = tomorrow.toISOString().split('T')[0];
            checkOutInput.value = tomorrowString;
            checkOutInput.min = tomorrowString;

            // Assurez-vous que le départ a toujours lieu après l'enregistrement
            checkInInput.addEventListener('change', function() {
                if (checkInInput.value) {
                    const checkInDate = new Date(checkInInput.value);
                    const newCheckOutDate = new Date(checkInDate);
                    newCheckOutDate.setDate(checkInDate.getDate() + 1);
                    const newCheckOutString = newCheckOutDate.toISOString().split('T')[0];

                    if (checkOutInput.value < newCheckOutString) {
                        checkOutInput.value = newCheckOutString;
                    }
                    checkOutInput.min = newCheckOutString;
                }
            });

            // Gérer le défilement fluide des liens de navigation
            document.querySelectorAll('nav a').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });