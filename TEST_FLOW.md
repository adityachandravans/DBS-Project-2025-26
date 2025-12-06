# Complete Testing Flow Guide

## ✅ Fixed Issues:
1. **Logout redirect** - Now properly redirects to index.php (home page)
2. **Session handling** - Better error messages and session management
3. **Email verification flow** - Improved with success messages
4. **Unverified login** - Users can click link to go to verification page
5. **Registration error handling** - Better error messages and cleanup

## 🧪 Testing Steps:

### 1. Initial Access
- Visit: `http://localhost/your-project/`
- Should show: Welcome page with Login and Get Started buttons
- ✅ Test: Click "Get Started" → Should go to register.php

### 2. Registration Flow
- Visit: `http://localhost/your-project/auth/register.php`
- Fill in:
  - Username: testuser
  - Email: your-email@gmail.com
  - Password: test123
  - Confirm Password: test123
- Click "Create Account"
- ✅ Should redirect to: verify_otp.php with success message
- ✅ Should receive: Email with 6-digit OTP

### 3. OTP Verification
- On verify_otp.php page
- Enter the 6-digit OTP from email
- Click "Verify OTP"
- ✅ Should redirect to: login.php with success message
- ✅ Should receive: Welcome email

### 4. Login Flow
- Visit: `http://localhost/your-project/auth/login.php`
- Enter email and password
- Click "Sign In"
- ✅ Should redirect to: dashboard.php
- ✅ Should show: Welcome message with username

### 5. Dashboard Access
- Should see:
  - Total Products count
  - Total Quantity count
  - Quick action buttons
- ✅ Test navigation links work

### 6. Product Management
- Click "Add New Product"
- ✅ Should go to: products/add.php
- Add a product:
  - Name: Test Product
  - Quantity: 10
  - Price: 99.99
- Click "Add Product"
- ✅ Should show: Success message
- Click "Back to Products"
- ✅ Should go to: products/index.php
- ✅ Should see: Product in table

### 7. Edit Product
- Click "Edit" on a product
- ✅ Should go to: products/edit.php?id=X
- Change values and click "Update Product"
- ✅ Should show: Success message
- ✅ Product should be updated

### 8. Delete Product
- Click "Delete" on a product
- Confirm deletion
- ✅ Should redirect to: products/index.php
- ✅ Product should be removed

### 9. Logout
- Click "Logout" from any page
- ✅ Should redirect to: index.php (home/welcome page)
- ✅ Session should be destroyed
- Try accessing dashboard.php directly
- ✅ Should redirect to: login.php

### 10. Protected Routes
Test these URLs without logging in:
- `/dashboard.php` → Should redirect to login
- `/products/index.php` → Should redirect to login
- `/products/add.php` → Should redirect to login
- `/products/edit.php?id=1` → Should redirect to login

### 11. Unverified User Login
- Register a new user but don't verify
- Try to login
- ✅ Should show: Error with link to verify
- Click verification link
- ✅ Should go to: verify_otp.php

### 12. Resend OTP
- On verify_otp.php page
- Click "Resend OTP"
- ✅ Should show: Success message
- ✅ Should receive: New OTP email

## 🔧 Common Issues & Solutions:

### Email Not Sending
- Check `config/email.php` credentials
- Ensure Gmail "App Password" is correct
- Check spam folder

### Database Connection Error
- Verify MySQL is running
- Check `config/db.php` credentials
- Import `database.sql` file

### Redirect Not Working
- Check for output before header()
- Ensure no spaces before <?php
- Check file paths are correct

### Session Issues
- Clear browser cookies
- Check session_start() is at top of files
- Verify PHP session is enabled

## 📝 All Redirect Paths:

| From | To | Condition |
|------|-----|-----------|
| index.php | dashboard.php | If logged in |
| index.php | welcome.php | If not logged in |
| register.php | verify_otp.php | After successful registration |
| verify_otp.php | login.php | After successful verification |
| verify_otp.php | register.php | If no session data |
| login.php | dashboard.php | After successful login |
| logout.php | index.php | Always |
| dashboard.php | login.php | If not logged in |
| products/* | login.php | If not logged in |
| delete.php | index.php | After deletion |

## ✨ Features Working:
- ✅ User registration with validation
- ✅ Email OTP verification (6-digit code)
- ✅ OTP expiry (10 minutes)
- ✅ Resend OTP functionality
- ✅ Secure login with password hashing
- ✅ Session management
- ✅ Protected routes
- ✅ Product CRUD operations
- ✅ Dashboard statistics
- ✅ Responsive design
- ✅ Beautiful email templates
- ✅ Proper logout with redirect to home
