<?php
require_once '../functions.php';

$post_id = $_GET['id'];
$sql = "select
        posts.id,
        posts.title,
        posts.content,
        users.nickname as user_name,
        categories.`name` as category_name,
        posts.created,
        posts.`status`
        from posts
        INNER JOIN categories on posts.category_id = categories.id
        INNER JOIN users on posts.user_id = users.id
        where posts.id={$post_id}";

header("Content-Type: application/json");
echo json_encode(fetch_one($sql),JSON_UNESCAPED_UNICODE);
