<?php
require_once '../functions.php';

$category_id = $_GET['category'];
$page = $_GET['page'];
$size = 8;
$offset = ($page - 1) * $size;

$sql_post = "select * from posts
        where category_id='{$category_id}' and status='published'
        order by created DESC
        limit {$offset},{$size};
      ";

$sql_page = "select count(1) as num from posts
       where category_id='{$category_id}' and status='published'
       ";

$totalPage = ceil(fetch_one($sql_page)['num']/$size);

$result['post'] = fetch_all($sql_post);
$result['totalPage'] = $totalPage;

header("Content-Type: application/json");
echo json_encode($result,JSON_UNESCAPED_UNICODE);
