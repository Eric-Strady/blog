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

				<img id="imagePost" class="img-fluid rounded" src="public/images/header.jpg" alt="En-tête billet" width="600" height="200"/>

				<hr>

				<p><?= nl2br($post['content']) ?></p>

				<hr>

		      	<?php
					if (!isset($_GET['comment']))
					{
				?>
						<p>
							<form action="index.php" method="POST">
								<button type="submit" class="btn btn-primary" formaction="http://127.0.0.1/blog/index.php?post=<?= $_GET['post'] ?>&comment=add">Ajouter un commentaire</button>
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
							        <input type="submit" class="btn btn-primary" value="Envoyer le commentaire"/>
								</form>
					        	</div>
					      	</div>
					      	<hr>
				<?php
					    }
					    else
						{
				?>
							<h5>Vous devez être connecté(e) pour ajouter un commentaire !</h5>
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
						<img class="d-flex mr-3 rounded-circle" id="mini-avatar" src="public/images/header.jpg" alt="Avatar" width="50" height="50"/>
						<em>Le <?= $comment['d_comment'] ?> à <?= $comment['h_comment'] ?> - </em><strong class="mt-0"><?= strip_tags($comment['author']) ?></strong>
				<?php
						if (isset($_SESSION['pseudo']))
						{
							$sessionPseudo = $_SESSION['pseudo'];
							if ($comment['author']==$sessionPseudo)
							{	
				?>
								<em>( <a href="index.php?post=<?= $_GET['post'] ?>&amp;commentId=<?= $comment['id'] ?>">Modifier</a> )</em>
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
										        <input type="submit" class="btn btn-success" value="Modifier le commentaire"/>
											</form>
										</div>
									</div>
				<?php
								}
							}
							else
							{
				?>
								<em>( <a href="index.php?warnedId=<?= $comment['id'] ?>">Signaler</a> )</em>
				<?php
							}
						}
				?>
						<p><?= strip_tags($comment['comment']) ?></p>
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