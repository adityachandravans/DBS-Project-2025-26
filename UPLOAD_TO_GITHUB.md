# 📤 Upload Project to GitHub (Forked Repository)

## Quick Guide to Upload Your Inventory Management System

### 🎯 Prerequisites

1. Git installed on your computer
2. GitHub account with forked repository
3. Your project folder: `C:\xampp\htdocs\inventory-system`

---

## 🚀 Method 1: Using Git Commands (Recommended)

### Step 1: Open Command Prompt in Project Folder

1. Open File Explorer
2. Navigate to: `C:\xampp\htdocs\inventory-system`
3. Type `cmd` in the address bar and press Enter
4. Command Prompt will open in this folder

### Step 2: Initialize Git (if not already done)

```bash
git init
```

### Step 3: Add Your Forked Repository as Remote

Replace `YOUR-USERNAME` and `REPOSITORY-NAME` with your actual GitHub details:

```bash
git remote add origin https://github.com/YOUR-USERNAME/REPOSITORY-NAME.git
```

Example:
```bash
git remote add origin https://github.com/yourusername/inventory-management.git
```

### Step 4: Create .gitignore File

Before adding files, create a `.gitignore` to exclude unnecessary files:

```bash
echo PHPMailer/ > .gitignore
echo .DS_Store >> .gitignore
echo Thumbs.db >> .gitignore
echo *.log >> .gitignore
```

### Step 5: Add All Files

```bash
git add .
```

### Step 6: Commit Your Changes

```bash
git commit -m "Initial commit: Complete Inventory Management System with OTP verification"
```

### Step 7: Push to GitHub

```bash
git push -u origin main
```

Or if your branch is named `master`:

```bash
git push -u origin master
```

If prompted for credentials:
- Username: Your GitHub username
- Password: Use Personal Access Token (not your password)

---

## 🚀 Method 2: Using GitHub Desktop (Easier)

### Step 1: Download GitHub Desktop

1. Visit: https://desktop.github.com/
2. Download and install

### Step 2: Add Your Project

1. Open GitHub Desktop
2. Click "File" → "Add Local Repository"
3. Browse to: `C:\xampp\htdocs\inventory-system`
4. Click "Add Repository"

### Step 3: Publish to GitHub

1. Click "Publish repository"
2. Select your forked repository
3. Uncheck "Keep this code private" if you want it public
4. Click "Publish repository"

---

## 🚀 Method 3: Upload via GitHub Website (Simplest)

### Step 1: Prepare Files

1. Go to: `C:\xampp\htdocs\inventory-system`
2. Select all files and folders
3. Create a ZIP file (right-click → Send to → Compressed folder)

### Step 2: Upload to GitHub

1. Go to your forked repository on GitHub
2. Click "Add file" → "Upload files"
3. Drag and drop all files (or the ZIP file)
4. Add commit message: "Initial commit: Inventory Management System"
5. Click "Commit changes"

---

## 📋 Files to Include

### Essential Files:
- ✅ All `.php` files
- ✅ `database.sql`
- ✅ `style.css`
- ✅ `.htaccess`
- ✅ All folders: `auth/`, `config/`, `products/`, `includes/`
- ✅ Documentation files: `README.md`, `*.txt`, `*.md`

### Files to EXCLUDE:
- ❌ `PHPMailer/` folder (will be downloaded when needed)
- ❌ `.DS_Store` (Mac system file)
- ❌ `Thumbs.db` (Windows system file)
- ❌ Any `.log` files

---

## 🔧 Troubleshooting

### Error: "fatal: not a git repository"

Solution:
```bash
git init
```

### Error: "remote origin already exists"

Solution:
```bash
git remote remove origin
git remote add origin https://github.com/YOUR-USERNAME/REPOSITORY-NAME.git
```

### Error: "failed to push some refs"

Solution:
```bash
git pull origin main --allow-unrelated-histories
git push -u origin main
```

### Error: "Authentication failed"

Solution:
1. Go to GitHub → Settings → Developer settings
2. Generate Personal Access Token
3. Use token as password when pushing

---

## 📝 Recommended Commit Message

```
Initial commit: Complete Inventory Management System

Features:
- User registration with email OTP verification
- Secure login with password hashing
- Product CRUD operations (Create, Read, Update, Delete)
- Dashboard with statistics
- Email integration with PHPMailer
- Beautiful responsive UI
- MySQL database
- Session management
- Protected routes

Tech Stack:
- PHP 7.4+
- MySQL
- PHPMailer for email
- HTML/CSS/JavaScript
- Bootstrap-inspired design
```

---

## 🎯 After Upload

### Update README.md

Make sure your README includes:
1. Project description
2. Features list
3. Installation instructions
4. Database setup
5. Email configuration
6. Screenshots (optional)
7. Credits

### Add .gitignore

Create `.gitignore` file with:
```
PHPMailer/
.DS_Store
Thumbs.db
*.log
.env
```

### Create LICENSE (Optional)

Add a LICENSE file if you want to specify usage terms.

---

## 📸 Optional: Add Screenshots

1. Take screenshots of:
   - Login page
   - Registration page
   - OTP verification
   - Dashboard
   - Product management

2. Create `screenshots/` folder
3. Add images
4. Reference in README.md

---

## ✅ Verification Checklist

After uploading, verify:

- [ ] All PHP files uploaded
- [ ] database.sql uploaded
- [ ] style.css uploaded
- [ ] All folders present (auth, config, products, includes)
- [ ] README.md is visible
- [ ] Documentation files uploaded
- [ ] .gitignore created
- [ ] Repository is accessible
- [ ] Files are organized properly

---

## 🔗 Share Your Repository

After upload, share the link:
```
https://github.com/YOUR-USERNAME/REPOSITORY-NAME
```

---

## 💡 Pro Tips

1. **Commit Often**: Make small, frequent commits
2. **Write Clear Messages**: Describe what each commit does
3. **Use Branches**: Create branches for new features
4. **Update README**: Keep documentation current
5. **Add Comments**: Comment your code for others

---

## 🎉 Success!

Once uploaded, your project will be:
- ✅ Backed up on GitHub
- ✅ Accessible from anywhere
- ✅ Shareable with others
- ✅ Version controlled
- ✅ Collaborative ready

---

Last Updated: December 6, 2025
