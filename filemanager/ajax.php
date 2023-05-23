<?php
	define('security', TRUE); // Add light protection against file access

	// Переключаємо режим, щоб html не виводився
	$systemOption['viewHtmlNeed'] = false;

	// Base check for send form
	if (is_array($_POST) OR $_FILES) {

		// Change path to controller 
		$baseControllersPath = './';

		// Add path to form controller
		$systemOption['page'] = 'forAjax/'.clean($_POST['forAjax']);

		// Switch whether to load the controller or just issue a message
		$systemOption['errorControllerNeed'] = false;

		// Змінюємо шляхи
		$baseControllersPath = MANAGERFOLDER;

	} else {

		// If there are no parameters, issue a message
		echo jsonAlert('I can\'t figure out what form to work with. There is no POST or FILES data!');
	}
	
