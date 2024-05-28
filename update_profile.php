<?php
session_start();

include_once("includedb.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $gender = $_POST['gender'];

    // Update user data
    $query = "UPDATE users SET name=?, username=?, age=?, address=?, email=?, phone_number=?, gender=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssissssi', $name, $username, $age, $address, $email, $phone_number, $gender, $id);

    if ($stmt->execute()) {
        // Update session email if the email was changed
        $_SESSION['email'] = $email;
        header("Location: profile.php");
        exit;
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
}
?>
