/**
 * Функціонал файлового менеджера
 */
const FileManager = function ()
{
	// Контекст self для зручного використання внутрішніх методів та властивостей.
	const self = this;

	// Загальна інфа для роботи скірпта
	this.dataForJs      = 'data-for-js';
	this.dataInputForJs = 'data-input-for-js';
	this.dataForAjax    = 'data-for-ajax';
	this.folderList     = '.js-folder-list';
	this.boxFolderGroup = '.js-box-folder-group';
	this.currentPath    = '.';
	this.currentTabId   = '';
	this.prevPath       = '';
	this.nameMaterial   = '';

	// Переклад файлового менеджера
	this.lang = {
		actionMark: 'Відмітити',
		actionCreateTab: 'Створити вкладку',
		actionCreateFolder: 'Створити папку',
		actionCreateFile: 'Створити файл',
		actionDownloadFolder: 'Скачати папку',
		actionDownloadFile: 'Скачати файл',
		actionUploadFolder: 'Загрузити папку',
		actionUploadFile: 'Загрузити файл',
		viewListItemNoResult: 'Результатів не знайдено!',
		viewListItemNotExist: 'Шлях на сервері не знайдений!',
	}

	/**
	 * Вказуємо поточний шлях в якому ми зараз є
	 */
	this.setPath = (currentPath = false, prevPath = false) => {
		// Поточний шлях
		if (currentPath) this.currentPath = currentPath;

		// Попередній шлях
		if (prevPath) this.prevPath = prevPath;
	}


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

		} else if (sendData.hasOwnProperty('inputForJs')) {

			// Просто викликаємо js функцію
			waitForFinalEvent(() => {

				// Просто викликаємо js функцію
				self[sendData.inputForJs](event, sendData);
			}, 2500)

		} else {

			// Просто викликаємо js функцію
			self[sendData.forJs](sendData);
		}
	}




	/**
	 * Отримужмо список папок по заданому шляху
	 */
	this.getDir = (sendData) => {

		// При першому завантаженні виводимо результати
		sendData = {
			forAjax: 'getDir',
			path: this.currentPath
		};

		// Робимо ajax запит
		setAjax('updateTableItems', sendData);
	}



	/**
	 * Отримужмо список папок по заданому шляху
	 */
	this.getDirInput = (event, sendData) => {

		// Значення з поля
		let value = event.target.value;

		// Дістаємо перший і другий символ для перевірки
		const pathCharAt1 = value.charAt(0);
		const pathCharAt2 = value.charAt(1);

		// Якщо в полі ввдений шлях не від кореня, тоді підставляємо його
		if (!pathCharAt1.length || pathCharAt1 != '.' || pathCharAt2 && pathCharAt2 != '/')
			value = './' + value;

		// Якщо немає ніякого значення виводимо поточний шлях
		if (!pathCharAt1.length)
			value = '.';

		// При першому завантаженні виводимо результати
		const dataset = {
			forAjax: 'getDir',
			path: value
		};

		// Робимо ajax запит
		setAjax('updateTableItems', { ...sendData, ...dataset });
	}




	/**
	 * Питатися чи створити шляху
	 */
	 this.alertNotExistPath = (dataPath) => {
	 	console.log("dataPath", dataPath);

		// При першому завантаженні виводимо результати
		const dataset = {
			forAjax: 'createPath',
		};

		// Заглушка для виводу питання
		let result = false;

		// Питаємося в користувача чи створювати не існуючий шлях
		if (dataPath.path) {
			result = confirm((isFile(dataPath.path)) ? `Створити файл ${dataPath.nameLabel}?` : `Створюємо шлях ${dataPath.path}?`);
		}

		// Робимо ajax запит
		if (result)
			setAjax('alertNotExistPathSuccess', { ...dataset, ...dataPath });

		// Повертаємо відповідь
		return (result) ? true : false;
	 }



	 /**
	  * Після успішного відпрацювання поля і ajax запускаємо функцію
	  */
	 this.alertNotExistPathSuccess = (result) => {

	 	// Якщо файл відкриваємо редактор
	 	if (result.isFile) {
	 		this.setFileEditor(result);
	 	}
	 }



	 /**
	  * Після успішного відпрацювання поля і ajax запускаємо функцію
	  */
	 this.setFileEditor = (result) => {

		console.log("Редагуємо файл!!!", result);

	 }




	/**
	 * Виводимо інформацію про папку
	 */
	this.updateTableItems = (result) =>	{

		// Щоб залишилася можливість подивитися result в console.log диструктуризуємо його на цьому етапі
		let { list, prevPath, getFile } = result;

		// Ключ який буде вказувати, що папка не існує
		const notExist = 'not-exist';

		// Якщо не існує шляху, запитуватися чи створити
		if (list == notExist && !getFile) {

			// Запускаємо функцію, яка видасть вспливаючу вікно
			const result = this.alertNotExistPath(prevPath);

			// Змінній потрібний масив або якесь повідомлення
			list = (result) ? [] : notExist;

			// Якщо переданий шлях в якому є файл, переопреділяємо мітку файлу
			if (isFile(prevPath.path))
				getFile = true;
		}

		// Якщо потрібно відкрити файл, викликаємо відповідну функцію
		if (getFile) {

			// Викликаємо редактор файлу
			this.setFileEditor(result);
		} else {

			// Витягуємо блок в який будемо поміщати шаблон
			const boxFolderList = $(this.folderList);

			// Зберігаємо попердній шлях
			const prevPathStr = (isObject(prevPath)) ? prevPath.url : '.';

			// Очищаємо перед добавленням
			boxFolderList.html('');

			// Задаємо шляхи
			this.setPath(prevPath.path, prevPathStr);

			// Якщо є зворотній шлях тоді добавляємо кнопку повернутися назад
			if (prevPath.path != '') {

				// Виводимо попердній шлях
				boxFolderList.append(self.viewPrevListItem(prevPath));

				// Формуємо змінну шляху в якому ми зараз є
				this.currentPath = prevPath.path;
			}

			// Перевіряємо масив на пустоту
			if (list == notExist) {

				// Виводимо повідомлення, що папки не існує
				boxFolderList.append(self.viewNoResultInfo(prevPath.nameLabel, self.lang.viewListItemNotExist, false));

			} else if (!list.length) {

				// Виводимо повідомлення, що папка пуста
				boxFolderList.append(self.viewNoResultInfo(prevPath.nameLabel));

			} else {

				// Перебираємо масив і виводимо html в таблицю
				$.each(list, function (key, listItemData) {

					// Виводимо записи в таблицю
					boxFolderList.append(self.viewListItem(key, listItemData));

				});

				// Оновлюємо tooltip
				initializeTooltips();
			}
		}


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
	this.viewNoResultInfo = (nameLabel, title = false, buttonNeed = true) => {

		if (!title)
			title = `Папка  <span>&ldquo;${nameLabel}&rdquo;</span>  пуста...`;

		let linksHtml = '';

		if (buttonNeed) {
			linksHtml = `<div class="no-result-info__footer">
							Ось рекомендовані посилання на цей випадок
							<a href="" class="link-primary">Створити файл</a>
							<a href="" class="link-primary">Створити папку</a>
						</div>`;
		}

		return `<div class="no-result-info">
					<div class="no-result-info__top d-flex align-items-center">
						<div class="no-result-info__icon-hold hover-scale cur-p">
							<svg class="icon icon-additem"><use xlink:href="#icon-additem"></use></svg>
						</div>
						<div class="no-result-info__text">
							<h2 class="no-result-info__text-title">${title}</h2>
							<p class="no-result-info__text-inner">Добавити файли до папки?</p>
						</div>
					</div>
					${linksHtml}
				</div>`;
	}



	/**
	 * Html вкладки добавлення вкладки
	 */
	this.viewAddTabMaterial = ({ nameLabel, url }) => {
		
		// Якщо головне сторінка, тоді деякі вкладки добавляти не потрібно.
		let itemMark = '';

		if (url) {
			itemMark = `<li>
							<a class="dropdown-item" href="#">
								<svg class="icon icon-article"><use xlink:href="#icon-home"></use></svg>
								<span classs="dropdown-item-inner-text">${this.lang.actionMark}</span>
							</a>
						</li>`;
		}

		return `<li class="nav-item nav-item--add-tab">
					<div class="dropdown">
						<button class="nav-link btn btn-sm btn-icon btn-new-tab btn-light btn-action" data-bs-toggle="dropdown"
							data-name="${nameLabel}"
							data-url="${url}"
							data-for-js="addNewTab">
							<svg class="icon icon-plus-circle"><use xlink:href="#icon-plus-circle"></use></svg>
						</button>
						<ul class="dropdown-menu">
							<li>
								<a class="dropdown-item" href="#">
									<svg class="icon icon-article"><use xlink:href="#icon-home"></use></svg>
									<span classs="dropdown-item-inner-text">${this.lang.actionCreateTab}</span>
								</a>
							</li>
							
							<li><hr class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="#">
									<svg class="icon icon-article"><use xlink:href="#icon-home"></use></svg>
									<span classs="dropdown-item-inner-text">${this.lang.actionCreateFolder}</span>
								</a>
							</li>
							<li>
								<a class="dropdown-item" href="#">
									<svg class="icon icon-article"><use xlink:href="#icon-home"></use></svg>
									<span classs="dropdown-item-inner-text">${this.lang.actionCreateFile}</span>
								</a>
							</li>
							<li><hr class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="#">
									<svg class="icon icon-article"><use xlink:href="#icon-home"></use></svg>
									<span classs="dropdown-item-inner-text">${this.lang.actionUploadFile}</span>
								</a>
							</li>
						</ul>
					</div>
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
			foldersHtml += `<button class="btn btn-sm btn-light btn-home"
						data-path="."
						data-name="${nameLabel}"
						data-type="${type}"
						data-ajax-callback="updateTableItems"
						data-for-ajax="getDir"><svg class="icon icon-arrow icon-arrow-right"><use xlink:href="#icon-arrow-right"></use></svg><svg class="icon icon-home"><use xlink:href="#icon-home"></use></svg></button>`;

			// Для підстановки для шляху
			let pathPart = '';

			// Добавляємо решту папок
			pathArr.forEach((folder) => {

				// Формаємо шлях до папки
				pathPart += folder + '/';

				// Виводимо назву папки
				if (folder != '.') {
					foldersHtml += `<button class="btn btn-sm btn-light"
						data-path="${pathPart}"
						data-name="${nameLabel}"
						data-type="${type}"
						data-ajax-callback="updateTableItems"
						data-for-ajax="getDir"><svg class="icon icon-arrow icon-arrow-right"><use xlink:href="#icon-arrow-right"></use></svg>${folder}</button>`;
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
							<input type="search" class="form-control form-control-sm" placeholder="Шлях до файлу" value="${path}" data-input-for-js="getDirInput">
							<!-- <button class="btn btn-sm btn-icon btn-action btn-edit btn-pr-bg btn-similar-y position-absolute top-50 end-0 translate-middle-y"><svg class="icon icon-arrow-right-line"><use xlink:href="#icon-arrow-right-line"></use></svg></button> -->
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

		// Html для dropdown
		let dropdown = '';

		// Формуємо id елементу
		const itemId = 'folder-item-' + key;

		// Формуємо data інформацію
		let attrData = `data-path="${path}"
						data-name="${name}"
						data-type="${type}"
						data-ajax-callback="updateTableItems"
						data-for-ajax="getDir"`;

		// Перелік можливостей відносно типу
		const dropdownActions = {
			'dir': [
				{
					'icon': 'icon-home',
					'value': 'Відмітити',
				},
				{
					'icon': 'icon-home',
					'value': 'Перейменувати',
				},
				{
					'icon': 'icon-home',
					'value': 'Скопіювати',
				},
				{
					'icon': 'icon-home',
					'value': 'Перемістити',
				},
				{
					'value': 'hr',
				},
				{
					'icon': 'icon-home',
					'value': 'Видалити',
				},
			],
			'file': [
				{
					'icon': 'icon-home',
					'value': 'Відмітити',
				},
				{
					'icon': 'icon-home',
					'value': 'Перейменувати',
				},
				{
					'icon': 'icon-home',
					'value': 'Відкрити',
				},
				{
					'icon': 'icon-home',
					'value': 'Скопіювати',
				},
				{
					'icon': 'icon-home',
					'value': 'Перемістити',
				},
				{
					'icon': 'icon-home',
					'value': 'Скачати',
				},
				{
					'value': 'hr',
				},
				{
					'icon': 'icon-home',
					'value': 'Видалити',
				},
			]
		} 

		// Dropdown для різних типів
		dropdownActions[type].forEach(item => {

			dropdown += (item.value === 'hr')
				? `<li><hr class="dropdown-divider"></li>`
				: `<li>
						<a class="dropdown-item" href="#">
							<svg class="icon ${item.icon}"><use xlink:href="#${item.icon}"></use></svg>
							<span classs="dropdown-item-inner-text">${item.value}</span>
						</a>
					</li>`
		});

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
							${dropdown}
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

		// Подія яку потрібно виконати js
		$(document).on('input', `[${self.dataInputForJs}]`, self.setAction);;
	}
}


/**
 * Запускаємо скріпт
 */
const fileManager = new FileManager();
fileManager.init();