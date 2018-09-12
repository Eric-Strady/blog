<?php

	require_once('model/PostsManager.php');
	require_once('model/CommentsManager.php');

	//Affichage des posts + pagination pour listPostsView

	function listPosts()
	{
		$count = new Eric\Blog\Model\PostsManager();
		$postManager = new Eric\Blog\Model\PostsManager();

		$max_nb_post = 5;
		$req = $count->countPosts();
		$total_post = $req->fetch();
		$req->closeCursor();
		$nb_post = $total_post['nb_post'];
		$nb_page = ceil($nb_post/$max_nb_post);

		if (isset($_GET['page']))
		{
			strip_tags($_GET['page']);
			$_GET['page'] = (int)$_GET['page'];
			$current_page = $_GET['page'];
			if ($current_page == 0)
			{
				$current_page = 1;
			}
			elseif ($current_page > $nb_page)
			{
				$current_page = $nb_page;
			}
		}
		else
		{
			$current_page = 1;
		}

		$first_post = ($current_page-1)*$max_nb_post;

		$req = $postManager->getPosts($first_post, $max_nb_post);

		require ('view/frontend/listPostsView.php');
	}

	//Affichage du post selectionne et de ses commentaires + ajout de commentaires 

	function post()
	{
		$postsManager = new Eric\Blog\Model\PostsManager();
		$commentsManager = new Eric\Blog\Model\CommentsManager();

		$post = $postsManager->getPost($_GET['post']);

		if (!empty($post))
		{
			$comments = $commentsManager->getComments($_GET['post']);
			require ('view/frontend/comments.php');
		}
		else
		{
			throw new Exception('Le billet auquel vous souhaitez accéder n\'existe pas !');
		}
	}

	function insertComment()
	{
		$commentsManager = new Eric\Blog\Model\CommentsManager();

		$commentsManager->addComment($_POST['postId'], $_POST['pseudo'], $_POST['comment']);

		require ('view/frontend/comments.php');
	}

	function checkPseudo()
	{
		$usersManager = new Eric\Blog\Model\UsersManager();

		$usersManager->verifyPseudo($_GET['pseudo']);

		require ('signInView.php');
	}