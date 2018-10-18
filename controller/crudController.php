<?php

	require_once('model/Warning.php');
	require_once('model/WarningManager.php');
	require_once('model/CommentsManager.php');

	use \Eric\Blog\Model\Warning\Warning;
	use \Eric\Blog\Model\Warning\WarningManager;
	use \Eric\Blog\Model\Comments\CommentsManager;

												//DEFINE ACTION

	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
	{
		if (isset($_GET['action']) AND !empty($_GET['action']))
		{
			$action = strip_tags($_GET['action']);
			switch ($action)
			{
				case 'create_page':
					require 'view/backend/addPostView.php';
				break;

				case 'create':
					createPost();
				break;

				case 'read':
					require 'view/backend/readPostView.php';
				break;

				case 'update_page':
					require 'view/backend/updatePostView.php';
				break;

				case 'update':
					changePost();
				break;

				case 'delete_page':
					require 'view/backend/deletePostView.php';
				break;

				case 'delete':
					erasePost();
				break;

				default:
					throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
				break;
			}
		}
		else
		{
			throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
		}
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à aller sur cette page !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
	}

												//FUNCTIONS

	function createPost()
	{

	}

	function changePost()
	{

	}

	function erasePost()
	{

	}	

	/*
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
	*/