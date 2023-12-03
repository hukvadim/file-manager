<?php
defined('security') or die('Access denied'); // Add light protection against file access

// $types[] = 'folder';
// $types[] = 'folder';
// $types[] = 'folder';
// $types[] = 'img';
// $types[] = 'file';
// $types[] = 'file';
// $types[] = 'img';
// $types[] = 'file';
// $types[] = 'file';
// $types[] = 'folder';
// $types[] = 'folder';
// $types[] = 'folder';
// $types[] = 'img';
// $types[] = 'file';
// $types[] = 'file';
// $types[] = 'img';
// $types[] = 'file';
// $types[] = 'file';
?>

<div class="page-content">
	<div class="container">



		<?php
			// Header, folder tabs
			include setPath('view') . 'block--folder-header.php';
		?>

		<div class="folder-list folder-list-items js-folder-list" id="page-content">

			<!-- Виводимо результати через javascript -->

		</div>

		<div class="box-editor js-editor hide" id="js-editor"></div>

	</div>
</div>






