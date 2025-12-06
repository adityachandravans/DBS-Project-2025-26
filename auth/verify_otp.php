<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Check if config files exist
if (!file_exists('../config/db.php')) {
    die('Error: Database configuration file not found.');
}
if (!file_exists('../config/email.php')) {
    die('Error: Email configuration file not found.');
}

require_once '../config/db.php';
require_once '../config/email.php';

// Check database connection
if (!$conn) {
    die('Error: Database connection failed.');
}

// Check if user came from registration
if (!isset($_SESSION['verify_email']) || !isset($_SESSION['verify_username'])) {
    $_SESSION['error_message'] = "Please register first to verify your email.";
    header("Location: register.php");
    exit();
}

$email = $_SESSION['verify_email'];
$username = $_SESSION['verify_username'];
$error = '';
$success = '';

// Handle OTP verification
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_otp'])) {
    $otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'] . $_POST['otp6'];
    
    if (strlen($otp) != 6) {
        $error = "Please enter complete OTP";
    } else {
        $query = "SELECT * FROM users WHERE email = '$email' AND otp = '$otp'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Check if OTP is expired
            if (strtotime($user['otp_expiry']) < time()) {
                $error = "OTP has expired. Please request a new one.";
            } else {
                // Verify user
                $update_query = "UPDATE users SET is_verified = 1, otp = NULL, otp_expiry = NULL WHERE email = '$email'";
                if (mysqli_query($conn, $update_query)) {
                    // Send welcome email
                    sendWelcomeEmail($email, $username);
                    
                    // Clear session
                    unset($_SESSION['verify_email']);
                    unset($_SESSION['verify_username']);
                    
                    $_SESSION['verification_success'] = true;
                    header("Location: login.php");
                    exit();
                }
            }
        } else {
            $error = "Invalid OTP. Please try again.";
        }
    }
}

// Handle resend OTP
if (isset($_POST['resend_otp'])) {
    $otp = sprintf("%06d", mt_rand(1, 999999));
    $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
    
    $update_query = "UPDATE users SET otp = '$otp', otp_expiry = '$otp_expiry' WHERE email = '$email'";
    if (mysqli_query($conn, $update_query)) {
        $emailSent = sendOTPEmail($email, $otp, $username);
        if ($emailSent) {
            $success = "✅ New OTP has been sent to your email!";
        } else {
            // Development mode: Show OTP if email fails
            $success = "⚠️ Email not configured. Your new OTP is: <strong style='font-size: 20px; letter-spacing: 2px;'>$otp</strong>";
        }
    } else {
        $error = "Failed to generate new OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Inventory System</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .otp-container {
            text-align: center;
        }
        .email-display {
            background: #f8f9ff;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            color: #667eea;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="logo">📧</div>
            <h2 class="text-center">Verify Your Email</h2>
            
            <?php if (isset($_SESSION['registration_success'])): ?>
                <div class="alert alert-success">
                    ✅ Registration successful! Please check your email for the OTP code.
                </div>
                <?php unset($_SESSION['registration_success']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['debug_otp'])): ?>
                <div class="alert alert-error" style="background: #fff3cd; border-color: #ffc107; color: #856404;">
                    ⚠️ <strong>Development Mode:</strong> Email not configured. Your OTP is: <strong style="font-size: 24px; letter-spacing: 3px;"><?php echo $_SESSION['debug_otp']; ?></strong>
                    <br><small>Configure email in config/email.php and XAMPP settings to send real emails.</small>
                </div>
                <?php unset($_SESSION['debug_otp']); ?>
            <?php endif; ?>
            
            <div class="email-display">
                <?php echo htmlspecialchars($email); ?>
            </div>
            
            <p class="text-center" style="color: #666; margin-bottom: 30px;">
                We've sent a 6-digit OTP to your email.<br>
                Please enter it below to verify your account.
            </p>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" class="otp-container">
                <div class="otp-input-group">
                    <input type="text" class="otp-input" name="otp1" maxlength="1" pattern="[0-9]" required autofocus>
                    <input type="text" class="otp-input" name="otp2" maxlength="1" pattern="[0-9]" required>
                    <input type="text" class="otp-input" name="otp3" maxlength="1" pattern="[0-9]" required>
                    <input type="text" class="otp-input" name="otp4" maxlength="1" pattern="[0-9]" required>
                    <input type="text" class="otp-input" name="otp5" maxlength="1" pattern="[0-9]" required>
                    <input type="text" class="otp-input" name="otp6" maxlength="1" pattern="[0-9]" required>
                </div>
                
                <button type="submit" name="verify_otp" class="btn btn-primary" style="width: 100%; margin-top: 20px;">
                    Verify OTP
                </button>
            </form>
            
            <div class="text-center mt-20">
                <p style="color: #666;">Didn't receive the code?</p>
                <form method="POST" action="" style="display: inline;">
                    <button type="submit" name="resend_otp" class="resend-link" style="background: none; border: none; cursor: pointer; font-size: 15px;">
                        Resend OTP
                    </button>
                </form>
            </div>
            
            <p class="text-center mt-20">
                <a href="register.php" style="color: #667eea;">← Back to Registration</a>
            </p>
        </div>
    </div>
    
    <script>
        // Auto-focus next input
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
            
            // Only allow numbers
            input.addEventListener('keypress', (e) => {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
