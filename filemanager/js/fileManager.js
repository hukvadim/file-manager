/**
 * Функціонал файлового менеджера
 */
const FileManager = function ()
{
	// Контекст self для зручного використання внутрішніх методів та властивостей.
	const self = this;

	// Загальна інфа для роботи скірпта
	this.dataForJs      = 'data-for-js';
	this.dataForAjax    = 'data-for-ajax';
	this.folderList     = '.js-folder-list';
	this.boxFolderGroup = '.js-box-folder-group';
	this.currentPath    = '.';
	this.currentTabId   = '';
	this.prevPath       = '';
	this.nameMaterial   = '';

	/**
	 * Загальна функція, яка буде задавати потрібний тип
	 */
	this.setAction = function (event = false, type = false, sendData = {}) {

		// Перевіряємо чи це клік чи просто запит
		if (event) {

			// Забороняємо стандарний функціонал html
			event.preventDefault();

			// Добавляємо дані атрибутів до переданого об'єкту
			sendData = { ...sendData, ...this.dataset };
		}
		
		// Відносно типу запускаємо потрібну функцію
		if (sendData.hasOwnProperty('forAjax')) {
			
			// Робимо ajax запит
			setAjax(sendData.ajaxCallback, sendData);

		} else {
			
			// Просто викликаємо js функцію
			self[sendData.forJs](sendData);
		}
	}


	/**
	 * Добавляємо нову вкладку
	 */
	this.addNewTab = (result) => {
		console.log('this', this)
		console.log('result', result)
	}

	

	/**
	 * Отримужмо список папок по заданому шляху
	 */
	this.getDir = () => {

		// При першому завантаженні виводимо результати
		sendData = {
			forAjax: 'getDir',
			path: this.currentPath
		};

		// Робимо ajax запит
		setAjax('updateTableItems', sendData);
	}



	/**
	 * Виводимо інформацію про папку
	 */
	this.updateTableItems = (result) =>	{
	
		// Щоб залишилася можливість подивитися result в console.log диструктуризуємо його на цьому етапі
		const { list, prevPath } = result;

		// Витягуємо блок в який будемо поміщати шаблон
		const boxFolderList = $(this.folderList);

		// Очищаємо перед добавленням
		boxFolderList.html('');

		// Зберігаємо попердній шлях
		this.prevPath = (isObject(prevPath)) ? prevPath.url : '.';

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
						data-for-js="addNewTab">
						<svg class="icon icon-plus-circle"><use xlink:href="#icon-plus-circle"></use></svg>
					</button>
				</li>`;
	}




	/**
	 * Html вкладки
	 */
	this.viewTabMaterial = ({ nameLabel, type, url, path, pathArr }) => {

		// Змінна для переключалки папок
		foldersHtml = '';

		// Якщо більше ніж два тоді формуємо кнопки інших папок
		if (pathArr.length >= 2) {

			// Початок блоку кнопок папок
			foldersHtml += `<div class="btn-group-vertical w-100 btn-group-folders">`;

			// Переходимо до головної
			foldersHtml += `<button class="btn btn-sm btn-light btn-home"><svg class="icon icon-arrow icon-arrow-right"><use xlink:href="#icon-arrow-right"></use></svg><svg class="icon icon-home"><use xlink:href="#icon-home"></use></svg></button>`;

			// Добавляємо решту папок
			pathArr.forEach((folder) => {
				if (folder != '.') {
					foldersHtml += `<button class="btn btn-sm btn-light"><svg class="icon icon-arrow icon-arrow-right"><use xlink:href="#icon-arrow-right"></use></svg>${folder}</button>`;
				}
			});

			// Кінець блоку кнопок папок
			foldersHtml += `</div>`;
		}

		return `<li class="nav-item dropdown-folder-set-path">
					<button class="btn btn-sm btn-action btn-close"></button>
					<button class="nav-link btn btn-sm btn-light btn-action active" data-bs-toggle="dropdown">
						<svg class="icon icon-${type}-color"><use xlink:href="#icon-${type}-color"></use></svg>
						<span class="btn-inner-text">${nameLabel}</span>
					</button>
					<div class="dropdown-menu">
						<div class="input-hold-folder-path position-relative">
							<input type="text" class="form-control form-control-sm" placeholder="Шлях до файлу" value="${path}">
							<button class="btn btn-sm btn-icon btn-action btn-edit btn-pr-bg btn-similar-y position-absolute top-50 end-0 translate-middle-y"><svg class="icon icon-arrow-right-line"><use xlink:href="#icon-arrow-right-line"></use></svg></button>
						</div>
						${foldersHtml}
					</div>
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
								data-ajax-callback="updateTableItems"
								data-for-ajax="getDir">${prevPath.name}</button>
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
						data-ajax-callback="updateTableItems"
						data-for-ajax="getDir"`;

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

		// Подія яку потрібно передати через ajax
		$(document).on('click', `[${self.dataForAjax}]`, self.setAction);
		
		// Подія яку потрібно виконати js
		$(document).on('click', `[${self.dataForJs}]`, self.setAction);
	}
}


/**
 * Запускаємо скріпт
 */
const fileManager = new FileManager();
fileManager.init();