<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Do something before connecting the controller
include setPath('controllers').'0--beforeController.php';

// Try to connect the page controller
// @ - does not display an error if the file is not found
if(!@include(setPath('controllers', $baseControllersPath).$systemOption['page'].'Controller.php')) {

	// If failed to connect the page controller, connect the 404 page controller
	if ($systemOption['errorControllerNeed'])
		require_once setPath('controllers').'404Controller.php';
	else
		exit(setLang('error__controller'));
}

// If something is not found at all, should display a 404 error
if ($systemOption['setError'])
	require_once setPath('controllers').'404Controller.php';

// Do something after connecting the controller
include setPath('controllers').'0--afterController.php';



