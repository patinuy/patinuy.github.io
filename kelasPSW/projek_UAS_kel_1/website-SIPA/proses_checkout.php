<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil isi keranjang user
$query = "SELECT k.*, p.nama, p.harga FROM keranjang k 
          JOIN produk p ON k.produk_id = p.id 
          WHERE k.users_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
$total_harga = 0;
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total_harga += $row['harga'] * $row['jumlah'];
}

$stmt->close();

// Ambil data metode pembayaran
$pembayaran = $conn->query("SELECT * FROM metode_pembayaran");

// Proses saat tombol checkout ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $metode_id = $_POST['metode_pembayaran'];

    // Simpan transaksi ke log (jika ada tabel transaksi, nanti bisa ditambahkan)

    // Kosongkan keranjang setelah checkout
    $hapus = $conn->prepare("DELETE FROM keranjang WHERE users_id = ?");
    $hapus->bind_param("i", $user_id);
    $hapus->execute();
    $hapus->close();

    echo "<script>alert('Checkout berhasil!'); window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>

<h1>Checkout</h1>

<h3>Keranjang Anda:</h3>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Produk</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= $item['nama'] ?></td>
            <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
            <td><?= $item['jumlah'] ?></td>
            <td>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Total Harga: Rp <?= number_format($total_harga, 0, ',', '.') ?></h3>

<form method="post">
    <label for="metode_pembayaran">Pilih Metode Pembayaran:</label>
    <select name="metode_pembayaran" id="metode_pembayaran" required>
        <option value="">-- Pilih --</option>
        <?php while ($row = $pembayaran->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>">
                <?= $row['nama_metode'] ?> 
                <?php if ($row['jenis_metode'] != 'COD') {
                    echo " - No Rek: {$row['nomor_rekening']} a.n {$row['pemilik_rekening']}";
                } ?>
            </option>
        <?php endwhile; ?>
    </select>
    <br><br>
    <button type="submit">Proses Checkout</button>
</form>

</body>
</html>
