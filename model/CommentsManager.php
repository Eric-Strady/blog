<?php
	namespace Eric\Blog\Model;
	require_once("model/Manager.php");

	class CommentsManager extends Manager
	{
		function getComments($postId)
		{
			$db = $this->dbConnect();

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
			$db = $this->dbConnect();

			strip_tags($pseudo);
			strip_tags($comment);

			$addComment = $db->prepare('INSERT INTO comments(id_post, author, comment, comment_date) VALUES (:id_post, :author, :comment, NOW())');
			$addComment->execute(array('id_post' => $postId, 'author' => $pseudo, 'comment' => $comment));

			$redirection = 'Location: http://127.0.0.1/blog/index.php?post=' . $postId;
			header($redirection);
		}
	}