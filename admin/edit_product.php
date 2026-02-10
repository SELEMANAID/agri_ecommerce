<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.html");
    exit;
}

$id = $_GET['id'];
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id"));

if(isset($_POST['update'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/products/$image");
        $sql = "UPDATE products SET name='$name', price='$price', category_id='$category_id', description='$description', image='$image' WHERE id=$id";
    } else {
        $sql = "UPDATE products SET name='$name', price='$price', category_id='$category_id', description='$description' WHERE id=$id";
    }

    mysqli_query($conn, $sql);
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Product</title></head>
<body>
<h2>Edit Product</h2>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br>
    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required><br>
    <select name="category_id" required>
        <?php
        $cats = mysqli_query($conn, "SELECT * FROM categories");
        while($cat = mysqli_fetch_assoc($cats)){
            $selected = ($cat['id'] == $product['category_id']) ? "selected" : "";
            echo '<option value="'.$cat['id'].'" '.$selected.'>'.$cat['name'].'</option>';
        }
        ?>
    </select><br>
    <textarea name="description"><?php echo $product['description']; ?></textarea><br>
    <input type="file" name="image"><br>
    <button type="submit" name="update">Save Changes</button>
</form>
</body>
</html>