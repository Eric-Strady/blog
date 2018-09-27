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

		<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="mainNav">
		    <div class="container">
		        <a class="navbar-brand" href="index.php">Jean Forteroche - Un billet pour l'Alaska</a>
		        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		        	<span class="navbar-toggler-icon"></span>
		        </button>
		        <div class="collapse navbar-collapse" id="navbarResponsive">
		            <ul class="navbar-nav ml-auto">
			            <li class="nav-item">
			              <a class="nav-link" href="index.php">Accueil</a>
			            </li>
			            <?php
							if (!isset($_SESSION['id']) AND !isset($_SESSION['pseudo']))
							{
						?>
			            		<li class="nav-item">
			              			<a class="nav-link" href="index.php?link=inscription">Inscription</a>
			            		</li>
			            		<li class="nav-item">
			              			<a class="nav-link" href="index.php?link=connexion">Connexion</a>
			            		</li>
			            <?php
			            	}
			            	elseif (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
							{
			        	?>
			        			<li class="nav-item">
			              			<a class="nav-link" href="index.php?link=admin">Retour à l'interface d'administration</a>
			            		</li>
			            		<li class="nav-item dropdown">
			              			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                			<?= $_SESSION['pseudo'] ?>
			              			</a>
			              			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
			                			<a class="dropdown-item" href="index.php?link=account">Mon profil</a>
			                			<a class="dropdown-item" href="index.php?link=deconnexion">Déconnexion</a>
			              			</div>
			            		</li>
			            <?php
			            	}
			            	else
			            	{
			            ?>
			            		<li class="nav-item dropdown">
			              			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                			<?= $_SESSION['pseudo'] ?>
			              			</a>
			              			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
			                			<a class="dropdown-item" href="index.php?link=account">Mon profil</a>
			                			<a class="dropdown-item" href="index.php?link=deconnexion">Déconnexion</a>
			              			</div>
			            		</li>
			            <?php
			            	}
			            ?>
		            </ul>
		        </div>
		    </div>
		</nav>

		<div class="container">
        	<?= $content ?>
        </div>

        <footer class="py-5 bg-dark">
	  		<div class="container">
	    		<p class="m-0 text-center text-white">Copyright &copy; Jean Forteroche 2018</p>
	  		</div>
		</footer>

    </body>
</html>