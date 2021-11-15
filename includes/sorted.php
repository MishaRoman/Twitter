<?php
include_once "functions.php";

$posts = get_posts(0, true);
$title = 'Сначала старые посты';
$error = get_error_message();
include_once "header.php";
include_once "posts.php";
include_once "footer.php";