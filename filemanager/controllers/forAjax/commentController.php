<?php
defined('security') or die('Access denied'); // Add light protection against file access

// If there is no user label, then switch to the main page
isUserRegistered($user, 'Only registered users can add comments.', true);

// Alert settings
$alert['text'] = 'Comment successfully added!'; 
$alert['type'] = 'success'; // success | info | warn | error

// Generate data and check its accuracy
$toDb['text']       = addslashes(trim($_POST['comment']));
$toDb['article_id'] = clean($_POST['article-id']);
$toDb['user_id']    = clean($user['id']);
$toDb['date_add']   = time();

// Validate data before add
$error[] = checkArticleExist($toDb['article_id']);
$error[] = checkCommentLimit($toDb['article_id'], $user['id']);
$error[] = checkValue('comment', $toDb['text'], 5, 600);

// If there are errors, we display them
if (arrExist(array_filter($error)))
	jsonAlert($error, 'error');

// Call the add function
$insertID = addRecord('comments', $toDb);

// Additional data for js function
$jsonResponse['commentSum']              = countDataInBd('comments', ['article_id' => $toDb['article_id']]);
$jsonResponse['commentSum']              = declensionWord($jsonResponse['commentSum'], ['Comment', 'Comments', 'Comments']);
$jsonResponse['comment']['user_link']    = setLink($user['link'], 'user-detail');
$jsonResponse['comment']['user_img']     = viewImg(setImgSm($user['avatar']), 'user').addTmpView($user['avatar_cache_num']);
$jsonResponse['comment']['user_name']    = viewFullName($user['name'], $user['surname']);
$jsonResponse['comment']['comment_date'] = 'Today';
$jsonResponse['comment']['comment']      = nl2br(trim($_POST['comment']));

// Create a response text
jsonAlert($alert['text'], $alert['type'], false, 'viewNewComment', $jsonResponse);