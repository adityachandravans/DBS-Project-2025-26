<!DOCTYPE html>
<html>
<head>
    <title>Basic System Test</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .section { margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 5px; }
        h1 { color: #667eea; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Basic System Test</h1>
        
        <div class="section">
            <h2>1. PHP Version</h2>
            <?php
            echo "<p>PHP Version: <strong>" . phpversion() . "</strong></p>";
            if (version_compare(phpversion(), '7.0.0', '>=')) {
                echo "<p class='success'>✅ PHP version is compatible</p>";
            } else {
                echo "<p class='error'>❌ PHP 7.0+ required</p>";
            }
            ?>
        </div>
        
        <div class="section">
            <h2>2. Required Extensions</h2>
            <?php
            $extensions = ['mysqli', 'session'];
            foreach ($extensions as $ext) {
                if (extension_loaded($ext)) {
                    echo "<p class='success'>✅ $ext extension loaded</p>";
                } else {
                    echo "<p class='error'>❌ $ext extension NOT loaded</p>";
                }
            }
            ?>
        </div>
        
        <div class="section">
            <h2>3. File Structure</h2>
            <?php
            $files = [
                'config/db.php',
                'config/email.php',
                'auth/register.php',
                'auth/verify_otp.php',
                'auth/login.php'
            ];
            
            foreach ($files as $file) {
                if (file_exists($file)) {
                    echo "<p class='success'>✅ $file exists</p>";
                } else {
                    echo "<p class='error'>❌ $file NOT found</p>";
                }
            }
            ?>
        </div>
        
        <div class="section">
            <h2>4. Database Connection</h2>
            <?php
            if (file_exists('config/db.php')) {
                require_once 'config/db.php';
                
                if ($conn) {
                    echo "<p class='success'>✅ Database connected successfully</p>";
                    echo "<p>Database: <strong>" . DB_NAME . "</strong></p>";
                    
                    // Check users table
                    $result = @mysqli_query($conn, "SHOW TABLES LIKE 'users'");
                    if ($result && mysqli_num_rows($result) > 0) {
                        echo "<p class='success'>✅ Users table exists</p>";
                        
                        // Count users
                        $count_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
                        $count = mysqli_fetch_assoc($count_result)['count'];
                        echo "<p>Total users in database: <strong>$count</strong></p>";
                    } else {
                        echo "<p class='error'>❌ Users table NOT found. Please import database.sql</p>";
                    }
                    
                    // Check products table
                    $result = @mysqli_query($conn, "SHOW TABLES LIKE 'products'");
                    if ($result && mysqli_num_rows($result) > 0) {
                        echo "<p class='success'>✅ Products table exists</p>";
                    } else {
                        echo "<p class='error'>❌ Products table NOT found. Please import database.sql</p>";
                    }
                } else {
                    echo "<p class='error'>❌ Database connection failed</p>";
                    echo "<p>Error: " . mysqli_connect_error() . "</p>";
                }
            } else {
                echo "<p class='error'>❌ config/db.php not found</p>";
            }
            ?>
        </div>
        
        <div class="section">
            <h2>5. Session Test</h2>
            <?php
            session_start();
            if (session_status() === PHP_SESSION_ACTIVE) {
                echo "<p class='success'>✅ Session working</p>";
                
                // Test session write
                $_SESSION['test'] = 'working';
                if (isset($_SESSION['test']) && $_SESSION['test'] === 'working') {
                    echo "<p class='success'>✅ Session read/write working</p>";
                    unset($_SESSION['test']);
                } else {
                    echo "<p class='error'>❌ Session read/write failed</p>";
                }
            } else {
                echo "<p class='error'>❌ Session NOT working</p>";
            }
            ?>
        </div>
        
        <div class="section" style="background: #e8f5e9;">
            <h2>✅ Next Steps</h2>
            <?php
            $all_good = true;
            
            // Check critical items
            if (!$conn) $all_good = false;
            if (!file_exists('config/db.php')) $all_good = false;
            if (!file_exists('auth/register.php')) $all_good = false;
            
            if ($all_good) {
                echo "<p class='success'>✅ All basic checks passed!</p>";
                echo "<p>You can now:</p>";
                echo "<ol>";
                echo "<li><a href='auth/register.php'>Go to Registration Page</a></li>";
                echo "<li><a href='debug_registration.php'>Use Debug Registration Tool</a></li>";
                echo "<li><a href='index.php'>Visit Home Page</a></li>";
                echo "</ol>";
            } else {
                echo "<p class='error'>❌ Some checks failed. Please fix the errors above.</p>";
                echo "<p><strong>Common fixes:</strong></p>";
                echo "<ul>";
                echo "<li>Make sure MySQL is running in XAMPP</li>";
                echo "<li>Import database.sql in phpMyAdmin</li>";
                echo "<li>Check file paths are correct</li>";
                echo "</ul>";
            }
            ?>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php" style="display: inline-block; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;">Go to Home Page</a>
            <a href="debug_registration.php" style="display: inline-block; padding: 12px 30px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">Debug Registration</a>
        </div>
    </div>
</body>
</html>
