<?php
session_start();
include("../config/db.php");

// Role check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.html");
    exit;
}

// Get products
$sql = "SELECT products.*, categories.name AS category_name 
        FROM products 
        JOIN categories ON products.category_id = categories.id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>Admin Dashboard</h2>

<!-- Add Product Button -->
<div style="margin-bottom:20px;">
    <a href="add_product.php" style="padding:10px 20px; background-color:#28a745; color:white; text-decoration:none; border-radius:5px;">Add Product</a>
</div>

<div class="products-container">
<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        echo '<div class="product">';
        echo '<img src="../assets/images/products/'.$row['image'].'" alt="'.$row['name'].'" width="150" height="150">';
        echo '<h3>'.$row['name'].'</h3>';
        echo '<p>Category: '.$row['category_name'].'</p>';
        echo '<p>Price: $'.$row['price'].'</p>';
        echo '<p>'.$row['description'].'</p>';
        echo '<a href="edit_product.php?id='.$row['id'].'" style="color:#007bff;">Edit</a>';
        echo '</div>';
    }
} else {
    echo "<p>No products available.</p>";
}
?>
</div>

</body>
</html>