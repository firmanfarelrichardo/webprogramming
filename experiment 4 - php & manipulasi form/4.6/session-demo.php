<?php
session_start();

if (!isset($_COOKIE['user_preference'])) {
    setcookie('user_preference', 'default_theme', time() + (86400 * 30)); // 30 hari
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if ($username == "admin" && $password == "123456") {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['login_time'] = date('Y-m-d H:i:s');
        } else {
            $login_error = "Username atau password salah!";
        }
    }
    
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: session-demo.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Session & Cookie Demo</title>
    <style>
        .login-form { border: 1px solid #ccc; padding: 20px; max-width: 400px; }
        .user-info { background: #e7f3ff; padding: 15px; border-radius: 5px; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Demo Session & Cookie PHP</h2>
    
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
        <div class="user-info">
            <h3>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
            <p><strong>Waktu Login:</strong> <?php echo $_SESSION['login_time']; ?></p>
            <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
            
            <form method="POST" style="margin-top: 10px;">
                <input type="submit" name="logout" value="Logout">
            </form>
        </div>
        
        <h3>Data Session:</h3>
        <pre><?php print_r($_SESSION); ?></pre>
        
    <?php else: ?>
        <div class="login-form">
            <h3>Login Form</h3>
            
            <?php if (isset($login_error)): ?>
                <p class="error"><?php echo $login_error; ?></p>
            <?php endif; ?>
            
            <form method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="admin" required><br><br>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="123456" required><br><br>
                
                <input type="submit" name="login" value="Login">
            </form>
            
            <p><small>Hint: username = admin, password = 123456</small></p>
        </div>
    <?php endif; ?>
    
    <h3>Cookie Information:</h3>
    <p><strong>User Preference Cookie:</strong> <?php echo $_COOKIE['user_preference'] ?? 'Belum diset'; ?></p>
    
    <h3>Debug Information:</h3>
    <p><strong>All Cookies:</strong></p>
    <pre><?php print_r($_COOKIE); ?></pre>
</body>
</html>