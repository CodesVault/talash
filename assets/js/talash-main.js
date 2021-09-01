/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/advancedOptions.js":
/*!***************************************!*\
  !*** ./assets/src/advancedOptions.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, exports) => {

eval("\nfunction advancedOption() {\n\tconst searchBar = document.querySelector('.search-bar')\n\tconst searchInput = document.querySelector('.search-bar__input')\n\tconst searchInner = document.querySelector('.search-bar__inner')\n\tconst advancedOptions = document.querySelector('.talash-advanced')\n\tconst talashOverlay = document.querySelector('.talash-overlay')\n\n\tsearchInput.onfocus = function() {\n\t\tif (document.activeElement === searchInput) {\n\t\t\tsearchInner.removeAttribute('talash-tooltip')\n\t\t}\n\n\t\tsearchBar.classList.add('unfold')\n\t\tadvancedOptions.classList.add('show')\n\t\ttalashOverlay.classList.add('show')\n\t}\n}\n\nexports.advancedOption = advancedOption\n\n\n//# sourceURL=webpack://talash/./assets/src/advancedOptions.js?");

/***/ }),

/***/ "./assets/src/author.js":
/*!******************************!*\
  !*** ./assets/src/author.js ***!
  \******************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

eval("const {fetchData} = __webpack_require__(/*! ./fetchData */ \"./assets/src/fetchData.js\")\nconst { reset } = __webpack_require__(/*! ./reset */ \"./assets/src/reset.js\")\nconst { currentState, setState } = __webpack_require__(/*! ./state */ \"./assets/src/state.js\")\n\nfunction selectAuthor() {\n\tconst authorPopup = document.querySelector('#author-popup')\n\tconst authorPopupInput = document.querySelector('#author-popup__input')\n\tconst authorLi = document.querySelectorAll('.author-li__inner')\n\tconst authorData = document.querySelector('#author-data')\n\tconst authorLabel = document.querySelector('.author-label')\n\n\tlet authors = ''\n\tlet labels = ''\n\tif (authorLi) {\n\t\tauthorLi.forEach((val, index) => {\n\t\t\tauthorLi[index].onclick = function(event) {\n\t\t\t\tif ((event.ctrlKey || event.metaKey)) {\n\t\t\t\t\tif (currentState('author') > 1) reset(true, true, true, false)\n\n\t\t\t\t\tauthors += authors ? ', ' + authorLi[index].getAttribute('data-authorID') : authorLi[index].getAttribute('data-authorID')\n\t\t\t\t\tauthorData.value = authors\n\n\t\t\t\t\tlabels += labels ? ', ' + authorLi[index].textContent : authorLi[index].textContent\n\t\t\t\t\tauthorLabel.textContent = labels\n\t\t\t\t\tauthorLabel.setAttribute('talash-tooltip', labels)\n\t\t\t\t} else {\n\t\t\t\t\tif (authorData.value) reset(true, true, true, false)\n\n\t\t\t\t\tauthorLi.forEach((newVal, i) => {\n\t\t\t\t\t\tif (authorLi[i].classList.contains('selected')) {\n\t\t\t\t\t\t\tauthorLi[i].classList.remove('selected')\n\t\t\t\t\t\t\tauthorLi[i].style.borderColor = 'transparent'\n\t\t\t\t\t\t}\n\t\t\t\t\t});\n\n\t\t\t\t\tauthorLabel.textContent = authorLi[index].childNodes[3].textContent\n\t\t\t\t\tauthorData.value = authorLi[index].getAttribute('data-authorID')\n\t\t\t\t\tauthorLabel.removeAttribute('talash-tooltip')\n\n\t\t\t\t\tsetTimeout(function() {\n\t\t\t\t\t\tauthorPopupInput.classList.remove('show')\n\t\t\t\t\t\tauthorPopup.classList.remove('show')\n\t\t\t\t\t}, 300)\n\t\t\t\t}\n\t\t\t\t\n\t\t\t\tauthorLi[index].style.borderColor = '#00ffad'\n\t\t\t\tauthorLi[index].classList.add('selected')\t\t\t\t\n\t\t\t}\n\t\t})\n\t}\n}\n\nfunction changeAuthor() {\n\tconst authorPopupInput = document.querySelector('#author-popup__input');\n\tconst postType = document.querySelector('#postType-data');\n\tconst cat = document.querySelector('#cat-data');\n\tconst loader = document.querySelector('#author-loader');\n\n\tconst bodyParams = {\n\t\taction: 'action=talash_get_authors',\n\t\tnonce: '&security=' + talashPublicApi.nonce,\n\t\tdata: '&talash_data=' + JSON.stringify( { postType: postType.value, catID: cat.value } )\n\t}\n\tconst args = bodyParams.action + bodyParams.nonce + bodyParams.data\n\n\tfetchData(args, false)\n\t\t.then( function(data) {\n\t\t\tloader.classList.remove('show')\n\t\t\tauthorPopupInput.classList.add('show')\n\t\t\tauthorPopupInput.innerHTML = data\n\n\t\t\tinnerPopupClose();\n\t\t\tselectAuthor();\n\t\t})\n\t\t.catch( function(error) {\n\t\t\tconsole.log(error.message);\n\t\t});\n}\n\nfunction innerPopupClose() {\n\tconst authorClose = document.querySelector('#author-close')\n\tconst authorPopup = document.querySelector('#author-popup')\n\tconst authorInput = document.querySelector('#author-popup__input')\n\n\tauthorClose.addEventListener('click', function() {\n\t\tauthorInput.classList.remove('show')\n\t\tauthorPopup.classList.remove('show')\n\t})\n}\n\nfunction getAuthors() {\n\tconst authorList = document.querySelector('.author-list');\n\tconst authorPopup = document.querySelector('#author-popup');\n\tconst loader = document.querySelector('#author-loader');\n\n\tauthorList.onclick = function() {\n\t\tsetState('author')\n\t\t\n\t\tauthorPopup.classList.add('show')\n\t\tloader.classList.add('show')\n\n\t\tsetTimeout(function() {\n\t\t\tchangeAuthor()\n\t\t}, 300) \n\t}\n}\n\nexports.getAuthors = getAuthors\n\n\n//# sourceURL=webpack://talash/./assets/src/author.js?");

