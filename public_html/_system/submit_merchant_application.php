<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/recipients_config.php';

$recipient_emails = get_recipients_for_form('merchant_application');

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
$surname = isset($input['surname']) ? trim($input['surname']) : '';
$first_name = isset($input['first_name']) ? trim($input['first_name']) : '';
$title = isset($input['title']) ? trim($input['title']) : '';
$phone = isset($input['phone']) ? trim($input['phone']) : '';
$company = isset($input['company']) ? trim($input['company']) : '';
$email = isset($input['email']) ? trim($input['email']) : '';
$fax = isset($input['fax']) ? trim($input['fax']) : '';
$address1 = isset($input['address1']) ? trim($input['address1']) : '';
$address2 = isset($input['address2']) ? trim($input['address2']) : '';
$state = isset($input['state']) ? trim($input['state']) : '';
$city = isset($input['city']) ? trim($input['city']) : '';
$zip = isset($input['zip']) ? trim($input['zip']) : '';
$business_type = isset($input['business_type']) ? trim($input['business_type']) : '';
$accept_credit_cards = isset($input['accept_credit_cards']) ? $input['accept_credit_cards'] : '';
$previous_credit_cards = isset($input['previous_credit_cards']) ? $input['previous_credit_cards'] : '';
$monthly_volume = isset($input['monthly_volume']) ? trim($input['monthly_volume']) : '';
$comments = isset($input['comments']) ? trim($input['comments']) : '';

// Validation
$errors = [];

if (empty($surname) || strlen($surname) < 2) {
    $errors[] = 'Please provide your surname';
}

if (empty($first_name) || strlen($first_name) < 2) {
    $errors[] = 'Please provide your first name';
}

if (empty($phone)) {
    $errors[] = 'Please provide your phone number';
}

if (empty($company)) {
    $errors[] = 'Please provide your company name';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address';
}

if (empty($accept_credit_cards)) {
    $errors[] = 'Please indicate if you currently accept credit cards';
}

if (empty($previous_credit_cards)) {
    $errors[] = 'Please indicate if you have previously taken credit cards';
}

if (empty($monthly_volume)) {
    $errors[] = 'Please select your estimated monthly volume';
}

// Return errors if any
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// Generate unique confirmation token
$confirmation_token = bin2hex(random_bytes(32));

// Insert into database with confirmed=0
$stmt = $conn->prepare("
    INSERT INTO merchant_applications (
        surname, first_name, title, phone, company, email, fax,
        address1, address2, state, city, zip,
        business_type, accept_credit_cards, previous_credit_cards,
        monthly_volume, comments, status, confirmed, confirmation_token, created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'new', 0, ?, NOW())
");

$stmt->bind_param(
    "ssssssssssssssssss",
    $surname, $first_name, $title, $phone, $company, $email, $fax,
    $address1, $address2, $state, $city, $zip,
    $business_type, $accept_credit_cards, $previous_credit_cards,
    $monthly_volume, $comments, $confirmation_token
);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to submit application. Please try again later.']);
    exit;
}

$stmt->close();

// Build confirmation link
$site_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$confirmation_link = $site_url . "/_system/confirm_merchant_application.php?token=" . urlencode($confirmation_token);

// Send confirmation request email to applicant
$applicant_subject = "We Received Your Submission";
$applicant_body = "
Dear {$first_name} {$surname},

Thank you for your interest in Optimum Payments!

To complete your merchant application, please confirm your email address by clicking the link below:

{$confirmation_link}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
IMPORTANT:
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

• This link will expire in 1 hour
• If you didn't submit this application, simply ignore this email - it will be automatically deleted
• For security, please don't share this link with anyone

Once confirmed, you'll receive a detailed confirmation email and our team will review your application within 24-48 hours.

Best regards,
Optimum Payments Team
(800) 770-5520
info@optimum-payments.com
";

$applicant_headers = "From: Optimum Payments <noreply@optimum-payments.com>\r\n";
$applicant_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send confirmation request email to applicant (suppress errors for now)
send_notification_email($email, $applicant_subject, $applicant_body, $applicant_headers);

// Always return success since data is saved (email delivery is secondary)
echo json_encode([
    'success' => true,
    'message' => 'Thank you! Your application has been submitted. Please check your email to confirm (also check spam folder).'
]);

$conn->close();
?>
