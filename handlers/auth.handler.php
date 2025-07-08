<?php
require_once BOOTSTRAP_PATH;
require_once UTILS_PATH . 'auth.util.php';

Auth::init();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// 🔐 Attempt login using Auth utility
if (Auth::login($username, $password)) {
    header('Location: /dashboard/index.php');
    exit;
} else {
    $error = urlencode('Invalid username or password.');
    header('Location: /pages/login/index.php?error=' . $error);
    exit;
}
