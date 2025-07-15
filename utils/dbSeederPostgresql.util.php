<?php
declare(strict_types=1);

require_once 'bootstrap.php';
require_once VENDOR_PATH . 'autoload.php';
require_once UTILS_PATH . 'envSetter.util.php';

try {
    $users = require_once DUMMIES_PATH . 'users.staticData.php';
    $meetings = require_once DUMMIES_PATH . 'meetings.staticData.php';
    $meetingUsers = require_once DUMMIES_PATH . 'meeting_users.staticData.php';
    $tasks = require_once DUMMIES_PATH . 'tasks.staticData.php';

    $dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['dbname']}";
    $pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $pdo->beginTransaction();

    // Truncate all tables
    $pdo->exec('TRUNCATE TABLE tasks, meeting_users, meetings, users RESTART IDENTITY CASCADE');

    // Insert users
    $stmt = $pdo->prepare(
        'INSERT INTO users (first_name, last_name, middle_name, role, username, password, created_at, updated_at)
     VALUES (:fn, :ln, :mn, :role, :username, :pw, :created_at, :updated_at)'
    );
    foreach ($users as $u) {
        $stmt->execute([
            ':fn' => $u['first_name'],
            ':ln' => $u['last_name'],
            ':mn' => $u['middle_name'] ?? null,
            ':role' => $u['role'],
            ':username' => $u['username'],
            ':pw' => password_hash($u['password'], PASSWORD_DEFAULT),
            ':created_at' => date('Y-m-d H:i:s'),
            ':updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    // Insert meetings
    $meetingsStmt = $pdo->prepare(
        'INSERT INTO meetings (title, description, schedule, location, created_by, created_at, updated_at)
         VALUES (:title, :description, :schedule, :location, :created_by, :created_at, :updated_at)'
    );
    foreach ($meetings as $m) {
        $meetingsStmt->execute([
            ':title' => $m['title'],
            ':description' => $m['description'],
            ':schedule' => $m['schedule'],
            ':location' => $m['location'],
            ':created_by' => $m['created_by'],
            ':created_at' => $m['created_at'],
            ':updated_at' => $m['updated_at'],
        ]);
    }

    // Insert meeting_users
    $meetingUsersStmt = $pdo->prepare(
        'INSERT INTO meeting_users (meeting_id, user_id, role)
         VALUES (:meeting_id, :user_id, :role)'
    );
    foreach ($meetingUsers as $mu) {
        $meetingUsersStmt->execute([
            ':meeting_id' => $mu['meeting_id'],
            ':user_id' => $mu['user_id'],
            ':role' => $mu['role'],
        ]);
    }

    // Insert tasks
    $tasksStmt = $pdo->prepare(
        'INSERT INTO tasks (meeting_id, assigned_to, title, description, status, due_date, created_at, updated_at)
         VALUES (:meeting_id, :assigned_to, :title, :description, :status, :due_date, :created_at, :updated_at)'
    );
    foreach ($tasks as $t) {
        $tasksStmt->execute([
            ':meeting_id' => $t['meeting_id'],
            ':assigned_to' => $t['assigned_to'],
            ':title' => $t['title'],
            ':description' => $t['description'],
            ':status' => $t['status'],
            ':due_date' => $t['due_date'],
            ':created_at' => $t['created_at'],
            ':updated_at' => $t['updated_at'],
        ]);
    }

    $pdo->commit();
    $GLOBALS['seederStatus'] = "✅ PostgreSQL seeding complete!";

} catch (PDOException $e) {
    $pdo->rollBack();
    $GLOBALS['seederStatus'] = "❌ Seeding failed: " . $e->getMessage();
}
