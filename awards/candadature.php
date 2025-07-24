<?php
header('Content-Type: application/json'); // Indique que la réponse est du JSON

$response = ['success' => false, 'message' => ''];

// Informations de connexion à la base de données
$servername = "localhost"; // Généralement localhost
$username = "root"; // Votre nom d'utilisateur de BDD
$password = ""; // Votre mot de passe de BDD
$dbname = "bdd_award"; // Le nom de votre base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    $response['message'] = "Échec de la connexion à la base de données: " . $conn->connect_error;
    echo json_encode($response);
    exit();
}

// Vérifier si la requête est bien de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    $description = $_POST['description'] ?? '';
    // Pour les fichiers, c'est un peu plus complexe
    $fichier_url = '';

    // Validation simple des données
    if (empty($nom) || empty($prenom) || empty($email) || empty($categorie)) {
        $response['message'] = "Veuillez remplir tous les champs obligatoires.";
        echo json_encode($response);
        $conn->close();
        exit();
    }

    // Gestion de l'upload de fichier
    if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Dossier où stocker les fichiers
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Crée le dossier s'il n'existe pas
        }
        $file_name = uniqid() . '_' . basename($_FILES["fichier"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier le type de fichier (vous pouvez ajouter plus de validations)
        $allowed_types = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        if (!in_array($file_type, $allowed_types)) {
            $response['message'] = "Type de fichier non autorisé. Seuls les PDF, DOC, DOCX, JPG, JPEG, PNG sont permis.";
            echo json_encode($response);
            $conn->close();
            exit();
        }

        if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $target_file)) {
            $fichier_url = $target_file;
        } else {
            $response['message'] = "Erreur lors du téléversement du fichier.";
            echo json_encode($response);
            $conn->close();
            exit();
        }
    }

    // Préparation de la requête SQL pour insérer dans la table candidatures
    // NOTE: Avant d'insérer une candidature, il faudrait probablement vérifier si l'utilisateur existe
    // et récupérer son `id_utilisateur`. Pour la simplicité, nous allons simuler un `id_utilisateur`
    // ou assumer que l'utilisateur est déjà connecté et son ID est connu.
    // Dans un vrai système, vous inséreriez d'abord l'utilisateur s'il n'existe pas, ou récupéreriez son ID.

    // Supposons un id_utilisateur fictif pour cet exemple.
    // Dans un vrai scénario, cet ID viendrait de la session de l'utilisateur connecté.
    $id_utilisateur = 1; // À remplacer par l'ID réel de l'utilisateur connecté

    // Insérer dans la table `candidatures`
    $stmt_candidature = $conn->prepare("INSERT INTO candidatures (id_utilisateur, categorie, description, url_fichier, statut, date_soumission) VALUES (?, ?, ?, ?, ?, NOW())");
    $statut_initial = 'en_attente';
    $stmt_candidature->bind_param("issss", $id_utilisateur, $categorie, $description, $fichier_url, $statut_initial);

    if ($stmt_candidature->execute()) {
        $response['success'] = true;
        $response['message'] = "Candidature soumise avec succès !";
    } else {
        $response['message'] = "Erreur SQL lors de l'insertion de la candidature: " . $stmt_candidature->error;
    }

    $stmt_candidature->close();

} else {
    $response['message'] = "Méthode de requête non autorisée.";
}

$conn->close();
echo json_encode($response);
?>