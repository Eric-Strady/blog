<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

	<div class="container">
		<div id="transparency-post">
			<div class="row">
			    <div class="col-lg-12">

					<h1 id="post-title"><?= $post->getTitle() ?></h1>

					<p>Posté le <?= $post->getCreationDate() ?></p>

					<hr>

					<img id="imagePost" class="img-fluid rounded" src="public/images/cover/<?= $post->getId() ?>.<?= $post->getImgExt() ?>" alt="<?= $post->getImgDesc() ?>" width="600" height="200"/>

					<hr>

					<p><?= nl2br($post->getContent()) ?></p>

				</div>
			</div>
		</div>
	</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>