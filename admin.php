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
$phone_number = $user['phone_number'];
$gender = $user['gender'];

// Fetch pending orders
$pendingOrdersResult = mysqli_query($mysqli, "SELECT * FROM order_details WHERE user_id={$user['id']}");
$pendingOrders = mysqli_fetch_all($pendingOrdersResult, MYSQLI_ASSOC);

// Fetch completed orders
$completedOrdersResult = mysqli_query($mysqli, "SELECT * FROM completed_orders WHERE user_id={$user['id']}");
$completedOrders = mysqli_fetch_all($completedOrdersResult, MYSQLI_ASSOC);

// Initialize search query
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch users and orders based on search query
$searchResults = [];
if (!empty($searchQuery)) {
    $searchQueryEscaped = mysqli_real_escape_string($mysqli, $searchQuery);
    $searchQuerySql = "
        SELECT id, name, email, 'users' AS source FROM users WHERE name LIKE '%$searchQueryEscaped%' OR email LIKE '%$searchQueryEscaped%'
        UNION
        SELECT order_id AS id, user_name AS name, NULL AS email, 'order_details' AS source FROM order_details WHERE user_name LIKE '%$searchQueryEscaped%'
    ";
    $searchResults = mysqli_fetch_all(mysqli_query($mysqli, $searchQuerySql), MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css">

    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f8f8f8;
            color: black;
        }

        .container-fluid {
            padding: 0;
        }

        .sidebar {
            background-color: #00235b;
            color: white;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
        }

        .sidebar ul {
            list-style-type: none;
            padding-left: 0;
        }

        .sidebar li {
            padding: 10px 20px;
            border-bottom: 1px solid #555;
        }

        .sidebar li:hover,
        .sidebar ul a:hover {
            background-color: #ffdd83;
            color: black;
        }

        a {
            font-family: 'Lato', sans-serif;
            color: white;
        }

        .content {
            padding: 20px;
        }

        section {
            flex-grow: 1;
            padding-left: 350px;
            margin-bottom: 30%;
        }

        h1 {
            margin-top: 0;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-sm-4 {
            flex: 1 1 33%;
            display: flex;
        }

        h2 {
            margin: 0;
        }

        .dashboard-card {
            padding: 20px;
            margin: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 450px;
            /* Fixed width */
            height: 200px;
            /* Fixed height */
            font-size: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }

        .card-title {
            margin-top: 0;
        }

        .customers-card {
            background-color: #2A629A;
        }

        .orders-card {
            background-color: #2D9596;
        }

        .sales-card {
            background-color: #FF7F3E;
        }

        #logo {
            border-radius: 100%;
            margin-left: 80px;
        }

        .inbox-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .message {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .message:last-child {
            border-bottom: none;
        }

        .message-header {
            font-weight: bold;
        }

        .message-email {
            color: #888;
        }

        .message-body {
            margin-top: 10px;
        }

        .message-time {
            color: #bbb;
            font-size: 12px;
        }
    </style>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

    <div class="container-fluid">
        <?php include 'dashboard.php'; ?>
        <div class="row">
            <!-- Sidebar -->
            <div class="col-sm-3 sidebar">
                <img id="logo" height="100px" width="120px" src="logo3.jpg" alt="logo">
                <ul>
                    <br>
                    <li><a href="admin.php#dashboard">DASHBOARD</a></li>
                    <li><a href="admin.php#customers">CUSTOMERS</a></li>
                    <li><a href="admin.php#orders">ORDERS</a></li>
                    <li><a href="admin.php#totalsales">TOTAL SALES</a></li>
                    <li><a href="admin.php#messages">MESSAGES</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                    <form class="navbar-form" method="GET" action="admin.php">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search" name="search"
                                value="<?php echo htmlspecialchars($searchQuery); ?>">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>

                    </form>
                </ul>

            </div>

            <section id="dashboard">
                <!-- Main Content -->
                <img height="200px" width="400px" src="dashboard.png" alt="dashboard">
                <div class="col-sm-9 content">

                    <div class="row">
                        <!-- Customers Card -->
                        <div class="col-sm-4">
                            <div class="dashboard-card customers-card">
                                <h2 class="card-title">Customers</h2>
                                <p>Total customers: <strong><br><?php echo $total_customers; ?></strong></p>
                            </div>
                        </div>

                        <!-- Orders Card -->
                        <div class="col-sm-4">
                            <div class="dashboard-card orders-card">
                                <h2 class="card-title">Orders</h2>
                                <p>Total orders:<strong><br><?php echo $total_orders; ?></strong></p>
                            </div>
                        </div>

                        <!-- Income Card -->
                        <div class="col-sm-4">
                            <div class="dashboard-card sales-card">
                                <h2 class="card-title">Total Sales</h2>
                                <p>Total Sales:<strong><br>₱ <?php echo $overall_total; ?></strong></p>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <section>

                <?php if (!empty($searchResults)): ?>
                    <section id="search-results">
                        <h2>Search Results</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($searchResults as $result): ?>
                                    <tr>
                                        <td><?php echo $result['id']; ?></td>
                                        <td><?php echo $result['name']; ?></td>
                                        <td><?php echo $result['email'] ?? 'N/A'; ?></td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </section>
                <?php endif; ?>
        </div>
    </div>
    </section>

    <section id="customers">
        <img height="200px" width="400px" src="customers.png" alt="customers">
        <div class="container table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'customers.php'; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section id="orders">
        <img height="200px" width="400px" src="pendingadmin.png" alt="pending">
        <div class="container table-container">
            <table class="table table-bordered table-stripe">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order Number</th>
                        <th>User ID</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'orders.php'; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <div class="container table-container">
            <img height="200px" width="400px" src="completedadmin.png" alt="completed">
            <table class="table table-bordered table-stripe">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer ID</th>
                 
                        <th>Reservation Date</th>
                        <th>Total Price</th>
                        <th>Complete At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($completedOrders as $order): ?>
                        <tr>
                            <td><?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['user_id']; ?></td>
                           
                            <td><?php echo $order['reservation_date']; ?></td>
                            <td>P<?php echo number_format($order['total_price'], 2); ?></td>
                            <td><?php echo $order['deleted_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($completedOrders)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No completed orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section id="totalsales">
        <img height="200px" width="400px" src="totalsales.png" alt="total sales">
        <br>
        <h1>₱<?php echo $overall_total; ?></h1>
    </section>

    <section id="messages">
        <div class="inbox-container table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Message</th>
                        <th>Message Received at</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'messages.php'; ?>
                </tbody>
            </table>
        </div>
    </section>


</body>

</html>