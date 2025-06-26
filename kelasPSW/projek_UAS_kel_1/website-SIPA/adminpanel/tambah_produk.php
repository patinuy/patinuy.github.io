<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil kategori
$stmtKategori = $pdo->query("SELECT * FROM kategori");
$kategoriList = $stmtKategori->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori_id = $_POST['kategori_id'];

    $stmt = $pdo->prepare("INSERT INTO produk (nama, harga, stok, kategori_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nama, $harga, $stok, $kategori_id]);

    header("Location: produk.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
</head>
<body>

<h1>Tambah Produk</h1>

<form method="POST">
    <label>Nama Produk:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Harga:</label><br>
    <input type="number" name="harga" required><br><br>

    <label>Stok:</label><br>
    <input type="number" name="stok" required><br><br>

    <label>Kategori:</label><br>
    <select name="kategori_id" required>
        <option value="">--Pilih Kategori--</option>
        <?php foreach ($kategoriList as $kategori): ?>
            <option value="<?= $kategori['id'] ?>"><?= $kategori['nama'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Simpan</button>
</form>

<a href="produk.php">← Kembali</a>

</body>
</html>
