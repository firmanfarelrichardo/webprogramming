
<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil POST Method</title>
</head>
<body>
    <h2>Data Registrasi:</h2>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $email = $_POST['email'] ?? '';
        $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
        $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
        $bio = $_POST['bio'] ?? '';
        
        echo "<table border='1'>";
        echo "<tr><td><strong>Username</strong></td><td>" . htmlspecialchars($username) . "</td></tr>";
        echo "<tr><td><strong>Password</strong></td><td>" . str_repeat("*", strlen($password)) . "</td></tr>";
        echo "<tr><td><strong>Email</strong></td><td>" . htmlspecialchars($email) . "</td></tr>";
        echo "<tr><td><strong>Tanggal Lahir</strong></td><td>" . htmlspecialchars($tanggal_lahir) . "</td></tr>";
        echo "<tr><td><strong>Jenis Kelamin</strong></td><td>" . ($jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') . "</td></tr>";
        echo "<tr><td><strong>Bio</strong></td><td>" . nl2br(htmlspecialchars($bio)) . "</td></tr>";
        echo "</table>";
        
        echo "<h3>Debug - Semua Data POST:</h3>";
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }
    ?>
    
    <p><a href="form-post.html">Kembali ke Form</a></p>
</body>
</html>

