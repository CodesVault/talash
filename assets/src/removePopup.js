
function removePopup() {
	const searchBar = document.querySelector('.search-bar');
	const searchResult = document.querySelector('.talash-result');
	const advancedOptions = document.querySelector('.talash-advanced');
	const searchInner = document.querySelector('.search-bar__inner');
	const innerPopup = document.querySelectorAll('.talash-inner-popup');
	const popupInput = document.querySelectorAll('.talash-popup__input');
	const talashOverlay = document.querySelector('.talash-overlay');
	
	talashOverlay.addEventListener('click', function() {
		talashOverlay.classList.remove('show')
		searchBar.classList.remove('unfold')

		if (advancedOptions.classList.contains('show')) {
			advancedOptions.classList.remove('show')
		}

		innerPopup.forEach( function(popup, index) {
			if (innerPopup[index].classList.contains('show')) {
				innerPopup[index].classList.remove('show')
			}
		})

		popupInput.forEach( function(popup, index) {
			if (popupInput[index].classList.contains('show')) {
				popupInput[index].classList.remove('show')
			}
		})

		if (searchResult.classList.contains('show')) {
			searchResult.classList.remove('show')
		}

		searchInner.setAttribute('talash-tooltip', 'CTRL + SHIFT + F')
	});
}

exports.removePopup = removePopup
