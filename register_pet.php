<?php
include ("config.php");
include  ("includedb.php");
include  ("includedb_admin.php");

include  ("includedb_orders.php");

session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("location: index.html");
    exit;
}

// Get the user's email from the session
$email = $_SESSION['email'];

// Query to fetch user data
$result = mysqli_query($mysqli, "SELECT * FROM pawsnplay_users.users WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

// Check if user exists
if (!$user) {
    echo "User not found.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_name = $_POST["pet-name"];
    $pet_type = $_POST["pet-type"];
    $pet_breed = $_POST["pet-breed"];
    $pet_birthday = $_POST["pet-birthday"];
    $pet_gender = $_POST["pet-gender"];
    
    // Validate and sanitize input data
    $pet_name = mysqli_real_escape_string($mysqli, $pet_name);
    $pet_type = mysqli_real_escape_string($mysqli, $pet_type);
    $pet_breed = mysqli_real_escape_string($mysqli, $pet_breed);
    $pet_birthday = mysqli_real_escape_string($mysqli, $pet_birthday);
    $pet_gender = mysqli_real_escape_string($mysqli, $pet_gender);

    // Get the owner_id from the fetched user data
    $owner_id = $user['id'];

    // Insert the pet into the database
    $sql = "INSERT INTO pawsnplay_pets.pets (name, type, breed, birthday, gender, owner_id) VALUES ('$pet_name', '$pet_type', '$pet_breed', '$pet_birthday', '$pet_gender', $owner_id)";

    if ($mysqli->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}
$mysqli->close();
?>
