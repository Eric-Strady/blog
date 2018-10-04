<?php
	namespace Eric\Blog\Model\Comments;
	require_once("model/Manager.php");

	class CommentsManager extends \Eric\Blog\Model\Manager
	{
		public function getComments($postId)
		{
			$db = $this->dbConnect();

			$comments = $db->prepare('
			SELECT id, id_post, author, email, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y\') AS d_comment, DATE_FORMAT(comment_date, \'%Hh%imin%ss\') AS h_comment
			FROM comments 
			WHERE id_post = :postId 
			ORDER BY comment_date DESC
			');
			$comments->execute(array('postId' => $postId));

			return $comments;
		}

		public function getComment($id)
		{
			$db = $this->dbConnect();

			$comment = $db->prepare('SELECT id, id_post, author, comment FROM comments WHERE id = :id');
			$comment->execute(array('id' => $id));

			return $comment;
		}

		public function addComment($postId, $pseudo, $email, $comment)
		{
			$db = $this->dbConnect();

			strip_tags($comment);

			$addComment = $db->prepare('INSERT INTO comments(id_post, author, email, comment, comment_date) VALUES (:id_post, :author, :email, :comment, NOW())');
			$addComment->execute(array('id_post' => $postId, 'author' => $pseudo, 'email' => $email, 'comment' => $comment));

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

		public function deleteComment($id_comment)
		{
			$db = $this->dbConnect();

			$deleteComment = $db->prepare('DELETE FROM comments WHERE id = :id');
			$deleteComment->execute(array('id' => $id_comment));
		}

		public function deleteComments($pseudo)
		{
			$db = $this->dbConnect();

			$deleteComments = $db->prepare('DELETE FROM comments WHERE author = :pseudo');
			$deleteComments->execute(array('pseudo' => $pseudo));
		}
	}