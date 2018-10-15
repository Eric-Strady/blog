<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Style (Bootstrap + Font-Awesome) -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link rel="stylesheet" href="public/css/style.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <?php if (isset($script)){echo $script;} ?>
        <title><?= $title ?></title>
        
    </head>
        
    <body>

		<nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
		    <div class="container">
		        <a class="navbar-brand" href="index.php" title="Page d'accueil">Jean Forteroche<br/>
		        	<span id="slogan">Un billet pour l'Alaska</span>
		        </a>
		        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		        	<span class="navbar-toggler-icon"></span>
		        </button>
		        <div class="collapse navbar-collapse" id="navbarResponsive">
		            <ul class="navbar-nav ml-auto">
		            	
			            <li class="nav-item">
			              	<a class="nav-link" href="index.php" title="Page d\'accueil"><span class="fas fa-home"></span> Accueil</a>
			            </li>
			            <?php
							if (!isset($_SESSION['id']) AND !isset($_SESSION['pseudo']))
							{
						?>
			            		<li class="nav-item">
			              			<a class="nav-link" href="index.php?link=registration" title="Page d'inscription">Inscription</a>
			            		</li>
			            		<li class="nav-item">
			              			<a class="nav-link" href="index.php?link=signin" title="Page de connexion">Connexion</a>
			            		</li>
			            		<li class="nav-item">
			              			<a class="nav-link" href="index.php?link=contact" title="Page de contact">Contact</a>
			            		</li>
			            <?php
			            	}
			            	elseif (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
							{
			        	?>
			        			<li class="nav-item">
			              			<a class="nav-link" href="index.php?link=admin" title="Page d'administration">Retour à l'interface d'administration</a>
			            		</li>
			            		<li class="nav-item dropdown">
			              			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAccount" title="Menu déroulant" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                			<?= $_SESSION['pseudo'] ?>
			              			</a>
			              			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
			                			<a class="dropdown-item" href="index.php?link=account" title="Page de profil">Mon profil</a>
			                			<a class="dropdown-item" href="index.php?link=signout" title="Lien de déconnexion">Déconnexion</a>
			              			</div>
			            		</li>
			            <?php
			            	}
			            	else
			            	{
			            ?>
			            		<li class="nav-item">
			              			<a class="nav-link" href="index.php?link=contact" title="Page de contact">Contact</a>
			            		</li>
			            		<li class="nav-item dropdown">
			              			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAccount" title="Menu déroulant" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                			<?= $_SESSION['pseudo'] ?>
			              			</a>
			              			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
			                			<a class="dropdown-item" href="index.php?link=account" title="Page de profil">Mon profil</a>
			                			<a class="dropdown-item" href="index.php?link=signout" title="Lien de déconnexion">Déconnexion</a>
			              			</div>
			            		</li>
			            <?php
			            	}
			            ?>
		            </ul>
		        </div>
		    </div>
		</nav>

        <?= $content ?>

		<footer class="footer">
			<div class="container">
				<span class="text-muted">Copyright &copy; Jean Forteroche 2018</span>
			</div>
		</footer>

    </body>
</html>

