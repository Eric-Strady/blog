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
            return $this->_email;
        }
        
        public function getReasons()
        {
            return $this->_reasons;
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

        public function sendBannedEmail()
        {
            $to = $this->getEmail();
            $subject = 'Suppression de votre compte utilisateur';
            $message = '
                <html>
                    <head></head>
                    <body>
                        <div align="center">
                            <h3>Suppression de votre compte !</h3>
                            <p>Bonjour,<br/>
                            Votre compte utilisateur sur le blog de Jean Forteroche a fait l\'objet d\'une suppression par l\'administrateur.</p>
                            <p>En voici les raisons:<br/>
                            "' . $this->getReasons() . '"</p>
                        </div>
                    </body>
                </html>
            ';
            $header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
            $header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
            $header.= "MIME-Version: 1.0\n";
            $header.= "Content-Type: text/html; charset=\"UTF-8\"";
            $header.= "Content-Transfer-Encoding: 8bit";

            mail($to, $subject, $message, $header);
        }
    }