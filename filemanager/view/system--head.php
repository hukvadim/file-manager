<?php
	defined('security') or die('Access denied'); // Add light protection against file access
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui, shrink-to-fit=no viewport-fit=cover">

	<title><?=viewStr($seo['title'])?></title>

	<link rel="apple-touch-icon" sizes="180x180" href="<?=setPath('favicon')?>apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?=setPath('favicon')?>favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?=setPath('favicon')?>favicon-16x16.png">
	<link rel="manifest" href="<?=setPath('favicon')?>site.webmanifest">
	<link rel="shortcut icon" href="<?=setPath('favicon')?>favicon.ico">
	<meta name="msapplication-config" content="<?=setPath('favicon')?>browserconfig.xml">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">


	<?php if ($systemOption['admin']): ?>
		<link rel="stylesheet" href="<?=setPath('css')?>admin/admin.css<?=addTmpView()?>">
	<?php endif ?>

	<meta name="author" content="Zahar">
</head>
<body id="to-top" class="nav-padding sticky-footer<?=$systemOption['bodyCssClass']?>">
	<noscript><div class="alert alert-danger container" role="alert"><strong>Oops!</strong> You have javascript disabled! Some elements of the site may not work. We recommend enabling javascript for greater convenience</div></noscript>

	<?php
		// HTML svg icons
		include 'system--head-svg.php';

		// HTML site menu
		include 'block--nav.php';
	?>