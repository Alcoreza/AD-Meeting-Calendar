<?php
session_start();
require 'bootstrap.php';
require_once UTILS_PATH . 'auth.util.php';

// Database checkers
include_once HANDLERS_PATH . 'mongodbChecker.handler.php';
include_once HANDLERS_PATH . 'postgreChecker.handler.php';

// Seeder & Migrator
include_once UTILS_PATH . 'dbMigratePostgresql.util.php';
include_once UTILS_PATH . 'dbSeederPostgresql.util.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Home</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Welcome to the Dashboard System</h1>

        <div class="status-section">
            <h3>📊 Database Status</h3>
            <p><strong>MongoDB:</strong> <?= $mongoStatus ?? '<span style="color:red;">❌ Unchecked</span>' ?></p>
            <p><strong>PostgreSQL:</strong> <?= $pgStatus ?? '<span style="color:red;">❌ Unchecked</span>' ?></p>
        </div>

        <div class="status-section">
            <h3>🛠 Seeder & Migrator Status</h3>
            <p><strong>Seeder:</strong> <?= $GLOBALS['seederStatus'] ?? '<span style="color:red;">❌ Not run</span>' ?>
            </p>
            <p><strong>Migrator:</strong>
                <?= $GLOBALS['migrateStatus'] ?? '<span style="color:red;">❌ Not run</span>' ?></p>
        </div>

        <div class="status-section">
            <?php if (!Auth::check()): ?>
                <a href="/pages/login/index.php"><button>Login</button></a>
            <?php else: ?>
                <?php $user = Auth::user(); ?>
                <p>👋 Hello, <strong><?= htmlspecialchars($user['first_name']) ?></strong>
                    (<?= htmlspecialchars($user['role']) ?>)</p>
                <form method="POST" action="/handlers/logout.handler.php">
                    <button type="submit">Logout</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>