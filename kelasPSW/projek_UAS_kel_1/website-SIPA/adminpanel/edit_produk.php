<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// Ambil data produk
$stmtProduk = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
$stmtProduk->execute([$id]);
$produk = $stmtProduk->fetch();

if (!$produk) {
    die("Produk tidak ditemukan");
}

// Ambil kategori
$stmtKategori = $pdo->query("SELECT * FROM kategori");
$kategoriList = $stmtKategori->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori_id = $_POST['kategori_id'];

    $stmt = $pdo->prepare("UPDATE produk SET nama=?, harga=?, stok=?, kategori_id=? WHERE id=?");
    $stmt->execute([$nama, $harga, $stok, $kategori_id, $id]);

    header("Location: produk.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
</head>
<body>

<h1>Edit Produk</h1>

<form method="POST">
    <label>Nama Produk:</label><br>
    <input type="text" name="nama" value="<?= $produk['nama'] ?>" required><br><br>

    <label>Harga:</label><br>
    <input type="number" name="harga" value="<?= $produk['harga'] ?>" required><br><br>

    <label>Stok:</label><br>
    <input type="number" name="stok" value="<?= $produk['stok'] ?>" required><br><br>

    <label>Kategori:</label><br>
    <select name="kategori_id" required>
        <?php foreach ($kategoriList as $kategori): ?>
            <option value="<?= $kategori['id'] ?>" <?= $kategori['id'] == $produk['kategori_id'] ? 'selected' : '' ?>>
                <?= $kategori['nama'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Update</button>
</form>

<a href="produk.php">← Kembali</a>

</body>
</html>
