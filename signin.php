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

		<?php
			if (isset($_GET['pseudo']) AND $_GET['pseudo']!='')
			{
				try
				{
					$db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
				}
				catch (Exception $e)
				{
					die('Erreur: ' . $e->getMessage());
				}

				$req = $db->prepare('SELECT pseudo FROM users WHERE pseudo = :pseudo');
				$req->execute(array('pseudo' => $_GET['pseudo']));
				$verifyPseudo = $req->fetch();

				if ($verifyPseudo)
				{
					$id = strip_tags($verifyPseudo['pseudo']);
					echo 'Votre inscription a bien été prise en compte ! Pour utiliser votre compte, veuillez vous connecter ci-dessous.';
				}
				else
				{
					echo 'Cet identifiant n\'est pas valide !';
				}
			}


		?>

		<form action="usersmanager.php" method="post">
			<p><label for="id_connect">Pseudo ou adresse e-mail:</label><br/>
			<input type="text" name="id_connect" id="id_connect" value="<?php echo $id?>" maxlength="255" size="30" required autofocus/></p>
			<p><label for="pass_connect">Mot de passe:</label><br/>
		    <input type="pass_connect" name="pass_connect" id="pass_connect" maxlength="255" size="30" required/></p>
		    <p><input type="checkbox" name="auto_connect" id="auto_connect" /> <label for="auto_connect">Se rappeler de moi</label></p>
		    <input type="submit" value="Se connecter"/>
		</form>

	</body>
</html>