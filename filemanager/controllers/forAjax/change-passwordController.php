<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Get user login and password
$login        = clean($_POST['email']);
$newPassword  = clean($_POST['new-password']);
$needRedirect = clean($_POST['need-redirect']);

// Validate data
$error[] = checkEmail($login);
$error[] = checkValue('password', $newPassword , 4, 200);

// If there are errors, we display them
if (arrExist(array_filter($error)))
	jsonAlert($error, 'error');

// Trying to get a user by the requested login
$user = getUser($login);

// If the user is found, but the token is incorrect, then we notify the user about it
if (!arrExist($user))
	jsonAlert('No user found to activate');

// If the user is found, but the token is incorrect, then we notify the user about it
if ($user['email_confirmed'] === 'no')
	jsonAlert('This user is not activated!');

// After all the checks, we can encode the password
$passwordEncode = encodePassword($newPassword);

// After all the checks, we can encode the password
$toDb['password'] = $passwordEncode['value'];
$toDb['token']    = $passwordEncode['token'];
$toDb['email_token']   = NULL;
$toDb['email_newpass'] = NULL;

// Update images in bd
editRecord('users', $toDb, 'id = '.$user['id']);

// Set authorisation data
authData('set', $user['id'], $passwordEncode['token']);

// General settings
$alert['type'] = 'success'; // success | info | warn | error
$alert['text'] = 'Password changed!'; 
$urlSuccess  = ($needRedirect) ? gotToProfile() : false; // Link where to send in case of error

// Create a response text
setAlert($alert['text'], $alert['type']); // Alert on other page
jsonAlert($alert['text'], $alert['type'], $urlSuccess);