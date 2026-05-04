<?php
// -------------------------------------------------------
// manage_products.php
// Allows users to:
//   1. Insert a new product into the database.
//   2. Delete an existing product from the database.
// Part 4 - Insert and Delete operations
// -------------------------------------------------------

require 'db.php';

$message = "";

// ---- Handle INSERT ----
if (isset($_POST["action"]) && $_POST["action"] == "insert") {
    $name     = trim($_POST["name"]);
    $price    = floatval($_POST["price"]);
    $quantity = intval($_POST["quantity"]);

    if ($name != "" && $price > 0 && $quantity >= 0) {
        $stmt = mysqli_prepare($conn, "INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sdi", $name, $price, $quantity);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $message = "Product added successfully.";
    } else {
        $message = "Please fill all fields correctly.";
    }
}

// ---- Handle DELETE ----
if (isset($_POST["action"]) && $_POST["action"] == "delete") {
    $product_id = intval($_POST["product_id"]);

    if ($product_id > 0) {
        $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE product_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $message = "Product deleted successfully.";
    } else {
        $message = "Invalid product ID.";
    }
}

// ---- Load all products ----
$products = [];
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY product_id");
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Close connection only after all queries are done
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">

    <h2>Manage Products</h2>

    <?php if ($message != ""): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Add New Product Form -->
    <h4>Add New Product</h4>
    <form method="post" action="manage_products.php">
        <input type="hidden" name="action" value="insert">
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Price ($)</label>
            <input type="number" name="price" class="form-control" step="0.01" min="0" required>
        </div>
        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" min="0" required>
        </div>
        <button type="submit" class="btn btn-success">Add Product</button>
    </form>

    <br>

    <!-- Delete a Product Form -->
    <h4>Delete a Product</h4>
    <form method="post" action="manage_products.php">
        <input type="hidden" name="action" value="delete">
        <div class="mb-3">
            <label>Product ID to Delete</label>
            <input type="number" name="product_id" class="form-control" min="1" required>
        </div>
        <button type="submit" class="btn btn-danger">Delete Product</button>
    </form>

    <br>

    <!-- Current Products Table -->
    <h4>Current Products in Database</h4>
    <table border="1" cellpadding="6" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price ($)</th>
            <th>Quantity</th>
        </tr>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?php echo $p["product_id"]; ?></td>
            <td><?php echo htmlspecialchars($p["name"]); ?></td>
            <td><?php echo $p["price"]; ?></td>
            <td><?php echo $p["quantity"]; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
