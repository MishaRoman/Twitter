	</main>
</div>
<?php if (!logged_in()) { ?>
<div class="modal overlay">
	<div class="container modal__body" id="login-modal">
		<div class="modal-close">
			<button class="modal-close__btn chest-icon"></button>
		</div>
		<section class="wrapper">
			<h2 class="tweet-form__title">Введите логин и пароль</h2>
			<?php if ($error) { ?>
				<div class="tweet-form__error"><?php echo $error ?></div>
			<?php } ?>
			<div class="tweet-form__subtitle">Если у вас нет логина, пройдите <a href="<?php echo get_url('register.php'); ?>">регистрацию</a></div>
			<form class="tweet-form" action="<?php echo get_url('includes/signin.php') ?>" method="POST">
				<div class="tweet-form__wrapper_inputs">
					<input type="text" class="tweet-form__input" placeholder="Логин" name="login" required>
					<input type="password" class="tweet-form__input" placeholder="Пароль" name="pass" required>
				</div>
				<div class="tweet-form__btns_center">
					<button class="tweet-form__btn_center" type="submit">Войти</button>
				</div>
			</form>
		</section>
	</div>
</div>
<?php } ?>
<script src="<?php echo get_url('js/scripts.js'); ?>"></script>

<!-- Если есть ошибка при авторизации отображаем модальное окно -->
<?php if ($error) { ?>
	<script>
		openModal();
	</script>
<?php } ?>
</body>
</html>