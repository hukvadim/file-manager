<?php
defined('security') or die('Access denied'); // Add light protection against file access

// If there is no user label, then switch to the main page
isUserRegistered($user, 'Only registered users can add articles.', true);

// The table to which we will add a new record
$insertTable = 'articles';

// Alert settings
$alert['text'] = 'Record added successfully!'; 
$alert['type'] = 'success'; // success | info | warn | error


// Generate data and check its accuracy
$toDb['title']      = clean($_POST['title']);
$toDb['link']       = generateLink($toDb['title']);
$toDb['meta_title'] = $toDb['title'];
$toDb['date_add']   = time();
$toDb['cat_id']     = clean($_POST['category']);
$toDb['user_id']    = clean($user['id']);
$toDb['text_sm']    = addslashes($_POST['text-small']);
$toDb['text']       = addslashes($_POST['article']);

// Validate data before add
$error = []; // Variable for error
$error[] = checkImageFile($_FILES['image'], true);              // Check avatar
$error[] = checkCategoryExist($rivers, $toDb['cat_id']);        // Check category
$error[] = checkValue('title', $toDb['title']);                 // Check title
$error[] = checkValue('description', $toDb['text_sm'], 2, 200); // Check description
$error[] = checkValue('article', $toDb['text'], 2, 5000);     // Check article

// If there are errors, we display them
if (arrExist(array_filter($error)))
	jsonAlert($error, 'error');

// Check if the link exists in already added articles
isUrlExist($insertTable, $toDb['link']);


// Call the add function
$insertID = addRecord($insertTable, $toDb);
print_arr($insertID); exit;
// Upload pictures to the project
$updateImg['img']         = uploadImage('image', $insertID.'-card', $filePath['article'], 380, 300); // Image for card
$updateImg['img_article'] = uploadImage('image', $insertID.'-preview', $filePath['article'], 825, 500, false); // Image for article preview
$updateImg['meta_img']    = uploadImage('image', $insertID.'-social', $filePath['article'], 900, 900, false); // Image for social

// Update images in bd
editRecord($insertTable, $updateImg, 'id = '.$insertID);

// Create a response text
setAlert($alert['text'], $alert['type']);
jsonAlert($alert['text'], $alert['type'], gotToProfile());



