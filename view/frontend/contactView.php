<?php session_start(); ?>

<?php $script = '<script src=\'https://www.google.com/recaptcha/api.js\'></script>'; ?>
<?php $title = 'Page de contact'; ?>

<?php ob_start(); ?>
<div class="container">
	<div class="text-center mt-5">
		<form class="form-contact" action="index.php" method="post">
			<h1 class="h3 mb-3 font-weight-normal">Contact</h1>
			<p><label for="subject">Sujet:</label><br/>
			<input class="form-control" type="text" name="subject" id="subject" maxlength="60" required autofocus/></p>
			<p><label for="email">Adresse e-mail:</label><br/>
			<input class="form-control" type="text" name="email" id="email" maxlength="255" required/></p>
			<p><label for="message">Message:</label><br/>
			<textarea class="form-control" name="message" id="message" placeholder="Limité à 255 caractères" maxlength="255" required></textarea></p>
			<div class="g-recaptcha mb-3" data-sitekey="6LfRh20UAAAAAECJ4QkzsCdxCJ3XbXWHRoKhVngm"></div>
		    <input class="btn btn-lg btn-primary btn-block mb-5" type="submit" value="Envoyer"/>
		</form>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>