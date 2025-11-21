<?php
session_start();
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../views/auth/login.php');
    exit();
}

$username = trim($_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Username dan Password wajib diisi.";
    header('Location: ../../views/auth/login.php');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['logged_in'] = true;

        header('Location: ../../index.php');
        exit();
    } else {
        $_SESSION['error'] = "Username atau Password salah.";
        header('Location: ../../views/auth/login.php');
        exit();
    }

} catch (PDOException $e) {
    $_SESSION['error'] = "Terjadi kesalahan sistem.";
    header('Location: ../../views/auth/login.php');
    exit();
}