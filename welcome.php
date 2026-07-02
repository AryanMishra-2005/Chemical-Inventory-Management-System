<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>CIS</title>
  </head>
  <body>
    <?php
    session_start();
    
    ?>
    

<?php include 'style.html'?>
<?php include 'nav.php'?>


<body style=" background-color: rgb(217, 227, 236);">

    <div class="container-fluid">
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

            <div class="col-10 col-sm-9 col-xl-10 p-0 m-0">

                
                <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="images/transperancy.jpg" class="d-block w-100" style="height: 70vh;" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="images/Manage.jpg" class="d-block w-100" style="height: 70vh;" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="images/Compliant.webp" class="d-block w-100" style="height: 70vh;" alt="...">
                        </div>
                    </div>
                </div>





<div class="row row-cols-1 row-cols-md-2 g-4">
<div class="container my-5">
    <div class="row gx-1">
  <div class="card mb-3 me-3" style="width: 50rem;">
  <div class="card-body" style="background-image: url('images/bgcard3.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <h5 class="card-title"><b>Categories</b></h5><br>
    <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
    <p class="card-text"><b>Here you can manage your categories and you can add new parent and sub categories.</b></p>
    <a class="btn btn-primary" href="https://wwwn.cdc.gov/tsp/substances/ToxChemicalClasses.aspx" role="button">Know More</a>
  </div>
</div>
  <div class="card mb-3 me-3" style="width: 50rem;">
  <div class="card-body" style="background-image: url('images/bgcard2.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <h5 class="card-title"><b>Brands</b></h5><br>
    <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
    <p class="card-text"><b>Here you can verify which brands are excellent in chemical production.</b></p>
    <a class="btn btn-primary" href="https://www.sharescart.com/industry/chemicals/" role="button">Know more</a>
  </div>
</div>
  <div class="card mb-3 me-3" style="width: 50rem;">
  <div class="card-body" style="background-image: url('images/bgcard1.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <h5 class="card-title"><b>Product</b></h5><br>
    <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
    <p class="card-text"><b>Here you can manage your products and add products to cart.</b></p><br>
    <a class="btn btn-primary" href="inventory_form.php" role="button">Add to cart</a>
  </div>
</div>
</div>
</div>
</div>


<div class="row text-center">

        <?php
            include 'dbconnect.php';

            // Query product counts
            $counts = [
                "Chemicals" => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM chemicals"))['count'],
                "Glasswares" => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM glassware"))['count'],
                "Instruments" => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM instrument"))['count']
            ];

            // Icon map
            $icons = [
                "Chemicals" => "flask",
                "Glasswares" => "wine-glass-alt",
                "Instruments" => "microscope"
            ];

            // Color classes
            $colors = [
                "Chemicals" => "primary",
                "Glasswares" => "success",
                "Instruments" => "info"
            ];
        ?>

        <?php foreach ($counts as $item => $count): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-left-<?php echo $colors[$item]; ?> h-100 py-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title text-<?php echo $colors[$item]; ?>"><?php echo $item; ?></h5>
                                <h2 class="font-weight-bold"><?php echo $count; ?></h2>
                            </div>
                            <div>
                                <i class="fas fa-<?php echo $icons[$item]; ?> fa-3x text-<?php echo $colors[$item]; ?>"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>




<footer class="text-dark pt-5" style="background-color: rgb(198, 208, 214);">
    <div class="container px-5">
        <div class="row">
            <div class="col-6 col-lg-4">
                <h3 class="fw-bold">ABC Chemicals</h3>
                <p class="pt-2">Plot no- 001, Sector 321, ABC Chemicals, Taluka-Mangaon, District-Raigad, State-Maharashtra, Country-India, PIN-402103.</p>
                <p class="mb-2">0987654321</p>
                <p>1234567890</p>
            </div>
            <div class="col">
                <h4 class="fw-bold">Menu</h4>
                <ul class="list-unstyled pt-2">
                    <li class="py-1"><a class="nav-link" href="welcome.php">Home</a></li>
                    <li class="py-1"><a class="nav-link" href="#">Brands</a></li>
                    <li class="py-1"><a class="nav-link" href="#">About Us</a></li>
                    <li class="py-1"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="col">
                <h4 class="fw-bold">Our Solutions</h4>
                <ul class="list-unstyled pt-2">
                    <li class="py-1"><a class="nav-link" href="#">Environment, Health, Safety and Sustainability</a></li>
                    <li class="py-1"><a class="nav-link" href="#">Operational risk management</a></li>
                    <li class="py-1"><a class="nav-link" href="#">Sustainability Consulting</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-3 text-lg-end">
                <h4 class="fw-bold">Social Media Links</h4>
                <div class="social-media pt-2">
                    <a href="#" class="text-dark fs-2 me-3"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-dark fs-2 me-3"><i class="bi bi-pinterest"></i></a>
                    <a href="#" class="text-dark fs-2 me-3"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-dark fs-2"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
        <hr>
        <div class="d-sm-flex justify-content-between py-1">
            <p>2026 © ABC Chemicals. All Rights Reserved. </p>
            <p>
                <a href="#" class="text-dark text-decoration-none pe-4">Terms of use</a>
                <a href="#" class="text-dark text-decoration-none"> Privacy policy</a>
            </p>
        </div>
    </div>
</footer>


            </div>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!-- Table -->
    <div class="container my-5">
    
    </div>

    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>


</html>