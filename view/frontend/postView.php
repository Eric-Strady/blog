<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>
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

				<hr>

		      	<?php
					if (!isset($_GET['comment']))
					{
				?>
						<p>
							<form action="index.php" method="POST">
								<button type="submit" class="btn btn-dark" formaction="http://127.0.0.1/blog/index.php?post=<?= $_GET['post'] ?>&comment=add">Ajouter un commentaire</button>
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
			      	while ($comment = $comments->fetch())
					{
				?>
						<img class="d-flex mr-3 rounded-circle" id="mini-avatar" src="https://www.gravatar.com/avatar/<?= md5(strtolower(trim($comment['email']))) ?>?s=50&amp;d=retro" alt="Gravatar"/>
						<em>Le <?= $comment['d_comment'] ?> à <?= $comment['h_comment'] ?> - </em><strong class="mt-0"><?= strip_tags($comment['author']) ?></strong>
				<?php
						if (isset($_SESSION['pseudo']))
						{
							$sessionPseudo = $_SESSION['pseudo'];
							if ($comment['author']==$sessionPseudo)
							{	
				?>
								<a href="index.php?post=<?= $_GET['post'] ?>&amp;commentId=<?= $comment['id'] ?>"><span class="fas fa-pen-fancy"></span></a>
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
								<a href="index.php?warnedId=<?= $comment['id'] ?>&amp;informerId=<?= $_SESSION['id'] ?>"><span class="fas fa-exclamation-triangle"></span></a>
				<?php
							}
						}
				?>
						<p><?= strip_tags($comment['comment']) ?></p>
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