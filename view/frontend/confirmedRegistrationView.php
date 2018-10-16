<?php $title = 'Inscription finalisée'; ?>

<?php ob_start(); ?>

<div class="container">
	<div class="text-center mt-5">
		<h1 class="h3 mb-3 font-weight-normal">Inscription finalisée</h1>

		<div class="alert alert-success">
			<strong>Félicitation !</strong><br/>
			Votre inscription est désormais finalisée. Vous pouvez dès à présent vous <a href="index.php?link=connexion" title="Page de connexion" class="alert-link">connecter</a> ;)
		</div>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>