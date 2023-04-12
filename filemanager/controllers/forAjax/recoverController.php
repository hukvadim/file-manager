<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Get user login and password
$login = clean($_POST['email']);

// Email validate
if (checkEmail($login))
	jsonAlert(checkEmail($login));

// Trying to get a user by the requested login
$user = getUser($login);

// If the user is found, but the token is incorrect, then we notify the user about it
if (!arrExist($user))
	jsonAlert('User with this email was not found.');

// We send an letter with new password
sendNewPassword($user);

// General settings
$alert['type'] = 'success'; // success | info | warn | error
$alert['text'] = 'Link for password recovery has been sent to your email.'; 

// Create a response text
setAlert($alert['text'], $alert['type']); // Alert on other page
jsonAlert($alert['text'], $alert['type'], PATH);
