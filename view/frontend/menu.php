<nav>
	<ul>
		<li><a href="index.php?link=accueil">Page d'accueil</a></li>
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