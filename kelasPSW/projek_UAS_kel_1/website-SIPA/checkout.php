<?php
require 'dbconnect.php';
require_once 'auth.php';

if (!isset($_SESSION['user'])) {
    header("Location: adminpanel/login.php");
    exit;
}
$user_id = $_SESSION['user']['id'];

// Ambil alamat jika sudah ada
$stmt = $pdo->prepare("SELECT * FROM alamat_pengiriman WHERE users_id = ? LIMIT 1");
$stmt->execute([$user_id]);
$alamat = $stmt->fetch();

// Simpan alamat baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simpan_alamat'])) {
    $stmt = $pdo->prepare("INSERT INTO alamat_pengiriman (users_id, alamat, kota, provinsi, kode_pos, no_hp)
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user_id, $_POST['alamat'], $_POST['kota'], $_POST['provinsi'],
        $_POST['kode_pos'], $_POST['no_hp']
    ]);
    header("Location: checkout.php");
    exit;
}

// Ambil isi keranjang
$stmt = $pdo->prepare("
    SELECT k.id AS keranjang_id, p.id AS produk_id, p.nama, p.harga, k.jumlah
    FROM keranjang k JOIN produk p ON k.produk_id = p.id
    WHERE k.users_id = ?");
$stmt->execute([$user_id]);
$keranjang = $stmt->fetchAll();

if (empty($keranjang)) {
    echo "<script>alert('Keranjang kosong, silakan belanja dulu.'); window.location='shop.php';</script>";
    exit;
}

// Hitung harga
$total_harga = 0;

foreach ($keranjang as $i) {
    $total_harga += $i['harga'] * $i['jumlah'];
}
$ongkir = 20000;
$grand_total = $total_harga + $ongkir;

// Ambil metode pembayaran
$pembayaran = $pdo->query("SELECT * FROM metode_pembayaran")->fetchAll();

// Proses checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    if (!$alamat) {
        echo "<script>alert('Alamat belum diisi!'); window.location='checkout.php';</script>";
        exit;
    }
    $metode = $_POST['metode_pembayaran'];

    try {
        $pdo->beginTransaction();

        // Gunakan alamat_pengiriman_id saja
        $stmt = $pdo->prepare("INSERT INTO orders
            (users_id, total, status, payment_method_id, alamat_pengiriman_id, shipping_cost, shipping_method, tanggal_order)
            VALUES (?, ?, 'Menunggu Pembayaran', ?, ?, ?, 'Reguler', NOW())");
        $stmt->execute([$user_id, $grand_total, $metode, $alamat['id'], $ongkir]);
        $order_id = $pdo->lastInsertId();

        foreach ($keranjang as $i) {
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, produk_id, jumlah, harga)
                                   VALUES (?, ?, ?, ?)");
            $stmt->execute([$order_id, $i['produk_id'], $i['jumlah'], $i['harga']]);
        }

        $pdo->prepare("DELETE FROM keranjang WHERE users_id = ?")->execute([$user_id]);
        $pdo->commit();

        header("Location: https://wa.me/6285834195094?text=" . urlencode(
            "Halo Admin, saya sudah checkout. No Order: $order_id, Total: Rp " . number_format($grand_total, 0, ',', '.')
        ));
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('Checkout gagal.'); window.location='checkout.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Checkout - Lugx Gaming</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
</head>

<body>

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
            <li><a href="cart.php">Keranjang</a></li>
            <li><a href="checkout_final.php" class="active">Checkout</a></li>
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
        <h3>Checkout</h3>
        <span class="breadcrumb"><a href="index.php">Home</a> > Checkout</span>
      </div>
    </div>
  </div>
</div>

<section class="checkout section">
  <div class="container">
    <h3>Checkout Sekarang</h3>

    <?php if (!$alamat): ?>
      <form method="post" class="row mb-4">
        <div class="col-md-6 mb-3"><input type="text" name="alamat" class="form-control" placeholder="Alamat lengkap" required></div>
        <div class="col-md-6 mb-3"><input type="text" name="kota" class="form-control" placeholder="Kota" required></div>
        <div class="col-md-6 mb-3"><input type="text" name="provinsi" class="form-control" placeholder="Provinsi" required></div>
        <div class="col-md-3 mb-3"><input type="text" name="kode_pos" class="form-control" placeholder="Kode pos" required></div>
        <div class="col-md-3 mb-3"><input type="text" name="no_hp" class="form-control" placeholder="No HP" required></div>
        <div class="col-12"><button class="btn btn-primary" name="simpan_alamat">Simpan Alamat</button></div>
      </form>
    <?php else: ?>
      <div class="mb-4">
        <h5>Alamat Pengiriman</h5>
        <p><?= htmlspecialchars("{$alamat['alamat']}, {$alamat['kota']}, {$alamat['provinsi']}, {$alamat['kode_pos']} (HP: {$alamat['no_hp']})") ?></p>
      </div>
      <div class="mb-4">
        <h5>Ringkasan Pesanan</h5>
        <table class="table"><tbody>
          <?php foreach ($keranjang as $i): ?>
            <tr>
              <td><?= htmlspecialchars($i['nama']) ?> x<?= $i['jumlah'] ?></td>
              <td>Rp <?= number_format($i['harga'] * $i['jumlah'],0,',','.') ?></td>
            </tr>
          <?php endforeach; ?>
          <tr><td><strong>Subtotal</strong></td><td>Rp <?= number_format($total_harga,0,',','.') ?></td></tr>
          <tr><td><strong>Ongkir</strong></td><td>Rp <?= number_format($ongkir,0,',','.') ?></td></tr>
          <tr><td><strong>Total</strong></td><td>Rp <?= number_format($grand_total,0,',','.') ?></td></tr>
        </tbody></table>
      </div>
      <form method="post">
        <div class="mb-3">
          <label>Metode Pembayaran:</label>
          <select name="metode_pembayaran" class="form-control" required>
            <option value="">-- Pilih Metode --</option>
            <?php foreach ($pembayaran as $p): ?>
              <option value="<?= $p['id'] ?>">
                <?= htmlspecialchars($p['nama_metode']) ?>
                <?php if ($p['jenis_metode'] !== 'Bank'): ?>
                  - <?= htmlspecialchars($p['nomor_rekening']) ?> a.n <?= htmlspecialchars($p['pemilik_rekening']) ?>
                <?php endif; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <button class="btn btn-success" name="checkout">Checkout Sekarang</button>
      </form>
    <?php endif; ?>
  </div>
</section>


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
