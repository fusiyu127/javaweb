<?php
$new_slide = new stdClass();
$new_slide->image = "/baixiu/static/uploads";
$new_slide->text = '付思雨';
$new_slide->link = 'hehe';
$test[] = $new_slide;

$test = json_encode($test,JSON_UNESCAPED_UNICODE);
echo $test;

?>