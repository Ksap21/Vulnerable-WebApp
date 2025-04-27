<?php
// search.php - Secure version
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'");

$query = $_GET['query'] ?? '';
echo "<h3>Search results for: " . htmlspecialchars($query, ENT_QUOTES, 'UTF-8') . "</h3>";
?>