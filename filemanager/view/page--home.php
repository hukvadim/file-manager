<?php
	defined('security') or die('Access denied'); // Add light protection against file access

	$types[] = 'folder'; 
	$types[] = 'folder'; 
	$types[] = 'folder'; 
	$types[] = 'img'; 
	$types[] = 'file'; 
	$types[] = 'file';
	$types[] = 'img'; 
	$types[] = 'file'; 
	$types[] = 'file'; 
	$types[] = 'folder'; 
	$types[] = 'folder'; 
	$types[] = 'folder'; 
	$types[] = 'img'; 
	$types[] = 'file'; 
	$types[] = 'file';
	$types[] = 'img'; 
	$types[] = 'file'; 
	$types[] = 'file'; 
?>

<div class="page-content">
	<div class="container">

		<div class="folder-list-header d-flex-sides mb-2">
			<div class="folder-list-header__left d-flex-side-left gap-10">
				<label class="form-check-label">
					<input class="form-check-input" type="checkbox" value="">
				</label>
				<button class="btn btn-sm btn-icon btn-action btn-body-color">
					<svg class="icon icon-refresh"><use xlink:href="#icon-refresh"></use></svg>
				</button>
			</div>
			<div class="folder-list-header__right d-flex-side-right">
				<button class="btn btn-sm btn-icon btn-action btn-body-color">
					<svg class="icon icon-arrow-left"><use xlink:href="#icon-arrow-left"></use></svg>
				</button>
				<button class="btn btn-sm btn-icon btn-action btn-body-color">
					<svg class="icon icon-arrow-right"><use xlink:href="#icon-arrow-right"></use></svg>
				</button>
			</div>
		</div>

		<div class="folder-list folder-list-items">

			<?php foreach ($files as $file): ?>
			<div class="folder-item d-flex-sides">
				<div class="folder-item__main-info">
					<label class="folder-item__checkbox folder-item__el form-check-label hover-scale">
						<input class="form-check-input" type="checkbox" value="">
					</label>
					<a href="#" class="folder-item__img-hold folder-item__el img-box">
						<?=viewIcon($file['ext'])?>
						<!-- <?php if ($file == 'img'): ?>
							<img src="<?=setPath('img')?>demo-img.jpg" alt="" class="folder-item__img img-size hover-scale">
						<?php elseif (is_dir($file)): ?>
							<div class="icon-file img-size hover-scale" style="--ext: 'txt';"></div>
						<?php else: ?>
							<svg class="icon img-size icon-folder hover-scale"><use xlink:href="#icon-folder"></use></svg>
						<?php endif ?> -->
					</a>
					<div class="folder-item__text folder-item__el">
						<a href="#" class="folder-item__title text-truncate"><?=viewStr($file['name'])?></a>
					</div>
				</div>
				<div class="folder-item__size fz-info hide-tablet"><?=($file['size']) ? viewSize($file['type'], $file['size']) : ''?></div>
				<div class="folder-item__date-create fz-info hide-tablet"><?=$file['modified']?></div>
				<div class="dropdown dropstart folder-item__action folder-item__el">
					<button class="btn btn-action btn-sm btn-icon btn-body-color btn-pr-bg hover-scale" type="button" data-bs-toggle="dropdown">
						<svg class="icon icon-more-vertical"><use xlink:href="#icon-more-vertical"></use></svg>
					</button>
					<ul class="dropdown-menu dropdown-menu-end">
						<li>
							<a class="dropdown-item" href="#">
								<svg class="icon icon-article"><use xlink:href="#icon-home"></use></svg>Action
							</a>
						</li>
						<li>
							<a class="dropdown-item" href="#">
								<svg class="icon icon-article"><use xlink:href="#icon-article"></use></svg>Another action
							</a>
						</li>
						<li>
							<a class="dropdown-item" href="#">
								<svg class="icon icon-article"><use xlink:href="#icon-squares"></use></svg>Something else here
							</a>
						</li>
					</ul>
				</div>
			</div>
			<?php endforeach ?>
		</div>


	</div>
</div>



<div class="page-history">
	<div class="container position-relative">

		<h3 class="block-title mb-4">Відмічений матеріл</h3>

		<div class="folder-list-history mb-5 js-scroll-horizontal">
			<?php foreach ($types as $key => $value): ?>
				<div class="folder-item d-flex-sides folder-item--card">
					<div class="folder-item__main-info">
						<a href="#" class="folder-item__img-hold folder-item__el img-box">
							<?php if ($value == 'img'): ?>
								<img src="<?=setPath('img')?>demo-img.jpg" alt="" class="folder-item__img img-size hover-scale mask-squircle">
							<?php elseif ($value == 'file'): ?>
								<div class="icon-file img-size hover-scale" style="--ext: 'txt';"></div>
							<?php else: ?>
								<svg class="icon img-size icon-folder hover-scale"><use xlink:href="#icon-folder"></use></svg>
							<?php endif ?>
						</a>
						<div class="folder-item__text folder-item__el">
							<a href="#" class="folder-item__title text-truncate">script.js</a>
						</div>
						<div class="folder-item__action">
							<button class="btn btn-action btn-star btn-sm btn-icon">
								<svg class="icon icon-star"><use xlink:href="#icon-star-fill"></use></svg>
							</button>
						</div>
					</div>
					<div class="folder-item__date-create fz-info hide-tablet">15.04.2023 11:30</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>
