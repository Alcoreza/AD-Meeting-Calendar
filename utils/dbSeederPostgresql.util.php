<?php
declare(strict_types=1);

// 1) Composer bootstrap
require 'bootstrap.php';

// 2) Composer autoload
require 'vendor/autoload.php';

// 3) envSetter
require_once UTILS_PATH . '/envSetter.util.php';

// 4) PostgreSQL Connection
$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['dbname']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "✅ Connected to PostgreSQL\n";

// 5) Read and apply schema
$sqlPath = BASE_PATH . '/database/user.model.sql';
$sql = file_get_contents($sqlPath);
if ($sql === false) {
    throw new RuntimeException("❌ Could not read $sqlPath");
}
$pdo->exec($sql);
echo "✔️  Table created from user.model.sql\n";

// 6) Load Dummy Data
$users = require_once DUMMIES_PATH . 'users.staticData.php';

// 7) Seeding Logic
echo "🌱 Seeding users...\n";

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

echo "✅ Seeding complete.\n";