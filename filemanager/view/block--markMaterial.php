<?php
	defined('security') or die('Access denied'); // Add light protection against file access
?>

<?php if ($types): ?>
	<div class="page-history">
		<div class="container position-relative">

			<h3 class="block-title mb-4">Відмічений матеріл</h3>

			<div class="folder-list-history mb-5 js-scroll-horizontal">
				<?php foreach ($types as $key => $value): ?>
					<div class="folder-item d-flex-sides folder-item--card">
						<div class="folder-item__main-info">
							<a href="#" class="folder-item__img-hold folder-item__el img-box">
								<?php if ($value == 'img'): ?>
									<img src="<?= setPath('img') ?>demo-img.jpg" alt=""
										class="folder-item__img img-size hover-scale mask-squircle">
								<?php elseif ($value == 'file'): ?>
									<div class="icon-file img-size hover-scale" style="--ext: 'txt';"></div>
								<?php else: ?>
									<svg class="icon img-size icon-folder hover-scale">
										<use xlink:href="#icon-folder"></use>
									</svg>
								<?php endif ?>
							</a>
							<div class="folder-item__text folder-item__el">
								<a href="#" class="folder-item__title text-truncate">script.js</a>
							</div>
							<div class="folder-item__action">
								<button class="btn btn-action btn-star btn-sm btn-icon">
									<svg class="icon icon-star">
										<use xlink:href="#icon-star-fill"></use>
									</svg>
								</button>
							</div>
						</div>
						<div class="folder-item__date-create fz-info hide-tablet">15.04.2023 11:30</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
<?php endif ?>