<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: adminpanel/login.php");
    exit;
}
?>
