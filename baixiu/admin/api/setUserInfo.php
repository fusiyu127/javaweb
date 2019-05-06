<?php
require_once '../../functions.php';

$current_user = get_cur_user();
$avatar = $current_user['avatar'];

//判断是否上传图片
if(!empty($_FILES['avatar']['tmp_name'])){
    $filename = $_FILES['avatar']['name'];
    $tmp_name = $_FILES['avatar']['tmp_name'];
    move_uploaded_file($tmp_name , "../../static/uploads/".$filename);
    $avatar = "/baixiu/static/uploads/".$filename;
    echo "上传图片";
}

$slug = $_POST['slug'];
$nickname = $_POST['nickname'];
$bio = $_POST['bio'];

$sql = "update users set slug='{$slug}',nickname='{$nickname}',bio='{$bio}',avatar='{$avatar}' where id={$current_user['id']}";
execute($sql);

//更新当前用户信息
$current_user = fetch_one("select * from users where id={$current_user['id']}");
$_SESSION['current_login_user'] = $current_user;

header('location:/baixiu/admin/profile.php');