<?php
require 'dbconnect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    echo $userId;
} else {
    echo "User ID not found";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $deletedcartId = $_POST["cart_id"];
        $deleteSQL = "DELETE FROM table_cart WHERE cart_id=$deletedcartId";
        $result = mysqli_query($conn, $deleteSQL);
        if ($result) {
        } else {
            $errors[] = "Error deleting data: " . mysqli_error($conn);
        }
    }
    if (isset($_POST['edit'])) {
        header("Location: editcar.php?car_id=$carId");
        exit();
    }
}
// $carId = $_GET['car_id'];
$getRental = "SELECT * FROM table_rental
WHERE user_id = $userId";
$result = mysqli_query($conn, $getRental);

$totalResult = $result->num_rows;
$resultPerPage = 6;
$totalPages = ceil($totalResult / $resultPerPage);

// Get the current page number from the URL
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting index of the results based on the current page
$startingResultIndex = ($currentPage - 1) * $resultPerPage;

// Modify the SQL query to include the LIMIT clause
$getRental .= " LIMIT $startingResultIndex, $resultPerPage";

// Execute the modified query to get the paginated results
$result = mysqli_query($conn, $getRental);
// session_destroy();

?>
<!doctype html>
<html lang="en">

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
    <script>
        window.addEventListener('scroll', function() {
            var navbar = document.querySelector('.navbar');
            navbar.classList.toggle('navbar-scrolled', window.scrollY > 0);
        });
    </script>
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
                                <?php if (isset($_SESSION['user_id'])) : ?>
                                    <a href="?logout=true" class="btn btn-primary">Log Out</a>
                                <?php else : ?>
                                    <a href="login.php" class="btn btn-primary">Log In</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </header>
    <!-- Products -->
    <section>
        <div class="container my-5">
            <header class="mb-4">
                <h3>My Order</h3>
            </header>

            <div class="row">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['rental_duration'] >= 24) {
                            $totalhoursduration = $row['rental_duration'];
                            $days = intval($totalhoursduration / 24);
                            $hours = $totalhoursduration - ($days * 24);
                        } else {
                            $days = 0;
                            $hours = $row['rental_duration'];
                            $totalhoursduration = $hours;
                        }
                        $carsql= "SELECT * FROM table_car WHERE car_id = $row[car_id]";
                        $cardata=mysqli_query($conn,$carsql);
                        $carrow=mysqli_fetch_assoc($cardata)
                ?>
                        <div class="card mb-4">
                            <div class="card-body p-4">

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="<?= $carrow['car_image'] ?>" class="img-fluid" alt="Generic placeholder image">
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <p class="small text-muted mb-4 pb-2">Car Name</p>
                                            <p class="lead fw-normal mb-0"><?= $carrow['car_name'] ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <p class="small text-muted mb-4 pb-2">Date</p>
                                            <p class="lead fw-normal mb-0">
                                                <?= $row['rental_start_date'] ?> <?= $row['rental_start_time'] ?> - <?= $row['rental_end_date'] ?> <?= $row['rental_end_time'] ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <p class="small text-muted mb-4 pb-2">Duration</p>
                                            <p class="lead fw-normal mb-0"><?= $days ?> days <?= $hours ?>hours</p>
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <p class="small text-muted mb-4 pb-2">Total</p>
                                            <p class="lead fw-normal mb-0">RM<?= $row['rental_price'] ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <p class="small text-muted mb-4 pb-2">Status</p>
                                            <p class="lead fw-normal mb-0"><?= $row['rental_status'] ?></p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>No products available</p>";
                }
                ?>

            </div>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-4">
                <?php if ($currentPage > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                    <li class="page-item <?php echo ($page == $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </section>
    <!-- Products -->

    <!-- Feature -->
    <section class="mt-5" style="background-color: #f5f5f5;">
        <div class="container text-dark pt-3">
            <header class="pt-4 pb-3">
                <h3>Why choose us</h3>
            </header>

            <div class="row mb-4">
                <div class="col-lg-4 col-md-6">
                    <figure class="d-flex align-items-center mb-4">
                        <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                            <i class="fas fa-camera-retro fa-2x fa-fw text-primary floating"></i>
                        </span>
                        <figcaption class="info">
                            <h6 class="title">Reasonable prices</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
                        </figcaption>
                    </figure>
                    <!-- itemside // -->
                </div>
                <!-- col // -->
                <div class="col-lg-4 col-md-6">
                    <figure class="d-flex align-items-center mb-4">
                        <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                            <i class="fas fa-star fa-2x fa-fw text-primary floating"></i>
                        </span>
                        <figcaption class="info">
                            <h6 class="title">Trusted Car</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
                        </figcaption>
                    </figure>
                    <!-- itemside // -->
                </div>
                <!-- col // -->
                <div class="col-lg-4 col-md-6">
                    <figure class="d-flex align-items-center mb-4">
                        <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                            <i class="fas fa-plane fa-2x fa-fw text-primary floating"></i>
                        </span>
                        <figcaption class="info">
                            <h6 class="title">Many Item</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
                        </figcaption>
                    </figure>
                    <!-- itemside // -->
                </div>
                <!-- col // -->
                <!-- col // -->
            </div>
        </div>
        <!-- container end.// -->
    </section>
    <!-- Feature -->

    <!-- Blog -->
    <section class="mt-5 mb-4">
        <div class="container text-dark">
            <header class="mb-4">
                <h3>News</h3>
            </header>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <article>
                        <a href="#" class="img-fluid">
                            <img class="rounded w-100" src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/1.webp" style="object-fit: cover;" height="160" />
                        </a>
                        <div class="mt-2 text-muted small d-block mb-1">
                            <span>
                                <i class="fa fa-calendar-alt fa-sm"></i>
                                23.12.2022
                            </span>
                            <a href="#">
                                <h6 class="text-dark">How to promote brands</h6>
                            </a>
                            <p>When you enter into any new area of science, you almost reach</p>
                        </div>
                    </article>
                </div>
                <!-- col.// -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <article>
                        <a href="#" class="img-fluid">
                            <img class="rounded w-100" src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/2.webp" style="object-fit: cover;" height="160" />
                        </a>
                        <div class="mt-2 text-muted small d-block mb-1">
                            <span>
                                <i class="fa fa-calendar-alt fa-sm"></i>
                                13.12.2022
                            </span>
                            <a href="#">
                                <h6 class="text-dark">How we handle shipping</h6>
                            </a>
                            <p>When you enter into any new area of science, you almost reach</p>
                        </div>
                    </article>
                </div>
                <!-- col.// -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <article>
                        <a href="#" class="img-fluid">
                            <img class="rounded w-100" src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/3.webp" style="object-fit: cover;" height="160" />
                        </a>
                        <div class="mt-2 text-muted small d-block mb-1">
                            <span>
                                <i class="fa fa-calendar-alt fa-sm"></i>
                                25.11.2022
                            </span>
                            <a href="#">
                                <h6 class="text-dark">How to promote brands</h6>
                            </a>
                            <p>When you enter into any new area of science, you almost reach</p>
                        </div>
                    </article>
                </div>
                <!-- col.// -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <article>
                        <a href="#" class="img-fluid">
                            <img class="rounded w-100" src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/4.webp" style="object-fit: cover;" height="160" />
                        </a>
                        <div class="mt-2 text-muted small d-block mb-1">
                            <span>
                                <i class="fa fa-calendar-alt fa-sm"></i>
                                03.09.2022
                            </span>
                            <a href="#">
                                <h6 class="text-dark">Success story of sellers</h6>
                            </a>
                            <p>When you enter into any new area of science, you almost reach</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog -->

    <!-- Footer -->
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
    <!-- Footer -->
    <script>
        function showLoginMessage() {
            alert("Please login to add the car to your cart.");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>