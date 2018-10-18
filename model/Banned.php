<?php

    namespace Eric\Blog\Model\Banned;

	class Banned
	{
		private $_email, $_reasons;

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

        public function getEmail()
        {
            return $this->_id;
        }
        
        public function getReasons()
        {
            return $this->_pseudo;
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
                    throw new \Exception('<p>La taille de l\'e-mail ne doit pas dépasser 255 caractères.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
                }
            }
        }

        public function setReasons($reasons)
        {
            if (is_string($reasons))
            {
                if (strlen($reasons) <= 255)
                {
                    $this->_reasons = $reasons; 
                }
                else
                {
                    throw new \Exception('<p>La taille du motif de suppression ne doit pas dépasser 255 caractères.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
                }
            }
        }
    }