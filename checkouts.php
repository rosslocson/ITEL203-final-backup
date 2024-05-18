<?php
include_once("includedb.php");

// Retrieve order details from the form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['total'])) {
    $totalPrice = $_POST['total'];
    $reservationDate = date('Y-m-d', strtotime($_POST['reservationDate']));

    // Assuming you have the user ID in the session
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Generate a random order ID
        $orderId = "ORD" . rand(100000, 999999);

        // Prepare and execute SQL statement to insert the order into the database
        $sql = "INSERT INTO orders (order_id, user_id, reservation_date, total_price) VALUES ('$orderId', '$userId', '$reservationDate', '$totalPrice')";
        if ($conn->query($sql) === TRUE) {
            echo "Order placed successfully. Your Order ID is: " . $orderId;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "User ID not found in session.";
    }
}

// Display the order details from the database
if (isset($orderId)) {
    $sql = "SELECT users.username, users.address, users.contact_number, orders.order_id, orders.reservation_date, orders.total_price, order_items.product_name
            FROM orders
            JOIN users ON orders.user_id = users.id
            JOIN order_items ON orders.id = order_items.order_id
            WHERE orders.order_id = '$orderId'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $address = $row['address'];
        $contactNumber = $row['contact_number'];
        $reservationDate = $row['reservation_date'];
        $totalPrice = $row['total_price'];
        $productName = $row['product_name'];

        // Display order details
        echo "<h2>Order Details</h2>";
        echo "<p><strong>Username:</strong> $username</p>";
        echo "<p><strong>Address:</strong> $address</p>";
        echo "<p><strong>Contact Number:</strong> $contactNumber</p>";
        echo "<p><strong>Order ID:</strong> $orderId</p>";
        echo "<p><strong>Reservation Date:</strong> $reservationDate</p>";
        echo "<p><strong>Total Price:</strong> $totalPrice</p>";
        echo "<p><strong>Product Name:</strong> $productName</p>";
    } else {
        echo "No order found";
    }
}

$conn->close();
?>
