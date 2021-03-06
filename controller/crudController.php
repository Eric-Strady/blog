<?php

	require_once('model/Post.php');
	require_once('model/Manager/PostsManager.php');

	use \Eric\Blog\Model\Posts\Post;
	use \Eric\Blog\Model\Manager\Posts\PostsManager;

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
					readPost();
				break;

				case 'update_page':
					chargePost();
				break;

				case 'update_img':
					changeImg();
				break;

				case 'update_post':
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
							$content = ($_POST['add_content']);

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

	function readPost()
	{
		if (isset($_GET['id_post']) AND $_GET['id_post']!='')
		{
			$id_post = $_GET['id_post'];
			$post = new Post(['id' => $id_post]);
			$postsManager = new PostsManager();

			if ($postsManager->isExist($post->getId()))
			{
				$post = $postsManager->findPost($post);

				require 'view/backend/readPostView.php';
			}
			else
			{
				throw new Exception('<p>Ce billet n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseigné l\'identifiant du billet.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
		}
	}

	function chargePost()
	{
		if (isset($_GET['id_post']) AND $_GET['id_post']!='')
		{
			$id_post = $_GET['id_post'];
			$post = new Post(['id' => $id_post]);
			$postsManager = new PostsManager();

			if ($postsManager->isExist($post->getId()))
			{
				$post = $postsManager->findPost($post);

				require 'view/backend/updatePostView.php';
			}
			else
			{
				throw new Exception('<p>Ce billet n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseigné l\'identifiant du billet.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
		}
	}

	function changeImg()
	{
		if (isset($_POST['description'], $_FILES['image'], $_POST['id_post']))
		{
			if ($_POST['description']!='' AND $_FILES['image']!='' AND $_POST['id_post']!='')
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
							$id_post = $_POST['id_post'];

							$post = new Post(['id' => $id_post, 'image_description' => $description, 'image_extension' => $extension_upload]);
							$postsManager = new PostsManager();

							if ($postsManager->isExist($post->getId()))
							{
								$postsManager->updateImage($post);

								move_uploaded_file($_FILES['image']['tmp_name'], 'public/images/cover/' . $post->getId() . '.' . $post->getImgExt());

								$path = 'Location: http://127.0.0.1/blog/index.php?link=crud&action=read&id_post=' . $post->getId();
								header($path);
							}
							else
							{
								throw new Exception('<p>Ce billet n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
							}
						}
						else
						{
							throw new Exception('<p>Le format de l\'image n\'est pas conforme. Pour rappel, vous devez transmettre une image au format "JPG", "JPEG" ou "PNG".<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
						}
					}
					else
					{
						throw new Exception('<p>L\'image est trop volumineuse. Pour rappel, elle ne doit pas dépasser 500Ko.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Une erreur est survenue lors du téléchargement.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
		}
	}

	function changePost()
	{
		if (isset($_POST['up_title'], $_POST['up_content'], $_POST['id_post']))
		{
			if ($_POST['up_title']!='' AND $_POST['up_content']!='' AND $_POST['id_post']!='')
			{

				$title = strip_tags($_POST['up_title']);
				$content = ($_POST['up_content']);
				$id_post = strip_tags($_POST['id_post']);

				$post = new Post(['id' => $id_post, 'title' => $title, 'content' => $content]);
				$postsManager = new PostsManager();

				if ($postsManager->isExist($post->getId()))
				{
					$postsManager->updatePost($post);

					$path = 'Location: http://127.0.0.1/blog/index.php?link=crud&action=read&id_post=' . $post->getId();
					header($path);
				}
				else
				{
					throw new Exception('<p>Ce billet n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
				}		
			}
			else
			{
				throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
		}
	}

	function erasePost()
	{
		if (isset($_POST['delete'], $_POST['id_post']))
		{
			if ($_POST['delete']=='confirm' AND $_POST['id_post']!='')
			{
				$id_post = ($_POST['id_post']);
				
				$post = new Post(['id' => $id_post]);
				$postsManager = new PostsManager();
				$post = $postsManager->findPost($post);

				if ($postsManager->isExist($post->getId()))
				{
					$postsManager->deletePost($post);
					unlink('public/images/cover/' . $post->getId() . '.' . $post->getImgExt());

					$path = 'Location: http://127.0.0.1/blog/index.php?link=admin&deleted=post';
					header($path);
				}
				else
				{
					throw new Exception('<p>Ce billet n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
				}
			}
			elseif ($_POST['delete']=='cancel' AND $_POST['id_post']!='')
			{
				$path = 'Location: http://127.0.0.1/blog/index.php?link=admin';
				header($path);
			}
			else
			{
				throw new Exception('<p>Vous n\'avez pas renseigné votre choix. Prenez votre temps pour peser le pour et le contre ;)<br/>Retour à l\'<a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous n\'avez pas renseigné votre choix. Prenez votre temps pour peser le pour et le contre ;)<br/>Retour à l\'<a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
		}
	}