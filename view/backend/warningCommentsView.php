<?php $title = 'Commentaire(s) signalé(s)'; ?>

<?php ob_start(); ?>

	<div class="container">
		<div id="transparency">
			<h3 id="post-title" class="mb-4">Commentaire(s) signalé(s):</h3>

			<?php
				if (!$warningManager->count())
				{
			?>
					<div class="alert alert-secondary">
						Aucun commentaire signalé ! :)
					</div>
			<?php
				}
				else
				{
					foreach ($warning as $oneWarning)
					{
			?>
						<div class="card my-4">
							<h5 class="card-header">Signalé <?= $oneWarning->getNbTimes() ?> fois:</h5>
							<div class="card-body">
								<p><em>Le <?= $oneWarning->getWarningDay() ?> à <?= $oneWarning->getWarningHour() ?></em> - Commentaire de <strong><?= $oneWarning->getPseudo() ?></strong>:
								<a href="index.php?eraseComment=<?= $oneWarning->getId() ?>" title="Supprimer le commentaire"><span class="fas fa-times fa-lg"></a>
								 - 
								<a href="index.php?conserve=<?= $oneWarning->getPseudo() ?>" title="Conserver le commentaire"><span class="fas fa-check fa-lg"></a><br/>
								" <?= $oneWarning->getComment() ?> "</p>
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