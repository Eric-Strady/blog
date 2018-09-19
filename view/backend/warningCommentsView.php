<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<h2>Création d'un billet:</h2>

<?php
	while ($comment = $listWarnedComments->fetch())
	{
?>
		<p><em>Le <?= $comment['d_warning'] ?> à <?= $comment['h_warning'] ?></em> - <strong><?= strip_tags($comment['author']) ?></strong>: ( <a href="index.php?eraseComment=<?= $comment['id_comment'] ?>&amp;eraceWarning=<?= $comment['id'] ?>">Supprimer</a> - <a href="index.php?conserve=<?= $comment['id'] ?>">Conserver</a> )<br/>
		<?= strip_tags($comment['comment'])?></p>
<?php
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>