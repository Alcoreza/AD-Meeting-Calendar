<?php
session_start();
require 'bootstrap.php';
require_once UTILS_PATH . 'auth.util.php';

if (!Auth::check()) {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Login Required</title>
    </head>

    <body>
        <h2>You are not logged in.</h2>
        <a href="/pages/Login/login.php"><button>Login</button></a>
    </body>

    </html>
    <?php
    exit;
}

$user = Auth::user();

// DB checkers
include HANDLERS_PATH . 'mongodbChecker.handler.php';
include HANDLERS_PATH . 'postgreChecker.handler.php';
include UTILS_PATH . 'dbSeederPostgresql.util.php';
include UTILS_PATH . 'dbMigratePostgresql.util.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>

    <h1>Welcome, <?= htmlspecialchars($user['first_name']) ?>!</h1>
    <p>You are logged in as <strong><?= htmlspecialchars($user['role']) ?></strong>.</p>

    <h3>Database Status:</h3>
    <p>✅ Connected to MongoDB successfully.</p>
    <p>✔️ PostgreSQL Connection</p>

    <p><a href="/logout.php"><button>Logout</button></a></p>

</body>

</html>