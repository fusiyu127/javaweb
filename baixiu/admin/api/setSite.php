<?php
require_once '../../functions.php';

//判断是否上传图片
if(!empty($_FILES['logo']['tmp_name'])){
    $filename = $_FILES['logo']['name'];
    $tmp_name = $_FILES['logo']['tmp_name'];
    move_uploaded_file($tmp_name , "../../static/uploads/logo/".$filename);
    $logo = "/baixiu/static/uploads/logo/".$filename;
    $sql = "update options set `value`='{$logo}' where `key`='site_logo'";
    $result = execute($sql);
}

$current_name = $_POST['site_name'];
$current_description = $_POST['site_description'];
$current_keywords = $_POST['site_keywords'];

execute("update options set `value`='{$current_name}' where `key`='site_name'");
execute("update options set `value`='{$current_description}' where `key`='site_description'");
execute("update options set `value`='{$current_keywords}' where `key`='site_keywords'");

header('location:/baixiu/admin/settings.php');