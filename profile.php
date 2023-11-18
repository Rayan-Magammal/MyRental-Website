<?php
require 'dbconnect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
}

$getCarSQL = "SELECT * FROM table_car WHERE owner_id='$userId'";
$getUser = "SELECT * FROM table_user WHERE user_id='$userId'";
$resultUser = mysqli_query($conn, $getUser);
$userData = mysqli_fetch_assoc($resultUser);


$result = mysqli_query($conn, $getCarSQL);

$totalResult = $result->num_rows;
$resultPerPage = 4;
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
    <section class="h-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card">
                        <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                                <img src="<?= $userData['user_photo'] ?>" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
                                <a href="editprofile.php" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">Edit profile</a>

                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <h5><?= $userData['user_name'] ?></h5>
                            </div>
                        </div>


                        <div class="card-body p-4 text-black">

                            <div class="mb-5">
                                <p class="lead fw-normal mb-1">About</p>
                                <div class="col-lg-8">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Full Name</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0"><?= $userData['user_name'] ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Email</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0"><?= $userData['user_email'] ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Phone</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0"><?= $userData['user_phone'] ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Address</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0"><?= $userData['user_address'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <p class="lead fw-normal mb-0">MY Car</p>
                                    <p class="mb-0"><a href="#!" class="text-muted">Show all</a></p>
                                </div>
                                <div class="row">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <div class="col-lg-6 col-md-6 col-sm-6 d-flex">
                                                <div class="card w-100 my-2 shadow-2-strong">
                                                    <img src="<?php echo $row['car_image']; ?>" class="card-img-top" style="aspect-ratio: 1 / 1" />
                                                    <div class="card-body d-flex flex-column">
                                                        <h5 class="card-title"><?php echo $row['car_name']; ?></h5>
                                                        <p class="card-text">RM<?php echo $row['car_price']; ?></p>
                                                        <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                                            <a href="cardetail.php?car_id=<?php echo $row['car_id']; ?>" class="btn btn-primary shadow-0 me-1">View Car</a>
                                                            <?php if (isset($_SESSION['user_id'])) : ?>
                                                                <a href="#!" class="btn btn-primary shadow-0 me-1">Add To Cart</a>
                                                            <?php else : ?>
                                                                <a href="#!" class="btn btn-primary shadow-0 me-1" data-bs-toggle="modal" data-bs-target="#loginModal">Add To Cart</a>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Please login first</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <a href="login.php" class="btn btn-primary">Login</a>
                                                                    </div>
                                                                </div>
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
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>