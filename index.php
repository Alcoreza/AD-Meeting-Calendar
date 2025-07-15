<?php
session_start();

require_once 'bootstrap.php';
require_once UTILS_PATH . 'auth.util.php';
require_once LAYOUTS_PATH . 'main.layout.php';

// Database checkers
$mongoStatus = include HANDLERS_PATH . 'mongodbChecker.handler.php';
$pgStatus = include HANDLERS_PATH . 'postgreChecker.handler.php';

// Seeder & Migrator
include_once UTILS_PATH . 'dbMigratePostgresql.util.php';
include_once UTILS_PATH . 'dbSeederPostgresql.util.php';

// Components
require_once COMPONENTS_PATH . 'dbStatus.component.php';
require_once COMPONENTS_PATH . 'seederStatus.component.php';
require_once COMPONENTS_PATH . 'authBlock.component.php';

$title = "Dashboard Home";

renderMainLayout(function () use ($mongoStatus, $pgStatus) {
    $seederStatus = $GLOBALS['seederStatus'] ?? '<span style="color:red;">❌ Not run</span>';
    $migrateStatus = $GLOBALS['migrateStatus'] ?? '<span style="color:red;">❌ Not run</span>';
    $user = Auth::user();
    ?>
    <div class="container">
        <h1>Welcome to the Dashboard System</h1>
        <?php
        renderDbStatus($mongoStatus, $pgStatus);
        renderSeederStatus($seederStatus, $migrateStatus);
        renderAuthBlock($user);
        ?>
    </div>
    <?php
}, $title);
