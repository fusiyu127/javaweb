<?php

require_once '../functions.php';

if(empty($_GET['id'])){
    exit('缺少必要参数');
}
$id = $_GET['id'];

execute('delete from categories where id in ( '.$id .');');

header('location: /baixiu/admin/categories.php');