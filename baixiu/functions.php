<?php

require_once 'config.php';

//封装共用的函数
session_start();

/*获取当前用户登录信息，没有登录跳转到用户登录页面*/
function get_cur_user(){
    if (empty($_SESSION['current_login_user'])) {
      // 没有当前登录用户信息，意味着没有登录
      header('Location: /baixiu/admin/login.php');
      exit();
    }
    return $_SESSION['current_login_user'];
}

function fetch_all($sql){
    // 数据库连接
     $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
     if(!$conn){
        exit("数据库连接失败！");
     }
     mysqli_set_charset($conn,"utf8");
     $query = mysqli_query($conn,$sql);
     if(!$query){
        //查询失败
        return false;
     }
     $result = array();
     while($row = mysqli_fetch_assoc($query)){
        $result[] = $row;
     }
     mysqli_close($conn);
     return $result;
}

function fetch_one($sql){
    $result = fetch_all($sql);
    return isset($result[0]) ? $result[0] : null;
}

//非查询语句，增删改
function execute($sql){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$conn){
       exit("数据库连接失败！");
    }
    mysqli_set_charset($conn,"utf8");
    $query = mysqli_query($conn,$sql);
    if(!$query){
       //查询失败
       return false;
    }
    $affected_row = mysqli_affected_rows($conn);
    mysqli_close($conn);

    //返回受影响行数
    return $affected_row;
}