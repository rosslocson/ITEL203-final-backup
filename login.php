<?php

/**
 * Name: Simple PHP Login & Registration Script
 * Tutorial: https://tutorialsclass.com/code/simple-php-login-registration-script
 */

// Start PHP session at the beginning 
session_start();

// Create database connection using config file
include_once("includedb.php");

// If form submitted, collect email and password from form
if (isset($_POST['login'])) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Retrieve the hashed password from the database for the given email
        $result = mysqli_query($mysqli, "SELECT password FROM users WHERE email='$email'");

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_hash = $row['password'];

            // Verify the password against the stored hash
            if (password_verify($password, $stored_hash)) {
                // Password is correct, store email in session and redirect
                $_SESSION['email'] = $email;
                header("location: profile.php");
            } else {
                echo "User email or password is not matched";
            }
        } else {
            echo "User email or password is not matched";
        }
    }
}

?>
