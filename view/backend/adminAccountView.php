<?php session_start(); ?>

<?php $title = 'Profil Administrateur'; ?>

<?php ob_start(); ?>

<h1>Profil Administrateur:</h1>

<p><?= $_SESSION['pseudo'] ?></p>

<img src="public/images/univers.jpg" alt="Avatar" title="Avatar <?= $_SESSION['pseudo'] ?>" height="200" width="300">

<h2>Paramètres de votre compte:</h2>

<p><form action="index.php" method="POST">
	<fieldset>
		<legend>Changer de pseudo</legend>
		<p><label for="new_pseudo">Nouveau pseudo: </label>
		<input type="text" name="new_pseudo" id="new_pseudo" maxlength="255" size="40" required/></p>
		<p><label for="password"> Merci de confirmer votre mot de passe: </label>
	    <input type="password" name="password" id="password" maxlength="255" size="40" required/></p>
		<input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>">
	    <input type="submit" value="Soumettre"/></p>
	</fieldset>
</form></p>

<p><form action="index.php" method="POST">
	<fieldset>
		<legend>Changer d'adresse e-mail</legend>
		<p><label for="new_email">Nouvelle adresse e-mail: </label>
		<input type="text" name="new_email" id="new_email" maxlength="255" size="40" required/></p>
		<p><label for="password"> Merci de confirmer votre mot de passe: </label>
	    <input type="password" name="password" id="password" maxlength="255" size="40" required/></p>
		<input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>">
	    <input type="submit" value="Soumettre"/></p>
	</fieldset>
</form></p>

<p><form action="index.php" method="POST">
	<fieldset>
		<legend>Changer de mot de passe</legend>
		<p><label for="old_password">Ancien mot de passe: </label>
		<input type="password" name="old_password" id="old_password" maxlength="255" size="40" required/></p>
		<p><label for="new_password"> Nouveau mot de passe: </label>
	    <input type="password" name="new_password" id="new_password" maxlength="255" size="40" required/></p>
	    <p><label for="confirm_new_password"> Nouveau mot de passe: </label>
	    <input type="password" name="confirm_new_password" id="confirm_new_password" maxlength="255" size="40" required/></p>
		<input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>">
	    <input type="submit" value="Soumettre"/></p>
	</fieldset>
</form></p>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>