<?php
defined('security') or die('Access denied'); // Add light protection against file access

// We check whether it gives us information $user from $_COOKIE (0--beforeController.php)
isUserLogined($user);

// General settings
$urlSuccess  = PATH; // Link where to send in case of error

$insertTable = 'users'; // The table to which we will add a new record

$alert['text'] = 'Confirmation email has been sent.'; // 
$alert['type'] = 'success'; // success | info | warn | error

// The avatar is optional, so we make a similar entry
$avatar      = $_FILES['avatar'];
$avatarExist = (empty($avatar['name'])) ? false : true;

// Generate data and check its accuracy
$toDb['email']    = clean($_POST['email']);
$toDb['password'] = clean($_POST['password']);
$toDb['name']     = clean($_POST['name']);
$toDb['surname']  = clean($_POST['surname']);

// Validate data before add
$error = []; // Variable for error
$error[] = checkEmail($toDb['email']);                          // Check email
$error[] = checkPassword($toDb['password'], 4, 85, true);       // Check password
$error[] = checkValue('name', $toDb['name'], 2, 50);            // Check name
$error[] = checkValue('surname', $toDb['surname'], 2, 50);      // Check surname
$error[] = ($avatarExist) ? checkImageFile($avatar, true) : ''; // Check avatar

// If there are errors, we display them
if (arrExist(array_filter($error)))
	jsonAlert($error, 'error');

// Trying to get a user by the requested login
$user = getUser($toDb['email']);

// Checking the user for existence
if (arrExist($user))
	jsonAlert('User with this email already exists.', 'error');

// After all the checks, we can encode the password
$passwordEncode = encodePassword($toDb['password']);

// Add DB data
$toDb['password'] = $passwordEncode['value'];
$toDb['token']    = $passwordEncode['token'];

// Call the add function
$userID = addRecord($insertTable, $toDb);

// Upload pictures to the project
uploadImage('avatar', $userID.'-sm', $filePath['user'], 30, 30); // Avatar small we will quietly store it on the side, we will not enter it into the database
$updateImg['avatar'] = uploadImage('avatar', $userID, $filePath['user'], 200, 200); // Avatar normal
$updateImg['link']   = generateLink($userID.'-'.$toDb['name'].'-'.$toDb['surname']); // Link from name and surname with id

// Update images in bd
editRecord($insertTable, $updateImg, 'id = '.$userID);

// Params for email send
$sendData['id']      = $userID;
$sendData['email']   = $toDb['email'];
$sendData['name']    = $toDb['name'];
$sendData['surname'] = $toDb['surname'];

// We send an activation letter
sendUserActivation($sendData);

// Create a response text
setAlert($alert['text'], $alert['type']); // Alert on other page
jsonAlert($alert['text'], $alert['type'], $urlSuccess);
