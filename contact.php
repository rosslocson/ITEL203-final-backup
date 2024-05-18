<?php
//including the database connection file
include_once ("includedb.php");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['comments'];

// Insert data into database
$sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
if ($mysqli->query($sql) === TRUE) {
    echo "Message sent successfully.";
    echo "<br><br><a href='index.html'>Back to Home Page</a>";
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}

// Close connection
$mysqli->close();

