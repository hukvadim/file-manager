<?php
defined('security') or die('Access denied'); // Add light protection against file access


// Формуємо шлях до папки
$getPath = clean($_POST['path']);

// Отримуємо назву файлу
$fileName = clean($_POST['fileName']);

// Повний шлях до файлу
$filePath = ($getPath == '.') ? $getPath . '/' .  $fileName : $getPath . $fileName;

// Нараметри для оповіщення
$alert['type'] = 'success'; // success | info | warn | error
$alert['text'] = "Створили файл $fileName";

// Перевіряємо, чи існує файл за вказаним шляхом
if (file_exists($filePath)) {
    $alert['type'] = 'error';
    $alert['text'] = "Файл $fileName вже існує";
} else {
    // Створюємо файл з порожнім вмістом
    if (file_put_contents($filePath, '') === false) {
        $alert['type'] = 'error';
        $alert['text'] = "Не вдалося створити файл $fileName";
    }
}

// Формуємо відповідь для Ajax
$return['typeAlert'] = $alert['type'];
$return['textAlert'] = $alert['text'];


// Encode result for ajax response
exit(json_encode($return));