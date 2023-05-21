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
			<div class="folder-list-header__left d-flex-side-left position-relative">
				<label class="form-check-label checkbox-file">
					<input class="form-check-input" type="checkbox" value="">
				</label>
				<div class="btn-folder-group js-box-header-left">
					<div class="dropdown btn-folder dropdown-folder-set-path">
						<button class="btn btn-sm btn-icon btn-action btn-show-breadcrumbs" data-bs-toggle="dropdown">
							<svg class="icon icon-more-horizontal"><use xlink:href="#icon-more-horizontal"></use></svg>
						</button>
						<div class="dropdown-menu">
							<div class="input-hold-folder-path position-relative">
								<input type="text" class="form-control form-control-sm" placeholder="Шлях до файлу" value="libs/jquery/">
								<button class="btn btn-sm btn-icon btn-action btn-edit btn-pr-bg btn-similar-y position-absolute top-50 end-0 translate-middle-y">
									<svg class="icon icon-maximize"><use xlink:href="#icon-maximize"></use></svg>
								</button>
							</div>
							<div class="btn-group-vertical w-100 btn-group-folders mt-2">
								<button type="button" class="btn btn-sm btn-light"><svg class="icon icon-arrow-right"><use xlink:href="#icon-arrow-right"></use></svg>libs</button>
								<button type="button" class="btn btn-sm btn-light"><svg class="icon icon-arrow-right"><use xlink:href="#icon-arrow-right"></use></svg>jquery</button>
							</div>
						</div>
					</div>
					<span class="btn btn-action btn-sm btn-folder btn-similar-y">libs</span>
					<span class="btn btn-action btn-sm btn-folder btn-similar-y">Jquery</span>
				</div>
			</div>


			<div class="folder-list-header__right d-flex-side-right">
				<div class="folder-list-header__action-btns d-flex js-box-header-right">
					<button class="btn btn-sm btn-icon btn-action">
						<svg class="icon icon-upload"><use xlink:href="#icon-upload"></use></svg>
					</button>
					<button class="btn btn-sm btn-icon btn-action">
						<svg class="icon icon-link"><use xlink:href="#icon-link"></use></svg>
					</button>
				</div>
				<button class="btn btn-sm btn-icon btn-action btn-action--refresh">
					<svg class="icon icon-refresh"><use xlink:href="#icon-refresh"></use></svg>
				</button>
				<button class="btn btn-sm btn-icon btn-action btn-action--info">
					<svg class="icon icon-info"><use xlink:href="#icon-info"></use></svg>
				</button>
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
							<div class="folder-item__img-hold folder-item__el img-box" data-js-action="get-folder" data-path="<?= $file['path'] ?>" data-name="<?=$file['name']?>">
								<?= viewIcon($file) ?>
							</div>
							<div class="folder-item__text folder-item__el">
									<a href="#" class="folder-item__title text-truncate js-click-item"
										data-js-action="get-folder"
										data-path="<?= $file['path'] ?>"
										data-name="<?=$file['name']?>"
										<?=setTooltip(($file['size']) ? htmlspecialchars(viewSize($file['type'], $file['size'])) : '') ?>><?= viewStr($file['name']) ?></a>
									</div>
									</div>
									<div class="folder-item__date-create fz-info hide-tablet" <?= setTooltip($file['modified_date']) ?>>
										<?= $file['modified_time_ago'] ?></div>
									<div class="dropdown dropstart folder-item__action folder-item__el">
										<button class="btn btn-action btn-sm btn-icon btn-body-color btn-pr-bg hover-scale" type="button"
											data-bs-toggle="dropdown">
											<svg class="icon icon-more-vertical">
												<use xlink:href="#icon-more-vertical"></use>
											</svg>
										</button>
										<ul class="dropdown-menu dropdown-menu-end">
											<li>
												<a class="dropdown-item" href="#">
													<svg class="icon icon-article">
														<use xlink:href="#icon-home"></use>
													</svg>Action
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








