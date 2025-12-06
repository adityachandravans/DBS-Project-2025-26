# 🔧 Troubleshooting Guide - Blank Page Issue

## Problem: Blank Page After Clicking "Create Account"

This usually means there's a PHP error that's not being displayed.

## ✅ IMMEDIATE SOLUTIONS

### Solution 1: Use Test Pages (Recommended)

1. **Visit:** `http://localhost/inventory-system/test_basic.php`
   - This will show you exactly what's wrong
   - Check all sections for ❌ red X marks
   - Fix any issues shown

2. **Visit:** `http://localhost/inventory-system/auth/register_simple.php`
   - This is a simplified registration page
   - Shows debug information
   - Form fields are pre-filled for quick testing
   - Click "Create Account" and watch for errors

### Solution 2: Check Database

The most common cause is **database not imported**.

**Steps:**
1. Open XAMPP Control Panel
2. Make sure MySQL is running (green)
3. Click "Admin" next to MySQL (opens phpMyAdmin)
4. Look for database named `inventory_db`
5. If it doesn't exist:
   - Click "New" to create database
   - Name it: `inventory_db`
   - Click "Create"
6. Click on `inventory_db`
7. Click "Import" tab
8. Click "Choose File"
9. Select `database.sql` from your project folder
10. Click "Go"
11. Wait for success message

### Solution 3: Enable Error Display

Add this to the top of `auth/register.php` (already done):

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 🔍 DIAGNOSTIC STEPS

### Step 1: Check XAMPP Services

```
✓ Apache: Must be running (green)
✓ MySQL: Must be running (green)
```

If not running:
- Click "Start" button
- Wait for green status
- If fails, check port conflicts (80 for Apache, 3306 for MySQL)

### Step 2: Check Database Connection

Visit: `http://localhost/inventory-system/test_basic.php`

Look for:
- ✅ Database connected successfully
- ✅ Users table exists
- ✅ Products table exists

If you see ❌:
- Import database.sql
- Check MySQL is running
- Verify database name is `inventory_db`

### Step 3: Check File Paths

Visit: `http://localhost/inventory-system/test_basic.php`

All files should show ✅:
- config/db.php
- config/email.php
- auth/register.php
- auth/verify_otp.php
- auth/login.php

If any show ❌:
- Files are missing or in wrong location
- Re-extract project files

### Step 4: Test Simple Registration

Visit: `http://localhost/inventory-system/auth/register_simple.php`

This page:
- Has pre-filled form fields
- Shows debug information
- Displays PHP errors
- Shows HTML comments with debug info

Click "Create Account" and watch for:
- Error messages
- Debug comments (View Page Source)
- Redirect to verify_otp.php

## 🐛 COMMON ERRORS & FIXES

### Error: "Connection failed"

**Cause:** MySQL not running or database doesn't exist

**Fix:**
1. Start MySQL in XAMPP
2. Import database.sql in phpMyAdmin
3. Refresh page

### Error: "Table 'inventory_db.users' doesn't exist"

**Cause:** Database not imported

**Fix:**
1. Open phpMyAdmin
2. Select inventory_db database
3. Import database.sql
4. Try again

### Error: Blank white page, no error

**Cause:** PHP error with display_errors off

**Fix:**
1. Use register_simple.php instead
2. Or check Apache error logs:
   - Windows: `C:\xampp\apache\logs\error.log`
3. Look for recent errors

### Error: "Cannot modify header information"

**Cause:** Output before header() redirect

**Fix:**
- Already fixed in code
- Make sure no spaces before <?php
- Check for echo statements before header()

### Error: "Call to undefined function"

**Cause:** Missing PHP extension or function

**Fix:**
1. Visit test_basic.php
2. Check PHP extensions section
3. Enable required extensions in php.ini

## 📋 TESTING CHECKLIST

Use this checklist to verify everything:

