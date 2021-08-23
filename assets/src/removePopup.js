
function removePopup() {
	const searchBar = document.querySelector('.search-bar');
	const searchResult = document.querySelector('.searchify-result');
	const advancedOptions = document.querySelector('.searchify-advanced');
	const searchInner = document.querySelector('.search-bar__inner');
	const innerPopup = document.querySelectorAll('.searchify-inner-popup');
	const popupInput = document.querySelectorAll('.searchify-popup__input');
	const searchifyOverlay = document.querySelector('.searchify-overlay');
	
	searchifyOverlay.addEventListener('click', function() {
		searchifyOverlay.classList.remove('show')
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

		searchInner.setAttribute('searchify-tooltip', 'CTRL + SHIFT + F')
	});
}

exports.removePopup = removePopup
