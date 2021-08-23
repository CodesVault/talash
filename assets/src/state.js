class SearchifyState {

	static state = {
		postType: 0,
		cat: 0,
		author: 0
	};

	static currentState(name = null) {
		if (name === 'postType') {
			return SearchifyState.state
		} else if (name === 'cat') {
			return SearchifyState.cat
		} else if (name === 'author') {
			return SearchifyState.author
		}
	}

	static setState(name = null) {
		// console.log(SearchifyState.state)
		if (name === 'postType') {
			SearchifyState.state.postType++
		} else if (name === 'cat') {
			SearchifyState.state.cat++
		} else if (name === 'author') {
			SearchifyState.state.author++
		}
	}

	static resetState() {
		SearchifyState.state.postType = 0
		SearchifyState.state.cat = 0
		SearchifyState.state.author = 0
	}
}

exports.currentState = SearchifyState.currentState
exports.setState = SearchifyState.setState
exports.resetState = SearchifyState.resetState
