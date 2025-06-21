<?php

require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$pgConfig = [
    'host' => $_ENV['PG_HOST'],
    'port' => $_ENV['PG_PORT'],
    'dbname' => $_ENV['PG_DB'],
    'user' => $_ENV['PG_USER'],
    'pass' => $_ENV['PG_PASS']
];

$mongoConfig = [
    'uri' => $_ENV['MONGO_URI'],
];