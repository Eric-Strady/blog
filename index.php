<!DOCTYPE html>
<html lang="fr">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <title>Blog</title>

	</head>

	<body>
	    
		<?php
			try
			{
			    $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
			}
			catch(Exception $e)
			{
			        die('Erreur : '.$e->getMessage());
			}

			$req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY id DESC LIMIT 0, 5');
			while ($data = $req->fetch())
			{
		?>

			<h4><?php echo strip_tags($data['title']);?></h4>
			<em> le <?php echo $data['creation_date_fr'];?></em>
		    <p><?php echo nl2br(strip_tags($data['content']));?><br/>
		    <em><a href="comments.php?post=<?php echo $data['id']; ?>">Commentaires</a></em></p>

		<?php
			}
		?>

	</body>
</html>