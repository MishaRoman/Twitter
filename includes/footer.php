	</main>
</div>
<div class="modal overlay">
	<div class="container modal__body" id="login-modal">
		<div class="modal-close">
			<button class="modal-close__btn chest-icon"></button>
		</div>
		<section class="wrapper">
			<h2 class="tweet-form__title">Введите логин и пароль</h2>
			<div class="tweet-form__error">Что-то пошло не так</div>
			<div class="tweet-form__subtitle">Если у вас нет логина, пройдите <a href="<?php echo get_url('register.php'); ?>">регистрацию</a></div>
			<form class="tweet-form">
				<div class="tweet-form__wrapper_inputs">
					<input type="text" class="tweet-form__input" placeholder="Логин" required>
					<input type="password" class="tweet-form__input" placeholder="Пароль" required>
				</div>
				<div class="tweet-form__btns_center">
					<button class="tweet-form__btn_center" type="submit">Войти</button>
				</div>
			</form>
		</section>
	</div>
</div>
<script src="<?php echo get_url('js/scripts.js'); ?>"></script>
</body>
</html>