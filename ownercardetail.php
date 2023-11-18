<?php
require 'dbconnect.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    echo $userId;
} else {
    echo "User ID not found";
}
$carId = $_GET['car_id'];
$getCarSQL = "SELECT * FROM table_car WHERE car_id=$carId";
$result = mysqli_query($conn, $getCarSQL);
$row = mysqli_fetch_assoc($result);
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $deleteSQL = "DELETE FROM table_car WHERE car_id=$carId";
        $result = mysqli_query($conn, $deleteSQL);
        if ($result) {
            header("Location: ownercar.php");
            exit();
        } else {
            $errors[] = "Error deleting data: " . mysqli_error($conn);
        }
    }
    if (isset($_POST['edit'])) {
        header("Location: editcar.php?car_id=$carId");
        exit();
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



    <!-- content -->
    <?php
    if (mysqli_num_rows($result) > 0) {
    ?>
        <section class="py-5">
            <div class="container">
                <div class="row gx-5">
                    <aside class="col-lg-6">
                        <div class="border rounded-4 mb-3 d-flex justify-content-center">
                            <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image" href="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big.webp">
                                <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="<?php echo $row['car_image']; ?>" />
                            </a>
                        </div>
                    </aside>

                    <main class="col-lg-6">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="ps-lg-3">
                                <h3 class="title text-dark">
                                    <?php echo $row['car_name']; ?>
                                </h3>
                                <div class="d-flex flex-row my-3">
                                    <span class="text-success ms-2">Available</span>
                                </div>

                                <div class="mb-3">
                                    <span class="h5">RM<?php echo $row['car_price']; ?></span>
                                    <span class="text-muted">/per hour</span>
                                </div>
                                <div class="col">
                                    <span class="h4">Description</span>
                                    <p>
                                        <?php echo $row['car_description']; ?>
                                    </p>
                                </div>


                                <div class="row">
                                    <span class="h4">Details</span>
                                    <dt class="col-3">Type</dt>
                                    <dd class="col-9"><?php echo $row['car_type']; ?></dd>

                                    <dt class="col-3">State</dt>
                                    <dd class="col-9"><?php echo $row['car_state']; ?></dd>
                                    <dt class="col-3">Location</dt>
                                    <dd class="col-9"><?php echo $row['car_location']; ?></dd>
                                </div>
                                <hr />
                            </div>
                            <button class="btn btn-danger shadow-0" type="submit" name="delete">Delete Car</button>
                            <button class="btn btn-warning shadow-0" type="submit" name="edit">Edit Car</button>
                        </form>
                    </main>
                </div>
            </div>
        </section>
    <?php
    } else {
        echo "<p>No products available</p>";
    }
    ?>
    <!-- content -->



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>