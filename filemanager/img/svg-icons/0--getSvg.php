<?php
	$folderPath = ($_GET['path']) ? $_GET['path'].'/' : '.';

	$iconList = scandir($folderPath);
	
	unset($iconList[0]);	
	unset($iconList[1]);

?>

<p class="svg-list">
<?php if (is_array($iconList)): ?>
	<?php foreach ($iconList as $folder): ?>
		<?php
			if($folder == 'index.html' || $folder == '0--getSvg.php' || stripos($folder, '.') !== false)
				continue;
		?>
		<span class="link-item">
			<a href="?path=<?=$folder?>" class="link"><?=$folder?></a>
		</span>

	<?php endforeach ?>
<?php endif ?>
</p>

<p class="svg-list">
<?php if (is_array($iconList)): ?>
	<?php foreach ($iconList as $icon): ?>
		<?php
			if($icon == 'index.html' || $icon == '0--getSvg.php' || stripos($icon, '.') === false)
				continue;
		?>
		<span>
			<img src="<?=($_GET['path']) ? $folderPath.$icon : $icon?>" alt="">
		</span>

	<?php endforeach ?>
<?php endif ?>
</p>



<style>
	.svg-list {
    display: flex;
    flex-wrap: wrap;
}
.svg-list span {
    flex: 10%;
    text-align: center;
    margin-bottom: 45px;
}
.svg-list img {
	width: 26px;
    height: 26px;
}
</style>