<?php
include ("includedb.php");
include ("includedb_admin.php");
include ("config.php");
include ("includedb_orders.php");

// SQL query to fetch all orders
$sql = "SELECT order_details.id, 
order_details.order_id, 
order_details.user_id, 
users.name, 
order_details.reservation_date, 
order_details.total_price  FROM order_details
JOIN 
    pawsnplay_users.users 
ON 
    order_details.user_id = pawsnplay_users.users.id";
$result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["order_id"] . "</td>";
                echo "<td>" . $row["user_id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["reservation_date"] . "</td>";
                echo "<td>" . $row["total_price"] . "</td>";
                echo "<td>
                <form method='POST' action='complete_order.php' style='display:inline-block;'>
                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                    <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                </form>
              </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No orders found</td></tr>";
        }