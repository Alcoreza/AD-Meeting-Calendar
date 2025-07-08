<?php
declare(strict_types=1);

// 1. Load environment and dependencies
require 'bootstrap.php';
require_once VENDOR_PATH . 'autoload.php';
require_once UTILS_PATH . 'envSetter.util.php';

// 2. Connect to PostgreSQL
$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['dbname']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// 3. Confirm connection and table availability
$tables = $pdo->query("SELECT schemaname, tablename FROM pg_tables WHERE tablename ILIKE '%users%'")->fetchAll(PDO::FETCH_ASSOC);
echo "<hr><strong>📋 Available user-like tables:</strong><pre>";
print_r($tables);
echo "</pre>";

echo "Connected as user: " . $pdo->query("SELECT current_user")->fetchColumn() . "<br>";

// 4. Load users from static data
$users = require_once DUMMIES_PATH . 'users.staticData.php';
if (!$users || !is_array($users)) {
    die("❌ No users loaded from staticData.");
}

echo "Loaded users:<pre>" . print_r($users, true) . "</pre>";

try {
    // 5. Start a transaction to ensure everything is committed
    $pdo->beginTransaction();

    // 6. Clear the "users" table first
    $pdo->exec('TRUNCATE TABLE public."users" RESTART IDENTITY CASCADE');

    echo "Seeder connected to: {$pgConfig['host']} / {$pgConfig['dbname']} / {$pgConfig['user']}<br>";
    $pdo->exec('DELETE FROM public."users"');



    // 7. Prepare insert statement
    $stmt = $pdo->prepare("
        INSERT INTO public.\"users\" (username, role, first_name, last_name, password)
        VALUES (:username, :role, :fn, :ln, :pw)
    ");

    // 8. Insert each user
    foreach ($users as $u) {
        $stmt->execute([
            ':username' => $u['username'],
            ':role' => $u['role'],
            ':fn' => $u['first_name'],
            ':ln' => $u['last_name'],
            ':pw' => password_hash($u['password'], PASSWORD_DEFAULT),
        ]);
        echo "✅ Inserted user: {$u['username']}<br>";
    }

    // 9. Commit the transaction to save changes
    $pdo->commit();

    $GLOBALS['seederStatus'] = "✅ PostgreSQL seeding complete!";

    // 10. Show what's now inside the users table
    $rows = $pdo->query('SELECT username FROM public."users"')->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>Users in DB:\n";
    print_r($rows);
    echo "</pre>";

} catch (PDOException $e) {
    $pdo->rollBack(); // If error, undo changes
    die("❌ DB Error: " . $e->getMessage());
}

echo "Seeder using DB: {$pgConfig['dbname']}<br>";
