<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/recipients_config.php';

$recipient_emails = get_recipients_for_form('business_referral');

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

// Extract and sanitize form data
$referrer_name = isset($input['referrer_name']) ? trim($input['referrer_name']) : '';
$referrer_email = isset($input['referrer_email']) ? trim($input['referrer_email']) : '';
$referrer_phone = isset($input['referrer_phone']) ? trim($input['referrer_phone']) : '';
$business_name = isset($input['business_name']) ? trim($input['business_name']) : '';
$owner_name = isset($input['owner_name']) ? trim($input['owner_name']) : '';
$owner_phone = isset($input['owner_phone']) ? trim($input['owner_phone']) : '';
$owner_email = isset($input['owner_email']) ? trim($input['owner_email']) : '';

// Validation
$errors = [];

if (empty($referrer_name) || strlen($referrer_name) < 2) {
    $errors[] = 'Please provide your full name';
}

if (empty($referrer_email) || !filter_var($referrer_email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address';
}

if (empty($referrer_phone) || !preg_match('/^[\d\s\+\-\(\)]+$/', $referrer_phone)) {
    $errors[] = 'Please provide a valid phone number';
}

if (empty($business_name) || strlen($business_name) < 2) {
    $errors[] = 'Please provide the business name';
}

if (empty($owner_name) || strlen($owner_name) < 2) {
    $errors[] = 'Please provide the business owner\'s name';
}

if (empty($owner_phone) || !preg_match('/^[\d\s\+\-\(\)]+$/', $owner_phone)) {
    $errors[] = 'Please provide a valid business owner\'s phone number';
}

if (!empty($owner_email) && !filter_var($owner_email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid business email address';
}

// Return errors if any
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// Check for duplicate submission (same referrer email within last 24 hours for same business)
$check_stmt = $conn->prepare("SELECT id FROM business_referrals WHERE referrer_email = ? AND business_name = ? AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
$check_stmt->bind_param("ss", $referrer_email, $business_name);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'You have already referred this business recently. Our team will contact them soon.']);
    exit;
}
$check_stmt->close();

// Insert into database
$stmt = $conn->prepare("
    INSERT INTO business_referrals (
        referrer_name, referrer_email, referrer_phone,
        business_name, owner_name, owner_phone, owner_email,
        status, created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, 'new', NOW())
");

$stmt->bind_param(
    "sssssss",
    $referrer_name, $referrer_email, $referrer_phone,
    $business_name, $owner_name, $owner_phone, $owner_email
);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to submit referral. Please try again later.']);
    exit;
}

$stmt->close();

// Send email notification
$email_subject = "New Submission – Business Referral";
$email_body = "Form Name: Business Referral
Submitted On: " . date('F j, Y \a\t g:i A') . "

---

Contact Information:
Name: {$referrer_name}
Email: {$referrer_email}
Phone: {$referrer_phone}

---

Submission Details:
Referred Business Name: {$business_name}
Business Owner Name: {$owner_name}
Business Owner Phone: {$owner_phone}
Business Owner Email: " . ($owner_email ?: 'Not provided') . "

---

Notes:
* This submission was sent via the website.
* Reply directly from info@optimum-payments.com to respond.
";

$headers = "From: info@optimum-payments.com\r\n";
$headers .= "Reply-To: info@optimum-payments.com\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send to all recipients
foreach ($recipient_emails as $recipient) {
    send_notification_email($recipient, $email_subject, $email_body, $headers);
}

// Send confirmation email to referrer
$user_confirm_subject = 'Referral Received - Thank You';
$user_confirm_body = "Hi {$referrer_name},\n\nWe've received your referral-thank you for connecting us.\n\nOur team will review the details and follow up as needed.\n\nWe appreciate your trust in Optimum Payments.\n\nBest regards,\nOptimum Payments Team";
send_user_confirmation_email($referrer_email, $user_confirm_subject, $user_confirm_body);

// Return success
echo json_encode([
    'success' => true,
    'message' => 'Thank you for your referral! We\'ll contact the business owner within 24 hours and keep you updated on your $500 reward.'
]);

$conn->close();
?>
