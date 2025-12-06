<?php
/**
 * PHPMailer Download and Setup Script
 * This will download PHPMailer library automatically
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Download PHPMailer</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        .success { color: green; font-weight: bold; padding: 15px; background: #d4edda; border-radius: 5px; margin: 10px 0; }
        .error { color: red; font-weight: bold; padding: 15px; background: #f8d7da; border-radius: 5px; margin: 10px 0; }
        .info { padding: 15px; background: #d1ecf1; border-radius: 5px; margin: 10px 0; }
        .btn { display: inline-block; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; }
        pre { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>📧 PHPMailer Setup</h1>";

// Check if PHPMailer directory exists
if (is_dir('PHPMailer')) {
    echo "<div class='success'>✅ PHPMailer is already installed!</div>";
    echo "<p>Location: " . realpath('PHPMailer') . "</p>";
} else {
    echo "<div class='info'>📥 Downloading PHPMailer...</div>";
    
    // Download PHPMailer from GitHub
    $url = 'https://github.com/PHPMailer/PHPMailer/archive/refs/tags/v6.8.1.zip';
    $zipFile = 'phpmailer.zip';
    
    echo "<p>Downloading from: $url</p>";
    
    // Download the file
    $content = @file_get_contents($url);
    
    if ($content === false) {
        echo "<div class='error'>❌ Failed to download PHPMailer. Please download manually.</div>";
        echo "<div class='info'>";
        echo "<h3>Manual Installation:</h3>";
        echo "<ol>";
        echo "<li>Download PHPMailer from: <a href='https://github.com/PHPMailer/PHPMailer/releases' target='_blank'>GitHub Releases</a></li>";
        echo "<li>Extract the ZIP file</li>";
        echo "<li>Copy the 'src' folder to your project as 'PHPMailer'</li>";
        echo "<li>Refresh this page</li>";
        echo "</ol>";
        echo "</div>";
    } else {
        file_put_contents($zipFile, $content);
        echo "<div class='success'>✅ Downloaded successfully!</div>";
        
        // Extract the ZIP
        $zip = new ZipArchive;
        if ($zip->open($zipFile) === TRUE) {
            $zip->extractTo('.');
            $zip->close();
            
            // Rename the extracted folder
            if (is_dir('PHPMailer-6.8.1')) {
                rename('PHPMailer-6.8.1/src', 'PHPMailer');
                rmdir('PHPMailer-6.8.1');
            }
            
            unlink($zipFile);
            echo "<div class='success'>✅ PHPMailer installed successfully!</div>";
        } else {
            echo "<div class='error'>❌ Failed to extract ZIP file.</div>";
        }
    }
}

echo "<div class='info'>";
echo "<h3>✅ Next Steps:</h3>";
echo "<ol>";
echo "<li>PHPMailer is now ready to use</li>";
echo "<li>Email configuration is already set in config/email.php</li>";
echo "<li>Go to registration and test email sending</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin-top: 30px;'>";
echo "<a href='test_email.php' class='btn'>Test Email</a> ";
echo "<a href='auth/register.php' class='btn' style='background: #28a745; margin-left: 10px;'>Go to Registration</a>";
echo "</div>";

echo "</div></body></html>";
?>
