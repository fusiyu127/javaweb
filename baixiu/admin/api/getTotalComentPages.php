<?php
//接收ajax请求，返回评论数据
require_once '../../functions.php';
$size = 30;
$counts = (int)fetch_one("select count(1) as num from comments")['num'];
$page = ceil($counts/$size);
echo $page;