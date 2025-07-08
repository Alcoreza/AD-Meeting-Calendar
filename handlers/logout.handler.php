<?php
require BOOTSTRAP_PATH;
require_once UTILS_PATH . 'auth.util.php';

Auth::logout();
header('Location: /index.php');
exit;
