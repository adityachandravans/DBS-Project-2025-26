<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Check if config files exist
if (!file_exists('../config/db.php')) {
    die('Error: Database configuration file not found. Please check config/db.php exists.');
}
if (!file_exists('../config/email.php')) {
    die('Error: Email configuration file not found. Please check config/email.php exists.');
}

require_once '../config/db.php';
require_once '../config/email.php';

// Check database connection
if (!$conn) {
    die('Error: Database connection failed. Please check your database settings in config/db.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        // Check if email already exists
        $check_query = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($result) > 0) {
            $error = "Email already registered";
        } else {
            // Generate 6-digit OTP
            $otp = sprintf("%06d", mt_rand(1, 999999));
            $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, email, password, otp, otp_expiry, is_verified) 
                      VALUES ('$username', '$email', '$hashed_password', '$otp', '$otp_expiry', 0)";
            
            if (mysqli_query($conn, $query)) {
                // Try to send OTP email
                $emailSent = sendOTPEmail($email, $otp, $username);
                
                // For development: Allow registration even if email fails
                // Comment out the next 3 lines in production to enforce email verification
                if (!$emailSent) {
                    $error = "⚠️ Email sending failed, but registration completed. Your OTP is: <strong>$otp</strong> (Valid for 10 minutes). <a href='verify_otp.php' style='color: #667eea;'>Click here to verify</a>";
                }
                
                // Set session and redirect
                $_SESSION['verify_email'] = $email;
                $_SESSION['verify_username'] = $username;
                $_SESSION['registration_success'] = true;
                $_SESSION['debug_otp'] = $otp; // For development only - remove in production
                
                // Redirect to verification page
                header("Location: verify_otp.php");
                exit();
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Inventory System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="logo">📦</div>
            <h2 class="text-center">Create Account</h2>
            
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" id="registerForm">
                <div class="form-group">
                    <label>👤 Username</label>
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>
                
                <div class="form-group">
                    <label>📧 Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label>🔒 Password</label>
                    <input type="password" name="password" placeholder="Minimum 6 characters" minlength="6" required>
                </div>
                
                <div class="form-group">
                    <label>🔒 Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Re-enter password" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Create Account</button>
            </form>
            
            <p class="text-center mt-20">
                Already have an account? <a href="login.php">Login here</a>
            </p>
        </div>
    </div>
</body>
</html>
