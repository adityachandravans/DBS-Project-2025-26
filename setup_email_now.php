<?php
/**
 * Complete Email Setup - Downloads PHPMailer and Tests Email
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$step = isset($_GET['step']) ? $_GET['step'] : 1;
$status = [];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Email Setup - Inventory System</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        h1 { color: #667eea; margin-bottom: 10px; }
        .success { color: green; font-weight: bold; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0; }
        .error { color: red; font-weight: bold; padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px 0; }
        .warning { color: orange; font-weight: bold; padding: 15px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 5px; margin: 10px 0; }
        .info { padding: 15px; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 5px; margin: 10px 0; }
        .btn { display: inline-block; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; font-size: 16px; margin: 5px; }
        .btn:hover { background: #5568d3; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        .step { margin: 20px 0; padding: 20px; background: #f8f9fa; border-left: 4px solid #667eea; border-radius: 5px; }
        .step h3 { margin-top: 0; color: #667eea; }
        pre { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto; font-size: 12px; }
        .progress { margin: 20px 0; }
        .progress-bar { background: #e9ecef; height: 30px; border-radius: 15px; overflow: hidden; }
        .progress-fill { background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); height: 100%; transition: width 0.3s; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📧 Complete Email Setup</h1>
        <p>This will set up PHPMailer and enable real email sending via Gmail SMTP.</p>
        
        <?php if ($step == 1): ?>
            <!-- Step 1: Download PHPMailer -->
            <div class="step">
                <h3>Step 1: Download PHPMailer Files</h3>
                <p>Click the button below to download and install PHPMailer automatically.</p>
                
                <form method="POST" action="?step=2">
                    <button type="submit" class="btn btn-success">📥 Download & Install PHPMailer</button>
                </form>
            </div>
            
            <div class="info">
                <strong>What this will do:</strong>
                <ul>
                    <li>Download PHPMailer library from GitHub</li>
                    <li>Extract required files</li>
                    <li>Place them in PHPMailer folder</li>
                    <li>Verify installation</li>
                </ul>
            </div>
            
        <?php elseif ($step == 2): ?>
            <!-- Step 2: Install PHPMailer -->
            <div class="step">
                <h3>Step 2: Installing PHPMailer...</h3>
                
                <?php
                // URLs for PHPMailer files
                $files = [
                    'PHPMailer.php' => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.1/src/PHPMailer.php',
                    'SMTP.php' => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.1/src/SMTP.php',
                    'Exception.php' => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.1/src/Exception.php'
                ];
                
                $success_count = 0;
                $total_files = count($files);
                
                foreach ($files as $filename => $url) {
                    $filepath = 'PHPMailer/' . $filename;
                    
                    echo "<p>Downloading $filename...</p>";
                    
                    // Use cURL for better compatibility
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $content = curl_exec($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    
                    if ($content && $http_code == 200) {
                        file_put_contents($filepath, $content);
                        echo "<div class='success'>✅ Downloaded $filename (" . number_format(strlen($content)) . " bytes)</div>";
                        $success_count++;
                    } else {
                        echo "<div class='error'>❌ Failed to download $filename (HTTP $http_code)</div>";
                    }
                }
                
                if ($success_count == $total_files) {
                    echo "<div class='success'><h3>🎉 PHPMailer Installed Successfully!</h3>";
                    echo "<p>All $total_files files downloaded and installed.</p></div>";
                    echo "<a href='?step=3' class='btn btn-success'>Next: Test Email →</a>";
                } else {
                    echo "<div class='error'><h3>⚠️ Installation Incomplete</h3>";
                    echo "<p>Only $success_count of $total_files files were downloaded.</p></div>";
                    echo "<a href='?step=1' class='btn'>← Try Again</a>";
                }
                ?>
            </div>
            
        <?php elseif ($step == 3): ?>
            <!-- Step 3: Test Email -->
            <div class="step">
                <h3>Step 3: Test Email Sending</h3>
                
                <?php
                // Check if PHPMailer is installed
                $phpmailer_installed = file_exists('PHPMailer/PHPMailer.php') && 
                                      file_exists('PHPMailer/SMTP.php') && 
                                      file_exists('PHPMailer/Exception.php');
                
                if (!$phpmailer_installed) {
                    echo "<div class='error'>❌ PHPMailer files not found. Please go back and install.</div>";
                    echo "<a href='?step=1' class='btn'>← Back to Installation</a>";
                } else {
                    echo "<div class='success'>✅ PHPMailer is installed</div>";
                    
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['test_email'])) {
                        $test_email = $_POST['test_email'];
                        
                        echo "<div class='info'><strong>Sending test email to:</strong> $test_email</div>";
                        
                        require_once 'config/email.php';
                        
                        $test_otp = "123456";
                        $test_username = "Test User";
                        
                        if (sendOTPEmail($test_email, $test_otp, $test_username)) {
                            echo "<div class='success'>";
                            echo "<h3>🎉 Email Sent Successfully!</h3>";
                            echo "<p>Check your inbox (and spam folder) for the test email.</p>";
                            echo "<p><strong>Test OTP:</strong> $test_otp</p>";
                            echo "</div>";
                            echo "<a href='auth/register.php' class='btn btn-success'>Go to Registration →</a>";
                        } else {
                            echo "<div class='error'>";
                            echo "<h3>❌ Email Sending Failed</h3>";
                            echo "<p>Possible reasons:</p>";
                            echo "<ul>";
                            echo "<li>Internet connection issue</li>";
                            echo "<li>Firewall blocking SMTP port 587</li>";
                            echo "<li>Gmail credentials incorrect</li>";
                            echo "<li>Antivirus blocking connection</li>";
                            echo "</ul>";
                            echo "<p><strong>Don't worry!</strong> The system will show OTP on screen as fallback.</p>";
                            echo "</div>";
                            echo "<a href='auth/register.php' class='btn'>Continue to Registration →</a>";
                        }
                    } else {
                        ?>
                        <form method="POST" action="?step=3">
                            <div style="margin: 20px 0;">
                                <label style="display: block; margin-bottom: 10px; font-weight: bold;">Enter your email address to receive a test OTP:</label>
                                <input type="email" name="test_email" placeholder="your-email@example.com" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                            </div>
                            <button type="submit" class="btn btn-success">📧 Send Test Email</button>
                        </form>
                        <?php
                    }
                }
                ?>
            </div>
            
            <div class="info">
                <strong>Email Configuration:</strong>
                <ul>
                    <li><strong>SMTP Host:</strong> smtp.gmail.com</li>
                    <li><strong>Port:</strong> 587</li>
                    <li><strong>Email:</strong> seminarmanagement143@gmail.com</li>
                    <li><strong>Encryption:</strong> STARTTLS</li>
                </ul>
            </div>
            
        <?php endif; ?>
        
        <!-- Progress Indicator -->
        <div class="progress">
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo ($step / 3 * 100); ?>%;">
                    Step <?php echo $step; ?> of 3
                </div>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
            <strong>Quick Links:</strong><br>
            <a href="test_basic.php" class="btn" style="background: #6c757d;">System Status</a>
            <a href="test_email.php" class="btn" style="background: #17a2b8;">Test Email</a>
            <a href="auth/register.php" class="btn" style="background: #28a745;">Registration</a>
            <a href="index.php" class="btn" style="background: #6c757d;">Home</a>
        </div>
    </div>
</body>
</html>
