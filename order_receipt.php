<?php
session_start();

include_once ("includedb.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("location: login.html");
    exit;
}

// Get the user's email from the session
$email = $_SESSION['email'];

// Query to fetch user data
$result = mysqli_query($mysqli, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

// Check if user exists
if (!$user) {
    echo "User not found.";
    exit;
}

// Extract user data
$id = $user['id'];
$name = $user['name'];
$age = $user['age'];
$address = $user['address'];
$username = $user['username'];
$email = $user['email'];
$address = $user['address'];
$phone_number = $user['phone_number'];
$age = $user['age'];
$gender = $user['gender'];


// Fetch pending orders
$pendingOrdersResult = mysqli_query($mysqli, "SELECT * FROM order_details WHERE user_id={$user['id']}");
$pendingOrders = mysqli_fetch_all($pendingOrdersResult, MYSQLI_ASSOC);

// Fetch completed orders
$completedOrdersResult = mysqli_query($mysqli, "SELECT * FROM completed_orders WHERE user_id={$user['id']}");
$completedOrders = mysqli_fetch_all($completedOrdersResult, MYSQLI_ASSOC);




?>


<!DOCTYPE html>
<html lang="en">

<head>

    <title>Paws & Play</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css">
    <style>
        
.orderss {
    width: 80%;
    background-color: #FFDD83;
  
}
    </style>

</head>


<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">

                    <li><a href="home.html">HOME <span class="glyphicon glyphicon-home"></span></a></li>
                    <li><a href="profile.php#avail">AVAIL PACKAGES <span
                                class="glyphicon glyphicon-plus-sign"></span></a></li>

                    <li><a href="profile.php#myCart">MY CART <span class="glyphicon glyphicon-shopping-cart"></span></a>
                    </li>
                    <li><a href="profile.php#myorders">MY ORDERS <span class="glyphicon glyphicon-list-alt"></span></a>
                    </li>
                    <li><a href="logout.php">LOG OUT</a></li>
                </ul>
            </div>
        </div>
    </nav>
<center>
    <section action="profile.php#orderDetails" method="post">


    </section>
</center>
   
    <script>



        $(document).ready(function () {
            // Add smooth scrolling to all links in navbar + footer link
            $(".navbar a, footer a[href='#myPage']").on('click', function (event) {
                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 900, function () {

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                } // End if
            });

            $(window).scroll(function () {
                $(".slideanim").each(function () {
                    var pos = $(this).offset().top;

                    var winTop = $(window).scrollTop();
                    if (pos < winTop + 600) {
                        $(this).addClass("slide");
                    }
                });
            });
        })

    
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>