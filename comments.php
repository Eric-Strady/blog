<!DOCTYPE html>
<html lang="fr">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <title></title>

	</head>

	<body>
		<p><a href="index.php">Page d'accueil</a></p>

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

			$req = $db->prepare('SELECT author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE id_post = :postId ORDER BY comment_date');
			$req->execute(array('postId' => $_GET['post']));

			while ($data = $req->fetch())
			{
		?>

		<p><strong><?php echo strip_tags($data['author']);?></strong> le <?php echo $data['comment_date_fr'];?></p>
		<p><?php echo nl2br(strip_tags($data['comment']));?></p>
		
		<?php
			}
			$req->closeCursor();
		?>

	</body>
</html>
