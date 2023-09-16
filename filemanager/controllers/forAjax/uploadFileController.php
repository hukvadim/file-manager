<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Формуємо шлях до папки
$getPath = clean($_POST['path']);

// Отримуємо назву, щоб додавати назву файлу до alert
$files = $_FILES;

// Зберігаємо надані файли до поточного шляху
simpleUploadFile($files, $getPath);

// Формуємо відповідь для Ajax
$return['typeAlert'] = 'success'; // success | info | warn | error
$return['textAlert'] = 'Файл успішно завантажено!';

// Encode result for ajax response
exit(json_encode($return));