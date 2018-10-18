<?php $script = '<script src=\'https://www.google.com/recaptcha/api.js\'></script>'; ?>
<?php $title = 'Page de contact'; ?>

<?php ob_start(); ?>

<?php
	if (isset($_GET['link'], $_GET['send']) AND $_GET['send']=='message')
	{
?>
		<div class="alert alert-success mt-5">
			Votre message a bien été envoyé ! :)<br/>
			Une réponse vous sera apportée dans les plus brefs délais.
		</div>
<?php
	}
?>

<div class="container">
	<div class="text-center mt-5">
		<form id="form-contact" action="index.php?link=contact&amp;action=message" method="post">
			<h1 class="h3 mb-3 font-weight-normal">Contact</h1>
			<p><label for="email">Votre adresse e-mail:</label><br/>
			<input class="form-control" type="text" name="email" id="email" maxlength="255" required/></p>
			<p><label for="subject">Sujet:</label><br/>
			<input class="form-control" type="text" name="subject" id="subject" placeholder="Limité à 60 caractères" maxlength="60" required autofocus/></p>
			<p><label for="message">Message:</label><br/>
			<textarea class="form-control" name="message" id="message" placeholder="Limité à 255 caractères" maxlength="255" required></textarea></p>
			<div class="g-recaptcha mb-3" data-sitekey="6LfRh20UAAAAAECJ4QkzsCdxCJ3XbXWHRoKhVngm"></div>
		    <input class="btn btn-lg btn-primary btn-block mb-5" type="submit" value="Envoyer"/>
		</form>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>