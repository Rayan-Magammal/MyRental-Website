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
    if (isset($_POST['addcart'])) {
        $cartSQL = "INSERT INTO table_cart (car_id, user_id) VALUES ('$carId', '$userId')";
        $result = mysqli_query($conn, $cartSQL);
        if ($result) {
            header("Location: home.php");
            exit();
        } else {
            $errors[] = "Error deleting data: " . mysqli_error($conn);
        }
    }
    if (isset($_POST['rent'])) {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $startTime = $_POST['startingTime'];
        $endTime = $_POST['endTime'];
        $totalDays = $_POST['durationDays'];
        $hours = $_POST['durationHours'];
        $daysToHours = $totalDays * 24;
        $totalDuration = $daysToHours + $hours;
        if ($totalDuration >= 24) {
            $totalPrice = ($row['car_price'] * 0.5) * $totalDuration;
        } else {
            $totalPrice = $row['car_price'] * $totalDuration;
        }
        $insertSQL = "INSERT INTO table_rental (user_id,car_id,rental_start_date, rental_end_date,rental_start_time, rental_end_time,rental_duration,rental_price,rental_status) VALUES ('$userId','$carId','$startDate', '$endDate','$startTime', '$endTime','$totalDuration','$totalPrice','Pending Payment')";
        $rentresult = mysqli_query($conn, $insertSQL);
        header("Location: payment.php?rental_id=$rentalId");
        // if ($rentresult) {
        //     header("Location: payment.php?rental_id=$rentalId");
        //     // echo "Form data submitted successfully.";
        // } else {
        //     echo "Error: " . mysqli_error($conn);
        // }
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
                                <dd class="col-9"><?php echo $row['car_name']; ?></dd>

                                <dt class="col-3">Color</dt>
                                <dd class="col-9"><?php echo $row['car_name']; ?></dd>

                                <dt class="col-3">Fuel</dt>
                                <dd class="col-9"><?php echo $row['car_name']; ?></dd>

                                <dt class="col-3">Year</dt>
                                <dd class="col-9"><?php echo $row['car_name']; ?></dd>
                            </div>

                            <hr />
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row mb-4">
                                    <div class="col-md-4 col-6">
                                        <label class="mb-2" for="startDate">Start Date</label>
                                        <input type="date" class="form-control" id="startDate" name="startDate" required onchange="updateEndTime()" />
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <label class="mb-2" for="endDate">End Date</label>
                                        <input type="date" class="form-control" id="endDate" name="endDate" required readonly />
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4 col-6">
                                            <label class="mb-2" for="startingTime">Starting Time</label>
                                            <input type="time" class="form-control" id="startingTime" name="startingTime" required onchange="updateEndTime()" />
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <label class="mb-2" for="endTime">End Time</label>
                                            <input type="time" class="form-control" id="endTime" name="endTime" required readonly />
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-6 mb-3">
                                        <label class="mb-2 d-block">Duration (in days)</label>
                                        <div class="input-group mb-3" style="width: 170px;">
                                            <button class="btn btn-white border border-secondary px-3" type="button" id="button-addon1" data-mdb-ripple-color="dark" onclick="decrementDuration('days')">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="text" class="form-control text-center border border-secondary" id="durationDays" name="durationDays" value="0" placeholder="0" aria-label="Example text with button addon" aria-describedby="button-addon1" readonly />
                                            <button class="btn btn-white border border-secondary px-3" type="button" id="button-addon2" data-mdb-ripple-color="dark" onclick="incrementDuration('days')">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6 mb-3">
                                        <label class="mb-2 d-block">Duration (in hours)</label>
                                        <div class="input-group mb-3" style="width: 170px;">
                                            <button class="btn btn-white border border-secondary px-3" type="button" id="button-addon1" data-mdb-ripple-color="dark" onclick="decrementDuration('hours')">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="text" class="form-control text-center border border-secondary" id="durationHours" name="durationHours" value="0" placeholder="0" aria-label="Example text with button addon" aria-describedby="button-addon1" readonly />
                                            <button class="btn btn-white border border-secondary px-3" type="button" id="button-addon2" data-mdb-ripple-color="dark" onclick="incrementDuration('hours')">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary shadow-0" type="submit" name="addcart">Add to cart</button>
                                <button class="btn btn-warning shadow-0" type="submit" name="rent">Rent now</button>
                            </form>
                        </div>
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


    <script>
        function updateEndTime() {
            var startingTimeInput = document.getElementById('startingTime');
            var endTimeInput = document.getElementById('endTime');
            var durationHoursInput = document.getElementById('durationHours');
            var durationDaysInput = document.getElementById('durationDays');

            var startingTime = new Date(`2000/01/01 ${startingTimeInput.value}`);
            var endTime = new Date(startingTime.getTime() + durationHoursInput.value * 60 * 60 * 1000);
            endTimeInput.value = formatTime(endTime);

            var startDate = new Date(document.getElementById('startDate').value);
            var endDate = new Date(startDate.getTime() + durationDaysInput.value * 24 * 60 * 60 * 1000);
            document.getElementById('endDate').value = formatDate(endDate);
        }

        function incrementDuration(type) {
            var durationHoursInput = document.getElementById('durationHours');
            var durationDaysInput = document.getElementById('durationDays');

            if (type === 'hours') {
                var currentDuration = parseInt(durationHoursInput.value);
                durationHoursInput.value = currentDuration + 1;
            } else if (type === 'days') {
                var currentDuration = parseInt(durationDaysInput.value);
                durationDaysInput.value = currentDuration + 1;

                var startDate = new Date(document.getElementById('startDate').value);
                var endDate = new Date(startDate.getTime() + (currentDuration + 1) * 24 * 60 * 60 * 1000);
                document.getElementById('endDate').value = formatDate(endDate);
            }

            updateEndTime();
        }

        function decrementDuration(type) {
            var durationHoursInput = document.getElementById('durationHours');
            var durationDaysInput = document.getElementById('durationDays');

            if (type === 'hours') {
                var currentDuration = parseInt(durationHoursInput.value);
                if (currentDuration > 0) {
                    durationHoursInput.value = currentDuration - 1;
                }
            } else if (type === 'days') {
                var currentDuration = parseInt(durationDaysInput.value);
                if (currentDuration > 0) {
                    durationDaysInput.value = currentDuration - 1;

                    var startDate = new Date(document.getElementById('startDate').value);
                    var endDate = new Date(startDate.getTime() + (currentDuration - 1) * 24 * 60 * 60 * 1000);
                    document.getElementById('endDate').value = formatDate(endDate);
                }
            }

            updateEndTime();
        }

        function formatDate(date) {
            var year = date.getFullYear();
            var month = (date.getMonth() + 1).toString().padStart(2, '0');
            var day = date.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function formatTime(time) {
            var hours = time.getHours().toString().padStart(2, '0');
            var minutes = time.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        // Initialize the start date to the current date
        var currentDate = new Date();
        var currentDateString = formatDate(currentDate);
        document.getElementById('startDate').value = currentDateString;

        // Initialize the start time to the current time
        var currentHours = currentDate.getHours().toString().padStart(2, '0');
        var currentMinutes = currentDate.getMinutes().toString().padStart(2, '0');
        document.getElementById('startingTime').value = `${currentHours}:${currentMinutes}`;

        // Set the initial end date and end time
        updateEndTime();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>