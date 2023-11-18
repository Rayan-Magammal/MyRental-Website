<?php
require 'dbconnect.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  if (empty($email)) {
    $errors[] = "Email is required";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
  }
  if (empty($password)) {
    $errors[] = "Password is required";
  }

  if (empty($errors)) {
    $loginSQL = "SELECT * FROM table_user WHERE user_email = '$email' AND user_password = '$password'";
    $result = mysqli_query($conn, $loginSQL);

    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      session_start();
      $_SESSION['user_id'] = $row['user_id'];
      header("Location: home.php");
      exit();
    } else {
      $errors[] = "Invalid email or password";
    }
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

                <a href="register.php" class="btn btn-primary">Register php</a>


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
      <h1 class="h3 mb-3 fw-normal">Login</h1>

      <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
          <ul>
            <?php foreach ($errors as $error) : ?>
              <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="" method="post">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
        </div>
        <button class="btn btn-outline-success" type="submit">Log In</button>
      </form>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>