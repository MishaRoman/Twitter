<?php
include_once 'functions.php';

if (!logged_in()) redirect();

$id = $_GET['id'];

if (isset($id) && !empty($id)) {
	if (!delete_like($id)) {
		$_SESSION['error'] = 'Во время удаления лайка что-то пошло не так';
	}
}

redirect();