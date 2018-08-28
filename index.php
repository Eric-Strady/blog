<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <title>Blog</title>

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

			$max_nb_post = 5;

			$req = $db->query('SELECT COUNT(*) AS nb_post FROM posts');
			$total_post = $req->fetch();
			$nb_post = $total_post['nb_post'];

			$nb_page = ceil($nb_post/$max_nb_post);

			if (isset($_GET['page']))
			{
				strip_tags($_GET['page']);
				$_GET['page'] = (int)$_GET['page'];
				$current_page = $_GET['page'];
				if ($current_page == 0)
				{
					$current_page = 1;
				}
				elseif ($current_page > $nb_page)
				{
					$current_page = $nb_page;
				}
			}
			else
			{
				$current_page = 1;
			}

			$first_post = ($current_page-1)*$max_nb_post;

			$req->closeCursor();

			$req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY id DESC LIMIT ' . $first_post . ', ' . $max_nb_post);
			while ($data = $req->fetch())
			{
		?>

				<h4><?php echo strip_tags($data['title']);?></h4>
				<em> le <?php echo $data['creation_date_fr'];?></em>
			    <p><?php echo nl2br(strip_tags($data['content']));?></p>
			    <em><a href="comments.php?post=<?php echo $data['id'];?>">Commentaires</a></em>

		<?php
			}

			echo '<p>Page: ';
			for ($i = 1; $i <= $nb_page; $i++)
			{
				echo '<a href="index.php?page=' . $i . '">' . $i . '</a> > ';
			}
			echo '</p>';
		?>

	</body>
</html>