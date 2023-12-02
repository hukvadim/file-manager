<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Формуємо шлях до папки
$getPath = clean($_POST['path']);

// Отримуємо назву, щоб додавати назву файлу до alert
$fileName = basename($getPath);

// Нараметри для оповіщення
$alert['type'] = 'success'; // success | info | warn | error
$alert['text'] = ($fileName and $fileName != '.') ? "Перейшли в папку $fileName" : 'Перейшли в основну папку';

// Якщо потрібно замінити текст оповіщення
if (isset($_POST['textAlert']) and $_POST['textAlert'])
	$alert['text'] = $_POST['textAlert'];

// Якщо потрібно замінити тип оповіщення
if (isset($_POST['typeAlert']) and $_POST['typeAlert'])
	$alert['type'] = $_POST['typeAlert'];

// Витягуємо інформацію про папку
$return['demo'] = $_POST;
$return['list'] = dirToArray($getPath, true);

// Формуємо шлях, щоб повернутися назад
$return['prevPath'] = getPrevPath($_POST);

// Формуємо шлях, щоб повернутися назад
$return['getFile'] = is_file($getPath);

// Encode result for ajax response
jsonAlert($alert['text'], $alert['type'], $return);