<?php
session_start();

// Include your database connection file
include_once("includedb.php");
include("config.php");
include("includedb_admin.php");
include("includedb_orders.php");

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(array("success" => false, "message" => "User not logged in."));
    exit;
}

// Get the user's email from the session
$email = $_SESSION['email'];

// Query to fetch user data
$result = mysqli_query($mysqli, "SELECT * FROM pawsnplay_users.users WHERE email='$email'");
if (!$result) {
    echo json_encode(array("success" => false, "message" => "Error fetching user: " . mysqli_error($mysqli)));
    exit;
}

$user = mysqli_fetch_assoc($result);

// Check if user exists
if (!$user) {
    echo json_encode(array("success" => false, "message" => "User not found."));
    exit;
}

$userId = $user['id'];

// Query to fetch appointment details for the logged-in user
$query = "
    SELECT 
        pawsnplay.order_details.reservation_date, 
        pawsnplay.order_items.order_id, 
        pawsnplay.order_items.pet_name, 
        pawsnplay.order_items.product_name 
    FROM 
        pawsnplay.order_items 
    JOIN 
        pawsnplay.order_details
    ON
    pawsnplay.order_items.order_id = pawsnplay.order_details.order_id 
    WHERE 
    pawsnplay.order_items.user_id='$userId'
";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    echo json_encode(array("success" => false, "message" => "Error fetching appointments: " . mysqli_error($mysqli)));
    exit;
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
echo json_encode(array("success" => true, "data" => $appointments));

// Close database connection
mysqli_close($mysqli);
?>