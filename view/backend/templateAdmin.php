<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src='public/js/tinymce/tinymce.min.js'></script>
		<script type="text/javascript">
        	tinymce.init({
        		selector: '#up_content',
        		height: 500,
				theme: 'modern',
				plugins: 'preview searchreplace autolink image link pagebreak nonbreaking advlist lists textcolor wordcount imagetools contextmenu colorpicker help',
				block_formats: 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6',
				toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat'
        	});
		</script>

        <title><?= $title ?></title>
        
    </head>
        
    <body>

    	<h1><a href="index.php?link=admin">Interface d'administration</a></h1>

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