/***/ }),

/***/ "./assets/src/category.js":
/*!********************************!*\
  !*** ./assets/src/category.js ***!
  \********************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

eval("const {fetchData} = __webpack_require__(/*! ./fetchData */ \"./assets/src/fetchData.js\")\nconst {reset} = __webpack_require__(/*! ./reset */ \"./assets/src/reset.js\")\nconst { setState, currentState } = __webpack_require__(/*! ./state */ \"./assets/src/state.js\")\n\nfunction selectCat() {\n\tconst catLi = document.querySelectorAll('.cat-li__inner');\n\tconst catLabel = document.querySelector('.cat-label');\n\tconst catData = document.querySelector('#cat-data');\n\tconst catPopup = document.querySelector('#cat-popup');\n\tconst catPopupInput = document.querySelector('#cat-popup__input');\n\n\tlet cats = ''\n\tlet labels = ''\n\tif (catLi) {\n\t\tcatLi.forEach((val, index) => {\n\t\t\tcatLi[index].onclick = function(event) {\n\t\t\t\tif ((event.ctrlKey || event.metaKey)) {\n\t\t\t\t\tif (currentState('cat') > 1) reset(true, true, false)\n\n\t\t\t\t\tcats += cats ? ', ' + catLi[index].getAttribute('data-catID') : catLi[index].getAttribute('data-catID')\n\t\t\t\t\tcatData.value = cats\n\n\t\t\t\t\tlabels += labels ? ', ' + catLi[index].textContent : catLi[index].textContent\n\t\t\t\t\tcatLabel.textContent = labels\n\t\t\t\t\tcatLabel.setAttribute('talash-tooltip', labels)\n\t\t\t\t} else {\n\t\t\t\t\tif (catData.value) reset(true, true, false)\n\t\t\t\t\t\n\t\t\t\t\tcatLi.forEach((newVal, i) => {\n\t\t\t\t\t\tif (catLi[i].classList.contains('selected')) {\n\t\t\t\t\t\t\tcatLi[i].classList.remove('selected')\n\t\t\t\t\t\t\tcatLi[i].style.borderColor = 'transparent'\n\t\t\t\t\t\t}\n\t\t\t\t\t});\n\n\t\t\t\t\tcatLabel.textContent = catLi[index].textContent\n\t\t\t\t\tcatData.value = catLi[index].getAttribute('data-catID')\n\t\t\t\t\tcatLabel.removeAttribute('talash-tooltip')\n\n\t\t\t\t\tsetTimeout(function() {\n\t\t\t\t\t\tcatPopup.classList.remove('show')\n\t\t\t\t\t\tcatPopupInput.classList.remove('show')\n\t\t\t\t\t}, 300)\n\t\t\t\t}\n\n\t\t\t\tcatLi[index].style.borderColor = '#00ffad'\n\t\t\t\tcatLi[index].classList.add('selected')\n\t\t\t}\n\t\t})\n\t}\n}\n\nconst changeCat = () => {\n\tconst catLoader = document.querySelector('#cat-loader');\n\tconst catPopupInput = document.querySelector('#cat-popup__input');\n\tconst postType = document.querySelector('#postType-data');\n\tconst authorData = document.querySelector('#author-data');\n\n\tconst bodyParams = {\n\t\taction: 'action=talash_get_categories',\n\t\tnonce: '&security=' + talashPublicApi.nonce,\n\t\tdata: '&talash_data=' + JSON.stringify( {'postType': postType.value, 'authorID': authorData.value} )\n\t}\n\tconst args = bodyParams.action + bodyParams.nonce + bodyParams.data\n\n\tfetchData(args, false)\n\t\t.then(function(data) {\n\t\t\tcatLoader.classList.remove('show')\n\t\t\tcatPopupInput.innerHTML = data\n\t\t\tcatPopupInput.classList.add('show')\n\n\t\t\tinnerPopupClose();\n\t\t\tselectCat();\n\t\t})\n\t\t.catch( function(error) {\n\t\t\tconsole.log(error.message);\n\t\t});\n}\n\nfunction innerPopupClose() {\n\tconst catClose = document.querySelector('#cat-close')\n\tconst catPopup = document.querySelector('#cat-popup')\n\tconst catInput = document.querySelector('#cat-popup__input')\n\n\tcatClose.addEventListener('click', function() {\n\t\tcatInput.classList.remove('show')\n\t\tcatPopup.classList.remove('show')\n\t})\n}\n\nfunction getCategories() {\n\tconst catList = document.querySelector('.category-list');\n\tconst catPopup = document.querySelector('#cat-popup');\n\tconst catPopupInput = document.querySelector('#cat-popup__input');\n\tconst catLoader = document.querySelector('#cat-loader');\n\t\n\tcatList.onclick = function() {\n\t\tsetState('cat')\n\n\t\tif (catPopupInput.classList.contains('show')) {\n\t\t\tcatPopupInput.classList.remove('show')\n\t\t}\n\t\tcatPopup.classList.add('show')\n\t\tcatLoader.classList.add('show')\n\n\t\tsetTimeout(function() {\n\t\t\tchangeCat()\n\t\t}, 300) \n\t}\n}\n\nexports.getCategories = getCategories\n\n\n//# sourceURL=webpack://talash/./assets/src/category.js?");