### Before Testing:
- [ ] XAMPP Apache is running (green)
- [ ] XAMPP MySQL is running (green)
- [ ] Database `inventory_db` exists in phpMyAdmin
- [ ] Tables `users` and `products` exist
- [ ] Project files in `C:\xampp\htdocs\inventory-system\`

### Test 1: Basic System
- [ ] Visit `test_basic.php`
- [ ] All checks show ✅ green
- [ ] No ❌ red errors

### Test 2: Simple Registration
- [ ] Visit `auth/register_simple.php`
- [ ] Form loads correctly
- [ ] Debug info shows at bottom
- [ ] Click "Create Account"
- [ ] Redirects to verify_otp.php
- [ ] OTP shown in yellow box

### Test 3: Normal Registration
- [ ] Visit `auth/register.php`
- [ ] Fill form with test data
- [ ] Click "Create Account"
- [ ] Redirects to verify_otp.php
- [ ] OTP shown in yellow box

### Test 4: Complete Flow
- [ ] Register new account
- [ ] See OTP on verify page
- [ ] Enter OTP
- [ ] Redirect to login
- [ ] Login with credentials
- [ ] Redirect to dashboard
- [ ] Dashboard shows welcome message

## 🔧 ADVANCED TROUBLESHOOTING

### Check Apache Error Log

**Windows:**
```
C:\xampp\apache\logs\error.log
```

Look for recent errors (bottom of file)

### Check PHP Configuration

Create file `phpinfo.php`:
```php
<?php phpinfo(); ?>
```

Visit: `http://localhost/inventory-system/phpinfo.php`

Check:
- PHP Version (should be 7.0+)
- mysqli extension (should be enabled)
- session support (should be enabled)

### Test Database Directly

Create file `test_db.php`:
```php
<?php
$conn = mysqli_connect('localhost', 'root', '', 'inventory_db');
if ($conn) {
    echo "✅ Connected!";
    $result = mysqli_query($conn, "SELECT * FROM users");
    echo "<br>Users: " . mysqli_num_rows($result);
} else {
    echo "❌ Failed: " . mysqli_connect_error();
}
?>
```

### Clear Browser Cache

Sometimes old cached files cause issues:
1. Press Ctrl+Shift+Delete
2. Clear cache and cookies
3. Close browser
4. Reopen and try again

### Check Session Directory

PHP needs write access to session directory:
1. Visit test_basic.php
2. Check "Session Test" section
3. Should show ✅ Session working

If fails:
- Check session.save_path in php.ini
- Ensure directory exists and is writable

## 🎯 QUICK FIX WORKFLOW

**If you're seeing a blank page:**

1. **Visit:** `http://localhost/inventory-system/test_basic.php`
   - Fix any ❌ errors shown

2. **Visit:** `http://localhost/inventory-system/auth/register_simple.php`
   - Click "Create Account"
   - Watch for errors or redirect

3. **If still blank:**
   - Check `C:\xampp\apache\logs\error.log`
   - Look for PHP errors
   - Post the error message for help

4. **If redirects work:**
   - Use register_simple.php for now
   - Or fix the main register.php based on errors

## 📞 STILL NOT WORKING?

### Collect This Information:

1. **PHP Version:**
   - Visit test_basic.php
   - Note PHP version shown

2. **Database Status:**
   - Visit test_basic.php
   - Screenshot database section

3. **Error Messages:**
   - Any errors on screen
   - Errors in Apache error.log
   - Browser console errors (F12)

4. **What Happens:**
   - Describe exactly what you see
   - Does page reload?
   - Does URL change?
   - Any error messages?

### Try These URLs:

1. `http://localhost/inventory-system/test_basic.php`
2. `http://localhost/inventory-system/auth/register_simple.php`
3. `http://localhost/inventory-system/debug_registration.php`

One of these should work and show you the issue!

## ✅ SUCCESS INDICATORS

You'll know it's working when:

1. **test_basic.php shows:**
   - ✅ All green checkmarks
   - No ❌ red errors
   - "All basic checks passed!"

2. **register_simple.php:**
   - Form loads
   - Debug info shows at bottom
   - Clicking "Create Account" redirects
   - No blank page

3. **Normal flow:**
   - Register → verify_otp.php
   - OTP shown in yellow box
   - Verify → login.php
   - Login → dashboard.php

## 🎉 FINAL NOTES

- **Use register_simple.php** if main registration has issues
- **Check test_basic.php** first to diagnose problems
- **Import database.sql** if you see database errors
- **Start MySQL** if connection fails
- **Clear browser cache** if seeing old pages

---

**Most Common Fix:** Import database.sql in phpMyAdmin!

**Second Most Common:** MySQL not running in XAMPP!

**Third Most Common:** Wrong folder name in URL!

---

Last Updated: December 6, 2025
