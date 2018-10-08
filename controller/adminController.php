<?php

	require_once('model/Posts.php');
	require_once('model/Warning.php');

	use \Eric\Blog\Model\Posts\Posts;
	use \Eric\Blog\Model\Warning\Warning;

		//Affichage liste des posts + pagination pour adminView.php
	function listPostsAdmin()
	{
		$count = new Posts();
		$postManager = new Posts();

		$max_nb_post = 5;
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

		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/adminView.php');
	}