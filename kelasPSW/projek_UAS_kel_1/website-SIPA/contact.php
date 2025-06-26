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

// Ambil produk rekomendasi dari database
$stmtProduk = $pdo->query("SELECT * FROM produk WHERE rekomendasi = TRUE ORDER BY id DESC LIMIT 4");
$produkList = $stmtProduk->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title> Contact Page</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
<!--

TemplateMo 589 lugx gaming

https://templatemo.com/tm-589-lugx-gaming

-->
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
           <a href="index.php" class="logo">
            <img src="assets/images/logo.png" alt="Dapoyumya" style="width: 158px;">
            </a>

           <ul class="nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="shop.php">Our Shop</a></li>
            <li><a href="about-us.php">About Us</a></li>
             <li><a href="contact.php" class="active">Contact Us</a></li>

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
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h3>Contact Us</h3>
          <span class="breadcrumb"><a href="#">Home</a>  >  Contact Us</span>
        </div>
      </div>
    </div>
  </div>

  <div class="contact-page section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center">
          <div class="left-text">
            <div class="section-heading">
              <h6>Contact Us</h6>
              <h2>Hai</h2>
            </div>
            <p>Selamat datang di DAPOYUMYA – rumah bagi cita rasa autentik dimsum yang dikukus dengan penuh cinta. Kami adalah UMKM lokal yang berdedikasi untuk menghadirkan dimsum berkualitas dengan bahan segar dan halal, tanpa pengawet. kami percaya bahwa setiap gigitan adalah pengalaman yang tak terlupakan.</p>
            <ul>
              <li><span>Address</span> Batam, aku tahu 3 blok ee no 6 sungai panas, Indonesia</li>
              <li><span>Phone</span> +62 813-7132-9678</li>
              <li><span>Email</span> Dapoyumya@contact.com</li>
            </ul>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="right-content">
            <div class="row">
              <div class="col-lg-12">
                <div id="map">
              <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3989.037673863146!2d104.03091807496541!3d1.1334316988557158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMcKwMDgnMDAuNCJOIDEwNMKwMDInMDAuNiJF!5e0!3m2!1sid!2sid!4v1749050410222!5m2!1sid!2sid" width="600" height="450" style="border:0; pointer-events: none;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                </div>
              </div>
              <div class="col-lg-12">
                <form id="contact-form" action="" method="post">
                  <div class="row">
                    <div class="col-lg-6">
                      <fieldset>
                        <input type="name" name="name" id="name" placeholder="Your Name..." autocomplete="on" required>
                      </fieldset>
                    </div>
                    <div class="col-lg-6">
                      <fieldset>
                        <input type="surname" name="surname" id="surname" placeholder="Your Surname..." autocomplete="on" required>
                      </fieldset>
                    </div>
                    <div class="col-lg-6">
                      <fieldset>
                        <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your E-mail..." required="">
                      </fieldset>
                    </div>
                    <div class="col-lg-6">
                      <fieldset>
                        <input type="subject" name="subject" id="subject" placeholder="Subject..." autocomplete="on" >
                      </fieldset>
                    </div>
                    <div class="col-lg-12">
                      <fieldset>
                        <textarea name="message" id="message" placeholder="Your Message"></textarea>
                      </fieldset>
                    </div>
                    <div class="col-lg-12">
                      <fieldset>
                        <button type="submit" id="form-submit" class="orange-button">Send Message Now</button>
                      </fieldset>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  

  <footer>
    <div class="container">
      <div class="col-lg-12">
        <p>Copyright © 2025  DapoYumya. All rights reserved.</a></p>
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