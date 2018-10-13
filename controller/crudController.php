<?php

	require_once('model/PostsManager.php');
	require_once('model/AdminManager.php');
	require_once('model/WarningManager.php');

	use \Eric\Blog\Model\Posts\PostsManager;
	use \Eric\Blog\Model\Admin\AdminManager;
	use \Eric\Blog\Model\Warning\WarningManager;

	//Lien vers la création d'un post + insertion d'un post
	function newPost()
	{
		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require ('view/backend/addPostView.php');
	}

	function addPost($title, $content, $description, $extension_upload)
	{
		$adminManager = new AdminManager();
		$adminManager->createPost($title, $content, $description, $extension_upload);
	}

	function lastId()
	{
		$adminManager = new AdminManager();
		$lastId = $adminManager->getLastPost();

		return $lastId;
	}

	//Affichage d'un post + modification d'un post
	function readPost($postId)
	{
		$postsManager = new PostsManager();
		$post = $postsManager->getPost($postId);

		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require ('view/backend/readPostView.php');
	}

	function changePost($postId)
	{
		$postsManager = new PostsManager();
		$post = $postsManager->getPost($postId);

		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require ('view/backend/updatePostView.php');
	}

	function rePost($title, $content, $id)
	{
		$adminManager = new AdminManager();
		$adminManager->updatePost($title, $content, $id);
	}

	function changeImage($description, $extension, $id)
	{
		$changeImage = new AdminManager();
		$changeImage->updateImage($description, $extension, $id);
	}

	//Affichage du formulaire de suppression + suppression d'un post
	function deleteForm()
	{
		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/deletePostView.php');
	}

	function eraseImage($id, $extension)
	{
		unlink('public/images/cover/' . $id . '.' . $extension);
	}

	function erasePost($id)
	{
		$adminManager = new AdminManager();
		$adminManager->deletePost($id);
	}