<?php
	defined('security') or die('Access denied'); // Add light protection against file access
?>

<footer class="footer border-top d-none d-lg-none d-md-block py-3">
	<div class="container text-center">
		<div class="dropdown">
			<button class="btn btn-action btn-sm btn-body-color btn-similar-y btn-options" type="button" data-bs-toggle="dropdown">
				<img src="<?=setPath('users')?>user.png" alt="" width="32" height="32" class="rounded-circle me-2">
				Налаштування робота
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
</footer>

<script>
	// Settings that will be passed to js
	const option = {
		path: '<?=__DIR__?>',
	}

	// Error from php
	let phpAnswer = '<?=($_SESSION['answer']) ? $_SESSION['answer'] : ''?>';
</script>

<script src="<?=setPath('libs')?>jquery/jquery-3.6.3.min.js"></script>
<script src="<?=setPath('libs')?>bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?=setPath('libs')?>mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script src="<?=setPath('js')?>script.js<?=addTmpView()?>"></script>

<?php if ($systemOption['page'] == 'examples'): ?>
	<script src="<?=setPath('js')?>examples.js"></script>
<?php endif ?>

<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
<?php unset($_SESSION['answer']); // Errors, we will output in an array $_SESSION['answer'] and it must be shown once  ?>
</body>
</html>