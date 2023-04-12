<p class="svg-list">
<?php
	$folderPath = ($_GET['path']) ? $_GET['path'].'/' : 'icons/';

	$iconList = scandir($folderPath);
	
	unset($iconList[0]);	
	unset($iconList[1]);	
?>
<?php if (is_array($iconList)): ?>
	<?php foreach ($iconList as $icon): ?>
		<?php
			if($icon == 'index.html')
				continue;
		?>
		<span>
			<img src="<?=$folderPath.$icon?>" alt="">
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