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
	this.dataType       = 'data-js-action';
	this.folderList     = '.js-folder-list';
	this.boxFolderGroup = '.js-box-folder-group';
	this.currentPath    = '.';
	this.currentTabId   = '';
	this.prevPath       = '';
	this.nameMaterial   = '';


	/**
	 * Викликаємо якусь подію відносно типу
	 */
	this.setAction = function (type = false, params = false, callFunctionResult = false)
	{
		// Generating data for ajax
		const data = {
			'form-type': type,
		}

		// Об'єднюємо налаштування і передані дані
		setAjax({ ...data, ...params }, false, callFunctionResult);
	}



	/**
	 * Виводимо інформацію про папку
	 */
	this.setDir = function (result) {

		// Оновлюємо записи в таблиці
		self.updateTableItems(result);
	}



	/**
	 * Отримужмо список папок по заданому шляху
	 */
	this.getDir = function (e)
	{	
		// Цей об'єкт відповідає за передачу даних
		let mergeData;

		// Перевіряємо чи це клік чи просто запит
		if (isUndefined(e)) {

			// Робимо якісь наші параметри і з ними передаємо дані
			mergeData = {
				path: this.currentPath
			};

		} else {
			// Забороняємо стандарний функціонал html
			e.preventDefault();

			// Робимо якісь наші параметри і з ними передаємо дані
			mergeData = this.dataset;
		}

		// Робимо ajax запит
		self.setAction('getDir', mergeData, 'setDir');
	}



	/**
	 * Html карточка в таблиці
	 */
	this.updateTableItems = function (result)
	{
		// Щоб залишилася можливість подивитися result в console.log диструктуризуємо його на цьому етапі
		const { list, prevPath } = result;

		// Витягуємо блок в який будемо поміщати шаблон
		const boxFolderList = $(this.folderList);

		// Очищаємо перед добавленням
		boxFolderList.html('');

		// Зберігаємо попердній шлях
		this.prevPath = prevPath.url;

		// Якщо є зворотній шлях тоді добавляємо кнопку повернутися назад
		if (this.prevPath) {			

			// Виводимо попердній шлях
			boxFolderList.append(self.viewPrevListItem(prevPath));

		}

		// Перебираємо масив і виводимо html в таблицю
		$.each(list, function (key, listItemData) {

			// Виводимо записи в таблицю
			boxFolderList.append(self.viewListItem(key, listItemData));
		});

		// Оновлюємо tooltip
		initializeTooltips();

		// Оновлюємо вкладки
		this.setMaterialTab(prevPath);
	}



	/**
	 * Виводимо вкладку поточного матеріалу
	 */
	this.setMaterialTab = (prevPath) => {

		// Витягуємо блок в який будемо поміщати шаблон
		const boxFolderGroup = $(self.boxFolderGroup);

		// Очищаємо і виводимо кнопку добавлення вкладки
		boxFolderGroup.html(self.viewAddTabMaterial(prevPath));

		// Виводимо вкладку з поточним файлом
		boxFolderGroup.append(self.viewTabMaterial(prevPath));
	}
	
	


	/**
	 * Html вкладки добавлення вкладки
	 */
	this.viewAddTabMaterial = ({ nameLabel, url }) => {
		return `<li class="nav-item nav-item--add-tab">
					<button class="nav-link btn btn-sm btn-icon btn-new-tab btn-light btn-action"
						data-name="${nameLabel}"	
						data-url="${url}"	
						data-js-action="add-new-tab">
						<svg class="icon icon-plus-circle"><use xlink:href="#icon-plus-circle"></use></svg>
					</button>
				</li>`;
	}




	/**
	 * Html вкладки
	 */
	this.viewTabMaterial = ({ nameLabel, type, url }) => {
		return `<li class="nav-item">
					<button class="btn btn-sm btn-action btn-close"></button>
					<button class="nav-link btn btn-sm btn-light btn-action active">
						<svg class="icon icon-${type}-color"><use xlink:href="#icon-${type}-color"></use></svg>
						${nameLabel}
					</button>
				</li>`;
	}


	
	/**
	 * Виводимо html кнопку перейти назад
	 */
	this.viewPrevListItem = (prevPath) => {
		return `<div class="folder-item d-flex-sides">
					<div class="folder-item__main-info">
						<div class="folder-item__img-hold folder-item__el img-box" data-js-action="get-prev-folder">${prevPath.icon}</div>
						<div class="folder-item__text folder-item__el">
							<button class="folder-item__title text-truncate w-h-100"
								data-path="${this.prevPath}" 
								data-name="${prevPath.prevName}" 
								data-js-action="get-folder">${prevPath.name}</button>
						</div>
					</div>
				</div>`;
	}



	/**
	 * Виводимо html єдиного запису в списку файлів і папок
	 */
	this.viewListItem = function (key, { icon, tooltipSize, tooltipDate, name, path, ext, type, size, modified_date, modified_time_ago }) {

		// Формуємо id елементу
		const itemId = 'folder-item-' + key;

		// Формуємо data інформацію
		let attrData = `data-path="${path}"
						data-name="${name}"
						data-type="${type}"
						data-js-action="get-folder"`;

		// Повертаємо html
		return `<div class="folder-item d-flex-sides" id="${itemId}">
					<div class="folder-item__main-info">
						<label class="folder-item__checkbox folder-item__el form-check-label hover-scale checkbox-file">
							<input class="form-check-input" type="checkbox" value="">
						</label>
						<div class="folder-item__img-hold folder-item__el img-box" ${attrData}>${icon}</div>
						<div class="folder-item__text folder-item__el">
							<button class="folder-item__title text-truncate" ${attrData} ${tooltipSize}>${name}</button>
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
				</div>`;
	}



	/**
	 * Перша функція, яка буде викликана
	 */
	this.init = function () {

		// Виводимо інформацію при першому завантаженні
		this.getDir();

		// Отримуємо список файлів з папки
		$(document).on('click', `[${self.dataType}]`, self.getDir);
	}
}


/**
 * Запускаємо скріпт
 */
const fileManager = new FileManager();
fileManager.init();