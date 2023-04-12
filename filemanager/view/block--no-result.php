<?php
	defined('security') or die('Access denied'); // Add light protection against file access
?>

<div class="no-result">
	<img src="<?=viewImg($systemOption['noResultImg'])?>" alt="No results" class="no-result__img">
	<h3 class="no-result__title"><?=$systemOption['noResultText']?></h3>
</div>

