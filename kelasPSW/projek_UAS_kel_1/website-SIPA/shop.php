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

// Ambil semua produk beserta nama kategori
$stmtProduk = $pdo->query("
    SELECT produk.*, kategori.nama AS kategori_nama 
    FROM produk 
    JOIN kategori ON produk.kategori_id = kategori.id
");
$produkList = $stmtProduk->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <title>DapoYumya - Shop Page</title>

  <!-- CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
</head>

<body>

  <!-- Header -->
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
              <li><a href="shop.php" class="active">Our Shop</a></li>
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

  <!-- Page Heading -->
  <div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h3>Our Shop</h3>
          <span class="breadcrumb"><a href="index.php">Home</a> > Our Shop</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Shop Section -->
  <div class="section trending">
    <div class="container">
      <div class="row">
        <?php foreach ($produkList as $produk): 
          $kategoriClass = ''; 
          switch (strtolower($produk['nama'])) {
              case 'paket a': $kategoriClass = 'adv'; break;
              case 'paket b': $kategoriClass = 'str'; break;
              case 'paket family': $kategoriClass = 'rac'; break;
          }

          // Gambar produk
          $gambarPath = "assets/images/produk/produk-{$produk['id']}.jpg";
          if (!file_exists($gambarPath)) {
              $gambarPath = "assets/images/produk/default.jpg";
          }
        ?>
        <div class="col-lg-3 col-md-6 mb-4 trending-items <?= $kategoriClass ?>">
          <div class="item">
            <div class="thumb">
              <a href="product-details.php?id=<?= $produk['id'] ?>">
                <img src="<?= $gambarPath ?>" alt="Gambar produk <?= htmlspecialchars($produk['nama']) ?>">
              </a>
              <span class="price">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></span>
            </div>
            <div class="down-content">
              <span class="category"><?= htmlspecialchars($produk['kategori_nama']) ?></span>
              <h4><?= htmlspecialchars($produk['nama']) ?></h4>
              <a href="product-details.php?id=<?= $produk['id'] ?>"><i class="fa fa-shopping-bag"></i></a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="col-lg-12">
        <p>Copyright © 2048 Dimsum DapoYumya. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/counter.js"></script>
  <script src="assets/js/custom.js"></script>

</body>
</html>
