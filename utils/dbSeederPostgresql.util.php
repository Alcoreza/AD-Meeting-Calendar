<?php

declare(strict_types=1);

// 2) Composer bootstrap
require 'bootstrap.php';

// 1) Composer autoload
require VENDOR_PATH . 'autoload.php';

// 3) envSetter
require_once UTILS_PATH . 'envSetter.util.php';

$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['dbname']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$users = require_once DUMMIES_PATH . 'users.staticData.php';

$pdo->exec("TRUNCATE TABLE users RESTART IDENTITY CASCADE;");


$stmt = $pdo->prepare("
    INSERT INTO users (username, role, first_name, last_name, password)
    VALUES (:username, :role, :fn, :ln, :pw)
");

foreach ($users as $u) {
    $stmt->execute([
        ':username' => $u['username'],
        ':role' => $u['role'],
        ':fn' => $u['first_name'],
        ':ln' => $u['last_name'],
        ':pw' => password_hash($u['password'], PASSWORD_DEFAULT),
    ]);
}

$GLOBALS['seederStatus'] = "✅ PostgreSQL seeding complete!";
