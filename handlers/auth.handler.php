<?php
require_once 'bootstrap.php';
require_once UTILS_PATH . 'auth.util.php';

Auth::init();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// 🔐 Attempt login using Auth utility
if (Auth::login($username, $password)) {
    header('Location: /index.php');
    exit;
} else {
    session_start();
    $_SESSION['error'] = 'Invalid username or password.';
    header('Location: /login.php');
    exit;
}
