<?php
	namespace Eric\Blog\Model\Warning;
	require_once("model/Manager.php");

	class WarningManager extends \Eric\Blog\Model\Manager
	{
		public function checkWarning($id, $informer)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT id_comment FROM warning WHERE id_comment = :id AND id_informer = :informer');
			$req->execute(array('id' => $id, 'informer' => $informer));
			$checkWarning = $req->fetch();

			return $checkWarning;
		}

		public function checkWarnedComment($id)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT nb_times FROM warning WHERE id_comment = :id');
			$req->execute(array('id' => $id));
			$checkWarnedComment = $req->fetch();

			return $checkWarnedComment;
		}

		public function insertWarnedComment($idComment, $author, $comment, $postId, $informer)
		{
			$db = $this->dbConnect();

			$insertWarnedComment = $db->prepare('INSERT INTO warning(id_comment, author, comment, warning_date, id_informer, nb_times) VALUES (:idComment, :author, :comment, NOW(), :informer, +1)');
			$insertWarnedComment->execute(array('idComment' => $idComment, 'author' => $author, 'comment' => $comment, 'informer' => $informer));

			$path = 'Location: http://127.0.0.1/blog/index.php?post=' . $postId ;
			header($path);
		}

		public function giveImportance($informer, $idComment, $postId)
		{
			$db = $this->dbConnect();

			$giveImportance = $db->prepare('UPDATE warning SET warning_date = NOW(), id_informer = :informer, nb_times = nb_times+1 WHERE id_comment = :idComment');
			$giveImportance->execute(array('informer' => $informer, 'idComment' => $idComment));

			$path = 'Location: http://127.0.0.1/blog/index.php?post=' . $postId ;
			header($path);
		}

		public function countWarning()
		{
			$db = $this->dbConnect();

			$req = $db->query('SELECT COUNT(*) AS nb_warning FROM warning');

			return $req;
		}

		public function getWarningComments()
		{
			$db = $this->dbConnect();

			$warningComments = $db->query('
			SELECT id, id_comment, author, comment, nb_times, DATE_FORMAT(warning_date, \'%d/%m/%Y\') AS d_warning, DATE_FORMAT(warning_date, \'%Hh%imin%ss\') AS h_warning
			FROM warning 
			ORDER BY nb_times DESC
			');

			return $warningComments;
		}

		public function deleteWarning($id)
		{
			$db = $this->dbConnect();

			$deleteWarning = $db->prepare('DELETE FROM warning WHERE id = :id');
			$deleteWarning->execute(array('id' => $id));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=moderate';
			header($path);
		}
	}