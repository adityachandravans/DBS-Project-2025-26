<?php
/**
 * Automatic Database Fix Script
 * This will add missing OTP columns to your users table
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Fix Database - Inventory System</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        h1 { color: #667eea; }
        .success { color: green; font-weight: bold; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0; }
        .error { color: red; font-weight: bold; padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px 0; }
        .warning { color: orange; font-weight: bold; padding: 15px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 5px; margin: 10px 0; }
        .info { padding: 15px; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 5px; margin: 10px 0; }
        .btn { display: inline-block; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; font-size: 16px; }
        .btn:hover { background: #5568d3; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        pre { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .step { margin: 20px 0; padding: 15px; background: #f8f9fa; border-left: 4px solid #667eea; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Database Fix Tool</h1>
        <p>This tool will fix the "Unknown column 'otp'" error by adding the missing columns to your database.</p>
        
        <?php
        // Connect to database
        $conn = @mysqli_connect('localhost', 'root', '', 'inventory_db');
        
        if (!$conn) {
            echo '<div class="error">❌ Cannot connect to database!</div>';
            echo '<div class="info">';
            echo '<strong>Error:</strong> ' . mysqli_connect_error() . '<br><br>';
            echo '<strong>Please:</strong><br>';
            echo '1. Make sure MySQL is running in XAMPP<br>';
            echo '2. Make sure database "inventory_db" exists<br>';
            echo '3. If database doesn\'t exist, create it first in phpMyAdmin';
            echo '</div>';
            exit;
        }
        
        echo '<div class="success">✅ Connected to database successfully!</div>';
        
        // Check if users table exists
        $result = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
        
        if (mysqli_num_rows($result) == 0) {
            echo '<div class="warning">⚠️ Users table does not exist. Creating complete database structure...</div>';
            
            // Read and execute database.sql
            $sql = file_get_contents('database.sql');
            
            // Split by semicolon and execute each statement
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            
            $success_count = 0;
            $error_count = 0;
            
            foreach ($statements as $statement) {
                if (empty($statement) || strpos($statement, '--') === 0) continue;
                
                if (mysqli_query($conn, $statement)) {
                    $success_count++;
                } else {
                    $error_count++;
                    echo '<div class="error">Error: ' . mysqli_error($conn) . '</div>';
                }
            }
            
            if ($error_count == 0) {
                echo '<div class="success">✅ Database created successfully! Executed ' . $success_count . ' statements.</div>';
            }
        } else {
            echo '<div class="info">ℹ️ Users table exists. Checking structure...</div>';
            
            // Get current table structure
            $result = mysqli_query($conn, "DESCRIBE users");
            $columns = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $columns[] = $row['Field'];
            }
            
            echo '<div class="step">';
            echo '<strong>Current columns:</strong><br>';
            echo implode(', ', $columns);
            echo '</div>';
            
            // Check for missing columns
            $required_columns = ['otp', 'otp_expiry', 'is_verified'];
            $missing_columns = array_diff($required_columns, $columns);
            
            if (empty($missing_columns)) {
                echo '<div class="success">✅ All required columns exist! Your database is correct.</div>';
            } else {
                echo '<div class="warning">⚠️ Missing columns: ' . implode(', ', $missing_columns) . '</div>';
                echo '<div class="info">Adding missing columns...</div>';
                
                // Add missing columns
                $fixes_applied = [];
                
                if (!in_array('is_verified', $columns)) {
                    if (mysqli_query($conn, "ALTER TABLE users ADD COLUMN is_verified TINYINT(1) DEFAULT 0")) {
                        $fixes_applied[] = 'Added is_verified column';
                    } else {
                        echo '<div class="error">Failed to add is_verified: ' . mysqli_error($conn) . '</div>';
                    }
                }
                
                if (!in_array('otp', $columns)) {
                    if (mysqli_query($conn, "ALTER TABLE users ADD COLUMN otp VARCHAR(6) DEFAULT NULL")) {
                        $fixes_applied[] = 'Added otp column';
                    } else {
                        echo '<div class="error">Failed to add otp: ' . mysqli_error($conn) . '</div>';
                    }
                }
                
                if (!in_array('otp_expiry', $columns)) {
                    if (mysqli_query($conn, "ALTER TABLE users ADD COLUMN otp_expiry DATETIME DEFAULT NULL")) {
                        $fixes_applied[] = 'Added otp_expiry column';
                    } else {
                        echo '<div class="error">Failed to add otp_expiry: ' . mysqli_error($conn) . '</div>';
                    }
                }
                
                if (!empty($fixes_applied)) {
                    echo '<div class="success">';
                    echo '✅ <strong>Database fixed successfully!</strong><br><br>';
                    foreach ($fixes_applied as $fix) {
                        echo '• ' . $fix . '<br>';
                    }
                    echo '</div>';
                }
            }
        }
        
        // Show final table structure
        echo '<div class="step">';
        echo '<h3>Final Table Structure:</h3>';
        $result = mysqli_query($conn, "DESCRIBE users");
        
        if ($result) {
            echo '<table style="width: 100%; border-collapse: collapse;">';
            echo '<tr style="background: #667eea; color: white;">';
            echo '<th style="padding: 10px; text-align: left;">Field</th>';
            echo '<th style="padding: 10px; text-align: left;">Type</th>';
            echo '<th style="padding: 10px; text-align: left;">Null</th>';
            echo '<th style="padding: 10px; text-align: left;">Default</th>';
            echo '</tr>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr style="border-bottom: 1px solid #ddd;">';
                echo '<td style="padding: 8px;">' . $row['Field'] . '</td>';
                echo '<td style="padding: 8px;">' . $row['Type'] . '</td>';
                echo '<td style="padding: 8px;">' . $row['Null'] . '</td>';
                echo '<td style="padding: 8px;">' . ($row['Default'] ?? 'NULL') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        echo '</div>';
        
        // Check products table
        $result = mysqli_query($conn, "SHOW TABLES LIKE 'products'");
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="success">✅ Products table exists</div>';
        } else {
            echo '<div class="warning">⚠️ Products table missing. Creating...</div>';
            $sql = "CREATE TABLE products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                quantity INT NOT NULL DEFAULT 0,
                price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            if (mysqli_query($conn, $sql)) {
                echo '<div class="success">✅ Products table created</div>';
            }
        }
        
        mysqli_close($conn);
        ?>
        
        <div class="step" style="background: #d4edda; border-color: #28a745;">
            <h3>🎉 All Done!</h3>
            <p>Your database is now ready. You can:</p>
            <ol>
                <li>Go to registration page and create an account</li>
                <li>The OTP will be shown on screen (no email needed)</li>
                <li>Complete verification and login</li>
                <li>Start using the inventory system!</li>
            </ol>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="test_basic.php" class="btn">Test System</a>
            <a href="auth/register.php" class="btn btn-success" style="margin-left: 10px;">Go to Registration</a>
            <a href="index.php" class="btn" style="margin-left: 10px; background: #6c757d;">Home Page</a>
        </div>
        
        <div class="info" style="margin-top: 30px;">
            <strong>💡 Tip:</strong> If you still see errors, try:
            <ul>
                <li>Refresh this page to verify the fix</li>
                <li>Clear your browser cache (Ctrl+Shift+Delete)</li>
                <li>Visit <a href="test_basic.php">test_basic.php</a> to verify everything</li>
            </ul>
        </div>
    </div>
</body>
</html>
