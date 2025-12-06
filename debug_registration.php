<?php
/**
 * Debug Registration - Test all components
 */
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Registration</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .debug-section { margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 10px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        .code { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto; }
        pre { margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>🔍 Registration Debug Tool</h1>
            <p>This page will help identify why registration isn't redirecting properly.</p>
            
            <!-- Test 1: Database Connection -->
            <div class="debug-section">
                <h2>1. Database Connection</h2>
                <?php
                require_once 'config/db.php';
                if ($conn) {
                    echo "<p class='success'>✅ Database connected successfully</p>";
                    echo "<p>Host: " . DB_HOST . "</p>";
                    echo "<p>Database: " . DB_NAME . "</p>";
                    
                    // Check if users table exists
                    $result = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
                    if (mysqli_num_rows($result) > 0) {
                        echo "<p class='success'>✅ Users table exists</p>";
                        
                        // Check table structure
                        $result = mysqli_query($conn, "DESCRIBE users");
                        echo "<p><strong>Table Structure:</strong></p>";
                        echo "<table style='width: 100%; border-collapse: collapse;'>";
                        echo "<tr style='background: #667eea; color: white;'><th style='padding: 10px; text-align: left;'>Field</th><th style='padding: 10px; text-align: left;'>Type</th><th style='padding: 10px; text-align: left;'>Null</th></tr>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr style='border-bottom: 1px solid #ddd;'>";
                            echo "<td style='padding: 8px;'>" . $row['Field'] . "</td>";
                            echo "<td style='padding: 8px;'>" . $row['Type'] . "</td>";
                            echo "<td style='padding: 8px;'>" . $row['Null'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p class='error'>❌ Users table does NOT exist. Please import database.sql</p>";
                    }
                } else {
                    echo "<p class='error'>❌ Database connection failed: " . mysqli_connect_error() . "</p>";
                }
                ?>
            </div>
            
            <!-- Test 2: Email Configuration -->
            <div class="debug-section">
                <h2>2. Email Configuration</h2>
                <?php
                require_once 'config/email.php';
                echo "<p><strong>SMTP Settings:</strong></p>";
                echo "<ul>";
                echo "<li>Host: " . SMTP_HOST . "</li>";
                echo "<li>Port: " . SMTP_PORT . "</li>";
                echo "<li>Username: " . SMTP_USERNAME . "</li>";
                echo "<li>From Email: " . SMTP_FROM_EMAIL . "</li>";
                echo "</ul>";
                
                if (function_exists('mail')) {
                    echo "<p class='success'>✅ PHP mail() function is available</p>";
                } else {
                    echo "<p class='error'>❌ PHP mail() function is NOT available</p>";
                }
                
                echo "<p class='warning'>⚠️ Note: Email may not work without proper XAMPP configuration.</p>";
                echo "<p>For development, the system will show OTP on screen if email fails.</p>";
                ?>
            </div>
            
            <!-- Test 3: Session -->
            <div class="debug-section">
                <h2>3. Session Configuration</h2>
                <?php
                if (session_status() === PHP_SESSION_ACTIVE) {
                    echo "<p class='success'>✅ Session is active</p>";
                    echo "<p>Session ID: " . session_id() . "</p>";
                    
                    if (!empty($_SESSION)) {
                        echo "<p><strong>Current Session Data:</strong></p>";
                        echo "<div class='code'><pre>" . print_r($_SESSION, true) . "</pre></div>";
                    } else {
                        echo "<p>No session data currently stored.</p>";
                    }
                } else {
                    echo "<p class='error'>❌ Session is NOT active</p>";
                }
                ?>
            </div>
            
            <!-- Test 4: File Permissions -->
            <div class="debug-section">
                <h2>4. File Structure</h2>
                <?php
                $files = [
                    'auth/register.php',
                    'auth/verify_otp.php',
                    'auth/login.php',
                    'config/db.php',
                    'config/email.php'
                ];
                
                echo "<ul>";
                foreach ($files as $file) {
                    if (file_exists($file)) {
                        echo "<li class='success'>✅ $file exists</li>";
                    } else {
                        echo "<li class='error'>❌ $file NOT found</li>";
                    }
                }
                echo "</ul>";
                ?>
            </div>
            
            <!-- Test 5: Test Registration -->
            <div class="debug-section">
                <h2>5. Test Registration Flow</h2>
                <p>Try registering with the form below. Watch for any errors.</p>
                
                <?php
                $test_error = '';
                $test_success = '';
                
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['test_register'])) {
                    $username = mysqli_real_escape_string($conn, $_POST['username']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $password = $_POST['password'];
                    
                    echo "<div class='code'><pre>";
                    echo "Step 1: Form submitted\n";
                    echo "Username: $username\n";
                    echo "Email: $email\n";
                    echo "Password length: " . strlen($password) . "\n\n";
                    
                    // Check if email exists
                    $check_query = "SELECT id FROM users WHERE email = '$email'";
                    $result = mysqli_query($conn, $check_query);
                    echo "Step 2: Checking if email exists... ";
                    
                    if (mysqli_num_rows($result) > 0) {
                        echo "Email already exists!\n";
                        $test_error = "Email already registered. Use a different email.";
                    } else {
                        echo "Email available\n\n";
                        
                        // Generate OTP
                        $otp = sprintf("%06d", mt_rand(1, 999999));
                        $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
                        echo "Step 3: Generated OTP: $otp\n";
                        echo "OTP Expiry: $otp_expiry\n\n";
                        
                        // Hash password
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        echo "Step 4: Password hashed\n\n";
                        
                        // Insert into database
                        $query = "INSERT INTO users (username, email, password, otp, otp_expiry, is_verified) 
                                  VALUES ('$username', '$email', '$hashed_password', '$otp', '$otp_expiry', 0)";
                        
                        echo "Step 5: Inserting into database... ";
                        if (mysqli_query($conn, $query)) {
                            echo "SUCCESS!\n";
                            $user_id = mysqli_insert_id($conn);
                            echo "New user ID: $user_id\n\n";
                            
                            // Try to send email
                            echo "Step 6: Attempting to send email... ";
                            $emailSent = sendOTPEmail($email, $otp, $username);
                            if ($emailSent) {
                                echo "Email sent successfully!\n\n";
                            } else {
                                echo "Email failed (this is OK for development)\n\n";
                            }
                            
                            // Set session
                            echo "Step 7: Setting session variables\n";
                            $_SESSION['verify_email'] = $email;
                            $_SESSION['verify_username'] = $username;
                            $_SESSION['registration_success'] = true;
                            $_SESSION['debug_otp'] = $otp;
                            echo "Session set successfully\n\n";
                            
                            echo "Step 8: Ready to redirect to verify_otp.php\n";
                            $test_success = "Registration successful! Your OTP is: <strong>$otp</strong>";
                            
                            echo "\n✅ ALL STEPS COMPLETED SUCCESSFULLY!\n";
                            echo "\nYou should now be able to:\n";
                            echo "1. Click the link below to go to verification page\n";
                            echo "2. Enter the OTP: $otp\n";
                            echo "3. Complete verification\n";
                        } else {
                            echo "FAILED!\n";
                            echo "Error: " . mysqli_error($conn) . "\n";
                            $test_error = "Database insert failed: " . mysqli_error($conn);
                        }
                    }
                    
                    echo "</pre></div>";
                }
                ?>
                
                <?php if ($test_error): ?>
                    <div class="alert alert-error"><?php echo $test_error; ?></div>
                <?php endif; ?>
                
                <?php if ($test_success): ?>
                    <div class="alert alert-success">
                        <?php echo $test_success; ?>
                        <br><br>
                        <a href="auth/verify_otp.php" class="btn btn-primary">Go to Verification Page →</a>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" style="margin-top: 20px;">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="testuser<?php echo rand(1, 999); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="test<?php echo rand(1, 999); ?>@example.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" value="test123" required>
                    </div>
                    
                    <button type="submit" name="test_register" class="btn btn-success">Test Registration</button>
                </form>
            </div>
            
            <!-- Quick Links -->
            <div class="debug-section">
                <h2>6. Quick Links</h2>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="index.php" class="btn btn-primary">Home Page</a>
                    <a href="auth/register.php" class="btn btn-primary">Registration Page</a>
                    <a href="auth/verify_otp.php" class="btn btn-primary">Verification Page</a>
                    <a href="auth/login.php" class="btn btn-primary">Login Page</a>
                    <a href="verify_setup.php" class="btn btn-primary">Setup Verification</a>
                </div>
            </div>
            
            <!-- Instructions -->
            <div class="debug-section" style="background: #e8f5e9;">
                <h2>📋 How to Fix Registration Issues</h2>
                <ol>
                    <li><strong>Database:</strong> Make sure MySQL is running and database.sql is imported</li>
                    <li><strong>Email:</strong> Email configuration is optional for development - OTP will show on screen</li>
                    <li><strong>Test:</strong> Use the test form above to see detailed step-by-step process</li>
                    <li><strong>Register:</strong> Go to <a href="auth/register.php">register.php</a> and create account</li>
                    <li><strong>Verify:</strong> You'll be redirected to verify_otp.php with OTP shown on screen</li>
                    <li><strong>Login:</strong> After verification, login and access dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</body>
</html>
