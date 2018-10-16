<?php $title = 'Demande de réinitialisation'; ?>

<?php ob_start(); ?>

<div class="container">
	<div class="text-center mt-5">
		<h1 class="h3 mb-3 font-weight-normal">Demande de réinitialisation</h1>

		<div class="alert alert-warning mt-3">
			Pour obtenir un nouveau mot de passe, vous devez renseigner l'adresse e-mail de votre compte pour recevoir un e-mail de réinitialisation.<br/>
			<strong>Attention, l'e-mail de réinitialisation sera valide durant 15 minutes.</strong>
		</div>

		<form id="form-reset" action="index.php?link=signin&amp;action=reset_password" method="post">
			<p><label for="email">Adresse e-mail:</label><br/>
			<input class="form-control" type="text" name="email" id="email" maxlength="255" size="30" required autofocus/></p>
		    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Réinitialiser mon mot de passe"/>
		</form>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>