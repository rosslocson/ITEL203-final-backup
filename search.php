<?php
include_once("includedb.php");

$search = $_GET['search'];

$searchQuery = "
    SELECT id, name, email, 'users' AS source FROM users WHERE name LIKE '%$search%' OR email LIKE '%$search%'
    UNION
    SELECT order_id AS id, user_name AS name, NULL AS email, 'order_details' AS source FROM order_details WHERE user_name LIKE '%$search%'";

$result = mysqli_query($mysqli, $searchQuery);

if ($result) {
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Source</th></tr></thead>";
    echo "<tbody>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . (!is_null($row['email']) ? $row['email'] : '-') . "</td>";
        echo "<td>" . $row['source'] . "</td>";
        echo "</tr>";
    }
    
    echo "</tbody></table>";
} else {
    echo "Error: " . mysqli_error($mysqli);
}
?>
