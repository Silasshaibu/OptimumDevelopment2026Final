# Production Email Setup Guide

## Step 1: Install PHPMailer

### Option A: Using Composer (Recommended)
```bash
cd c:\xampp\htdocs\mywebsite
composer require phpmailer/phpmailer
```

### Option B: Manual Installation
1. Download PHPMailer from: https://github.com/PHPMailer/PHPMailer/releases
2. Extract to: `c:\xampp\htdocs\mywebsite\vendor\phpmailer\phpmailer\`

---

## Step 2: Choose Your Email Provider

### OPTION 1: Gmail SMTP (Quick Setup)

**Pros:** Free, easy to set up
**Cons:** Daily limit (500 emails), not ideal for business

**Setup:**
1. Go to your Google Account: https://myaccount.google.com/security
2. Enable 2-Step Verification
3. Go to App Passwords: https://myaccount.google.com/apppasswords
4. Select "Mail" and "Other" (name it "Optimum Payments")
5. Copy the 16-character password

**Configure in `email_config.php`:**
```php
$email_config = [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_secure' => 'tls',
    'smtp_username' => 'your-email@gmail.com',
    'smtp_password' => 'your-16-char-app-password',
    'from_email' => 'noreply@optimum-payments.com',
    'from_name' => 'Optimum Payments',
    'reply_to' => 'applications@optimum-payments.com'
];
```

---

### OPTION 2: SendGrid (Recommended for Production)

**Pros:** 100 free emails/day, professional, reliable
**Cons:** Requires account setup

**Setup:**
1. Sign up: https://sendgrid.com/
2. Verify your email
3. Create API Key:
   - Go to Settings > API Keys
   - Click "Create API Key"
   - Name: "Optimum Payments Website"
   - Select "Full Access"
   - Copy the API key (you'll only see it once!)

**Configure in `email_config.php`:**
```php
$email_config = [
    'smtp_host' => 'smtp.sendgrid.net',
    'smtp_port' => 587,
    'smtp_secure' => 'tls',
    'smtp_username' => 'apikey',
    'smtp_password' => 'SG.xxxxxxxxxxxxxxxxxxxxxxxx', // Your API key
    'from_email' => 'noreply@optimum-payments.com',
    'from_name' => 'Optimum Payments',
    'reply_to' => 'applications@optimum-payments.com'
];
```

**Verify Sender Identity (Important!):**
1. Go to Settings > Sender Authentication
2. Verify a single sender: noreply@optimum-payments.com
3. Check your email and click verification link

---

### OPTION 3: Your Hosting Provider (cPanel)

**Pros:** Already included with hosting
**Cons:** May have rate limits

**Setup:**
1. Log into cPanel
2. Go to Email Accounts
3. Find your SMTP settings (usually in "Configure Email Client")

**Configure in `email_config.php`:**
```php
$email_config = [
    'smtp_host' => 'mail.optimum-payments.com', // or smtp.yourdomain.com
    'smtp_port' => 587,
    'smtp_secure' => 'tls',
    'smtp_username' => 'noreply@optimum-payments.com',
    'smtp_password' => 'your-email-password',
    'from_email' => 'noreply@optimum-payments.com',
    'from_name' => 'Optimum Payments',
    'reply_to' => 'applications@optimum-payments.com'
];
```

---

## Step 3: Update Your PHP Files

Replace the old `mail()` function with EmailHelper.

**Example update for `submit_merchant_application.php`:**

```php
// OLD CODE (remove this):
// mail($email, $applicant_subject, $applicant_body, $applicant_headers);

// NEW CODE (add this):
require_once __DIR__ . '/EmailHelper.php';
$emailHelper = new EmailHelper();
$emailHelper->send($email, $applicant_subject, $applicant_body);
```

---

## Step 4: Test Your Setup

Create `_system/test_email.php`:

```php
<?php
require_once __DIR__ . '/EmailHelper.php';

$emailHelper = new EmailHelper();

$testEmail = 'your-test-email@gmail.com'; // Change this!
$subject = 'Test Email from Optimum Payments';
$body = 'This is a test email. If you receive this, your email setup is working!';

if ($emailHelper->send($testEmail, $subject, $body)) {
    echo "✓ Email sent successfully! Check your inbox.";
} else {
    echo "✗ Email failed to send. Check your email_config.php settings.";
}
?>
```

Visit: `http://localhost/mywebsite/_system/test_email.php`

---

## Step 5: Security Best Practices

### Protect Your Credentials

**Add to `.gitignore`:**
```
_system/email_config.php
vendor/
```

**Use Environment Variables (Production):**
Instead of hardcoding credentials in `email_config.php`, use:

```php
$email_config = [
    'smtp_host' => getenv('SMTP_HOST'),
    'smtp_port' => getenv('SMTP_PORT'),
    'smtp_secure' => getenv('SMTP_SECURE'),
    'smtp_username' => getenv('SMTP_USERNAME'),
    'smtp_password' => getenv('SMTP_PASSWORD'),
    // ...
];
```

Set environment variables in your hosting control panel.

---

## Troubleshooting

### "SMTP connect() failed"
- Check your username/password
- Verify SMTP host and port
- Check firewall settings
- Try port 465 with SSL instead of 587 with TLS

### "Sender address rejected"
- Verify sender identity with your email provider
- Make sure from_email matches your account

### "Connection timed out"
- Your hosting might block outbound SMTP
- Contact your hosting provider
- Try a different SMTP provider

### Emails go to spam
- Verify your domain with SPF, DKIM, DMARC records
- Use a verified sender identity
- Avoid spam trigger words in subject/body

---

## Recommended for Production

**Best choice: SendGrid**
- Free tier: 100 emails/day
- Professional delivery
- Email analytics
- No daily limits on paid plans ($15/month for 40k emails)

**Setup time: 10 minutes**

---

## Need Help?

After choosing your provider, I can update your actual PHP files to use the EmailHelper class.
