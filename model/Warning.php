<?php

	namespace Eric\Blog\Model\Warning;

	class Warning
	{
		private $_id, $_id_user, $_id_comment, $id_post, $_nbTimes, $_d_warning, $_h_warning, $_pseudo, $_comment;

		public function __construct(array $data)
		{
            $this->hydrate($data);
        }
        
        public function hydrate(array $data)
        {
            foreach ($data as $key => $value)
            {
                $setter = 'set' . ucfirst($key);
                if (method_exists($this, $setter))
                {
                    $this->$setter($value);
                }
            }
        }

        public function getId(){ return $this->_id; }
        public function getIdUser(){ return $this->_id_user; }
        public function getIdComment(){ return $this->_id_comment; }
        public function getIdPost(){ return $this->_id_post; }
        public function getNbTimes(){ return $this->_nbTimes; }
        public function getWarningDay(){ return $this->_d_warning; }
        public function getWarningHour(){ return $this->_h_warning; }
        public function getPseudo(){ return $this->_pseudo; }
        public function getComment(){ return $this->_comment; }

        public function setId($id)
        {
            $id = (int) $id;
            if ($id > 0)
            {
                $this->_id = $id;
            }
            else
            {
                throw new \Exception('<p>Ce signelement n\'existe pas !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
            } 
        }
        
        public function setId_user($idUser)
        {
            $idUser = (int) $idUser;
            if ($idUser > 0)
            {
                $this->_id_user = $idUser;
            }
            else
            {
                throw new \Exception('<p>Cette utilisateur n\'existe pas !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
            } 
        }

        public function setId_comment($idComment)
        {
            $idComment = (int) $idComment;
            if ($idComment > 0)
            {
                $this->_id_comment = $idComment;
            }
            else
            {
                throw new \Exception('<p>Ce commentaire n\'existe pas !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
            } 
        }

        public function setId_post($idPost)
        {
            $idPost = (int) $idPost;
            if ($idPost > 0)
            {
                $this->_id_post = $idPost;
            }
            else
            {
                throw new \Exception('<p>Ce billet n\'existe pas !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
            } 
        }

        public function setNbTimes($nbTimes)
        {
            $nbTimes = (int) $nbTimes;
            if ($nbTimes > 0)
            {
                $this->_nbTimes = $nbTimes;
            }
            else
            {
                throw new \Exception('<p>Impossible d\'afficher la liste des commentaires signalés.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
            } 
        }
        
        public function setD_warning($warningDay)
        {
            $this->_d_warning = $warningDay; 
        }

        public function setH_Warning($warningHour)
        {
            $this->_h_warning = $warningHour; 
        }

        public function setPseudo($pseudo)
        {
            if (is_string($pseudo))
            {
                if (strlen($pseudo) <= 255)
                {
                    $this->_pseudo = $pseudo; 
                }
                else
                {
                    throw new \Exception('<p>Impossible d\'afficher la liste des commentaires signalés.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
                }
            }
        }

        public function setComment($comment)
        {
            if (is_string($comment))
            {
                if (strlen($comment) <= 255)
                {
                    $this->_comment = $comment; 
                }
                else
                {
                    throw new \Exception('<p>Impossible d\'afficher la liste des commentaires signalés.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
                }
            }
        }
    }