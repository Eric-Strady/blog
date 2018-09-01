<?php
	function dbConnect()
	{
		try
		{
		    $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
		    return $db;
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

	function getPost($post)
	{
		$req = $db->prepare('SELECT title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts WHERE id = :postId');
		$req->execute(array('postId' => $post));
		$data = $req->fetch();

		return $data;
	}

	function getComments()
	{
		$req = $db->prepare('
		SELECT author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y\') AS d_comment, DATE_FORMAT(comment_date, \'%Hh%imin%ss\') AS h_comment
		FROM comments 
		WHERE id_post = :postId 
		ORDER BY comment_date DESC
		');
		$req->execute(array('postId' => $_GET['post']));
		
		return $req;
	}