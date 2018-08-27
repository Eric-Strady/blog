<?php

	if (isset($_POST['pseudo']) AND isset($_POST['comment']))
	{
		if ($_POST['pseudo']!='' AND $_POST['comment']!='')
		{
			try
			{
				$db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
			}
			catch (Exception $e)
			{
				die('Erreur: ' . $e->getMessage());
			}

			strip_tags($_POST['pseudo']);
			strip_tags($_POST['comment']);

			$addComment = $db->prepare('INSERT INTO comments(id_post, author, comment, comment_date) VALUES (:id_post, :author, :comment, NOW())');
			$addComment->execute(array('id_post' => $_POST['postId'], 'author' => $_POST['pseudo'], 'comment' => $_POST['comment']));

			setcookie('pseudo', $_POST['pseudo'], time()+10*24*3600, null, null, false, true);
			$redirection = 'Location: http://127.0.0.1/blog/comments.php?post=' . $_POST['postId'];
			header($redirection);
		}
	}