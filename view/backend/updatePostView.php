<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<h2>Billet:</h2>
<h4><?= strip_tags($post['title']) ?></h4>
<em>le <?= $post['creation_date_fr'] ?></em>
<p><?= nl2br($post['content']) ?></p>

<?php
	if (isset($_GET['update']) AND $_GET['update']!='')
	{
?>
		<h2>Modification du billet:</h2>
		
		<form action="index.php" method="POST">
			<p><label for="up_title">Titre du billet:</label></p>
			<p><input type="text" name="up_title" id="up_title" maxlength="255" size="50" value="<?= $post['title'] ?>" required autofocus/></p>
			<p><label for="up_content">Contenu du billet:</label></p>
	        <textarea name="up_content" id="up_content" required><?= $post['content'] ?></textarea>
	        <input type="hidden" name="id" value="<?= $post['id'] ?>">
	        <input type="submit" value="Modifier le billet"/>
		</form>
<?php
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>