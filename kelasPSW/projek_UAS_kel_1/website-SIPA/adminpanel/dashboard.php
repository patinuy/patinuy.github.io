<?php 
session_start();
require  '../dbconnect.php';

// Validasi login admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Hitung total pengguna
$stmtUser = $pdo->query("SELECT COUNT(*) AS total_user FROM users");
$userCount = $stmtUser->fetch()['total_user'];

// Hitung total produk
$stmtProduk = $pdo->query("SELECT COUNT(*) AS total_produk FROM produk");
$produkCount = $stmtProduk->fetch()['total_produk'];

// Hitung total order
$stmtOrder = $pdo->query("SELECT COUNT(*) AS total_order FROM orders");
$orderCount = $stmtOrder->fetch()['total_order'];

// Hitung total pendapatan dari order yang sudah dibayar
$stmtPendapatan = $pdo->query("SELECT SUM(total) AS total_pendapatan FROM orders WHERE status = 'Selesai'");
$totalPendapatan = $stmtPendapatan->fetch()['total_pendapatan'] ?? 0;
?>



<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; }
        h1 { color: #333; }
        .card { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        .card h2 { margin: 0; }
    </style>
</head>
<body>

<h1>Dashboard Admin</h1>

<div class="card">
    <h2>Total Pengguna: <?= $userCount ?></h2>
</div>

<div class="card">
    <h2><a href="produk.php">Total Produk: <?= $produkCount ?></a></h2>
</div>

<div class="card">
    <a href="order.php" style="text-decoration: none; color: inherit;">
        <h2>Total Order: <?= $orderCount ?></h2>
    </a>
</div>


<div class="card">
    <h2>Total Pendapatan: Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></h2>
</div>

<a href="logout.php">Logout</a>

</body>
</html>
