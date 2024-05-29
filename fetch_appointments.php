<?php
session_start();

// Include your database connection file
include_once("includedb.php");
include_once("config.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(array("success" => false, "message" => "User not logged in."));
    exit;
}

// Get the user's email from the session
$email = $_SESSION['email'];

// Query to fetch user data
$result = mysqli_query($mysqli, "SELECT * FROM pawsnplay.users WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

// Check if user exists
if (!$user) {
    echo json_encode(array("success" => false, "message" => "User not found."));
    exit;
}

$userId = $user['id'];

// Query to fetch appointment details for the logged-in user
$query = "SELECT od.reservation_date, oi.order_id, oi.pet_name, oi.product_name FROM pawsnplay.order_items oi JOIN pawsnplay.order_details od ON oi.order_id = od.order_id WHERE oi.user_id='$userId'";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die(json_encode(array("success" => false, "message" => "Error fetching appointments: " . mysqli_error($mysqli))));
}

// Fetch appointments and store in an array
$appointments = array();
while ($row = mysqli_fetch_assoc($result)) {
    $appointments[] = array(
        "date" => $row["reservation_date"],
        "orderId" => $row["order_id"],
        "petName" => $row["pet_name"],
        "productName" => $row["product_name"]
    );
}

// Return appointments data as JSON
echo json_encode($appointments);

// Close database connection
mysqli_close($mysqli);
?>
