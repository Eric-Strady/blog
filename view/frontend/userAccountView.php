<?php session_start(); ?>

<?php $title = 'Profil Utilisateur'; ?>

<?php ob_start(); ?>

<h1>Profil Utilisateur:</h1>

<p><?= $_SESSION['pseudo'] ?></p>

<img src="public/images/univers.jpg" alt="Avatar" title="Avatar <?= $_SESSION['pseudo'] ?>" height="200" width="300">

<h2>Paramètres de votre compte:</h2>

<?php

	if (isset($_GET['link'], $_GET['success']) AND $_GET['success']=='email')
	{
		echo '<p>Votre e-mail a bien été modifié !<br/>';
		echo 'Un e-mail vous a été envoyé pour en attester.</p>';
	}
	elseif (isset($_GET['link'], $_GET['success']) AND $_GET['success']=='password')
	{
		echo '<p>Votre mot de passe a bien été modifié !</p>';
	}
?>

<?php
	if (isset($_GET['form']) AND $_GET['form']=='pseudo')
	{
?>
		<p><form action="index.php" method="POST">
			<fieldset>
				<legend>Changer de pseudo</legend>
				<p><label for="new_pseudo_user">Nouveau pseudo: </label>
				<input type="text" name="new_pseudo_user" id="new_pseudo_user" maxlength="255" size="40" required/></p>
				<p><label for="password">Merci de confirmer votre mot de passe: </label>
			    <input type="password" name="password" id="password" maxlength="255" size="40" required/></p>
				<input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>">
			    <p><input type="submit" value="Soumettre"/></p>
			</fieldset>
		</form></p>
<?php
	}
	else
	{
?>
		<p><form action="index.php" method="POST">
	 		<button type="submit" formaction="http://127.0.0.1/blog/index.php?link=user_account&form=pseudo">Changer de pseudo</button>
		</form></p>
<?php
	}
?>

<?php
	if (isset($_GET['form']) AND $_GET['form']=='email')
	{
?>
		<p><form action="index.php" method="POST">
			<fieldset>
				<legend>Changer d'adresse e-mail</legend>
				<p><label for="new_email_user">Nouvelle adresse e-mail: </label>
				<input type="text" name="new_email_user" id="new_email_user" maxlength="255" size="40" required/></p>
				<p><label for="password">Merci de confirmer votre mot de passe: </label>
			    <input type="password" name="password" id="password" maxlength="255" size="40" required/></p>
				<input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>">
			    <p><input type="submit" value="Soumettre"/></p>
			</fieldset>
		</form></p>
<?php
	}
	else
	{
?>
		<p><form action="index.php" method="POST">
	 		<button type="submit" formaction="http://127.0.0.1/blog/index.php?link=user_account&form=email">Changer d'adresse e-mail</button>
		</form></p>
<?php
	}
?>

<?php
	if (isset($_GET['form']) AND $_GET['form']=='password')
	{
?>
		<p><form action="index.php" method="POST">
			<fieldset>
				<legend>Changer de mot de passe</legend>
				<p><label for="old_password_user">Ancien mot de passe: </label>
				<input type="password" name="old_password_user" id="old_password_user" maxlength="255" size="40" required/></p>
				<p><label for="change_password">Nouveau mot de passe *: </label>
			    <input type="password" name="change_password" id="change_password" maxlength="255" size="40" required/></p>
			    <p><label for="confirm_change_password">Confirmez votre nouveau mot de passe: </label>
			    <input type="password" name="confirm_change_password" id="confirm_change_password" maxlength="255" size="40" required/></p>
				<input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>">
			    <p><input type="submit" value="Soumettre"/></p>

			    <p>* Pour rappel, votre mot de passe doit:<br/>
			    <ul>
			    	<li>Utiliser au minimum 8 caractères</li>
			    	<li>Utiliser au minimum un chiffre et une lettre</li>
			    	<li>Utiliser au minimum une majuscule</li>
			    	<li>Utiliser au minimum un caractère spécial</li>
			    </ul></p>
			</fieldset>
		</form></p>
<?php
	}
	else
	{
?>
		<p><form action="index.php" method="POST">
	 		<button type="submit" formaction="http://127.0.0.1/blog/index.php?link=user_account&form=password">Changer de mot de passe</button>
		</form></p>
<?php
	}
?>

<?php
	if (isset($_GET['form']) AND $_GET['form']=='delete')
	{
?>
		<p><form action="index.php" method="POST">
			<fieldset>
				<legend>Supprimer son compte</legend>
				<p><label for="password_user">Merci de confirmer votre mot de passe: </label>
			    <input type="password" name="password_user" id="password_user" maxlength="255" size="40" required/></p>
				<input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>">
			    <p><input type="submit" value="Supprimer"/></p>
			</fieldset>
		</form></p>
<?php
	}
	else
	{
?>
		<p><form action="index.php" method="POST">
	 		<button type="submit" formaction="http://127.0.0.1/blog/index.php?link=user_account&form=delete">Supprimer son compte</button>
		</form></p>
<?php
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>