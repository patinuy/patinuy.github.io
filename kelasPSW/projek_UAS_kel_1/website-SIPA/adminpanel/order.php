<?php
session_start();
require '../dbconnect.php';

// Validasi login admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil data order
$stmt = $pdo->query("
 SELECT orders.*, users.name 
FROM orders 
JOIN users ON orders.users_id = users.id
ORDER BY orders.id DESC

");
$orderList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Order</title>
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

<h1>Daftar Order</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Pengguna</th>
        <th>Total</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($orderList as $order): ?>
    <tr>
        <td><?= $order['id'] ?></td>
        <td><?= htmlspecialchars($order['name']) ?></td>
        <td>Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
        <td><?= $order['status'] ?></td>
        <td>
            <a href="edit_order.php?id=<?= $order['id'] ?>">Update Status</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="dashboard.php">← Kembali ke Dashboard</a>

</body>
</html>
