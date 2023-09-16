<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Формуємо шлях до папки
$filePath = clean($_POST['path']);

// Отримуємо назву, щоб додавати назву файлу до alert
$fileName = clean($_POST['name']);

// Отримуємо тип елементу
$itemType = clean($_POST['type']);

// Ініціалізуємо параметри для оповіщення
$alert['type'] = 'success'; // success | info | warn | error
$alert['text'] = ($fileName) ? "Видалено $fileName" : 'Елемент видалено';

// Видаляємо файл чи папку на сервері
if (!unlink($filePath)) {
    $alert['type'] = 'error'; // Встановлюємо тип оповіщення на помилку
    $alert['text'] = 'Помилка під час видалення елементу';
}

// Формуємо відповідь для Ajax
$return['typeAlert'] = $alert['type'];
$return['textAlert'] = $alert['text'];


// Encode result for ajax response
exit(json_encode($return));