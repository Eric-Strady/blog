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
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à aller sur cette page !<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>