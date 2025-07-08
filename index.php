<?php
session_start();
require 'bootstrap.php';
require_once UTILS_PATH . 'auth.util.php';

include HANDLERS_PATH . 'mongodbChecker.handler.php';
include HANDLERS_PATH . 'postgreChecker.handler.php';
include_once UTILS_PATH . 'dbSeederPostgresql.util.php';
include_once UTILS_PATH . 'dbMigratePostgresql.util.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard / Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="status-section">
            <h3>Database Status:</h3>
            <p><?= $mongoStatus ?? 'MongoDB check not available' ?></p>
            <p><?= $pgStatus ?? 'PostgreSQL check not available' ?></p>

            <h3>Seeder & Migrator Status:</h3>
            <p><?= $GLOBALS['seederStatus'] ?? 'Seeder not run' ?></p>
            <p><?= $GLOBALS['migrateStatus'] ?? 'Migrator not run' ?></p>
        </div>

        <?php if (!Auth::check()): ?>
            <h2>Login</h2>

            <?php if (!empty($_SESSION['error'])): ?>
                <p class="error"><?= $_SESSION['error'] ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST" action="/handlers/auth.handler.php" class="login-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input name="username" type="text" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input name="password" type="password" required>
                </div>

                <button type="submit" name="login">Login</button>
            </form>

        <?php else:
            $user = Auth::user();
            ?>
            <h1>Welcome, <?= htmlspecialchars($user['first_name']) ?>!</h1>
            <p>You are logged in as <strong><?= htmlspecialchars($user['role']) ?></strong>.</p>

            <form method="POST">
                <button name="logout" type="submit">Logout</button>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>