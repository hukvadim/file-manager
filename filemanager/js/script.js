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




/**
 * A general AJAX function for sending POST requests
 */
function setAjax(data = {}, form = false, successCallback = null, dataType = 'json')
{
	if (dataType !== 'json' && dataType !== 'text')
		throw new Error(`Invalid data type '${dataType}'`);

	// Declare variables here to avoid getting "is not defined"
	let button, loading;
	let addForAjax = {};

	// If the form is passed then there will be undefined
	if (isUndefined(form)) throw new Error('Form element not passed');

	// If the form is passed, then we form additional variables
	if (isObject(form)) {
		form = $(form); // Make the form a jquery object
		button = form.find('[type="submit"]'); // Submit button 
		loading = 'loading'; // Css class download effect

		// Without these settings, it generates an error and does not send information.
		addForAjax = {
			processData: false,
			contentType: false,
		}
	}

	return $.ajax({
		type: 'POST',
		url: option.path + 'ajax.php',
		dataType: dataType,
		data: data,
		cache: false,
		...addForAjax,
		beforeSend: function() {

			// If a form is submitted, then make the button disabled
			if (isObject(button)) button.attr('disabled', 'disabled').addClass(loading);
		},
		success: function(response) {

			console.log("response", response);

			// We check if the json has really come to us.
			if (!isJSON(response)) return $.notify('Ajax cannot accept a response from the controller');

			// Generate settings from the answer
			let {value, type, link, callFunc, callFuncData} = JSON.parse(response);

			// Display alerts for the user
			if (value) $.notify(value, { className: type, autoHideDelay: 12000 });

			// If you need something more, we can additionally create a function
			if (callFunc) window[callFunc](callFuncData, response);

			// If you need something more, we can additionally create a function
			if (successCallback) successCallback(response);

			// Link to the link, if available
			if (link) setTimeout(() => { window.location.href = link }, 1500);

		},
		complete: function(data) {

			// If a form is submitted, then remove button disabled
			if (isObject(button)) setTimeout(() => { button.removeAttr('disabled').removeClass(loading); }, 1500);
		}
	});
}




/**
 * Викликаємо якусь подію відносно типу
 */
function setAction(type = false, params = false, callFunctionResult = false)
{
	// Generating data for ajax
	const data = {
		'form-type': type,
		'params': params
	}

	// Calling a ajax
	setAjax(data, false, callFunctionResult);
}





/**
 * Функціонал файлового менеджера
 */
const fileManager = {

	action: {
		clickItem: '.js-click-item'
	},

	getDir: function(e) {
		e.preventDefault();

		console.log("CLICK");

		// Generating data for ajax
		setAction('getDir', 'file');
	},

	init: function() {

		// Отримуємо список файлів з папки
		$(document).on('click', this.action.clickItem, this.getDir);
	}
}

fileManager.init();