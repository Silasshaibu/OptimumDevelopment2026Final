<?php
// PDO Database Connection for Product Management
$host = "localhost";
$db   = "dbpyuo9mf19qbv";
$user = "usmpvkou40gtp";       // replace with your DB username
$pass = "|2@3d#vqu2#@";   // replace with your DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}