/***/ }),

/***/ "./assets/src/clearInput.js":
/*!**********************************!*\
  !*** ./assets/src/clearInput.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, exports) => {

eval("\nfunction clearInput() {\n\tconst clearInput = document.querySelector('.search-bar__clear-input');\n\tconst searchInput = document.querySelector('.search-bar__input');\n\n\tsearchInput.addEventListener('input', function() {\n\t\tif (searchInput.value) {\n\t\t\tclearInput.classList.add('show')\n\t\t} else {\n\t\t\tclearInput.classList.remove('show')\n\t\t}\n\n\t\tclearInput.onclick = function() {\n\t\t\tsearchInput.value = ''\n\t\t\tsearchInput.focus()\n\t\t\tclearInput.classList.remove('show')\n\t\t}\n\t})\n}\n\nexports.clearInput = clearInput\n\n\n//# sourceURL=webpack://talash/./assets/src/clearInput.js?");

/***/ }),

/***/ "./assets/src/datePicker.js":
/*!**********************************!*\
  !*** ./assets/src/datePicker.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, exports) => {

eval("\nfunction dateRangePicker() {\n\t(function($) {\n\t\tvar start = moment().subtract(364, 'days');\n\t\tvar end = moment();\n\n\t\tfunction cb(start, end) {\n\t\t\t$('.date-range__input span').html(start.format('MMM D, YY') + ' - ' + end.format('MMM D, YY'));\n\t\t\t$('.dateRange').html(start.format('YYYY-MM-D') + ' - ' + end.format('YYYY-MM-D'));\n\t\t\t$('.dateRangeStart').val(start.format('YYYY-MM-D') + ' 00:00:00');\n\t\t\t$('.dateRangeEnd').val(end.format('YYYY-MM-D') + ' 23:59:59')\n\t\t}\n\n\t\t$('.date-range__input').daterangepicker({\n\t\t\tstartDate: start,\n\t\t\tendDate: end,\n\t\t\tranges: {\n\t\t\t\t'All Time': [moment().subtract(50, 'years'), moment()],\n\t\t\t\t'Today': [moment(), moment()],\n\t\t\t\t'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],\n\t\t\t\t'Last 7 Days': [moment().subtract(6, 'days'), moment()],\n\t\t\t\t'Last 30 Days': [moment().subtract(29, 'days'), moment()],\n\t\t\t\t'This Month': [moment().startOf('month'), moment().endOf('month')],\n\t\t\t\t'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],\n\t\t\t\t'Last 1 Year': [moment().subtract(364, 'days'), moment()]\n\t\t\t}\n\t\t}, cb);\n\n\t\tcb(start, end);\n\t})( jQuery );\n}\n\nexports.dateRangePicker = dateRangePicker\n\n\n//# sourceURL=webpack://talash/./assets/src/datePicker.js?");

/***/ }),

