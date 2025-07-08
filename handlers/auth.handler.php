<?php
require_once BOOTSTRAP_PATH;
require_once UTILS_PATH . 'auth.util.php';

Auth::init();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
// 🔐 Attempt login using Auth utility
if (Auth::login($username, $password)) {
    header('Location: /index.php');
    exit;
} else {
    $_SESSION['error'] = 'Invalid username or password.';
    header('Location: /index.php');
    exit;
}

if (isset($_POST['logout'])) {
    Auth::logout();
    header('Location: /index.php'); // ✅ redirect to home after logout
    exit;
}


