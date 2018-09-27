<?php $title = 'Suppression du compte'; ?>

<?php ob_start(); ?>

<?php
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
	{
		echo '<h2>Suppression du compte administrateur:</h2>';
	}
	else
	{
		echo '<h2>Suppression du compte utilisateur:</h2>';
	}
?>

<p>Souhaitez-vous vraiment procéder à la suppression de votre compte ?</p>

<form action="index.php" method="POST">
	<p><input type="radio" name="delete_account" value="confirm" id="confirm"/> <label for="confirm">Oui</label></p>
    <p><input type="radio" name="delete_account" value="cancel" id="cancel"/> <label for="cancel">Non</label></p>
    <input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>"/>
    <input type="hidden" name="id" value="<?= $_SESSION['id'] ?>"/>
	<input type="submit" value="Confirmer"/>
</form>

<?php $content = ob_get_clean(); ?>

<?php 
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
	{
		require('view/backend/templateAdmin.php'); 
	}
	else
	{
		require('view/frontend/template.php');
	}
?>