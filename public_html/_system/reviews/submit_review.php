<?php
session_start();
require '../db.php';
require_once __DIR__ . '/../recipients_config.php';

$rating = (int) $_POST['rating'];
$review = trim($_POST['review']);
$email  = $_POST['email'] ?? null;
$userId = $_SESSION['user_id'] ?? null;

// Basic validation
if ($rating < 1 || $rating > 5 || empty($review)) {
    die("Invalid submission");
}

// DUPLICATE CHECK
if ($userId) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM reviews WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_row()[0];
} else {
    if (!$email) die("Email required");
    $stmt = $conn->prepare("SELECT COUNT(*) FROM reviews WHERE guest_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_row()[0];
}

if ($count > 0) {
    die("You have already submitted a review.");
}

// INSERT REVIEW
$stmt = $conn->prepare("INSERT INTO reviews (user_id, guest_email, rating, review, status, source) VALUES (?, ?, ?, ?, 'pending', 'direct')");
$stmt->bind_param("isss", $userId, $email, $rating, $review);
$stmt->execute();

$subject = 'New Submission - Customer Review (Legacy Endpoint)';
$body = "A new review was submitted and is awaiting approval.\n\n"
    . "Email: " . ($email ?: 'N/A') . "\n"
    . "Rating: " . intval($rating) . "/5\n"
    . "Review:\n" . $review . "\n\n"
    . "Submitted: " . date('Y-m-d H:i:s') . "\n"
    . "Moderate now: "
    . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
    . "://" . ($_SERVER['HTTP_HOST'] ?? 'localhost')
    . "/_system/admin/reviews.php?status=pending\n";

$headers = "From: info@optimum-payments.com\r\n";
$headers .= "Reply-To: info@optimum-payments.com\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

foreach (get_recipients_for_form('review') as $adminEmail) {
    send_notification_email($adminEmail, $subject, $body, $headers);
}

echo "Review submitted and awaiting approval.";
?>