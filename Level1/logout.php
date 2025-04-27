<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }

    // Clear all session variables
    $_SESSION = [];

    // Destroy session cookie properly
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_start();
$_SESSION['level_complete'] = "🎉 Congratulations! You have completed Level 1!";
header("Location: login_form.php");
exit();


    // Destroy session completely
    session_destroy();

    // Redirect immediately without starting a fresh session yet
    header("Location: login_form.php");
    exit();
} else {
    header("Location: login_form.php");
    exit();
}
?>
