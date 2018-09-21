<?php session_start(); ?>

<?php $title = 'Profil Administrateur'; ?>

<?php ob_start(); ?>

<h1>Profil Administrateur:</h1>

<p><?= $_SESSION['pseudo'] ?></p>

<img src="public/images/univers.jpg" alt="Avatar" title="Avatar <?= $_SESSION['pseudo'] ?>" height="200" width="300">

<h2>Paramètres de votre compte:</h2>

<form action="index.php" method="POST">
	<p><label for="new_pseudo">Changer mon pseudo:</label></p>
	<p><input type="text" name="new_pseudo" id="new_pseudo" maxlength="255" size="40" required/>
	<p><label for="password">Merci de confirmer votre mot de passe:</label><br/>
    <input type="password" name="password" id="password" maxlength="255" size="40" required/></p>
	<input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>">
    <input type="submit" value="Soumettre"/></p>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>