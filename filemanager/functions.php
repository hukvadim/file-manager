<?php
defined('security') or die('Access denied'); // Add light protection against file access

/**
 * FUNCTIONS PART:
 * Global helpers
 */


/**
 * Constructs a file path based on a key that maps to a path in the $filePath array
 */
function setPath($filePathKey, $basePath = '')
{
	// The path to the files
	$filePath['controllers'] = 'controllers/';
	$filePath['css']         = 'css/';
	$filePath['js']          = 'js/';
	$filePath['libs']        = 'libs/';
	$filePath['view']        = 'view/';
	$filePath['img']         = 'img/';
	$filePath['users']       = $filePath['img'].'users/';
	$filePath['favicon']     = $filePath['img'].'favicon/';

	// Check if the key exists in the $filePath array.
	if (!array_key_exists($filePathKey, $filePath))
		throw new InvalidArgumentException(setLang('error__filePathKey'));

	// Construct the file path by concatenating the base path (if provided) and the file path from the $filePath array.
	return MANAGERFOLDER . $filePath[$filePathKey];
}


/**
 * Prints an array to the output for debugging purposes
 */
function print_arr($arr)
{
	echo '<pre>'; print_r($arr); echo "</pre>";
}



/**
 * Making text from an array without duplicate values
 */
function arrayToString($arr = [], $glue = "\n\r")
{
	return (arrExist($arr)) ? implode($glue, array_filter($arr)) : false;
}


/**
 * Clear cache and refresh on load
 */
function addTmpView($tmpNum = false)
{
	return ($tmpNum) ? '?v='.$tmpNum : '?v='.time();
}



/**
 * Specify the language of translation
 */
function setLang($langKey = false)
{
	return ($langKey) ? $GLOBALS['lang'][$langKey] : '!!!NoLangKey!!!';
}



/**
 * Tooltip ale
 */
function setTooltip($text = false, $placement = 'top')
{
	return 'data-bs-toggle="tooltip" title="'.$text.'" data-bs-placement="'.$placement.'"';
}




/**
 * Word declension (hour, hours, hours)
 */
function declensionWord($number = false, $word  = false, $viewWithNum = true) {
	$index = ($number%100 > 4 && $number%100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][min($number%10, 5)];
	return $viewWithNum ? $number.' '.$word[$index] : $word[$index];
}




/**
 * Determine whether it is a picture or not
 */
function isImage($ext = false)
{
	// Valid image file extensions
	$images = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

	// Check if the file extension is among the valid ones
	return in_array($ext, $images);
}






/**
 * Заносимо всі файли, папки в масив
 * @param  string  $dir          [ Шлях до папки ]
 * @param  boolean $foldersFirst [ Папки перед файлами або файли над папками ]
 * @param  boolean $skipAdd      [ Які папки пропустити ]
 * @return [type]                [ array || false ]
 */
function dirToArray($dir = '.', $needAjax = false, $foldersFirst = true, $skipAdd = false)
{
	// Якщо назва папки без слеша, core/modal > core/modal/
	if ($dir[-1] !== '/')
		$dir .= '/';

	// Розширення, які треба замінити
	include 'extSwap.php';
	
	// Вказуємо значення, що будемо пропускати
	$skip = ['./.git', '.git'];
	
	// Якщо передали папки (через кому), що треба пропустити, тоді об'єднюємо з масивом $skip
	if ($skipAdd)
		$skip = array_unique(array_merge($skip, explode(',', str_replace(' ', '', $skipAdd))));
	
	// Створюємо шаблон для glob, щоб відфільтрувати файли та папки
	$pattern = sprintf('%s{,.}[!.,!..]*', $dir);

	// Використовуємо glob з опціями GLOB_BRACE для сканування вказаної папки
	$files = array_diff(glob($pattern, GLOB_BRACE), $skip);

	// Формуємо масив файлів та директорій з їхньою інформацією
	$dirArr = [];
	
	// Перебираємо файли і папки
	if (arrExist($files)) {
		foreach ($files as $file) {

			// Формуємо дані файлу
			$fileInfo     = pathinfo($file);
			$ext          = isset($fileInfo['extension']) ? $fileInfo['extension'] : ''; // Формуємо розширення
			$ext          = array_key_exists($ext, $extList) ? $extList[$ext] : $ext; // Дивимося чи потрібно підміняти розширення
			$timeModified = filemtime($file); // Time modified
			
			// Записуємо дані файлу
			$fileData = [
				'name'              => basename($file),
				'path'              => is_dir($file) ? $file.'/' : $file,
				'ext'               => $ext,
				'type'              => is_dir($file) ? 'dir' : 'file',
				'size'              => filesize($file),
				'modified_date'     => date("d.m.Y H:i", $timeModified),
				'modified_time_ago' => timeAgo($timeModified),
			];

			// Якщо потрібна додаткова інформація для ajax
			if ($needAjax) {
				$fileData['icon']    = viewIcon($fileData);
				$fileData['tooltipDate'] = setTooltip($fileData['modified_date']);
				$fileData['tooltipSize'] = setTooltip(($fileData['size']) ? htmlspecialchars(viewSize($fileData['type'], $fileData['size'])) : '');
			}

			// Добавляємо до масиву файлів
			$dirArr[] = $fileData;
		}
	}

	// Повертаємо масив файлів і відразу їх фільтруємо
	return sortFiles($dirArr, $foldersFirst);
}



