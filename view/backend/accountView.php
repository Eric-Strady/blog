<?php 
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
 	{
 		$title = 'Profil Administrateur';
 	}
	else
	{
	 	$title = 'Profil Utilisateur';
	}
?>

<?php ob_start(); ?>
<div class="container">
	<div class="row mt-4" id="pseudo_account">
		<p><?= $_SESSION['pseudo'] ?></p>
	</div>

	<div class="row mt-3" id="avatar">
		<img class="d-flex rounded-circle" src="https://www.gravatar.com/avatar/<?= md5(strtolower(trim($_SESSION['email']))) ?>?s=200&amp;d=retro&r=g" alt="Gravatar"/>
	</div>

	<div class="row mt-4" id="param">
		<h2 class="h3 mt-4 font-weight-normal">Paramètres de votre compte:</h2>
	</div>

	<div class="row mt-2">
		<?php
			if (isset($_GET['link'], $_GET['success']) AND $_GET['success']=='email')
			{
		?>
				<div class="alert alert-success" id="accountAlert">
					Votre e-mail a bien été modifié ! Un e-mail vous a été envoyé pour en attester.
				</div>
		<?php
			}
			elseif (isset($_GET['link'], $_GET['success']) AND $_GET['success']=='password')
			{
		?>
				<div class="alert alert-success" id="accountAlert">
					Votre mot de passe a bien été modifié !
				</div>
		<?php
			}
			elseif (isset($_GET['link'], $_GET['success']) AND $_GET['success']=='user_suppression')
			{
		?>
				<div class="alert alert-success" id="accountAlert">
					Le compte utilisateur a bien été supprimé !
				</div>
		<?php
			}
		?>
	</div>
</div>

