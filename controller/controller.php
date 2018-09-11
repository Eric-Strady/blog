<?php

	require_once('model/PostsManager.php');
	require_once('model/CommentsManager.php');

	function listPosts()
	{
		$count = new PostsManager();
		$postManager = new PostsManager();

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

	function post()
	{
		$postsManager = new PostsManager();
		$commentsManager = new CommentsManager();

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
		$commentsManager = new CommentsManager();

		$commentsManager->addComment($_POST['postId'], $_POST['pseudo'], $_POST['comment']);

		require ('view/frontend/comments.php');
	}