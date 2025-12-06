@echo off
echo ========================================
echo   Uploading to GitHub
echo   DBS-Project-2025-26
echo ========================================
echo.
echo Repository: https://github.com/adityachandravans/DBS-Project-2025-26.git
echo.

REM Check if git is installed
git --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Git is not installed!
    echo.
    echo Please install Git first:
    echo 1. Visit: https://git-scm.com/download/win
    echo 2. Download and install Git for Windows
    echo 3. Run this script again
    echo.
    pause
    exit /b 1
)

echo [OK] Git is installed
echo.

echo ========================================
echo Step 1: Initializing Git repository...
echo ========================================
git init
echo [OK] Repository initialized
echo.

echo ========================================
echo Step 2: Adding remote repository...
echo ========================================
git remote remove origin 2>nul
git remote add origin https://github.com/adityachandravans/DBS-Project-2025-26.git
echo [OK] Remote repository added
echo.

echo ========================================
echo Step 3: Adding all files...
echo ========================================
git add .
echo [OK] Files staged for commit
echo.

echo ========================================
echo Step 4: Committing changes...
echo ========================================
git commit -m "Add Inventory Management System with OTP Email Verification"
echo [OK] Changes committed
echo.

echo ========================================
echo Step 5: Pushing to GitHub...
echo ========================================
echo.
echo IMPORTANT: You will be prompted for GitHub credentials
echo.
echo Username: adityachandravans
echo Password: Use your Personal Access Token (NOT your GitHub password)
echo.
echo To create a Personal Access Token:
echo 1. Go to: https://github.com/settings/tokens
echo 2. Click "Generate new token (classic)"
echo 3. Give it a name: "DBS Project Upload"
echo 4. Select scope: repo (check all repo boxes)
echo 5. Click "Generate token"
echo 6. COPY the token and use it as password below
echo.
pause

git push -u origin main

if errorlevel 1 (
    echo.
    echo Push to 'main' branch failed. Trying 'master' branch...
    git push -u origin master
    
    if errorlevel 1 (
        echo.
        echo ========================================
        echo Upload Failed!
        echo ========================================
        echo.
        echo Possible reasons:
        echo 1. Wrong credentials
        echo 2. Need to use Personal Access Token instead of password
        echo 3. Repository doesn't exist or no access
        echo.
        echo Please check and try again.
        pause
        exit /b 1
    )
)

echo.
echo ========================================
echo SUCCESS! Upload Complete!
echo ========================================
echo.
echo Your project has been uploaded to:
echo https://github.com/adityachandravans/DBS-Project-2025-26
echo.
echo Visit the repository to verify all files are there!
echo.
pause
