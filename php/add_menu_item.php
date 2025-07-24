<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'] ?? '';
    $name = $_POST['mealName'] ?? '';
    $description = $_POST['mealDescription'] ?? '';
    $price = $_POST['mealPrice'] ?? '';
    $is_available = 1;

    // Gestion de l'image
    $image = '';
    if (isset($_FILES['mealImage']) && $_FILES['mealImage']['error'] === UPLOAD_ERR_OK) {
        $imageName = uniqid() . '_' . basename($_FILES['mealImage']['name']);
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        move_uploaded_file($_FILES['mealImage']['tmp_name'], $uploadDir . $imageName);
        $image = $imageName;
    }

    if ($category && $name && $price) {
        $sql = "INSERT INTO Menu (Category, Name_M, Description, Price, Is_available, Image)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdis", $category, $name, $description, $price, $is_available, $image);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'insertion']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Champs manquants']);
    }
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
}
?>