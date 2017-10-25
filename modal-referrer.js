window.addEventListener('DOMContentLoaded', function() {
	const ref = document.referrer;
	console.log(ref);
	if (ref.match(/^https?:\/\/(([^\/]+\.)*wordpress\.org|localhost(:\d+))\/.*$/i)) {
		const tmpl = document.getElementById('sdsModal');
		const modal = document.importNode(tmpl.content, true);

		const modalElement = modal.firstElementChild;
		modalElement.id = 'sdsModalImpl';

		const buttons = modal.querySelectorAll('button');
		for (button of buttons) {
			button.addEventListener('click', function() {
				document.getElementById('sdsModalImpl').remove();
			});
		}
		document.body.appendChild(modal);
	} // if ref.match
});