/***/ "./assets/src/fetchData.js":
/*!*********************************!*\
  !*** ./assets/src/fetchData.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, exports) => {

eval("async function fetchData(args, json = true) {\n\tconst res = await fetch(talashPublicApi.ajax_url,\n\t\t{\n\t\t\tmethod: 'POST',\n\t\t\theaders: { 'Content-Type': 'application/x-www-form-urlencoded' },\n\t\t\tbody: args\n\t\t}\n\t)\n\n\tif (json) {\n\t\treturn res.json();\n\t}\n\treturn res.text();\n}\n\nexports.fetchData = fetchData\n\n\n//# sourceURL=webpack://talash/./assets/src/fetchData.js?");

/***/ }),

/***/ "./assets/src/keyShortCut.js":
/*!***********************************!*\
  !*** ./assets/src/keyShortCut.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, exports) => {

eval("function keyShortCut() {\n\tconst talash = document.querySelector('#talash')\n\tconst searchInput = document.querySelector('.search-bar__input')\n\tconst overlay = document.querySelector('.talash-overlay')\n\n\twindow.addEventListener('keydown', function(event) {\n\t\tif ((event.ctrlKey || event.metaKey) && event.shiftKey && event.key === 'F') {\n\t\t\tsearchInput.focus();\n\n\t\t\ttalash.scrollIntoView({\n\t\t\t\tbehavior: 'smooth'\n\t\t\t});\n\t\t\twindow.scroll(100, talash.offsetTop - 20);\n\t\t}\n\n\t\tif (event.key === 'Escape') {\n\t\t\tsearchInput.blur()\n\t\t\toverlay.click()\n\t\t}\n\t})\n}\n\nexports.keyShortCut = keyShortCut;\n\n\n//# sourceURL=webpack://talash/./assets/src/keyShortCut.js?");

/***/ }),

/***/ "./assets/src/main.js":
/*!****************************!*\
  !*** ./assets/src/main.js ***!
  \****************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

eval("const {clearInput} = __webpack_require__(/*! ./clearInput */ \"./assets/src/clearInput.js\")\nconst { advancedOption } = __webpack_require__(/*! ./advancedOptions */ \"./assets/src/advancedOptions.js\")\nconst { search } = __webpack_require__(/*! ./search */ \"./assets/src/search.js\")\nconst { removePopup } = __webpack_require__(/*! ./removePopup */ \"./assets/src/removePopup.js\")\nconst { getPostTypes } = __webpack_require__(/*! ./postType */ \"./assets/src/postType.js\")\nconst { getCategories } = __webpack_require__(/*! ./category */ \"./assets/src/category.js\")\nconst { dateRangePicker } = __webpack_require__(/*! ./datePicker */ \"./assets/src/datePicker.js\")\nconst { getAuthors } = __webpack_require__(/*! ./author */ \"./assets/src/author.js\")\nconst { reset } = __webpack_require__(/*! ./reset */ \"./assets/src/reset.js\")\nconst { keyShortCut } = __webpack_require__(/*! ./keyShortCut */ \"./assets/src/keyShortCut.js\")\n\ndocument.addEventListener(\"DOMContentLoaded\", function() {\n\tconst talash = document.querySelector('#talash');\n\tif (talash && (document.readyState === \"interactive\" || document.readyState === \"complete\") ) {\n\t\tkeyShortCut();\n\t\tclearInput();\n\t\tadvancedOption();\n\t\tsearch();\n\t\tremovePopup();\n\t\tgetPostTypes();\n\t\tgetCategories();\n\t\tdateRangePicker();\n\t\tgetAuthors();\n\t\treset();\n\t}\n});\n\n\n//# sourceURL=webpack://talash/./assets/src/main.js?");

