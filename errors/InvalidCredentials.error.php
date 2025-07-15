<?php
$title = 'Invalid Credentials - Meeting Calendar';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/errors/assets/css/error.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body class="error-page">
    <div class="error-container">
        <div class="error-card">
            <div class="error-logo">
                <h1 class="app-title">Meeting Calendar</h1>
            </div>
            <div class="error-content">
                <div class="error-icon">🔒</div>
                <h2 class="error-title">Invalid Credentials</h2>
                <p class="error-message">
                    The username or password you entered is incorrect.<br>
                    Please try again.
                </p>
                <div class="error-actions">
                    <a href="/index.php" class="btn btn-primary">
                        🔄 Try Again
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>