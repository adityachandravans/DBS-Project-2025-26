<?php
/**
 * Email Testing Script
 * Use this to test if email sending is working
 * Access: http://localhost/[your-folder]/test_email.php
 */

require_once 'config/email.php';

$test_result = '';
$email_sent = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $test_email = $_POST['test_email'];
    
    if (filter_var($test_email, FILTER_VALIDATE_EMAIL)) {
        // Test OTP email
        $test_otp = "123456";
        $test_username = "Test User";
        
        if (sendOTPEmail($test_email, $test_otp, $test_username)) {
            $test_result = "✓ Email sent successfully to: " . htmlspecialchars($test_email);
            $email_sent = true;
        } else {
            $test_result = "✗ Failed to send email. Check your SMTP configuration.";
        }
    } else {
        $test_result = "✗ Invalid email address";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Test - Inventory System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="logo">📧</div>
            <h2 class="text-center">Email Configuration Test</h2>
            
            <p style="text-align: center; color: #666; margin-bottom: 30px;">
                Test if email sending is working correctly
            </p>
            
            <?php if ($test_result): ?>
                <div class="alert <?php echo $email_sent ? 'alert-success' : 'alert-error'; ?>">
                    <?php echo $test_result; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>📧 Test Email Address</label>
                    <input type="email" name="test_email" placeholder="Enter your email" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    Send Test Email
                </button>
            </form>
            
            <div style="margin-top: 30px; padding: 20px; background: #f8f9ff; border-radius: 10px;">
                <h3 style="color: #667eea; margin-bottom: 15px;">📋 Current Configuration</h3>
                <table style="width: 100%; font-size: 14px;">
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>SMTP Host:</strong></td>
                        <td style="padding: 8px;"><?php echo SMTP_HOST; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>SMTP Port:</strong></td>
                        <td style="padding: 8px;"><?php echo SMTP_PORT; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>From Email:</strong></td>
                        <td style="padding: 8px;"><?php echo SMTP_FROM_EMAIL; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>PHPMailer:</strong></td>
                        <td style="padding: 8px;">
                            <?php 
                            if (file_exists('PHPMailer/PHPMailer.php')) {
                                echo '<span style="color: green;">✅ Installed</span>';
                            } else {
                                echo '<span style="color: orange;">⚠️ Not installed</span> <a href="install_phpmailer.php" style="color: #667eea;">Install Now</a>';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background: #d4edda; border-radius: 10px; border-left: 4px solid #28a745;">
                <p style="margin: 0; color: #155724; font-size: 14px;">
                    <strong>✅ Using PHPMailer:</strong> Emails will be sent via Gmail SMTP using PHPMailer library.
                    <?php if (!file_exists('PHPMailer/PHPMailer.php')): ?>
                    <br><br><a href="install_phpmailer.php" style="color: #667eea; font-weight: bold;">Click here to install PHPMailer</a>
                    <?php endif; ?>
                </p>
            </div>
            
            <p class="text-center mt-20">
                <a href="index.php" style="color: #667eea;">← Back to Application</a>
            </p>
        </div>
    </div>
</body>
</html>
