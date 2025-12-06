@echo off
echo ========================================
echo   Git Upload Script
echo   Inventory Management System
echo ========================================
echo.

REM Check if git is installed
git --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Git is not installed!
    echo Please install Git from: https://git-scm.com/download/win
    pause
    exit /b 1
)

echo Git is installed. Proceeding...
echo.

REM Prompt for GitHub repository URL
set /p REPO_URL="Enter your GitHub repository URL (e.g., https://github.com/username/repo.git): "

if "%REPO_URL%"=="" (
    echo ERROR: Repository URL cannot be empty!
    pause
    exit /b 1
)

echo.
echo ========================================
echo Step 1: Initializing Git repository...
echo ========================================
git init

echo.
echo ========================================
echo Step 2: Adding remote repository...
echo ========================================
git remote remove origin 2>nul
git remote add origin %REPO_URL%

echo.
echo ========================================
echo Step 3: Adding all files...
echo ========================================
git add .

echo.
echo ========================================
echo Step 4: Committing changes...
echo ========================================
git commit -m "Initial commit: Complete Inventory Management System with OTP verification"

echo.
echo ========================================
echo Step 5: Pushing to GitHub...
echo ========================================
echo.
echo NOTE: You may be prompted for GitHub credentials
echo Username: Your GitHub username
echo Password: Use Personal Access Token (not your password)
echo.
echo To create a token: GitHub Settings > Developer settings > Personal access tokens
echo.
pause

git push -u origin main

if errorlevel 1 (
    echo.
    echo Push to 'main' branch failed. Trying 'master' branch...
    git push -u origin master
)

echo.
echo ========================================
echo Upload Complete!
echo ========================================
echo.
echo Your project has been uploaded to:
echo %REPO_URL%
echo.
echo Visit your repository on GitHub to verify!
echo.
pause
