<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Initializes session data to remember some user data
session_start();

// Attitude to errors
error_reporting(E_ERROR); // E_ERROR | E_WARNING | E_PARSE | E_NOTICE

// Displaying a partition by default
define('DEFAULTPAGE', 'home');

// The default translation language key
define('DEFAULTLANG', 'uk');

// Default lang
$needLang = ($_GET['lang']) ? ($_GET['lang']) : DEFAULTLANG;;

// Connect the lang file
if (!include("lang/$needLang/lang.php"))
	die("lang/$needLang/lang.php not found");

// Connect the function file
if (!include('functions.php'))
	die('functions.php not found');

// View page with this key
$systemOption['page'] = (clean($_GET['view'])) ? clean($_GET['view']) : DEFAULTPAGE;

// General seo text
$seo['title'] = setLang('pageTitleHome');

// Breadcrumb array key => link, 
$breadcrumb = [];

// Add class to html body
$systemOption['bodyCssClass'] = [];

// Switch whether to load the controller or just issue a message
$systemOption['errorControllerNeed'] = true;

// If it is not found at all, should display a 404 error
$systemOption['setError'] = false;

// No result info
$systemOption['noResultImg']  = 'no-result-v1.png';
$systemOption['noResultText'] = setLang('blockNoResult');