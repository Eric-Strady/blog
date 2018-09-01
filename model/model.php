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

	function getPost($postId)
	{
		$db = dbConnect();

		$req = $db->prepare('SELECT title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts WHERE id = :postId');
		$req->execute(array('postId' => $postId));
		$post = $req->fetch();

		return $post;
	}

	function getComments($postId)
	{
		$db = dbConnect();

		$comments = $db->prepare('
		SELECT author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y\') AS d_comment, DATE_FORMAT(comment_date, \'%Hh%imin%ss\') AS h_comment
		FROM comments 
		WHERE id_post = :postId 
		ORDER BY comment_date DESC
		');
		$comments->execute(array('postId' => $postId));

		return $comments;
	}

	function addComment($postId, $pseudo, $comment)
	{
		$db = dbConnect();

		strip_tags($pseudo);
		strip_tags($comment);

		$addComment = $db->prepare('INSERT INTO comments(id_post, author, comment, comment_date) VALUES (:id_post, :author, :comment, NOW())');
		$addComment->execute(array('id_post' => $postId, 'author' => $pseudo, 'comment' => $comment));

		$redirection = 'Location: http://127.0.0.1/blog/index.php?post=' . $postId;
		header($redirection);
	}