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
$user_id = $user['id']; // Assuming the user ID is stored in the 'id' column

// Process order form submission
if (isset($_POST['package']) && isset($_POST['quantity']) && isset($_POST['date'])) {
    $package_id = $_POST['package'];
    $quantity = $_POST['quantity'];
    $reservation_date = $_POST['date'];

    // Retrieve package price from the database
$package_result = mysqli_query($mysqli, "SELECT price FROM packages WHERE id='$package_id'");
if (mysqli_num_rows($package_result) > 0) {
    $package = mysqli_fetch_assoc($package_result);
    $price = $package['price'];

    // Calculate total price
    $total_price = $price * $quantity;

    // Insert order into database
    $insert_result = mysqli_query($mysqli, "INSERT INTO orders (user_id, package_id, quantity, reservation_date, total_price) 
                                            VALUES ('$user_id', '$package_id', '$quantity', '$reservation_date', '$total_price')");

    if ($insert_result) {
        echo "Order placed successfully.";
    } else {
        echo "Error placing order: " . mysqli_error($mysqli);
    }
} else {
    echo "Invalid package ID.";
}
}
?>
