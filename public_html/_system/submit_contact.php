<?php
/**
 * Contact Form Submission Handler
 * Processes contact form submissions with spam protection and email notifications
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/recipients_config.php';

$recipient_emails = get_recipients_for_form('contact');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Accept both JSON payloads and standard form posts
$raw_input = file_get_contents('php://input');
$json_input = json_decode($raw_input, true);
$input = (is_array($json_input) && !empty($json_input)) ? $json_input : $_POST;

// Get form data
$firstName = isset($input['firstName']) ? trim($input['firstName']) : '';
$lastName = isset($input['lastName']) ? trim($input['lastName']) : '';
$email = isset($input['email']) ? trim($input['email']) : '';
$phone = isset($input['yourphone']) ? trim($input['yourphone']) : '';
$company = isset($input['company']) ? trim($input['company']) : '';
$source = isset($input['howDidYouHearAboutUs']) ? trim($input['howDidYouHearAboutUs']) : '';
$message = isset($input['comments']) ? trim($input['comments']) : '';
$policyChecked = filter_var($input['submitFormPolicyChecked'] ?? false, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
$policyChecked = ($policyChecked === null) ? isset($input['submitFormPolicyChecked']) : $policyChecked;
$honeypot = isset($input['website']) ? trim($input['website']) : '';

// Honeypot spam check
if (!empty($honeypot)) {
    // Pretend success to fool bots
    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
    exit;
}

// Validation
$errors = [];

if (empty($firstName) || strlen($firstName) < 2) {
    $errors[] = 'First name is required (minimum 2 characters)';
}

if (empty($lastName) || strlen($lastName) < 2) {
    $errors[] = 'Last name is required (minimum 2 characters)';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Valid email address is required';
}

if (!empty($phone)) {
    // Validate phone format (+1 followed by 10 digits)
    $phoneDigits = preg_replace('/\D/', '', substr($phone, 2)); // Remove +1 prefix and non-digits
    if (strlen($phoneDigits) !== 10) {
        $errors[] = 'Phone number must be exactly 10 digits';
    }
}

if (empty($source)) {
    $errors[] = 'Please select how you heard about us';
}

if (empty($message) || strlen($message) < 10) {
    $errors[] = 'Message is required (minimum 10 characters)';
}

if (!$policyChecked) {
    $errors[] = 'You must acknowledge the privacy policy';
}

// Return validation errors
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

// Get client IP address
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
}

// Check for duplicate submission (same email within last hour)
$checkStmt = $conn->prepare("SELECT id FROM contact_messages WHERE email = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'You have already submitted a message recently. Please wait before submitting another.']);
    $checkStmt->close();
    $conn->close();
    exit;
}
$checkStmt->close();

// Insert into database
$stmt = $conn->prepare("
    INSERT INTO contact_messages (
        first_name, 
        last_name, 
        email, 
        phone, 
        company, 
        source, 
        message, 
        status, 
        ip_address,
        created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, 'new', ?, NOW())
");

$stmt->bind_param(
    "ssssssss",
    $firstName,
    $lastName,
    $email,
    $phone,
    $company,
    $source,
    $message,
    $ipAddress
);

if ($stmt->execute()) {
    $messageId = $conn->insert_id;
    
    // Send email notification to admin
    $subject = "New Submission – Contact Us";
    $emailBody = "Form Name: Contact Us
Submitted On: " . date('F j, Y \a\t g:i A') . "

---

Contact Information:
Name: {$firstName} {$lastName}
Email: {$email}
Phone: " . ($phone ?: 'Not provided') . "

---

Submission Details:
Company: " . ($company ?: 'Not provided') . "
How Did You Hear About Us: " . ucfirst($source) . "
Message: {$message}
IP Address: {$ipAddress}

---

Notes:
* This submission was sent via the website.
* Reply directly from info@optimum-payments.com to respond.
";

    $headers = "From: info@optimum-payments.com\r\n";
    $headers .= "Reply-To: info@optimum-payments.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send to all recipients
    foreach ($recipient_emails as $adminEmail) {
        send_notification_email($adminEmail, $subject, $emailBody, $headers);
    }

    // Send confirmation email to user
    $user_confirm_subject = 'Thanks for Contacting Us';
    $user_confirm_body = "Hi {$firstName},\n\nThanks for reaching out to Optimum Payments.\n\nWe've received your message and will get back to you as soon as possible.\n\nExpected response time: within 24 hours\n\nBest regards,\nOptimum Payments Team";
    send_user_confirmation_email($email, $user_confirm_subject, $user_confirm_body);

    echo json_encode([
        'success' => true,
        'message' => 'Thank you for contacting us! We will get back to you shortly.',
        'id' => $messageId
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while submitting your message. Please try again.'
    ]);
}

$stmt->close();
$conn->close();
?>
