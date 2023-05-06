// To make the code look better, I make a function to check
const isUndefined = (el) => typeof el === 'undefined';
const isObject    = (el) => typeof el === 'object';
const isJSON      = (str) => { try { return (JSON.parse(str) && !!str); } catch (e) { return false; } };

// Tooltips for bootstrap
// const tooltipList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

/**
 * Doesn't call the script multiple times
 */
let waitForFinalEvent = (function() {
	let timers = {};
	return function(callback, ms, uniqueId) {
		if (!uniqueId)
			uniqueId = "Не викликає двічі без унікального ідентифікатору";

		if (timers[uniqueId])
			clearTimeout(timers[uniqueId]);

		timers[uniqueId] = setTimeout(callback, ms);
	};
})();



/**
 * Textarea autogrow
 */
const textareaAutogrow = document.querySelector('textarea.autogrow');
if (textareaAutogrow) {
	textareaAutogrow.addEventListener('input', function() {
		this.style.height = (this.scrollHeight + 2) + 'px';
	});
}



/**
 * Scroll
 */
$(".js-scroll-horizontal").mCustomScrollbar({
	theme: "dark",
	axis: "x",
	scrollInertia: 350,
});






