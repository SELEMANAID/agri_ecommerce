<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.html");
    exit();
}
require "../config/db.php";
$id = $_GET['id'];
$conn->query("DELETE FROM products WHERE product_id=$id");
header("Location: view_products.php");
?>