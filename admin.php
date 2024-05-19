<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }

        .container-fluid {
            padding: 0;
        }

        .sidebar {
            background-color: #333;
            color: #fff;
            height: 100vh;
            padding-top: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding-left: 0;
        }

        .sidebar li {
            padding: 10px 20px;
            border-bottom: 1px solid #555;
        }

        .sidebar li:hover {
            background-color: #555;
        }

        .content {
            padding: 20px;
        }

        /* Style for the page title */
        h1 {
            margin-top: 0;
        }

        /* Style for the dashboard cards */
        .dashboard-card {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Style for the card titles */
        .card-title {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <?php include 'dashboard.php'; ?>
        <div class="row">
            <!-- Sidebar -->
            <div class="col-sm-3 sidebar">
                <ul>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="admin.php#customers">Customers</a></li>
                    <li><a href="admin.php#orders">Orders</a></li>
                    <li><a href="#">Income</a></li>
                    <li><a href="#">Settings</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </div>
            <!-- Main Content -->
            <div class="col-sm-9 content">
                <h1>Dashboard</h1>
                <div class="row">
                    <!-- Customers Card -->
                    <div class="col-sm-4">
                        <div class="dashboard-card">
                            <h2 class="card-title">Customers</h2>
                            <p>Total customers: <?php echo $total_customers; ?></p>
                        </div>
                    </div>
                    <!-- Orders Card -->
                    <div class="col-sm-4">
                        <div class="dashboard-card">
                            <h2 class="card-title">Orders</h2>
                            <p>Total orders: <?php echo $total_orders; ?></p>
                        </div>
                    </div>
                    <!-- Income Card -->
                    <div class="col-sm-4">
                        <div class="dashboard-card">
                            <h2 class="card-title">Income</h2>
                            <p>Total income: P<?php echo $overall_total; ?></p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <section id="customers">
            <h1>Customers Section</h1>

            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>

                    </tr>
                </thead>
                <tbody>

                    <?php include 'customers.php' ?>

                </tbody>
            </table>
        </section>

        <section id="orders">
            <h1>Orders</h1>

            <div class="container table-container">
                <h2>Orders</h2>
                <table class="table table-bordered">
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
                        <?php include 'orders.php' ?>
                    </tbody>
                </table>
            </div>
        </section>



        <section>
            <div class="container">
                <h1 class="text-center">Completed Orders</h1>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                        
                            <th>User ID</th>
                            <th>Reservation Date</th>
                            <th>Total Price</th>
                            <th>Deleted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($completed_orders as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                             
                                <td><?php echo $order['user_id']; ?></td>
                                <td><?php echo $order['reservation_date']; ?></td>
                                <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                                <td><?php echo $order['deleted_at']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($completed_orders)): ?>
                            <tr>
                                <td colspan="6" class="text-center">No completed orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <h2>Total Sales: <?php echo $overall_total; ?></h2>
            </div>
        </section>
</body>

</html>