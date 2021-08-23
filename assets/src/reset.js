const { resetState } = require("./state")

function reset(optionReset = false, postTypeReset = true, catReset = true, authorReset = true) {
	const reset = document.querySelector('.searchify-reset')
	const postTypeData = document.querySelector('#postType-data')
	const postTypeLabel = document.querySelector('.postType-label')
	const postTypeInput = document.querySelector('#postType-popup__input')

	const catData = document.querySelector('#cat-data')
	const catLabel = document.querySelector('.cat-label')
	const catPopupInput = document.querySelector('#cat-popup__input')

	const authorData = document.querySelector('#author-data')
	const authorLabel = document.querySelector('.author-label');
	const authorPopupInput = document.querySelector('#author-popup__input')

	const resetCallback = () => {
		if (postTypeReset) {
			postTypeInput.innerHTML = ''
			postTypeData.value = ''
			postTypeLabel.textContent = postTypeLabel.getAttribute('data-label')
		}
		
		if (catReset) {
			catPopupInput.innerHTML = ''
			catData.value = ''
			catLabel.textContent = catLabel.getAttribute('data-label')
		}

		if (authorReset) {
			authorPopupInput.innerHTML = ''
			authorData.value = ''
			authorLabel.textContent = authorLabel.getAttribute('data-label')
		}

		resetState()
	}

	if (! optionReset) {
		reset.addEventListener('click', resetCallback);
	} else {
		resetCallback()
	}
}

exports.reset = reset
