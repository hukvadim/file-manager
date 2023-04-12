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
		throw new InvalidArgumentException("Invalid file path key: $filePathKey");

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
 * Global helpers
 */


/**
* Clean up text
*/
function viewStr($value = false)
{
	return ($value) ? stripslashes($value) : false;
}