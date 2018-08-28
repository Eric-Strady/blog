<?php
	function dbConnect()
	{
		try
		{
		    $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
		}
		catch(Exception $e)
		{
		    die('Erreur : '.$e->getMessage());
		}
	}

	function countPosts()
	{
		$db = dbConnect();

		$req = $db->query('SELECT COUNT(*) AS nb_post FROM posts');

		return $req;
	}

	function getPosts($first_post, $max_nb_post)
	{
		$db = dbConnect();

		$req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY id DESC LIMIT ' . $first_post . ', ' . $max_nb_post);

		return $req;
	}



