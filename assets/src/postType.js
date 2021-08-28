const {fetchData} = require("./fetchData")
const {reset} = require("./reset")
const { setState, currentState } = require("./state")

function selectPostType() {
	const postTypePopup = document.querySelector('#postType-popup')
	const postTypeInput = document.querySelector('#postType-popup__input')
	const postTypeListli = document.querySelectorAll('.post-type-li__inner')
	const postTypeLabel = document.querySelector('.postType-label')
	const postTypeData = document.querySelector('#postType-data')

	let postTypes = ''
	let labels = ''
	if (postTypeListli) {
		postTypeListli.forEach((val, index) => {
			postTypeListli[index].onclick = function(event) {
				if ((event.ctrlKey || event.metaKey)) {
					if (currentState('postType') > 1) reset(true, false)

					postTypes += postTypes ? ', ' + postTypeListli[index].getAttribute('data-postType') : postTypeListli[index].getAttribute('data-postType')
					postTypeData.value = postTypes

					labels += labels ? ', ' + postTypeListli[index].textContent : postTypeListli[index].textContent
					postTypeLabel.textContent = labels
					postTypeLabel.setAttribute('talash-tooltip', labels)
				} else {
					if (postTypeData.value) reset(true, false)

					postTypeListli.forEach((newVal, i) => {
						if (postTypeListli[i].classList.contains('selected')) {
							postTypeListli[i].classList.remove('selected')
							postTypeListli[i].style.borderColor = 'transparent'
						}
					});

					postTypeLabel.textContent = postTypeListli[index].textContent
					postTypeData.value = postTypeListli[index].getAttribute('data-postType')
					postTypeLabel.removeAttribute('talash-tooltip')

					setTimeout(function() {
						postTypePopup.classList.remove('show')
						postTypeInput.classList.remove('show')
					}, 300)
				}

				postTypeListli[index].style.borderColor = '#00ffad'
				postTypeListli[index].classList.add('selected')
			}
		})
	}
}

function changePostType() {
	const catData = document.querySelector('#cat-data')
	const authorData = document.querySelector('#author-data')
	const postTypeInput = document.querySelector('#postType-popup__input')
	const postTypeLoader = document.querySelector('#postType-loader')

	const bodyParams = {
		action: 'action=talash_get_post_types',
		nonce: '&security=' + talashPublicApi.nonce,
		data: '&talash_data=' + JSON.stringify( {'catID': catData.value, 'authorID': authorData.value} )
	}
	const args = bodyParams.action + bodyParams.nonce + bodyParams.data

	fetchData(args, false)
		.then( function(data) {
			postTypeLoader.classList.remove('show')
			postTypeInput.innerHTML = data
			postTypeInput.classList.add('show')

			innerPopupClose();
			selectPostType();
		})
		.catch( function(error) {
			console.log(error.message);
		});
}

function innerPopupClose() {
	const postTypeClose = document.querySelector('#postType-close')
	const postTypePopup = document.querySelector('#postType-popup')
	const postTypeInput = document.querySelector('#postType-popup__input')

	postTypeClose.addEventListener('click', function() {
		postTypeInput.classList.remove('show')
		postTypePopup.classList.remove('show')
	})
}

function getPostTypes() {
	const postTypeList = document.querySelector('.post-type-list')
	const postTypePopup = document.querySelector('#postType-popup')
	const postTypeLoader = document.querySelector('#postType-loader')

	postTypeList.onclick = function() {
		setState('postType')

		postTypePopup.classList.add('show')
		postTypeLoader.classList.add('show')

		setTimeout(function() {
			changePostType();
		}, 300)
	}
}

exports.getPostTypes = getPostTypes
