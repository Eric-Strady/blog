<?php
	namespace Eric\Blog\Model\Warning;
	require_once("model/Manager.php");

	class WarningManager extends \Eric\Blog\Model\Manager
	{

		public function insertWarnedComment($idComment, $author, $comment, $postId)
		{
			$db = $this->dbConnect();

			$insertWarnedComment = $db->prepare('INSERT INTO warning(id_comment, author, comment, warning_date) VALUES (:idComment, :author, :comment, NOW())');
			$insertWarnedComment->execute(array('idComment' => $idComment, 'author' => $author, 'comment' => $comment));

			$path = 'Location: http://127.0.0.1/blog/index.php?post=' . $postId ;
			header($path);
		}

		public function checkWarning($id)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT id_comment FROM warning WHERE id_comment = :id ');
			$req->execute(array('id' => $id));
			$checkWarning = $req->fetch();

			return $checkWarning;
		}

		public function getWarningComments()
		{
			$db = $this->dbConnect();

			$warningComments = $db->query('
			SELECT id, id_comment, author, comment, DATE_FORMAT(warning_date, \'%d/%m/%Y\') AS d_warning, DATE_FORMAT(warning_date, \'%Hh%imin%ss\') AS h_warning
			FROM warning 
			ORDER BY warning_date DESC
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