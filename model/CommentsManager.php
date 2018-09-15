<?php
	namespace Eric\Blog\Model;
	require_once("model/Manager.php");

	class CommentsManager extends Manager
	{
		public function getComments($postId)
		{
			$db = $this->dbConnect();

			$comments = $db->prepare('
			SELECT id, id_post, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y\') AS d_comment, DATE_FORMAT(comment_date, \'%Hh%imin%ss\') AS h_comment
			FROM comments 
			WHERE id_post = :postId 
			ORDER BY comment_date DESC
			');
			$comments->execute(array('postId' => $postId));

			return $comments;
		}

		public function addComment($postId, $pseudo, $comment)
		{
			$db = $this->dbConnect();

			strip_tags($comment);

			$addComment = $db->prepare('INSERT INTO comments(id_post, author, comment, comment_date) VALUES (:id_post, :author, :comment, NOW())');
			$addComment->execute(array('id_post' => $postId, 'author' => $pseudo, 'comment' => $comment));

			$path = 'Location: http://127.0.0.1/blog/index.php?post=' . $postId;
			header($path);
		}

		public function updateComment($comment, $commentId, $id_post)
		{
			$db = $this->dbConnect();

			$updateComment = $db->prepare('UPDATE comments SET comment = :comment, comment_date = NOW() WHERE id = :commentId');
			$updateComment->execute(array('comment' => $comment, 'commentId' => $commentId));

			$path = 'Location: http://127.0.0.1/blog/index.php?post=' . $id_post;
			header($path);
		}
	}