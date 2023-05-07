<?php
	defined('security') or die('Access denied'); // Add light protection against file access
?>

<nav class="navbase bg-light">
	<div class="container-fluid">
		<div class="navbase__wrap d-flex-sides">
			<div class="navbase__left navbase__box-item">
				<a href="#" class="btn btn-link logo-link">
					<img src="<?=setPath('img')?>logo.svg" alt="" class="logo">
				</a>
			</div>
			<div class="navbase__middle navbase__box-item">
				<form class="navbase__search w-100">
					<input type="search" class="form-control" placeholder="Шукати...">
				</form>
			</div>
			<div class="navbase__right navbase__box-item d-md-none d-lg-flex">
				<div class="dropdown">
					<button class="btn btn-action btn-sm btn-similar-y dropdown-toggle btn-options" type="button" data-bs-toggle="dropdown">
						<img src="<?=setPath('users')?>user.png" alt="" width="32" height="32" class="rounded-circle">
					</button>
					<ul class="dropdown-menu">
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
		</div>
		
	</div>
</nav>