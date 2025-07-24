document.querySelector('#soumettre form').addEventListener('submit', async function(event) {
    event.preventDefault(); // Empêche le rechargement de la page

    const formData = new FormData(this); // Collecte toutes les données du formulaire

    try {
        const response = await fetch('submit_candidature.php', { // 'submit_candidature.php' est votre script PHP
            method: 'POST',
            body: formData
        });

        const result = await response.json(); // Le serveur PHP devrait renvoyer une réponse JSON

        if (result.success) {
            alert('Votre candidature a été soumise avec succès !');
            this.reset(); // Réinitialise le formulaire
        } else {
            alert('Erreur lors de la soumission : ' + result.message);
        }
    } catch (error) {
        console.error('Erreur réseau ou du serveur:', error);
        alert('Une erreur est survenue. Veuillez réessayer.');
    }
});