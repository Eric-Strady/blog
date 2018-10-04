<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<?php
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
 	{
?>
		<h2>Billet:</h2>
		<h4><?= strip_tags($post['title']) ?></h4>
		<p>le <?= $post['creation_date_fr'] ?></p>
		<img class="img-fluid rounded" src="public/images/cover/<?= $post['id'] ?>.<?= $post['image_extension'] ?>" alt="<?= $post['image_description'] ?>" width="600" height="200"/>
		<p><?= nl2br($post['content']) ?></p>

		<?php
			if (isset($_GET['update']) AND $_GET['update']!='')
			{
		?>
				<h2>Changer l'image d'illustration</h2>

				<form action="index.php" method="POST" enctype="multipart/form-data">
					<p><label for="description">Description:</label><br/>
					<input type="text" name="description" id="description" placeholder="Maximum 30 caractères" maxlength="30" required/></p>
					<p><label for="image">Choisissez votre image (max 500Ko):</label><br/>
					<input type="file" name="image" id="image" required/></p>
					<input type="hidden" name="id" value="<?= $post['id'] ?>">
					<input type="submit" value="Modifier l'image"/>
				</form>
				
				<h2>Modification du billet:</h2>

				<form action="index.php" method="POST">
					<p><label for="up_title">Titre du billet:</label></p>
					<p><input type="text" name="up_title" id="up_title" maxlength="255" size="50" value="<?= $post['title'] ?>" required autofocus/></p>
					<p><label for="up_content">Contenu du billet:</label></p>
			        <p><textarea name="up_content" id="up_content" required><?= $post['content'] ?></textarea></p>
			        <input type="hidden" name="id" value="<?= $post['id'] ?>">
			        <input type="submit" value="Modifier le billet"/>
				</form>
		<?php
			}
		?>
<?php
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à aller sur cette page !<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>