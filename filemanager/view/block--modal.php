<?php
	defined('security') or die('Access denied'); // Add light protection against file access
?>

<!-- Модальне вікно для створення папки -->
<div class="modal modal-action modal-add-folder fade" id="modal-create-folder">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Створити папку</h3>
				<button type="button" class="btn-close btn btn-sm btn-icon btn-pr-bg btn-body-color" data-bs-dismiss="modal"><svg class='icon icon-close'><use href='#icon-close'></use></svg></button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="form-label">
						<div class="form-control-hold">
							<svg class='icon icon-folder'><use href='#icon-folder'></use></svg>
							<input type="text" class="form-control form-control-lg form-control-gray" placeholder="Введіть назву папки" id="form-control-new-folder" data-input-for-js="inputBehaviorBtnStatus" data-for-btn="#modal-btn-add-folder" data-time-offset="200">
						</div>
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-cancel btn-light" data-bs-dismiss="modal">Закрити</button>
				<button class="btn btn-add btn-primary" data-for-js="createFolder" id="modal-btn-add-folder" disabled>
					<svg class='icon icon-plus'><use href='#icon-plus-circle'></use></svg>
					Створити папку
				</button>
			</div>
			<div class="modal-footer modal-footer-detail">
				<a href="#" class="link-primary fz-14px" style="--bs-link-opacity: .55" data-bs-toggle="modal" data-bs-target="#modal-create-file">Створити файл</a>
			</div>
		</div>
	</div>
</div>


<!-- Модальне вікно для створення файлу -->
<div class="modal modal-action modal-add-folder fade" id="modal-create-file">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Створити файл</h3>
				<button type="button" class="btn-close btn btn-sm btn-icon btn-pr-bg btn-body-color" data-bs-dismiss="modal"><svg class='icon icon-close'><use href='#icon-close'></use></svg></button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="form-label">
						<div class="form-control-hold">
							<div class="icon icon-file icon-file--no-ext img-size"></div>
							<input type="text" class="form-control form-control-lg form-control-gray" placeholder="Введіть назву файлу" id="form-control-new-file" data-input-for-js="inputBehaviorBtnStatus" data-for-btn="#modal-btn-add-file" data-time-offset="200">
						</div>
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-cancel btn-light" data-bs-dismiss="modal">Закрити</button>
				<button class="btn btn-add btn-primary" data-for-js="createFile" id="modal-btn-add-file" disabled>
					<svg class='icon icon-plus'><use href='#icon-plus-circle'></use></svg>
					Створити файл
				</button>
			</div>
			<div class="modal-footer modal-footer-detail">
				<a href="#" class="link-primary fz-14px" style="--bs-link-opacity: .55" data-bs-toggle="modal" data-bs-target="#modal-create-folder">Створити папку</a>
			</div>
		</div>
	</div>
</div>