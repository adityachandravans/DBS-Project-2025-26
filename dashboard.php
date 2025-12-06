<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Get statistics
$total_products_query = "SELECT COUNT(*) as total FROM products";
$total_products_result = mysqli_query($conn, $total_products_query);
$total_products = mysqli_fetch_assoc($total_products_result)['total'];

$total_quantity_query = "SELECT SUM(quantity) as total FROM products";
$total_quantity_result = mysqli_query($conn, $total_quantity_query);
$total_quantity = mysqli_fetch_assoc($total_quantity_result)['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Inventory Management System</h1>
            <div class="nav">
                <a href="dashboard.php">Dashboard</a>
                <a href="products/index.php">View Products</a>
                <a href="products/add.php">Add Product</a>
                <a href="auth/logout.php">Logout</a>
            </div>
        </div>
        
        <div class="card">
            <h2>👋 Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p style="color: #666; font-size: 16px;">Manage your inventory efficiently and track your products in real-time.</p>
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <h3>📦 Total Products</h3>
                <p><?php echo $total_products; ?></p>
            </div>
            
            <div class="stat-card">
                <h3>📊 Total Quantity</h3>
                <p><?php echo number_format($total_quantity); ?></p>
            </div>
        </div>
        
        <div class="card">
            <h2>🚀 Quick Actions</h2>
            <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 20px;">
                <a href="products/add.php" class="btn btn-success">➕ Add New Product</a>
                <a href="products/index.php" class="btn btn-primary">📋 View All Products</a>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>
    </div>
</body>
</html>
