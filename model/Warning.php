<?php

	namespace Eric\Blog\Model\Warning;

	class Warning
	{
		private $_id, $_id_user, $_id_comment, $id_post, $_warning_date;

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

        public function getId()
        {
            return $this->_id;
        }
        
        public function getIdUser()
        {
            return $this->_id_user;
        }
        
        public function getIdComment()
        {
            return $this->_id_comment;
        }

        public function getIdPost()
        {
            return $this->_id_post;
        }
        
        public function getWarningDate()
        {
            return $this->_warning_date;
        }

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
        
        public function setWarning_date($warningDate)
        {
            $this->_comment = $warningDate; 
        }
    }