<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
				elseif ($_SESSION['pseudo']=='Coxus' OR $_SESSION['pseudo']=='coxus@gmail.com')
				{
					echo '<li><a href="index.php?link=admin">Retour à l\'interface d\'administration</a></li>';
					echo '<li><a href="index.php?link=deconnexion">Déconnexion</a></li>';
				}
				else
				{
					echo '<li><a href="index.php?link=deconnexion">Déconnexion</a></li>';
				}
			?>
			</ul>
		</nav>

        <?= $content ?>

    </body>
</html>