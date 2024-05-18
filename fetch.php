<?php
session_start(); // Start the session

// Assuming you have already connected to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "paws";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details based on the email passed as a parameter
if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $sql = "SELECT id, name, address FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row as JSON
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo "User not found";
    }
} else {
    echo "Email not provided";
}

$conn->close();
?>
