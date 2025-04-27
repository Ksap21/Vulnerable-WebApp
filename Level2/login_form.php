<?php
session_start();
require 'config.php';

// Check if user has unlocked Level 2
if (!isset($_SESSION['level2_unlocked']) || !$_SESSION['level2_unlocked']) {
    header('Location: Lev2CodeSubmission.php');  // Changed to Lev2CodeSubmission.php
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // This is intentionally vulnerable to SQL injection
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $pdo->query($sql);
    
    if ($result->rowCount() > 0) {
        $success = "Congratulations! You've successfully logged in. Flag: SQLI_MASTER_{RANDOM_STRING}";
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VulnWebApp - Level 2 Login</title>
</head>
<body>
    <h1>Level 2 - Admin Login</h1>
    
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php else: ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <p><small>Hint: Try SQL injection techniques like <code>' OR '1'='1</code></small></p>
    <?php endif; ?>
</body>
</html>
