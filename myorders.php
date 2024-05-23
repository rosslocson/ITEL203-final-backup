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

// Validate and retrieve user_id from GET parameter
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    die("Error: user_id parameter is missing.");
}
// Fetch pending orders
$sql_pending = "SELECT od.order_id, od.user_id, u.name, od.reservation_date, od.total_price
                FROM order_details od
                JOIN users u ON od.user_id = u.id
                WHERE od.user_id = ?";
$stmt_pending = $conn->prepare($sql_pending);
$stmt_pending->bind_param("i", $user_id);
$stmt_pending->execute();
$result_pending = $stmt_pending->get_result();
$pending_orders = $result_pending->fetch_all(MYSQLI_ASSOC);

// Fetch completed orders
$sql_completed = "SELECT co.order_id, co.user_id, co.name, co.reservation_date, co.total_price, co.deleted_at
                  FROM completed_orders co
                  WHERE co.user_id = ?";
$stmt_completed = $conn->prepare($sql_completed);
$stmt_completed->bind_param("i", $user_id);
$stmt_completed->execute();
$result_completed = $stmt_completed->get_result();
$completed_orders = $result_completed->fetch_all(MYSQLI_ASSOC);

$stmt_pending->close();
$stmt_completed->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Pending Orders</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Reservation Date</th>
            <th>Total Price</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($pending_orders)): ?>
            <?php foreach ($pending_orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['name']); ?></td>
                    <td><?php echo htmlspecialchars($order['reservation_date']); ?></td>
                    <td>P<?php echo number_format($order['total_price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No pending orders found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <h2>Completed Orders</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Reservation Date</th>
            <th>Total Price</th>
            <th>Deleted At</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($completed_orders)): ?>
            <?php foreach ($completed_orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['name']); ?></td>
                    <td><?php echo htmlspecialchars($order['reservation_date']); ?></td>
                    <td>P<?php echo number_format($order['total_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($order['deleted_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">No completed orders found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
