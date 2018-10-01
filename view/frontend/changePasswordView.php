<?php session_start(); ?>

<?php $title = 'Réinitialiser son mot de passe'; ?>

<?php ob_start(); ?>

<?php
	if (isset($_COOKIE['email']) AND $_COOKIE['email']!='')
	{
?>
		<div class="container">

			<h1>Réinitialiser son mot de passe</h1>

			<p>Vous pouvez désormais choisir un nouveau mot de passe pour votre compte. Merci de respecter les règles de sécurité pour votre nouveau mot de passe.</p>

		    <div class="text-center mt-5">
		        <form class="form-registration" action="index.php" method="post">
		        	<p><label for="reset_password">Nouveau mot de passe *:</label><br/>
		            <input class="form-control" type="password" name="reset_password" id="reset_password" maxlength="255" size="30" required autofocus/></p>
		            <p><label for="confirm_reset_password">Confirmez votre nouveau mot de passe:</label><br/>
		            <input class="form-control" type="password" name="confirm_reset_password" id="confirm_reset_password" maxlength="255" size="30" required/></p>
		            <input type="hidden" name="email" value="<?= $_COOKIE['email'] ?>"/>
		            <input class="btn btn-lg btn-primary btn-block" type="submit" value="S'inscrire"/>
		        </form>
		    </div>


		    <p>* Pour rappel, la sécurisation de votre mot de passe, doit passer par ces différents points:<br/>
		        <ul>
		        	<li>Utiliser au minimum 8 caractères</li>
		        	<li>Utiliser au minimum un chiffre et une lettre</li>
		        	<li>Utiliser au minimum une majuscule</li>
		        	<li>Utiliser au minimum un caractère spécial</li>
		        </ul>
		    </p>
		</div>
<?php
	}
	else
	{
		throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à la page de <a href="index.php?link=connexion">connexion</a></p>');
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>