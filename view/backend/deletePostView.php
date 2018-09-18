<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<h2>Suppression du billet:</h2>

<p>Souhaitez-vous vraiment procéder à la suppression de ce billet ?</p>

<form action="index.php" method="POST">
	<p><input type="radio" name="delete" value="confirm" id="confirm" /> <label for="confirm">Oui</label></p>
    <p><input type="radio" name="delete" value="cancel" id="cancel" /> <label for="cancel">Non</label></p>
    <input type="hidden" name="id" value="<?= $_GET['delete'] ?>">
	<input type="submit" value="Confirmer"/>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>