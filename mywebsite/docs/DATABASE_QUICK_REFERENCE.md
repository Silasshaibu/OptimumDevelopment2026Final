## 🚀 DATABASE QUICK REFERENCE CARD

**Print this and keep it handy during deployment!**

---

## 📋 CRITICAL INFORMATION

```
Database Name:     optimumpayments_db
Total Tables:      8
MySQL Version:     5.6 or higher
Charset:           utf8mb4
Collation:         utf8mb4_unicode_ci
```

---

## 🗂️ TABLE NAMES & FIELDS

### 1️⃣ users
```
Fields: id, name, email, password, role, status, created_at, updated_at
Key: email (UNIQUE)
Constraint: role IN ('user', 'admin')
Constraint: status IN ('active', 'blocked', 'inactive')
Min Records: 1 (admin account)
```

### 2️⃣ products
```
Fields: id, name, description, price, category, is_affiliate, affiliate_link, 
        image_url, stock_quantity, is_active, display_order, created_at, updated_at
Key: category (INDEX)
Constraint: category IN ('shop', 'handheld', 'supplies', 'top_selling')
Min Records: Depends on your catalog
```

### 3️⃣ reviews
```
Fields: id, user_id, guest_email, name, rating, review, status, source, 
        platform, reviewer_img, reviewer_url, recommendation_type, created_at, updated_at
Keys: status, source, email (INDEXES)
Foreign Key: user_id → users.id
Constraint: rating BETWEEN 1 AND 5
Constraint: status IN ('pending', 'approved', 'rejected')
Min Records: 0 (optional)
```

### 4️⃣ contact_messages
```
Fields: id, first_name, last_name, email, phone, company, source, message, 
        status, ip_address, created_at, updated_at
Keys: status, email, created_at (INDEXES)
Constraint: status IN ('new', 'read', 'replied', 'closed')
Min Records: 0 (optional)
```

### 5️⃣ merchant_applications
```
Fields: id, surname, first_name, title, phone, company, email, fax, 
        address1, address2, city, state, zip, business_type, accept_credit_cards, 
        previous_credit_cards, monthly_volume, comments, status, confirmed, 
        confirmation_token, created_at, updated_at
Keys: status, confirmed, email, company (INDEXES)
Constraint: status IN ('new', 'pending', 'processing', 'approved', 'rejected')
Constraint: confirmed IN (0, 1)
Min Records: 0 (optional)
```

### 6️⃣ digital_briefs
```
Fields: id, name, email, phone, website, budget_min, budget_max, 
        referral_source, services (JSON), comments, status, created_at, updated_at
Keys: status, email, created_at (INDEXES)
Constraint: status IN ('new', 'pending', 'in_progress', 'completed', 'rejected')
Min Records: 0 (optional)
```

### 7️⃣ business_referrals
```
Fields: id, referrer_name, referrer_email, referrer_phone, business_name, 
        owner_name, owner_phone, owner_email, status, created_at, updated_at
Keys: status, referrer_email, business_name (INDEXES)
Constraint: status IN ('new', 'pending', 'approved', 'rejected', 'completed')
Min Records: 0 (optional)
```

### 8️⃣ business_owners
```
Fields: id, owner_name, business_name, phone, email, status, created_at, updated_at
Keys: status, email, created_at (INDEXES)
Constraint: status IN ('new', 'contacted', 'interested', 'qualified', 'rejected')
Min Records: 0 (optional)
```

---

## 🔧 ESSENTIAL COMMANDS

### CREATE ALL TABLES
```bash
mysql -u root -p optimumpayments_db < _system/create_all_tables.sql
```

### VERIFY TABLES EXIST
```bash
mysql -u root -p
USE optimumpayments_db;
SHOW TABLES;
```

### BACKUP DATABASE
```bash
mysqldump -u root -p optimumpayments_db > backup_$(date +%Y%m%d).sql
```

### RESTORE DATABASE
```bash
mysql -u root -p optimumpayments_db < backup_YYYYMMDD.sql
```

### CHECK TABLE STRUCTURE
```bash
DESCRIBE table_name;
DESCRIBE users;
```

### CHECK ROW COUNTS
```bash
SELECT 'users', COUNT(*) FROM users
UNION ALL SELECT 'products', COUNT(*) FROM products
UNION ALL SELECT 'reviews', COUNT(*) FROM reviews
UNION ALL SELECT 'contact_messages', COUNT(*) FROM contact_messages
UNION ALL SELECT 'merchant_applications', COUNT(*) FROM merchant_applications
UNION ALL SELECT 'digital_briefs', COUNT(*) FROM digital_briefs
UNION ALL SELECT 'business_referrals', COUNT(*) FROM business_referrals
UNION ALL SELECT 'business_owners', COUNT(*) FROM business_owners;
```

### CREATE TEST ADMIN USER
```sql
INSERT INTO users (name, email, password, role, status) VALUES (
    'Admin User',
    'admin@example.com',
    '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36gZvWFm',
    'admin',
    'active'
);
-- Password: password
```

### DELETE TEST ADMIN USER
```sql
DELETE FROM users WHERE email = 'admin@example.com';
```

---

## 🔍 QUICK DIAGNOSTICS

