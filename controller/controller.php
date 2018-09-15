<?php

	require_once('model/PostsManager.php');
	require_once('model/CommentsManager.php');
	require_once('model/UsersManager.php');

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

		require('view/frontend/listPostsView.php');
	}

	//Liens vers les pages du menu

	function registrationLink()
	{
		require('view/frontend/registrationView.php');
	}
	function signinLink()
	{
		require('view/frontend/signInView.php');
	}
	function signoutLink()
	{
		require('view/frontend/signOutView.php');
	}

	//Affichage du post selectionné et de ses commentaires + ajout de commentaire + modification de commentaire

	function post($postId)
	{
		$postsManager = new Eric\Blog\Model\PostsManager();
		$commentsManager = new Eric\Blog\Model\CommentsManager();

		$post = $postsManager->getPost($postId);

		if (!empty($postId))
		{
			$comments = $commentsManager->getComments($postId);
			require('view/frontend/postView.php');
		}
		else
		{
			throw new Exception('Le billet auquel vous souhaitez accéder n\'existe pas !');
		}
	}

	function insertComment($postId, $pseudo, $comment)
	{
		$commentsManager = new Eric\Blog\Model\CommentsManager();
		$commentsManager->addComment($postId, $pseudo, $comment);
	}

	function reComment($comment, $commentId, $id_post)
	{
		$commentsManager = new Eric\Blog\Model\CommentsManager();
		$commentsManager->updateComment($comment, $commentId, $id_post);
	}

	//Vérifications pour l'insciption d'un utilisateur

	function verifyPseudo($pseudo)
	{
		$verifyPseudo = new Eric\Blog\Model\UsersManager();
		$avaiblePseudo = $verifyPseudo->checkPseudo($pseudo);

		return $avaiblePseudo;
	}

	function verifyEmail($email)
	{
		$verifyEmail = new Eric\Blog\Model\UsersManager();
		$avaibleEmail = $verifyEmail->checkEmail($email);

		return $avaibleEmail;
	}

	function registration($pseudo, $pass_hash, $email)
	{
		$registration = new Eric\Blog\Model\UsersManager();
		$registration->addMembers($pseudo, $pass_hash, $email);

		setcookie('pseudo', $pseudo, time()+120, null, null, false, true);
		require('signInView.php');
	}

	//Vérifications pour la connexion d'un utilisateur

	function verifyConnect($id_connect)
	{
		$verifyConnect = new Eric\Blog\Model\UsersManager();
		$verifyId = $verifyConnect->checkConnect($id_connect);

		return $verifyId;
	}

	//Affichage liste des posts + pagination pour adminView.php
	function listPostsAdmin()
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

		require('view/backend/adminView.php');
	}