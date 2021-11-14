<?php include_once "includes/functions.php" ?>

<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo SITE_NAME; ?></title>
	<link rel="stylesheet" href="<?php echo get_url('css/style.css'); ?>">
</head>
<body>
<div class="container row">
	<header class="header">
		<h1 class="visually-hidden">Твиттер</h1>
		<nav class="header__navigation">
			<ul>
				<li>
					<a href="<?php echo get_url(); ?>" class="header__link header__link_main"></a>
				</li>
				<li>
					<button class="header__link header__link_profile_fill" title="Авторизоваться"></button>
					<!--<a href="#" class="header__link header__link_exit" title="Выйти"></a>-->
				</li>
			</ul>
		</nav>
	</header>
	<main class="main">
		<section class="wrapper">
			<div class="main-header">
				<a href="<?php echo get_url(); ?>" class="header__link header__link_home" title="Лента"></a>
				<a href="#" class="header__link header__link_profile" title="Твиты пользователя"></a>
				<a href="#" class="header__link header__link_likes" title="Понравившиеся твиты"></a>
				<a href="#" class="header__link header__link_sort" title="Сортировать"></a>
			</div>
		</section>