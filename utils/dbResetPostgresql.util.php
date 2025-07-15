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

// Just indicator it was working
echo "Applying schema from database/users.model.sql…\n";

$sql = file_get_contents('database/users.model.sql');

// Another indicator but for failed creation
if ($sql === false) {
    throw new RuntimeException("Could not read database/users.model.sql");
} else {
    echo "Creation Success from the database/users.model.sql";
}

// If your model.sql contains a working command it will be executed
$pdo->exec($sql);

echo "Truncating tables…\n";
foreach (['users'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}

$modelFiles = [
    'database/users.model.sql',
    'database/meetings.model.sql',
    'database/meeting_users.model.sql',
    'database/tasks.model.sql'
];

foreach ($modelFiles as $file) {
    echo "Applying schema from {$file}…\n";
    $sql = file_get_contents($file);
    if ($sql === false) {
        throw new RuntimeException("❌ Could not read {$file}");
    } else {
        $pdo->exec($sql);
        echo "✓ Successfully applied schema: {$file}\n";
    }
}

echo "\n✅ PostgreSQL database reset and reloaded successfully.\n";