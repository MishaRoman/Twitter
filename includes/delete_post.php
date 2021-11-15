<?php
include_once 'functions.php';

if (!logged_in()) redirect();

$id = $_GET['id'];

if (isset($id) && !empty($id)) {
	if (!delete_post($id)) {
		$_SESSION['error'] = 'Во время удаления поста что-то пошло не так';
	}
}

redirect(get_url('user_posts.php'));