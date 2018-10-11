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

		<!-- Scripts TinyMCE -->
        <script type="text/javascript" src='public/js/tinymce/tinymce.min.js'></script>
		<script type="text/javascript">
        	tinymce.init({
        		selector: '#add_content',
        		height: 400,
				theme: 'modern',
				plugins: 'preview searchreplace autolink link pagebreak nonbreaking advlist lists textcolor wordcount contextmenu colorpicker help',
				block_formats: 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6',
				toolbar: 'formatselect | bold italic strikethrough forecolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat'
        	});
		</script>
		<script type="text/javascript">
        	tinymce.init({
        		selector: '#up_content',
        		height: 400,
				theme: 'modern',
				plugins: 'preview searchreplace autolink link pagebreak nonbreaking advlist lists textcolor wordcount contextmenu colorpicker help',
				block_formats: 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6',
				toolbar: 'formatselect | bold italic strikethrough forecolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat'
        	});
		</script>

        <title><?= $title ?></title>
        
    </head>
        
    <body>

    	<nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
		    <div class="container">
		        <a class="navbar-brand" href="index.php?link=admin" title="Page d'administration">Interface d'administration</a>
		        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		        	<span class="navbar-toggler-icon"></span>
		        </button>
		        <div class="collapse navbar-collapse" id="navbarResponsive">
		            <ul class="navbar-nav ml-auto">
			            <li class="nav-item">
			            	<a class="nav-link" href="index.php?link=create" title="Page de création">Ajouter un billet</a>
			            </li>
			            <li class="nav-item">
			            	<a class="nav-link" href="index.php?link=moderate" title="Page de modération">
			            		Modérer les commentaires <?php if ($nbWarning['nb_warning']!='0'){ echo'<span class="badge">' . $nbWarning['nb_warning'] . '</span>'; } ?>
			            	</a>
			            </li>
			            <li class="nav-item">
			            	<a class="nav-link" href="index.php" title="Page d'accueil">Visualiser le site</a>
			            </li>
			            <li class="nav-item dropdown">
			            	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAccount" title="Menu déroulant" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			            		<?= $_SESSION['pseudo'] ?>
			            	</a>
			            	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
				            	<a class="dropdown-item" href="index.php?link=account" title="Page de profil">Mon profil</a>
				            	<a class="dropdown-item" href="index.php?link=deconnexion" title="Lien de déconnexion">Déconnexion</a>
			            	</div>
			            </li>
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