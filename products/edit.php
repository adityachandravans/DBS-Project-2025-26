<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$error = '';
$success = '';
$product = null;

// Get product ID
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch product
$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$product = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    
    if (empty($name) || $quantity < 0 || $price < 0) {
        $error = "Please fill all fields with valid values";
    } else {
        $update_query = "UPDATE products SET name = '$name', quantity = $quantity, price = $price WHERE id = $id";
        
        if (mysqli_query($conn, $update_query)) {
            $success = "Product updated successfully!";
            // Refresh product data
            $result = mysqli_query($conn, $query);
            $product = mysqli_fetch_assoc($result);
        } else {
            $error = "Failed to update product. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Inventory System</title>
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
            <h2>✏️ Edit Product</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>📦 Product Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" placeholder="Enter product name" required>
                </div>
                
                <div class="form-group">
                    <label>📊 Quantity</label>
                    <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="0" placeholder="Enter quantity" required>
                </div>
                
                <div class="form-group">
                    <label>💰 Price ($)</label>
                    <input type="number" name="price" value="<?php echo $product['price']; ?>" step="0.01" min="0" placeholder="0.00" required>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">✓ Update Product</button>
                    <a href="index.php" class="btn btn-primary">← Back to Products</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
