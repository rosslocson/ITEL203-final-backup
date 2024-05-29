<?php
// Include your database connection file
include_once("includedb.php");

// Query to fetch all pets
$query = "SELECT * FROM petcare.pets";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die(json_encode(array("success" => false, "message" => "Error fetching pets: " . mysqli_error($mysqli))));
}

// Fetch pets and store in an array
$pets = array();
while ($row = mysqli_fetch_assoc($result)) {
    $pets[] = array(
        "id" => $row["id"],
        "name" => $row["name"],
        "type" => $row["type"],
        "breed" => $row["breed"],
        "birthday" => $row["birthday"],
        "gender" => $row["gender"]
    );
}

// Return pets data as JSON
echo json_encode($pets);

// Close database connection
mysqli_close($mysqli);
?>
