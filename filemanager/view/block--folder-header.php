<?php
	defined('security') or die('Access denied'); // Add light protection against file access
?>

<div class="folder-list-header d-flex-sides">
	<div class="folder-list-header__left d-flex-side-left">
		<label class="form-check-label checkbox-file">
			<input class="form-check-input" type="checkbox" value="">
		</label>
		<div class="btn-folder-group w-100">
			<ul class="nav nav-pills nav-files w-100 js-box-folder-group">
				<li class="nav-item nav-item--add-tab">
					<button class="nav-link btn btn-sm btn-icon btn-new-tab btn-light btn-action">
						<svg class="icon icon-plus-circle"><use xlink:href="#icon-plus-circle"></use></svg>
					</button>
				</li>
				<li class="nav-item">
					<button class="btn btn-sm btn-action btn-close"></button>
					<button class="nav-link btn btn-sm btn-light btn-action active">
						<svg class="icon icon-dir-color"><use xlink:href="#icon-dir-color"></use></svg>
						Головна
					</button>
				</li>
				<!-- <li class="nav-item">
					<button class="btn btn-sm btn-action btn-close"></button>
					<button class="nav-link btn btn-sm btn-light btn-action ">
						<svg class="icon icon-folder-color"><use xlink:href="#icon-folder-color"></use></svg>
						css
					</button>
				</li>
				<li class="nav-item">
					<button class="btn btn-sm btn-action btn-close"></button>
					<button class="nav-link btn btn-sm btn-light btn-action">
						<svg class="icon icon-file-color"><use xlink:href="#icon-file-color"></use></svg>
						style.css
					</button>
				</li> -->
			</ul>
		</div>
	</div>
</div>