<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<?php
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
 	{
?>
		<div class="container">
			<div id="transparency-post">
				<div class="row">
				    <div class="col-lg-12">

						<h1 id="post-title"><?= strip_tags($post['title']) ?></h1>

						<p>Posté le <?= $post['creation_date_fr'] ?></p>

						<hr>

						<img id="imagePost" class="img-fluid rounded" src="public/images/cover/<?= $post['id'] ?>.<?= $post['image_extension'] ?>" alt="<?= $post['image_description'] ?>" width="600" height="200"/>

						<hr>

						<p><?= nl2br($post['content']) ?></p>

					</div>
				</div>
			</div>
		</div>

<?php
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à aller sur cette page !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>