<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/recipients_config.php';

$recipient_emails = get_recipients_for_form('digital_brief');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Accept both JSON payloads and standard form posts (FormData/multipart)
$raw_input = file_get_contents('php://input');
$json_input = json_decode($raw_input, true);

if (is_array($json_input) && !empty($json_input)) {
    $request_data = $json_input;
} else {
    $request_data = $_POST;
}

// Extract and sanitize form data
$name = isset($request_data['name']) ? trim($request_data['name']) : '';
$email = isset($request_data['email']) ? trim($request_data['email']) : '';
$phone = isset($request_data['phone']) ? trim($request_data['phone']) : '';
$website = isset($request_data['website']) ? trim($request_data['website']) : '';
$budget_min = isset($request_data['budget_min']) ? intval($request_data['budget_min']) : 0;
$budget_max = isset($request_data['budget_max']) ? intval($request_data['budget_max']) : 0;
$referral_source = isset($request_data['referral_source']) ? trim($request_data['referral_source']) : '';
$comments = isset($request_data['comments']) ? trim($request_data['comments']) : '';

// Services can arrive as an array, a JSON string, or a single value
$services = [];
if (isset($request_data['services']) && is_array($request_data['services'])) {
    $services = $request_data['services'];
} elseif (isset($request_data['services']) && is_string($request_data['services'])) {
    $decoded_services = json_decode($request_data['services'], true);
    if (is_array($decoded_services)) {
        $services = $decoded_services;
    } elseif (trim($request_data['services']) !== '') {
        $services = [trim($request_data['services'])];
    }
}

// Validation
$errors = [];
$max_upload_files = 5;
$max_file_size_bytes = 4 * 1024 * 1024; // 4MB

if (empty($name) || strlen($name) < 2) {
    $errors[] = 'Please provide your name';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address';
}

if (!empty($phone) && !preg_match('/^[\d\s\+\-\(\)]+$/', $phone)) {
    $errors[] = 'Please provide a valid phone number';
}

if (!empty($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
    $errors[] = 'Please provide a valid website URL';
}

if (empty($services)) {
    $errors[] = 'Please select at least one service';
}

if (empty($referral_source)) {
    $errors[] = 'Please tell us how you heard about us';
}

if (isset($_FILES['brief_files']) && is_array($_FILES['brief_files']['name'])) {
    $file_count = count($_FILES['brief_files']['name']);

    if ($file_count > $max_upload_files) {
        $errors[] = 'You can only upload up to 5 files per brief submission';
    }

    for ($i = 0; $i < $file_count; $i++) {
        $file_error = $_FILES['brief_files']['error'][$i] ?? UPLOAD_ERR_NO_FILE;
        if ($file_error === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        if ($file_error !== UPLOAD_ERR_OK) {
            $errors[] = 'One or more files failed to upload. Please try again.';
            break;
        }

        $file_size = isset($_FILES['brief_files']['size'][$i]) ? (int) $_FILES['brief_files']['size'][$i] : 0;
        if ($file_size > $max_file_size_bytes) {
            $file_name = basename((string) ($_FILES['brief_files']['name'][$i] ?? 'A file'));
            $errors[] = $file_name . ' exceeds 4MB limit';
        }
    }
}

// Return errors if any
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// Convert services array to JSON
$services_json = json_encode($services);

// Collect uploaded file metadata from multipart submissions
$uploaded_files = [];
if (isset($_FILES['brief_files']) && is_array($_FILES['brief_files']['name'])) {
    $file_count = count($_FILES['brief_files']['name']);
    for ($i = 0; $i < $file_count; $i++) {
        if (!isset($_FILES['brief_files']['error'][$i]) || $_FILES['brief_files']['error'][$i] !== UPLOAD_ERR_OK) {
            continue;
        }
        $file_name = basename((string) $_FILES['brief_files']['name'][$i]);
        $file_name = str_replace(["\r", "\n", "\t"], ' ', $file_name);
        $file_size = isset($_FILES['brief_files']['size'][$i]) ? (int) $_FILES['brief_files']['size'][$i] : 0;
        $uploaded_files[] = $file_name . ' (' . number_format($file_size / 1024, 1) . ' KB)';
    }
}

// Insert into database
$stmt = $conn->prepare("
    INSERT INTO digital_briefs (
        name, email, phone, website, 
        budget_min, budget_max, 
        referral_source, services, comments, 
        status, created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'new', NOW())
");

$stmt->bind_param(
    "ssssiisss",
    $name, $email, $phone, $website,
    $budget_min, $budget_max,
    $referral_source, $services_json, $comments
);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to submit request. Please try again later.']);
    exit;
}

$stmt->close();

// Send email notification
$service_names = [
    'website_design_development' => 'Website Design + Development',
    'app_design_development' => 'App Design + Development',
    'copywriting' => 'Copywriting',
    'packaging_design' => 'Packaging Design',
    'branding' => 'Branding'
];

$service_list = '';
foreach ($services as $service) {
    $service_name = $service_names[$service] ?? $service;
    $service_list .= "• " . $service_name . "\n";
}

$email_subject = "New Submission – Digital Services Brief";
$email_body = "Form Name: Digital Services Brief
Submitted On: " . date('F j, Y \a\t g:i A') . "

---

Contact Information:
Name: {$name}
Email: {$email}
Phone: " . ($phone ?: 'Not provided') . "

---

Submission Details:
Website: " . ($website ?: 'Not provided') . "
Budget Range: \${$budget_min} – \${$budget_max}
How Did You Hear About Us: {$referral_source}
Services Requested:
{$service_list}
Additional Comments: " . ($comments ?: 'None') . "
Attached Files: " . (!empty($uploaded_files) ? "\n- " . implode("\n- ", $uploaded_files) : 'None') . "

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
$user_confirm_subject = 'Your Project Brief Has Been Received';
$user_confirm_body = "Hi {$name},\n\nThanks for submitting your project brief-we're excited to learn more about your vision.\n\nOur team (including Silas) will review your submission and follow up with next steps, questions, or a proposal if applicable.\n\nExpected response time: 1-2 business days\n\nWe look forward to working with you.\n\nBest regards,\nOptimum Payments Team";
send_user_confirmation_email($email, $user_confirm_subject, $user_confirm_body);

// Return success
echo json_encode([
    'success' => true,
    'message' => 'Thank you for your inquiry! Our team will review your request and contact you within 24 hours.'
]);

$conn->close();
?>
