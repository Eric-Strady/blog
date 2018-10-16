<?php $title = 'Réinitialiser son mot de passe'; ?>

<?php ob_start(); ?>

<div class="container">
    <div class="text-center mt-5">
    	<h1 class="h3 mb-3 font-weight-normal">Réinitialiser son mot de passe</h1>

    	<p>Vous pouvez désormais choisir un nouveau mot de passe pour votre compte. Merci de respecter les règles de sécurité pour votre nouveau mot de passe.</p>

        <form id="form-new-pass" action="index.php?link=signin&amp;action=change_password" method="post">
        	<p><label for="reset_password">Nouveau mot de passe *:</label><br/>
            <input class="form-control" type="password" name="reset_password" id="reset_password" maxlength="255" size="30" required autofocus/></p>
            <p><label for="confirm_reset_password">Confirmez votre nouveau mot de passe:</label><br/>
            <input class="form-control" type="password" name="confirm_reset_password" id="confirm_reset_password" maxlength="255" size="30" required/></p>
            <input type="hidden" name="email" value="<?= $_COOKIE['email'] ?>"/>
            <input class="btn btn-lg btn-primary btn-block" type="submit" value="S'inscrire"/>
        </form>

        <p>* Pour rappel, la sécurisation de votre mot de passe, doit passer par ces différents points:<br/>
            <ul>
            	<li>Utiliser au minimum 8 caractères</li>
            	<li>Utiliser au minimum un chiffre et une lettre</li>
            	<li>Utiliser au minimum une majuscule</li>
            	<li>Utiliser au minimum un caractère spécial</li>
            </ul>
        </p>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>