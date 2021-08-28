const {fetchData} = require("./fetchData")
const { reset } = require("./reset")
const { currentState, setState } = require("./state")

function selectAuthor() {
	const authorPopup = document.querySelector('#author-popup')
	const authorPopupInput = document.querySelector('#author-popup__input')
	const authorLi = document.querySelectorAll('.author-li__inner')
	const authorData = document.querySelector('#author-data')
	const authorLabel = document.querySelector('.author-label')

	let authors = ''
	let labels = ''
	if (authorLi) {
		authorLi.forEach((val, index) => {
			authorLi[index].onclick = function(event) {

				if ((event.ctrlKey || event.metaKey)) {
					if (currentState('author') > 1) reset(true, true, true, false)

					authors += authors ? ', ' + authorLi[index].getAttribute('data-authorID') : authorLi[index].getAttribute('data-authorID')
					authorData.value = authors

					labels += labels ? ', ' + authorLi[index].textContent : authorLi[index].textContent
					authorLabel.textContent = labels
					authorLabel.setAttribute('talash-tooltip', labels)
				} else {
					if (authorData.value) reset(true, true, true, false)

					authorLi.forEach((newVal, i) => {
						if (authorLi[i].classList.contains('selected')) {
							authorLi[i].classList.remove('selected')
							authorLi[i].style.borderColor = 'transparent'
						}
					});

					authorLabel.textContent = authorLi[index].childNodes[2].textContent
					authorData.value = authorLi[index].getAttribute('data-authorID')
					authorLabel.removeAttribute('talash-tooltip')

					setTimeout(function() {
						authorPopupInput.classList.remove('show')
						authorPopup.classList.remove('show')
					}, 300)
				}
				
				authorLi[index].style.borderColor = '#00ffad'
				authorLi[index].classList.add('selected')				
			}
		})
	}
}

function changeAuthor() {
	const authorPopupInput = document.querySelector('#author-popup__input');
	const postType = document.querySelector('#postType-data');
	const cat = document.querySelector('#cat-data');
	const loader = document.querySelector('#author-loader');

	const bodyParams = {
		action: 'action=talash_get_authors',
		nonce: '&security=' + talashPublicApi.nonce,
		data: '&talash_data=' + JSON.stringify( { postType: postType.value, catID: cat.value } )
	}
	const args = bodyParams.action + bodyParams.nonce + bodyParams.data

	fetchData(args, false)
		.then( function(data) {
			if (data) {
				loader.classList.remove('show')
				authorPopupInput.classList.add('show')
				authorPopupInput.innerHTML = data

				innerPopupClose();
				selectAuthor();
			}
		})
		.catch( function(error) {
			console.log(error.message);
		});
}

function innerPopupClose() {
	const authorClose = document.querySelector('#author-close')
	const authorPopup = document.querySelector('#author-popup')
	const authorInput = document.querySelector('#author-popup__input')

	authorClose.addEventListener('click', function() {
		authorInput.classList.remove('show')
		authorPopup.classList.remove('show')
	})
}

function getAuthors() {
	const authorList = document.querySelector('.author-list');
	const authorPopup = document.querySelector('#author-popup');
	const loader = document.querySelector('#author-loader');

	authorList.onclick = function() {
		setState('author')
		
		authorPopup.classList.add('show')
		loader.classList.add('show')

		setTimeout(function() {
			changeAuthor()
		}, 300) 
	}
}

exports.getAuthors = getAuthors