/**
 * Функція, яка сортує список файлів так, щоб папки йшли першими, а потім файли, за алфавітом.
 * Також може виводити файли вище ніж папки, якщо параметр $foldersFirst встановлено в false.
 *
 * @param array $files       Список файлів для сортування.
 * @param bool  $foldersFirst Вказує, чи повинні папки розташовуватися перед файлами (true) або після файлів (false).
 * @return array             Відсортований список файлів.
 */
function sortFiles($files, $foldersFirst = true)
{
	// Сортуємо список файлів, використовуючи функцію порівняння, яка розглядає тип файлу та його ім'я.
	usort($files, function ($a, $b) use ($foldersFirst) {
		// Якщо типи файлів різні (один є папкою, а інший - файлом), розміщуємо папку або файл згідно з параметром $foldersFirst.
		if ($a['type'] !== $b['type'])
			return ($a['type'] === 'dir' xor $foldersFirst) ? 1 : -1;

		// Якщо типи файлів однакові, порівнюємо їхні імена за алфавітом.
		return strcmp($a['name'], $b['name']);
	});

	return $files;
}






/**
 * Display the number of days between a given date and the current date
 */
function timeAgo($date)
{
	// Check if $date is valid
	if (!is_numeric($date) && !is_string($date)) return;

	// Convert $date to a timestamp if it's a string
	if (!is_numeric($date) && is_string($date))
		$date = strtotime($date);

	// Get today's date
	$now = time();
	
	// Get the time difference
	$diff = $now - $date;

	// Define periods in seconds
	$minute = 60;
	$hour   = 60 * $minute;
	$day    = 24 * $hour;
	$month  = 30 * $day;
	$year   = 12 * $month;

	// Calculate the number of years, months, and days
	$years  = floor($diff / $year);
	$months = floor(($diff - $years * $year) / $month);
	$days   = floor(($diff - $years * $year - $months * $month) / $day);

	// Create the response
	if ($years > 0) {
		return declensionWord($years, ['year ago', 'years ago', 'years ago']);
	} elseif ($months > 0) {
		return declensionWord($months, ['month ago', 'months ago', 'months ago']);
	} elseif ($days > 0) {
		return declensionWord($days, ['day ago', 'days ago', 'days ago']);
	} else {
		return 'Today';
	}
}





/**
 * Функція для відображення іконки файлу або папки.
 *
 * @param array|bool $file Масив, що містить інформацію про файл або папку.
 * @return string|null HTML-розмітка для відображення іконки файлу або папки.
 */
function viewIcon($file = false)
{
	// Перевірка, чи є вхідний параметр масивом
	if (!is_array($file))
		return null;

	// Якщо тип елемента є папкою, відображаємо іконку папки
	if ($file['type'] == 'dir')
		return '<svg class="icon img-size icon-folder hover-scale"><use xlink:href="#icon-folder"></use></svg>';

	// Якщо файл є зображенням, відображаємо мініатюру зображення
	if (isImage($file['ext']))
		return '<img src="' . $file['path'] . '" alt="" class="folder-item__img img-size hover-scale">';

	// Якщо файл має розширення, відображаємо іконку файлу з відповідним розширенням
	if ($file['ext'])
		return '<div class="icon-file img-size hover-scale" style="--ext: \'' . $file['ext'] . '\'"></div>';

	// Якщо файл не має розширення, відображаємо іконку файлу без розширення
	return '<div class="icon-file icon-file--no-ext img-size hover-scale"></div>';
}






