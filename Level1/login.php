<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Database config
$db_host = 'localhost';
$db_user = "root";
$db_pass = 'yournewpassword';  // your real root password
$db_name = 'databaselev1';

// CSRF validation
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token");
}

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Input validation
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    die("Username and password are required");
}

// Query the user
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // 👉 Level 1: Direct comparison (plain text password)
    if ($password === $user['password']) {
        session_regenerate_id();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['logged_in'] = true;

        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['login_time'] = date('Y-m-d H:i:s');
        // On successful login
        $_SESSION['success_message'] = "Login Successful!";
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid username or password!";
        header("Location: login_form.php"); // your login form filename
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid username or password!";
    header("Location: login_form.php");
    exit();
}

$stmt->close();
$conn->close();
?>
