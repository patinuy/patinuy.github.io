<?php
session_start();
require 'dbconnect.php';
require_once 'auth.php';

if (!isset($_SESSION['user'])) {
    header("Location: adminpanel/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if (!$id || !$action) {
    header("Location: cart.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT k.jumlah, p.stok 
    FROM keranjang k 
    JOIN produk p ON k.produk_id = p.id 
    WHERE k.id = ? AND k.users_id = ?
");
$stmt->execute([$id, $user_id]);
$data = $stmt->fetch();

if (!$data) {
    header("Location: cart.php");
    exit;
}

$jumlah = $data['jumlah'];
$stok = $data['stok'];

if ($action == 'increase' && $jumlah < $stok) {
    $stmt = $pdo->prepare("UPDATE keranjang SET jumlah = jumlah + 1 WHERE id = ?");
    $stmt->execute([$id]);
} elseif ($action == 'decrease') {
    if ($jumlah > 1) {
        $stmt = $pdo->prepare("UPDATE keranjang SET jumlah = jumlah - 1 WHERE id = ?");
        $stmt->execute([$id]);
    } else {
        $stmt = $pdo->prepare("DELETE FROM keranjang WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header("Location: cart.php");
exit;
?>
