<?php
session_start();
require 'db.php';

$name  = trim($_POST['name']);
$email = trim($_POST['email']);
$pass  = $_POST['password'];

if (!$name || !$email || !$pass) {
    die("All fields required");
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user) {
    die("Account already exists. Please log in.");
}

$hash = password_hash($pass, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (name, email, password, status) VALUES (?, ?, ?, 'active')");
$stmt->execute([$name, $email, $hash]);
$userId = $pdo->lastInsertId();

// LINK GUEST REVIEWS
$stmt = $pdo->prepare("UPDATE reviews SET user_id = ?, guest_email = NULL WHERE guest_email = ?");
$stmt->execute([$userId, $email]);

$_SESSION['user_id'] = $userId;
$_SESSION['role'] = 'user';
header("Location: dashboard.php");
?>