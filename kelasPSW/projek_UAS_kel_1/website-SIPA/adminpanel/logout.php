<?php
session_start();
$_SESSION = []; // Kosongkan isi session
session_destroy(); // Hancurkan session
header("Location: login.php");
exit();
?>
