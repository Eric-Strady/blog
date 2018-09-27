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

		<!-- Scripts TinyMCE -->
        <script type="text/javascript" src='public/js/tinymce/tinymce.min.js'></script>
		<script type="text/javascript">
        	tinymce.init({
        		selector: '#add_content',
        		height: 500,
				theme: 'modern',
				plugins: 'preview searchreplace autolink image link pagebreak nonbreaking advlist lists textcolor wordcount imagetools contextmenu colorpicker help',
				block_formats: 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6',
				toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | image | removeformat'
        	});
		</script>
		<script type="text/javascript">
        	tinymce.init({
        		selector: '#up_content',
        		height: 500,
				theme: 'modern',
				plugins: 'preview searchreplace autolink image link pagebreak nonbreaking advlist lists textcolor wordcount imagetools contextmenu colorpicker help',
				block_formats: 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6',
				toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | image | removeformat'
        	});
		</script>

        <title><?= $title ?></title>
        
    </head>
        
    <body>

    	<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="mainNav">
		    <div class="container">
		        <a class="navbar-brand" href="index.php?link=admin">Interface d'administration</a>
		        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		        	<span class="navbar-toggler-icon"></span>
		        </button>
		        <div class="collapse navbar-collapse" id="navbarResponsive">
		            <ul class="navbar-nav ml-auto">
			            <li class="nav-item">
			            	<a class="nav-link" href="index.php?link=create">Ajouter un billet</a>
			            </li>
			            <li class="nav-item">
			            	<a class="nav-link" href="index.php?link=moderate">
			            		Modérer les commentaires</a><?php if ($nbWarning['nb_warning']!='0'){ echo' ( ' . $nbWarning['nb_warning'] . ' )'; } ?>
			            	</a>
			            </li>
			            <li class="nav-item">
			            	<a class="nav-link" href="index.php">Visualiser le site</a>
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