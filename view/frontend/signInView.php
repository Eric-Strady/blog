<?php session_start(); ?>

<?php $title = 'Page de connexion'; ?>

<?php ob_start(); ?>
<div class="container">
	<?php
		if (isset($_COOKIE['pseudo']))
		{
			echo '<p>Votre inscription a bien été prise en compte !<br/>';
			echo 'Un e-mail de confirmation vient de vous être envoyé. Merci de finaliser votre inscription avant de vous connecter :)</p>';
		}
	?>

	<div class="text-center mt-5">
		<form class="form-signin" action="index.php" method="post">
			<h1 class="h3 mb-3 font-weight-normal">Connexion</h1>
			<p><label for="id_connect">Pseudo ou adresse e-mail:</label><br/>
			<input class="form-control" type="text" name="id_connect" id="id_connect"
			<?php
				if (isset($_COOKIE['pseudo'])){ echo 'value=' . $_COOKIE['pseudo'];} elseif (isset($_COOKIE['id_user'])){ echo 'value=' . $_COOKIE['id_user'];}
			?> 
			maxlength="255" required autofocus/></p>
			<p><label for="pass_connect">Mot de passe:</label><br/>
		    <input class="form-control" type="password" name="pass_connect" id="pass_connect" maxlength="255" required/></p>
		    <p><input type="checkbox" name="auto_connect" id="auto_connect" value="checked"/> <label for="auto_connect">Se rappeler de moi (identifiant)</label></p>
		    <p><a href="index.php?link=new_password">Mot de passe oublié</a></p>
		    <input class="btn btn-lg btn-primary btn-block mb-5" type="submit" value="Se connecter"/>
		</form>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>