/***/ }),

/***/ "./assets/src/postType.js":
/*!********************************!*\
  !*** ./assets/src/postType.js ***!
  \********************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

eval("const {fetchData} = __webpack_require__(/*! ./fetchData */ \"./assets/src/fetchData.js\")\nconst {reset} = __webpack_require__(/*! ./reset */ \"./assets/src/reset.js\")\nconst { setState, currentState } = __webpack_require__(/*! ./state */ \"./assets/src/state.js\")\n\nfunction selectPostType() {\n\tconst postTypePopup = document.querySelector('#postType-popup')\n\tconst postTypeInput = document.querySelector('#postType-popup__input')\n\tconst postTypeListli = document.querySelectorAll('.post-type-li__inner')\n\tconst postTypeLabel = document.querySelector('.postType-label')\n\tconst postTypeData = document.querySelector('#postType-data')\n\n\tlet postTypes = ''\n\tlet labels = ''\n\tif (postTypeListli) {\n\t\tpostTypeListli.forEach((val, index) => {\n\t\t\tpostTypeListli[index].onclick = function(event) {\n\t\t\t\tif ((event.ctrlKey || event.metaKey)) {\n\t\t\t\t\tif (currentState('postType') > 1) reset(true, false)\n\n\t\t\t\t\tpostTypes += postTypes ? ', ' + postTypeListli[index].getAttribute('data-postType') : postTypeListli[index].getAttribute('data-postType')\n\t\t\t\t\tpostTypeData.value = postTypes\n\n\t\t\t\t\tlabels += labels ? ', ' + postTypeListli[index].textContent : postTypeListli[index].textContent\n\t\t\t\t\tpostTypeLabel.textContent = labels\n\t\t\t\t\tpostTypeLabel.setAttribute('talash-tooltip', labels)\n\t\t\t\t} else {\n\t\t\t\t\tif (postTypeData.value) reset(true, false)\n\n\t\t\t\t\tpostTypeListli.forEach((newVal, i) => {\n\t\t\t\t\t\tif (postTypeListli[i].classList.contains('selected')) {\n\t\t\t\t\t\t\tpostTypeListli[i].classList.remove('selected')\n\t\t\t\t\t\t\tpostTypeListli[i].style.borderColor = 'transparent'\n\t\t\t\t\t\t}\n\t\t\t\t\t});\n\n\t\t\t\t\tpostTypeLabel.textContent = postTypeListli[index].textContent\n\t\t\t\t\tpostTypeData.value = postTypeListli[index].getAttribute('data-postType')\n\t\t\t\t\tpostTypeLabel.removeAttribute('talash-tooltip')\n\n\t\t\t\t\tsetTimeout(function() {\n\t\t\t\t\t\tpostTypePopup.classList.remove('show')\n\t\t\t\t\t\tpostTypeInput.classList.remove('show')\n\t\t\t\t\t}, 300)\n\t\t\t\t}\n\n\t\t\t\tpostTypeListli[index].style.borderColor = '#00ffad'\n\t\t\t\tpostTypeListli[index].classList.add('selected')\n\t\t\t}\n\t\t})\n\t}\n}\n\nfunction changePostType() {\n\tconst catData = document.querySelector('#cat-data')\n\tconst authorData = document.querySelector('#author-data')\n\tconst postTypeInput = document.querySelector('#postType-popup__input')\n\tconst postTypeLoader = document.querySelector('#postType-loader')\n\n\tconst bodyParams = {\n\t\taction: 'action=talash_get_post_types',\n\t\tnonce: '&security=' + talashPublicApi.nonce,\n\t\tdata: '&talash_data=' + JSON.stringify( {'catID': catData.value, 'authorID': authorData.value} )\n\t}\n\tconst args = bodyParams.action + bodyParams.nonce + bodyParams.data\n\n\tfetchData(args, false)\n\t\t.then( function(data) {\n\t\t\tpostTypeLoader.classList.remove('show')\n\t\t\tpostTypeInput.innerHTML = data\n\t\t\tpostTypeInput.classList.add('show')\n\n\t\t\tinnerPopupClose();\n\t\t\tselectPostType();\n\t\t})\n\t\t.catch( function(error) {\n\t\t\tconsole.log(error.message);\n\t\t});\n}\n\nfunction innerPopupClose() {\n\tconst postTypeClose = document.querySelector('#postType-close')\n\tconst postTypePopup = document.querySelector('#postType-popup')\n\tconst postTypeInput = document.querySelector('#postType-popup__input')\n\n\tpostTypeClose.addEventListener('click', function() {\n\t\tpostTypeInput.classList.remove('show')\n\t\tpostTypePopup.classList.remove('show')\n\t})\n}\n\nfunction getPostTypes() {\n\tconst postTypeList = document.querySelector('.post-type-list')\n\tconst postTypePopup = document.querySelector('#postType-popup')\n\tconst postTypeLoader = document.querySelector('#postType-loader')\n\n\tpostTypeList.onclick = function() {\n\t\tsetState('postType')\n\n\t\tpostTypePopup.classList.add('show')\n\t\tpostTypeLoader.classList.add('show')\n\n\t\tsetTimeout(function() {\n\t\t\tchangePostType();\n\t\t}, 300)\n\t}\n}\n\nexports.getPostTypes = getPostTypes\n\n\n//# sourceURL=webpack://talash/./assets/src/postType.js?");

