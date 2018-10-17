<?php
	namespace Eric\Blog\Model\Warning;
	require_once("model/Manager.php");

	class WarningManager extends \Eric\Blog\Model\Manager
	{
		public function isExist($infos)
        {
        	$req = $this->_db->prepare('SELECT COUNT(*) FROM warning WHERE id_comment = :infos');
			$req->execute(array('infos' => $infos));
			
			return (bool) $req->fetchcolumn();
        }

        public function alreadyWarned($id_user, $id_comment)
        {
        	$req = $this->_db->prepare('SELECT COUNT(*) FROM warning WHERE id_user = :id_user AND id_comment = :id_comment');
			$req->execute(array('id_user' => $id_user, 'id_comment' => $id_comment));
			
			return (bool) $req->fetchcolumn();
        }

		public function addWarning($id_user, $id_comment, $id_post)
		{
			$req = $this->_db->prepare('INSERT INTO warning(id_user, id_comment, id_post, warning_date) VALUES (:id_user, :id_comment, :id_post, NOW())');
			$req->execute(array('id_user' => $id_user, 'id_comment' => $id_comment, 'id_post' => $id_post));
		}

		public function count()
		{
			$req = $this->_db->query('SELECT COUNT(*) FROM warning');
			
			return (bool) $req->fetchcolumn();
		}

		public function listWarned()
        {
            $warning = [];
            $req = $this->_db->query('
            	SELECT SUM(w.nb_times) AS nbTimes, w.id, w.id_user, w.id_comment, u.pseudo, c.comment, 
            	DATE_FORMAT(w.warning_date, \'%d/%m/%Y\') AS d_warning, 
            	DATE_FORMAT(w.warning_date, \'%Hh%imin%ss\') AS h_warning 
            	FROM warning AS w 
            	INNER JOIN users AS u ON w.id_user = u.id 
            	INNER JOIN comments AS c ON w.id_comment = c.id 
            	GROUP BY w.id_comment 
            	ORDER BY nbTimes DESC');
            
            while ($data = $req->fetch(\PDO::FETCH_ASSOC))
            {
                $warning[] = new Warning($data);
            }
            
            return $warning;
        }

		/*
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
		*/
	}