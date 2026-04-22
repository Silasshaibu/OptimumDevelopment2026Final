<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/recipients_config.php';

$recipient_emails = get_recipients_for_form('business_owner');

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
$owner_name = isset($input['owner_name']) ? trim($input['owner_name']) : '';
$business_name = isset($input['business_name']) ? trim($input['business_name']) : '';
$phone = isset($input['phone']) ? trim($input['phone']) : '';
$email = isset($input['email']) ? trim($input['email']) : '';

// Validation
$errors = [];

if (empty($owner_name) || strlen($owner_name) < 2) {
    $errors[] = 'Please provide your full name';
}

if (empty($business_name) || strlen($business_name) < 2) {
    $errors[] = 'Please provide your business name';
}

if (empty($phone) || !preg_match('/^[\d\s\+\-\(\)]+$/', $phone)) {
    $errors[] = 'Please provide a valid phone number';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address';
}

// Return errors if any
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// Check for duplicate submission (same email within last 7 days)
$check_stmt = $conn->prepare("SELECT id FROM business_owners WHERE email = ? AND created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)");
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'You have already submitted an inquiry recently. Our team will contact you soon.']);
    exit;
}
$check_stmt->close();

// Insert into database
$stmt = $conn->prepare("
    INSERT INTO business_owners (
        owner_name, business_name, phone, email,
        status, created_at
    ) VALUES (?, ?, ?, ?, 'new', NOW())
");

$stmt->bind_param(
    "ssss",
    $owner_name, $business_name, $phone, $email
);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to submit inquiry. Please try again later.']);
    exit;
}

$stmt->close();

// Send email notification
$email_subject = "New Submission – Business Owner Inquiry";
$email_body = "Form Name: Business Owner Inquiry
Submitted On: " . date('F j, Y \a\t g:i A') . "

---

Contact Information:
Name: {$owner_name}
Email: {$email}
Phone: {$phone}

---

Submission Details:
Business Name: {$business_name}

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

// Send confirmation email to user
$user_confirm_subject = 'Referral Received - Thank You';
$user_confirm_body = "Hi {$owner_name},\n\nWe've received your referral-thank you for connecting us.\n\nOur team will review the details and follow up as needed.\n\nWe appreciate your trust in Optimum Payments.\n\nBest regards,\nOptimum Payments Team";
send_user_confirmation_email($email, $user_confirm_subject, $user_confirm_body);

// Return success
echo json_encode([
    'success' => true,
    'message' => 'Thank you for your interest! Our team will contact you within 24 hours to discuss how you can save up to 100% on processing fees and get up to 100% off new equipment.'
]);

$conn->close();
?>
