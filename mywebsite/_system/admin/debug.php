<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if authenticated
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die('Not authenticated. Please <a href="../auth/login.php">login first</a>.');
}

require_once __DIR__ . '/../../db.php';

echo "<h1>Admin Debug Info</h1>";
echo "<p><strong>User ID:</strong> " . htmlspecialchars($_SESSION['user_id']) . "</p>";
echo "<p><strong>Role:</strong> " . htmlspecialchars($_SESSION['role']) . "</p>";

echo "<h2>Database Tables Check</h2>";

$tables_to_check = [
    'reviews',
    'contact_messages',
    'merchant_applications',
    'digital_briefs',
    'business_referrals',
    'business_owners',
    'users'
];

foreach ($tables_to_check as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        echo "<p style='color: green;'>✓ Table '$table' exists</p>";
    } else {
        echo "<p style='color: red;'>✗ Table '$table' MISSING</p>";
    }
}

echo "<h2>Query Test</h2>";

// Test reviews table
$result = $conn->query("SELECT COUNT(*) as total FROM reviews");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p style='color: green;'>✓ Reviews query successful (Total: " . $row['total'] . ")</p>";
} else {
    echo "<p style='color: red;'>✗ Reviews query failed: " . $conn->error . "</p>";
}

// Test contact_messages table
$result = $conn->query("SELECT COUNT(*) as total FROM contact_messages");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p style='color: green;'>✓ Contact Messages query successful (Total: " . $row['total'] . ")</p>";
} else {
    echo "<p style='color: red;'>✗ Contact Messages query failed: " . $conn->error . "</p>";
}

// Test merchant_applications table
$result = $conn->query("SELECT COUNT(*) as total FROM merchant_applications");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p style='color: green;'>✓ Merchant Applications query successful (Total: " . $row['total'] . ")</p>";
} else {
    echo "<p style='color: red;'>✗ Merchant Applications query failed: " . $conn->error . "</p>";
}

// Test digital_briefs table
$result = $conn->query("SELECT COUNT(*) as total FROM digital_briefs");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p style='color: green;'>✓ Digital Briefs query successful (Total: " . $row['total'] . ")</p>";
} else {
    echo "<p style='color: red;'>✗ Digital Briefs query failed: " . $conn->error . "</p>";
}

// Test business_referrals table
$result = $conn->query("SELECT COUNT(*) as total FROM business_referrals");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p style='color: green;'>✓ Business Referrals query successful (Total: " . $row['total'] . ")</p>";
} else {
    echo "<p style='color: red;'>✗ Business Referrals query failed: " . $conn->error . "</p>";
}

// Test business_owners table
$result = $conn->query("SELECT COUNT(*) as total FROM business_owners");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p style='color: green;'>✓ Business Owners query successful (Total: " . $row['total'] . ")</p>";
} else {
    echo "<p style='color: red;'>✗ Business Owners query failed: " . $conn->error . "</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>Back to Dashboard</a></p>";
?>
