<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/recipients_config.php';

$recipient_emails = get_recipients_for_form('review');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Accept both JSON payloads and standard form posts
$raw_input = file_get_contents('php://input');
$json_input = json_decode($raw_input, true);
$input = (is_array($json_input) && !empty($json_input)) ? $json_input : $_POST;

// Validate required fields
$rating = isset($input['rating']) ? intval($input['rating']) : 0;
$review = isset($input['review']) ? trim($input['review']) : '';
$name = isset($input['name']) ? trim($input['name']) : '';
$email = isset($input['email']) ? trim($input['email']) : '';
$privacy_agreed_raw = isset($input['privacy_agreed']) ? $input['privacy_agreed'] : false;
$privacy_agreed = filter_var($privacy_agreed_raw, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
$privacy_agreed = ($privacy_agreed === null) ? false : $privacy_agreed;

// Validation
$errors = [];

if ($rating < 1 || $rating > 5) {
    $errors[] = 'Please select a rating between 1 and 5 stars';
}

if (empty($review) || strlen($review) < 10) {
    $errors[] = 'Review must be at least 10 characters long';
}

if (empty($name) || strlen($name) < 2) {
    $errors[] = 'Please provide your name';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address';
}

if (!$privacy_agreed) {
    $errors[] = 'You must agree to the privacy policy';
}

// Return errors if any
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// Check for duplicate submission (same email within last 24 hours)
$check_stmt = $conn->prepare("SELECT id FROM reviews WHERE guest_email = ? AND source = 'direct' AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'You have already submitted a review recently. Please wait 24 hours before submitting another.']);
    exit;
}
$check_stmt->close();

// Insert review into database
$stmt = $conn->prepare("
    INSERT INTO reviews (
        rating, 
        review, 
        guest_email, 
        status, 
        source, 
        platform, 
        recommendation_type,
        created_at
    ) VALUES (?, ?, ?, 'pending', 'direct', 'website', 'positive', NOW())
");

$stmt->bind_param("iss", $rating, $review, $email);

if ($stmt->execute()) {
    $subject = "New Submission – Customer Review";
    $emailBody = "Form Name: Customer Review
Submitted On: " . date('F j, Y \a\t g:i A') . "

---

Contact Information:
Name: {$name}
Email: {$email}
Phone: N/A

---

Submission Details:
Rating: " . intval($rating) . " / 5
Review: {$review}

---

Notes:
* This submission was sent via the website.
* Reply directly from info@optimum-payments.com to respond.
* This review is pending approval. Moderate at: " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . "://" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "/_system/admin/reviews.php?status=pending
";

    $headers = "From: info@optimum-payments.com\r\n";
    $headers .= "Reply-To: info@optimum-payments.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    foreach ($recipient_emails as $adminEmail) {
        send_notification_email($adminEmail, $subject, $emailBody, $headers);
    }

    // Send confirmation email to reviewer
    $user_confirm_subject = 'Thank You for Your Feedback';
    $user_confirm_body = "Hi {$name},\n\nThank you for taking the time to share your experience with Optimum Payments.\n\nYour feedback helps us improve and continue delivering great service.\n\nWe truly appreciate it.\n\nBest regards,\nOptimum Payments Team";
    send_user_confirmation_email($email, $user_confirm_subject, $user_confirm_body);

    echo json_encode([
        'success' => true, 
        'message' => 'Thank you for your review! It will be visible once approved by our team.'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Failed to submit review. Please try again later.'
    ]);
}

$stmt->close();
$conn->close();
?>
