<?php
session_start();

include_once("includedb.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("location: login.html");
    exit;
}

// Get the user's email from the session
$email = $_SESSION['email'];

// Query to fetch user data
$result = mysqli_query($mysqli, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

// Check if user exists
if (!$user) {
    echo "User not found.";
    exit;
}

// Extract user data
$user_id = $user['id'];

// Check if order_id is set in the URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Perform checkout logic here (e.g., update order status, process payment, etc.)

    // Redirect back to the cart page
    header("location: profile.php#myorders");
    exit;
} else {
    echo "Order ID not provided.";
}
?>