### Check Database Size
```sql
SELECT table_name, 
       ROUND(((data_length + index_length) / 1024 / 1024), 2) AS size_mb
FROM information_schema.tables 
WHERE table_schema = 'optimumpayments_db';
```

### Find Duplicate Emails
```sql
SELECT email, COUNT(*) as count FROM users GROUP BY email HAVING count > 1;
SELECT email, COUNT(*) as count FROM contact_messages GROUP BY email HAVING count > 1;
```

### Check NULL Values
```sql
SELECT COUNT(*) as null_count FROM users WHERE email IS NULL;
SELECT COUNT(*) as null_count FROM products WHERE name IS NULL;
SELECT COUNT(*) as null_count FROM reviews WHERE rating IS NULL;
```

### Verify Foreign Keys
```sql
SELECT COUNT(*) as orphaned_reviews 
FROM reviews 
WHERE user_id IS NOT NULL AND user_id NOT IN (SELECT id FROM users);
```

---

## ⏱️ DEPLOYMENT TIMELINE

| Step | Action | Time | Command |
|------|--------|------|---------|
| 1 | Backup current | 2 min | `mysqldump -u root -p optimumpayments_db > backup.sql` |
| 2 | Create tables | 1 min | `mysql -u root -p optimumpayments_db < create_all_tables.sql` |
| 3 | Verify tables | 1 min | `SHOW TABLES;` |
| 4 | Create admin | 1 min | `INSERT INTO users ...` |
| 5 | Test login | 2 min | Visit `/mywebsite/_system/auth/login.php` |
| 6 | Test forms | 5 min | Submit test contact message |
| 7 | Test products | 5 min | Add sample product |
| 8 | Run tests | 10 min | Full functionality test |
| **TOTAL** | **Complete** | **~27 min** | ✅ Ready |

---

## 🚨 EMERGENCY PROCEDURES

### IF TABLES DON'T EXIST
1. Check if database exists: `mysql -u root -p -e "SHOW DATABASES;"`
2. If not: `CREATE DATABASE optimumpayments_db;`
3. Run: `mysql -u root -p optimumpayments_db < create_all_tables.sql`

### IF PASSWORDS ARE FORGOTTEN
1. Reset MySQL root: Stop MySQL, start with `--skip-grant-tables`
2. Then: `UPDATE users SET password = SHA2('newpass', 256) WHERE email = 'admin@example.com';`
3. Use proper hashing in app code

### IF BACKUP IS CORRUPT
1. Check file: `file backup.sql` (should show "ASCII text")
2. Verify with: `grep -c "INSERT INTO" backup.sql`
3. Try partial restore for specific table

### IF DATABASE IS LOCKED
1. Show processes: `SHOW PROCESSLIST;`
2. Kill process: `KILL process_id;`
3. Check for locks: `SHOW OPEN TABLES WHERE in_use > 0;`

---

## 📊 PERFORMANCE TARGETS

| Metric | Target | Check |
|--------|--------|-------|
| Backup time | < 1 min | `time mysqldump ...` |
| Restore time | < 1 min | `time mysql ... < backup.sql` |
| Query response | < 100ms | Use `EXPLAIN` |
| Table size | < 100MB | Check `information_schema` |
| Row count | < 100k per table | `COUNT(*)` |

---

## 📝 COMMON QUERIES

### Get Recent Activity
```sql
SELECT 'Reviews' as type, COUNT(*) as count, MAX(created_at) as latest FROM reviews
UNION ALL SELECT 'Messages', COUNT(*), MAX(created_at) FROM contact_messages
UNION ALL SELECT 'Applications', COUNT(*), MAX(created_at) FROM merchant_applications;
```

### Get Status Summary
```sql
SELECT 'Users' as type, status, COUNT(*) FROM users GROUP BY status
UNION ALL SELECT 'Reviews', status, COUNT(*) FROM reviews GROUP BY status
UNION ALL SELECT 'Messages', status, COUNT(*) FROM contact_messages GROUP BY status;
```

### Find Recently Added Data
```sql
SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 10;
SELECT * FROM merchant_applications WHERE created_at > DATE_SUB(NOW(), INTERVAL 7 DAY);
SELECT * FROM reviews WHERE status = 'pending' ORDER BY created_at ASC;
```

---

## 🔐 SECURITY REMINDERS

✅ **ALWAYS:**
- Use prepared statements (parameterized queries)
- Hash passwords with `password_hash()`
- Validate user input
- Use HTTPS for admin panel
- Keep backups off-site
- Update MySQL regularly
- Monitor disk space

❌ **NEVER:**
- Store plain-text passwords
- Use `SELECT *` in loops (performance)
- Connect as root from application
- Store backups on same server
- Skip input validation
- Leave default credentials
- Ignore error logs

---

## 📞 QUICK HELP

| Problem | Solution |
|---------|----------|
| "Access Denied" | Check username/password in `_system/db.php` |
| "MySQL has gone away" | Increase `max_connections` or restart MySQL |
| Table doesn't exist | Run `create_all_tables.sql` |
| Data is gone | Restore from backup file |
| Email not sending | Check `_system/email_config.php` |
| Admin can't login | Create new user with proper password hash |
| Site is slow | Check database size, run `OPTIMIZE TABLE` |

---

**Last Updated:** March 6, 2026  
**Print & Keep Safe!** 🔒
