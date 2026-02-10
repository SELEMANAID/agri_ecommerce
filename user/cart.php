<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user'){
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items with product info
$sql = "SELECT cart.id AS cart_id, cart.quantity, products.id AS product_id, products.name, products.price, products.image
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = $user_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Cart</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h2>My Cart</h2>
<a href="products.php">Continue Shopping</a>

<?php if(mysqli_num_rows($result) > 0){ ?>
<table border="1" cellpadding="10">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Action</th>
    </tr>
    <?php 
    $total = 0;
    while($row = mysqli_fetch_assoc($result)){
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
    ?>
    <tr>
        <td><?php echo $row['name']; ?></td>
        <td>$<?php echo $row['price']; ?></td>
        <td>
            <form method="post" action="update_cart.php">
                <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1">
                <button type="submit" name="update_qty">Update</button>
            </form>
        </td>
        <td>$<?php echo $subtotal; ?></td>
        <td>
            <form method="post" action="remove_cart.php">
                <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                <button type="submit" name="remove">Remove</button>
            </form>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="3"><strong>Total</strong></td>
        <td colspan="2"><strong>$<?php echo $total; ?></strong></td>
    </tr>
</table>
<?php } else { ?>
<p>Your cart is empty.</p>
<?php } ?>
</body>
</html>