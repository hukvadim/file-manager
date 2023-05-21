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



		<div class="folder-list-header d-flex-sides mb-2">
			<div class="folder-list-header__left d-flex-side-left js-scroll-horizontal">
				<label class="form-check-label checkbox-file">
					<input class="form-check-input" type="checkbox" value="">
				</label>
				<div class="btn-folder-group js-box-header-left">
					<ul class="nav nav-pills nav-files">
						<li class="nav-item">
							<button class="nav-link btn btn-sm btn-icon btn-new-tab btn-light btn-action">
								<svg class="icon icon-plus-circle"><use xlink:href="#icon-plus-circle"></use></svg>
							</button>
						</li>
						<li class="nav-item">
							<button class="btn btn-sm btn-action btn-close"></button>
							<button class="nav-link btn btn-sm btn-light btn-action active">
								<svg class="icon icon-folder-color"><use xlink:href="#icon-folder-color"></use></svg>
								jquery
							</button>
						</li>
						<li class="nav-item">
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
						</li>
					</ul>
				</div>
			</div>
		</div>



		<div class="folder-list folder-list-items js-folder-list">

			<?php foreach ($files as $key => $file): ?>
				<?php
				$folderKey = 'folder-item-' . $key;
				?>
				<div class="folder-item d-flex-sides js-card-item-in-table" id="<?= $folderKey ?>">
					<div class="folder-item__main-info">
						<label class="folder-item__checkbox folder-item__el form-check-label hover-scale checkbox-file">
							<input class="form-check-input" type="checkbox" value="">
						</label>
						<div class="folder-item__img-hold folder-item__el img-box" data-js-action="get-folder"
							data-path="<?= $file['path'] ?>"
							data-name="<?= $file['name'] ?>"
							><?= viewIcon($file) ?>
						</div>
						<div class="folder-item__text folder-item__el">
							<button class="folder-item__title text-truncate js-click-item" data-js-action="get-folder"
								data-path="<?= $file['path'] ?>"
								data-name="<?= $file['name'] ?>"
								<?= setTooltip(($file['size']) ? htmlspecialchars(viewSize($file['type'], $file['size'])) : '') ?>
								><?= viewStr($file['name']) ?></button>
						</div>
					</div>
					<div class="folder-item__date-create fz-info hide-tablet" <?= setTooltip($file['modified_date']) ?>>
						<?= $file['modified_time_ago'] ?></div>
					<div class="dropdown dropstart folder-item__action folder-item__el">
						<button class="btn btn-action btn-sm btn-icon btn-body-color btn-pr-bg hover-scale" data-bs-toggle="dropdown">
							<svg class="icon icon-more-vertical"><use xlink:href="#icon-more-vertical"></use></svg>
						</button>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="#"><svg class="icon icon-article"><use xlink:href="#icon-home"></use></svg>Action</a></li>
						</ul>
					</div>
				</div>
			<?php endforeach ?>

		</div>

	</div>
</div>






