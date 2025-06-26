<?php
require 'dbconnect.php';
require_once 'auth.php';


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->execute([$id]);
    $produk = $stmt->fetch();

    if (!$produk) {
        echo "<script>alert('Produk tidak ditemukan!'); window.location='shop.php';</script>";
        exit;
    }

    // Path gambar produk (otomatis dari ID produk)
    $gambarPath = "assets/images/produk/produk-{$produk['id']}.jpg";
    $gambarTersedia = file_exists($gambarPath) ? $gambarPath : "assets/images/produk/default.jpg";
} else {
    echo "<script>alert('ID tidak valid!'); window.location='shop.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <title>Lugx Gaming - Product Detail</title>

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
    <div class="dots">
      <span></span>
      <span></span>
      <span></span>
    </div>
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
            <li><a href="index.php" class=>Home</a></li>
            <li><a href="shop.php">Our Shop</a></li>
            <li><a href="about-us.php">About Us</a></li>
             <li><a href="contact.php">Contact Us</a></li>
             <li><a href="cart.php">keranjang kamu</a></li>

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

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h3><?= htmlspecialchars($produk['nama']) ?></h3>
        <span class="breadcrumb"><a href="index.php">Home</a> > <a href="shop.php">Shop</a> > <?= htmlspecialchars($produk['nama']) ?></span>
      </div>
    </div>
  </div>
</div>

<div class="single-product section">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="left-image">
          <img id="product-image" src="<?= $gambarTersedia ?>" alt="<?= htmlspecialchars($produk['nama']) ?>">
        </div>
      </div>
      <div class="col-lg-6 align-self-center">
        <h4><?= htmlspecialchars($produk['nama']) ?></h4>
        <h6 class="mb-3">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></h6>
        <p><?= nl2br(htmlspecialchars($produk['deskripsi'])) ?></p>

      <form action="add_to_cart.php" method="post">
    <input type="hidden" name="produk_id" value="<?= $produk['id'] ?>">
    <input type="number" name="jumlah" value="1" min="1">
    <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
   </form>


      </div>
      <div class="col-lg-12">
        <div class="sep"></div>
      </div>
    </div>
  </div>
</div>

<div class="more-info">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="tabs-content">
          <div class="row">
            <div class="nav-wrapper">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Reviews</button>
                </li>
              </ul>
            </div>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="description" role="tabpanel">
                <p><?= nl2br(htmlspecialchars($produk['deskripsi'])) ?></p>
              </div>
              <div class="tab-pane fade" id="reviews" role="tabpanel">
                <p>Reviews coming soon.</p>
              </div>
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
