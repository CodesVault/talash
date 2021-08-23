const {fetchData} = require("./fetchData")
const {reset} = require("./reset")
const { setState, currentState } = require("./state")

function selectCat() {
	const catLi = document.querySelectorAll('.cat-li__inner');
	const catLabel = document.querySelector('.cat-label');
	const catData = document.querySelector('#cat-data');
	const catPopup = document.querySelector('#cat-popup');
	const catPopupInput = document.querySelector('#cat-popup__input');

	let cats = ''
	let labels = ''
	if (catLi) {
		catLi.forEach((val, index) => {
			catLi[index].onclick = function(event) {
				if ((event.ctrlKey || event.metaKey)) {
					if (currentState('cat') > 1) reset(true, true, false)

					cats += cats ? ', ' + catLi[index].getAttribute('data-catID') : catLi[index].getAttribute('data-catID')
					catData.value = cats

					labels += labels ? ', ' + catLi[index].textContent : catLi[index].textContent
					catLabel.textContent = labels
					catLabel.setAttribute('searchify-tooltip', labels)
				} else {
					if (catData.value) reset(true, true, false)
					
					catLi.forEach((newVal, i) => {
						if (catLi[i].classList.contains('selected')) {
							catLi[i].classList.remove('selected')
							catLi[i].style.borderColor = 'transparent'
						}
					});

					catLabel.textContent = catLi[index].textContent
					catData.value = catLi[index].getAttribute('data-catID')
					catLabel.removeAttribute('searchify-tooltip')

					setTimeout(function() {
						catPopup.classList.remove('show')
						catPopupInput.classList.remove('show')
					}, 300)
				}

				catLi[index].style.borderColor = '#00ffad'
				catLi[index].classList.add('selected')
			}
		})
	}
}

const changeCat = () => {
	const catLoader = document.querySelector('#cat-loader');
	const catPopupInput = document.querySelector('#cat-popup__input');
	const postType = document.querySelector('#postType-data');
	const authorData = document.querySelector('#author-data');

	const bodyParams = {
		action: 'action=talash_get_categories',
		nonce: '&security=' + talashPublicApi.nonce,
		data: '&talash_data=' + JSON.stringify( {'postType': postType.value, 'authorID': authorData.value} )
	}
	const args = bodyParams.action + bodyParams.nonce + bodyParams.data

	fetchData(args)
		.then(function(data) {
			if (data != 'error') {
				// console.log(data)
				catLoader.classList.remove('show')

				let options = ''
				data.forEach(element => {
					options += `<li class='cat-li'><div class='cat-li__inner' data-catID=${element.term_id}>${element.name}</div></li>`
				});
				catPopupInput.innerHTML = options
				catPopupInput.classList.add('show')

				innerPopupClose();
				selectCat();
			}
		})
		.catch( function(error) {
			console.log(error.message);
		});
}

function innerPopupClose() {
	const catClose = document.querySelector('#cat-close')
	const catPopup = document.querySelector('#cat-popup')
	const catInput = document.querySelector('#cat-popup__input')

	catClose.addEventListener('click', function() {
		catInput.classList.remove('show')
		catPopup.classList.remove('show')
	})
}

function getCategories() {
	const catList = document.querySelector('.category-list');
	const catPopup = document.querySelector('#cat-popup');
	const catPopupInput = document.querySelector('#cat-popup__input');
	const catLoader = document.querySelector('#cat-loader');
	
	catList.onclick = function() {
		setState('cat')

		if (catPopupInput.classList.contains('show')) {
			catPopupInput.classList.remove('show')
		}
		catPopup.classList.add('show')
		catLoader.classList.add('show')

		setTimeout(function() {
			changeCat()
		}, 300) 
	}
}

exports.getCategories = getCategories
