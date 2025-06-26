<?php
require 'auth_admin.php';

// Tambah Pembayaran
if (isset($_POST['tambah'])) {
    $nama_metode = $_POST['nama_metode'];
    $nomor_rekening = $_POST['nomor_rekening'];
    $pemilik_rekening = $_POST['pemilik_rekening'];
    $jenis_metode = $_POST['jenis_metode'];

    $stmt = $pdo->prepare("INSERT INTO metode_pembayaran 
        (nama_metode, nomor_rekening, pemilik_rekening, jenis_metode)
        VALUES (?, ?, ?, ?)");
    $stmt->execute([$nama_metode, $nomor_rekening, $pemilik_rekening, $jenis_metode]);
    header("Location: pembayaran.php");
}

// Hapus Pembayaran
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $pdo->prepare("DELETE FROM metode_pembayaran WHERE id = ?")->execute([$id]);
    header("Location: pembayaran.php");
}

// List Metode Pembayaran
$stmt = $pdo->query("SELECT * FROM metode_pembayaran");
$pembayaran = $stmt->fetchAll();
?>

<h2>Kelola Metode Pembayaran</h2>

<form method="post">
    Nama Metode: <input type="text" name="nama_metode" required><br>
    Nomor Rekening: <input type="text" name="nomor_rekening"><br>
    Pemilik Rekening: <input type="text" name="pemilik_rekening"><br>
    Jenis Metode:
    <select name="jenis_metode">
        <option value="Bank">Bank</option>
        <option value="E-Wallet">E-Wallet</option>
        <option value="COD">COD</option>
    </select><br>
    <button type="submit" name="tambah">Tambah</button>
</form>

<h3>Daftar Metode Pembayaran:</h3>
<table border="1">
    <tr><th>Metode</th><th>No Rek</th><th>Pemilik</th><th>Jenis</th><th>Aksi</th></tr>
    <?php foreach($pembayaran as $p): ?>
    <tr>
        <td><?= $p['nama_metode'] ?></td>
        <td><?= $p['nomor_rekening'] ?></td>
        <td><?= $p['pemilik_rekening'] ?></td>
        <td><?= $p['jenis_metode'] ?></td>
        <td><a href="?hapus=<?= $p['id'] ?>" onclick="return confirm('Yakin?')">Hapus</a></td>
    </tr>
    <?php endforeach ?>
</table>

<a href="index.php">Kembali</a>
