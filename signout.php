<?php
	session_start();

	if (isset($_SESSION['id']) AND isset($_SESSION['pseudo']))
	{
		$_SESSION = array();

		session_destroy();

		header('Location: index.php');
	}
	else
	{
?>

	<!DOCTYPE html>
	<html lang="fr">
		<head>
		    <meta charset="utf-8">
		    <meta name="viewport" content="width=device-width, initial-scale=1.0">

		    <title>Page de déconnexion</title>

		</head>

		<body>

			<nav>
				<a href="index.php">Page d'accueil</a>
				<?php
					if (!isset($_SESSION['id']) AND !isset($_SESSION['pseudo']))
					{
						echo '<a href="registration.php">Inscription</a> ';
						echo '<a href="signin.php">Connexion</a>';
					}
					else
					{
						echo '<a href="signout.php">Déconnexion</a>';
					}
				?>
			</nav>

			<p>Pour être déconnecté, il faudrait d'abord se <a href="signin.php">connecter</a> ;)</p>

		</body>
	</html>
	
<?php
	}
?>