<?php
$errors = [];
$data = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nama"])) {
        $errors[] = "Nama harus diisi";
    } else {
        $data['nama'] = trim($_POST["nama"]);
        if (!preg_match("/^[a-zA-Z\s]+$/", $data['nama'])) {
            $errors[] = "Nama hanya boleh mengandung huruf dan spasi";
        }
    }
    
    if (empty($_POST["email"])) {
        $errors[] = "Email harus diisi";
    } else {
        $data['email'] = trim($_POST["email"]);
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format email tidak valid";
        }
    }
    
    if (empty($_POST["umur"])) {
        $errors[] = "Umur harus diisi";
    } else {
        $data['umur'] = (int)$_POST["umur"];
        if ($data['umur'] < 1 || $data['umur'] > 120) {
            $errors[] = "Umur harus antara 1-120 tahun";
        }
    }
    
    if (!empty($_POST["website"])) {
        $data['website'] = trim($_POST["website"]);
        if (!filter_var($data['website'], FILTER_VALIDATE_URL)) {
            $errors[] = "Format URL website tidak valid";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Validation</title>
    <style>
        .error { color: red; }
        .success { color: green; }
        .form-group { margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Form dengan Validasi</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="error">
            <h3>Error:</h3>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <div class="success">
            <h3>Data Berhasil Divalidasi!</h3>
            <p><strong>Nama:</strong> <?php echo htmlspecialchars($data['nama']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($data['email']); ?></p>
            <p><strong>Umur:</strong> <?php echo $data['umur']; ?> tahun</p>
            <?php if (!empty($data['website'])): ?>
                <p><strong>Website:</strong> <a href="<?php echo htmlspecialchars($data['website']); ?>" target="_blank"><?php echo htmlspecialchars($data['website']); ?></a></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="nama">Nama Lengkap:</label>
            <input type="text" id="nama" name="nama" value="<?php echo isset($data['nama']) ? htmlspecialchars($data['nama']) : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($data['email']) ? htmlspecialchars($data['email']) : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="umur">Umur:</label>
            <input type="number" id="umur" name="umur" min="1" max="120" value="<?php echo isset($data['umur']) ? $data['umur'] : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="website">Website (opsional):</label>
            <input type="url" id="website" name="website" value="<?php echo isset($data['website']) ? htmlspecialchars($data['website']) : ''; ?>">
        </div>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>