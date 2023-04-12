<?php
defined('security') or die('Access denied'); // Add light protection against file access

// If there is no user label, then switch to the main page
isUserRegistered($user, 'Only registered users can edit profile.', true);

// General settings
$alert['text'] = 'Profile successfully updated.'; // 
$alert['type'] = 'success'; // success | info | warn | error

// The avatar is optional, so we make a similar entry
$avatar      = $_FILES['avatar'];
$avatarExist = (empty($avatar['name'])) ? false : true;

// Generate data and check its accuracy
$toDb['email']    = clean($_POST['email']);
$toDb['name']     = clean($_POST['name']);
$toDb['surname']  = clean($_POST['surname']);

// Validate data before add
$error = []; // Variable for error
$error[] = checkEmail($toDb['email']);                          // Check email
$error[] = checkValue('name', $toDb['name'], 2, 50);            // Check name
$error[] = checkValue('surname', $toDb['surname'], 2, 50);      // Check surname
$error[] = ($avatarExist) ? checkImageFile($avatar, true) : ''; // Check avatar

// Make password variable
$password = clean($_POST['password']);

// If password exist
if (!empty($password)) {
	$toDb['password'] = $password;
	$error[] = checkPassword($password, 4, 85, true);
}

// If there are errors, we display them
if (arrExist(array_filter($error)))
	jsonAlert($error, 'error');

// If password exist 
if ($password) {

	// After all the checks, we can encode the password
	$passwordEncode = encodePassword($toDb['password']);

	// Add DB data
	$toDb['password'] = $passwordEncode['value'];
	$toDb['token']    = $passwordEncode['token'];

	// Set authorisation data
	authData('set', $user['id'], $toDb['token']);
}

// Upload pictures to the project
if (!empty($_FILES['avatar']['name'])) {
	uploadImage('avatar', $user['id'].'-sm', $filePath['user'], 30, 30); // Avatar small we will quietly store it on the side, we will not enter it into the database
	$toDb['avatar']           = uploadImage('avatar', $user['id'], $filePath['user'], 200, 200); // Avatar normal
	$toDb['avatar_cache_num'] = $user['avatar_cache_num'] + 1;
}

// If the link has changed
if ($user['link'] !== $toDb['link'])
	$toDb['link'] = generateLink($user['id'].'-'.$toDb['name'].'-'.$toDb['surname']);

// If the email has changed
if ($user['email'] !== $toDb['email']) {

	// Trying to get a user by the requested login
	$userExist = getUser($toDb['email'], 'email');

	// Checking the user for existence
	if (arrExist($userExist) and $userExist['email'] == $toDb['email'])
		jsonAlert('User with this email already exists.', 'error');
}

// Update images in bd
editRecord('users', $toDb, 'id = '.$user['id']);

// Additional data for js function
$jsonResponse['avatar']  = (isset($toDb['avatar'])) ? viewImg(setImgSm($toDb['avatar']), 'user').addTmpView($toDb['avatar_cache_num']) : '';
$jsonResponse['name']    = ($user['name'] !== $toDb['name']) ? $toDb['name'] : '';
$jsonResponse['surname'] = ($user['surname'] !== $toDb['surname']) ? $toDb['surname'] : '';

// Create a response text
jsonAlert($alert['text'], $alert['type'], false, 'viewNewUserInfo', $jsonResponse);