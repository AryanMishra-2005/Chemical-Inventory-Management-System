<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

// Function to log a transaction
function log_transaction($conn, $username, $action, $table, $entry_id) {
    $stmt = mysqli_prepare($conn, "INSERT INTO transactions (username, action, table_name, entry_id) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssi", $username, $action, $table, $entry_id);
    mysqli_stmt_execute($stmt);
}

// Handle dynamic actions (insert/update/delete)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['table']) && isset($_POST['action'])) {
    $table = $_POST['table'];
    $action = $_POST['action'];
    $username = $_SESSION['username'];
    $entry_id = intval($_POST['entry_id']);

    // Log the transaction
    log_transaction($conn, $username, $action, $table, $entry_id);
    header("Location: transactions.php?logged=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<?php require 'nav.php'; ?>
<div class="row" style="height: 100vh">
            <div class="col-2 col-sm-3 col-xl-2 bg-dark">
                <nav class="nav flex-column sticky-top">
                    <a class="nav-link text-white" href="welcome.php"><i class="bi bi-house-door-fill"></i><span class="d-none d-sm-inline ms-2">Home</span></a><br>
                    <a class="nav-link text-white" href="category.html"><i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Category</span></a><br>
                    <a class="nav-link text-white" href="https://www.sharescart.com/industry/chemicals/"><i class="bi bi-building"></i><span class="d-none d-sm-inline ms-2">Brand</span></a><br>
                    <a class="nav-link text-white" href="transaction.php"><i class="bi bi-info-circle-fill"></i><span class="d-none d-sm-inline ms-2">Transaction</span></a><br>

                    <a class="nav-link text-white" href="inventory_view.php"><i class="bi bi-info-circle"></i><span class="d-none d-sm-inline ms-2">Inventory</span></a><br>
                    <a class="nav-link text-white" href="inventory_form.php"><i class="bi bi-cart-plus-fill"></i><span class="d-none d-sm-inline ms-2">Cart</span></a><br>
                </nav>

            </div>

<div class="container mt-4"><br><br>
    <h2 class="text-center mb-4">Inventory Activity Logs</h2>

    <?php if (isset($_GET['logged']) && $_GET['logged'] == 1): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Transaction successfully logged.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Product ID</th>
                    <th>Table Affected</th>
                    <th>Action</th>
                    <th>Username</th>
                    <th>Date & Time</th>
                    
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM `transactions` ORDER BY timestamp DESC";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['entry_id']}</td>
                                    <td>{$row['table_name']}</td>
                                    <td><span class='badge badge-" .
                                        ($row['action'] === 'add' ? 'success' : ($row['action'] === 'update' ? 'info' : 'danger')) .
                                        "'>" . ucfirst($row['action']) . "</span></td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['timestamp']}</td>
                                    
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No transaction records found.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    

</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>