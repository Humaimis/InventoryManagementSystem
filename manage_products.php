<?php
// -------------------------------------------------------
// search.php
// Allows users to search products from the database.
// Part 4 - Search Functionality (SELECT query)
// -------------------------------------------------------

require 'db.php';

$results  = [];
$searched = false;
$keyword  = "";
$min_price = "";
$max_price = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searched  = true;
    $keyword   = trim($_POST["keyword"]);
    $min_price = trim($_POST["min_price"]);
    $max_price = trim($_POST["max_price"]);

    // Build query based on what the user entered
    $sql = "SELECT * FROM products WHERE 1=1";

    if ($keyword != "") {
        $keyword_safe = mysqli_real_escape_string($conn, $keyword);
        $sql .= " AND name LIKE '%$keyword_safe%'";
    }

    if ($min_price != "") {
        $sql .= " AND price >= " . floatval($min_price);
    }

    if ($max_price != "") {
        $sql .= " AND price <= " . floatval($max_price);
    }

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>Search Products</h2>

    <form method="post" action="search.php">
        <div class="mb-3">
            <label>Product Name (keyword)</label>
            <input type="text" name="keyword" class="form-control"
                   value="<?php echo htmlspecialchars($keyword); ?>">
        </div>
        <div class="mb-3">
            <label>Min Price</label>
            <input type="number" name="min_price" class="form-control"
                   value="<?php echo htmlspecialchars($min_price); ?>">
        </div>
        <div class="mb-3">
            <label>Max Price</label>
            <input type="number" name="max_price" class="form-control"
                   value="<?php echo htmlspecialchars($max_price); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <br>

    <?php if ($searched): ?>
        <h4>Search Results</h4>

        <?php if (count($results) == 0): ?>
            <p>No products found.</p>
        <?php else: ?>
            <table border="1" cellpadding="6" cellspacing="0">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price ($)</th>
                    <th>Quantity</th>
                </tr>
                <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $row["product_id"]; ?></td>
                    <td><?php echo htmlspecialchars($row["name"]); ?></td>
                    <td><?php echo $row["price"]; ?></td>
                    <td><?php echo $row["quantity"]; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
