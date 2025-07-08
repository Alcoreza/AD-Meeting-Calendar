<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>System Status | AD-Meeting-Calendar</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <div class="header">
        AD Meeting Calendar
    </div>

    <div class="container">
        <h2>✅ System Status Check</h2>
        <p>Below are the results of your database connection checks:</p>

        <div class="card">
            <?php include_once "handlers/mongodbChecker.handler.php"; ?>
            <?php include_once "handlers/postgreChecker.handler.php"; ?>
        </div>

        <div style="margin-top: 30px;">
            <a href="/pages/login/index.php" class="btn">Go to Login Page</a>
        </div>
    </div>

</body>

</html>