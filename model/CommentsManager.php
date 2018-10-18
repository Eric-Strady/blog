<?php
	namespace Eric\Blog\Model\Comments;
	require_once("model/Manager.php");

	class CommentsManager extends \Eric\Blog\Model\Manager
	{
		public function listComments($id_post)
		{
			$comments = [];
			$req = $this->_db->prepare('
				SELECT c.id, c.id_user, c.comment, DATE_FORMAT(c.comment_date, \'%d/%m/%Y\') AS d_comment, DATE_FORMAT(c.comment_date, \'%Hh%imin%ss\') AS h_comment, u.pseudo, u.email
				FROM comments AS c
				INNER JOIN users AS u
				ON c.id_user = u.id
				WHERE c.id_post = :id_post
				ORDER BY c.comment_date DESC');
			$req->execute(array('id_post' => $id_post));

			while ($data = $req->fetch(\PDO::FETCH_ASSOC))
            {
                $comments[] = new Comment($data);
            }
            
            return $comments;
		}

		public function addComment(Comment $comment)
		{
			$req = $this->_db->prepare('INSERT INTO comments(id_user, id_post, comment, comment_date) VALUES (:id_user, :id_post, :comment, NOW())');
			$req->execute(array('id_user' => $comment->getIdUser(), 'id_post' => $comment->getIdPost(), 'comment' => $comment->getComment()));
		}

		public function isExist($infos)
        {
        	$req = $this->_db->prepare('SELECT COUNT(*) FROM comments WHERE id = :infos');
			$req->execute(array('infos' => $infos));
			
			return (bool) $req->fetchcolumn();
        }

        public function updateComment(Comment $comment)
        {
        	$req = $this->_db->prepare('UPDATE comments SET comment = :comment WHERE id = :id');
        	$req->execute(array('comment' => $comment->getComment(), 'id' => $comment->getId()));
        }

        public function deleteComment($id_comment)
        {
        	$req = $this->_db->prepare('DELETE FROM comments WHERE id = :id_comment');
			$req->execute(array('id_comment' => $id_comment));
        }
	}