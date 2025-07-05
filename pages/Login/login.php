<?php
session_start();
require 'bootstrap.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>

    <h2>Login Page</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <p style="color:red"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="/handlers/auth.handler.php">
        <label for="username">Username:</label><br>
        <input id="username" name="username" type="text" required><br><br>

        <label for="password">Password:</label><br>
        <input id="password" name="password" type="password" required><br><br>

        <button type="submit">Login</button>
    </form>

</body>

</html>