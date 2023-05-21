/**
 * Викликаємо якусь подію відносно типу
 */
// function setAction(type = false, params = false, callFunctionResult = false) {
// 	// Generating data for ajax
// 	const data = { 'form-type': type }

// 	// Об'єднюємо загальні налаштуванні і передані дані 
// 	const mergeData = { ...data, ...params };

// 	// Calling a ajax
// 	setAjax(mergeData, false, callFunctionResult);
// }





/**
 * Функціонал файлового менеджера
 */
const FileManager = function ()
{
	// Контекст self для зручного використання внутрішніх методів та властивостей.
	const self = this;

	// Загальна інфа для роботи скірпта
	this.dataType    = 'data-js-action';
	this.currentPath = '.';
	this.prevPath    = '';

	// Отримужмо список папок по заданому шляху
	this.test = function (e) {
		console.log("Test");
	}



	// Викликаємо якусь подію відносно типу
	this.setAction = function (type = false, params = false, callFunctionResult = false)
	{
		// Generating data for ajax
		const data = {
			'form-type': type,
		}

		// Об'єднюємо налаштування і передані дані
		setAjax({ ...data, ...params }, false, callFunctionResult);
	}



	// Отримужмо список папок по заданому шляху
	this.getDir = function (e)
	{
		// Забороняємо стандарний функціонал html
		e.preventDefault();

		// Збираємо необхідні параметри
		const params = {
			testKey: 'testVal', // Нічого не значить, просто приклад
		}

		// Робимо якісь наші параметри і з ними передаємо дані
		const mergeData = { ...params, ...this.dataset };

		// // Generating data for ajax
		self.setAction('getDir', mergeData, 'setDir');
	}
	

	// Виводимо інформацію про папку
	this.setDir = function (result)
	{
		// Оновлюємо записи в таблиці
		self.updateTableItems(result);
	}



	// Html карточка в таблиці
	this.updateTableItems = function (result)
	{
		console.log(result);
		// Щоб залишилася можливість подивитися result в console.log диструктуризуємо його на цьому етапі
		const { list, prevPath } = result;

		// Зберігаємо попердній шлях
		this.prevPath = prevPath.url;
		console.log('this', this.prevPath);


		// Витягуємо блок в який будемо поміщати шаблон
		const boxFolderList = $('.js-folder-list');

		// Очищаємо перед добавленням
		boxFolderList.html('');

		// Виводимо попердній шлях
		boxFolderList.append(`<div class="folder-item d-flex-sides">
								<div class="folder-item__main-info">
									<div class="folder-item__img-hold folder-item__el img-box" data-js-action="get-prev-folder">${prevPath.icon}</div>
									<div class="folder-item__text folder-item__el">
										<button class="folder-item__title text-truncate w-h-100 js-click-item" data-js-action="get-prev-folder">${prevPath.name}</button>
									</div>
								</div>
							</div>`);

		// Перебираємо масив і виводимо html в таблицю
		$.each(list, function (key, listItemData) {

			// Виводимо записи в таблицю
			boxFolderList.append(self.viewListItem(key, listItemData));
		});

		// Оновлюємо tooltip
		initializeTooltips();
	}



	// Виводимо html єдиного запису в списку файлів і папок
	this.viewListItem = function (key, { icon, tooltipSize, tooltipDate, name, path, ext, type, size, modified_date, modified_time_ago }) {

		// Формуємо id елементу
		const itemId = 'folder-item-' + key;

		// Повертаємо html
		return `<div class="folder-item d-flex-sides" id="${itemId}">
					<div class="folder-item__main-info">
						<label class="folder-item__checkbox folder-item__el form-check-label hover-scale checkbox-file">
							<input class="form-check-input" type="checkbox" value="">
						</label>
						<div class="folder-item__img-hold folder-item__el img-box" data-js-action="get-folder" data-path="${path}" data-name="${name}">${icon}</div>
						<div class="folder-item__text folder-item__el">
							<button
								class="folder-item__title text-truncate js-click-item"
								data-path="${path}" 
								data-name="${name}"
								data-js-action="get-folder"
								${tooltipSize}>${name}</button>
						</div>
					</div>
					<div class="folder-item__date-create fz-info hide-tablet" ${tooltipDate}>${modified_time_ago}</div>
					<div class="dropdown dropstart folder-item__action folder-item__el">
						<button class="btn btn-action btn-sm btn-icon btn-body-color btn-pr-bg hover-scale" type="button" data-bs-toggle="dropdown"><svg class="icon icon-more-vertical"><use xlink:href="#icon-more-vertical"></use></svg></button>
						<ul class="dropdown-menu dropdown-menu-end">
							<li>
								<a class="dropdown-item" href="#">
									<svg class="icon icon-article"><use xlink:href="#icon-home"></use></svg>Action
								</a>
							</li>
						</ul>
					</div>
				</div>`
	}



	// Перша функція, яка буде викликана
	this.init = function () {

		// console.log('self', self)

		// Отримуємо список файлів з папки
		$(document).on('click', `[${self.dataType}]`, self.getDir);
	}
}


// Запускаємо скріпт
const fileManager = new FileManager();
fileManager.init();