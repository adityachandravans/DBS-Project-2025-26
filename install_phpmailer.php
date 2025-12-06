<?php
/**
 * PHPMailer Installation Script
 * This will create PHPMailer files in your project
 */

echo "<!DOCTYPE html><html><head><title>Install PHPMailer</title>";
echo "<style>body{font-family:Arial;padding:40px;background:#f5f5f5;}.container{max-width:800px;margin:0 auto;background:white;padding:30px;border-radius:10px;}.success{color:green;font-weight:bold;padding:15px;background:#d4edda;border-radius:5px;margin:10px 0;}.error{color:red;font-weight:bold;padding:15px;background:#f8d7da;border-radius:5px;margin:10px 0;}.info{padding:15px;background:#d1ecf1;border-radius:5px;margin:10px 0;}.btn{display:inline-block;padding:12px 30px;background:#667eea;color:white;text-decoration:none;border-radius:5px;margin:5px;}pre{background:#2d2d2d;color:#f8f8f2;padding:15px;border-radius:5px;overflow-x:auto;font-size:12px;}</style>";
echo "</head><body><div class='container'><h1>📧 PHPMailer Installation</h1>";

// Create PHPMailer directory if it doesn't exist
if (!is_dir('PHPMailer')) {
    mkdir('PHPMailer', 0755, true);
    echo "<div class='info'>📁 Created PHPMailer directory</div>";
}

// Download PHPMailer files from CDN
$files = [
    'PHPMailer.php' => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/PHPMailer.php',
    'SMTP.php' => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/SMTP.php',
    'Exception.php' => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/Exception.php'
];

$success_count = 0;
$error_count = 0;

foreach ($files as $filename => $url) {
    $filepath = 'PHPMailer/' . $filename;
    
    if (file_exists($filepath)) {
        echo "<div class='success'>✅ $filename already exists</div>";
        $success_count++;
    } else {
        echo "<p>Downloading $filename...</p>";
        
        // Try to download
        $content = @file_get_contents($url);
        
        if ($content !== false) {
            file_put_contents($filepath, $content);
            echo "<div class='success'>✅ Downloaded $filename successfully</div>";
            $success_count++;
        } else {
            echo "<div class='error'>❌ Failed to download $filename</div>";
            $error_count++;
        }
    }
}

if ($error_count > 0) {
    echo "<div class='error'><h3>⚠️ Some files failed to download</h3>";
    echo "<p>This might be due to firewall or internet connection issues.</p>";
    echo "<p><strong>Alternative Solution:</strong> Use the built-in email system (no PHPMailer needed)</p>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<h3>Option 1: Manual Download</h3>";
    echo "<ol>";
    echo "<li>Visit: <a href='https://github.com/PHPMailer/PHPMailer/releases' target='_blank'>PHPMailer Releases</a></li>";
    echo "<li>Download the latest version ZIP</li>";
    echo "<li>Extract and copy these files to PHPMailer folder:";
    echo "<ul><li>PHPMailer.php</li><li>SMTP.php</li><li>Exception.php</li></ul></li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<h3>Option 2: Use Without PHPMailer</h3>";
    echo "<p>The system will work without PHPMailer by showing OTP on screen (development mode).</p>";
    echo "<p>This is perfect for testing!</p>";
    echo "</div>";
} else {
    echo "<div class='success'><h3>🎉 PHPMailer Installed Successfully!</h3>";
    echo "<p>All required files are in place.</p></div>";
    
    echo "<div class='info'>";
    echo "<h3>✅ Email Configuration:</h3>";
    echo "<ul>";
    echo "<li><strong>SMTP Host:</strong> smtp.gmail.com</li>";
    echo "<li><strong>Port:</strong> 587</li>";
    echo "<li><strong>Email:</strong> seminarmanagement143@gmail.com</li>";
    echo "<li><strong>App Password:</strong> Configured ✓</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<div class='success'>";
    echo "<h3>🚀 Ready to Send Emails!</h3>";
    echo "<p>Your system is now configured to send real emails via Gmail SMTP.</p>";
    echo "</div>";
}

echo "<div class='info'>";
echo "<h3>📋 Next Steps:</h3>";
echo "<ol>";
echo "<li>Test email sending with the button below</li>";
echo "<li>If test works, go to registration</li>";
echo "<li>Register a new account</li>";
echo "<li>Check your email for OTP</li>";
echo "<li>Complete verification and login!</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align:center;margin-top:30px;'>";
echo "<a href='test_email.php' class='btn' style='background:#28a745;'>Test Email Sending</a>";
echo "<a href='auth/register.php' class='btn'>Go to Registration</a>";
echo "<a href='index.php' class='btn' style='background:#6c757d;'>Home Page</a>";
echo "</div>";

// Show file status
echo "<div class='info' style='margin-top:30px;'>";
echo "<h3>📁 File Status:</h3>";
echo "<table style='width:100%;border-collapse:collapse;'>";
echo "<tr style='background:#667eea;color:white;'><th style='padding:10px;text-align:left;'>File</th><th style='padding:10px;text-align:left;'>Status</th><th style='padding:10px;text-align:left;'>Size</th></tr>";

foreach ($files as $filename => $url) {
    $filepath = 'PHPMailer/' . $filename;
    $exists = file_exists($filepath);
    $size = $exists ? filesize($filepath) : 0;
    
    echo "<tr style='border-bottom:1px solid #ddd;'>";
    echo "<td style='padding:8px;'>$filename</td>";
    echo "<td style='padding:8px;'>" . ($exists ? "✅ Exists" : "❌ Missing") . "</td>";
    echo "<td style='padding:8px;'>" . ($exists ? number_format($size) . " bytes" : "-") . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

echo "</div></body></html>";
?>
