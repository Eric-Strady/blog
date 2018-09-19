<?php session_start(); ?>

<?php $title = 'Réinitialiser son mot de passe'; ?>

<?php ob_start(); ?>

<h1>Réinitialiser son mot de passe</h1>

<p>Pour obtenir un nouveau mot de passe, vous devez renseigner votre pseudo ou votre e-mail pour recevoir un e-mail avec votre nouveau mot de passe.<br/>
Lors de votre reconnexion, nous vous conseillons de personnaliser votre nouveau mot de passe.</p>

<form action="index.php" method="post">
	<p><label for="new_password">Pseudo ou adresse e-mail:</label><br/>
	<input type="text" name="new_password" id="new_password" <?php if(isset($_COOKIE['pseudo'])){ echo 'value=' . $_COOKIE['pseudo'];}?> maxlength="255" size="30" required autofocus/></p>
    <input type="submit" value="Envoyer"/>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>