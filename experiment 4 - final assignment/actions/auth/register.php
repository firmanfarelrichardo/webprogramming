<?php
session_start();
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../views/auth/register.php');
    exit();
}

$name = htmlspecialchars(trim($_POST['name']));
$username = htmlspecialchars(trim($_POST['username']));
$password = $_POST['password']; 

if (empty($name) || empty($username) || empty($password)) {
    $_SESSION['error'] = "Semua kolom wajib diisi!";
    header('Location: ../../views/auth/register.php');
    exit();
}

try {
    $checkStmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $checkStmt->execute([$username]);

    if ($checkStmt->rowCount() > 0) {
        $_SESSION['error'] = "Username sudah terpakai, pilih yang lain.";
        header('Location: ../../views/auth/register.php');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertStmt = $pdo->prepare("INSERT INTO users (name, username, password) VALUES (?, ?, ?)");
    $result = $insertStmt->execute([$name, $username, $hashedPassword]);

    if ($result) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        header('Location: ../../views/auth/login.php'); 
        exit();
    }

} catch (PDOException $e) {
    error_log($e->getMessage()); 
    $_SESSION['error'] = "Terjadi kesalahan sistem. Silakan coba lagi.";
    header('Location: ../../views/auth/register.php');
    exit();
}