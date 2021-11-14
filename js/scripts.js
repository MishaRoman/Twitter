/*const getResourse = async url => {
	const res = await fetch(url);

	if (!res.ok) {
		throw new Error('Произошла ошибка: ' + res.status)
	}

	return res.json();
};*/

const openModal = function () {
	const overlay = document.getElementById('login-modal').closest('.overlay');
	overlay.style.display = 'block';
};

const closeModal = function (event) {
	const target = event.target,
				overlay = document.getElementById('login-modal').closest('.overlay'),
				closeButton = overlay.querySelector('.modal-close__btn');

	if (target === overlay || target === closeButton)	overlay.style.display = 'none';
};

const loginModalShowButton = document.querySelector('.header__link_profile_fill'),
			loginModal = document.getElementById('login-modal'),
			imgButton = document.querySelector('.tweet-img__btn');

if (loginModalShowButton) {
	loginModalShowButton.addEventListener('click', openModal);
}

if (loginModal) {
	const loginModalOverlay = loginModal.closest('.overlay');
	loginModalOverlay.addEventListener('click', closeModal);
}

if (imgButton) {
	imgButton.addEventListener('click', () => {
		const imgInput = document.getElementById('image-path'),
					imgSpan = document.getElementById('image-span');

		imgUrl = prompt('Введите адрес картинки');
		imgInput.value = imgUrl;
		imgSpan.textContent = imgUrl;
	});
}
