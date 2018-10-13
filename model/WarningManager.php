<?php
	namespace Eric\Blog\Model\Warning;
	require_once("model/Manager.php");

	class WarningManager extends \Eric\Blog\Model\Manager
	{
		public function checkWarning($id, $informer)
		{
			$req = $this->getDB()->prepare('SELECT id_comment FROM warning WHERE id_comment = :id AND id_informer = :informer');
			$req->execute(array('id' => $id, 'informer' => $informer));
			$checkWarning = $req->fetch();

			return $checkWarning;
		}

		public function insertWarnedComment($idComment, $author, $comment, $postId, $informer)
		{
			$insertWarnedComment = $this->getDB()->prepare('INSERT INTO warning(id_comment, author, comment, warning_date, id_informer, nb_times) VALUES (:idComment, :author, :comment, NOW(), :informer, +1)');
			$insertWarnedComment->execute(array('idComment' => $idComment, 'author' => $author, 'comment' => $comment, 'informer' => $informer));

			$path = 'Location: http://127.0.0.1/blog/index.php?post=' . $postId ;
			header($path);
		}

		public function countWarning()
		{
			$req = $this->getDB()->query('SELECT COUNT(*) AS nb_warning FROM warning');

			return $req;
		}

		public function getWarningComments()
		{
			$warningComments = $this->getDB()->query('
			SELECT SUM(nb_times) AS nTimes, id, id_comment, author, comment, DATE_FORMAT(warning_date, \'%d/%m/%Y\') AS d_warning, DATE_FORMAT(warning_date, \'%Hh%imin%ss\') AS h_warning
			FROM warning
			GROUP BY id_comment
			ORDER BY nTimes DESC
			');
			$affectedLines = $warningComments->rowcount();

			if ($affectedLines == 0)
			{
				return $affectedLines;
			}
			else
			{
				return $warningComments;
			}	
		}

		public function deleteWarning($id_comment)
		{
			$deleteWarning = $this->getDB()->prepare('DELETE FROM warning WHERE id_comment = :id_comment');
			$deleteWarning->execute(array('id_comment' => $id_comment));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=moderate';
			header($path);
		}
	}