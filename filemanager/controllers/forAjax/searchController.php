<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Search value
$searchVal = (clean($_POST['query'])) ? clean($_POST['query']) : '';

// Search for the value in the database
$result = search($searchVal, ['title', 'text', 'text_sm']);

// You need to add a version to the avatar so that when you change the avatar, the cache updates the avatar
if (arrExist($result)) {
	foreach ($result as $key => $article) {

		// To avoid problems in the alt attribute, we additionally encode html sibilants
		$result[$key]['title'] = htmlspecialchars($article['title']);

		// Merge name and surname
		$result[$key]['user_full_name'] = htmlspecialchars(viewFullName($article['user_name'], $article['user_surname']));

		// Add their values to the links
		$result[$key]['link']      = setLink($article['link'], 'article');
		$result[$key]['cat_link']  = setLink($article['cat_link'], 'category');
		$result[$key]['user_link'] = $url['user'].$url['data1'].$article['user_link'];

		// Forming the url of the images
		$result[$key]['user_avatar'] = viewImg(setImgSm($article['user_avatar']), 'user').addTmpView($article['avatar_cache_num']);
		$result[$key]['img']         = viewImg($article['img'], 'article');
	}
}

// Encode result for ajax response
exit( json_encode($result) );
