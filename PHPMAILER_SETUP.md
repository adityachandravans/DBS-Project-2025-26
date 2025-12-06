# 📧 PHPMailer Email Setup Guide

## Overview

Your inventory system is now configured to send real emails using **PHPMailer** with Gmail SMTP.

### Email Credentials (Already Configured):
- **Email:** seminarmanagement143@gmail.com
- **App Password:** atkiotfaccnmpiql
- **SMTP Host:** smtp.gmail.com
- **SMTP Port:** 587

---

## 🚀 Quick Setup (3 Steps)

### Step 1: Install PHPMailer

Visit this URL in your browser:
```
http://localhost/inventory-system/install_phpmailer.php
```

This will:
- ✅ Download PHPMailer files automatically
- ✅ Place them in the correct location
- ✅ Verify installation
- ✅ Show you the status

**That's it!** PHPMailer will be installed automatically.

### Step 2: Test Email Sending

Visit:
```
http://localhost/inventory-system/test_email.php
```

1. Enter your email address
2. Click "Send Test Email"
3. Check your inbox (and spam folder)
4. You should receive a test OTP email

### Step 3: Register and Test

Visit:
```
http://localhost/inventory-system/auth/register.php
```

1. Fill the registration form
2. Click "Create Account"
3. Check your email for OTP
4. Enter OTP and verify
5. Login and enjoy!

---

## 📋 How It Works

### With PHPMailer (Recommended):
1. User registers
2. System generates 6-digit OTP
3. **PHPMailer sends email via Gmail SMTP**
4. User receives email with OTP
5. User enters OTP to verify
6. Account activated!

### Without PHPMailer (Fallback):
1. User registers
2. System generates 6-digit OTP
3. **OTP shown on screen** (development mode)
4. User enters OTP to verify
5. Account activated!

---

## ✨ Features

### Email Templates Included:

#### 1. OTP Verification Email
- Beautiful HTML design
- 6-digit OTP code
- Expiry information (10 minutes)
- Security tips
- Professional branding

#### 2. Welcome Email
- Sent after successful verification
- Feature highlights
- Getting started guide
- Professional design

---

## 🔧 Configuration Details

### File: `config/email.php`

The system automatically:
- ✅ Tries to use PHPMailer if installed
- ✅ Falls back to PHP mail() if PHPMailer not available
- ✅ Shows OTP on screen if email fails (development mode)
- ✅ Logs errors for debugging

### SMTP Settings:
```php
SMTP_HOST: smtp.gmail.com
SMTP_PORT: 587
SMTP_USERNAME: seminarmanagement143@gmail.com
SMTP_PASSWORD: atkiotfaccnmpiql
SMTP_SECURE: STARTTLS
```

---

## 🧪 Testing

### Test 1: PHPMailer Installation
```
http://localhost/inventory-system/install_phpmailer.php
```
Should show: ✅ All files installed

### Test 2: Email Sending
```
http://localhost/inventory-system/test_email.php
```
Should send email to your address

### Test 3: Registration Flow
```
http://localhost/inventory-system/auth/register.php
```
Should send OTP email after registration

### Test 4: Complete Flow
1. Register → Receive OTP email
2. Verify → Receive welcome email
3. Login → Access dashboard

---

## 🔍 Troubleshooting

### Problem: PHPMailer not installing

**Solution 1:** Manual Installation
1. Download from: https://github.com/PHPMailer/PHPMailer/releases
2. Extract the ZIP file
3. Copy these files to `PHPMailer` folder:
   - PHPMailer.php
   - SMTP.php
   - Exception.php

**Solution 2:** Use without PHPMailer
- System will work in development mode
- OTP shown on screen instead of email
- Perfect for testing!

### Problem: Email not sending

**Check:**
1. PHPMailer installed? Visit install_phpmailer.php
2. Internet connection working?
3. Gmail credentials correct?
4. Check spam folder

**Test:**
```
http://localhost/inventory-system/test_email.php
```

### Problem: "SMTP connect() failed"

**Causes:**
- Firewall blocking port 587
- Antivirus blocking SMTP
- Internet connection issue

**Solutions:**
1. Temporarily disable firewall
2. Check antivirus settings
3. Try different network
4. Use development mode (OTP on screen)

