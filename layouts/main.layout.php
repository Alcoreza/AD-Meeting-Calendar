<?php
require_once BOOTSTRAP_PATH;
require_once VENDOR_PATH . 'autoload.php';

function renderMainLayout(callable $content, string $title): void
{
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title><?= $title ?></title>
        <link rel="stylesheet" href="/assets/css/styles.css">
    </head>

    <body>
        <?php $content(); ?>
    </body>

    </html>
    <?php
}