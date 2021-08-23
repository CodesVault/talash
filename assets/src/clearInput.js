
function clearInput() {
	const clearInput = document.querySelector('.search-bar__clear-input');
	const searchInput = document.querySelector('.search-bar__input');

	searchInput.addEventListener('input', function() {
		if (searchInput.value) {
			clearInput.classList.add('show')
		} else {
			clearInput.classList.remove('show')
		}

		clearInput.onclick = function() {
			searchInput.value = ''
			searchInput.focus()
			clearInput.classList.remove('show')
		}
	})
}

exports.clearInput = clearInput
