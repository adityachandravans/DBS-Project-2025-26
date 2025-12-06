<?php
/**
 * Setup Verification Script
 * Run this file to verify your installation is correct
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Setup Verification</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        h1 { color: #667eea; }
        .check { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        .section { margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 5px; }
        ul { list-style: none; padding: 0; }
        li { padding: 8px 0; border-bottom: 1px solid #eee; }
        li:last-child { border-bottom: none; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔍 Setup Verification</h1>";

// Check PHP version
echo "<div class='section'>";
echo "<h2>PHP Configuration</h2>";
echo "<ul>";
echo "<li>PHP Version: " . phpversion();
if (version_compare(phpversion(), '7.0.0', '>=')) {
    echo " <span class='check'>✓ OK</span>";
} else {
    echo " <span class='error'>✗ PHP 7.0+ required</span>";
}
echo "</li>";

// Check required extensions
$extensions = ['mysqli', 'session'];
foreach ($extensions as $ext) {
    echo "<li>Extension '$ext': ";
    if (extension_loaded($ext)) {
        echo "<span class='check'>✓ Loaded</span>";
    } else {
        echo "<span class='error'>✗ Not loaded</span>";
    }
    echo "</li>";
}
echo "</ul></div>";

// Check database connection
echo "<div class='section'>";
echo "<h2>Database Connection</h2>";
echo "<ul>";
require_once 'config/db.php';
if ($conn) {
    echo "<li>MySQL Connection: <span class='check'>✓ Connected</span></li>";
    echo "<li>Database: " . DB_NAME . " <span class='check'>✓ Selected</span></li>";
    
    // Check tables
    $tables = ['users', 'products'];
    foreach ($tables as $table) {
        $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        echo "<li>Table '$table': ";
        if (mysqli_num_rows($result) > 0) {
            echo "<span class='check'>✓ Exists</span>";
        } else {
            echo "<span class='error'>✗ Missing (Run database.sql)</span>";
        }
        echo "</li>";
    }
} else {
    echo "<li>MySQL Connection: <span class='error'>✗ Failed</span></li>";
    echo "<li>Error: " . mysqli_connect_error() . "</li>";
}
echo "</ul></div>";

// Check email configuration
echo "<div class='section'>";
echo "<h2>Email Configuration</h2>";
echo "<ul>";
require_once 'config/email.php';
echo "<li>SMTP Host: " . SMTP_HOST . "</li>";
echo "<li>SMTP Port: " . SMTP_PORT . "</li>";
echo "<li>From Email: " . SMTP_FROM_EMAIL . "</li>";
if (SMTP_USERNAME && SMTP_PASSWORD) {
    echo "<li>Credentials: <span class='check'>✓ Configured</span></li>";
} else {
    echo "<li>Credentials: <span class='warning'>⚠ Not configured</span></li>";
}
echo "</ul></div>";

// Check file structure
echo "<div class='section'>";
echo "<h2>File Structure</h2>";
echo "<ul>";
$required_files = [
    'index.php',
    'dashboard.php',
    'auth/login.php',
    'auth/register.php',
    'auth/verify_otp.php',
    'auth/logout.php',
    'products/index.php',
    'products/add.php',
    'products/edit.php',
    'products/delete.php',
    'config/db.php',
    'config/email.php',
    'style.css'
];

foreach ($required_files as $file) {
    echo "<li>$file: ";
    if (file_exists($file)) {
        echo "<span class='check'>✓ Exists</span>";
    } else {
        echo "<span class='error'>✗ Missing</span>";
    }
    echo "</li>";
}
echo "</ul></div>";

// Check permissions
echo "<div class='section'>";
echo "<h2>Session Configuration</h2>";
echo "<ul>";
echo "<li>Session Support: ";
if (function_exists('session_start')) {
    echo "<span class='check'>✓ Available</span>";
} else {
    echo "<span class='error'>✗ Not available</span>";
}
echo "</li>";
echo "<li>Session Save Path: " . session_save_path() . "</li>";
echo "</ul></div>";

// Summary
echo "<div class='section' style='background: #e8f5e9;'>";
echo "<h2>✅ Next Steps</h2>";
echo "<ol style='list-style: decimal; padding-left: 20px;'>";
echo "<li>If all checks pass, visit <a href='index.php'>index.php</a> to start</li>";
echo "<li>Register a new account at <a href='auth/register.php'>register.php</a></li>";
echo "<li>Check your email for OTP verification code</li>";
echo "<li>Login and start managing your inventory!</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin-top: 30px; color: #666;'>";
echo "<p>For detailed testing instructions, see <strong>TEST_FLOW.md</strong></p>";
echo "</div>";

echo "</div></body></html>";
?>
