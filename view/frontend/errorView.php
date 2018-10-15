<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start() ?>

<div class="container" id="error">
	<h1 class="mt-4 mb-4">Erreur</h1>
	<div class="alert alert-danger">
		<?= $errorMessage ?>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require 'view/frontend/template.php'; ?>