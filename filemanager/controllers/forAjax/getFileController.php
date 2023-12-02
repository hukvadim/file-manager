<?php
defined('security') or die('Access denied'); // Add light protection against file access
// print_arr($_POST); exit;
// Формуємо шлях до папки
$getPath = clean($_POST['path']);

// Отримуємо назву, щоб додавати назву файлу до alert
$fileName = basename($getPath);

// Витягуємо інформацію про папку
$return['ext'] = setEditorExt(pathinfo($fileName)['extension']);
$return['content'] = htmlspecialchars(file_get_contents($getPath));
$return['data'] = $_POST;

// Нараметри для оповіщення
$alert['type'] = (!$return['content']) ? 'error' : 'success'; // success | info | warn | error
$alert['text'] = (!$return['content']) ? 'Файл $fileName редагувати не вийде!' : "Редагуємо файл $fileName";

// Encode result for ajax response
jsonAlert($alert['text'], $alert['type'], $return);