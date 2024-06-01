<?php

include ("includedb.php");
include ("includedb_admin.php");
include ("config.php");
include ("includedb_orders.php");


// Retrieve customer details froms the database
$sql = "SELECT * FROM pawsnplay_admin.messages";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["name"]."</td>";
        echo "<td>".$row["email"]."</td>";
        echo "<td>".$row["message"]."</td>";
        echo "<td>".$row["created_at"]."</td>";
       
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Inbox Empty </td></tr>";
}

// Close database connection
$conn->close();
?>
