<?php
	require ('model/model.php');

	function listPosts()
	{
		$max_nb_post = 5;
		$req = countPosts();
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

		$req = getPosts($first_post, $max_nb_post);

		require ('view/frontend/listPostsView.php');
	}

	function post()
	{
		$post = getPost($_GET['post']);

		if (!empty($post))
		{
		$comments = getComments($_GET['post']);
		require ('view/frontend/comments.php');
		}
		else
		{
			echo '<h2>Erreur:</h2><p>Le billet auquel vous souhaitez accéder n\'existe pas !</p>';
			echo 'Retour à la page d\'<a href="index.php">accueil</a>';
		}
	}

	function insertComment()
	{
		addComment($_POST['postId'], $_POST['pseudo'], $_POST['comment']);

		require ('view/frontend/comments.php');
	}