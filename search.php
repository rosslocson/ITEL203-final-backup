<?php
include_once("includedb.php");
include_once("includedb_admin.php");
include_once("includedb_orders.php");
include_once("config.php");

$searchResults = [];

if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Sanitize the search input to prevent SQL injection
    $search = mysqli_real_escape_string($mysqli, $search);

    // Construct the search query
    $searchQuery = "
        SELECT id, name, email, 'users' AS source FROM pawsnplay_users.users WHERE name LIKE '%$search%' OR email LIKE '%$search%'
         ";

    // Execute the search query
    $result = mysqli_query($mysqli, $searchQuery);

    // Check if the query execution was successful
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $searchResults[] = $row;
        }
    } else {
        $error = "Error: " . mysqli_error($mysqli);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Search</h2>
    <form action="search.php" method="GET">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search...">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($searchResults)): ?>
        <section id="search-results">
            <h2>Search Results</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Source</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($searchResults as $result): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['id']); ?></td>
                            <td><?php echo htmlspecialchars($result['name']); ?></td>
                            <td><?php echo isset($result['email']) ? htmlspecialchars($result['email']) : 'N/A'; ?></td>
                            <td><?php echo htmlspecialchars($result['source']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php endif; ?>
</div>
</body>
</html>
