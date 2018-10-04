<?php session_start(); ?>

<?php $title = 'Réinitialiser son mot de passe'; ?>

<?php ob_start(); ?>

<div class="container">
	<div class="text-center mt-5">
		<h1 class="h3 mb-3 font-weight-normal">Réinitialiser son mot de passe</h1>

		<p>Pour obtenir un nouveau mot de passe, vous devez renseigner l'adresse e-mail de votre compte pour recevoir un e-mail avec votre nouveau mot de passe.<br/>
		Attention ! L'e-mail de réinitialisation sera valide durant 15 minutes.</p>

		<form id="form-reset" action="index.php" method="post">
			<p><label for="get_email">Adresse e-mail:</label><br/>
			<input class="form-control" type="text" name="get_email" id="get_email" maxlength="255" size="30" required autofocus/></p>
		    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Réinitialiser mon mot de passe"/>
		</form>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>