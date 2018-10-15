<?php

    namespace Eric\Blog\Model\Users;

	class User
	{
		private $_id,
                $_pseudo,
                $_password,
                $_email,
                $_registration_key,
                $_registration_date,
                $_confirm,
                $_admin,
                $_token_pass,
                $_token_pass_date;

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
        
        public function getPseudo()
        {
            return $this->_pseudo;
        }
        
        public function getPassword()
        {
            return $this->_password;
        }
        
        public function getEmail()
        {
            return $this->_email;
        }
        
        public function getRegistrationKey()
        {
            return $this->_registration_key;
        }
        
        public function getRegistrationDate()
        {
            return $this->_registration_date;
        }
        
        public function getConfirm()
        {
            return $this->_confirm;
        }

        public function getAdmin()
        {
            return $this->_admin;
        }

        public function getTokenPass()
        {
            return $this->_token_pass;
        }

        public function getTokenPassDate()
        {
            return $this->_token_pass_date;
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
                throw new Exception('<p>Cet utilisateur n\'existe pas<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
            } 
        }
        
        public function setPseudo($pseudo)
        {
            if (is_string($pseudo))
            {
                if (strlen($pseudo) <= 255)
                {
                    $this->_title = $pseudo; 
                }
                else
                {
                    throw new Exception('<p>La taille du pseudo ne doit pas dépasser 255 caractères.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
                }
            }
        }
        
        public function setEmail($email)
        {
            if (is_string($email))
            {
                if (strlen($email) <= 255)
                {
                    $this->_email = $email; 
                }
                else
                {
                    throw new Exception('<p>La taille de l\'adresse e-mail ne doit pas dépasser 255 caractères.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
                }
            }
        }

        public function setRegistration_key($key)
        {
            if (is_string($key))
            {
                if (strlen($key) == 10)
                {
                    $this->_registration_key = $key; 
                }
                else
                {
                    throw new Exception('<p>Le format de votre clé d\'inscription n\'est pas conforme.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
                }
            }
        }
        
        public function setRegistration_date($date)
        {
            $this->_registration_date = $date;
        }

        public function setConfirm($confirm)
        {
            $confirm = (int) $confirm;

            $this->_confirm = $confirm;
        }

        public function setAdmin($admin)
        {
            $admin = (int) $admin;

            $this->_admin = $admin;
        }
        
        public function setToken_Pass($token)
        {
            if (is_string($token))
            {   
                if (strlen($token) == 60)
                {
                    $this->_token_pass = $token; 
                }
                else
                {
                    throw new Exception('<p>Le format de votre clé de réinitialisation de mot de passe n\'est pas conforme.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
                }
            }
        }

        public function setToken_pass_date($date)
        {
            $this->_token_pass_date = $date;
        }
    }