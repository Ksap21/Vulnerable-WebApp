<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'config.php';

// Hardcoded valid code
$valid_code = "f2c47a89b5e9340cf1d7d0e2f6a12d98";

// Debug: Log POST data
file_put_contents('debug.log', print_r($_POST, true), FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['access_code'])) {
    $user_code = $_POST['access_code'];
    
    // Debug: Log code comparison
    file_put_contents('debug.log', "Comparing: $user_code vs $valid_code\n", FILE_APPEND);
    
    if ($user_code === $valid_code) {
        $_SESSION['level2_unlocked'] = true;
        // Debug: Log successful validation
        file_put_contents('debug.log', "Code validated successfully\n", FILE_APPEND);
        header('Location: login_form.php');
        exit();
    } else {
        // Debug: Log failed validation
        file_put_contents('debug.log', "Invalid code entered\n", FILE_APPEND);
        header('Location: Lev2CodeSubmission.php?error=1');
        exit();
    }
} else {
    // Debug: Log missing access code
    file_put_contents('debug.log', "No access code provided\n", FILE_APPEND);
    header('Location: Lev2CodeSubmission.php');
    exit();
}
?>