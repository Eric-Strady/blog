<?php
	namespace Eric\Blog\Model\Posts;
	require_once("model/Manager.php");

	class PostsManager extends \Eric\Blog\Model\Manager
	{
		public function countPosts()
		{
			$req = $this->getDB()->query('SELECT COUNT(*) AS nb_post FROM posts');

			return $req;
		}

		public function getPosts($first_post, $max_nb_post)
		{
			$req = $this->getDB()->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr, image_description, image_extension FROM posts ORDER BY id DESC LIMIT ' . $first_post . ', ' . $max_nb_post);

			return $req;
		}

		public function getPost($postId)
		{
			$req = $this->getDB()->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr, image_description, image_extension FROM posts WHERE id = :postId');
			$req->execute(array('postId' => $postId));
			if ($req->rowcount() == 1)
			{
				$post = $req->fetch();
				return $post;
			}
			else
			{
				throw new \Exception('Le billet auquel vous souhaitez accéder n\'existe pas !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}
		}
	}