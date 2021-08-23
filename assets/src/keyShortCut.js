function keyShortCut() {
	const talash = document.querySelector('#talash')
	const searchInput = document.querySelector('.search-bar__input')
	const overlay = document.querySelector('.talash-overlay')

	window.addEventListener('keydown', function(event) {
		if ((event.ctrlKey || event.metaKey) && event.shiftKey && event.key === 'F') {
			searchInput.focus();

			talash.scrollIntoView({
				behavior: 'smooth'
			});
			window.scroll(100, talash.offsetTop - 20);
		}

		if (event.key === 'Escape') {
			searchInput.blur()
			overlay.click()
		}
	})
}

exports.keyShortCut = keyShortCut;
