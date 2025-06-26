<?php
require 'dbconnect.php';
require_once 'auth.php';

if (!isset($_SESSION['user'])) {
    header("Location: adminpanel/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Ambil isi keranjang user
$stmt = $pdo->prepare("
    SELECT k.id AS keranjang_id, p.id AS produk_id, p.nama, p.harga, p.stok, k.jumlah
    FROM keranjang k
    JOIN produk p ON k.produk_id = p.id
    WHERE k.users_id = ?
");
$stmt->execute([$user_id]);
$keranjang = $stmt->fetchAll();

// Hitung total harga
$total_harga = 0;
foreach ($keranjang as $item) {
    $total_harga += $item['harga'] * $item['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Keranjang Belanja - Lugx Gaming</title>
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
            <img src="assets/images/logo.png" alt="" style="width: 158px;">
          </a>
          <ul class="nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="shop.php">Our Shop</a></li>
            <li><a href="cart.php" class="active">Keranjang</a></li>
            <li><a href="about-us.php" >About Us</a></li>
            <li><a href="contact.php">Contact Us</a></li>
          </ul>
          <a class='menu-trigger'><span>Menu</span></a>
        </nav>
      </div>
    </div>
  </div>
</header>

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h3>Keranjang Belanja</h3>
        <span class="breadcrumb"><a href="index.php">Home</a> > Keranjang</span>
      </div>
    </div>
  </div>
</div>

<div class="contact-page section">
  <div class="container">
    <?php if (count($keranjang) === 0): ?>
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h4>Keranjang Anda kosong.</h4>
          <a href="shop.php" class="btn btn-primary mt-3">Belanja Sekarang</a>
        </div>
      </div>
    <?php else: ?>
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th>Produk</th>
                  <th>Harga</th>
                  <th>Jumlah</th>
                  <th>Subtotal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($keranjang as $item): ?>
                  <tr>
                    <td><?= htmlspecialchars($item['nama']) ?></td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td>
                      <div class="input-group">
                        <a href="update_keranjang.php?id=<?= $item['keranjang_id'] ?>&action=decrease" class="btn btn-sm btn-warning">-</a>
                        <span class="mx-2"><?= $item['jumlah'] ?></span>
                        <a href="update_keranjang.php?id=<?= $item['keranjang_id'] ?>&action=increase" class="btn btn-sm btn-success"
                           <?= $item['jumlah'] >= $item['stok'] ? 'disabled' : '' ?>>+</a>
                      </div>
                    </td>
                    <td>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></td>
                    <td>
                      <a href="hapus_keranjang.php?id=<?= $item['keranjang_id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

            <div class="text-end mt-3">
              <h4>Total: Rp <?= number_format($total_harga, 0, ',', '.') ?></h4>
              <a href="checkout.php" class="btn btn-success">Checkout</a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
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
