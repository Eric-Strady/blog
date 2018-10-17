<?php $title = 'Commentaire(s) signalé(s)'; ?>

<?php ob_start(); ?>

	<div class="container">
		<div id="transparency">
			<h3 id="post-title" class="mb-4">Commentaire(s) signalé(s):</h3>

			<?php
				if ($listWarnedComments === 0)
				{
			?>
					<div class="alert alert-secondary">
						Aucun commentaire signalé ! :)
					</div>
			<?php
				}
				else
				{
					while ($comment = $listWarnedComments->fetch())
					{
			?>
						<div class="card my-4">
							<h5 class="card-header">Signalé <?= $comment['nTimes'] ?> fois:</h5>
							<div class="card-body">
								<p><em>Le <?= $comment['d_warning'] ?> à <?= $comment['h_warning'] ?></em> - Commentaire de "<strong><?= strip_tags($comment['author']) ?></strong>" :
								<a href="index.php?eraseComment=<?= $comment['id_comment'] ?>&amp;eraseWarning=<?= $comment['id'] ?>" title="Supprimer le commentaire"><span class="fas fa-times fa-lg"></a>
								 - 
								<a href="index.php?conserve=<?= $comment['id_comment'] ?>" title="Conserver le commentaire"><span class="fas fa-check fa-lg"></a><br/>
								<?= strip_tags($comment['comment'])?></p>
							</div>
						</div>
			<?php
					}
				}
			?>
		</div>
	</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>