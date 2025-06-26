<?php
session_start();
require '../dbconnect.php';

// Validasi login admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil data produk beserta nama kategori
$stmt = $pdo->query("
    SELECT produk.*, kategori.nama AS nama_kategori 
    FROM produk 
    LEFT JOIN kategori ON produk.kategori_id = kategori.id
");
$produkList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: #007BFF; }
    </style>
</head>
<body>

<h1>Daftar Produk</h1>

<a href="tambah_produk.php">+ Tambah Produk</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Kategori</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($produkList as $produk): ?>
    <tr>
        <td><?= $produk['id'] ?></td>
        <td><?= $produk['nama'] ?></td>
        <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
        <td><?= $produk['stok'] ?></td>
        <td><?= $produk['nama_kategori'] ?? '-' ?></td>
        <td>
            <a href="edit_produk.php?id=<?= $produk['id'] ?>">Edit</a> | 
            <a href="hapus_produk.php?id=<?= $produk['id'] ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="dashboard.php">← Kembali ke Dashboard</a>

</body>
</html>
