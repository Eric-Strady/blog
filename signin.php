<!DOCTYPE html>
<html lang="fr">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <title>Page de connexion</title>

	</head>

	<body>

		<nav>
			<a href="index.php">Page d'accueil</a>
			<a href="registration.php">Inscription</a>
			<a href="signin.php">Connexion</a>
			<a href="signout.php">Déconnexion</a>
		</nav>
	    
		<form action="usersmanager.php" method="post">
			<p><label for="id_connect">Pseudo ou adresse e-mail:</label><br/>
			<input type="text" name="id_connect" id="id_connect" maxlength="255" size="30" required autofocus/></p>
			<p><label for="pass_connect">Mot de passe:</label><br/>
		    <input type="pass_connect" name="pass_connect" id="pass_connect" maxlength="255" size="30" required/></p>
		    <p><input type="checkbox" name="auto_connect" id="auto_connect" /> <label for="auto_connect">Se rappeler de moi</label></p>
		    <input type="submit" value="Se connecter"/>
		</form>

	</body>
</html>