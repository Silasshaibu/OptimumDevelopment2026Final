<?php
$host = "localhost";
$db   = "dbpyuo9mf19qbv";
$user = "usmpvkou40gtp";       // replace with your DB username
$pass = "|2@3d#vqu2#@";   // replace with your DB password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>