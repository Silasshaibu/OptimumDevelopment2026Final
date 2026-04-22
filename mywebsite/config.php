
<?php
// TEMPORARY: show PHP errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Detect protocol
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    ? 'https'
    : 'http';

// Base URL (PROJECT ROOT)
// $base_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/MYWEBSITE';
$base_url = '/mywebsite';
// $base_url = 'https://task.optimum-payments.com';

// Preloader Configuration
$enable_preloader = !isset($_GET['disable-preloader']);

// Load environment variables from .env if available
$env = [];
if (file_exists(__DIR__ . '/.env')) {
    // simple parser that handles values starting with special characters
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') {
            continue;
        }
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $val = trim($parts[1]);
            // strip optional surrounding quotes
            $val = trim($val, "\"'");
            $env[$key] = $val;
        }
    }
}

// Database connection parameters (override with .env values)
$host = $env['DB_HOST'] ?? 'localhost';
$db   = $env['DB_NAME'] ?? 'dbpyuo9mf19qbv';
$user = $env['DB_USER'] ?? 'usmpvkou40gtp';       // replace with your DB username
$pass = $env['DB_PASS'] ?? '|2@3d#vqu2#@';   // replace with your DB password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Database connection on local server (uncomment if testing locally)
// $host = "localhost";
// $db   = "dbpyuo9mf19qbv";
// $user = "root";       // replace with your DB username
// $pass = "";   // replace with your DB password

// $conn = new mysqli($host, $user, $pass, $db);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }