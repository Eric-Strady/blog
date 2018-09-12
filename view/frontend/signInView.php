<?php session_start(); ?>

<?php $title = 'Page de connexion'; ?>

<?php ob_start(); ?>

	<nav>
		<a href="index.php">Page d'accueil</a>
		<?php
			if (!isset($_SESSION['id']) AND !isset($_SESSION['pseudo']))
			{
				echo '<a href="registration.php">Inscription</a> ';
				echo '<a href="signInView.php">Connexion</a>';
			}
			else
			{
				echo '<a href="signout.php">Déconnexion</a>';
			}
		?>
	</nav>

	<?php
		if (isset($_COOKIE['pseudo']))
		{
			echo '<p>Votre inscription a bien été prise en compte ! Pour utiliser votre compte, veuillez vous connecter ci-dessous.</p>';
		}
	?>

	<form action="index.php" method="post">
		<p><label for="id_connect">Pseudo ou adresse e-mail:</label><br/>
		<input type="text" name="id_connect" id="id_connect" <?php if(isset($_COOKIE['pseudo'])){ echo 'value=' . $_COOKIE['pseudo'];}?> maxlength="255" size="30" required autofocus/></p>
		<p><label for="pass_connect">Mot de passe:</label><br/>
	    <input type="password" name="pass_connect" id="pass_connect" maxlength="255" size="30" required/></p>
	    <p><input type="checkbox" name="auto_connect" id="auto_connect" /> <label for="auto_connect">Se rappeler de moi</label></p>
	    <input type="submit" value="Se connecter"/>
	</form>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>