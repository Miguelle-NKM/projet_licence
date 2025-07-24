<?php
$password = "1234"; // Example password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo password_hash("1234", PASSWORD_DEFAULT);
?>