### Problem: "Invalid credentials"

**Check:**
- Email: seminarmanagement143@gmail.com
- App Password: atkiotfaccnmpiql
- These are already configured in config/email.php

### Problem: Email goes to spam

**Normal behavior:**
- First emails often go to spam
- Mark as "Not Spam"
- Future emails will go to inbox

---

## 📁 File Structure

```
inventory-system/
├── PHPMailer/
│   ├── PHPMailer.php    (Main class)
│   ├── SMTP.php         (SMTP protocol)
│   └── Exception.php    (Error handling)
├── config/
│   └── email.php        (Email configuration)
├── install_phpmailer.php (Installation script)
├── test_email.php       (Email testing)
└── auth/
    ├── register.php     (Uses email for OTP)
    └── verify_otp.php   (Verifies OTP)
```

---

## 🎯 Email Flow Diagram

```
Registration
     │
     ▼
Generate OTP (123456)
     │
     ▼
PHPMailer → Gmail SMTP → User's Email
     │
     ▼
User receives email
     │
     ▼
User enters OTP
     │
     ▼
Verification successful
     │
     ▼
Welcome email sent
```

---

## 💡 Development vs Production

### Development Mode (Current):
- ✅ PHPMailer sends real emails
- ✅ OTP shown on screen if email fails
- ✅ Perfect for testing
- ✅ No XAMPP configuration needed

### Production Mode (Future):
- ✅ PHPMailer sends real emails
- ❌ No OTP on screen
- ✅ Email required for verification
- ✅ More secure

To switch to production mode:
1. Remove debug OTP display from verify_otp.php
2. Remove fallback OTP display from register.php
3. Enforce email verification

---

## 🔐 Security Notes

### Gmail App Password:
- ✅ Already configured
- ✅ More secure than regular password
- ✅ Can be revoked anytime
- ✅ Specific to this application

### OTP Security:
- ✅ 6-digit random code
- ✅ Expires in 10 minutes
- ✅ One-time use only
- ✅ Stored securely in database

---

## ✅ Checklist

Before going live:

- [ ] PHPMailer installed (visit install_phpmailer.php)
- [ ] Email test successful (visit test_email.php)
- [ ] Registration sends OTP email
- [ ] OTP verification works
- [ ] Welcome email received
- [ ] Login works after verification

---

## 📞 Support

### Quick Links:
- Install PHPMailer: `install_phpmailer.php`
- Test Email: `test_email.php`
- System Status: `test_basic.php`
- Registration: `auth/register.php`

### Common Issues:
1. **PHPMailer not found** → Run install_phpmailer.php
2. **Email not sending** → Check test_email.php
3. **SMTP error** → Check internet connection
4. **Spam folder** → Mark as "Not Spam"

---

## 🎉 Benefits of PHPMailer

✅ **Reliable:** Industry-standard email library
✅ **Secure:** Uses SMTP authentication
✅ **Professional:** Beautiful HTML emails
✅ **Easy:** Automatic installation
✅ **Flexible:** Works with any SMTP server
✅ **Tested:** Used by millions of websites

---

## 📧 Email Examples

### OTP Email Preview:
```
Subject: Email Verification - OTP Code

Hello testuser!

Thank you for registering with Inventory Management System.

To complete your registration, please use the following OTP:

┌─────────────┐
│   123456    │
└─────────────┘

Important:
• This OTP is valid for 10 minutes
• Do not share this code with anyone
• If you didn't request this, please ignore

Best regards,
Inventory Management Team
```

### Welcome Email Preview:
```
Subject: Welcome to Inventory Management System!

Hello testuser!

Your email has been successfully verified!

You can now access all features:
✓ Add and manage products
✓ Track inventory levels
✓ View detailed statistics
✓ Generate reports

Thank you for joining us!

Best regards,
Inventory Management Team
```

---

## 🚀 Ready to Go!

Your email system is configured and ready to use!

**Start here:**
1. Visit: `http://localhost/inventory-system/install_phpmailer.php`
2. Click install button
3. Test with: `test_email.php`
4. Register and enjoy!

---

Last Updated: December 6, 2025
Status: ✅ Ready to Use
Email Provider: Gmail SMTP via PHPMailer
