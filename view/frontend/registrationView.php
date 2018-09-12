<?php session_start(); ?>
<?php $script = '<script src=\'https://www.google.com/recaptcha/api.js\'></script>'; ?>
<?php $title = 'Page de connexion'; ?>

<?php ob_start(); ?>
	
	<nav>
		<ul>
			<li><a href="index.php">Page d'accueil</a></li>
		<?php
			if (!isset($_SESSION['id']) AND !isset($_SESSION['pseudo']))
			{
				echo '<li><a href="index.php?link=inscription">Inscription</a></li>';
				echo '<li><a href="index.php?link=connexion">Connexion</a></li>';
			}
			else
			{
				echo '<li><a href="index.php?link=deconnexion">Déconnexion</a></li>';
			}
		?>
		</ul>
	</nav>

	<form action="index.php" method="post">
		<p><label for="pseudo">Votre pseudo:</label><br/>
		<input type="text" name="pseudo" id="pseudo" maxlength="255" size="30" required autofocus/></p>
		<p><label for="password">Votre mot de passe *:</label><br/>
	    <input type="password" name="password" id="password" maxlength="255" size="30" required/></p>
	    <p><label for="passwordVerify">Confirmez votre mot de passe:</label><br/>
	    <input type="password" name="passwordVerify" id="passwordVerify" maxlength="255" size="30" required/></p>
	    <p><label for="email">Votre adresse e-mail:</label><br/>
	    <input type="email" id="email" name="email" maxlength="255" size="30" required/></p>
	    <div class="g-recaptcha" data-sitekey="6LfRh20UAAAAAECJ4QkzsCdxCJ3XbXWHRoKhVngm"></div>
	    <input type="submit" value="S'inscrire"/>
	</form>

	<p>* Pour votre sécuriser votre mot de passe, vous devez:<br/>
	    <ul>
	    	<li>Utiliser au minimum 8 caractères</li>
	    	<li>Utiliser au minimum un chiffre et une lettre</li>
	    	<li>Utiliser au minimum une majuscule</li>
	    	<li>Utiliser au minimum un caractère spécial</li>
	    </ul>
	</p>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>