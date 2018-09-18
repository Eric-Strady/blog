<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<?php
	while ($data = $req->fetch())
	{
?>

		<h4><?= strip_tags($data['title']) ?></h4>
		<em> le <?= $data['creation_date_fr'] ?></em>
		<em><a href="index.php?read=<?= $data['id'] ?>">Lire</a></em>
	     - <em><a href="index.php?update=<?= $data['id'] ?>">Mettre à jour</a></em>
	     - <em><a href="index.php?delete=<?= $data['id'] ?>">Supprimer</a></em></p>
	    <p><?= nl2br($data['content']) ?>

<?php
	}
	$req->closeCursor();

	echo '<p>Page: ';
	for ($i = 1; $i <= $nb_page; $i++)
	{
		echo '<a href="index.php?show=' . $i . '">' . $i . '</a> > ';
	}
	echo '</p>';
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>