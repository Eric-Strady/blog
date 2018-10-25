<?php
	namespace Eric\Blog\Model\Manager\Warning;
	require_once("model/Manager/Manager.php");
    use \Eric\Blog\Model\Warning\Warning;

	class WarningManager extends \Eric\Blog\Model\Manager\Manager
	{
		public function isExist($infos)
        {
        	$req = $this->_db->prepare('SELECT COUNT(*) FROM warning WHERE id_comment = :infos');
			$req->execute(array('infos' => $infos));
			
			return (bool) $req->fetchcolumn();
        }

        public function count()
        {
            $req = $this->_db->query('SELECT * FROM warning');

            return (bool) $req->fetchcolumn(); 
        }

        public function alreadyWarned(Warning $warning)
        {
        	$req = $this->_db->prepare('SELECT COUNT(*) FROM warning WHERE id_user = :id_user AND id_comment = :id_comment');
			$req->execute(array('id_user' => $warning->getIdUser(), 'id_comment' => $warning->getIdComment()));
			
			return (bool) $req->fetchcolumn();
        }

		public function addWarning(Warning $warning)
		{
			$req = $this->_db->prepare('INSERT INTO warning(id_user, id_comment, id_post, warning_date) VALUES (:id_user, :id_comment, :id_post, NOW())');
			$req->execute(array('id_user' => $warning->getIdUser(), 'id_comment' => $warning->getIdComment(), 'id_post' => $warning->getIdPost()));
		}

		public function listWarned()
        {
            $warning = [];
            $req = $this->_db->query('
            	SELECT SUM(w.nb_times) AS nbTimes, w.id, w.id_user, w.id_comment, u.pseudo, c.comment, 
            	DATE_FORMAT(w.warning_date, \'%d/%m/%Y\') AS d_warning, 
            	DATE_FORMAT(w.warning_date, \'%Hh%imin%ss\') AS h_warning 
            	FROM warning AS w, comments AS c
            	INNER JOIN users AS u ON c.id_user = u.id 
            	WHERE w.id_comment = c.id 
            	GROUP BY w.id_comment 
            	ORDER BY nbTimes DESC');
            
            while ($data = $req->fetch(\PDO::FETCH_ASSOC))
            {
                $warning[] = new Warning($data);
            }
            
            return $warning;
        }

        public function deleteWarning(Warning $warning)
        {
        	$req = $this->_db->prepare('DELETE FROM warning WHERE id_comment = :id_comment');
			$req->execute(array('id_comment' => $warning->getIdComment()));
        }
    }