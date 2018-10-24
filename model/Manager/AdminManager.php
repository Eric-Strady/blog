<?php
	namespace Eric\Blog\Model\Admin;
	require_once("model/Manager.php");

	class AdminManager extends \Eric\Blog\Model\Manager
	{
		public function createPost($title, $content, $description, $extension)
		{
			$createPost = $this->getDB()->prepare('INSERT INTO posts(title, content, creation_date, image_description, image_extension) VALUES( :title, :content , NOW(), :description, :extension)');
			$createPost->execute(array('title' => $title, 'content' => $content, 'description' => $description, 'extension' => $extension));
		}

		public function getLastpost()
		{
			$getLastPost = $this->getDB()->query('SELECT MAX(id) AS last FROM posts');

			return $getLastPost;
		}

		public function updatePost($title, $content, $id)
		{
			$updatePost = $this->getDB()->prepare('UPDATE posts SET title = :title, content = :content, creation_date = NOW() WHERE id = :id');
			$updatePost->execute(array('title' => $title, 'content' => $content, 'id' => $id));

			$path = 'Location: http://127.0.0.1/blog/index.php?read=' . $id;
			header($path);
		}

		public function updateImage($description, $extension, $id)
		{
			$updateImage = $this->getDB()->prepare('UPDATE posts SET image_description = :description, image_extension = :extension WHERE id = :id');
			$updateImage->execute(array('description' => $description, 'extension' => $extension, 'id' => $id));

			$path = 'Location: http://127.0.0.1/blog/index.php?read=' . $id;
			header($path);
		}

		public function deletePost($id)
		{
			$deletePost = $this->getDB()->prepare('DELETE FROM posts WHERE id = :id');
			$deletePost->execute(array('id' => $id));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=admin';
			header($path);
		}

		public function deleteUser($pseudo)
		{
			$deleteUser = $this->getDB()->prepare('DELETE FROM users WHERE pseudo = :pseudo');
			$deleteUser->execute(array('pseudo' => $pseudo));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=account&success=user_suppression';
			header($path);
		}
	}