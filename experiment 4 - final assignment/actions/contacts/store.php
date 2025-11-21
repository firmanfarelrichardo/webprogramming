<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['logged_in']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$name = htmlspecialchars(trim($_POST['name']));
$phone = htmlspecialchars(trim($_POST['phone']));
$email = htmlspecialchars(trim($_POST['email']));
$photo_name = null; 

if (empty($name) || empty($phone)) {
    $_SESSION['error'] = "Nama dan Nomor HP wajib diisi!";
    header('Location: ../../views/contacts/add.php');
    exit();
}

// Logic Upload File
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['photo']['tmp_name'];
    $originalName = $_FILES['photo']['name'];
    $fileSize = $_FILES['photo']['size'];
    $fileType = $_FILES['photo']['type'];
    
    $fileNameCmps = explode(".", $originalName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'heic');
    
    if (in_array($fileExtension, $allowedfileExtensions)) {
        if ($fileSize < 5000000) { 
            $newFileName = md5(time() . $originalName) . '.' . $fileExtension;
            
            $uploadFileDir = '../../public/uploads/';
            $dest_path = $uploadFileDir . $newFileName;
            
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $photo_name = $newFileName;
            } else {
                $_SESSION['error'] = "Gagal memindahkan file ke folder upload.";
                header('Location: ../../views/contacts/add.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Ukuran file terlalu besar (Max 5MB).";
            header('Location: ../../views/contacts/add.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Format file tidak didukung. Gunakan JPG/PNG.";
        header('Location: ../../views/contacts/add.php');
        exit();
    }
}

try {
    $sql = "INSERT INTO contacts (user_id, name, phone, email, photo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $name, $phone, $email, $photo_name]);

    $_SESSION['success'] = "Kontak berhasil ditambahkan!";
    header('Location: ../../index.php');
    exit();

} catch (PDOException $e) {
    $_SESSION['error'] = "Gagal menyimpan data database.";
    header('Location: ../../views/contacts/add.php');
    exit();
}