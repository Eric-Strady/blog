<?php session_start(); ?>

<?php $title = 'Commentaire(s) signalé(s)'; ?>

<?php ob_start(); ?>

<h2>Commentaire(s) signalé(s):</h2>

<?php
	while ($comment = $listWarnedComments->fetch())
	{
?>
		<p><em>Le <?= $comment['d_warning'] ?> à <?= $comment['h_warning'] ?></em> - <strong><?= strip_tags($comment['author']) ?></strong>: ( <a href="index.php?eraseComment=<?= $comment['id_comment'] ?>&amp;eraseWarning=<?= $comment['id'] ?>">Supprimer</a> - <a href="index.php?conserve=<?= $comment['id'] ?>">Conserver</a> )<br/>
		<?= strip_tags($comment['comment'])?></p>
<?php
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>