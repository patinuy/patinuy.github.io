<?php
require_once '../dbconnect.php';
session_start();

$errors = [];

// ======= HANDLE REGISTER =======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $name = trim($_POST['name']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $created_at = date('Y-m-d H:i:s');

    // Validasi form
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format email tidak valid.';
    }
    if (empty($name)) {
        $errors['name'] = 'Nama wajib diisi.';
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'Password minimal 8 karakter.';
    }
    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Konfirmasi password tidak cocok.';
    }

    // Cek email sudah terdaftar
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        $errors['user_exist'] = 'Email sudah terdaftar.';
    }

    // Jika ada error
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: register.php');
        exit();
    }

    // Hash dan simpan
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (email, password, name, created_at, role) VALUES (:email, :password, :name, :created_at, :role)");
    $stmt->execute([
        'email' => $email,
        'password' => $hashedPassword,
        'name' => $name,
        'created_at' => $created_at,
        'role' => 'user' // default role
    ]);

    header('Location: login.php');
    exit();
}

// ======= HANDLE LOGIN =======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signin'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format email tidak valid.';
    }
    if (empty($password)) {
        $errors['password'] = 'Password wajib diisi.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: login.php');
        exit();
    }

    // Cari user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Simpan session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'role' => $user['role']
        ];

        // Arahkan berdasarkan role
        if ($user['role'] === 'admin') {
            header('Location: dashboard.php');
        } else {
            header('Location: ../index.php');
        }
        exit();
    } else {
        $errors['login'] = 'Email atau password salah.';
        $_SESSION['errors'] = $errors;
        header('Location: login.php');
        exit();
    }
}
?>
