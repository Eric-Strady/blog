<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

	<div class="container">
		<div id="transparency">
			<h3 id="post-title" class="mb-4">Suppression du billet:</h3>

			<p>Souhaitez-vous vraiment procéder à la suppression de ce billet ?</p>

			<form action="index.php" method="POST">
				<p><input type="radio" name="delete" value="confirm" id="confirm" /> <label for="confirm">Oui</label></p>
			    <p><input type="radio" name="delete" value="cancel" id="cancel" /> <label for="cancel">Non</label></p>
			    <input type="hidden" name="id" value="<?= $_GET['delete'] ?>">
			    <input type="hidden" name="extension" value="<?= $_GET['pic'] ?>">
				<input class="btn btn-primary" type="submit" value="Confirmer"/>
			</form>
		</div>
	</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>