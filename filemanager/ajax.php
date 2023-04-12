<?php
	define('security', TRUE); // Add light protection against file access

	// Check if the request method is POST
	if ($_SERVER['REQUEST_METHOD'] !== 'POST')
		exit('Invalid request method.');

	// Sanitize input data received from POST
	$formType = filter_input(INPUT_POST, 'form-type', FILTER_SANITIZE_STRING);

	// Base check for send form
	if (is_array($_POST) AND $formType OR $_FILES) {
		
		// Connect the config file
		include 'app/config.php';

		// If the administrator parameter is passed, then we take additional steps
		if (isset($_POST['admin'])) {
		
			// Connect the config file
			@include 'app/admin/config.php';

			// Create a page type
			$pageType = (clean($_POST['pageType'])) ? clean($_POST['pageType']) : 'users';

			// Add path to form controller
			$systemOption['page'] = 'admin/forAjax/'.clean($_POST['form-type']);

		} else {

			// Add path to form controller
			$systemOption['page'] = 'forAjax/'.clean($_POST['form-type']);
		}

		// Switch whether to load the controller or just issue a message
		$systemOption['errorControllerNeed'] = false;

		// Connect the base controller
		include 'app/baseController.php';

	} else {

		// If there are no parameters, issue a message
		echo jsonAlert('I can\'t figure out what form to work with. There is no POST or FILES data!');
	}
