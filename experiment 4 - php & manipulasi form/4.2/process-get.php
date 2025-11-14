<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil GET Method</title>
</head>
<body>
    <h2>Data yang Diterima (GET Method):</h2>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        echo "<h3>Data dari URL:</h3>";
        echo "<pre>";
        print_r($_GET);
        echo "</pre>";
        
        if (isset($_GET['nama']) && !empty($_GET['nama'])) {
            echo "<p><strong>Nama:</strong> " . htmlspecialchars($_GET['nama']) . "</p>";
        }
        
        if (isset($_GET['kota']) && !empty($_GET['kota'])) {
            echo "<p><strong>Kota:</strong> " . htmlspecialchars($_GET['kota']) . "</p>";
        }
        
        if (isset($_GET['hobi']) && is_array($_GET['hobi'])) {
            echo "<p><strong>Hobi:</strong> ";
            foreach ($_GET['hobi'] as $hobi) {
                echo htmlspecialchars($hobi) . " ";
            }
            echo "</p>";
        }
    }
    ?>
    
    <p><a href="form-get.html">Kembali ke Form</a></p>
</body>
</html>