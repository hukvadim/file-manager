<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Формуємо шлях до папки
$getPath = clean($_POST['path']);

// Отримуємо назву, щоб додавати назву файлу до alert
$folderName = clean($_POST['folderName']);

// Створюємо назву файлу разом зі шляхом
$folderItem = ($getPath == '.') ? $getPath . '/' .  $folderName : $getPath . $folderName;

// Нараметри для оповіщення
$alert['type'] = 'success'; // success | info | warn | error
$alert['text'] = "Створили папку $folderName";

// Перевіряємо чи існує папка по заданому шляху
if (is_dir($folderItem)) {
    $alert['type'] = 'error';
    $alert['text'] = "Папка $folderName вже існує";
} else {

    // Створюємо папку
    mkdir($folderItem);
}

// Формуємо відповідь для Ajax
$return['typeAlert'] = $alert['type'];
$return['textAlert'] = $alert['text'];


// Encode result for ajax response
exit(json_encode($return));