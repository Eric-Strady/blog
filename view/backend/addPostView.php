<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

	<div class="container">
		<div id="transparency">
			<h3 id="post-title" class="mb-4">Création d'un billet:</h3>

			<form action="index.php?link=crud&action=create" method="POST" enctype="multipart/form-data">
				<fieldset>
					<legend>Image d'illustration</legend>
					<p><label for="description">Description:</label><br/>
					<input type="text" class="form-control" name="description" id="description" placeholder="Maximum 30 caractères" maxlength="30" required autofocus/></p>
					<p><label for="image">Choisissez votre image (max 500Ko):</label><br/>
					<input type="file" name="image" id="image" required/></p>
				</fieldset>
				<fieldset>
					<legend>Billet</legend>
					<p><label for="add_title">Titre du billet:</label></p>
					<p><input class="form-control" type="text" name="add_title" id="add_title" maxlength="255" size="50" placeholder="Ex: Episode ..." required/></p>
					<p><label for="add_content">Contenu du billet:</label></p>
				    <p><textarea class="form-control" name="add_content" id="add_content" required>Vous pouvez effectuer diverses actions syntaxiques (mise en gras, alignement, etc) à l'aide de cet éditeur de texte.</textarea></p>
				</fieldset>
			    <input type="submit" class="btn btn-primary" value="Ajouter ce billet"/>
			</form>
		</div>
	</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>