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
    echo json_encode([]);
    exit;
}

// Get the owner_id from the fetched user data
$owner_id = $user['id'];

// Query to fetch pets data
$pets_result = mysqli_query($mysqli, "SELECT * FROM pawsnplay_pets.pets WHERE owner_id='$owner_id'");
$pets = [];

while ($pet = mysqli_fetch_assoc($pets_result)) {
    $pets[] = $pet;
}

echo json_encode($pets);
$mysqli->close();
?>
