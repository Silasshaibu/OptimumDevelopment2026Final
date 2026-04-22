<?php
/**
 * Email Configuration for Production
 * 
 * Choose one of the SMTP providers below and uncomment the relevant section.
 * Install PHPMailer first: composer require phpmailer/phpmailer
 */

// OPTION 1: Gmail SMTP (Free, good for small volume)
// NOTE: You need to enable "App Passwords" in your Google account
$email_config = [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_secure' => 'tls', // or 'ssl' for port 465
    'smtp_username' => 'your-email@gmail.com',
    'smtp_password' => 'your-app-password', // NOT your regular password!
    'from_email' => 'noreply@optimum-payments.com',
    'from_name' => 'Optimum Payments',
    'reply_to' => 'applications@optimum-payments.com'
];

/* OPTION 2: SendGrid (Recommended for production - 100 free emails/day)
$email_config = [
    'smtp_host' => 'smtp.sendgrid.net',
    'smtp_port' => 587,
    'smtp_secure' => 'tls',
    'smtp_username' => 'apikey', // literally the word "apikey"
    'smtp_password' => 'YOUR_SENDGRID_API_KEY',
    'from_email' => 'noreply@optimum-payments.com',
    'from_name' => 'Optimum Payments',
    'reply_to' => 'applications@optimum-payments.com'
];
*/

/* OPTION 3: Mailgun (Good for high volume)
$email_config = [
    'smtp_host' => 'smtp.mailgun.org',
    'smtp_port' => 587,
    'smtp_secure' => 'tls',
    'smtp_username' => 'postmaster@yourdomain.com',
    'smtp_password' => 'YOUR_MAILGUN_PASSWORD',
    'from_email' => 'noreply@optimum-payments.com',
    'from_name' => 'Optimum Payments',
    'reply_to' => 'applications@optimum-payments.com'
];
*/

/* OPTION 4: Postmark (Excellent for transactional emails - Recommended!)
   Free tier: 100 emails/month
   Pricing: $15/month for 10,000 emails
   Known for high deliverability and great support
*/
$email_config = [
    'smtp_host' => 'smtp.postmarkapp.com',
    'smtp_port' => 587,
    'smtp_secure' => 'tls',
    'smtp_username' => 'YOUR_POSTMARK_SERVER_TOKEN',
    'smtp_password' => 'YOUR_POSTMARK_SERVER_TOKEN', // Same as username
    'from_email' => 'noreply@optimum-payments.com',
    'from_name' => 'Optimum Payments',
    'reply_to' => 'applications@optimum-payments.com'
];

/* OPTION 5: cPanel/Hosting Provider SMTP
$email_config = [
    'smtp_host' => 'mail.yourdomain.com',
    'smtp_port' => 587,
    'smtp_secure' => 'tls',
    'smtp_username' => 'noreply@optimum-payments.com',
    'smtp_password' => 'your-email-password',
    'from_email' => 'noreply@optimum-payments.com',
    'from_name' => 'Optimum Payments',
    'reply_to' => 'applications@optimum-payments.com'
];
*/

/* OPTION 5: Office 365 / Outlook
$email_config = [
    'smtp_host' => 'smtp.office365.com',
    'smtp_port' => 587,
    'smtp_secure' => 'tls',
    'smtp_username' => 'your-email@yourdomain.com',
    'smtp_password' => 'your-password',
    'from_email' => 'noreply@optimum-payments.com',
    'from_name' => 'Optimum Payments',
    'reply_to' => 'applications@optimum-payments.com'
];
*/

return $email_config;
?>
