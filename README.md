# Simple Inventory Management System

A minimal inventory management system built with PHP and MySQL.

## Quick Start for XAMPP

### 1. Install XAMPP
Download and install XAMPP from https://www.apachefriends.org/

### 2. Copy Project Files
Copy this entire project folder to your XAMPP `htdocs` directory:
- Windows: `C:\xampp\htdocs\`
- Mac: `/Applications/XAMPP/htdocs/`
- Linux: `/opt/lampp/htdocs/`

### 3. Start XAMPP Services
1. Open XAMPP Control Panel
2. Click "Start" for Apache (should turn green)
3. Click "Start" for MySQL (should turn green)

### 4. Import Database
1. Open browser: `http://localhost/phpmyadmin`
2. Click "Import" tab
3. Click "Choose File" and select `database.sql` from this project
4. Click "Go" button
5. Wait for success message

### 5. Access Application
Open browser and navigate to:
```
http://localhost/[your-folder-name]/
```
Replace `[your-folder-name]` with the actual folder name in htdocs.

### 6. Configure Email (Important!)
For OTP verification to work, configure XAMPP email settings:

**Edit php.ini** (C:\xampp\php\php.ini):
```
SMTP=smtp.gmail.com
smtp_port=587
```

**Edit sendmail.ini** (C:\xampp\sendmail\sendmail.ini):
```
smtp_server=smtp.gmail.com
smtp_port=587
auth_username=seminarmanagement143@gmail.com
auth_password=atkiotfaccnmpiql
```

Restart Apache after changes!

### 7. Test Email
Visit: `http://localhost/[folder-name]/test_email.php`
Send a test email to verify configuration.

### 8. Verify Setup (Optional but Recommended)
Visit: `http://localhost/[folder-name]/verify_setup.php`
This will check:
- PHP configuration
- Database connection
- Required tables
- Email configuration
- File structure

### 9. Register & Login
1. Visit `http://localhost/[folder-name]/`
2. Click "Get Started" or "Register here"
3. Fill in username, email, and password
4. Click "Create Account"
5. **You'll be automatically redirected to OTP verification page**
6. Check your email for 6-digit OTP code
7. Enter the OTP (auto-focuses between fields)
8. Click "Verify OTP"
9. **You'll be redirected to login with success message**
10. Login with your verified credentials
11. **You'll be redirected to dashboard**
12. Start managing your inventory!

**See TEST_FLOW.md for complete testing guide.**
**See EMAIL_SETUP_GUIDE.txt for detailed email configuration.**
**See INSTALLATION.txt for detailed step-by-step guide with troubleshooting.**

## ✅ Latest Updates (Fully Working!)

**All redirecting issues have been fixed:**
- ✅ Registration → OTP Verification (automatic redirect)
- ✅ OTP Verification → Login (with success message)
- ✅ Login → Dashboard (for verified users)
- ✅ Logout → Home Page (proper session cleanup)
- ✅ Protected routes redirect to login when not authenticated
- ✅ Unverified users get link to verification page
- ✅ Better error handling and user feedback

## Features

✨ **Authentication & Security**
- User Registration with Email Verification
- OTP (One-Time Password) via Email (6-digit code)
- OTP expiry (10 minutes)
- Resend OTP functionality
- Secure password hashing (bcrypt)
- Session management
- Email verification required for login
- Protected routes for authenticated users only

📦 **Inventory Management**
- Add new products with name, quantity, and price
- Edit existing products
- Delete products
- View all products in beautiful table
- Real-time inventory tracking

📊 **Dashboard & Analytics**
- Welcome dashboard with user greeting
- Total products count
- Total quantity statistics
- Quick action buttons

🎨 **Modern UI/UX**
- Beautiful gradient design
- Smooth animations and transitions
- Responsive design for all devices
- Professional email templates
- Interactive OTP input
- Card hover effects
- Modern color scheme

## Configuration Files

**Database** (config/db.php):
- Host: localhost
- Username: root
- Password: (empty)
- Database: inventory_db

**Email** (config/email.php):
- SMTP: smtp.gmail.com
- Port: 587
- Email: seminarmanagement143@gmail.com
- App Password: atki otfa ccnm piql

⚠️ **Security Note:** Change email credentials in production!

## Folder Structure

```
inventory-system/
├── config/
│   └── db.php              # Database configuration
├── auth/
│   ├── login.php           # Login page
│   ├── register.php        # Registration page
│   └── logout.php          # Logout logic
├── products/
│   ├── index.php           # View all products
│   ├── add.php             # Add product
│   ├── edit.php            # Edit product
│   └── delete.php          # Delete product
├── dashboard.php           # Dashboard with stats
├── index.php               # Entry point
├── style.css               # Styles
├── database.sql            # Database structure
└── README.md               # This file
```

## Screenshots & Demo

Visit `http://localhost/[folder-name]/` to see:
- Beautiful welcome page with feature showcase
- Modern login and registration forms
- OTP verification interface
- Gradient dashboard with statistics
- Professional product management table
- Responsive design on all devices

## Troubleshooting

**Problem:** Cannot connect to database
- Make sure MySQL is running in XAMPP
- Check database credentials in `config/db.php`
- Import database.sql in phpMyAdmin

**Problem:** Email not sending
- Configure php.ini (see EMAIL_SETUP_GUIDE.txt)
- Configure sendmail.ini
- Restart Apache after changes
- Test with test_email.php
- Check spam folder

**Problem:** OTP not received
- Verify email configuration
- Check spam/junk folder
- Use test_email.php to verify setup
- Check Apache error logs

**Problem:** Page not found
- Make sure you copied files to `htdocs` folder
- Check the URL: `http://localhost/[folder-name]`
- Verify Apache is running

**Problem:** Database not found
- Import `database.sql` in phpMyAdmin
- Or create database manually named `inventory_db`
- Verify database name in config/db.php
