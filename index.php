<?php
session_start();
require 'bootstrap.php';
require_once UTILS_PATH . 'auth.util.php';

// ✅ Run DB checkers first
include HANDLERS_PATH . 'mongodbChecker.handler.php';
include HANDLERS_PATH . 'postgreChecker.handler.php';
// Run Seeder and Migrator
include_once UTILS_PATH . 'dbSeederPostgresql.util.php';
include_once UTILS_PATH . 'dbMigratePostgresql.util.php';

// ✅ Handle Login Logic before output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (Auth::login($username, $password)) {
        header('Location: index.php'); // Redirect to avoid resubmission
        exit;
    } else {
        $_SESSION['error'] = 'Invalid username or password.';
        header('Location: index.php');
        exit;
    }
}

// ✅ Handle Logout before output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    Auth::logout();
    header('Location: index.php');
    exit;
}

// ✅ Now safe to output HTML
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard / Login</title>
</head>

<body>

    <h3>Database Status:</h3>
    <p><?= $mongoStatus ?? 'MongoDB check not available' ?></p>
    <p><?= $pgStatus ?? 'PostgreSQL check not available' ?></p>

    <h3>Seeder & Migrator Status:</h3>
    <p><?= $GLOBALS['seederStatus'] ?? 'Seeder not run' ?></p>
    <p><?= $GLOBALS['migrateStatus'] ?? 'Migrator not run' ?></p>

    <hr>

    <?php if (!Auth::check()): ?>
        <h2>Login</h2>

        <?php if (!empty($_SESSION['error'])): ?>
            <p style="color:red"><?= $_SESSION['error'] ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Username:</label><br>
            <input name="username" type="text" required><br><br>

            <label for="password">Password:</label><br>
            <input name="password" type="password" required><br><br>

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

</body>

</html>