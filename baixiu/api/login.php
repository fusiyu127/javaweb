<?php
require_once '../functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "select * from users where email='{$email}' and password='{$password}'";
$user = fetch_one($sql);

if(!$user){
    echo 0;
}else{
    $_SESSION['current_login_user'] = $user;
    echo 1;
}
