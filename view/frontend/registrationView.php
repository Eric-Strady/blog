<?php $script = '<script src=\'https://www.google.com/recaptcha/api.js\'></script>'; ?>
<?php $title = 'Page d\'inscription'; ?>

<?php ob_start(); ?>
<div class="container">
    <div class="text-center mt-5">
        <form id="form-registration" action="index.php?link=registration&amp;action=register" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Inscription</h1>
        	<p><label for="pseudo">Votre pseudo:</label><br/>
        	<input class="form-control" type="text" name="pseudo" id="pseudo" maxlength="255" size="30" required autofocus/></p>
        	<p><label for="password">Votre mot de passe *:</label><br/>
            <input class="form-control" type="password" name="password" id="password" maxlength="255" size="30" required/></p>
            <p><label for="passwordVerify">Confirmez votre mot de passe:</label><br/>
            <input class="form-control" type="password" name="passwordVerify" id="passwordVerify" maxlength="255" size="30" required/></p>
            <p><label for="email">Votre adresse e-mail:</label><br/>
            <input class="form-control" type="email" id="email" name="email" maxlength="255" size="30" required/></p>
            <div class="g-recaptcha mb-3" data-sitekey="6LfRh20UAAAAAECJ4QkzsCdxCJ3XbXWHRoKhVngm"></div>
            <input class="btn btn-lg btn-primary btn-block" type="submit" value="S'inscrire"/>
        </form>
    </div>


    <p>* Pour sécuriser votre mot de passe, vous devez:<br/>
        <ul>
        	<li>Utiliser au minimum 8 caractères</li>
        	<li>Utiliser au minimum un chiffre et une lettre</li>
        	<li>Utiliser au minimum une majuscule</li>
        	<li>Utiliser au minimum un caractère spécial</li>
        </ul>
    </p>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>