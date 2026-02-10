<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    echo "not_logged_in";
    exit;
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['user_id'];

    // Check if product already in cart
    $check = mysqli_query($conn, "SELECT id, quantity FROM cart WHERE user_id=$user_id AND product_id=$product_id");
    if(mysqli_num_rows($check) > 0){
        // Increment quantity
        $row = mysqli_fetch_assoc($check);
        $new_qty = $row['quantity'] + 1;
        mysqli_query($conn, "UPDATE cart SET quantity=$new_qty WHERE id=".$row['id']);
        echo "added"; // same alert
        exit;
    }

    // Insert new product
    $insert = mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)");
    if($insert){
        echo "added";
    } else {
        echo "error";
    }
}
?>