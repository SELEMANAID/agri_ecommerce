<?php
session_start();
include("../config/db.php");

// Only admin can access
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.html");
    exit;
}

if(isset($_POST['add'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Check if image uploaded
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        // Move uploaded file
        if(!move_uploaded_file($tmp_name, "../assets/images/products/$image")){
            die("Failed to upload image. Check folder permissions.");
        }
    } else {
        die("Please select an image for the product.");
    }

    // Insert product into DB
    $sql = "INSERT INTO products (name, price, category_id, description, image) 
            VALUES ('$name', '$price', '$category_id', '$description', '$image')";

    if(mysqli_query($conn, $sql)){
        header("Location: dashboard.php");
        exit;
    } else {
        die("Insert failed: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Product - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h2>Add Product</h2>
<a href="dashboard.php">Back to Dashboard</a>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required><br><br>
    <input type="number" step="0.01" name="price" placeholder="Price" required><br><br>
    <select name="category_id" required>
        <option value="">Select Category</option>
        <?php
        $cats = mysqli_query($conn, "SELECT * FROM categories");
        while($cat = mysqli_fetch_assoc($cats)){
            echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
        }
        ?>
    </select><br><br>
    <textarea name="description" placeholder="Description"></textarea><br><br>
    <input type="file" name="image" required><br><br>
    <button type="submit" name="add">Add Product</button>
</form>
</body>
</html>