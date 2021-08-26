class SearchifyState {

	static state = {
		postType: 0,
		cat: 0,
		author: 0
	};

	static currentState(name = null) {
		if (name === 'postType') {
			return SearchifyState.state.postType
		} else if (name === 'cat') {
			return SearchifyState.state.cat
		} else if (name === 'author') {
			return SearchifyState.state.author
		}
	}

	static setState(name = null) {
		if (name === 'postType') {
			SearchifyState.state.postType++
		} else if (name === 'cat') {
			SearchifyState.state.cat++
		} else if (name === 'author') {
			SearchifyState.state.author++
		}
		console.log(SearchifyState.state)
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