/***/ }),

/***/ "./assets/src/removePopup.js":
/*!***********************************!*\
  !*** ./assets/src/removePopup.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, exports) => {

eval("\nfunction removePopup() {\n\tconst searchBar = document.querySelector('.search-bar');\n\tconst searchResult = document.querySelector('.talash-result');\n\tconst advancedOptions = document.querySelector('.talash-advanced');\n\tconst searchInner = document.querySelector('.search-bar__inner');\n\tconst innerPopup = document.querySelectorAll('.talash-inner-popup');\n\tconst popupInput = document.querySelectorAll('.talash-popup__input');\n\tconst talashOverlay = document.querySelector('.talash-overlay');\n\t\n\ttalashOverlay.addEventListener('click', function() {\n\t\ttalashOverlay.classList.remove('show')\n\t\tsearchBar.classList.remove('unfold')\n\n\t\tif (advancedOptions.classList.contains('show')) {\n\t\t\tadvancedOptions.classList.remove('show')\n\t\t}\n\n\t\tinnerPopup.forEach( function(popup, index) {\n\t\t\tif (innerPopup[index].classList.contains('show')) {\n\t\t\t\tinnerPopup[index].classList.remove('show')\n\t\t\t}\n\t\t})\n\n\t\tpopupInput.forEach( function(popup, index) {\n\t\t\tif (popupInput[index].classList.contains('show')) {\n\t\t\t\tpopupInput[index].classList.remove('show')\n\t\t\t}\n\t\t})\n\n\t\tif (searchResult.classList.contains('show')) {\n\t\t\tsearchResult.classList.remove('show')\n\t\t}\n\n\t\tsearchInner.setAttribute('talash-tooltip', 'CTRL + SHIFT + F')\n\t});\n}\n\nexports.removePopup = removePopup\n\n\n//# sourceURL=webpack://talash/./assets/src/removePopup.js?");

/***/ }),

