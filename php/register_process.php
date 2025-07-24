<?php
session_start();
require_once 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $confirm_password = $_POST['confirm_password']; 

   
    if (empty($email) || empty($password) || empty($confirm_password)){
        
        header("location: ../creercompte.html?error=empty_fields");
        exit();
    }

    
    $sql = "SELECT user_id, email, password_hash, role FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
           
            header("location: ../creercompte.html?error=email_exists");
            exit();
        }
        $stmt->close();
    } else {
       
        header("location: ../creercompte.html?error=db_prepare_failed");
        exit();
    }

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

   
    $sql = "INSERT INTO users (user_id, email, password_hash, ) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $email, $hashed_password, $confirm_password);
        if ($stmt->execute()) {
            
            header("location: ../login.html?success=account_created");
            exit();
        } else {
            
            header("location: ../creercompte.html?error=insert_failed");
            exit();
        }
        $stmt->close();
    } else {
       
        header("location: ../creercompte.html?error=db_prepare_failed");
        exit();
    }

    
    $conn->close();
} else {
    
    header("location: ../creercompte.html?error=invalid_request_method");
    exit();
}
?>
