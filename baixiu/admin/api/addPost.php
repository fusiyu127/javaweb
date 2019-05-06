<?php
require_once '../../functions.php';

$user_id = $_POST['user_id'];
$slug = $_POST['slug'];
$title = $_POST['title'];
$created = $_POST['created'];
$content = $_POST['content'];
$status = $_POST['status'];
$category_id = $_POST['category'];

$sql = "insert into posts values(null,'{$slug}','{$title}',null,'{$created}','{$content}',0,0,'{$status}',{$user_id},{$category_id})";

echo execute($sql);
