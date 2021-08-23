function keyShortCut() {
	const searchify = document.querySelector('#searchify')
	const searchInput = document.querySelector('.search-bar__input')
	const overlay = document.querySelector('.searchify-overlay')

	window.addEventListener('keydown', function(event) {
		if ((event.ctrlKey || event.metaKey) && event.shiftKey && event.key === 'F') {
			searchInput.focus();

			searchify.scrollIntoView({
				behavior: 'smooth'
			});
			window.scroll(100, searchify.offsetTop - 20);
		}

		if (event.key === 'Escape') {
			searchInput.blur()
			overlay.click()
		}
	})
}

exports.keyShortCut = keyShortCut;
