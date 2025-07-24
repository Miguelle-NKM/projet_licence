 <?php
$servername = "localhost"; 
$username = "root";        
$password = "";            
$database = "bdd_award"; 

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

echo "Successfully connected to the database!";

$conn->close();

?>