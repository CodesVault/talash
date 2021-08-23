
function advancedOption() {
	const searchBar = document.querySelector('.search-bar')
	const searchInput = document.querySelector('.search-bar__input')
	const searchInner = document.querySelector('.search-bar__inner')
	const advancedOptions = document.querySelector('.searchify-advanced')
	const searchifyOverlay = document.querySelector('.searchify-overlay')

	searchInput.onfocus = function() {
		if (document.activeElement === searchInput) {
			searchInner.removeAttribute('searchify-tooltip')
		}

		searchBar.classList.add('unfold')
		advancedOptions.classList.add('show')
		searchifyOverlay.classList.add('show')
	}
}

exports.advancedOption = advancedOption
