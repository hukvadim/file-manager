<?php
	defined('security') or die('Access denied'); // Add light protection against file access
?>

<!-- Modal -->
<div class="modal modal-action modal-add-folder fade" id="modal-action">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Створити папку</h3>
				<button type="button" class="btn-close btn btn-sm btn-icon btn-pr-bg btn-body-color" data-bs-dismiss="modal"><svg class='icon icon-close'><use xlink:href='#icon-close'></use></svg></button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="form-label">
						<!-- <span class="form-label-text">Назва папки:</span> -->
						<div class="form-control-hold">
							<svg class='icon icon-folder'><use xlink:href='#icon-folder'></use></svg>
							<input type="text" class="form-control form-control-lg form-control-gray" placeholder="Введіть назву папки" id="form-control-new-folder" data-input-for-js="inputBehaviorBtnStatus" data-for-btn="#modal-btn-add-folder" data-time-offset="200">
						</div>
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-cancel btn-light" data-bs-dismiss="modal">Закрити</button>
				<button class="btn btn-add btn-primary" data-for-js="createFolder" id="modal-btn-add-folder" disabled>
					<svg class='icon icon-plus'><use xlink:href='#icon-plus-circle'></use></svg>
					Створити папку
				</button>
			</div>
		</div>
	</div>
</div>