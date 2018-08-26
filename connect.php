<!DOCTYPE html>
<html lang="fr">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <title>Page de connexion</title>

	</head>

	<body>
	    
		<form action="interfaceAdmin.php" method="post">
			<p><label for="pseudo">Pseudo:</label><br/>
			<input type="text" id="pseudo" name="pseudo" maxlength="255" required/></p>
			<p><label for="password">Mot de passe:</label><br/>
		    <input type="password" name="password" maxlength="255" required/></p>
		    <input type="submit" value="Se connecter"/>
		</form>

	</body>
</html>