<?php
session_start();
// Add this at the top of Lev2CodeSubmission.php
session_start();
var_dump($_SESSION);
if (isset($_SESSION['level2_unlocked']) && $_SESSION['level2_unlocked']) {
    header('Location: login_form.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VulnWebApp - Level 2 Access</title>
</head>
<body>
    <h1>Level 2 - Restricted Access</h1>
    <p>Enter the access code you obtained from Level 1:</p>
    
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;">Invalid access code. Try again.</p>
    <?php endif; ?>
    
    <form action="ValidateCode.php" method="POST">  <!-- Changed to ValidateCode.php -->
        <input type="text" name="access_code" placeholder="Enter access code">
        <button type="submit">Submit</button>
    </form>
</body>
</html>