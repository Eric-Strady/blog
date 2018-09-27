<?php $title = 'Réinitialiser son mot de passe'; ?>

<?php ob_start(); ?>

<h1>Réinitialiser son mot de passe</h1>

<p>Pour obtenir un nouveau mot de passe, vous devez renseigner l'adresse e-mail de votre compte pour recevoir un e-mail avec votre nouveau mot de passe.<br/>
Lors de votre reconnexion, nous vous conseillons de personnaliser votre nouveau mot de passe.</p>

<form action="index.php" method="post">
	<p><label for="new_password">Adresse e-mail:</label><br/>
	<input type="text" name="new_password" id="new_password" maxlength="255" size="30" required autofocus/></p>
    <input type="submit" value="Réinitialiser mon mot de passe"/>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>