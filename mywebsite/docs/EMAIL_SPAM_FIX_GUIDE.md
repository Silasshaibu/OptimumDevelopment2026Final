# Email Spam Fix Guide — Optimum Payments

Follow these steps **in order**. Each step builds on the previous one.

---

## STEP 1 — Enable DKIM on SiteGround (5 minutes, free)

DKIM adds a cryptographic signature to every outgoing email, proving it came from your domain.

1. Log in to your SiteGround account at **my.siteground.com**
2. Go to **Websites** → click **Site Tools** for your domain
3. Go to **Email** → **Authentication**
4. You will see **DKIM** and **SPF** toggles — enable both
5. Click **Confirm**

> SiteGround automatically generates and applies the correct DNS records. No manual DNS editing needed for SPF and DKIM.

---

## STEP 2 — Add a DMARC DNS Record (5 minutes, free)

DMARC tells mail providers what to do if SPF or DKIM checks fail.

1. In SiteGround Site Tools go to **Domain** → **DNS Zone Editor**
2. Click **Add Record**
3. Fill in:
   - **Type:** `TXT`
   - **Name:** `_dmarc`
   - **Value:** `v=DMARC1; p=none; rua=mailto:silas@optimum-payments.com`
   - **TTL:** `3600`
4. Save the record

> `p=none` means monitor-only for now (no emails blocked). Once you confirm emails are delivering correctly, you can tighten it to `p=quarantine` then `p=reject`.

---

## STEP 3 — Create a Dedicated Sending Mailbox on SiteGround

You need a real mailbox to send authenticated SMTP mail from.

1. In SiteGround Site Tools go to **Email** → **Email Accounts**
2. Click **Create Email Account**
3. Create: `noreply@optimum-payments.com`
4. Set a strong password and save it somewhere safe
5. Click the settings icon on the new account → **Mail Configuration**
6. Note down these values — you will need them in Step 4:
   - **SMTP Server** (looks like `mail.optimum-payments.com`)
   - **SMTP Port:** `587` (TLS) or `465` (SSL)
   - **Username:** `noreply@optimum-payments.com`
   - **Password:** the one you just set

---

## STEP 4 — Install PHPMailer via Composer

PHPMailer is the library that sends emails through SMTP instead of PHP's built-in `mail()`.

1. SSH into your SiteGround server, or open the **Terminal** in SiteGround Site Tools under **Devs → SSH**
2. Navigate to your website root:
   ```bash
   cd ~/public_html
   ```
   *(adjust path if your site is in a subfolder)*
3. Run:
   ```bash
   composer require phpmailer/phpmailer
   ```
4. Confirm a `vendor/phpmailer/phpmailer/` folder now exists

> If Composer is not installed, SiteGround Site Tools has a **PHP Manager** — check there, or install Composer with:
> ```bash
> curl -sS https://getcomposer.org/installer | php
> php composer.phar require phpmailer/phpmailer
> ```

---

## STEP 5 — Update `_system/email_config.php`

Open `_system/email_config.php` and **replace the entire file contents** with this — filling in your real values from Step 3:

```php
<?php
/**
 * Email Configuration — SiteGround SMTP
 * Edit SMTP credentials here. All form handlers use this automatically.
 */

$email_config = [
    'smtp_host'     => 'mail.optimum-payments.com',   // From Step 3
    'smtp_port'     => 587,                            // 587 for TLS, 465 for SSL
    'smtp_secure'   => 'tls',                          // 'tls' for 587, 'ssl' for 465
    'smtp_username' => 'noreply@optimum-payments.com', // Full email address
    'smtp_password' => 'YOUR_MAILBOX_PASSWORD',        // Password from Step 3
    'from_email'    => 'noreply@optimum-payments.com',
    'from_name'     => 'Optimum Payments',
    'reply_to'      => 'info@optimum-payments.com',
];

return $email_config;
```

> **Never commit this file to Git.** Make sure `_system/email_config.php` is in your `.gitignore`.

---

## STEP 6 — Switch All Form Handlers from `mail()` to SMTP

Once PHPMailer is installed and `email_config.php` is filled in, ask your developer (or Copilot) to:

> "Migrate all six submit handlers from `mail()` to the `EmailHelper` SMTP class"

The `EmailHelper` class is already written and ready at `_system/EmailHelper.php`. The six files that need updating are:

- `_system/submit_contact.php`
- `_system/submit_merchant_application.php`
- `_system/submit_digital_brief.php`
- `_system/submit_business_owner.php`
- `_system/submit_business_referral.php`
- `_system/submit_review.php`

---

## STEP 7 — Test Email Delivery

Create a temporary test file on your server to confirm SMTP is working:

1. Create `_system/test_email.php` with this content:

```php
<?php
require_once __DIR__ . '/EmailHelper.php';

$emailHelper = new EmailHelper();
$result = $emailHelper->send(
    'silas@optimum-payments.com',
    'SMTP Test — Optimum Payments',
    'If you see this, SMTP is working correctly.'
);

echo $result ? '✓ Email sent successfully!' : '✗ Email failed — check email_config.php';
```

2. Visit: `https://optimum-payments.com/_system/test_email.php`
3. Check your inbox
4. **Delete `test_email.php` immediately after testing** — never leave test endpoints publicly accessible

---

## STEP 8 — Verify DNS Records Propagated

Use a free DNS checker to confirm SPF, DKIM, and DMARC are active:

1. Go to **mxtoolbox.com/SuperTool.aspx**
2. Run these three checks:
   - **SPF Lookup:** `optimum-payments.com`
   - **DKIM Lookup:** enter selector `default._domainkey.optimum-payments.com` (SiteGround's default selector — confirm in Site Tools if needed)
   - **DMARC Lookup:** `_dmarc.optimum-payments.com`
3. All three should return green results

> DNS changes can take up to 24 hours to propagate globally, but SiteGround usually applies them within minutes.

---

## STEP 9 — Tighten DMARC Policy (After 1 Week)

Once you have confirmed emails are delivering correctly for 7+ days:

1. Go back to **DNS Zone Editor** in SiteGround
2. Update the DMARC TXT record value from:
   ```
   v=DMARC1; p=none; rua=mailto:silas@optimum-payments.com
   ```
   to:
   ```
   v=DMARC1; p=quarantine; rua=mailto:silas@optimum-payments.com
   ```
3. After another week with no issues, change `p=quarantine` to `p=reject` for maximum protection

---

## Summary Checklist

| Step | Task | Time |
|------|------|------|
| 1 | Enable DKIM + SPF in SiteGround Email Authentication | 5 min |
| 2 | Add DMARC DNS TXT record | 5 min |
| 3 | Create `noreply@optimum-payments.com` mailbox | 5 min |
| 4 | Install PHPMailer via Composer on server | 5 min |
| 5 | Fill in `_system/email_config.php` with SMTP credentials | 2 min |
| 6 | Migrate form handlers from `mail()` to EmailHelper | Dev task |
| 7 | Test via `test_email.php`, then delete it | 5 min |
| 8 | Verify DNS records at mxtoolbox.com | 5 min |
| 9 | Tighten DMARC to `p=reject` after 1 week | 2 min |

---

## Why Emails Were Going to Spam — Quick Reference

| Cause | Impact | Fixed By |
|-------|--------|----------|
| Using `mail()` with no auth | Very high | Steps 4–6 |
| No SPF record | High | Step 1 |
| No DKIM signature | High | Step 1 |
| No DMARC policy | Medium | Step 2 |
| `From:` domain not verified | High | Steps 1 + 5 |
