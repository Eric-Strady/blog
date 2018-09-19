<?php session_start(); ?>

<?php $title = 'Page de connexion'; ?>

<?php ob_start(); ?>

<?php
	if (isset($_COOKIE['pseudo']))
	{
		echo '<p>Votre inscription a bien été prise en compte !<br/>';
		echo 'Un e-mail de confirmation vient de vous être envoyé. Merci de finaliser votre inscription avant de vous connecter :)</p>';
	}
?>

<form action="index.php" method="post">
	<p><label for="id_connect">Pseudo ou adresse e-mail:</label><br/>
	<input type="text" name="id_connect" id="id_connect" <?php if(isset($_COOKIE['pseudo'])){ echo 'value=' . $_COOKIE['pseudo'];}?> maxlength="255" size="30" required autofocus/></p>
	<p><label for="pass_connect">Mot de passe:</label><br/>
    <input type="password" name="pass_connect" id="pass_connect" maxlength="255" size="30" required/></p>
    <p><input type="checkbox" name="auto_connect" id="auto_connect" /> <label for="auto_connect">Se rappeler de moi (identifiant)</label></p>
    <p><a href="index.php?link=new_password">Mot de passe oublié</a></p>
    <input type="submit" value="Se connecter"/>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>