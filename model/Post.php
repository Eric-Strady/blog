<?php

	namespace Eric\Blog\Model\Posts;

	class Post
	{
		private $_id, $_title, $_content, $_creation_date, $_image_description, $_image_extension;

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
        
        public function getTitle()
        {
            return $this->_title;
        }
        
        public function getContent()
        {
            return $this->_content;
        }
        
        public function getCreation_date()
        {
            return $this->_creation_date;
        }
        
        public function getImage_desc()
        {
            return $this->_image_description;
        }
        
        public function getImage_extension()
        {
            return $this->_image_extension;
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
                throw new Exception('<p>Cette page n\'existe pas !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
            } 
        }
        
        public function setTitle($title)
        {
            if (is_string($title))
            {
            	if (strlen($title) <= 255)
            	{
            		$this->_title = $title; 
            	}
            	else
	            {
	                throw new Exception('<p>La taille du titre ne doit pas dépasser 255 caractères.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
	            }
            }
        }
        
        public function setContent($content)
        {
            if (is_string($content))
            {
                $this->_content = $content; 
            }
        }
        
        public function setCreation_date($date)
        {
            $this->_date = $date;
        }
        
        public function setImage_description($imgDesc)
        {
            if (is_string($imgDesc))
            {   
            	if (strlen($title) <= 30)
            	{
                	$this->_image_description = $imgDesc; 
            	}
            	else
	            {
	                throw new Exception('<p>La description de l\'image ne doit pas dépasser 30 caractères.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
	            }
   			}
        }
        
        public function setImage_extension($imgExt)
        {
            if (is_string($imgExt))
            {
            	if (strlen($title) <= 30)
            	{
	                $this->_image_extension = $imgExt;
	            }
	            else
	            {
	                throw new Exception('<p>Vous utilisez une extension d\'image non valide.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
	            }
            }
        }
	}