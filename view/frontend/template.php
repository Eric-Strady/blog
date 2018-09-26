<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Style (Bootstrap) -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="public/css/style.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <?php if (isset($script)){echo $script;} ?>
        <title><?= $title ?></title>
        
    </head>
        
    <body>

    	<h1><a href="index.php">Jean Forteroche - Un billet pour l'Alaska</a></h1>

		<nav>
			<ul>
				<li><a href="index.php">Accueil</a></li>
			<?php
				if (!isset($_SESSION['id']) AND !isset($_SESSION['pseudo']))
				{
					echo '<li><a href="index.php?link=inscription">Inscription</a></li>';
					echo '<li><a href="index.php?link=connexion">Connexion</a></li>';
				}
				elseif (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
				{
					echo '<li><a href="index.php?link=admin">Retour à l\'interface d\'administration</a></li>';
					echo '<li><a href="index.php?link=deconnexion">Déconnexion</a></li>';
					echo '<li><a href="index.php?link=account"><img src="public/images/thumbnails/' . $_SESSION['id'] .'.png" alt="Avatar de ' . $_SESSION['pseudo'] .'"/> ' . $_SESSION['pseudo'] . '</a></li>';
				}
				else
				{
					echo '<li><a href="index.php?link=account">Mon profil</a></li>';
					echo '<li><a href="index.php?link=deconnexion">Déconnexion</a></li>';
					echo '<li><a href="index.php?link=account"><img src="public/images/thumbnails/' . $_SESSION['id'] .'.png" alt="Avatar de ' . $_SESSION['pseudo'] .'"/> ' . $_SESSION['pseudo'] . '</a></li>';
				}
			?>
			</ul>
		</nav>

        <?= $content ?>

    </body>
</html>