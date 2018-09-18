<?php
	namespace Eric\Blog\Model\Posts;
	require_once("model/Manager.php");

	class PostsManager extends \Eric\Blog\Model\Manager
	{
		public function countPosts()
		{
			$db = $this->dbConnect();

			$req = $db->query('SELECT COUNT(*) AS nb_post FROM posts');

			return $req;
		}

		public function getPosts($first_post, $max_nb_post)
		{
			$db = $this->dbConnect();

			$req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr FROM posts ORDER BY id DESC LIMIT ' . $first_post . ', ' . $max_nb_post);

			return $req;
		}

		public function getPost($postId)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr FROM posts WHERE id = :postId');
			$req->execute(array('postId' => $postId));
			$post = $req->fetch();

			return $post;
		}
	}