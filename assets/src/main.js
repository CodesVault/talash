const {clearInput} = require('./clearInput')
const { advancedOption } = require('./advancedOptions')
const { search } = require('./search')
const { removePopup } = require('./removePopup')
const { getPostTypes } = require('./postType')
const { getCategories } = require('./category')
const { dateRangePicker } = require('./datePicker')
const { getAuthors } = require('./author')
const { reset } = require('./reset')
const { keyShortCut } = require('./keyShortCut')

document.addEventListener("DOMContentLoaded", function() {
	if (document.readyState === "interactive" || document.readyState === "complete" ) {
		keyShortCut();
		clearInput();
		advancedOption();
		search();
		removePopup();
		getPostTypes();
		getCategories();
		dateRangePicker();
		getAuthors();
		reset();
	}
});
