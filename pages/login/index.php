<?php
session_start();
require BOOTSTRAP_PATH;
require_once UTILS_PATH . 'auth.util.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <div class="container">
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

        <p><a href="/index.php">← Back to Home</a></p>
    </div>
</body>

</html>