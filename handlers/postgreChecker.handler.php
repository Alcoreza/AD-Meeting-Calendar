<?php

require_once UTILS_PATH . 'envSetter.util.php';

$host = $_ENV['PG_HOST'] ?? null;
$port = $_ENV['PG_PORT'] ?? null;
$username = $_ENV['PG_USER'] ?? null;
$password = $_ENV['PG_PASS'] ?? null;
$dbname = $_ENV['PG_DB'] ?? null;

$conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";

$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    $pgStatus = "❌ Connection Failed: ";
} else {
    $pgStatus = "✅ Connected to PostgreSQL successfully.";
    pg_close($dbconn);
}

return $pgStatus;