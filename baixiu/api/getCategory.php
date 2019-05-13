<?php
require_once '../functions.php';

$sql = "select * from categories;";
$categories = fetch_all($sql);
header("Content-Type: application/json");
echo json_encode($categories,JSON_UNESCAPED_UNICODE);