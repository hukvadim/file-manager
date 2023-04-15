<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Logout
if ($_GET['logout'])
	authData('delete');

// Get user data
$user = authData('get');

