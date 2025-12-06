<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Inventory Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .welcome-hero {
            text-align: center;
            padding: 60px 20px;
        }
        .welcome-hero h1 {
            font-size: 48px;
            color: white;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .welcome-hero p {
            font-size: 20px;
            color: rgba(255,255,255,0.9);
            margin-bottom: 40px;
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin: 40px 0;
        }
        .feature-box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        .feature-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .feature-box h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        .feature-box p {
            color: #666;
            font-size: 14px;
        }
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-hero">
            <div style="font-size: 80px; margin-bottom: 20px;">📦</div>
            <h1>Inventory Management System</h1>
            <p>Modern, Secure, and Beautiful Inventory Tracking</p>
            
            <div class="cta-buttons">
                <a href="auth/login.php" class="btn btn-primary" style="font-size: 18px; padding: 15px 40px;">
                    🔐 Login
                </a>
                <a href="auth/register.php" class="btn btn-success" style="font-size: 18px; padding: 15px 40px;">
                    ✨ Get Started
                </a>
            </div>
        </div>
        
        <div class="card">
            <h2 style="text-align: center; margin-bottom: 40px;">✨ Amazing Features</h2>
            
            <div class="feature-grid">
                <div class="feature-box">
                    <div class="feature-icon">🔐</div>
                    <h3>Secure Authentication</h3>
                    <p>Email verification with OTP, password hashing, and session management</p>
                </div>
                
                <div class="feature-box">
                    <div class="feature-icon">📦</div>
                    <h3>Easy Management</h3>
                    <p>Add, edit, and delete products with just a few clicks</p>
                </div>
                
                <div class="feature-box">
                    <div class="feature-icon">📊</div>
                    <h3>Real-time Stats</h3>
                    <p>Track total products and quantities on your dashboard</p>
                </div>
                
                <div class="feature-box">
                    <div class="feature-icon">📧</div>
                    <h3>Email System</h3>
                    <p>Professional email templates for OTP and welcome messages</p>
                </div>
                
                <div class="feature-box">
                    <div class="feature-icon">🎨</div>
                    <h3>Modern Design</h3>
                    <p>Beautiful gradient UI with smooth animations</p>
                </div>
                
                <div class="feature-box">
                    <div class="feature-icon">📱</div>
                    <h3>Responsive</h3>
                    <p>Works perfectly on desktop, tablet, and mobile devices</p>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2 style="text-align: center; margin-bottom: 30px;">🚀 How It Works</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; text-align: center;">
                <div>
                    <div style="font-size: 40px; margin-bottom: 10px;">1️⃣</div>
                    <h3 style="color: #667eea;">Register</h3>
                    <p style="color: #666;">Create your account with email verification</p>
                </div>
                
                <div>
                    <div style="font-size: 40px; margin-bottom: 10px;">2️⃣</div>
                    <h3 style="color: #667eea;">Verify</h3>
                    <p style="color: #666;">Enter OTP sent to your email</p>
                </div>
                
                <div>
                    <div style="font-size: 40px; margin-bottom: 10px;">3️⃣</div>
                    <h3 style="color: #667eea;">Login</h3>
                    <p style="color: #666;">Access your dashboard</p>
                </div>
                
                <div>
                    <div style="font-size: 40px; margin-bottom: 10px;">4️⃣</div>
                    <h3 style="color: #667eea;">Manage</h3>
                    <p style="color: #666;">Start tracking your inventory</p>
                </div>
            </div>
        </div>
        
        <div class="card" style="text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h2 style="color: white;">Ready to Get Started?</h2>
            <p style="color: rgba(255,255,255,0.9); font-size: 18px; margin: 20px 0;">
                Join now and experience modern inventory management!
            </p>
            <a href="auth/register.php" class="btn" style="background: white; color: #667eea; font-size: 18px; padding: 15px 40px;">
                Create Free Account →
            </a>
        </div>
        
        <?php include 'includes/footer.php'; ?>
    </div>
</body>
</html>
