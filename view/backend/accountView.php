<?php session_start(); ?>

<?php 
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
 	{
 		$title = 'Profil Administrateur';
 	}
	else
	{
	 	$title = 'Profil Utilisateur';
	}
?>

<?php ob_start(); ?>

<?php
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
 	{
 		echo '<h1>Profil Administrateur:</h1>';
 	}
	else
	{
	 	echo '<h1>Profil Utilisateur:</h1>';
	}
?>

<p><?= $_SESSION['pseudo'] ?></p>

<img src="public/images/avatars/<?= $_SESSION['id'] ?>.png" alt="Avatar" title="Avatar de <?= $_SESSION['pseudo'] ?>" height="200" width="300"/>

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
	elseif (isset($_GET['link'], $_GET['success']) AND $_GET['success']=='user_suppression')
	{
		echo '<p>Le compte utilisateur a bien été supprimé !</p>';
	}
?>

<?php
	if (isset($_GET['form']) AND $_GET['form']=='pseudo')
	{
?>
		<p><form action="index.php" method="POST">
			<fieldset>
				<legend>Changer de pseudo</legend>
				<p><label for="new_pseudo">Nouveau pseudo: </label>
				<input type="text" name="new_pseudo" id="new_pseudo" maxlength="255" size="40" required/></p>
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
	 		<button type="submit" formaction="http://127.0.0.1/blog/index.php?link=account&form=pseudo">Changer de pseudo</button>
		</form></p>
<?php
	}
?>

<?php
	if (isset($_GET['form']) AND $_GET['form']=='avatar')
	{
?>
		<p><form action="index.php" method="POST" enctype="multipart/form-data">
			<fieldset>
				<legend>Changer d'avatar</legend>
				<p><label for="avatar">Sélectionner une image au format "png" (max 200Ko):</label></p>
				<p><input type="file" name="avatar" required/></p>
				<input type="hidden" name="id" value="<?= $_SESSION['id'] ?>"/>
			    <p><input type="submit" value="Soumettre"/></p>
			</fieldset>
		</form></p>
<?php
	}
	else
	{
?>
		<p><form action="index.php" method="POST">
	 		<button type="submit" formaction="http://127.0.0.1/blog/index.php?link=account&form=avatar">Changer d'avatar</button>
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
				<p><label for="new_email">Nouvelle adresse e-mail: </label>
				<input type="text" name="new_email" id="new_email" maxlength="255" size="40" required/></p>
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
	 		<button type="submit" formaction="http://127.0.0.1/blog/index.php?link=account&form=email">Changer d'adresse e-mail</button>
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
				<p><label for="old_password">Ancien mot de passe: </label>
				<input type="password" name="old_password" id="old_password" maxlength="255" size="40" required/></p>
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
	 		<button type="submit" formaction="http://127.0.0.1/blog/index.php?link=account&form=password">Changer de mot de passe</button>
		</form></p>
<?php
	}
?>

<?php
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
	{
		if (isset($_GET['form']) AND $_GET['form']=='delete_user')
		{
?>
			<p><form action="index.php" method="POST">
				<fieldset>
					<legend>Supprimer un compte utilisateur</legend>
					<p><label for="user_pseudo">Pseudo de l'utilisateur: </label>
					<input type="text" name="user_pseudo" id="user_pseudo" maxlength="255" size="40" required/></p>
					<p><label for="reasons_suppression">Motif de suppression:</label><br/>
					<textarea name="reasons_suppression" id="reasons_suppression" placeholder="Limité à 255 caractères" maxlength="255" row="4" cols="40" required></textarea>
					<p><label for="password">Merci de confirmer votre mot de passe: </label>
				    <input type="password" name="password" id="password" maxlength="255" size="40" required/></p>
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
		 		<button type="submit" formaction="http://127.0.0.1/blog/index.php?link=account&form=delete_user">Supprimer un compte utilisateur</button>
			</form></p>
<?php
		}
	}
?>

<?php
	if (isset($_GET['form']) AND $_GET['form']=='delete')
	{
?>
		<p><form action="index.php" method="POST">
			<fieldset>
				<legend>Supprimer son compte</legend>
				<p><label for="password">Merci de confirmer votre mot de passe: </label>
			    <input type="password" name="password" id="password" maxlength="255" size="40" required/></p>
				<input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>"/>
			    <p><input type="submit" value="Supprimer"/></p>
			</fieldset>
		</form></p>
<?php
	}
	else
	{
?>
		<p><form action="index.php" method="POST">
	 		<button type="submit" formaction="http://127.0.0.1/blog/index.php?link=account&form=delete">Supprimer son compte</button>
		</form></p>
<?php
	}
?>

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