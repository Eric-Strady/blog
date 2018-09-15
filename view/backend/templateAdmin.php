<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
        
    </head>
        
    <body>

    	<h1>Interface d'administration</h1>

		<nav>
			<ul>
				<li><a href="#">Ajouter un billet</a></li>
				<li><a href="#">Modérer les commentaires</a></li>
				<li><a href="index.php">Visualiser le site</a></li>
				<li><a href="#">Mon profil</a></li>
				<li><a href="index.php?link=deconnexion">Déconnexion</a></li>
			</ul>
		</nav>

        <?= $content ?>

    </body>
</html>