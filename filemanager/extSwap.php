<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Розширення, які будемо підміняти
$extList['gitattributes'] = 'git';
$extList['LICENSE'] = 'lic';