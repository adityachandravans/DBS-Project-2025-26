<?php
// SIMPLE REGISTRATION - FOR TESTING
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!-- Debug: Script started -->\n";

session_start();
echo "<!-- Debug: Session started -->\n";

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'inventory_db');

if (!$conn) {
    die("<h1>Database Error</h1><p>Could not connect to database. Please make sure MySQL is running in XAMPP and database 'inventory_db' exists.</p><p>Error: " . mysqli_connect_error() . "</p>");
}

echo "<!-- Debug: Database connected -->\n";

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<!-- Debug: Form submitted -->\n";
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    echo "<!-- Debug: Data received - Username: $username, Email: $email -->\n";
    
    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        echo "<!-- Debug: Validation passed -->\n";
        
        // Check if email exists
        $check_query = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($result) > 0) {
            $error = "Email already registered";
            echo "<!-- Debug: Email already exists -->\n";
        } else {
            echo "<!-- Debug: Email available, creating user -->\n";
            
            // Generate OTP
            $otp = sprintf("%06d", mt_rand(1, 999999));
            $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            echo "<!-- Debug: OTP generated: $otp -->\n";
            
            // Insert user
            $query = "INSERT INTO users (username, email, password, otp, otp_expiry, is_verified) 
                      VALUES ('$username', '$email', '$hashed_password', '$otp', '$otp_expiry', 0)";
            
            if (mysqli_query($conn, $query)) {
                echo "<!-- Debug: User inserted successfully -->\n";
                
                // Set session
                $_SESSION['verify_email'] = $email;
                $_SESSION['verify_username'] = $username;
                $_SESSION['registration_success'] = true;
                $_SESSION['debug_otp'] = $otp;
                
                echo "<!-- Debug: Session set, redirecting... -->\n";
                
                // Redirect
                header("Location: verify_otp.php");
                exit();
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
                echo "<!-- Debug: Database insert failed: " . mysqli_error($conn) . " -->\n";
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
    <title>Register (Simple) - Inventory System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="logo">📦</div>
            <h2 class="text-center">Create Account (Simple Version)</h2>
            <p style="text-align: center; color: #666; font-size: 14px;">This is a simplified version for testing</p>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <strong>Error:</strong> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>👤 Username</label>
                    <input type="text" name="username" placeholder="Enter your username" required value="testuser">
                </div>
                
                <div class="form-group">
                    <label>📧 Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required value="test@example.com">
                </div>
                
                <div class="form-group">
                    <label>🔒 Password</label>
                    <input type="password" name="password" placeholder="Minimum 6 characters" minlength="6" required value="test123">
                </div>
                
                <div class="form-group">
                    <label>🔒 Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Re-enter password" required value="test123">
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Create Account</button>
            </form>
            
            <p class="text-center mt-20">
                <a href="register.php">← Back to Normal Registration</a> | 
                <a href="login.php">Login here</a>
            </p>
            
            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px; font-size: 13px;">
                <strong>Debug Info:</strong><br>
                - PHP Version: <?php echo phpversion(); ?><br>
                - Database: <?php echo $conn ? 'Connected' : 'Not Connected'; ?><br>
                - Session: <?php echo session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive'; ?><br>
                - Form fields are pre-filled for quick testing
            </div>
        </div>
    </div>
</body>
</html>
