<?php
defined('security') or die('Access denied'); // Add light protection against file access

// print_arr($_POST); exit;

// Формуємо шлях до папки
$getPath = clean($_POST['path']);

// Отримуємо назву, щоб додавати назву файлу до alert
$fileName = clean($_POST['name']);

// Нараметри для оповіщення
$alert['type'] = 'success'; // success | info | warn | error
$alert['text'] = ($fileName) ? "Перейшли в папку $fileName" : 'Перейшли в основну папку';

// Витягуємо інформацію про папку
$return['demo'] = $_POST;
$return['list'] = dirToArray($getPath, true);

// Формуємо шлях, щоб повернутися назад
$return['prevPath'] = getPrevPath($_POST);

// Encode result for ajax response
jsonAlert($alert['text'], $alert['type'], $return);
