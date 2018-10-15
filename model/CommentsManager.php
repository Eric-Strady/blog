<?php
	namespace Eric\Blog\Model\Comments;
	require_once("model/Manager.php");

	class CommentsManager extends \Eric\Blog\Model\Manager
	{

		public function listComments($idPost)
		{
			$comments = [];
			$req = $this->_db->query('
				SELECT c.id, c.id_user, c.comment, DATE_FORMAT(c.comment_date, \'%d/%m/%Y\') AS d_comment, DATE_FORMAT(c.comment_date, \'%Hh%imin%ss\') AS h_comment, u.pseudo, u.email
				FROM comments AS c
				INNER JOIN users AS u
				ON c.id_user = u.id
				WHERE c.id_post = ' . $idPost);

			while ($data = $req->fetch(\PDO::FETCH_ASSOC))
            {
                $comments[] = new Comment($data);
            }
            
            return $comments;
		}

		/*
		public function getComments($postId)
		{
			$comments = $this->getDB()->prepare('
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
			$comment = $this->getDB()->prepare('SELECT id, id_post, author, comment FROM comments WHERE id = :id');
			$comment->execute(array('id' => $id));

			return $comment;
		}

		public function addComment($postId, $pseudo, $email, $comment)
		{
			$addComment = $this->getDB()->prepare('INSERT INTO comments(id_post, author, email, comment, comment_date) VALUES (:id_post, :author, :email, :comment, NOW())');
			$addComment->execute(array('id_post' => $postId, 'author' => $pseudo, 'email' => $email, 'comment' => $comment));

			$path = 'Location: http://127.0.0.1/blog/index.php?post=' . $postId;
			header($path);
		}

		public function updateComment($comment, $commentId, $id_post)
		{
			$updateComment = $this->getDB()->prepare('UPDATE comments SET comment = :comment, comment_date = NOW() WHERE id = :commentId');
			$updateComment->execute(array('comment' => $comment, 'commentId' => $commentId));

			$path = 'Location: http://127.0.0.1/blog/index.php?post=' . $id_post;
			header($path);
		}

		public function deleteComment($id_comment)
		{
			$deleteComment = $this->getDB()->prepare('DELETE FROM comments WHERE id = :id');
			$deleteComment->execute(array('id' => $id_comment));
		}

		public function deleteComments($pseudo)
		{
			$deleteComments = $this->getDB()->prepare('DELETE FROM comments WHERE author = :pseudo');
			$deleteComments->execute(array('pseudo' => $pseudo));
		}
		*/
	}