<?php
require 'bootstrap.php';
require_once UTILS_PATH . 'auth.util.php';

Auth::logout();

// Redirect to home
header('Location: /index.php');
exit;
