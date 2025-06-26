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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dapoyumya - Dimsum Nagih!</title>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
</head>

<body>

<div id="js-preloader" class="js-preloader">
  <div class="preloader-inner">
    <span class="dot"></span>
    <div class="dots"><span></span><span></span><span></span></div>
  </div>
</div>

<header class="header-area header-sticky">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <nav class="main-nav">
           <a href="index.php" class="logo">
            <img src="assets/images/logo.png" alt="Dapoyumya" style="width: 158px;">
            </a>

           <ul class="nav">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="shop.php">Our Shop</a></li>
            <li><a href="about-us.php">About Us</a></li>
             <li><a href="contact.php">Contact Us</a></li>

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

<div class="main-banner">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 align-self-center">
        <div class="caption header-text">
          <h6>Welcome to Dapoyumya</h6>
          <h2>Dimsum Dapoyumya — Sekali Coba, Langsung Nagih!</h2>
          <p>Dapoyumya menyajikan <strong>Dimsum</strong> khas Asia Timur dengan cita rasa autentik. Kami berkomitmen memberi pengalaman terbaik kepada pelanggan.</p>
          <div class="search-input">
 <div class="social-buttons">
    <a href="https://wa.me/081371329678" class="btn btn-social" target="_blank"><i class="fab fa-whatsapp fa-3x"></i></a>
    <a href="https://www.instagram.com/dapoyumya" class="btn btn-social" target="_blank"><i class="fab fa-instagram fa-3x"></i></a>
    <a href="https://www.tiktok.com/@dapoyumya" class="btn btn-social" target="_blank"><i class="fab fa-tiktok fa-3x"></i></a>
  </div>
</div>
        </div>
      </div>
      <div class="col-lg-4 offset-lg-2">
        <div class="right-image">
          <img src="assets/images/banner-image.png" alt="">
        </div>
      </div>
    </div>
  </div>
</div>


<div class="section trending">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="section-heading">
          <h6>Rekomendasi</h6>
          <h2>Menu Rekomendasi</h2>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="main-button"><a href="shop.php">View All</a></div>
      </div>

      <?php foreach ($produkList as $produk): 
        $gambarPath = "assets/images/produk/produk-{$produk['id']}.jpg";
        $gambarTersedia = file_exists($gambarPath) ? $gambarPath : "assets/images/produk/default.jpg";
      ?>
      <div class="col-lg-3 col-md-6">
        <div class="item">
          <div class="thumb">
            <a href="product-details.php?id=<?= $produk['id'] ?>">
              <img src="<?= $gambarTersedia ?>" alt="<?= htmlspecialchars($produk['nama']) ?>">
            </a>
            <span class="price">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></span>
          </div>
          <div class="down-content">
            <span class="category">Dimsum</span>
            <h4><?= htmlspecialchars($produk['nama']) ?></h4>
            <a href="product-details.php?id=<?= $produk['id'] ?>"><i class="fa fa-shopping-bag"></i></a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
      
    </div>
  </div>
</div>

<div class="section cta">
  <div class="container">
    <div class="row">
      <div class="col-lg-5">
        <div class="section-heading">
          <h6>Our Product</h6>
          <h2>Klik sekarang, temukan <em>produk</em> yang kamu cari!</h2>
          <p>Temukan kelezatan dan kualitas terbaik hanya di produk kami! Klik sekarang dan rasakan sendiri bedanya!</p>
          <div class="main-button"><a href="shop.php">Kunjungi sekarang</a></div>
        </div>
      </div>

      <!-- Tambahkan gambar di sini -->
      <div class="col-lg-5 offset-lg-2 align-self-end">
        <img src="assets/images/cta-bg-1.jpg" alt="Banner CTA" class="img-fluid rounded shadow" style="max-width: 100%; height: auto;">
      </div>
    </div>
  </div>
</div>


<footer>
  <div class="container">
    <div class="col-lg-12">
      <p>Copyright © 2048 Dimsum Dapoyumya. All rights reserved.</p>
    </div>
  </div>
</footer>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/counter.js"></script>
<script src="assets/js/custom.js"></script>

</body>
</html>
