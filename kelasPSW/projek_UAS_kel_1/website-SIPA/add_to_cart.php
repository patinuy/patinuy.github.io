<?php
require 'dbconnect.php';
require_once 'auth.php';

// Pastikan user login
if (!isset($_SESSION['user'])) {
    header("Location: adminpanel/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Ambil data produk dari request (misal pakai POST)
if (!isset($_POST['produk_id']) || !isset($_POST['jumlah'])) {
    header("Location: shop.php");
    exit;
}

$produk_id = (int) $_POST['produk_id'];
$jumlah = (int) $_POST['jumlah'];

// Cek apakah produk sudah ada di keranjang user
$stmt = $pdo->prepare("SELECT id, jumlah FROM keranjang WHERE users_id = ? AND produk_id = ?");
$stmt->execute([$user_id, $produk_id]);
$existing = $stmt->fetch();

if ($existing) {
    // Produk sudah ada di keranjang → update jumlah
    $new_jumlah = $existing['jumlah'] + $jumlah;
    $stmt = $pdo->prepare("UPDATE keranjang SET jumlah = ? WHERE id = ?");
    $stmt->execute([$new_jumlah, $existing['id']]);
} else {
    // Produk belum ada di keranjang → insert baru
    $stmt = $pdo->prepare("INSERT INTO keranjang (users_id, produk_id, jumlah) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $produk_id, $jumlah]);
}

header("Location: cart.php");
exit;
?>
