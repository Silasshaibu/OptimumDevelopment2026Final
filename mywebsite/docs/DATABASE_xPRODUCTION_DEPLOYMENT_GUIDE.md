## 🚀 PRODUCTION DATABASE DEPLOYMENT GUIDE

---

## 📋 OVERVIEW

This guide walks you through preparing your database for production deployment. Your site uses **8 critical tables** in the `optimumpayments_db` database.

---

## 🗄️ DATABASE & TABLES REQUIRED

**Database Name:** `optimumpayments_db`

**Total Tables:** 8 (all required for full functionality)

| # | Table Name | Purpose | Status |
|---|---|---|---|
| 1 | `users` | Admin/User authentication | ✅ CREATE SCRIPT PROVIDED |
| 2 | `products` | E-commerce products | ✅ CREATE SCRIPT PROVIDED |
| 3 | `reviews` | Customer reviews | ✅ CREATE SCRIPT PROVIDED |
| 4 | `contact_messages` | Contact form submissions | ✅ CREATE SCRIPT PROVIDED |
| 5 | `merchant_applications` | Payment processor applications | ✅ CREATE SCRIPT PROVIDED |
| 6 | `digital_briefs` | Digital services requests | ✅ CREATE SCRIPT PROVIDED |
| 7 | `business_referrals` | Business referral program | ✅ CREATE SCRIPT PROVIDED |
| 8 | `business_owners` | Business owner inquiries | ✅ CREATE SCRIPT PROVIDED |

---

## 📁 SQL FILE LOCATION

```
c:\xampp\htdocs\mywebsite\_system\create_all_tables.sql
```

This file contains all 8 CREATE TABLE statements.

---

## ⚡ QUICK DEPLOYMENT (3 STEPS)

### Step 1: Backup Current Database

```bash
# This backs up your current data before creating new tables
mysqldump -u root -p optimumpayments_db > backup_current.sql
```

**What this does:**
- Exports all your existing data
- Creates a restore point if needed
- File saved as `backup_current.sql`

### Step 2: Run CREATE TABLE Scripts

**Option A: Using phpMyAdmin (Easy)**

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Select database: `optimumpayments_db`
3. Click **SQL** tab
4. Copy contents of `_system/create_all_tables.sql`
5. Paste into SQL editor
6. Click **Go** button
7. Wait for confirmation

**Option B: Using Command Line (Faster)**

```bash
cd c:\xampp\htdocs\mywebsite\_system
mysql -u root -p optimumpayments_db < create_all_tables.sql
```

**What this does:**
- Creates all 8 tables with proper structure
- Sets up indexes for performance
- Configures foreign key relationships
- Sets default values and constraints

### Step 3: Verify Tables Created

```bash
# Connect to database and list all tables
mysql -u root -p optimumpayments_db
```

Then in MySQL:

```sql
-- Show all tables
SHOW TABLES;

-- Should display 8 tables:
-- business_owners
-- business_referrals
-- contact_messages
-- digital_briefs
-- merchant_applications
-- products
-- reviews
-- users
```

Expected output:
```
+----------------------------+
| Tables_in_optimumpayments_db |
+----------------------------+
| business_owners            |
| business_referrals         |
| contact_messages           |
| digital_briefs             |
| merchant_applications      |
| products                   |
| reviews                    |
| users                      |
+----------------------------+
8 rows in set
```

---

## 🔍 TABLE VERIFICATION CHECKLIST

After creating tables, verify each table's structure:

```sql
-- Check table structure for each table
DESCRIBE users;
DESCRIBE products;
DESCRIBE reviews;
DESCRIBE contact_messages;
DESCRIBE merchant_applications;
DESCRIBE digital_briefs;
DESCRIBE business_referrals;
DESCRIBE business_owners;

-- Count rows in each table
SELECT 'users' as table_name, COUNT(*) as row_count FROM users
UNION ALL
SELECT 'products', COUNT(*) FROM products
UNION ALL
SELECT 'reviews', COUNT(*) FROM reviews
UNION ALL
SELECT 'contact_messages', COUNT(*) FROM contact_messages
UNION ALL
SELECT 'merchant_applications', COUNT(*) FROM merchant_applications
UNION ALL
SELECT 'digital_briefs', COUNT(*) FROM digital_briefs
UNION ALL
SELECT 'business_referrals', COUNT(*) FROM business_referrals
UNION ALL
SELECT 'business_owners', COUNT(*) FROM business_owners;
```

