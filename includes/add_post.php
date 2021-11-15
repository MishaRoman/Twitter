<?php
include_once 'functions.php';

if (!logged_in()) redirect();

$text = $_POST['text'];
$image = $_POST['image'];

if (isset($text) && !empty($text) && isset($image)) {
	if (!add_post($text, $image)) {
		$_SESSION['error'] = 'Во время добавления поста что-то пошло не так';
	}
}

redirect(get_url('user_posts.php'));