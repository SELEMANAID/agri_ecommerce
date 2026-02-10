<?php
session_start();
require "../config/db.php";

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $user = $result->fetch_assoc();
    if(password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        echo json_encode(['status'=>'success','role'=>$user['role']]);
    }else{
        echo json_encode(['status'=>'error','message'=>'Wrong password']);
    }
}else{
    echo json_encode(['status'=>'error','message'=>'User not found']);
}
?>