/**
 * Перетворення розміру файлу з байтів у зручніші для сприйняття одиниці виміру
 */
function viewSize($fileType, $bytes)
{
	if ($fileType != 'dir') {
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		} elseif ($bytes >= 1048576) {
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		} elseif ($bytes > 1) {
			$bytes = $bytes . ' Byte';
		} elseif ($bytes == 1) {
			$bytes = $bytes . ' Byte';
		} else {
			$bytes = '0 Byte';
		}

		return $bytes;
	}
}





/**
 * Отримує попередній шлях до папки або файлу.
 */
function getPrevPath($data)
{
	// Отримуємо попередній шлях, який містить папку або файл
	$prevPathArr = explode('/', $data['path']);

	// Формуємо попередній шлях, видаляючи назву файлу або папки
	$prevPathArr = array_filter($prevPathArr, function ($value) use ($data) {
		return $value !== $data['name'];
	});

	// Збираємо шлях знову разом
	return implode('/', $prevPathArr);
}






/**
 * Hang up and receive data for user augmentation
 */
function authData($type = 'get', $id = false, $token = false)
{
	// Key for $_COOKIE
	$setKeyId    = 'userId';
	$setKeyToken = 'userToken';

	// Regarding the type, we perform the following functionality
	switch ($type) {
		case 'delete':
			// To delete, you need to specify a date in the past
			setcookie($setKeyId, '', strtotime('-1 day'), '/', DOMAIN);
			setcookie($setKeyToken, '', strtotime('-1 day'), '/', DOMAIN);

			// Take you to the main page
			redirect(PATH);
			break;

		case 'get':
			// Check if there is an authorisation tag.
			// We do not do serious checks, if the date of the tag passes, it will be deleted by itself.
			$userId    = clean($_COOKIE[$setKeyId]);
			$userToken = clean($_COOKIE[$setKeyToken]);

			// If there is no label at all, then end the code execution
			if (!$userId || !$userToken) return false;

			// Where for sql
			$where['id']    = $userId;
			$where['token'] = $userToken;

			// Trying to extract the user
			$user = getUser($where);

			// I decided not to enter the small avatar into the database, so here we form its value
			$user['avatar_sm'] = setImgSm($user['avatar']);

			// Returning user array or false
			return (arrExist($user)) ? $user : false;
			break;

		case 'set':
		default:
			// Create an authorization tag
			if ($id and $token) {
				setcookie($setKeyId, $id, strtotime('+5 days'), '/', DOMAIN);
				setcookie($setKeyToken, $token, strtotime('+5 days'), '/', DOMAIN);
			}
			return true;
	}
}





/**
 * Set alert for ajax response
 */
function jsonAlert($value = false, $type = 'error', $callbackArray = [], $callback = false, $redirect = false)
{
	// Check if the message was transmitted
	if (!$value)
		return;

	// Generate main data
	$data['type'] = $type;
	$data['value'] = (arrExist($value)) ? arrayToString($value) : $value;

	// If you need to send the user somewhere, create a link
	if ($redirect)
		$data['link'] = $redirect;

	// We are sending a message that an additional function needs to be performed
	if ($callback)
		$data['callFunc'] = $callback;

	// We are sending a message that an additional function needs to be performed
	if (arrExist($callbackArray))
		$data = $data + $callbackArray;

	// Encode data for ajax response
	exit(json_encode($data));
}


















/**
 * FUNCTIONS PART:
 * For checking
 */


/**
 * Checking an array for existence for foreach
 */
function arrExist($data = false)
{
	return (is_array($data) AND !empty($data)) ? true : false;
}




















/**
 * FUNCTIONS PART:
 * Functions for data cleaning
 */


/**
* Clean up text
*/
function viewStr($value = false)
{
	return ($value) ? stripslashes($value) : false;
}



/**
* We clean up the data as much as possible
*/
function clean($data)
{
	return htmlspecialchars(strip_tags(addslashes(trim($data))));
}