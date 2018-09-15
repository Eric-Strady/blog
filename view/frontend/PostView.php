<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<h2>Billet:</h2>
<h4><?= strip_tags($post['title']) ?></h4>
<em>le <?= $post['creation_date_fr'] ?></em>
<p><?= nl2br(strip_tags($post['content'])) ?></p>
<em><a href="index.php?post=<?= $_GET['post'] ?>&amp;comment=add">Ajouter un commentaire</a></em>

<h2>Commentaires:</h2>

<?php
	if (isset($_GET['comment']) AND $_GET['comment']=='add')
	{
		if (isset($_SESSION['id']) AND isset($_SESSION['pseudo']))
		{
?>

		<form action="index.php" method="POST">
        <textarea name="comment" id="comment" placeholder="Max 255 caractères" maxlength="255" row="4" cols="40" required></textarea></p>
        <input type="hidden" name="postId" value="<?= $_GET['post'] ?>">
        <input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo'] ?>">
        <input type="submit" value="Envoyer le commentaire"/>
		</form>
		
<?php
		}
		else
		{
			throw new Exception('Vous devez être connecté(e) pour ajouter un commentaire !');
		}
	}

	while ($comment = $comments->fetch())
	{
		echo '<p><em>Le ' . $comment['d_comment'] . ' à ' . $comment['h_comment'] . '</em> - <strong>' . strip_tags($comment['author']) . '</strong>:';
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
					<form action="index.php" method="POST">
			        <textarea name="up_comment" id="up_comment" maxlength="255" row="4" cols="40" required><?= $comment['comment'] ?></textarea></p>
			        <input type="hidden" name="commentId" value="<?= $comment['id'] ?>">
			        <input type="hidden" name="id_post" value="<?= $comment['id_post'] ?>">
			        <input type="submit" value="Modifier le commentaire"/>
					</form>
<?php
				}
			}
		}
		echo '</br>' . strip_tags($comment['comment']) . '</p>';
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
