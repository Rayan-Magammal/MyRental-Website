<?php
require 'dbconnect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
}
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carName = $_POST['car_name'];
    $carPrice = $_POST['car_price'];
    $carDescription = $_POST['car_description'];

    // Validate form fields
    if (empty($carName)) {
        $errors[] = "Car name is required";
    }
    if (empty($carPrice)) {
        $errors[] = "Car price is required";
    }
    if (empty($carDescription)) {
        $errors[] = "Car description is required";
    }

    // Validate and handle image upload
    if ($_FILES['car_image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['car_image']['tmp_name'];
        $imageFileType = strtolower(pathinfo($_FILES['car_image']['name'], PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        $check = getimagesize($imageTmpName);
        if ($check === false) {
            $errors[] = "File is not an image";
        }

        // Check file extension
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        if (!in_array($imageFileType, $allowedExtensions)) {
            $errors[] = "Only JPG, JPEG, and PNG files are allowed";
        }

        // Upload the image if there are no errors
        if (empty($errors)) {
            $imagePath = 'images/' . uniqid() . '.' . $imageFileType;
            if (move_uploaded_file($imageTmpName, $imagePath)) {
                // Image uploaded successfully, proceed with database insertion
                $insertSQL = "INSERT INTO table_car (car_name, car_price, car_description, car_image,car_status,owner_id) VALUES ('$carName', '$carPrice', '$carDescription', '$imagePath','Available','$userId')";
                $result = mysqli_query($conn, $insertSQL);

                if ($result) {
                    // echo "Data inserted successfully";
                    header("Location: home.php");
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
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .main {
            background-image: url("https://picsum.photos/1920/1080");
            min-height: 100vh;
        }

        .navbar-scrolled {
            background-color: white !important;
        }

        #formcontainer {
            position: relative;
            backdrop-filter: blur(5px);
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 8px;
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
    <div class="main d-flex align-items-center">
        <div class="container p-4" style="width:500px; background-color:white; border-radius:8px;" id="formcontainer">
            <!-- <img class="mb-4" src="https://picsum.photos/64/64" alt="" width="72" height="57"> -->
            <h1 class="h3 mb-3 fw-normal">Add Car</h1>

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
                    <input type="text" class="form-control" id="car_name" name="car_name" placeholder="Enter car name">
                </div>
                <div class="mb-3">
                    <label for="car_price" class="form-label">Price</label>
                    <input type="text" class="form-control" id="car_price" name="car_price" placeholder="Enter car price">
                </div>
                <div class="mb-3">
                    <label for="car_description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="car_description" name="car_description" placeholder="Enter car description">
                </div>
                <div class="mb-3">
                    <label for="car_image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="car_image" name="car_image">
                </div>
                <button class="btn btn-outline-success" type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>