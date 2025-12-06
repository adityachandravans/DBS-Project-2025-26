<?php
/**
 * Real Email Test - Send actual email via Gmail
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$result = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $to_email = $_POST['email'];
    
    // Load PHPMailer
    require_once 'PHPMailer/PHPMailer.php';
    require_once 'PHPMailer/SMTP.php';
    require_once 'PHPMailer/Exception.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->SMTPDebug = 2; // Enable verbose debug output
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'seminarmanagement143@gmail.com';
        $mail->Password   = 'atkiotfaccnmpiql';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        // Recipients
        $mail->setFrom('seminarmanagement143@gmail.com', 'Inventory Management System');
        $mail->addAddress($to_email);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Test Email - OTP Verification';
        $mail->Body    = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 30px auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; color: white; }
                .content { padding: 40px 30px; }
                .otp-box { background: #f8f9ff; border: 2px dashed #667eea; border-radius: 10px; padding: 20px; text-align: center; margin: 30px 0; }
                .otp-code { font-size: 36px; font-weight: bold; color: #667eea; letter-spacing: 8px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>🔐 Test Email</h1>
                </div>
                <div class="content">
                    <h2>Email Configuration Test</h2>
                    <p>This is a test email from your Inventory Management System.</p>
                    <p>If you received this email, your email configuration is working correctly!</p>
                    
                    <div class="otp-box">
                        <div class="otp-code">123456</div>
                        <p style="margin: 10px 0 0 0; color: #666;">Sample OTP Code</p>
                    </div>
                    
                    <p><strong>Configuration Details:</strong></p>
                    <ul>
                        <li>SMTP Host: smtp.gmail.com</li>
                        <li>Port: 587</li>
                        <li>Email: seminarmanagement143@gmail.com</li>
                        <li>Encryption: STARTTLS</li>
                    </ul>
                    
                    <p>Best regards,<br>Inventory Management Team</p>
                </div>
            </div>
        </body>
        </html>
        ';
        
        $mail->send();
        $result = '✅ Email sent successfully! Check your inbox (and spam folder).';
        $success = true;
    } catch (Exception $e) {
        $result = "❌ Email could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Real Email</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .debug-output { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto; margin: 20px 0; font-size: 12px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>📧 Test Real Email Sending</h1>
            <p>This will send a real email via Gmail SMTP using PHPMailer.</p>
            
            <?php if ($result): ?>
                <div class="alert <?php echo $success ? 'alert-success' : 'alert-error'; ?>">
                    <?php echo $result; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>📧 Your Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    <small style="color: #666;">Enter the email where you want to receive the test OTP</small>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    📨 Send Test Email Now
                </button>
            </form>
            
            <div style="margin-top: 30px; padding: 20px; background: #f8f9ff; border-radius: 10px;">
                <h3 style="color: #667eea;">📋 Current Configuration</h3>
                <table style="width: 100%; font-size: 14px;">
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>PHPMailer Status:</strong></td>
                        <td style="padding: 8px;">
                            <?php 
                            if (file_exists('PHPMailer/PHPMailer.php')) {
                                echo '<span style="color: green; font-weight: bold;">✅ Installed (' . number_format(filesize('PHPMailer/PHPMailer.php')) . ' bytes)</span>';
                            } else {
                                echo '<span style="color: red; font-weight: bold;">❌ Not Installed</span>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>SMTP Host:</strong></td>
                        <td style="padding: 8px;">smtp.gmail.com</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>Port:</strong></td>
                        <td style="padding: 8px;">587 (STARTTLS)</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>From Email:</strong></td>
                        <td style="padding: 8px;">seminarmanagement143@gmail.com</td>
                    </tr>
                </table>
            </div>
            
            <?php if ($success): ?>
            <div style="margin-top: 20px; padding: 20px; background: #d4edda; border-radius: 10px; border-left: 4px solid #28a745;">
                <h3 style="color: #155724; margin-top: 0;">🎉 Success! What's Next?</h3>
                <ol style="color: #155724;">
                    <li>Check your email inbox (and spam folder)</li>
                    <li>You should see a test email with OTP: 123456</li>
                    <li>If received, go to registration and test</li>
                    <li>You'll now receive real OTP emails!</li>
                </ol>
                <a href="auth/register.php" class="btn btn-success" style="margin-top: 10px;">Go to Registration →</a>
            </div>
            <?php endif; ?>
            
            <div style="margin-top: 20px; text-align: center;">
                <a href="index.php" class="btn" style="background: #6c757d;">← Back to Home</a>
                <a href="auth/register.php" class="btn btn-success">Go to Registration</a>
            </div>
        </div>
    </div>
</body>
</html>
