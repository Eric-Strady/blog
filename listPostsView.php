<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <title>Blog</title>

	</head>

	<body>

		<nav>
			<a href="index.php">Page d'accueil</a>
			<a href="registration.php">Inscription</a>
			<a href="signin.php">Connexion</a>
			<a href="signout.php">Déconnexion</a>
		</nav>
	    
	    <?php
			while ($data = $req->fetch())
			{
		?>

				<h4><?= strip_tags($data['title']) ?></h4>
				<em> le <?= $data['creation_date_fr'] ?></em>
			    <p><?= nl2br(strip_tags($data['content'])) ?></p>
			    <em><a href="comments.php?post=<?= $data['id'] ?>">Commentaires</a></em>

		<?php
			}
			$req->closeCursor();

			echo '<p>Page: ';
			for ($i = 1; $i <= $nb_page; $i++)
			{
				echo '<a href="index.php?page=' . $i . '">' . $i . '</a> > ';
			}
			echo '</p>';
		?>

	</body>
</html>