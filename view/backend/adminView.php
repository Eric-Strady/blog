<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<?php
	while ($data = $req->fetch())
	{
?>

		<h4><?= strip_tags($data['title']) ?></h4>
		<em> le <?= $data['creation_date_fr'] ?></em>
	    <p><?= nl2br(strip_tags($data['content'])) ?>
	    <em><a href="index.php?admin=read">Lire</a></em> - <em><a href="index.php?admin=update">Mettre à jour</a></em> - <em><a href="index.php?admin=delete">Supprimer</a></em></p>

<?php
	}
	$req->closeCursor();

	echo '<p>Page: ';
	for ($i = 1; $i <= $nb_page; $i++)
	{
		echo '<a href="index.php?page=' . $i . '">' . $i . '</a> > ';
	}
	echo '</p>';
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>