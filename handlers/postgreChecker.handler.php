<?php

require_once UTILS_PATH . 'envSetter.util.php';

$host = "host.docker.internal";
$port = "5112";
$username = "user";
$password = "password";
$dbname = "mydatabase";

$conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";

$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    echo "❌ Connection Failed: ", pg_last_error() . "  <br>";
    exit();
} else {
    $pgStatus = "✅ Connected to PostgreSQL successfully.";
    pg_close($dbconn);
}