/**
 * Функціонал файлового менеджера
 */
const FileManager = function ()
{
	// Контекст self для зручного використання внутрішніх методів та властивостей.
	const self = this;

	// Запам'ятовуємо шлях де ми були останній раз
	const rememberPath = localStorage.getItem('currentPath');

	// Запам'ятовуємо вкладки
	const rememberTabActive = JSON.parse(localStorage.getItem('tabActive'));
	const rememberTabs = JSON.parse(localStorage.getItem('tabs'));

	// Загальна інфа для роботи скірпта
	this.editorClass    = 'set-editor';
	this.dataForJs      = 'data-for-js';
	this.dataInputForJs = 'data-input-for-js';
	this.dataForAjax    = 'data-for-ajax';
	this.folderList     = '.js-folder-list';
	this.boxFolderGroup = '.js-box-folder-group';
	this.currentPath    = (rememberPath) ? rememberPath : '.';
	this.currentTabId   = '';
	this.prevPath       = '';
	this.nameMaterial   = '';
	this.tabActive      = (rememberTabActive) ? rememberTabActive : 0,
	this.tabs           = (rememberTabs) ? rememberTabs : [];

	// Переклад файлового менеджера
	this.lang = {
		actionMark          : 'Відмітити',
		actionCreateTab     : 'Нова вкладка',
		actionCreateFolder  : 'Створити папку',
		actionCreateFile    : 'Створити файл',
		actionDownloadFolder: 'Скачати папку',
		actionDownloadFile  : 'Скачати файл',
		actionUploadFolder  : 'Загрузити папку',
		actionUploadFile    : 'Загрузити файл',
		viewListItemNoResult: 'Результатів не знайдено!',
		viewListItemNotExist: 'Шлях на сервері не знайдений!',
		textAddFile         : 'Добавити файли до папки?',
		textFolder          : 'Папка',
		textEmpty           : 'пуста...',
		folderEmptyRecomend : 'Ось рекомендовані посилання на цей випадок',
	}

	/**
	 * Вказуємо поточний шлях в якому ми зараз є
	 */
	this.setPath = (currentPath = false, prevPath = false) => {
		// Поточний шлях
		if (currentPath) this.currentPath = currentPath;

		// Попередній шлях
		if (prevPath) this.prevPath = prevPath;

		// Зберігаємо шлях
		localStorage.setItem('currentPath', (currentPath) ? currentPath : '.');
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

			// Якщо input має атрибут який задає час, використовуємо його
			const timeOffset = (event.target.dataset.timeOffset)? event.target.dataset.timeOffset : 1500;

			// Просто викликаємо js функцію
			waitForFinalEvent(() => {

				// Просто викликаємо js функцію
				self[sendData.inputForJs](event, sendData);
			}, timeOffset)

		} else {

			// Просто викликаємо js функцію
			self[sendData.forJs](sendData);
		}
	}

	
	/**
	 * Активовуємо кнопку або дизактивовуємо
	 */
	this.inputBehaviorBtnStatus = (e) => {

		// Елемент з яким потрібно попрацювати
		const el = e.target;
		
		// Дістаємо потрібні атрибути
		const btn = document.querySelector(el.dataset.forBtn);

		// Якщо якщо немає значення, робимо кнопку неактивною
		if (isObject(btn))
			btn.disabled = (el.value == '');
	}




	
	/**
	 * Дістаємо контент файлу і показуємо редактор
	 */
	this.setFileEditor = (data) => {
		
		// Формуємо дані для запиту
		sendData = {
			...data,
			forAjax: 'getFile'
		};
		// Робимо ajax запит
		setAjax('setEditor', sendData);
	}





	/**
	 * Після успішного відпрацювання поля і ajax запускаємо функцію
	 */
	this.setEditor = (result) => {
		console.log("Редагуємо файл!!!", result);
		
		// Витягуємо блок в який будемо поміщати шаблон
		const boxFolderList = $(this.folderList);

		// Виводимо контент в html
		boxFolderList.html(result.content);
		
		ace.require("ace/ext/language_tools");
		const editor = ace.edit("page-content");
		editor.getSession().setMode("ace/mode/" + result.ext);
		editor.setOptions({
			enableBasicAutocompletion: true,
			enableSnippets: true,
			enableLiveAutocompletion: false
		});
		// editor.setOption("enableEmmet", true);
		// editor.setTheme("ace/theme/monokai");

		// Ховаємо tooltip
		$('.tooltip').removeClass("show");
	}




	/**
	 * Отримужмо список папок по заданому шляху
	 */
	this.getDir = (sendData, textAlert = '', typeAlert = '') => {
		
		// Перевіряємо чи прийшли дані alert
		if (isObject(sendData)) {
			if (!isUndefined(sendData.textAlert) || !isUndefined(sendData.typeAlert)) {
				textAlert = sendData.textAlert;
				typeAlert = sendData.typeAlert;
			}
		}

		// При першому завантаженні виводимо результати
		sendData = {
			forAjax: 'getDir',
			path: this.currentPath,
			textAlert,
			typeAlert
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
	 * Створюємо папку
	 */
	this.createFolder = () => {
		
		// Поле з яким працюємо
		const el = $('#form-control-new-folder');

		// Дістаємо назву папки з поля #form-control-new-folder
		const folderName = el.val();
		
		// При першому завантаженні виводимо результати
		sendData = {
			forAjax: 'createFolder',
			path: this.currentPath,
			folderName
		};

		// Робимо ajax запит
		setAjax('getDir', sendData);

		// Очищуємо поле
		el.val('');

		// Закриваємо вспливаюче вікно
		$('#modal-create-folder').modal('hide');
	}



	/**
	 * Створюємо файл
	 */
	this.createFile = () => {
		
		// Поле з яким працюємо
		const el = $('#form-control-new-file');

		// Дістаємо назву папки з поля #form-control-new-folder
		const fileName = el.val();
		
		// При першому завантаженні виводимо результати
		sendData = {
			forAjax: 'createFile',
			path: this.currentPath,
			fileName
		};

		// Робимо ajax запит
		setAjax('getDir', sendData);

		// Очищуємо поле
		el.val('');

		// Закриваємо вспливаюче вікно
		$('#modal-create-file').modal('hide');
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

		// Формуємо першу вкладку для виводу
		if (this.tabs.length == 0 || isUndefined(this.tabs))
			this.tabs.push(prevPath);
		
		// Виводимо вкладки
		this.setMaterialTab(prevPath);
	}




	/**
	 * Виводимо вкладку поточного матеріалу
	 */
	this.setMaterialTab = (tabData) => {

		// Витягуємо блок в який будемо поміщати шаблон
		const boxFolderGroup = $(self.boxFolderGroup);
		
		// Витягуємо блок в який будемо поміщати шаблон
		const boxTab = $(`#tab-${this.tabActive}`);

		// Перевіряємо чи треба оновити вкладку чи вивести все
		if (boxTab.length === 0) {

			// Очищаємо і виводимо кнопку добавлення вкладки
			boxFolderGroup.html(self.viewAddTabMaterial());
	
			// Виводимо вкладку з поточним файлом
			this.tabs.forEach((tab, index) => {
				boxFolderGroup.append(self.viewTabMaterial(tab, index));
			})
			
		} else {

			// Оновлюємо дані вкладки
			boxTab.html(this.viewTabMaterial(tabData, this.tabActive, true));

			// Оновлюємо поточну вкладку
			this.tabs[this.tabActive] = tabData;
		}
		
		// Запам'ятовуємо дані вкладок
		localStorage.setItem('tabs', JSON.stringify(this.tabs));
		localStorage.setItem('tabActive', this.tabActive);
	}



	/**
	 * Добавляєному нову вкладку 
	 */
	this.createNewtab = (newTab = false) => {
		
		// Формуємо додаткову вкладку для виводу
		if (this.tabs.length < 10) {

			// Дані про нову вкладку
			if(!newTab || newTab['forJs'] == 'createNewtab')
				newTab = this.tabs[this.tabActive];

			// // Для добавлення файлу!!!!
			// newTab = {
			// 	nameLabel: 'config.php',
			// 	path: './filemanager/config.php',
			// 	pathArr: ['.', 'filemanager'],
			// 	type: 'file'
			// }

			// Добавляємо нову вкладку
			this.tabActive = this.tabs.push(newTab) - 1;

			// Виводимо її і змінюємо активну вкладку
			this.setMaterialTab();

		} else {

			// Виводимо помилку
			runNotify({ message: 'Можна максимально 10 вкладок!' });
		}
	}



	/**
	 * Видаляємо вкладку
	 */
	this.removeTab = ({ tabId }) => {

		// Залишаємо одну вкладку
		if (this.tabs.length != 1) {

			// Дані про нову вкладку
			this.tabs = this.tabs.filter((item, index) => index != tabId);

			// Добавляємо нову вкладку
			this.tabActive = isUndefined(this.tabs[this.tabActive]) ? this.tabActive - 1 : this.tabActive;

			// Очищуємо вкладки, щоб згенерувалися нові
			$(self.boxFolderGroup).empty();

			// Виводимо її і змінюємо активну вкладку
			this.setMaterialTab();
		}
	}



	/**
	 * Активовуємо вкладку
	 */
	this.setTab = ({ tabId }) => {

		// Якщо це не поточна вкладка тоді запускаємо активацію
		if (tabId != this.tabActive) {
			
			// Задаємо активацію вкладки
			this.tabActive = tabId;
			
			// Отримуємо дані поточної вкладки
			const tab = this.tabs[this.tabActive];

			// Очищуємо вкладки, щоб згенерувалися нові
			$(self.boxFolderGroup).empty();

			// Виводимо вкладки
			this.setMaterialTab(tab);

			// Виводимо дані про поточний шлях відно вкладки
			this.currentPath = (tab.path) ? tab.path : '.';

			// Виводимо папку з оновленим шляхом
			if (tab.type === 'dir')
				this.getDir();
			else
				this.setFileEditor(tab);
		}
	}




	/**
	 * Після видалення оповіщуємо користувача
	 */
	this.deleteAlert = (data) => {

		// Виводимо інформацію при видалення
		self.getDir(false, data.textAlert, data.typeAlert);
	}



	/**
	 * Завантажуємо файл в папку
	 */
	this.uploadFile = () => {

		// Спробуємо викликати вікно завантаження файлу
		const fileInput = document.createElement('input');
		fileInput.type     = 'file';
		fileInput.multiple = true;

		const handleFileSelect = (event) => {
			
			const files = Array.from(event.target.files);

			// Створюємо FormData об'єкт
			const formData = new FormData();

			// Додаємо файли до об'єкта formData
			files.forEach((file, index) => {
				formData.append(`file${index}`, file);
			});

			// Додаємо інші дані, які ви хочете відправити
			formData.append('forAjax', 'uploadFile');
			formData.append('path', this.currentPath);

			// Робимо AJAX-запит
			fetch(option.pathManagerFile, {
				method: 'POST',
				body: formData,
			})
			.then(response => response.json())
			.then(data => {

				// Виводимо інформацію при першому завантаженні
				self.getDir(false, data.textAlert, data.typeAlert);
			});
		}

		fileInput.addEventListener('change', handleFileSelect);

		// Викликаємо вікно завантаження файлу
		fileInput.click();
	}


	/**
	 * Вивід статичного тексту, якщо папка пуста
	 */
	this.viewNoResultInfo = (nameLabel, title = false, buttonNeed = true) => {

		if (!title)
			title = `${this.lang.textFolder}  <span>&ldquo;${nameLabel}&rdquo;</span>  ${this.lang.textEmpty}`;

		let linksHtml = '';

		if (buttonNeed) {
			linksHtml = `<div class="no-result-info__footer">
							${this.lang.folderEmptyRecomend}
							<a href="#" class="link-primary" data-bs-toggle="modal" data-bs-target="#modal-create-file">${this.lang.actionCreateFile}</a>
							<a href="#" class="link-primary" data-bs-toggle="modal" data-bs-target="#modal-create-folder">${this.lang.actionCreateFolder}</a>
						</div>`;
		}

		return `<div class="no-result-info">
					<div class="no-result-info__top d-flex align-items-center">
						<div class="no-result-info__icon-hold hover-scale cur-p" data-bs-toggle="modal" data-bs-target="#modal-create-folder">
							<svg class="icon icon-additem"><use href="#icon-additem"></use></svg>
						</div>
						<div class="no-result-info__text">
							<h2 class="no-result-info__text-title">${title}</h2>
							<p class="no-result-info__text-inner">${this.lang.textAddFile}</p>
						</div>
					</div>
					${linksHtml}
				</div>`;
	}



	/**
	 * Випливаючий список кнопок для файлів і папок 
	 */
	this.viewAddTabMaterial = () => {
		
		return `<li class="nav-item nav-item--add-tab">
					<div class="dropdown">
						<button class="nav-link btn btn-sm btn-icon btn-new-tab btn-light btn-action" data-bs-toggle="dropdown">
							<svg class="icon icon-plus-circle"><use href="#icon-plus-circle"></use></svg>
						</button>
						<ul class="dropdown-menu">
							<li>
								<a class="dropdown-item" href="#" data-for-js="createNewtab">
									<svg class="icon icon-tab"><use href="#icon-tab"></use></svg>
									<span classs="dropdown-item-inner-text">${this.lang.actionCreateTab}</span>
								</a>
							</li>
							
							<li><hr class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-create-folder">
									<svg class="icon icon-folder-line"><use href="#icon-folder-line"></use></svg>
									<span classs="dropdown-item-inner-text">${this.lang.actionCreateFolder}</span>
								</a>
							</li>
							<li>
								<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-create-file">
									<svg class="icon icon-file-line"><use href="#icon-file-line"></use></svg>
									<span classs="dropdown-item-inner-text">${this.lang.actionCreateFile}</span>
								</a>
							</li>
							<li><hr class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="#" data-for-js="uploadFile">
									<svg class="icon icon-upload"><use href="#icon-upload"></use></svg>
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
	this.viewTabMaterial = ({ nameLabel, type, url, path, pathArr }, index = null, needUpdate = false) => {

		// Змінна для переключалки папок
		foldersHtml = '';

		// Якщо більше ніж два тоді формуємо кнопки інших папок
		if (Array.isArray(pathArr)) {
			if (pathArr.length >= 2) {

				// Початок блоку кнопок папок
				foldersHtml += `<div class="btn-group-vertical w-100 btn-group-folders">`;

				// Переходимо до головної
				foldersHtml += `<button class="btn btn-sm btn-light btn-home"
							data-path="."
							data-name="${nameLabel}"
							data-type="${type}"
							data-ajax-callback="updateTableItems"
							data-for-ajax="getDir"><svg class="icon icon-arrow icon-arrow-right"><use href="#icon-arrow-right"></use></svg><svg class="icon icon-home"><use href="#icon-home"></use></svg></button>`;

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
							data-for-ajax="getDir"><svg class="icon icon-arrow icon-arrow-right"><use href="#icon-arrow-right"></use></svg>${folder}</button>`;
					}
				});

				// Кінець блоку кнопок папок
				foldersHtml += `</div>`;
			}
		}

		// Початок наповнення вкладки
		let boxTab = (!needUpdate) ? `<li class="nav-item dropdown-folder-set-path ${this.tabActive == index ? 'active' : ''}" id="tab-${index}">` : '';
		
		// Основне вмістиме вкладки
		boxTab += `<button class="btn btn-sm btn-action btn-close" data-for-js="removeTab" data-tab-id="${index}"></button>
					<button class="nav-link btn btn-sm btn-light btn-action btn-tab" data-bs-toggle="dropdown" data-for-js="setTab" data-tab-id="${index}">
						<svg class="icon icon-${type}-color"><use href="#icon-${type}-color"></use></svg>
						<span class="btn-inner-text">${nameLabel}</span>
					</button>
					<div class="dropdown-menu">
						<div class="input-hold-folder-path position-relative">
							<input type="search" class="form-control form-control-sm" placeholder="Шлях до файлу" value="${path}" data-input-for-js="getDirInput">
						</div>
						${foldersHtml}
					</div>`;
		
		// Закінчуємо формувати вкладку
		boxTab += `</li>`;

		// Повертаємо html вкладки
		return boxTab;
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

		// Перелік можливостей відносно типу
		const dropdownActions = {
			'dir': [
				{
					'icon': 'icon-star',
					'value': 'Відмітити',
				},
				{
					'icon': 'icon-edit',
					'value': 'Перейменувати',
				},
				{
					'icon': 'icon-copy',
					'value': 'Скопіювати',
				},
				{
					'icon': 'icon-git-pull',
					'value': 'Перемістити',
				},
				{
					'value': 'hr',
				},
				{
					'icon': 'icon-trash-2',
					'value': 'Видалити',
					'attr': 'data-for-ajax="deleteItem" data-ajax-callback="deleteAlert"'
				},
			],
			'file': [
				{
					'icon': 'icon-star',
					'value': 'Відмітити',
				},
				{
					'icon': 'icon-git-pull',
					'value': 'Перейменувати',
				},
				{
					'icon': 'icon-home',
					'value': 'Відкрити',
				},
				{
					'icon': 'icon-copy',
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
					'icon': 'icon-trash-2',
					'value': 'Видалити',
					'attr': 'data-for-ajax="deleteItem" data-ajax-callback="deleteAlert"'
				},
			]
		}

		// Формуємо data інформацію
		let attrDropdown = `data-path="${path}"
							data-name="${name}"
							data-type="${type}"`;

		// Dropdown для різних типів
		dropdownActions[type].forEach(item => {

			dropdown += (item.value === 'hr')
				? `<li><hr class="dropdown-divider"></li>`
				: `<li>
						<a class="dropdown-item" href="#" ${item.attr} ${attrDropdown}>
							<svg class="icon ${item.icon}"><use href="#${item.icon}"></use></svg>
							<span classs="dropdown-item-inner-text">${item.value}</span>
						</a>
					</li>`
		});

		
		// Формуємо data інформацію
		let attrItemData = `data-path="${path}"
						data-name="${name}"
						data-type="${type}"
						data-ajax-callback="${type == 'dir' ? 'updateTableItems' : 'setEditor'}"
						data-for-ajax="${type == 'dir' ? 'getDir' : 'getFile'}"`;


		// Повертаємо html
		return `<div class="folder-item d-flex-sides" id="${itemId}">
					<div class="folder-item__main-info">
						<label class="folder-item__checkbox folder-item__el form-check-label hover-scale checkbox-file">
							<input class="form-check-input" type="checkbox" value="">
						</label>
						<div class="folder-item__img-hold folder-item__el img-box" ${attrItemData}>${icon}</div>
						<div class="folder-item__text folder-item__el">
							<button class="folder-item__title text-truncate" ${attrItemData} ${tooltipSize}>${name}</button>
						</div>
					</div>
					<div class="folder-item__date-create fz-info hide-tablet" ${tooltipDate}>${modified_time_ago}</div>
					<div class="dropdown dropstart folder-item__action folder-item__el">
						<button class="btn btn-action btn-sm btn-icon btn-body-color btn-pr-bg hover-scale" type="button" data-bs-toggle="dropdown"><svg class="icon icon-more-vertical"><use href="#icon-more-vertical"></use></svg></button>
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

		// Дивимося, яка була активність останнього разу чи файл чи папка
		const tab = this.tabs[this.tabActive];

		// Виводимо інформацію при першому завантаженні
		if (!isUndefined(tab)) {
			if (tab.type === 'dir')
				this.getDir();
			else
				this.setFileEditor(tab);
		} else {
			this.getDir();
		}

		// Виводимо вкладки
		this.setMaterialTab();

		// Подія яку потрібно передати через ajax
		$(document).on('click', `[${self.dataForAjax}]`, self.setAction);

		// Подія яку потрібно виконати js
		$(document).on('click', `[${self.dataForJs}]`, self.setAction);

		// Подія яку потрібно виконати js
		$(document).on('input', `[${self.dataInputForJs}]`, self.setAction);

	}
}


/**
 * Запускаємо скріпт
 */
const fileManager = new FileManager();
fileManager.init();