---

## 📊 TABLE DESCRIPTIONS

### 1. **users** - Admin & User Accounts
**Purpose:** Store login credentials for admin panel access
**Key Fields:** id, email, password, role (admin/user), status (active/blocked)
**Records Needed:** At least 1 admin account
**Backup:** CRITICAL - Losing this means you can't access the admin panel

### 2. **products** - E-commerce Products
**Purpose:** Store affiliate and shop products
**Key Fields:** name, price, category, is_affiliate, image_url, is_active
**Records Needed:** Product data for your shop
**Backup:** CRITICAL - All product data and images stored here

### 3. **reviews** - Customer Reviews
**Purpose:** Store customer ratings and testimonials
**Key Fields:** rating, review, status (approved/pending), source (direct/imported)
**Records Needed:** Customer feedback data
**Backup:** IMPORTANT - Build trust and social proof

### 4. **contact_messages** - Contact Form Submissions
**Purpose:** Store messages from your contact form
**Key Fields:** first_name, last_name, email, message, status
**Records Needed:** Lead inquiries and customer messages
**Backup:** IMPORTANT - Business inquiries and contact information

### 5. **merchant_applications** - Merchant Applications
**Purpose:** Store payment processor applications
**Key Fields:** company, email, status, confirmed, business_type
**Records Needed:** Merchant application data
**Backup:** CRITICAL - Business applications and prospects

### 6. **digital_briefs** - Service Requests
**Purpose:** Store digital services project requests
**Key Fields:** name, email, budget_min, budget_max, services (JSON)
**Records Needed:** Service inquiry data
**Backup:** IMPORTANT - Business opportunities

### 7. **business_referrals** - Referral Program
**Purpose:** Track business referrals and partnerships
**Key Fields:** referrer_name, referrer_email, business_name, status
**Records Needed:** Referral tracking data
**Backup:** IMPORTANT - Partnership and referral data

### 8. **business_owners** - Business Inquiries
**Purpose:** Store business owner inquiry forms
**Key Fields:** owner_name, business_name, phone, email, status
**Records Needed:** Business owner contact data
**Backup:** IMPORTANT - Sales leads

---

## 📈 DATA MIGRATION STEPS

If you have existing data, follow these steps to migrate it:

### Step 1: Export Existing Data
```bash
# Backup entire database
mysqldump -u root -p optimumpayments_db > complete_backup.sql
```

### Step 2: Check Existing Tables
```bash
mysql -u root -p
USE optimumpayments_db;
SHOW TABLES;
```

### Step 3: Import New Table Structure
```bash
# This won't affect existing tables - it only creates missing ones
mysql -u root -p optimumpayments_db < _system/create_all_tables.sql
```

### Step 4: Verify Data Integrity
```sql
-- Run in MySQL to check for issues
-- Check for orphaned reviews without users
SELECT COUNT(*) as orphaned_reviews 
FROM reviews 
WHERE user_id IS NOT NULL AND user_id NOT IN (SELECT id FROM users);

-- Check for duplicate emails in users table
SELECT email, COUNT(*) 
FROM users 
GROUP BY email 
HAVING COUNT(*) > 1;

-- Check for NULL values in critical fields
SELECT COUNT(*) as null_emails FROM users WHERE email IS NULL;
SELECT COUNT(*) as null_products FROM products WHERE name IS NULL;
```

---

## 🛡️ SECURITY CHECKLIST

Before going to production:

