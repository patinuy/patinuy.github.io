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

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM keranjang WHERE id = ? AND users_id = ?");
    $stmt->execute([$id, $user_id]);
}

header("Location: cart.php");
exit;
?>
