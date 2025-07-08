<?php

require_once VENDOR_PATH . 'autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

global $pgConfig;

$pgConfig = [
    'host' => $_ENV['PG_HOST'],
    'port' => $_ENV['PG_PORT'],
    'dbname' => $_ENV['PG_DB'],
    'user' => $_ENV['PG_USER'],
    'pass' => $_ENV['PG_PASS']
];

global $mongoConfig;
$mongoConfig = [
    'uri' => $_ENV['MONGO_URI'],
];