### Database Credentials
- [ ] Database username changed from default
- [ ] Database password is strong (mix of upper, lower, numbers, symbols)
- [ ] Credentials stored in `_system/db.php` (not committed to public repo)
- [ ] db.php file permissions restricted (644 or 400)

### Table Security
- [ ] All tables use utf8mb4_unicode_ci collation (for security & emoji support)
- [ ] Foreign key constraints enabled (referential integrity)
- [ ] NOT NULL constraints on required fields
- [ ] CHECK constraints on numeric fields (like rating 1-5)
- [ ] ENUM values enforced for status fields

### Access Control
- [ ] Admin authentication required for sensitive operations
- [ ] User roles properly configured (admin vs user)
- [ ] Prepared statements used for all queries (prevents SQL injection)
- [ ] User input validated and sanitized

### Backups
- [ ] Automated daily backups scheduled
- [ ] Test restore procedure
- [ ] Backups stored in secure location
- [ ] Off-site backup copies (cloud storage)

---

## 🔄 BACKUP & RECOVERY PROCEDURES

### Making a Backup

**Manual Backup:**
```bash
# Backup entire database
mysqldump -u root -p optimumpayments_db > backup_$(date +%Y%m%d_%H%M%S).sql

# Backup specific table
mysqldump -u root -p optimumpayments_db users > backup_users.sql

# Backup with single statements per insert (smaller, portable)
mysqldump -u root -p --extended-insert=false optimumpayments_db > backup.sql
```

### Restoring from Backup

**Restore Entire Database:**
```bash
mysql -u root -p optimumpayments_db < backup.sql
```

**Restore Specific Table:**
```bash
# First drop the table, then restore it
mysql -u root -p optimumpayments_db
DROP TABLE users;
EXIT;

# Then restore from backup
mysql -u root -p optimumpayments_db < backup_users.sql
```

### Scheduled Backups (Windows Task Scheduler)

Create a batch file `backup.bat`:
```batch
@echo off
set TIMESTAMP=%date:~10,4%%date:~4,2%%date:~7,2%_%time:~0,2%%time:~3,2%
set BACKUP_DIR=C:\xampp\backups
set DB_NAME=optimumpayments_db

mkdir %BACKUP_DIR% 2>nul

"C:\xampp\mysql\bin\mysqldump.exe" -u root -p password %DB_NAME% > %BACKUP_DIR%\backup_%TIMESTAMP%.sql

echo Backup completed: %BACKUP_DIR%\backup_%TIMESTAMP%.sql
```

Then schedule this file to run daily using Windows Task Scheduler.

---

## 🚁 PRE-PRODUCTION TESTING

### Test 1: Create New Admin Account
```sql
-- Test user creation
INSERT INTO users (name, email, password, role, status)
VALUES (
    'Test Admin',
    'testadmin@example.com',
    '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36gZvWFm',
    'admin',
    'active'
);

-- Verify it was created
SELECT * FROM users WHERE email = 'testadmin@example.com';

-- Test login with: testadmin@example.com / password
```

### Test 2: Add Sample Product
```sql
-- Insert sample product
INSERT INTO products (name, description, price, category, is_active)
VALUES (
    'Test Product',
    'This is a test product',
    99.99,
    'shop',
    1
);

-- Verify it displays on frontend
```

### Test 3: Submit Sample Forms
- Visit contact form and submit a test message
- Check if it appears in admin panel
- Verify email notification sent

### Test 4: Test Backup & Restore
```bash
# Make test backup
mysqldump -u root -p optimumpayments_db > test_backup.sql

# Verify backup file exists and has content
type test_backup.sql | more

# Delete a test record
mysql -u root -p optimumpayments_db
DELETE FROM products WHERE id = 1;

# Restore from backup
mysql -u root -p optimumpayments_db < test_backup.sql

# Verify record is back
SELECT * FROM products WHERE id = 1;
```

---

## 📱 PRODUCTION DEPLOYMENT CHECKLIST

### Before Moving to Production

