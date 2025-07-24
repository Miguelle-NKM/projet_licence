<?php
require_once 'config.php';
$result = $conn->query("SELECT Menu_id, Category, Name_M, Description, Price, Image FROM Menu WHERE Is_available = 1 ORDER BY Menu_id DESC");
$menu = [];
while ($row = $result->fetch_assoc()) {
    $menu[] = $row;
}
echo json_encode($menu);
$conn->close();
?>