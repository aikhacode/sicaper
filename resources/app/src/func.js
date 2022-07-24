const parseApi = (namespace="") => {

	return (location.hostname == 'sicaper.test') ? `//sicaper.test/api${namespace}` : `../api${namespace}`;
}

const parseWeb = (namespace="") => {
	return (location.hostname == 'sicaper.test') ? `//sicaper.test${namespace}` : `..${namespace}`;
}

export {
	parseApi, parseWeb
}