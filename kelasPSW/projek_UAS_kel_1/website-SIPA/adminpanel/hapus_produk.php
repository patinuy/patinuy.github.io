<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM produk WHERE id = ?");
$stmt->execute([$id]);

header("Location: produk.php");
exit();
?>
