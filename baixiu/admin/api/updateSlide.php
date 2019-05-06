<?php
require_once '../../functions.php';

//获取当前轮播图状态
$current_slide = fetch_one("SELECT VALUE FROM `options` WHERE `key`='home_slides'")['VALUE'];
$current_slide = json_decode($current_slide);

function add_slide(){
    global $current_slide;
    $filename = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp_name , "../../static/uploads/".$filename);
    $new_slide = new stdClass();
    $new_slide->image = "/baixiu/static/uploads/".$filename;
    $new_slide->text = $_POST['text'];
    $new_slide->link = $_POST['link'];
    $current_slide[] = $new_slide;
    $current_slide = json_encode($current_slide, JSON_UNESCAPED_UNICODE);
    //修改数据库
    $sql = "update options set `value`='{$current_slide}' where `key`='home_slides'";
    $result = execute($sql);
    header("location:../slides.php");
}

function delete_slide(){
    global $current_slide;
    array_splice($current_slide, $_GET['id'], 1);
    $current_slide = json_encode($current_slide, JSON_UNESCAPED_UNICODE);
    $sql = "update options set `value`='{$current_slide}' where `key`='home_slides'";
    $result = execute($sql);
    header("location:../slides.php");
}

//添加轮播图
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    add_slide();
}

//删除轮播图
if(isset($_GET['id'])){
    delete_slide();
}