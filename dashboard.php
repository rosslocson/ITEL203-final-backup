<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pawsnplay";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//Retrieve total number of users
$sql = "SELECT COUNT(*) as total_customers FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_customers = $row["total_customers"];
} else {
    $total_customers = 0;
}



// Retrieve total income from the database
$sql = "SELECT total_price FROM order_details";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $overall_total = 0;
    // Calculate overall total
    while ($row = $result->fetch_assoc()) {
        $overall_total += $row["total_price"];
    }
    // Display overall total

} else {
    echo "No orders found";
}


//Retrieve total number of orders 

$sql = "SELECT COUNT(*) as total_orders FROM order_details";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_orders = $row["total_orders"];
} else {
    $total_orders = 0;
}

       
        
// Close database connection
$conn->close();
?>