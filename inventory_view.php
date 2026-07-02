<?php
session_start();
include 'dbconnect.php';
include 'nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<style>
    .hidden { display: none; }
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            margin-top: 40px;
            border-radius: 15px;
            background-color: #f8f9fa;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
  </style>
</head>
<body style="background-color: rgb(217, 227, 236);">


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

<div class="container mt-4"><br><br><br><br>
    <h2 class="text-center mb-4">View Inventory</h2>
    <form method="POST" class="form-inline justify-content-center mb-4">
        <label for="category" class="mr-2">Select Category:</label>
        <select name="category" id="category" class="form-control mr-3" required>
            <option value="">--Select--</option>
            <option value="chemicals">Chemicals</option>
            <option value="glassware">Glassware</option>
            <option value="instrument">Instruments</option>
        </select>
        <button type="submit" class="btn btn-primary">View</button>
    </form>
    
        <div class='mb-3'>
                <a class='btn btn-success btn-sm' href='inventory_form.php'>Add New</a>
                <a class='btn btn-warning btn-sm' href='inventory_update.php'>Update</a>
                <a class='btn btn-danger btn-sm' href='inventory_delete.php'>Delete</a>
              </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category'])) {
        $category = $_POST['category'];
        $allowed = ['chemicals', 'glassware', 'instrument'];
        if (!in_array($category, $allowed)) {
            echo "<div class='alert alert-danger'>Invalid category selected.</div>";
            exit;
        }


        $sql = "SELECT * FROM `$category`";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<div class='table-responsive'><table class='table table-bordered table-striped'>";
            echo "<thead class='thead-dark'><tr>";

            // Print headers dynamically
            while ($field = mysqli_fetch_field($result)) {
                echo "<th>" . ucfirst(str_replace('_', ' ', $field->name)) . "</th>";
            }
            echo "</tr></thead><tbody>";

            // Print rows dynamically
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach ($row as $val) {
                    echo "<td>" . htmlspecialchars($val) . "</td>";
                }
                echo "</tr>";
            }

            echo "</tbody></table></div>";
        } else {
            echo "<div class='alert alert-info'>No records found in $category.</div>";
        }
    }
    ?>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>