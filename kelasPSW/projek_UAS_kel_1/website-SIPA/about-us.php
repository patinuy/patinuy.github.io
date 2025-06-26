<?php
require_once 'auth.php';
require_once 'dbconnect.php';

// Ambil data user
$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    die("User tidak ditemukan di database.");
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us</title>


    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

  <style>
    .profile-section {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: center;
      padding: 80px 10%;
      background-color: #fff8f0; /* Sesuaikan jika ingin beda */
    }

    .profile-image {
      flex: 1 1 40%;
      text-align: center;
      padding: 20px;
    }

    .profile-image img {
      width: 300px;
      height: 300px;
      object-fit: cover;
      border-radius: 50%; /* Membuat gambar bulat */
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .profile-text {
      flex: 1 1 60%;
      padding-left: 40px;
    }

    .profile-text h2 {
      font-size: 36px;
      color: var(--primary-color); /* Sesuaikan dengan warna utama website */
      font-family: var(--heading-font);
      margin-bottom: 20px;
    }

    .profile-text p {
      font-size: 16px;
      line-height: 1.8;
      margin-bottom: 16px;
      font-family: var(--body-font);
    }

    .highlight-box {
      background: #ffcc00;
      padding: 10px 20px;
      font-weight: bold;
      font-size: 20px;
      color: black;
      display: inline-block;
      margin-top: 30px;
      border-radius: 6px;
    }

    @media (max-width: 768px) {
      .profile-section {
        flex-direction: column;
        text-align: center;
      }

      .profile-text {
        padding-left: 0;
      }
    }
  </style>
</head>
<body>
   <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.php" class="logo">
                        <img src="assets/images/logo.png" alt="" style="width: 158px;">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
             <ul class="nav">     
            <li><a href="index.php">Home</a></li>
            <li><a href="shop.php">Our Shop</a></li>
             <li><a href="contact.php" >Contact Us</a></li>
             <li><a href="about-us.php"class="active">About Us</a></li>

             <?php if (!isset($_SESSION['user'])): ?>
              <li><a href="adminpanel/login.php">Sign In</a></li>
             <?php endif; ?>

              <?php if (isset($_SESSION['user'])): ?>
              <li class="user-details-header">
              <p class="user-name">👤 <?= htmlspecialchars($_SESSION['user']['name']) ?></p>
              <a class="logout-link" href="adminpanel/logout.php">Logout</a>
               </li>
               <?php endif; ?>
             </ul>

              <a class="menu-trigger"><span>Menu</span></a>
              </nav>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h3>About Us</h3>
          <span class="breadcrumb"><a href="#">Home</a>  >  About-us</span>
        </div>
      </div>
    </div>
  </div>
  <!-- Profile Content -->
  <section class="profile-section">
    <div class="profile-image">
      <img src="assets/images/categories-01.png" alt="Dimsum Profile" />
    </div>
    <div class="profile-text">
      <h2>Profile</h2>
      <p>Dimsum merupakan makanan kecil yang sudah tidak asing lagi bagi penduduk Indonesia...</p>
      <p>Hadirnya Dimsum Yang di tengah-tengah masyarakat Indonesia untuk menjadi solusi menghadirkan dimsum dengan harga yang terjangkau...</p>
      <p>Menjadi #1 Pelopor Dimsum Prasmanan, kami memberikan konsep gerobak prasmanan, dengan lebih dari 30 varian menu dalam klakat...</p>
      <p>Dengan menu lebih dari 30 varian, Dimsum Yang sangat cocok menjadi jajanan untuk semua kalangan khususnya anak muda...</p>
      <p>Segera ambil peluang hebat ini.. Mari besar, berkembang dan menghasilkan bersama-sama.</p>

      <div class="highlight-box">#PELOPOR DIMSUM 1000 AN</div>
    </div>
  </section>

<!-- Video Section -->
<section class="video-section section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <h2 class="mb-4" style="font-size: 32px; font-family: var(--heading-font); color: var(--primary-color);">
          Kenali Kami Lebih Dekat
        </h2>
        <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
          <iframe
           src="https://www.youtube.com/embed/rYyopuxn3L8?si=2wSefBxnne6-c_M7" 
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            referrerpolicy="strict-origin-when-cross-origin"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius: 12px;">
          </iframe>

        </div>
      </div>
    </div>
  </div>
</section>

  <!-- Footer -->
  <footer>
  <div class="container">
      <div class="col-lg-12">
        <p>Copyright © 2048 Dimsum Dapoyumya. All rights reserved.
      </div>
    </div>
  </footer>
   <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/counter.js"></script>
  <script src="assets/js/custom.js"></script>

</body>
</html>
