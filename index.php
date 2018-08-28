<?php
	require ('model.php');

	$max_nb_post = 5;
	$count = countPosts();
	$total_post = $count->fetch();
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
	
	$req->closeCursor();
	$first_post = ($current_page-1)*$max_nb_post;

	$req = getPosts($first_post, $max_nb_post);

	require('listPostsView.php');
