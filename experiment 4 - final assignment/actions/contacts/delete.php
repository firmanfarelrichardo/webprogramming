<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['logged_in']) || !isset($_GET['id'])) {
    header('Location: ../../index.php');
    exit();
}

$contact_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT photo FROM contacts WHERE id = ? AND user_id = ?");
    $stmt->execute([$contact_id, $user_id]);
    $contact = $stmt->fetch();

    if ($contact) {
        $deleteStmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
        $deleteStmt->execute([$contact_id]);

        if ($contact['photo']) {
            $filePath = '../../public/uploads/' . $contact['photo'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $_SESSION['success'] = "Kontak berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Kontak tidak ditemukan atau akses ditolak.";
    }

    header('Location: ../../index.php');
    exit();

} catch (PDOException $e) {
    $_SESSION['error'] = "Gagal menghapus data.";
    header('Location: ../../index.php');
    exit();
}