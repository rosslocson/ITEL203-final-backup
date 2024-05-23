<?php
session_start();
include('includedb.php'); // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("location: login.html");
    exit;
}

// Get the user's email from the session
$email = $_SESSION['email'];

// Query to fetch user data
$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

// Check if user exists
if (!$user) {
    echo "User not found.";
    exit;
}

// Store user ID in session if not already stored
if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = $user['id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $name = htmlspecialchars($_POST['name']);
    $username = htmlspecialchars($_POST['username']);
    $age = (int)$_POST['age'];
    $address = htmlspecialchars($_POST['address']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $gender = htmlspecialchars($_POST['gender']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format');
    }

    // Assuming you have the user ID stored in session
    $id = $_SESSION['id'];

    // Update the database
    $sql = "UPDATE users SET name=?, username=?, age=?, address=?, email=?, phone_number=?, gender=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssisissi', $name, $username, $age, $address, $email, $phone_number, $gender, $id);

    if ($stmt->execute()) {
        echo "Profile updated successfully.";
        // Optionally, redirect to the profile page
        header('Location: profile.php');
        exit;
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
