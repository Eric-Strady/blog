<?php
	session_start();

?>

<!DOCTYPE html>
<html lang="fr">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <script src='https://www.google.com/recaptcha/api.js'></script>

	    <title>Page de connexion</title>

	</head>

	<body>

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
	    
		<form action="usersmanager.php" method="post">
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

	</body>
</html>