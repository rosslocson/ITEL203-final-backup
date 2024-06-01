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

include ("includedb_admin.php");
include ("includedb.php");
include ("config.php");

// Retrieve customer details froms the database
$sql = "SELECT * FROM pawsnplay_users.users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["name"]."</td>";
        echo "<td>".$row["email"]."</td>";
       
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No customers found</td></tr>";
}

// Close database connection
$conn->close();
?>