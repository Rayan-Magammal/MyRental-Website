<?php
require 'dbconnect.php';
$errors = [];
$carId = $_GET['car_id'];
$getCarSQL = "SELECT * FROM table_car WHERE car_id='$carId'";
$result = mysqli_query($conn, $getCarSQL);
$row = mysqli_fetch_assoc($result);
$carName = isset($row['car_name']) ? $row['car_name'] : '';
$carPrice = isset($row['car_price']) ? $row['car_price'] : '';
$carDescription = isset($row['car_description']) ? $row['car_description'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // Delete the car record from the database
        $deleteSQL = "DELETE FROM table_car WHERE car_id=$carId";
        $result = mysqli_query($conn, $deleteSQL);
        if ($result) {
            header("Location: ownercar.php");
            exit();
        } else {
            $errors[] = "Error deleting data: " . mysqli_error($conn);
        }
    }
    if (isset($_POST['update'])) {
        $carName = $_POST['car_name'];
        $carPrice = $_POST['car_price'];
        $carDescription = $_POST['car_description'];
        if (empty($carName)) {
            $errors[] = "Car name is required";
        }
        if (empty($carPrice)) {
            $errors[] = "Car price is required";
        }
        if (empty($carDescription)) {
            $errors[] = "Car description is required";
        }
        if ($_FILES['car_image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpName = $_FILES['car_image']['tmp_name'];
            $imageFileType = strtolower(pathinfo($_FILES['car_image']['name'], PATHINFO_EXTENSION));

            $check = getimagesize($imageTmpName);
            if ($check === false) {
                $errors[] = "File is not an image";
            }

            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if (!in_array($imageFileType, $allowedExtensions)) {
                $errors[] = "Only JPG, JPEG, and PNG files are allowed";
            }

            if (empty($errors)) {
                $imagePath = 'images/' . uniqid() . '.' . $imageFileType;
                if (move_uploaded_file($imageTmpName, $imagePath)) {

                    $updateSQL = "UPDATE table_car SET car_name = '$carName', car_price = '$carPrice', car_description = '$carDescription', car_image = '$imagePath' WHERE car_id = $carId";
                    $result = mysqli_query($conn, $updateSQL);

                    if ($result) {
                        header("Location: ownercardetail.php?car_id=$carId");
                        exit();
                    } else {
                        $errors[] = "Error inserting data: " . mysqli_error($conn);
                    }
                } else {
                    $errors[] = "Error uploading image";
                }
            }
        } else {
            $errors[] = "Image upload error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 100px;
        }

        .error {
            color: red;
        }
    </style>
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

        <div class="bg-primary text-white py-5">
            <div class="container py-5">
                <h1>
                    Best products & <br />
                    brands in our store
                </h1>
                <p>
                    Trendy Products, Factory Prices, Excellent Service
                </p>
                <button type="button" class="btn btn-outline-light">
                    Learn more
                </button>
                <button type="button" class="btn btn-light shadow-0 text-primary pt-2 border border-white">
                    <span class="pt-1">Purchase now</span>
                </button>
            </div>
        </div>
        <!-- Jumbotron -->
    </header>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Update Car Details</h1>

                <!-- Display validation errors if any -->
                <?php if (!empty($errors)) : ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error) : ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="car_name" class="form-label">Car Name</label>
                        <input type="text" class="form-control" id="car_name" name="car_name" placeholder="Enter car name" value="<?php echo $carName; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="car_price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="car_price" name="car_price" placeholder="Enter car price" value="<?php echo $carPrice; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="car_description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="car_description" name="car_description" placeholder="Enter car description" value="<?php echo $carDescription; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="car_image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="car_image" name="car_image">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary me-3" type="submit" name="update">Update</button>
                        <button class="btn btn-danger" type="submit" name="delete">Delete</button>
                    </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>