<?php $title = 'Suppression du compte'; ?>

<?php ob_start(); ?>

<?php
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
	{
?>
		<div class="container">
			<div id="transparency">
				<h3 id="post-title" class="mb-4">Suppression du compte administrateur:</h3>
<?php
	}
	else
	{
?>
		<div class="container">
			<div id="transparency">
				<h3 id="post-title" class="mb-4">Suppression du compte utilisateur:</h3>
<?php
	}
?>
				<p>Souhaitez-vous vraiment procéder à la suppression de votre compte ?</p>

				<form action="index.php?link=account&amp;action=delete_account" method="POST">
					<p><input type="radio" name="delete" value="confirm" id="confirm"/> <label for="confirm">Oui</label></p>
				    <p><input type="radio" name="delete" value="cancel" id="cancel"/> <label for="cancel">Non</label></p>
					<input class="btn btn-primary" type="submit" value="Confirmer"/>
				</form>
			</div>
		</div>

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