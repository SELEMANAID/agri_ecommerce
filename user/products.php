<?php
session_start();
include("../config/db.php");

// Role check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user'){
    header("Location: ../login.html");
    exit;
}

// Get products + category
$sql = "SELECT products.*, categories.name AS category_name 
        FROM products 
        JOIN categories ON products.category_id = categories.id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>Available Products</h2>

<div class="products-container">
<?php
while($row = mysqli_fetch_assoc($result)){
    echo '<div class="product">';
    echo '<img src="../assets/images/products/'.$row['image'].'" alt="'.htmlspecialchars($row['name']).'" width="150" height="150"><br>';
    echo '<h3>'.htmlspecialchars($row['name']).'</h3>';
    echo '<p>Category: '.htmlspecialchars($row['category_name']).'</p>';
    echo '<p>Price: $'.htmlspecialchars($row['price']).'</p>';
    echo '<p>'.htmlspecialchars($row['description']).'</p>';
    echo '<button onclick="addToCart('.$row['id'].')">Buy</button>';
    echo '</div>';
}

?>
</div>
<script>
function addToCart(productId){
    let formData = new FormData();
    formData.append('product_id', productId);

    fetch('../api/add_to_cart.php', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(data => {
        if(data === "added"){
            alert("Product added to cart!");
        } else if(data === "exists"){
            alert("Product already in cart!");
        } else if(data === "not_logged_in"){
            alert("Please login first!");
        } else {
            alert("Error adding product");
        }
    });
}
</script>

<script>
function addToCart(productId){
    let formData = new FormData();
    formData.append('product_id', productId);

    fetch('../api/add_to_cart.php', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(data => {
        if(data === "added"){
            alert("Product added to cart!");
        } else if(data === "not_logged_in"){
            alert("Please login first!");
        } else {
            alert("Error adding product");
        }
    });
}
</script>

</body>
</html>