# Postmark Setup Guide for Optimum Payments

## Why Postmark?

- ✅ **Excellent deliverability** - Industry-leading inbox placement
- ✅ **Simple pricing** - 100 free emails/month, then $15 for 10,000
- ✅ **Fast delivery** - Average 1-2 second delivery time
- ✅ **Great analytics** - Track opens, clicks, bounces
- ✅ **No daily limits** - Send whenever you need
- ✅ **Best for transactional emails** - Perfect for confirmations, notifications

---

## Step-by-Step Setup

### 1. Create Postmark Account

1. Go to: https://postmarkapp.com/
2. Click "Start Free Trial" (no credit card required)
3. Sign up with your email
4. Verify your email address

---

### 2. Create a Server

1. After logging in, you'll be prompted to create a "Server"
2. Name it: **"Optimum Payments Website"**
3. Click "Create Server"

---

### 3. Get Your Server Token

1. You'll see your **Server API Token** on the dashboard
2. Copy this token (looks like: `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx`)
3. Keep it safe - you'll need it in `email_config.php`

---

### 4. Add and Verify Sender Signature

**IMPORTANT:** You must verify your sender email before sending.

1. Go to **"Sender Signatures"** in the left menu
2. Click **"Add Sender Signature"**
3. Enter: `noreply@optimum-payments.com`
4. Click "Send Verification Email"
5. Check your `noreply@optimum-payments.com` inbox
6. Click the verification link

**Note:** If you don't have access to `noreply@optimum-payments.com`, use an email you control (like `john@optimum-payments.com`) and update your config.

---

### 5. Configure email_config.php

Open `_system/email_config.php` and update with your token:

```php
$email_config = [
    'smtp_host' => 'smtp.postmarkapp.com',
    'smtp_port' => 587,
    'smtp_secure' => 'tls',
    'smtp_username' => 'YOUR_POSTMARK_SERVER_TOKEN', // Paste token here
    'smtp_password' => 'YOUR_POSTMARK_SERVER_TOKEN', // Same token
    'from_email' => 'noreply@optimum-payments.com', // Must match verified sender
    'from_name' => 'Optimum Payments',
    'reply_to' => 'applications@optimum-payments.com'
];
```

**Example:**
```php
$email_config = [
    'smtp_host' => 'smtp.postmarkapp.com',
    'smtp_port' => 587,
    'smtp_secure' => 'tls',
    'smtp_username' => 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
    'smtp_password' => 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
    'from_email' => 'noreply@optimum-payments.com',
    'from_name' => 'Optimum Payments',
    'reply_to' => 'applications@optimum-payments.com'
];
```

---

### 6. Install PHPMailer

Run in PowerShell:
```powershell
cd c:\xampp\htdocs\mywebsite
composer require phpmailer/phpmailer
```

If you don't have Composer, install it from: https://getcomposer.org/download/

---

### 7. Test Your Setup

Create `_system/test_postmark.php`:

```php
<?php
require_once __DIR__ . '/EmailHelper.php';

$emailHelper = new EmailHelper();

// Change to YOUR email for testing
$testEmail = 'your-email@gmail.com';
$subject = 'Test Email from Optimum Payments via Postmark';
$body = "Hello!\n\nThis is a test email sent through Postmark SMTP.\n\nIf you receive this, your email configuration is working perfectly!\n\nBest regards,\nOptimum Payments Team";

if ($emailHelper->send($testEmail, $subject, $body)) {
    echo "✓ Email sent successfully via Postmark!\n";
    echo "Check your inbox (and spam folder) for the test email.";
} else {
    echo "✗ Email failed to send.\n";
    echo "Check:\n";
    echo "1. Your Server Token is correct\n";
    echo "2. Your sender signature is verified\n";
    echo "3. PHPMailer is installed\n";
}
?>
```

Visit: `http://localhost/mywebsite/_system/test_postmark.php`

---

### 8. Check Postmark Dashboard

1. Go to **"Activity"** in Postmark dashboard
2. You should see your test email listed
3. Check delivery status, opens, and any bounces

---

## Pricing (as of 2026)

| Plan | Emails/Month | Price |
|------|--------------|-------|
| Free | 100 | $0 |
| Starter | 10,000 | $15/month |
| Growth | 50,000 | $50/month |
| Scale | 125,000+ | Custom |

**Average for merchant applications:** ~1,000 emails/month = $15/month

---

## Troubleshooting

### "Authentication failed"
- Double-check your Server Token (it's case-sensitive)
- Make sure you copied the entire token
- Token should be the same for both username and password

### "Sender signature not verified"
- Check the inbox of the email you're trying to verify
- Click the verification link in the email
- Wait a few minutes for verification to complete
- Make sure `from_email` in config matches verified sender

### "Email not received"
1. Check Postmark Activity dashboard
2. Look for bounces or errors
3. Check your spam folder
4. Verify recipient email is correct

### Still having issues?
- Postmark has excellent support: https://postmarkapp.com/support
- Check error logs in Postmark dashboard
- Contact Postmark support (usually responds within hours)

---

## Advantages Over Other Providers

| Feature | Postmark | SendGrid | Gmail |
|---------|----------|----------|-------|
| Deliverability | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐ |
| Speed | 1-2 seconds | 2-5 seconds | Variable |
| Free Tier | 100/month | 100/day | 500/day |
| Support | Excellent | Good | Limited |
| Analytics | Detailed | Very detailed | None |
| Best For | Transactional | Marketing + Trans | Personal |

**Verdict:** Postmark is perfect for your merchant application emails!

---

## Next Steps

Once you've completed setup and testing:
1. Let me know and I'll update your PHP files to use EmailHelper
2. Set up email templates in Postmark (optional but recommended)
3. Configure webhooks for bounce tracking (optional)

**Ready to go live? Your emails will be professional and reliable! 🚀**
