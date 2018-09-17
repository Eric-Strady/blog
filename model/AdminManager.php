<?php
	namespace Eric\Blog\Model\Admin;
	require_once("model/Manager.php");

	class AdminManager extends \Eric\Blog\Model\Manager
	{
		public function updatePost($title, $content, $id)
		{
			$db = $this->dbConnect();

			$updatePost = $db->prepare('UPDATE posts SET title = :title, content = :content, creation_date = NOW() WHERE id = :id');
			$updatePost->execute(array('title' => $title, 'content' => $content, 'id' => $id));

			$path = 'Location: http://127.0.0.1/blog/index.php?read=' . $id;
			header($path);
		}
	}