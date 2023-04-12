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
	$filePath['favicon']     = $filePath['img'].'favicon/';

	// Check if the key exists in the $filePath array.
	if (!array_key_exists($filePathKey, $filePath))
		throw new InvalidArgumentException(setLang('error__filePathKey'));

	// Construct the file path by concatenating the base path (if provided) and the file path from the $filePath array.
	return ($basePath) ? $basePath . $filePath[$filePathKey] : MANAGERFOLDER . $filePath[$filePathKey];
}


/**
 * Prints an array to the output for debugging purposes
 */
function print_arr($arr)
{
	echo '<pre>'; print_r($arr); echo "</pre>";
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