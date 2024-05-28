<?php
// Database credentials
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Step 1: Fetch the order details to be deleted
        $sql_fetch = "SELECT id, order_id, user_id, reservation_date, total_price FROM order_details WHERE id = ?";
        $stmt_fetch = $conn->prepare($sql_fetch);
        $stmt_fetch->bind_param("i", $id);
        $stmt_fetch->execute();
        $result = $stmt_fetch->get_result();
        $order = $result->fetch_assoc();

        if (!$order) {
            throw new Exception("Order not found.");
        }

        // Debugging output to check fetched values
        echo "Fetched Order Details: ";
        print_r($order);
        echo "<br>";

        // Step 2: Insert the order details into completed_orders
        $sql_insert = "INSERT INTO completed_orders (id, order_id, user_id, reservation_date, total_price) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("isiss", $id, $order['order_id'], $order['user_id'], $order['reservation_date'], $order['total_price']);
        $stmt_insert->execute();

        // Step 3: Delete related records from order_items
        $sql_delete_items = "DELETE FROM order_items WHERE order_id = ?";
        $stmt_delete_items = $conn->prepare($sql_delete_items);
        $stmt_delete_items->bind_param("s", $order['order_id']);
        $stmt_delete_items->execute();

        // Step 4: Delete the order from order_details
        $sql_delete = "DELETE FROM order_details WHERE order_id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("s", $order['order_id']);
        $stmt_delete->execute();

        // Commit the transaction
        $conn->commit();

        // Redirect back to the orders page after deletion
        header("Location: admin.php#myorders");
    } catch (Exception $e) {
        // Rollback the transaction if any query fails
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the statements
        $stmt_fetch->close();
        $stmt_insert->close();
        $stmt_delete_items->close();
        $stmt_delete->close();
    }
}

$conn->close();
?>
