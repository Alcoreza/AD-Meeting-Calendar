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

foreach ([
    'meeting_users',
    'meetings',
    'tasks',
    'users'
] as $table) {
    $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
}

$modelFiles = [
    'database/user.model.sql',
    'database/meeting.model.sql',
    'database/meeting_users.model.sql',
    'database/tasks.model.sql'
];

foreach ($modelFiles as $file) {
    $sql = file_get_contents($file);
    if ($sql === false) {
        throw new RuntimeException("❌ Could not read {$file}");
    } else {
        $pdo->exec($sql);
    }
}

$GLOBALS['migrateStatus'] = "✅ PostgreSQL database migrated successfully.";
