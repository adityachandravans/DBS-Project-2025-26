<?php
// Email configuration for SMTP
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'seminarmanagement143@gmail.com');
define('SMTP_PASSWORD', 'atkiotfaccnmpiql');
define('SMTP_FROM_EMAIL', 'seminarmanagement143@gmail.com');
define('SMTP_FROM_NAME', 'Inventory Management System');

// Use PHPMailer if available, otherwise fallback to PHP mail()
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Send email using PHPMailer with Gmail SMTP
 */
function sendEmail($to, $subject, $message) {
    // Try to use PHPMailer if available
    if (file_exists(__DIR__ . '/../PHPMailer/PHPMailer.php')) {
        require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
        require_once __DIR__ . '/../PHPMailer/SMTP.php';
        require_once __DIR__ . '/../PHPMailer/Exception.php';
        
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USERNAME;
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;
            
            // Recipients
            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress($to);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message);
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            // Log error for debugging
            error_log("Email Error: {$mail->ErrorInfo}");
            return false;
        }
    } else {
        // Fallback to PHP mail() function
        $headers = "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM_EMAIL . ">\r\n";
        $headers .= "Reply-To: " . SMTP_FROM_EMAIL . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        return mail($to, $subject, $message, $headers);
    }
}

/**
 * Send OTP email
 */
function sendOTPEmail($to, $otp, $username) {
    $subject = "Email Verification - OTP Code";
    
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 30px auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; color: white; }
            .header h1 { margin: 0; font-size: 28px; }
            .content { padding: 40px 30px; }
            .otp-box { background: #f8f9ff; border: 2px dashed #667eea; border-radius: 10px; padding: 20px; text-align: center; margin: 30px 0; }
            .otp-code { font-size: 36px; font-weight: bold; color: #667eea; letter-spacing: 8px; }
            .footer { background: #f8f9fa; padding: 20px; text-align: center; color: #666; font-size: 12px; }
            .btn { display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 25px; margin: 20px 0; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🔐 Email Verification</h1>
            </div>
            <div class="content">
                <h2>Hello ' . htmlspecialchars($username) . '!</h2>
                <p>Thank you for registering with Inventory Management System.</p>
                <p>To complete your registration, please use the following One-Time Password (OTP):</p>
                
                <div class="otp-box">
                    <div class="otp-code">' . $otp . '</div>
                </div>
                
                <p><strong>Important:</strong></p>
                <ul>
                    <li>This OTP is valid for 10 minutes</li>
                    <li>Do not share this code with anyone</li>
                    <li>If you didn\'t request this, please ignore this email</li>
                </ul>
                
                <p>Best regards,<br>Inventory Management Team</p>
            </div>
            <div class="footer">
                <p>This is an automated email. Please do not reply.</p>
                <p>&copy; ' . date('Y') . ' Inventory Management System. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ';
    
    return sendEmail($to, $subject, $message);
}

/**
 * Send welcome email after successful verification
 */
function sendWelcomeEmail($to, $username) {
    $subject = "Welcome to Inventory Management System!";
    
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 30px auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; color: white; }
            .content { padding: 40px 30px; }
            .footer { background: #f8f9fa; padding: 20px; text-align: center; color: #666; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🎉 Welcome!</h1>
            </div>
            <div class="content">
                <h2>Hello ' . htmlspecialchars($username) . '!</h2>
                <p>Your email has been successfully verified!</p>
                <p>You can now access all features of the Inventory Management System:</p>
                <ul>
                    <li>✓ Add and manage products</li>
                    <li>✓ Track inventory levels</li>
                    <li>✓ View detailed statistics</li>
                    <li>✓ Generate reports</li>
                </ul>
                <p>Thank you for joining us!</p>
                <p>Best regards,<br>Inventory Management Team</p>
            </div>
            <div class="footer">
                <p>&copy; ' . date('Y') . ' Inventory Management System. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ';
    
    return sendEmail($to, $subject, $message);
}
?>
