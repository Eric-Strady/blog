<?php

	namespace Eric\Blog\Model\Comments;

	class Comment
	{
		private $_id, $_id_user, $_id_post, $_comment, $_d_comment, $_h_comment, $pseudo, $email;

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
        public function getIdPost(){ return $this->_id_post; }
        public function getComment(){ return $this->_comment; }
        public function getCommentDay(){ return $this->_d_comment; }
        public function getCommentHour(){ return $this->_h_comment; }
        public function getPseudo(){ return $this->_pseudo; }
        public function getEmail(){ return $this->_email; }

        public function setId($id)
        {
            $id = (int) $id;
            if ($id > 0)
            {
                $this->_id = $id;
            }
            else
            {
                throw new \Exception('<p>Ce commentaire n\'existe pas !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
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
	                throw new \Exception('<p>Le commentaire ne doit pas dépasser 255 caractères.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
	            }
            }
        }
        
        public function setD_comment($dDate)
        {
            $this->_d_comment = $dDate;
        }

        public function setH_comment($hDate)
        {
            $this->_h_comment = $hDate;
        }

        public function setPseudo($pseudo)
        {
            $this->_pseudo = $pseudo;
        }

        public function setEmail($email)
        {
            $this->_email = $email;
        }
	}