<?php
//接收ajax请求，返回评论数据
require_once '../../functions.php';
$page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
$size = 30;
$offset = ($page - 1) * $size;

$sql = "select
        comments.*,
        posts.title as post_title
        from comments
        inner join posts on comments.post_id=posts.id
        order by comments.created desc
        limit {$offset},{$size}";

$comments = fetch_all($sql);

header("Content-Type: application/json");
echo json_encode($comments);