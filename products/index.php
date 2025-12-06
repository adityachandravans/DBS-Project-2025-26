<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Get all products
$query = "SELECT * FROM products ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Inventory System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Inventory Management System</h1>
            <div class="nav">
                <a href="../dashboard.php">Dashboard</a>
                <a href="index.php">View Products</a>
                <a href="add.php">Add Product</a>
                <a href="../auth/logout.php">Logout</a>
            </div>
        </div>
        
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>📦 All Products</h2>
                <a href="add.php" class="btn btn-success">➕ Add Product</a>
            </div>
            
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo $product['quantity']; ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td><?php echo date('Y-m-d H:i', strtotime($product['created_at'])); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $product['id']; ?>" class="btn btn-primary" style="padding: 8px 15px; font-size: 13px;">✏️ Edit</a>
                                    <a href="delete.php?id=<?php echo $product['id']; ?>" class="btn btn-danger" style="padding: 8px 15px; font-size: 13px;" onclick="return confirm('Are you sure you want to delete this product?')">🗑️ Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; color: #999;">
                    <div style="font-size: 64px; margin-bottom: 20px;">📦</div>
                    <h3 style="color: #666; margin-bottom: 10px;">No Products Yet</h3>
                    <p style="margin-bottom: 20px;">Start by adding your first product to the inventory.</p>
                    <a href="add.php" class="btn btn-success">➕ Add Your First Product</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
