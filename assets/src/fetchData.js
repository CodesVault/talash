async function fetchData(args, json = true) {
	const res = await fetch(talashPublicApi.ajax_url,
		{
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: args
		}
	)

	if (json) {
		return res.json();
	}
	return res.text();
}

exports.fetchData = fetchData
