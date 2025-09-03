<?php

$port = (int) getenv('PORT');
if ($port <= 0) {
    $port = 8000; // Default port if not set or invalid
}

$host = '0.0.0.0';

echo "Starting Laravel server on {$host}:{$port}\n";

// Passthru will execute the command and pass the output directly to the console.
// escapeshellarg ensures the arguments are passed safely.
passthru('php artisan serve --host=' . escapeshellarg($host) . ' --port=' . escapeshellarg($port));
