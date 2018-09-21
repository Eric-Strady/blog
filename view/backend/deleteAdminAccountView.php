<?php session_start(); ?>

<?php $title = 'Suppression du compte'; ?>

<?php ob_start(); ?>

<h2>Suppression du compte administrateur:</h2>

<p>Souhaitez-vous vraiment procéder à la suppression de votre compte ?</p>

<form action="index.php" method="POST">
	<p><input type="radio" name="delete_account_admin" value="confirm" id="confirm" /> <label for="confirm">Oui</label></p>
    <p><input type="radio" name="delete_account_admin" value="cancel" id="cancel" /> <label for="cancel">Non</label></p>
    <input type="hidden" name="id" value="$_POST['pseudo']">
	<input type="submit" value="Confirmer"/>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>