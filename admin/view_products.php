<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.html");
    exit();
}
require "../config/db.php";
$result = $conn->query("SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id=c.category_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Products</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h1>All Products</h1>
<a href="add_product.php">Add New Product</a> | <a href="dashboard.php">Back Dashboard</a>
<table border="1" cellpadding="10">
<tr>
<th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Quantity</th><th>Image</th><th>Actions</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['product_id'] ?></td>
<td><?= $row['product_name'] ?></td>
<td><?= $row['category_name'] ?></td>
<td><?= $row['price'] ?></td>
<td><?= $row['quantity'] ?></td>
<td><img src="../assets/images/<?= $row['image'] ?>" width="50"></td>
<td>
<a href="edit_product.php?id=<?= $row['product_id'] ?>">Edit</a> | 
<a href="delete_product.php?id=<?= $row['product_id'] ?>" onclick="return confirm('Delete product?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>