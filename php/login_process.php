<?php
session_start(); 

require_once 'config.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

  
    if (empty($email) || empty($password)) {
        header("location: login.html?error=empty_fields");
        exit();
    }

   
    $sql = "SELECT user_id, email, password_hash, role FROM users WHERE email = ?";

    if ($stmt = $conn -> prepare($sql)) {
    
        $stmt->bind_param("s", $param_email); 

        
        $param_email = $email;

        
        if ($stmt->execute()) {
            
            $stmt->store_result();

            
            if ($stmt->num_rows == 1) {
              
                $stmt->bind_result($User_id, $email, $hashed_password, $role);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashed_password)) {
                        
                        session_regenerate_id(true); 
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["email"] = $email;
                        $_SESSION["role"] = $role; 

                        
                        if ($role == 'admin') {
                            header("location: ../dashboard.html");
                        } elseif ($role == 'admin') {
                            header("location: ../dashboard.html");
                        } elseif ($role == 'client') {
                            header("location: ../home.html");
                        } else {
                            header("location: ../home.html");
                        }
                        exit();
                    } else {
                       
                        header("location: ../login.html?error=invalid_credentials");
                        exit();
                    }
                }
            } else {
                
                header("location: ../login.html?error=invalid_credentials fykgl");
                exit();
            }
        } else {
            echo "Oups ! Un problème est survenu. Veuillez réessayer plus tard..";
        }

        
        $stmt->close();
    }

    
    $conn->close();
} else {

    header("location: login.html");
    exit();
}
