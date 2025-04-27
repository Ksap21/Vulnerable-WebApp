<?php
session_start();

header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline';");

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_form.php");
    exit();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Global Trust Bank - Dashboard</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f8f9fa;
    color: #333;
    margin: 0;
    padding: 20px;
}
.header {
    background-color: #007bff;
    color: white;
    padding: 20px;
    text-align: center;
    font-size: 28px;
    margin-bottom: 20px;
}
.section {
    background: white;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.balance {
    font-size: 32px;
    color: #28a745;
    margin: 10px 0;
}
.transaction-list {
    list-style: none;
    padding: 0;
}
.transaction-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #ddd;
}
.transaction-amount.debit {
    color: #dc3545;
}
.transaction-amount.credit {
    color: #28a745;
}
.secret-code {
    background: #e9ecef;
    padding: 15px;
    border-radius: 6px;
    font-family: monospace;
}
</style>
</head>
<body>

<div class="header">Global Trust Bank</div>

<div class="section">
<h2>Login Successful!</h2>
</div>

<div class="section">
<h3>Account Overview</h3>
<div class="balance">$15,245.73</div>
<p>Checking Account •••• 6789</p>
</div>

<div class="section">
<h3>Recent Transactions</h3>
<ul class="transaction-list">
<li class="transaction-item"><span>Amazon Purchase</span> <span class="transaction-amount debit">-$89.99</span></li>
<li class="transaction-item"><span>Salary Deposit</span> <span class="transaction-amount credit">+$2,500.00</span></li>
<li class="transaction-item"><span>Electric Bill</span> <span class="transaction-amount debit">-$120.50</span></li>
<li class="transaction-item"><span>Starbucks</span> <span class="transaction-amount debit">-$5.75</span></li>
</ul>
</div>

<div class="section">
<h3>Secure Notes (Confidential)</h3>
<div class="secret-code">Level 2 Access Code: <strong>f2c47a89b5e9340cf1d7d0e2f6a12d98</strong></div>
</div>

</body>
</html>
