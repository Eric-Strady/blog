<!DOCTYPE html>
<html lang="fr">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <title></title>

	</head>

	<body>
		<nav>
			<a href="index.php">Page d'accueil</a>
			<a href="registration.php">Inscription</a>
			<a href="signin.php">Connexion</a>
			<a href="signout.php">Déconnexion</a>
		</nav>

		<?php
			try
			{
			    $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
			}
			catch(Exception $e)
			{
			    die('Erreur : '.$e->getMessage());
			}

			$req = $db->prepare('SELECT title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts WHERE id = :postId');
			$req->execute(array('postId' => $_GET['post']));
			$data = $req->fetch();

			if (!empty($data))
			{
		?>

				<h2>Billet:</h2>
				<h4><?php echo strip_tags($data['title']); ?></h4>
				<em>le <?php echo $data['creation_date_fr'];?></em>
				<p><?php echo nl2br(strip_tags($data['content']));?></p>
				<em><a href="comments.php?post=<?php echo $_GET['post'];?>&amp;comment=add">Ajouter un commentaire</a></em>

				<h2>Commentaires:</h2>

		<?php
			}
			else
			{
		?>

				<h2>Erreur:</h2>
				<p>Le billet auquel vous souhaitez accéder n'existe pas !</p>

		<?php
			}
			$req->closeCursor();

			if (isset($_GET['comment']) AND $_GET['comment']=='add')
			{
		?>

				<form action="addcomment.php" method="POST">
				<p><label for="pseudo">Pseudo: </label><br/>
				<input type="text" name="pseudo" id="pseudo" value="<?php if (isset($_COOKIE['pseudo'])) {echo $_COOKIE['pseudo'];} ?>" maxlength="255" required/></p>
		        <p><label for="comment">Commentaire: </label><br/>
		        <textarea name="comment" id="comment" placeholder="Max 255 caractères" maxlength="255" row="4" cols="40" required></textarea></p>
		        <input type="hidden" name="postId" value="<?php echo $_GET['post'];?>">
		        <input type="submit" value="Envoyer le commentaire"/>
				</form>
				
		<?php		
			}

			$req = $db->prepare('
			SELECT author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y\') AS d_comment, DATE_FORMAT(comment_date, \'%Hh%imin%ss\') AS h_comment
			FROM comments 
			WHERE id_post = :postId 
			ORDER BY comment_date DESC
			');
			$req->execute(array('postId' => $_GET['post']));

			while ($data = $req->fetch())
			{
				echo '<p><em>Le ' . $data['d_comment'] . ' à ' . $data['h_comment'] . '</em> - <strong>' .strip_tags($data['author']) . '</strong>: ' . strip_tags($data['comment']) . '</p>';
			}

			$req->closeCursor();

		?>

	</body>
</html>
