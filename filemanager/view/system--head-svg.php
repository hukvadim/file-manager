<?php
	defined('security') or die('Access denied'); // Add light protection against file access

	// To insert an svg icon:
	// <svg class="icon icon-search"><use xlink:href="#icon-search"></use></svg>
?>

<div hidden="hidden" class="null-svg-elements">
	<svg xmlns="http://www.w3.org/2000/svg">
		<symbol id="icon-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
		</symbol>
		<symbol id="icon-squares" viewBox="0 0 24 24">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				<rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"></rect>
				<rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
				<rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
				<rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
			</g>
		</symbol>
		


	</svg>
</div>

<svg class="icon icon-squares"><use xlink:href="#icon-squares"></use></svg>