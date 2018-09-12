<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

	<nav>
		<a href="index.php">Page d'accueil</a>
		<?php
			if (!isset($_SESSION['id']) AND !isset($_SESSION['pseudo']))
			{
				echo '<a href="registration.php">Inscription</a> ';
				echo '<a href="signin.php">Connexion</a>';
			}
			else
			{
				echo '<a href="signout.php">Déconnexion</a>';
			}
		?>
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
			<p><label for="pseudo">Pseudo: </label><br/>
			<input type="text" name="pseudo" id="pseudo" value="<?= $_SESSION['pseudo'] ?>" maxlength="255" required autofocus/></p>
	        <p><label for="comment">Commentaire: </label><br/>
	        <textarea name="comment" id="comment" placeholder="Max 255 caractères" maxlength="255" row="4" cols="40" required></textarea></p>
	        <input type="hidden" name="postId" value="<?= $_GET['post'] ?>">
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
