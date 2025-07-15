<?php

require_once UTILS_PATH . 'envSetter.util.php';

try {
    $mongo = new MongoDB\Driver\Manager($mongoConfig['uri']);

    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand("admin", $command);

    $mongoStatus = "✅ Connected to MongoDB successfully.";
} catch (MongoDB\Driver\Exception\Exception $e) {
    $mongoStatus = "❌ MongoDB connection failed: " . $e->getMessage() . "  <br>";
}

return $mongoStatus;
