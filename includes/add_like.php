<?php
include_once 'functions.php';

if (!logged_in()) redirect();

$id = $_GET['id'];

if (isset($id) && !empty($id)) {
	if (!add_like($id)) {
		$_SESSION['error'] = 'Во время добавления лайка что-то пошло не так';
	}
}

redirect();