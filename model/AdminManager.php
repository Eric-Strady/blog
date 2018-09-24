<?php
	namespace Eric\Blog\Model\Admin;
	require_once("model/Manager.php");

	class AdminManager extends \Eric\Blog\Model\Manager
	{
		public function createPost($title, $content)
		{
			$db = $this->dbConnect();

			$createPost = $db->prepare('INSERT INTO posts(title, content, creation_date) VALUES( :title, :content , NOW())');
			$createPost->execute(array('title' => $title, 'content' => $content));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=admin';
			header($path);
		}

		public function updatePost($title, $content, $id)
		{
			$db = $this->dbConnect();

			$updatePost = $db->prepare('UPDATE posts SET title = :title, content = :content, creation_date = NOW() WHERE id = :id');
			$updatePost->execute(array('title' => $title, 'content' => $content, 'id' => $id));

			$path = 'Location: http://127.0.0.1/blog/index.php?read=' . $id;
			header($path);
		}

		public function deletePost($id)
		{
			$db = $this->dbConnect();

			$deletePost = $db->prepare('DELETE FROM posts WHERE id = :id');
			$deletePost->execute(array('id' => $id));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=admin';
			header($path);
		}

		public function deleteUser($pseudo)
		{
			$db = $this->dbConnect();

			$deleteUser = $db->prepare('DELETE FROM users WHERE pseudo = :pseudo');
			$deleteUser->execute(array('pseudo' => $pseudo));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=account&success=user_suppression';
			header($path);
		}
	}