<?php
session_start();
require '../dbconnect.php';

// Validasi login admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// Ambil data order
$stmtOrder = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmtOrder->execute([$id]);
$order = $stmtOrder->fetch();

if (!$order) {
    die("Order tidak ditemukan");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    $stmtUpdate = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmtUpdate->execute([$status, $id]);

    header("Location: order.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Status Order</title>
</head>
<body>

<h1>Update Status Order #<?= $order['id'] ?></h1>

<form method="POST">
    <label>Status:</label><br>
    <select name="status" required>
        <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="Diproses" <?= $order['status'] == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
        <option value="Dikirim" <?= $order['status'] == 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
        <option value="Selesai" <?= $order['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
        <option value="Batal" <?= $order['status'] == 'Batal' ? 'selected' : '' ?>>Batal</option>
    </select><br><br>

    <button type="submit">Update</button>
</form>

<a href="order.php">← Kembali</a>

</body>
</html>
