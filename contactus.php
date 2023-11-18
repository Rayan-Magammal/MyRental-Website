<?php
require 'dbconnect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['car_type']) && isset($_POST['location']) && isset($_POST['date'])) {
        $carType = $_POST["car_type"];
        $carLocation = $_POST["location"];
        $date = $_POST["date"];
        if ($carType != null && $carLocation != null && $date != null) {
            $getCarSQL = "SELECT * FROM table_car WHERE car_type LIKE '%$carType%' AND (car_location LIKE '%$carLocation%'OR car_state LIKE '%$carLocation%') AND car_status LIKE '%Available%'";
        } else if ($carType != null && $carLocation == null && $date == null) {
            $getCarSQL = "SELECT * FROM table_car WHERE car_type LIKE '%$carType%'";
        } else if ($carType == null && $carLocation != null && $date == null) {
            $getCarSQL = "SELECT * FROM table_car WHERE car_location LIKE '%$carLocation%' OR car_state LIKE '%$carLocation%'";
        } else if ($carType == null && $carLocation == null && $date != null) {
            $getCarSQL = "SELECT * FROM table_car WHERE car_status LIKE '%Available%'";
        } else {
            $getCarSQL = "SELECT * FROM table_car";
        }
    } else {
        $getCarSQL = "SELECT * FROM table_car WHERE car_status LIKE '%Available%'";
    }
} else {
    $getCarSQL = "SELECT * FROM table_car";
}



$result = mysqli_query($conn, $getCarSQL);

$totalResult = $result->num_rows;
$resultPerPage = 8;
$totalPages = ceil($totalResult / $resultPerPage);

// Get the current page number from the URL
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting index of the results based on the current page
$startingResultIndex = ($currentPage - 1) * $resultPerPage;

// Modify the SQL query to include the LIMIT clause
$getCarSQL .= " LIMIT $startingResultIndex, $resultPerPage";

// Execute the modified query to get the paginated results
$result = mysqli_query($conn, $getCarSQL);
// session_destroy();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .icon-hover:hover {
            border-color: #3b71ca !important;
            background-color: white !important;
        }

        .icon-hover:hover i {
            color: #3b71ca !important;
        }
    </style>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
</head>