/***/ "./assets/src/reset.js":
/*!*****************************!*\
  !*** ./assets/src/reset.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

eval("const { resetState } = __webpack_require__(/*! ./state */ \"./assets/src/state.js\")\n\nfunction reset(optionReset = false, postTypeReset = true, catReset = true, authorReset = true) {\n\tconst reset = document.querySelector('.talash-reset')\n\tconst postTypeData = document.querySelector('#postType-data')\n\tconst postTypeLabel = document.querySelector('.postType-label')\n\tconst postTypeInput = document.querySelector('#postType-popup__input')\n\n\tconst catData = document.querySelector('#cat-data')\n\tconst catLabel = document.querySelector('.cat-label')\n\tconst catPopupInput = document.querySelector('#cat-popup__input')\n\n\tconst authorData = document.querySelector('#author-data')\n\tconst authorLabel = document.querySelector('.author-label');\n\tconst authorPopupInput = document.querySelector('#author-popup__input')\n\n\tconst resetCallback = () => {\n\t\tif (postTypeReset) {\n\t\t\tpostTypeInput.innerHTML = ''\n\t\t\tpostTypeData.value = ''\n\t\t\tpostTypeLabel.textContent = postTypeLabel.getAttribute('data-label')\n\t\t}\n\t\t\n\t\tif (catReset) {\n\t\t\tcatPopupInput.innerHTML = ''\n\t\t\tcatData.value = ''\n\t\t\tcatLabel.textContent = catLabel.getAttribute('data-label')\n\t\t}\n\n\t\tif (authorReset) {\n\t\t\tauthorPopupInput.innerHTML = ''\n\t\t\tauthorData.value = ''\n\t\t\tauthorLabel.textContent = authorLabel.getAttribute('data-label')\n\t\t}\n\n\t\tresetState()\n\t}\n\n\tif (! optionReset) {\n\t\treset.addEventListener('click', resetCallback);\n\t} else {\n\t\tresetCallback()\n\t}\n}\n\nexports.reset = reset\n\n\n//# sourceURL=webpack://talash/./assets/src/reset.js?");

/***/ }),

