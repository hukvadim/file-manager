<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Change the page to be connected
$systemOption['page'] = 404;

// Seo data
$seo['title'] = setLang('pageTitle404');