<body>
    <header>
        <!-- Jumbotron -->
        <div class="p-3 text-center bg-white border-bottom">
            <div class="container">
                <div class="row">
                    <!-- Left elements -->
                    <nav class="navbar fixed-top navbar-expand-lg bg-white">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="#">
                                <img src="https://picsum.photos/30/24" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                                MyRental
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarText">
                                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <?php if (isset($_SESSION['user_id'])) : ?>
                                            <a href="ownercar.php" class="nav-link active">My Car</a>
                                        <?php else : ?>
                                            <a href="#!" class="nav-link active" data-bs-toggle="modal" data-bs-target="#loginModal">My Car</a>
                                        <?php endif; ?>
                                    </li>
                                    <li class="nav-item">
                                        <?php if (isset($_SESSION['user_id'])) : ?>
                                            <a href="cart.php" class="nav-link active">Cart</a>
                                        <?php else : ?>
                                            <a href="#!" class="nav-link active" data-bs-toggle="modal" data-bs-target="#loginModal">Cart</a>
                                        <?php endif; ?>
                                    </li>
                                    <li class="nav-item">
                                        <?php if (isset($_SESSION['user_id'])) : ?>
                                            <a href="order.php" class="nav-link active">Order</a>
                                        <?php else : ?>
                                            <a href="#!" class="nav-link active" data-bs-toggle="modal" data-bs-target="#loginModal">Order</a>
                                        <?php endif; ?>
                                    </li>
                                    <li class="nav-item">
                                        <?php if (isset($_SESSION['user_id'])) : ?>
                                            <a href="profile.php" class="nav-link active">Profile</a>
                                        <?php else : ?>
                                            <a href="#!" class="nav-link active" data-bs-toggle="modal" data-bs-target="#loginModal">Profile</a>
                                        <?php endif; ?>
                                    </li>
                                    <li class="nav-item">
                                        <?php if (isset($_SESSION['user_id'])) : ?>
                                            <a href="contactus.php" class="nav-link active">Contact US</a>
                                        <?php else : ?>
                                            <a href="#!" class="nav-link active" data-bs-toggle="modal" data-bs-target="#loginModal">Contact US</a>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                                <button class="btn btn-outline-success" type="submit">Login</button>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Jumbotron -->
    </header>
    <div class="container" style="min-height: 70vh; padding-top: 50px;">
        <div class="d-flex justify-content-center ">
            <div class="col-10">
                <form action="https://script.google.com/macros/s/AKfycbw41iUOb27UsP5VDRqhochnnmAvCZesdU8jg0170Wg/dev" method="POST" name="priform" id="priform">
                    <p class="h3 mb-3 text-center">Contact US</p>

                    <div class="form-group">
                        <b><label for="first_name">Name</label></b>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                    </div>
                    <br>

                    <div class="form-group">
                        <b><label for="email">Email</label></b>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Please Insert a valid email address because a response will be sent via email.
                        </small>
                    </div>
                    <div class="form-group">
                        <b><label for="email">Message</label></b>
                        <textarea class="form-control" id="message" name="message" placeholder="Message" required rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <footer class="text-center text-lg-start text-muted mt-3" style="background-color: #f5f5f5;">
        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start pt-4 pb-4">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-12 col-lg-3 col-sm-12 mb-2">
                        <!-- Content -->
                        <a href="" target="_blank" class="">
                            <img src="https://uploads-ssl.webflow.com/63b6f6ff12456b72bef92955/64aee46469a4b265ec3d8977_Screenshot_2023-07-13_013503-removebg-preview.png" height="35" />
                        </a>
                        <p class="mt-2 text-dark">
                            GROUP 8
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-6 col-sm-4 col-lg-2">
                        <!-- Links -->
                        <h6 class="text-uppercase text-dark fw-bold mb-2">
                            Store
                        </h6>
                        <ul class="list-unstyled mb-4">
                            <li><a class="text-muted" href="#">About us</a></li>
                            <li><a class="text-muted" href="#">Find store</a></li>
                            <li><a class="text-muted" href="#">Categories</a></li>
                            <li><a class="text-muted" href="#">Blogs</a></li>
                        </ul>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-6 col-sm-4 col-lg-2">
                        <!-- Links -->
                        <h6 class="text-uppercase text-dark fw-bold mb-2">
                            Information
                        </h6>
                        <ul class="list-unstyled mb-4">
                            <li><a class="text-muted" href="#">Help center</a></li>
                            <li><a class="text-muted" href="#">Money refund</a></li>
                            <li><a class="text-muted" href="#">Shipping info</a></li>
                            <li><a class="text-muted" href="#">Refunds</a></li>
                        </ul>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-6 col-sm-4 col-lg-2">
                        <!-- Links -->
                        <h6 class="text-uppercase text-dark fw-bold mb-2">
                            Support
                        </h6>
                        <ul class="list-unstyled mb-4">
                            <li><a class="text-muted" href="#">Help center</a></li>
                            <li><a class="text-muted" href="#">Documents</a></li>
                            <li><a class="text-muted" href="#">Account restore</a></li>
                            <li><a class="text-muted" href="#">My orders</a></li>
                        </ul>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-12 col-sm-12 col-lg-3">
                        <!-- Links -->
                        <h6 class="text-uppercase text-dark fw-bold mb-2">Newsletter</h6>
                        <p class="text-muted">Stay in touch with latest updates about our products and offers</p>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control border" placeholder="Email" aria-label="Email" aria-describedby="button-addon2" />
                            <button class="btn btn-light border shadow-0" type="button" id="button-addon2" data-mdb-ripple-color="dark">
                                Join
                            </button>
                        </div>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <div class="">
            <div class="container">
                <div class="d-flex justify-content-between py-4 border-top">
                    <!--- payment --->
                    <div>
                        <i class="fab fa-lg fa-cc-visa text-dark"></i>
                        <i class="fab fa-lg fa-cc-amex text-dark"></i>
                        <i class="fab fa-lg fa-cc-mastercard text-dark"></i>
                        <i class="fab fa-lg fa-cc-paypal text-dark"></i>
                    </div>
                    <!--- payment --->

                    <!--- language selector --->
                    <div class="dropdown dropup">
                        <a class="dropdown-toggle text-dark" href="#" id="Dropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false"> <i class="flag-united-kingdom flag m-0 me-1"></i>English </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="Dropdown">
                            <li>
                                <a class="dropdown-item" href="#"><i class="flag-united-kingdom flag"></i>English <i class="fa fa-check text-success ms-2"></i></a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="flag-poland flag"></i>Polski</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="flag-china flag"></i>中文</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="flag-japan flag"></i>日本語</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="flag-germany flag"></i>Deutsch</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="flag-france flag"></i>Français</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="flag-spain flag"></i>Español</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="flag-russia flag"></i>Русский</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="flag-portugal flag"></i>Português</a>
                            </li>
                        </ul>
                    </div>
                    <!--- language selector --->
                </div>
            </div>
        </div>
    </footer>
    <!-- <script>
            const form = document.forms['priform']
            function upload(){
                const reader = new FileReader()
                const photo1 = document.getElementById('photo1').files[0]
                const reader1 = new FileReader()
                const tf1= document.getElementById('tf1').files[0]

                reader.onload = function (){
                    document.getElementById('photofile').value=reader.result
                    document.getElementById('photoname').value=photo1.name
                    reader1.onload = function (){
                        document.getElementById('tffile').value=reader1.result
                        document.getElementById('tfname').value=tf1.name
                        document.getElementById('priform').submit()
                    }
                    reader1.readAsDataURL(tf1)
                }
                reader.readAsDataURL(photo1)
            }
            form.reset()
        </script> -->
</body>

</html>