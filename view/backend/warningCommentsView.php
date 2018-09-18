<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<h2>Création d'un billet:</h2>

<?php
	while ($comment = $listWarnedComments->fetch())
	{
		echo '<p><em>Le ' . $comment['d_warning'] . ' à ' . $comment['h_warning'] . '</em> - <strong>' . strip_tags($comment['author']) . '</strong>:';
		echo '</br>' . strip_tags($comment['comment']) . '</p>';
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>