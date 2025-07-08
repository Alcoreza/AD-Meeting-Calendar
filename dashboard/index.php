<?php
require_once '../../utils/auth.util.php';

Auth::init();
if (!Auth::check()) {
    header("Location: /pages/login/index.php");
    exit;
}

$user = Auth::user();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | AD-Meeting-Calendar</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <div class="header dashboard-nav">
        <div><strong>Dashboard</strong></div>
        <div>
            Welcome, <?= htmlspecialchars($user['full_name']) ?>
            | <a href="/authLogout/index.php" class="btn" style="margin-left: 10px;">Logout</a>
        </div>
    </div>

    <div class="container">
        <h2>Your Meetings</h2>

        <div class="card">
            <p>📅 <strong>Upcoming:</strong> Dev Standup @ 9:00 AM</p>
        </div>

        <div class="card">
            <p>📝 <strong>Task:</strong> Finalize UI for Meeting Scheduler</p>
        </div>

        <div class="card">
            <p>📌 <strong>Note:</strong> Backend review meeting scheduled tomorrow</p>
        </div>
    </div>

</body>

</html>