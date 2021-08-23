
function advancedOption() {
	const searchBar = document.querySelector('.search-bar')
	const searchInput = document.querySelector('.search-bar__input')
	const searchInner = document.querySelector('.search-bar__inner')
	const advancedOptions = document.querySelector('.talash-advanced')
	const talashOverlay = document.querySelector('.talash-overlay')

	searchInput.onfocus = function() {
		if (document.activeElement === searchInput) {
			searchInner.removeAttribute('talash-tooltip')
		}

		searchBar.classList.add('unfold')
		advancedOptions.classList.add('show')
		talashOverlay.classList.add('show')
	}
}

exports.advancedOption = advancedOption
