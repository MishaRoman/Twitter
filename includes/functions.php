<?php
include_once "config.php";

function debug($var, $stop = false) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';
	if ($stop) die;
}

// Перенаправляет пользователя по указанной ссылке или на главную
function redirect($link = HOST) {
	header("Location: $link");
	die;
}

function get_url($page = '') {
	return HOST . "/$page";
}

function get_page_title($title = '') {
	if (!empty($title)) {
		return SITE_NAME . " - $title";
	} else {
		return SITE_NAME;
	}
}

// Функция подключения к базе данных
function db() {
	try {
		return new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS,
		[
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		]
	);
	} catch(PDOException $e) {
		die($e->getMessage());
	}
}

// Функция для запросов к БД
function db_query($sql, $exec = false) {
	if (empty($sql)) return false;

	if ($exec) return db()->exec($sql);

	return db()->query($sql);
}

function get_posts($user_id = 0, $sort = false) {
	$sorting = 'DESC';
	if ($sort) $sorting = 'ASC';

	if ($user_id > 0) {
		return db_query("SELECT posts.*, users.name, users.login, users.avatar
			FROM `posts` JOIN `users` ON users.id = posts.user_id WHERE posts.user_id = $user_id ORDER BY posts.`date` $sorting;")->fetchAll();
	}
	return db_query("SELECT posts.*, users.name, users.login, users.avatar
		FROM `posts` JOIN `users` ON users.id = posts.user_id ORDER BY posts.`date` $sorting;")->fetchAll();
}

// Функция для проверки существует ли такой пользователь
function get_user_info($login) {
	return db_query("SELECT * FROM `users` WHERE `login` = '$login' ")->fetch();
}

function add_user($login, $pass) {
	$login = trim($login);
	$name = ucfirst($login);
	$password = password_hash($pass, PASSWORD_DEFAULT);
	$sql = "INSERT INTO `users` (`id`, `login`, `pass`, `name`) VALUES (NULL, '$login', '$password', '$name')";
	return db_query($sql, true);
}

function register_user($auth_data) {
	if (empty($auth_data) || !isset($auth_data['login']) || empty($auth_data['login'])) return false;

	$user = get_user_info($auth_data['login']);
	if (!empty($user)) {
		$_SESSION['error'] = 'Пользователь ' . $auth_data['login'] . ' уже существует';
		redirect(get_url('register.php'));
		die;
	}

	if ($auth_data['pass'] !== $auth_data['pass2']) {
		$_SESSION['error'] = 'Пароли не совпадают';
		redirect(get_url('register.php'));
		die;
	}

	if (add_user($auth_data['login'], $auth_data['pass'])) {
		redirect(get_url());
		die;
	}
}

function login($auth_data) {
	if (empty($auth_data) || !isset($auth_data['login']) || empty($auth_data['login'])) return false;

	$user = get_user_info($auth_data['login']);

	if (empty($user)) {
		$_SESSION['error'] = 'Такой пользователь не существует';
		header('Location: ' . get_url());
		die;
	}

	if (password_verify($auth_data['pass'], $user['pass'])) {
		$_SESSION['user'] = $user;

		$_SESSION['error'] = '';
		header('Location: ' . get_url('user_posts.php?id=' . $user['id']));
		die;
	} else {
		$_SESSION['error'] = 'Неверный пароль';
		header('Location: ' . get_url());
		die;
	}
}

function get_error_message() {
	$error = '';
	if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
		$error = $_SESSION['error'];
		$_SESSION['error'] = '';
	}

	return $error;
}

// Функция для проверки авторизирован ли пользователь
function logged_in() {
	return isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id']);
}

function add_post($text, $image) {
	$text = trim($text);
	if (mb_strlen($text) > 255) {
		$text = mb_substr($text, 0, 250). ' ...';
	}

	$user_id = $_SESSION['user']['id'];
	$sql = "INSERT INTO `posts` (`id`, `user_id`, `text`, `image`) VALUES (NULL, $user_id, '$text', '$image')";
	return db_query($sql, true);
}

function delete_post($id) {
	$user_id = $_SESSION['user']['id'];
	$sql = "DELETE FROM `posts` WHERE `id` = $id AND `user_id` = $user_id";
	return db_query($sql, true);
}

function get_likes_count($post_id) {
	if (empty($post_id)) return 0;

	$sql = "SELECT COUNT(*) FROM `likes` WHERE `post_id` = $post_id";
	return db_query($sql)->fetchColumn();
}

function is_post_liked($post_id) {
	$user_id = $_SESSION['user']['id'];
	if (empty($post_id)) return false;

	$sql = "SELECT * FROM `likes` WHERE `post_id` = $post_id AND `user_id` = $user_id;";
	return db_query($sql)->rowCount() > 0;
}

function add_like($post_id) {
	$user_id = $_SESSION['user']['id'];
	if (empty($post_id)) return false;

	$sql = "INSERT INTO `likes` (`post_id`, `user_id`) VALUES ($post_id, $user_id)";
	return db_query($sql, true);
}

function delete_like($post_id) {
	$user_id = $_SESSION['user']['id'];
	if (empty($post_id)) return false;

	$sql = "DELETE FROM `likes` WHERE `post_id` = $post_id AND `user_id` = $user_id";
	return db_query($sql, true);
}

function get_liked_posts() {
	$user_id = $_SESSION['user']['id'];

	$sql = "SELECT posts.*, users.name, users.login, users.avatar FROM `likes`
	 JOIN `posts` ON posts.id = likes.post_id
	 JOIN `users` ON users.id = posts.user_id WHERE likes.user_id = $user_id";

	return db_query($sql)->fetchAll();
}