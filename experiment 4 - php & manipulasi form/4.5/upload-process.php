<?php
$targetDir = "uploads/";
$uploadOk = 1;
$errors = [];

// Buat direktori uploads jika belum ada
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (isset($_POST["submit"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $deskripsi = htmlspecialchars($_POST["deskripsi"]);
    
    $fileName = basename($_FILES["file"]["name"]);
    $targetFile = $targetDir . time() . "_" . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $fileSize = $_FILES["file"]["size"];
    
    if ($fileType != "jpg" && $fileType != "jpeg" && $fileType != "png" && $fileType != "gif" && $fileType != "pdf") {
        $errors[] = "Hanya file JPG, JPEG, PNG, GIF & PDF yang diperbolehkan.";
        $uploadOk = 0;
    }
    
    if ($fileSize > 2000000) {
        $errors[] = "File terlalu besar. Maksimal 2MB.";
        $uploadOk = 0;
    }
    
    if (file_exists($targetFile)) {
        $errors[] = "File sudah ada.";
        $uploadOk = 0;
    }
    
    if ($_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
        $errors[] = "Error saat upload file.";
        $uploadOk = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Upload</title>
    <style>
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h2>Hasil Upload File</h2>
    
    <?php
    if (isset($_POST["submit"])) {
        if ($uploadOk == 0) {
            echo "<div class='error'>";
            echo "<h3>Upload Gagal!</h3>";
            foreach ($errors as $error) {
                echo "<p>• " . $error . "</p>";
            }
            echo "</div>";
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                echo "<div class='success'>";
                echo "<h3>Upload Berhasil!</h3>";
                echo "<p><strong>Nama:</strong> " . $nama . "</p>";
                echo "<p><strong>File:</strong> " . $fileName . "</p>";
                echo "<p><strong>Ukuran:</strong> " . number_format($fileSize / 1024, 2) . " KB</p>";
                echo "<p><strong>Tipe:</strong> " . strtoupper($fileType) . "</p>";
                echo "<p><strong>Deskripsi:</strong> " . $deskripsi . "</p>";
                
                if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "<p><strong>Preview:</strong><br>";
                    echo "<img src='" . $targetFile . "' alt='Preview' style='max-width: 300px; max-height: 200px;'></p>";
                }
                echo "</div>";
            } else {
                echo "<div class='error'><p>Terjadi error saat upload file.</p></div>";
            }
        }
    }
    ?>
    
    <p><a href="upload-form.html">Upload File Lain</a></p>
    
    <h3>File yang Telah Diupload:</h3>
    <?php
    $files = glob($targetDir . "*");
    if ($files) {
        echo "<ul>";
        foreach ($files as $file) {
            echo "<li><a href='" . $file . "' target='_blank'>" . basename($file) . "</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Belum ada file yang diupload.</p>";
    }
    ?>
</body>
</html>