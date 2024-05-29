<?php
session_start();

include_once ("includedb.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(array("success" => false, "message" => "User not logged in."));
    exit;
}

// Get the user's email from the session
$email = $_SESSION['email'];

// Query to fetch user data
$result = mysqli_query($mysqli, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

// Check if user exists
if (!$user) {
    echo json_encode(array("success" => false, "message" => "User not found."));
    exit;
}

// Retrieve order details from the POST data
$userId = $user['id'];
$userName = $user['name'];
$userAddress = $user['address'];
$reservationDate = $_POST['reservationDate'];
$total = $_POST['total'];
$orderItems = $_POST['orderItems'];
$orderId = $_POST['orderId'];

// Insert order details into the database
$query = "INSERT INTO order_details (order_id, user_id, reservation_date, total_price) VALUES ('$orderId', '$userId', '$reservationDate', '$total')";
if (mysqli_query($mysqli, $query)) {

    foreach ($orderItems as $item) {
        $productName = $item['productName'];
        $quantity = $item['quantity'];
        $totalPrice = $item['totalPrice'];
        $petName = $item['petName']; // Assuming this field exists in each order item
        $petId = $item['petId']; // Assuming this field exists in each order item
        $insertItemQuery = "INSERT INTO order_items (order_id, product_name, quantity, total_price, user_id, pet_name, pet_id) VALUES ('$orderId', '$productName', '$quantity', '$totalPrice', '$userId', '$petName', '$petId')";

        if (!mysqli_query($mysqli, $insertItemQuery)) {
            echo json_encode(array("success" => false, "message" => "Error inserting order item: " . mysqli_error($mysqli)));
            exit;
        }
    }
    echo json_encode(array("success" => true, "message" => "Order placed successfully."));
} else {
    echo json_encode(array("success" => false, "message" => "Error inserting order details: " . mysqli_error($mysqli)));
}
?>
