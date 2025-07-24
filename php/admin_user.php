<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Le reste de votre code PHP suit ici
// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_gest";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Récupérer tous les utilisateurs
$sql = "SELECT id_utilisateur, nom, prenom, email, date_creation FROM utilisateurs ORDER BY date_creation DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des Comptes Utilisateurs</title>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F5F5DC; color: #051f18; margin: 20px; }
        .container { max-width: 1000px; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #051f18; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #051f18; color: #F5F5DC; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #e9e9e9; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Comptes Utilisateurs Enregistrés</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Date de Création</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_utilisateur']); ?></td>
                        <td><?php echo htmlspecialchars($row['nom']); ?></td>
                        <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_creation']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center;">Aucun compte utilisateur trouvé.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>