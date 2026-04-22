<?php
/**
 * Email Recipients Configuration — Single Source of Truth
 *
 * Edit ONLY this file to change who receives form submission notifications.
 * Every submit handler loads from here automatically.
 */

// Toggle this to switch the secondary operations recipient in one place.
// false = silasshaibu30bg@gmail.com (current)
// true  = paul@optimum-payments.com (future)
$use_paul_email = false;

$ops_secondary_email = $use_paul_email
    ? 'paul@optimum-payments.com'
    : 'silasshaibu30bg@gmail.com';

$email_recipients = [

    // Digital Services Brief form (digital-services-brief-submit page)
    'digital_brief' => [
        'info@optimum-payments.com',
        'silas@optimum-payments.com',
    ],

    // Business Owner inquiry form (promo page — Tab 2)
    'business_owner' => [        
        'info@optimum-payments.com',
    ],

    // Business Referral form (promo page — Tab 1)
    'business_referral' => [
        'info@optimum-payments.com',
    ],

    // Merchant Application form
    'merchant_application' => [
        'info@optimum-payments.com',
        $ops_secondary_email,
    ],

    // Customer Review submissions
    'review' => [
        'info@optimum-payments.com',
    ],

    // Contact Us form
    'contact' => [
        'info@optimum-payments.com',
    ],

    // Fallback for unknown form types
    'fallback' => [
        'info@optimum-payments.com',
    ],

];

/**
 * Resolve recipients for a form key, with fallback routing.
 */
function get_recipients_for_form(string $form_key): array {
    global $email_recipients;
    if (isset($email_recipients[$form_key]) && is_array($email_recipients[$form_key]) && !empty($email_recipients[$form_key])) {
        return $email_recipients[$form_key];
    }
    return $email_recipients['fallback'] ?? ['info@optimum-payments.com'];
}

/**
 * Send an email notification with up to 3 retry attempts.
 * On final failure, alerts the configured operations secondary email.
 */
function send_notification_email(string $to, string $subject, string $body, string $headers): bool {
    global $ops_secondary_email;

    for ($attempt = 1; $attempt <= 3; $attempt++) {
        if (@mail($to, $subject, $body, $headers)) {
            return true;
        }
        if ($attempt < 3) {
            usleep(200000); // 200ms pause between retries
        }
    }
    // All attempts failed — alert error contact
    $error_subject = '[ALERT] Email delivery failed: ' . $subject;
    $error_body    = "Failed to deliver email after 3 attempts.\n\nTo: {$to}\nSubject: {$subject}\nTime: " . date('Y-m-d H:i:s');
    @mail(
        $ops_secondary_email,
        $error_subject,
        $error_body,
        "From: info@optimum-payments.com\r\nContent-Type: text/plain; charset=UTF-8\r\n"
    );
    return false;
}

/**
 * Send user confirmation from no-reply with retry logic.
 */
function send_user_confirmation_email(string $to, string $subject, string $body): bool {
    $headers = "From: Optimum Payments <noreply@optimum-payments.com>\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    return send_notification_email($to, $subject, $body, $headers);
}
