<?php

	require_once('model/Post.php');
	require_once('model/PostsManager.php');

	use \Eric\Blog\Model\Posts\Post;
	use \Eric\Blog\Model\Posts\PostsManager;

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
		if (isset($_POST['description'], $_FILES['image'], $_POST['add_title'], $_POST['add_content']))
		{
			if ($_POST['description']!='' AND $_FILES['image']!='' AND $_POST['add_title']!='' AND $_POST['add_content']!='')
			{
				if ($_FILES['image']['error'] == 0)
				{
					if ($_FILES['image']['size']<=500000)
					{
						$data_files = pathinfo($_FILES['image']['name']);
						$extension_upload = $data_files['extension'];
						$authorized_extensions = array('jpg', 'jpeg', 'png');

						if (in_array($extension_upload, $authorized_extensions))
						{
							$description = strip_tags($_POST['description']);
							$title = strip_tags($_POST['add_title']);
							$content = strip_tags($_POST['add_content']);

							$post = new Post(['title' => $title, 'content' => $content, 'image_description' => $description, 'image_extension' => $extension_upload]);
							$postsManager = new PostsManager();
							$postsManager->addPost($post);

							move_uploaded_file($_FILES['image']['tmp_name'], 'public/images/cover/' . $post->getId() . '.' . $post->getImgExt());

							$path = 'Location: http://127.0.0.1/blog/index.php?link=crud&action=read&id_post=' . $post->getId();
							header($path);
						}
						else
						{
							throw new Exception('<p>Le format de l\'image n\'est pas conforme. Pour rappel, vous devez transmettre une image au format "JPG", "JPEG" ou "PNG".<br/>Retour à la page de <a href="index.php?link=crud&amp;action=create_page" title="Page de création" class="alert-link">création</a></p>');
						}
					}
					else
					{
						throw new Exception('<p>L\'image est trop volumineuse. Pour rappel, elle ne doit pas dépasser 500Ko.<br/>Retour à la page de <a href="index.php?link=crud&amp;action=create_page" title="Page de création" class="alert-link">création</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Une erreur est survenue lors du téléchargement.<br/>Retour à la page de <a href="index.php?link=crud&amp;action=create_page" title="Page de création" class="alert-link">création</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à la page de <a href="index.php?link=crud&amp;action=create_page" title="Page de création" class="alert-link">création</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à la page de <a href="index.php?link=crud&amp;action=create_page" title="Page de création" class="alert-link">création</a></p>');
		}
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