<div class="container-fluid mt-3">
	<div class="row account">
		<div class="col-lg-2 col-sm-6 col-xs-12">
			<?php
				if (isset($_GET['form']) AND $_GET['form']=='pseudo')
				{
			?>
					<p><form action="index.php?link=account&amp;action=pseudo" method="POST">
						<fieldset>
							<legend>Changer de pseudo</legend>
							<p><label for="new_pseudo">Nouveau pseudo: </label>
							<input type="text" name="new_pseudo" id="new_pseudo" maxlength="255" required/></p>
							<p><label for="password">Merci de confirmer votre mot de passe: </label>
						    <input type="password" name="password" id="password" maxlength="255" required/></p>
						    <p><input class="btn btn-sm btn-outline-dark" type="submit" value="Soumettre"/></p>
						</fieldset>
					</form></p>
			<?php
				}
				else
				{
			?>
					<p><form action="#" method="POST">
				 		<button class="btn btn-lg btn-dark" type="submit" formaction="http://127.0.0.1/blog/index.php?link=account&amp;form=pseudo">Changer de pseudo</button>
					</form></p>
			<?php
				}
			?>
		</div>

		<div class="col-lg-2 col-sm-6 col-xs-12">
			<?php
				if (isset($_GET['form']) AND $_GET['form']=='email')
				{
			?>
					<p><form action="index.php?link=account&amp;action=email" method="POST">
						<fieldset>
							<legend>Changer d'adresse e-mail</legend>
							<p><label for="new_email">Nouvelle adresse e-mail: </label>
							<input type="text" name="new_email" id="new_email" maxlength="255" size="40" required/></p>
							<p><label for="password">Merci de confirmer votre mot de passe: </label>
						    <input type="password" name="password" id="password" maxlength="255" size="40" required/></p>
						    <p><input class="btn btn-sm btn-outline-dark" type="submit" value="Soumettre"/></p>
						</fieldset>
					</form></p>
			<?php
				}
				else
				{
			?>
					<p><form action="#" method="POST">
				 		<button class="btn btn-lg btn-dark" type="submit" formaction="http://127.0.0.1/blog/index.php?link=account&amp;form=email">Changer d'adresse e-mail</button>
					</form></p>
			<?php
				}
			?>
		</div>

		<div class="col-lg-2 col-sm-6 col-xs-12">
			<?php
				if (isset($_GET['form']) AND $_GET['form']=='password')
				{
			?>
					<p><form action="index.php?link=account&amp;action=password" method="POST">
						<fieldset>
							<legend>Changer de mot de passe</legend>
							<p><label for="old_password">Ancien mot de passe: </label>
							<input type="password" name="old_password" id="old_password" maxlength="255" size="40" required/></p>
							<p><label for="change_password">Nouveau mot de passe *: </label>
						    <input type="password" name="change_password" id="change_password" maxlength="255" size="40" required/></p>
						    <p><label for="confirm_change_password">Confirmez votre nouveau mot de passe: </label>
						    <input type="password" name="confirm_change_password" id="confirm_change_password" maxlength="255" size="40" required/></p>
						    <p><input class="btn btn-sm btn-outline-dark" type="submit" value="Soumettre"/></p>

						    <p>* Pour rappel, votre mot de passe doit:<br/>
						    <ul>
						    	<li>Utiliser au minimum 8 caractères</li>
						    	<li>Utiliser au minimum un chiffre et une lettre</li>
						    	<li>Utiliser au minimum une majuscule</li>
						    	<li>Utiliser au minimum un caractère spécial</li>
						    </ul></p>
						</fieldset>
					</form></p>
			<?php
				}
				else
				{
			?>
					<p><form action="#" method="POST">
				 		<button class="btn btn-lg btn-dark" type="submit" formaction="http://127.0.0.1/blog/index.php?link=account&amp;&form=password">Changer de mot de passe</button>
					</form></p>
			<?php
				}
			?>
		</div>

		<div class="col-lg-2 col-sm-6 col-xs-12">
			<?php
				if (isset($_GET['form']) AND $_GET['form']=='delete')
				{
			?>
					<p><form action="index.php?link=account&amp;action=delete" method="POST">
						<fieldset>
							<legend>Supprimer son compte</legend>
							<p><label for="password">Merci de confirmer votre mot de passe: </label>
						    <input type="password" name="password" id="password" maxlength="255" size="40" required/></p>
						    <p><input class="btn btn-sm btn-outline-danger" type="submit" value="Supprimer"/></p>
						</fieldset>
					</form></p>
			<?php
				}
				else
				{
			?>
					<p><form action="#" method="POST">
				 		<button class="btn btn-lg btn-dark mb-4" type="submit" formaction="http://127.0.0.1/blog/index.php?link=account&amp;form=delete">Supprimer son compte</button>
					</form></p>
			<?php
				}
			?>
		</div>
	</div>

	<?php
		if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
		{
			if (isset($_GET['form']) AND $_GET['form']=='delete_user')
			{
	?>			
				<div class="row account">
					<div class="col-lg-2 col-sm-6 col-xs-12">
						<p><form action="index.php?link=account&amp;action=delete_user" method="POST">
							<fieldset>
								<legend>Supprimer un utilisateur</legend>
								<p><label for="user_pseudo">Pseudo de l'utilisateur: </label>
								<input type="text" name="user_pseudo" id="user_pseudo" maxlength="255" size="40" required/></p>
								<p><label for="reasons_suppression">Motif de suppression:</label><br/>
								<textarea name="reasons_suppression" id="reasons_suppression" placeholder="Limité à 255 caractères" maxlength="255" required></textarea></p>
								<p><label for="password">Merci de confirmer votre mot de passe: </label>
							    <input type="password" name="password" id="password" maxlength="255" size="40" required/></p>
							    <p><input class="btn btn-sm btn-outline-danger" type="submit" value="Supprimer"/></p>
							</fieldset>
						</form></p>
					</div>
				</div>
	<?php
			}
			else
			{
	?>
				<div class="row account">
					<div class="col-lg-2 col-sm-6 col-xs-12">
						<p><form action="#" method="POST">
					 		<button class="btn btn-lg btn-dark" type="submit" formaction="http://127.0.0.1/blog/index.php?link=account&amp;form=delete_user">Supprimer un utilisateur</button>
						</form></p>
					</div>
				</div>
	<?php
			}
		}
	?>
</div>

<?php $content = ob_get_clean(); ?>

<?php 
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
	{
		require('view/backend/templateAdmin.php'); 
	}
	else
	{
		require('view/frontend/template.php');
	}
?>