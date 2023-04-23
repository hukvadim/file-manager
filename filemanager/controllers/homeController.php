<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Seo data
$seo['title'] = setLang('pageTitleHome');

// Дістаємо файли для головної сторінки
$files = sortFiles(dirToArray('.'));

// print_arr($files); exit;