function isEmpty(obj) {
	return Object.keys(obj).length === 0;
}

function errorText(text) {
	return '<div class="js-danger-text">' + text + '</div>';
}