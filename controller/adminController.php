<?php

	require_once('model/Post.php');
	require_once('model/PostsManager.php');

	use \Eric\Blog\Model\Posts\Post;
	use \Eric\Blog\Model\Posts\PostsManager;


	$posts = new Post([]);
	$postsManager = new PostsManager();

	$max_nb_post = 6;
	$total_post = $postsManager->count();
	$nb_post = $total_post;
	$nb_page = ceil($nb_post/$max_nb_post);

	if (isset($_GET['page']))
	{
		$_GET['page'] = (int) $_GET['page'];
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

	$posts = $postsManager->listPosts($first_post, $max_nb_post);

	require 'view/backend/adminView.php';
	

		
	/*
		//Affichage liste des posts + pagination pour adminView.php
	function listPostsAdmin()
	{
		$count = new PostsManager();
		$postManager = new PostsManager();

		$max_nb_post = 6;
		$req = $count->countPosts();
		$total_post = $req->fetch();
		$req->closeCursor();
		$nb_post = $total_post['nb_post'];
		$nb_page = ceil($nb_post/$max_nb_post);

		if (isset($_GET['show']))
		{
			strip_tags($_GET['show']);
			$_GET['show'] = (int)$_GET['show'];
			$current_page = $_GET['show'];
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

		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/adminView.php');
	}
	*/