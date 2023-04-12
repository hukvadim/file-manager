<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Initializes session data to remember some user data
session_start();

// Attitude to errors
error_reporting(E_ERROR); // E_ERROR | E_WARNING | E_PARSE | E_NOTICE

// Default lang
$needLang = 'en';

// Connect the lang file
if (!include("lang/$needLang/lang.php"))
	die("lang/$needLang/lang.php not found");

// Connect the function file
if (!include('functions.php'))
	die('functions.php not found');

// View page with this key
$viewPage = 'home';

// Add class to html body
$systemOption['bodyCssClass'] = [];

// General seo text
$seo['title'] = 'File manager';