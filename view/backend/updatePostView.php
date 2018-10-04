<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<?php
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
 	{
?>
		<div class="container">
			<div id="transparency">
				<h3 id="post-title" class="mb-4">Changer l'image d'illustration</h3>

				<form class="mb-5" action="index.php" method="POST" enctype="multipart/form-data">
					<p><label for="description">Description:</label><br/>
					<input type="text" class="form-control" name="description" id="description" placeholder="Maximum 30 caractères" maxlength="30" required/></p>
					<p><label for="image">Choisissez votre image (max 500Ko):</label><br/>
					<input type="file" name="image" id="image" required/></p>
					<input type="hidden" name="id" value="<?= $post['id'] ?>">
					<input type="submit" class="btn btn-primary" value="Modifier l'image"/>
				</form>
				
				<h3 id="post-title" class="mb-5">Modification du billet:</h3>

				<form action="index.php" method="POST">
					<p><label for="up_title">Titre du billet:</label></p>
					<p><input type="text" class="form-control" name="up_title" id="up_title" maxlength="255" size="50" value="<?= $post['title'] ?>" required/></p>
					<p><label for="up_content">Contenu du billet:</label></p>
			        <p><textarea name="up_content" id="up_content" required><?= $post['content'] ?></textarea></p>
			        <input type="hidden" name="id" value="<?= $post['id'] ?>">
			        <input type="submit" class="btn btn-primary" value="Modifier le billet"/>
				</form>
			</div>
		</div>
		
<?php
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à aller sur cette page !<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>