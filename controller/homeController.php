<?php

	require_once('model/Post.php');
	require_once('model/Manager/PostsManager.php');

	use \Eric\Blog\Model\Posts\Post;
	use \Eric\Blog\Model\Manager\Posts\PostsManager;

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

	require 'view/frontend/listPostsView.php';