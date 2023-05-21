<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Формуємо шлях до папки
$getPath = clean($_POST['path']);

// Отримуємо назву, щоб додавати назву файлу до alert
$fileName = clean($_POST['name']);

// General settings
$alert['type'] = 'success'; // success | info | warn | error
$alert['text'] = "Перейшли в папку $fileName";

// Витягуємо інформацію про папку
$return['demo'] = $_POST;
$return['list'] = dirToArray($getPath, true);

// Формуємо шлях, щоб повернутися назад
$return['prevPath']['url']  = getPrevPath($return['demo']);
$return['prevPath']['name'] = '<svg class="icon icon-more-horizontal"><use xlink:href="#icon-more-horizontal"></use></svg>';
$return['prevPath']['icon'] = viewIcon(['type' => 'dir']);

// Encode result for ajax response
jsonAlert($alert['text'], $alert['type'], $return);
