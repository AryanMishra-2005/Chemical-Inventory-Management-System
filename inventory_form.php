<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Inventory Entry Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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

<?php
session_start();
include 'dbconnect.php';
include 'nav.php';
include 'style.html';    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];

    if ($type === 'glassware') {
        $s_no = $_POST['glass_s_no'];
        $name = $_POST['glass_name'];
        $capacity = $_POST['glass_capacity'];
        $t_quantity = $_POST['glass_quantity'];
        $price = $_POST['glass_price'];
        $date = $_POST['glass_date'];
        $working=$_POST['glass_quantity'];

        $sql = "INSERT INTO glassware (s_no, name, capacity, t_quantity, price, working, date)
                VALUES ('$s_no', '$name', '$capacity', '$t_quantity', '$price','$working', '$date')";
    } elseif ($type === 'chemical') {
        $s_no = $_POST['chem_s_no'];
        $name = $_POST['chem_name'];
        $volume = $_POST['chem_volume'];
        $state = $_POST['chem_state'];
        $price = $_POST['chem_price'];
        $date = $_POST['chem_date'];

        $sql = "INSERT INTO chemicals (s_no, name, volume, state, price, date)
                VALUES ('$s_no', '$name', '$volume', '$state', '$price', '$date')";
    } elseif ($type === 'instrument') {
        $number = $_POST['instru_s_no'];
        $name = $_POST['instru_name'];
        $total_quantity = $_POST['instru_total_quantity'];
        $price = $_POST['instru_price'];
        $date = $_POST['instru_date'];

        $sql = "INSERT INTO instrument (number, name, total_quantity,price,date) 
                VALUES ('$number', '$name', '$total_quantity','$price','$date')";
    }
    

    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<div class="alert alert-success text-center">Entry added successfully!</div>';
        // Assuming session is started and user is logged in
        // Log the transaction
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $action = 'add';

            if (in_array($type, ['glassware', 'chemical', 'instrument'])) {
                $table = $type === 'chemical' ? 'chemicals' : $type;

                // Get the serial number from POST
                if ($type === 'glassware' && isset($_POST['glass_s_no'])) {
                    $s_no = $_POST['glass_s_no'];
                } elseif ($type === 'chemical' && isset($_POST['chem_s_no'])) {
                    $s_no = $_POST['chem_s_no'];
                } elseif ($type === 'instrument' && isset($_POST['instru_s_no'])) {
                    $s_no = $_POST['instru_s_no'];
                } else {
                    $s_no = null;
                }

                if ($s_no !== null) {
                    $sql_log = "INSERT INTO transactions (username, action, table_name, entry_id, timestamp)
                                VALUES (?, ?, ?, ?, NOW())";
                    $stmt_log = mysqli_prepare($conn, $sql_log);
                    mysqli_stmt_bind_param($stmt_log, "sssi", $username, $action, $table, $s_no);
                    mysqli_stmt_execute($stmt_log);
                }
            }
        }
    } else {
        echo '<div class="alert alert-danger text-center">Error: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<div class="container-fluid">
        <div class="row" style="height: 100vh">
            <div class="col-2 col-sm-3 col-xl-2 bg-dark">
                <nav class="nav flex-column sticky-top">
                    <a class="nav-link text-white" href="welcome.php"><i class="bi bi-house-door-fill"></i><span class="d-none d-sm-inline ms-2">Home</span></a><br>
                    <a class="nav-link text-white" href="category.html"><i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Category</span></a><br>
                    <a class="nav-link text-white" href="https://www.sharescart.com/industry/chemicals/"><i class="bi bi-building"></i><span class="d-none d-sm-inline ms-2">Brand</span></a><br>
                    <a class="nav-link text-white" href="inventory_form.php"><i class="bi bi-info-circle-fill"></i><span class="d-none d-sm-inline ms-2">Product</span></a><br>

                    <a class="nav-link text-white" href="inventory_view.php"><i class="bi bi-info-circle"></i><span class="d-none d-sm-inline ms-2">Inventory</span></a><br>
                    <a class="nav-link text-white" href="inventory_form.php"><i class="bi bi-cart-plus-fill"></i><span class="d-none d-sm-inline ms-2">Cart</span></a><br>
                </nav>

            </div>

<div class="container mt-4"><br><br><br><br>
  <h2 class="text-center">Inventory Entry</h2>
  <!-- Type Selector -->
   <div class="form-group">
    <label>Select Inventory Type</label>
    <select class="form-control" id="inventoryType" onchange="toggleForms()">
      <option disabled selected>-- Select Type --</option>
      <option value="glassware">Glassware</option>
      <option value="chemical">Chemical</option>
      <option value="instrument">Instrument</option>
    </select>
  </div>
    <div class='mb-3'>
            <a class='btn btn-success btn-sm' href='inventory_update.php'>Add</a>
            <a class='btn btn-danger btn-sm' href='inventory_delete.php'>Delete</a>
    </div>
    

    <div class="form-container">

  <!-- Glassware Form -->
   
  <form method="POST" action="inventory_form.php" id="glasswareForm" class="hidden">
    <input type="hidden" name="type" value="glassware">
    <div class="form-group">
      <label>Serial Number</label>
      <input type="number" name="glass_s_no" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Glassware Name</label>
      <input type="text" name="glass_name" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Capacity (mL)</label>
      <input type="text" name="glass_capacity" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Quantity Purchased</label>
      <input type="number" name="glass_quantity" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Invoice Value (INR)</label>
      <input type="number" name="glass_price" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Purchase Date</label>
      <input type="date" name="glass_date" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success btn-block">Add Glassware</button>
  </form>


  <!-- Chemical Form -->
  <form method="POST" action="inventory_form.php" id="chemicalForm" class="hidden">
    <input type="hidden" name="type" value="chemical">
    <div class="form-group">
      <label>Serial Number</label>
      <input type="number" name="chem_s_no" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Chemical Name</label>
      <input type="text" name="chem_name" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Quantity (kg or L)</label>
      <input type="number" name="chem_volume" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Physical State</label>
      <select name="chem_state" class="form-control" required>
        <option disabled selected>-- Select State --</option>
        <option value="Solid">Solid</option>
        <option value="Liquid">Liquid</option>
        <option value="Gas">Gas</option>
      </select>
    </div>
    <div class="form-group">
      <label>Invoice Value (INR)</label>
      <input type="number" name="chem_price" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Purchase Date</label>
      <input type="date" name="chem_date" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success btn-block">Add Chemical</button>
  </form>
    <!-- Instrument Form -->
  <form method="POST" action="inventory_form.php" id="instrumentForm" class="hidden">
    <input type="hidden" name="type" value="instrument">
    <div class="form-group">
      <label>Serial Number</label>
      <input type="number" name="instru_s_no" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Instrument Name</label>
      <input type="text" name="instru_name" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Total Quantity</label>
      <input type="number" name="instru_total_quantity" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Price (INR)</label>
      <input type="number" name="instru_price" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Purchase Date</label>
      <input type="date" name="instru_date" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success btn-block">Add Instrument</button>
  </form>
</div>

<!-- Script for toggling forms -->
<script>
  function toggleForms() {
    const type = document.getElementById('inventoryType').value;
    document.getElementById('glasswareForm').style.display = (type === 'glassware') ? 'block' : 'none';
    document.getElementById('chemicalForm').style.display = (type === 'chemical') ? 'block' : 'none';
    document.getElementById('instrumentForm').style.display = (type === 'instrument') ? 'block' : 'none';
  }
</script>

</body>
</html>