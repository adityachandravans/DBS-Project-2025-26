<?php
/**
 * Database Connection Test Script
 * Run this file to verify your XAMPP setup is working correctly
 * Access: http://localhost/[your-folder]/test_connection.php
 */

echo "<h2>XAMPP & Database Connection Test</h2>";
echo "<hr>";

// Test 1: PHP Version
echo "<h3>✓ Test 1: PHP Version</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Status: <strong style='color: green;'>OK</strong><br><br>";

// Test 2: Required Extensions
echo "<h3>✓ Test 2: Required Extensions</h3>";
$extensions = ['mysqli', 'session'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? "<strong style='color: green;'>Loaded</strong>" : "<strong style='color: red;'>Missing</strong>";
    echo "$ext: $status<br>";
}
echo "<br>";

// Test 3: Database Connection
echo "<h3>✓ Test 3: Database Connection</h3>";
require_once 'config/db.php';

if ($conn) {
    echo "Status: <strong style='color: green;'>Connected Successfully!</strong><br>";
    echo "Host: " . DB_HOST . "<br>";
    echo "Database: " . DB_NAME . "<br><br>";
    
    // Test 4: Check Tables
    echo "<h3>✓ Test 4: Database Tables</h3>";
    
    $tables = ['users', 'products'];
    foreach ($tables as $table) {
        $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        if (mysqli_num_rows($result) > 0) {
            echo "$table table: <strong style='color: green;'>Exists</strong><br>";
        } else {
            echo "$table table: <strong style='color: red;'>Missing</strong> (Import database.sql)<br>";
        }
    }
    
    mysqli_close($conn);
} else {
    echo "Status: <strong style='color: red;'>Connection Failed!</strong><br>";
    echo "Error: " . mysqli_connect_error() . "<br>";
    echo "<br><strong>Solutions:</strong><br>";
    echo "1. Make sure MySQL is running in XAMPP Control Panel<br>";
    echo "2. Import database.sql in phpMyAdmin<br>";
    echo "3. Check config/db.php settings<br>";
}

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<ul>";
echo "<li>If all tests pass, <a href='index.php' style='color: #667eea; font-weight: bold;'>Go to Application</a></li>";
echo "<li>Test email functionality: <a href='test_email.php' style='color: #667eea; font-weight: bold;'>Test Email</a></li>";
echo "<li>If database tables are missing, import database.sql in phpMyAdmin</li>";
echo "<li>Configure email settings (see EMAIL_SETUP_GUIDE.txt)</li>";
echo "<li>Delete test files after verification (test_connection.php, test_email.php)</li>";
echo "</ul>";

echo "<div style='margin-top: 30px; padding: 20px; background: #f8f9ff; border-radius: 10px; border-left: 4px solid #667eea;'>";
echo "<h3 style='color: #667eea; margin-top: 0;'>🎨 New Features</h3>";
echo "<ul style='color: #555;'>";
echo "<li>✓ Modern gradient UI design</li>";
echo "<li>✓ Email verification with OTP</li>";
echo "<li>✓ Beautiful email templates</li>";
echo "<li>✓ Responsive design</li>";
echo "<li>✓ Enhanced user experience</li>";
echo "</ul>";
echo "</div>";
?>