/***/ "./assets/src/search.js":
/*!******************************!*\
  !*** ./assets/src/search.js ***!
  \******************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

eval("const {fetchData} = __webpack_require__(/*! ./fetchData */ \"./assets/src/fetchData.js\")\n\nfunction closeSearchPopup() {\n\tconst searchClose = document.querySelector('.talash-result-close')\n\tconst searchInput = document.querySelector('.search-bar__input')\n\tconst searchResult = document.querySelector('.talash-result')\n\tconst searchInner = document.querySelector('.talash-result__inner')\n\tconst innerPopup = document.querySelectorAll('.talash-inner-popup')\n\tconst innerPopupInput = document.querySelectorAll('.talash-popup__input')\n\n\tsearchClose.addEventListener('click', function() {\n\t\tinnerPopup.forEach(function(val, key) {\n\t\t\tif (innerPopup[key].classList.contains('show')) {\n\t\t\t\tinnerPopup[key].classList.remove('show')\n\t\t\t\tinnerPopupInput[key].classList.remove('show')\n\t\t\t}\n\t\t})\n\n\t\tsearchResult.classList.remove('show')\n\t\tsearchInner.classList.remove('show')\n\t\tsearchInput.focus()\n\t})\n}\n\nfunction validation() {\n\tconst searchInput = document.querySelector('.search-bar__input')\n\tconst postType = document.querySelector('#postType-data')\n\tconst catID = document.querySelector('#cat-data')\n\tconst authorID = document.querySelector('#author-data')\n\tconst searchResult = document.querySelector('.talash-result')\n\n\tif (searchInput.value == '') {\n\t\tif (postType.value == '' && catID.value == '' && authorID.value == '') {\n\t\t\tif (searchResult.classList.contains('show')) {\n\t\t\t\tsearchResult.classList.remove('show')\n\t\t\t}\n\t\t\treturn false;\n\t\t}\n\t}\n\treturn true;\n}\n\nfunction searchByLog(data) {\n\tconst searchBy = document.querySelector('.talash-search-by')\n\tconst searchInput = document.querySelector('.search-bar__input')\n\tconst postTypeLabel = document.querySelector('.postType-label')\n\tconst catLabel = document.querySelector('.cat-label')\n\tconst authorLabel = document.querySelector('.author-label')\n\n\tlet searchByData = ''\n\tsearchByData += searchInput.value ? searchInput.getAttribute('data-key') + ': ' + searchInput.value : ''\n\n\tsearchByData += searchInput.value && data.postType ? '; ' : ''\n\tsearchByData += data.postType ? postTypeLabel.getAttribute('data-label') + ': ' + data.postType : ''\n\n\tsearchByData += data.postType && data.catID ? '; ' : ''\n\tsearchByData +=  data.catID ? catLabel.getAttribute('data-label') + ': ' + catLabel.textContent : ''\n\n\tsearchByData += data.catID && data.authorID ? '; ' : ''\n\tsearchByData +=  data.authorID ? authorLabel.getAttribute('data-label') + ': ' + authorLabel.textContent : ''\n\tsearchBy.setAttribute('talash-tooltip', searchByData)\n}\n\nfunction search() {\n\tconst searchInput = document.querySelector('.search-bar__input')\n\tconst searchSubmit = document.querySelector('#talash-form')\n\tconst searchResult = document.querySelector('.talash-result')\n\tconst searchInner = document.querySelector('.talash-result__inner')\n\tconst talashOverlay = document.querySelector('.talash-overlay')\n\tconst loader = document.querySelector('#search-loader')\n\n\tfunction searchCallback(e) {\n\t\te.preventDefault();\n\n\t\tsearchInput.focus()\n\t\tif (searchInner.classList.contains('show')) {\n\t\t\tsearchInner.classList.remove('show')\n\t\t}\n\n\t\tconst validate = validation();\n\t\tif (! validate) {\n\t\t\treturn;\n\t\t}\n\n\t\tsearchResult.classList.add('show')\n\t\ttalashOverlay.classList.add('show')\n\t\tloader.classList.add('show')\n\n\t\tconst data = {}\n\t\tconst formData = new FormData(searchSubmit)\n\t\tfor (let [key, val] of formData.entries()) {\n\t\t\tdata[key] = val\n\t\t}\n\n\t\t// search by tooltip log\n\t\tsearchByLog(data)\n\n\t\tconst bodyParams = {\n\t\t\taction: 'action=get_search_results',\n\t\t\tnonce: '&security=' + talashPublicApi.nonce,\n\t\t\tdata: '&talash_data=' + JSON.stringify(data)\n\t\t}\n\t\tconst args = bodyParams.action + bodyParams.nonce + bodyParams.data\n\t\tfetchData(args, false)\n\t\t\t.then( function(data) {\n\t\t\t\tsetTimeout(function() {\n\t\t\t\t\tloader.classList.remove('show')\n\t\t\t\t\tsearchInner.classList.add('show')\n\t\t\t\t\tsearchInner.innerHTML = data\n\t\t\t\t}, 300)\n\t\t\t})\n\t\t\t.catch( function(error) {\n\t\t\t\tconsole.log(error);\n\t\t\t});\n\n\t\tcloseSearchPopup();\n\t}\n\n\t// search submit\n\tsearchSubmit.addEventListener('submit', searchCallback);\n}\n\nexports.search = search\n\n\n//# sourceURL=webpack://talash/./assets/src/search.js?");

/***/ }),

/***/ "./assets/src/state.js":
/*!*****************************!*\
  !*** ./assets/src/state.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, exports) => {

eval("class SearchifyState {\n\n\tstatic state = {\n\t\tpostType: 0,\n\t\tcat: 0,\n\t\tauthor: 0\n\t};\n\n\tstatic currentState(name = null) {\n\t\tif (name === 'postType') {\n\t\t\treturn SearchifyState.state.postType\n\t\t} else if (name === 'cat') {\n\t\t\treturn SearchifyState.state.cat\n\t\t} else if (name === 'author') {\n\t\t\treturn SearchifyState.state.author\n\t\t}\n\t}\n\n\tstatic setState(name = null) {\n\t\tif (name === 'postType') {\n\t\t\tSearchifyState.state.postType++\n\t\t} else if (name === 'cat') {\n\t\t\tSearchifyState.state.cat++\n\t\t} else if (name === 'author') {\n\t\t\tSearchifyState.state.author++\n\t\t}\n\t}\n\n\tstatic resetState() {\n\t\tSearchifyState.state.postType = 0\n\t\tSearchifyState.state.cat = 0\n\t\tSearchifyState.state.author = 0\n\t}\n}\n\nexports.currentState = SearchifyState.currentState\nexports.setState = SearchifyState.setState\nexports.resetState = SearchifyState.resetState\n\n\n//# sourceURL=webpack://talash/./assets/src/state.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./assets/src/main.js");
/******/ 	
/******/ })()
;