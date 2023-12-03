// To make the code look better, I make a function to check
const isUndefined = (el) => typeof el === 'undefined';
const isObject    = (el) => typeof el === 'object';
const isJSON      = (str) => { try { return (JSON.parse(str) && !!str); } catch (e) { return false; } };
const isFile      = (path) => {
	let filename = path.split('/').pop();
	let isFile = /\.[^/.]+$/.test(filename);
	return isFile;
};


// Ініціалізуємо редактор
ace.require("ace/ext/language_tools");
const editor = ace.edit('js-editor');
editor.getSession().setMode("ace/mode/text");
editor.setOptions({
	enableBasicAutocompletion: true,
	enableSnippets: true,
	enableLiveAutocompletion: false
});
// editor.setOption("enableEmmet", true);
// editor.setTheme("ace/theme/monokai");


// Tooltips for bootstrap
// const tooltipList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
function initializeTooltips() {
	let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
	tooltipTriggerList.forEach(function (tooltipTriggerEl) {
		new bootstrap.Tooltip(tooltipTriggerEl);
	});
}
initializeTooltips();



// /**
//  * Php answer alert with js
//  */
// if (phpAnswer) {

// 	// Decode json
// 	phpAnswer = JSON.parse(phpAnswer);
// 	phpAnswer.value = (Array.isArray(phpAnswer.value)) ? phpAnswer.value.join('\n\r') : phpAnswer.value;

// 	// Display alerts for the user
// 	$.notify(phpAnswer.value, { className: phpAnswer.type, autoHideDelay: 7000 }); // notify type: success | info | warn | error
// 	runNotify({ levelMessage: type, message: value }); // notify type: notify | error | success | warning
// }


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
function setAjax(successCallback = null, data = {}, form = false, dataType = 'text')
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
		url: option.pathManagerFile,
		dataType: dataType,
		data: data,
		cache: false,
		...addForAjax,
		beforeSend: function() {

			// If a form is submitted, then make the button disabled
			if (isObject(button)) button.attr('disabled', 'disabled').addClass(loading);

			// Виводимо прелоадер
			if (data.forAjax == 'getFile') {

				// Видаляємо клас, який відповідає за редагування файлу
				fileManager.folderList.addClass('hide')
				fileManager.editorBox.removeClass('hide')
			} else {

				// Щоб не робити повторювального видалення редактору перевіряємо чи існує клас
				fileManager.folderList.removeClass('hide')
				fileManager.editorBox.addClass('hide')
			}

		},
		success: function(response) {

			// We check if the json has really come to us.
			if (!isJSON(response)) return runNotify({ message: 'Ajax cannot accept a response from the controller' });

			// Перекодовуємо в об'єкт для js
			response = JSON.parse(response);

			// Generate settings from the answer
			const { value, type, link, callFunc, callFuncData } = response;

			// Display alerts for the user
			if (value) runNotify({ levelMessage: type, message: value });

			// If you need something more, we can additionally create a function
			if (successCallback) fileManager[successCallback](response);

			// Link to the link, if available
			if (link) setTimeout(() => { window.location.href = link }, 1500);

		},
		complete: function(data) {

			// If a form is submitted, then remove button disabled
			if (isObject(button)) setTimeout(() => { button.removeAttr('disabled').removeClass(loading); }, 1500);
		}
	});
}



// const textarea = $('#content');
// const editor = ace.edit("editor");