<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Формуємо шлях до папки
$getPath = clean($_POST['path']);

// Формуємо назва файлу
$getFileName = clean($_POST['nameLabel']);

// Формуємо масив шляху
$getPathArr = $_POST['pathArr'];

// Створюємо шлях відносно переданого масиву
$result = createPath($getPathArr);

// Формуємо шлях
$return['path']   = $getPath;
$return['isFile'] = is_file($getPath);

// Нараметри для оповіщення
if ($result) {
	$alert['type'] = 'success'; // success | info | warn | error
	$alert['text'] = ($return['isFile']) ? "Створили файл $getFileName" : "Створили шлях $getPath";
} else {
	$alert['type'] = 'error'; // success | info | warn | error
	$alert['text'] = ($return['isFile']) ? "Помилка при створенні файлу $getFileName" : "Помилка при створенні шляху $getPath";
}


// Encode result for ajax response
jsonAlert($alert['text'], $alert['type'], $return);
