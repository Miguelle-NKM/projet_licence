
<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id'] ?? null; // récupère l'id utilisateur connecté
    $room_id = $_POST['room_id'] ?? '';
    $checkInDate = $_POST['checkInDate'] ?? '';
    $checkOutDate = $_POST['checkOutDate'] ?? '';
    $numAdults = $_POST['numAdults'] ?? '';
    $numChildren = $_POST['numChildren'] ?? '';

    if (
        empty($user_id) || empty($room_id) || empty($checkInDate) || empty($checkOutDate) || empty($numAdults)
    ) {
        header("Location: ../reserpaie.html?error=empty_fields");
        exit();
    }

    $sql = "INSERT INTO Reservations 
        (User_id, Room_id, Check_in, Check_out, Adults, Children) 
        VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "iissii",
            $user_id,
            $room_id,
            $checkInDate,
            $checkOutDate,
            $numAdults,
            $numChildren
        );
        if ($stmt->execute()) {
            header("Location: ../reserpaie.html?success=reservation_ok");
            exit();
        } else {
            header("Location: ../reserpaie.html?error=insert_failed");
            exit();
        }
        $stmt->close();
    } else {
        header("Location: ../reserpaie.html?error=db_prepare_failed");
        exit();
    }
    $conn->close();
} else {
    header("Location: ../reserpaie.html?error=invalid_request");
    exit();
}
?>