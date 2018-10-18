<?php

    namespace Eric\Blog\Model\Contact;

	class Contact
	{
		private $_email, $_subject, $_message;

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
        
        public function getSubject()
        {
            return $this->_subject;
        }

        public function getMessage()
        {
            return $this->_message;
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

        public function setSubject($subject)
        {
            if (is_string($subject))
            {
                if (strlen($subject) <= 60)
                {
                    $this->_subject = $subject; 
                }
                else
                {
                    throw new \Exception('<p>La taille du sujet ne doit pas dépasser 60 caractères.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
                }
            }
        }

        public function setMessage($message)
        {
            if (is_string($message))
            {
                if (strlen($message) <= 255)
                {
                    $this->_message = $message; 
                }
                else
                {
                    throw new \Exception('<p>La taille du message ne doit pas dépasser 255 caractères.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
                }
            }
        }

        public function sendMessage()
        {
            $to = 'strady60@gmail.com';
            $subject = $this->getSubject();
            $message = '
                <html>
                    <head></head>
                    <body>
                        <div align="center">
                            <h3>Prise de contact depuis le blog:</h3>
                            <p>' . $this->getMessage() . '</p>
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