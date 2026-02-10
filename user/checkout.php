<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.html");
    exit();
}
require "../config/db.php";

$order_id = $_GET['order_id'];

// Mark order as completed
$conn->query("UPDATE orders SET status='Completed' WHERE order_id=$order_id");

echo "<h1>Checkout Complete!</h1>";
echo "<p>Thank you for your purchase.</p>";
echo "<a href='products.php'>Back to Products</a>";
?>