const {fetchData} = require("./fetchData")

function closeSearchPopup() {
	const searchClose = document.querySelector('.talash-result-close')
	const searchInput = document.querySelector('.search-bar__input')
	const searchResult = document.querySelector('.talash-result')
	const searchInner = document.querySelector('.talash-result__inner')
	const innerPopup = document.querySelectorAll('.talash-inner-popup')
	const innerPopupInput = document.querySelectorAll('.talash-popup__input')

	searchClose.addEventListener('click', function() {
		innerPopup.forEach(function(val, key) {
			if (innerPopup[key].classList.contains('show')) {
				innerPopup[key].classList.remove('show')
				innerPopupInput[key].classList.remove('show')
			}
		})

		searchResult.classList.remove('show')
		searchInner.classList.remove('show')
		searchInput.focus()
	})
}

function validation() {
	const searchInput = document.querySelector('.search-bar__input')
	const postType = document.querySelector('#postType-data')
	const catID = document.querySelector('#cat-data')
	const authorID = document.querySelector('#author-data')

	if (searchInput.value == '') {
		if (postType.value == '' && catID.value == '' && authorID.value == '') {
			return false;
		}
	}
	return true;
}

function searchByLog(data) {
	const searchBy = document.querySelector('.talash-search-by')
	const searchInput = document.querySelector('.search-bar__input')
	const postTypeLabel = document.querySelector('.postType-label')
	const catLabel = document.querySelector('.cat-label')
	const authorLabel = document.querySelector('.author-label')

	let searchByData = ''
	searchByData += searchInput.value ? searchInput.getAttribute('data-key') + ': ' + searchInput.value : ''

	searchByData += searchInput.value && data.postType ? '; ' : ''
	searchByData += data.postType ? postTypeLabel.getAttribute('data-label') + ': ' + data.postType : ''

	searchByData += data.postType && data.catID ? '; ' : ''
	searchByData +=  data.catID ? catLabel.getAttribute('data-label') + ': ' + catLabel.textContent : ''

	searchByData += data.catID && data.authorID ? '; ' : ''
	searchByData +=  data.authorID ? authorLabel.getAttribute('data-label') + ': ' + authorLabel.textContent : ''
	searchBy.setAttribute('talash-tooltip', searchByData)
}

function search() {
	const searchInput = document.querySelector('.search-bar__input')
	const searchSubmit = document.querySelector('#talash-form')
	const searchResult = document.querySelector('.talash-result')
	const searchInner = document.querySelector('.talash-result__inner')
	const talashOverlay = document.querySelector('.talash-overlay')
	const loader = document.querySelector('#search-loader')

	function searchCallback(e) {
		e.preventDefault();

		searchInput.focus()
		if (searchInner.classList.contains('show')) {
			searchInner.classList.remove('show')
		}

		const validate = validation();
		if (! validate) {
			return;
		}

		searchResult.classList.add('show')
		talashOverlay.classList.add('show')
		loader.classList.add('show')

		const data = {}
		const formData = new FormData(searchSubmit)
		for (let [key, val] of formData.entries()) {
			// console.log(key, val)
			data[key] = val
		}

		// search by tooltip log
		searchByLog(data)

		const bodyParams = {
			action: 'action=get_search_results',
			nonce: '&security=' + talashPublicApi.nonce,
			data: '&talash_data=' + JSON.stringify(data)
		}
		const args = bodyParams.action + bodyParams.nonce + bodyParams.data
		fetchData(args, false)
			.then( function(data) {
				setTimeout(function() {
					loader.classList.remove('show')
					searchInner.classList.add('show')
					searchInner.innerHTML = data
				}, 300)
			})
			.catch( function(error) {
				console.log(error);
			});

		closeSearchPopup();
	}

	// search submit
	searchSubmit.addEventListener('submit', searchCallback);
}

exports.search = search
