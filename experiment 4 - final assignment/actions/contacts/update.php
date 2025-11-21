<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['logged_in']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../index.php');
    exit();
}

$id = $_POST['id'];
$user_id = $_SESSION['user_id'];
$name = htmlspecialchars(trim($_POST['name']));
$phone = htmlspecialchars(trim($_POST['phone']));
$email = htmlspecialchars(trim($_POST['email']));
$old_photo = $_POST['old_photo'];
$photo_name = $old_photo; 

if (empty($name) || empty($phone)) {
    $_SESSION['error'] = "Nama dan Nomor HP wajib diisi!";
    header("Location: ../../views/contacts/edit.php?id=$id");
    exit();
}

if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['photo']['tmp_name'];
    $originalName = $_FILES['photo']['name'];
    $fileSize = $_FILES['photo']['size'];
    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'heic'];

    if (in_array($fileExtension, $allowedExtensions) && $fileSize < 5000000) {
        $newFileName = md5(time() . $originalName) . '.' . $fileExtension;
        $uploadFileDir = '../../public/uploads/';
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $photo_name = $newFileName;
            
            if ($old_photo && file_exists($uploadFileDir . $old_photo)) {
                unlink($uploadFileDir . $old_photo);
            }
        }
    } else {
        $_SESSION['error'] = "Gagal upload foto. Pastikan format JPG/PNG dan ukuran < 2MB.";
        header("Location: ../../views/contacts/edit.php?id=$id");
        exit();
    }
}

try {
    $sql = "UPDATE contacts SET name = ?, phone = ?, email = ?, photo = ? WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$name, $phone, $email, $photo_name, $id, $user_id]);

    if ($result) {
        $_SESSION['success'] = "Kontak berhasil diperbarui!";
        header('Location: ../../index.php');
    } else {
        $_SESSION['error'] = "Gagal memperbarui kontak.";
        header("Location: ../../views/contacts/edit.php?id=$id");
    }
    exit();

} catch (PDOException $e) {
    $_SESSION['error'] = "Database Error.";
    header("Location: ../../views/contacts/edit.php?id=$id");
    exit();
}