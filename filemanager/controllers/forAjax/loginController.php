<?php
defined('security') or die('Access denied'); // Add light protection against file access

// We check whether it gives us information $user from $_COOKIE (0--beforeController.php)
isUserLogined($user);

// General data for the form to work
$alert['text'] = 'You successfully log in the site!';
$alert['type'] = 'success'; // success | info | warn | error

// Get user login and password
$login = clean($_POST['email']);
$pass  = clean($_POST['password']);

// Trying to get a user by the requested login
$user = getUser($login);

// Пароль, який зараз є в цього користувача
$encodePass = $user['password'];

// Checking the user for existence
if (!$user)
	jsonAlert('Login or password is incorrect'); // We won't say that we found or didn't find the user, for greater security. We don't want the attacker to know and pick a password.

// Checking the user password
if (!verifyPassword($pass, $encodePass, $user['email_newpass']))
	jsonAlert('Login or password is incorrect');

// Checking the user for publishing
if ($user['published'] == 'hide')
	jsonAlert('User moved to the archive');

// Checking the user for existence
if ($user['email_confirmed'] == 'no') {

	// We put a label to avoid sending several emails a day. Only one per day.
	if(!isset($_COOKIE['emailConfirmed'])) {
		sendUserActivation($user);
		setcookie('emailConfirmed', true, strtotime('+4 hours'), '/', DOMAIN);
		jsonAlert('The user is not active. We have just sent you an email to reactivate your account.');
	} else {
		jsonAlert('The user is not active. We have already sent an activation email today.');
	}

}

// Update user data
$toDb['token'] = generateToken();

// Update images in bd
editRecord('users', $toDb, 'id = '.$user['id']);

// Set authorisation data
authData('set', $user['id'], $toDb['token']);

// It should come to this if everything goes well
jsonAlert($alert['text'], $alert['type'], gotToProfile());