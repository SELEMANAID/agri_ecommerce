<?php
include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = $_POST['password'];

    if (empty($name) || empty($email) || empty($pass)) {
        echo "empty";
        exit;
    }

    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (!$check) {
        echo "SQL_CHECK_ERROR: " . mysqli_error($conn);
        exit;
    }

    if (mysqli_num_rows($check) > 0) {
        echo "exists";
        exit;
    }

    $hashed = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role)
            VALUES ('$name', '$email', '$hashed', 'user')";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "SQL_INSERT_ERROR: " . mysqli_error($conn);
    }
}
?>