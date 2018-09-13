<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

	<nav>
		<ul>
			<li><a href="index.php">Page d'accueil</a></li>
		<?php
			if (!isset($_SESSION['id']) AND !isset($_SESSION['pseudo']))
			{
				echo '<li><a href="index.php?link=inscription">Inscription</a></li>';
				echo '<li><a href="index.php?link=connexion">Connexion</a></li>';
			}
			else
			{
				echo '<li><a href="index.php?link=deconnexion">Déconnexion</a></li>';
			}
		?>
		</ul>
	</nav>

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
			echo '<p><em>Le ' . $comment['d_comment'] . ' à ' . $comment['h_comment'] . '</em> - <strong>' .strip_tags($comment['author']) . '</strong>: ' . strip_tags($comment['comment']) . '</p>';
		}
	?>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
