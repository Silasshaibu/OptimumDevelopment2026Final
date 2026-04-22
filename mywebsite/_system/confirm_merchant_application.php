<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/recipients_config.php';

// Get token from URL
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($token)) {
    http_response_code(400);
    die('Invalid confirmation link.');
}

// Find the application by token
$stmt = $conn->prepare("SELECT * FROM merchant_applications WHERE confirmation_token = ? AND confirmed = 0");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    die('This confirmation link is invalid or has already been used.');
}

$application = $result->fetch_assoc();
$stmt->close();

// Check if application is older than 1 hour
$created_at = strtotime($application['created_at']);
$current_time = time();
$time_diff = ($current_time - $created_at) / 60; // in minutes

if ($time_diff > 60) {
    // Delete expired application
    $delete_stmt = $conn->prepare("DELETE FROM merchant_applications WHERE id = ?");
    $delete_stmt->bind_param("i", $application['id']);
    $delete_stmt->execute();
    $delete_stmt->close();
    
    http_response_code(410);
    die('This confirmation link has expired. Please submit your application again.');
}

// Update application to confirmed
$update_stmt = $conn->prepare("UPDATE merchant_applications SET confirmed = 1, confirmation_token = NULL WHERE id = ?");
$update_stmt->bind_param("i", $application['id']);
$update_stmt->execute();
$update_stmt->close();

// Prepare data for emails
$full_name = $application['first_name'] . ' ' . $application['surname'];
$full_address = $application['address1'];
if ($application['address2']) $full_address .= ', ' . $application['address2'];
if ($application['city']) $full_address .= ', ' . $application['city'];
if ($application['state']) $full_address .= ', ' . $application['state'];
if ($application['zip']) $full_address .= ' ' . $application['zip'];

// Send confirmation email to applicant
$applicant_subject = "Your Merchant Application is Under Review";
$applicant_body = "Hi {$application['first_name']},

Thank you for applying with Optimum Payments.

Your merchant application has been received and is currently under review. A member of our team will reach out shortly to guide you through the next steps.

Expected response time: 1 business day

We look forward to helping your business grow.

Best regards,
Optimum Payments Team";

$applicant_headers = "From: Optimum Payments <noreply@optimum-payments.com>\r\n";
$applicant_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send confirmation email to applicant
send_user_confirmation_email($application['email'], $applicant_subject, $applicant_body);

// Send notification to team
$team_subject = "New Submission – Merchant Application (Confirmed)";
$team_body = "Form Name: Merchant Application
Submitted On: " . date('F j, Y \a\t g:i A', $created_at) . "
Confirmed On: " . date('F j, Y \a\t g:i A') . "

---

Contact Information:
Name: {$full_name}" . ($application['title'] ? " ({$application['title']})" : "") . "
Email: {$application['email']}
Phone: {$application['phone']}

---

Submission Details:
Company: {$application['company']}
Fax: " . ($application['fax'] ?: 'Not provided') . "
Address: " . ($full_address ?: 'Not provided') . "
Business Type: " . ($application['business_type'] ?: 'Not specified') . "
Currently Accepts Credit Cards: " . strtoupper($application['accept_credit_cards']) . "
Previously Taken Credit Cards: " . strtoupper($application['previous_credit_cards']) . "
Estimated Monthly Volume: {$application['monthly_volume']}
Additional Comments: " . ($application['comments'] ?: 'None') . "

---

Notes:
* This submission was sent via the website.
* Reply directly from info@optimum-payments.com to respond.
";

$team_headers = "From: info@optimum-payments.com\r\n";
$team_headers .= "Reply-To: info@optimum-payments.com\r\n";
$team_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send to team recipients
foreach (get_recipients_for_form('merchant_application') as $recipient) {
    send_notification_email($recipient, $team_subject, $team_body, $team_headers);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Confirmed - Optimum Payments</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 600px;
            text-align: center;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: #10B981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .success-icon svg {
            width: 50px;
            height: 50px;
            stroke: white;
            stroke-width: 3;
            fill: none;
        }
        h1 {
            color: #1F2937;
            margin: 0 0 16px;
            font-size: 1.75rem;
        }
        p {
            color: #6B7280;
            line-height: 1.6;
            margin: 0 0 24px;
        }
        .details {
            background: #F9FAFB;
            border-radius: 8px;
            padding: 20px;
            margin: 24px 0;
            text-align: left;
        }
        .details h3 {
            color: #374151;
            margin: 0 0 12px;
            font-size: 1rem;
        }
        .details p {
            margin: 8px 0;
            font-size: 0.875rem;
        }
        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 32px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5568d3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">
            <svg viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        <h1>Application Confirmed!</h1>
        <p>Thank you for confirming your merchant application, <?= htmlspecialchars($application['first_name']) ?>.</p>
        
        <div class="details">
            <h3>What happens next?</h3>
            <p>✓ You'll receive a detailed confirmation email at <strong><?= htmlspecialchars($application['email']) ?></strong></p>
            <p>✓ Our team will review your application within 24-48 hours</p>
            <p>✓ We'll contact you to discuss the next steps</p>
        </div>
        
        <p>If you have any questions, feel free to contact us at<br><strong>(800) 770-5520</strong> or <strong>applications@optimum-payments.com</strong></p>
        
        <a href="/" class="btn">Return to Homepage</a>
    </div>
</body>
</html>