**Database:**
- [ ] All 8 tables created successfully
- [ ] Data migrated if needed
- [ ] Backup created and tested
- [ ] Database optimized (indexes added)

**Configuration:**
- [ ] Database credentials updated for production
- [ ] _system/db.php configured for production server
- [ ] SSL/HTTPS enabled for admin panel
- [ ] Session timeout configured appropriately

**Security:**
- [ ] All user passwords hashed with password_hash()
- [ ] All queries use prepared statements
- [ ] Input validation on all forms
- [ ] CSRF tokens in place
- [ ] Rate limiting on sensitive endpoints

**Testing:**
- [ ] All forms test successfully
- [ ] Admin panel login works
- [ ] Products display on frontend
- [ ] Reviews show correctly
- [ ] Email notifications send
- [ ] Reports/exports work

**Monitoring:**
- [ ] Error logging configured
- [ ] Database monitoring set up
- [ ] Performance metrics established
- [ ] Alerts configured for issues
- [ ] Backup verification scheduled

**Documentation:**
- [ ] Database documentation complete
- [ ] Backup procedures documented
- [ ] Recovery procedures tested
- [ ] Team trained on procedures
- [ ] Support contacts identified

---

## 🆘 TROUBLESHOOTING

### Error: "No such table"
**Solution:** The table hasn't been created yet.
```bash
# Re-run the CREATE TABLE script
mysql -u root -p optimumpayments_db < _system/create_all_tables.sql
```

### Error: "Duplicate entry for key 'email'"
**Solution:** User already exists with that email.
```sql
-- Check for existing user
SELECT * FROM users WHERE email = 'your@email.com';

-- Or use INSERT IGNORE (won't error if exists)
INSERT IGNORE INTO users (name, email, password, role, status) VALUES (...);
```

### Error: "Syntax error in SQL statement"
**Solution:** Check the SQL file encoding and line endings.
```bash
# Ensure proper encoding
file -i _system/create_all_tables.sql
# Should show: charset=utf-8
```

### Slow Backups
**Solution:** Exclude logs or large tables:
```bash
mysqldump -u root -p optimumpayments_db \
  --ignore-table=optimumpayments_db.logs \
  > backup.sql
```

### Foreign Key Errors
**Solution:** Check that referenced tables exist first:
```sql
-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

-- Load data here

-- Re-enable checks
SET FOREIGN_KEY_CHECKS = 1;
```

---

## 📞 SUPPORT & RESOURCES

### Common Questions

**Q: Can I skip creating some tables?**
- A: No, all 8 tables are required for full functionality. Some features will break without them.

**Q: How often should I backup?**
- A: At least daily, or after important changes. Consider hourly backups for critical data.

**Q: What's the maximum database size?**
- A: Depends on your hosting, but 1GB is typically safe. Monitor size regularly.

**Q: Can I migrate to a different database system?**
- A: Yes, but requires rewriting queries. SQL structure is portable to PostgreSQL, etc.

### Useful MySQL Commands

```bash
# Check database size
SELECT table_schema "Database", 
   ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) "Size in MB" 
FROM information_schema.tables 
GROUP BY table_schema;

# Check table row counts
SELECT TABLE_NAME, TABLE_ROWS FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA = 'optimumpayments_db';

# Optimize all tables
OPTIMIZE TABLE optimumpayments_db.*;

# Repair corrupted table
REPAIR TABLE table_name;
```

---

## ✅ PRODUCTION READY CHECKLIST

- [ ] All 8 tables created
- [ ] All existing data migrated
- [ ] Backup created and tested
- [ ] Security measures in place
- [ ] Forms tested
- [ ] Admin panel working
- [ ] Frontend working
- [ ] Email notifications tested
- [ ] Monitoring configured
- [ ] Disaster recovery plan ready
- [ ] Team trained
- [ ] Documentation complete

**Once all items checked: ✅ READY FOR PRODUCTION DEPLOYMENT**

---

**Last Updated:** March 6, 2026
**Version:** 1.0
**Status:** Production Ready
