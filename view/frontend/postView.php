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

				<hr>

		      	<?php
					if (!isset($_GET['comment']))
					{
				?>
						<p>
							<form action="index.php" method="POST">
								<button type="submit" class="btn btn-dark" formaction="http://127.0.0.1/blog/index.php?link=post&amp;action=read&amp;id=<?= $post->getId() ?>&comment=add">Ajouter un commentaire</button>
							</form>
						</p>
						<hr>
				<?php
					}
				?>

				<?php
					if (isset($_GET['comment']) AND $_GET['comment']=='add')
					{
						if (isset($_SESSION['id']) AND isset($_SESSION['pseudo']))
						{
				?>
							<div class="card my-4">
					        	<h5 class="card-header">Commentaire:</h5>
					        	<div class="card-body">
					          	<form action="index.php" method="POST">
							        <textarea class="form-control" name="comment" id="comment" placeholder="Max 255 caractères" maxlength="255" rows="3" required></textarea></p>
							        <input type="hidden" name="postId" value="<?= $_GET['post'] ?>">
							        <input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>">
							        <input type="hidden" name="email" value="<?= $_SESSION['email'] ?>">
							        <input type="submit" class="btn btn-dark mb-3" value="Envoyer le commentaire"/>
								</form>
					        	</div>
					      	</div>
					      	<hr>
				<?php
					    }
					    else
						{
				?>
							<div class="alert alert-danger">
								Vous devez être connecté(e) pour ajouter un commentaire !
							</div>
							<hr>
				<?php
						}
					}
				?>

		      	<div class="media mb-4">
					<div class="media-body">
		      	<?php
			      	foreach ($comments as $oneComment)
					{
				?>
						<img class="d-flex mr-3 rounded-circle" id="mini-avatar" src="https://www.gravatar.com/avatar/<?= md5(strtolower(trim($oneComment->getEmail()))) ?>?s=50&amp;d=retro" alt="Gravatar"/>
						<em>Le <?= $oneComment->getCommentDay() ?> à <?= $oneComment->getCommentHour() ?> - </em><strong class="mt-0"><?= $oneComment->getPseudo() ?></strong>
				<?php
						if (isset($_SESSION['pseudo']))
						{
							$sessionPseudo = $_SESSION['pseudo'];
							if ($comment['author']==$sessionPseudo)
							{	
				?>
								<a href="index.php?post=<?= $_GET['post'] ?>&amp;commentId=<?= $comment['id'] ?>" title="Modifier son commentaire"><span class="fas fa-pen-fancy fa-lg"></span></a>
				<?php
								if (isset($_GET['commentId']) AND $_GET['commentId']==$comment['id'])
								{
				?>
									<hr>
									<div class="card my-4">
										<div class="card-body">
											<form action="index.php" method="POST">
										        <textarea class="form-control" name="up_comment" id="up_comment" maxlength="255" rows="3" required><?= $comment['comment'] ?></textarea></p>
										        <input type="hidden" name="commentId" value="<?= $comment['id'] ?>">
										        <input type="hidden" name="id_post" value="<?= $comment['id_post'] ?>">
										        <input type="submit" class="btn btn-dark mb-3" value="Modifier le commentaire"/>
											</form>
										</div>
									</div>
				<?php
								}
							}
							else
							{
				?>
								<a href="index.php?warnedId=<?= $comment['id'] ?>&amp;informerId=<?= $_SESSION['id'] ?>" title="Signaler un commentaire"><span class="fas fa-exclamation-triangle fa-lg"></span></a>
				<?php
							}
						}
				?>
						<p><?= $oneComment->getComment() ?></p>
						<hr>
				<?php
					}
				?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>