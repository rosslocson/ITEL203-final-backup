<?php
//including the database connection file
include_once ("includedb.php");

// Check If form submitted, insert user data into database.
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // If email already exists, throw error
    $email_result = mysqli_query($mysqli, "select 'email' from users where email='$email' and password='$hashed_password'");

    // Count the number of row matched 
    $user_matched = mysqli_num_rows($email_result);

    // If number of user rows returned more than 0, it means email already exists
    if ($user_matched > 0) {
        echo "<br/><br/><strong>Error: </strong> User already exists with the email id '$email'.";
    } else {
        // Insert user data into database
        $result = mysqli_query($mysqli, "INSERT INTO users(username,password,name,email,address,age,gender,phone_number) VALUES('$username','$hashed_password','$name','$email','$address','$age','$gender','$phone_number')");

        // check if user data inserted successfully.
        if ($result) {
            echo "<br/><br/>User Registered successfully.<br>";
            echo '<a href="index.html">Click here to log in.</a>';

        } else {
            echo "Registration error. Please try again." . mysqli_error($mysqli);
        }
    }
}

