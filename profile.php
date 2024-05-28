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


        #editbutton, #updatebutton {
            height: auto;
            width: auto;
            background-color: #00235B;
            color: white;
            border-radius: 5%;
            margin-left: 9%;
            margin-top: 2%;
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
                    <li><a href="profile.php#contact">MESSAGE US <span class="glyphicon glyphicon-envelope"></span></a></li>
                    <li><a href="logout.php">LOG OUT</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Container (Profile Section) -->
    <section id="profile" class="container-fluid bg-grey ">
        <div class="row">
            <div class="col-sm-8">
                <br>
                <br>
                <div class="profile-container">
                    <img height="200px" width="400px" src="userprofile.png" alt="user profile">
                    <ul>
                        <li><strong>Name: </strong><?php echo htmlspecialchars($name); ?></li>
                        <li><strong>Username: </strong><?php echo htmlspecialchars($username); ?></li>
                        <li><strong>Age: </strong><?php echo htmlspecialchars($age); ?></li>
                        <li><strong>Address: </strong><?php echo htmlspecialchars($address); ?></li>
                        <li><strong>Email Address: </strong><?php echo htmlspecialchars($email); ?></li>
                        <li><strong>Phone Number: </strong><?php echo htmlspecialchars($phone_number); ?></li>
                        <li><strong>Gender: </strong><?php echo htmlspecialchars($gender); ?></li>
                    </ul>
                    
                    <button id="editbutton" onclick="toggleEditForm()">Edit Profile</button>
              
                    <form id="editProfileForm" action="update_profile.php" method="POST" style="display:none;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                        <ul>
                        <br>
                            <li><strong>Name: </strong><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
                            </li>
                            <li><strong>Username: </strong><input type="text" name="username"
                                    value="<?php echo htmlspecialchars($username); ?>"></li>
                            <li><strong>Age: </strong><input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>"></li>
                            <li><strong>Address: </strong><input type="text" name="address"
                                    value="<?php echo htmlspecialchars($address); ?>"></li>
                            <li><strong>Email Address: </strong><input type="email" name="email"
                                    value="<?php echo htmlspecialchars($email); ?>"></li>
                            <li><strong>Phone Number: </strong><input type="tel" name="phone_number"
                                    value="<?php echo htmlspecialchars($phone_number); ?>"></li>
                            <li><strong>Gender:</strong>
                                <select name="gender">
                                    <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male
                                    </option>
                                    <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female
                                    </option>
                                    <option value="Other" <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>Other
                                    </option>
                                </select>
                            </li>
                        </ul>
                        <br>
                        <button id="updatebutton" class="btn btn-default" type="submit">Update Profile</button>
                    </form>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </section>



    <!-- Container (Profile Section) -->
    <center>

        <section id="avail" class="container-fluid">
            <div>
                <div>
                    <br>
                    <br>
                    <div>
                        <img height="200px" width="400px" src="avail.png" alt="avail services">
                        <table>
                            <thead>
                                <tr>
                                    <th>PRODUCT NAME</th>
                                    <th>PRODUCT ID</th>
                                    <th>PRICE</th>
                                    <th>QUANTITY</th>
                                    <th>TOTAL PRICE</th>
                                    <th>ADD TO CART</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Basic Grooming (Small Pets)</td>
                                    <td>1</td>
                                    <td>550.00</td>
                                    <td><input type="number" name="quantity1"></td>
                                    <td><span id="total1"></span></td>
                                    <td><button onclick="addToCart(1)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Basic Grooming (Medium Pets)</td>
                                    <td>2</td>
                                    <td>650.00</td>
                                    <td><input type="number" name="quantity2"></td>
                                    <td><span id="total2"></span></td>
                                    <td><button onclick="addToCart(2)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Basic Grooming (Large Pets)</td>
                                    <td>3</td>
                                    <td>750.00</td>
                                    <td><input type="number" name="quantity3"></td>
                                    <td><span id="total3"></span></td>
                                    <td><button onclick="addToCart(3)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Full Grooming (Small Pets)</td>
                                    <td>4</td>
                                    <td>700.00</td>
                                    <td><input type="number" name="quantity4"></td>
                                    <td><span id="total4"></span></td>
                                    <td><button onclick="addToCart(4)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Full Grooming (Medium Pets)</td>
                                    <td>5</td>
                                    <td>850.00</td>
                                    <td><input type="number" name="quantity5"></td>
                                    <td><span id="total5"></span></td>
                                    <td><button onclick="addToCart(5)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Full Grooming (Large Pets)</td>
                                    <td>6</td>
                                    <td>950.00</td>
                                    <td><input type="number" name="quantity6"></td>
                                    <td><span id="total6"></span></td>
                                    <td><button onclick="addToCart(6)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Basic Haircut</td>
                                    <td>7</td>
                                    <td>300.00</td>
                                    <td><input type="number" name="quantity7"></td>
                                    <td><span id="total7"></span></td>
                                    <td><button onclick="addToCart(7)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Face Trim</td>
                                    <td>8</td>
                                    <td>200.00</td>
                                    <td><input type="number" name="quantity8"></td>
                                    <td><span id="total8"></span></td>
                                    <td><button onclick="addToCart(8)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Paw Trimming</td>
                                    <td>9</td>
                                    <td>150.00</td>
                                    <td><input type="number" name="quantity9"></td>
                                    <td><span id="total9"></span></td>
                                    <td><button onclick="addToCart(9)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Eye Cleaning</td>
                                    <td>10</td>
                                    <td>100.00</td>
                                    <td><input type="number" name="quantity10"></td>
                                    <td><span id="total10"></span></td>
                                    <td><button onclick="addToCart(10)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Ear Cleaning</td>
                                    <td>11</td>
                                    <td>100.00</td>
                                    <td><input type="number" name="quantity11"></td>
                                    <td><span id="total11"></span></td>
                                    <td><button onclick="addToCart(11)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Teeth Brushing</td>
                                    <td>12</td>
                                    <td>150.00</td>
                                    <td><input type="number" name="quantity12"></td>
                                    <td><span id="total12"></span></td>
                                    <td><button onclick="addToCart(12)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Nail Clipping</td>
                                    <td>13</td>
                                    <td>100.00</td>
                                    <td><input type="number" name="quantity13"></td>
                                    <td><span id="total13"></span></td>
                                    <td><button onclick="addToCart(13)">Add to Cart</button></td>

                                </tr>

                                <tr>
                                    <td>Bath & Dry</td>
                                    <td>14</td>
                                    <td>250.00</td>
                                    <td><input type="number" name="quantity14"></td>
                                    <td><span id="total14"></span></td>
                                    <td><button onclick="addToCart(14)">Add to Cart</button></td>

                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

        </section>
    </center>

    <center>
        <section id="orders">
            <div id="myCart">
                <img height="200px" width="400px" src="cart.png" alt="cart">
                <table>
                    <thead>
                        <tr>
                            <th>PET SERVICE</th>
                            <th>QUANTITY</th>
                            <th>TOTAL PRICE</th>
                            <th>REMOVE FROM CART</button></th>
                        </tr>
                    </thead>
                    <tbody id="cartItems">

                    </tbody>
                    <tfoot>
                        <tr>

                            <td colspan="2"><strong>Total:</strong></td>
                            <td colspan="2"><strong></strong><span id="cartTotal"></span></strong></td>

                        </tr>
                    </tfoot>

                </table>
                <br>
                <tr colspan="5"><input type="datetime-local" id="reservationDate" required> </tr>
                <button class="delete" onclick="checkout()">Confirm Reservation</button>
            </div>
        </section>
    </center>

    <center>
        <section id="orderDetails">


        </section>

        <br>
    </center>

    <!-- Container (Orders Section) -->
    <center>
        <section id="myorders" class="container-fluid">
            <div class="orderss">
                <div class="col-sm-12">
                    <img height="200px" width="400px" src="myorders.png" alt="my orders">
                </div>
                <div class="col-sm-6">
                    <div class="row">

                        <img height="150px" width="300px" src="pending.png" alt="pending orders">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                 
                                    <th>Total Price</th>
                                    <th>Reservation Date</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($pendingOrders) > 0): ?>
                                    <?php foreach ($pendingOrders as $order): ?>
                                        <tr>
                                            <td><?php echo $order['order_id']; ?></td>
                                            
                                            <td>₱<?php echo number_format($order['total_price'], 2); ?></td>
                                            <td><?php echo $order['reservation_date']; ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No pending appointments/orders.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="orderss">
                <div class="col-sm-6">
                    <div class="row">
                        <img height="150px" width="300px" src="completed.png" alt="completed orders">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Total Price</th>
                                    <th>Reservation Date</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($completedOrders) > 0): ?>
                                    <?php foreach ($completedOrders as $order): ?>
                                        <tr>
                                            <td><?php echo $order['order_id']; ?></td>
                                            <td>₱<?php echo number_format($order['total_price'], 2); ?></td>
                                            <td><?php echo $order['reservation_date']; ?></td>
                                           
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No completed orders/appointments.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </section>


    </center>

  <!-- Container (Contact Section) -->
  <section id="contact">
        <div class="container-fluid bg-grey">
            <br>
            <h2 class="text-center">CONTACT</h2>
            <div class="row">
                <div class="col-sm-5">
                    <p>Contact us and we'll get back to you within 24 hours.</p>
                    <p><span class="glyphicon glyphicon-map-marker"></span> San Pablo City, Laguna</p>
                    <p><span class="glyphicon glyphicon-phone"></span> +639123456789</p>
                    <p><span class="glyphicon glyphicon-envelope"></span> pawsandplay@gmail.com</p>
                </div>
                <div class="col-sm-7 slideanim">
                    <form action="contact.php" method="post">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="name">Name:</label>
                                <input class="form-control" id="name" name="name" placeholder="Name" type="text"
                                    required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="email">Email:</label>
                                <input class="form-control" id="email" name="email" placeholder="Email" type="email"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comments">Message:</label>
                            <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"
                                required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <button class="btn btn-default pull-right" type="submit">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
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

        function addToCart(productId) {
            var quantity = parseInt(document.getElementsByName("quantity" + productId)[0].value);
            var price = parseFloat(document.getElementsByTagName("tr")[productId].getElementsByTagName("td")[2].innerHTML);
            var total = quantity * price;
            document.getElementById("total" + productId).innerHTML = total.toFixed(2);

            // Add logic here to manage the cart and calculate the total price of all items
            var productName = document.getElementsByTagName("tr")[productId].getElementsByTagName("td")[0].innerHTML;
            var reservationDate = document.getElementById("reservationDate").value;
            var cartItemId = "cartItem_" + productId;
            var cartItem = "<tr id='" + cartItemId + "'><td>" + productName + "</td><td>" + quantity + "</td><td>" + total.toFixed(2) + "</td><td><button class='delete' onclick='deleteItem(\"" + cartItemId + "\")'>Delete</button></td></tr>";
            $("#cartItems").append(cartItem);

            updateCartTotal();
        }

        function deleteItem(cartItemId) {
            $("#" + cartItemId).remove();
            updateCartTotal();
        }

        function updateCartTotal() {
            var total = 0;
            $("#cartItems tr").each(function () {
                total += parseFloat($(this).find("td:eq(2)").text());
            });
            $("#cartTotal").text(total.toFixed(2));

            if ($("#cartItems tr").length > 0) {
                $("#myCart").show();
            } else {
                $("#myCart").hide();
            }
        }
        function checkout() {
            var reservationDate = document.getElementById("reservationDate").value;
            var total = parseFloat($("#cartTotal").text());

            // Retrieve user details from the PHP variables
            var userId = "<?php echo $user['id']; ?>";
            var userName = "<?php echo $user['name']; ?>";
            var userAddress = "<?php echo $user['address']; ?>";


            // Generate a random order ID (for demonstration purposes)
            var orderId = "ORD" + Math.floor(Math.random() * 1000000);

            // Prepare the order details to be sent to the server
            var orderItems = [];
            $("#cartItems tr").each(function () {
                var productName = $(this).find("td:eq(0)").text();
                var quantity = parseInt($(this).find("td:eq(1)").text());
                var totalPrice = parseFloat($(this).find("td:eq(2)").text());
                orderItems.push({

                    productName: productName,
                    quantity: quantity,
                    totalPrice: totalPrice
                });
            });

            var orderDetails = "<section>" + "<div class='order-details-container'>" +
                "<img src='receipt.png' alt='reservation receipt' style='height: 150px; width: 300px;'>" + // Add the image here
                "<strong><p style='color: red;'>Important Reminder: Please come on your SCHEDULED APPOINTMENT. Thank you!</p></strong>" +
                "<p><strong>Order ID:</strong> " + orderId + "</p>" +
                "<p><strong>Customer ID:</strong> " + userId + "</p>" +
                "<p><strong>Customer Name:</strong> " + userName + "</p>" +
                "<p><strong>Address:</strong> " + userAddress + "</p>" +
                "<p><strong>Reservation Date:</strong> " + reservationDate + "</p>" +
                "<p><strong>Total Amount to be Paid:</strong> P" + total.toFixed(2) + "</p>" +
                "<img src='booked.png' alt='booked services' style='height: 150px; width: 300px;'>";
            for (var i = 0; i < orderItems.length; i++) {
                orderDetails += "<li>" + orderItems[i].productName + " - Quantity: " + orderItems[i].quantity + " - Total Price: " + orderItems[i].totalPrice.toFixed(2) + "</li>";
            }
            orderDetails += "</ul>" + "</div>" + "</section>";

            $("#orderDetails").html(orderDetails);



            // Send the order details to the server using AJAX
            $.ajax({
                url: "save_order_details.php",
                method: "POST",
                data: {
                    orderId: orderId,
                    userId: userId,
                    userName: userName,
                    userAddress: userAddress,
                    reservationDate: reservationDate,
                    total: total,
                    orderItems: orderItems
                },
                success: function (response) {
                    // Handle the server's response
                    console.log(response);
                    // For example, you can show a success message to the user
                    alert("Order placed successfully!");
                    window.location.href = 'profile.php#orderDetails';
                    // Clear the cart and update the UI
                    $("#cartItems").empty();
                    $("#cartTotal").text("0.00");
                },
                error: function (xhr, status, error) {
                    // Handle errors here
                    console.error(xhr.responseText);
                    alert("An error occurred while placing the order. Please try again.");
                }
            });
        }

    </script>

    <script>
        function toggleEditForm() {
            var form = document.getElementById('editProfileForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>