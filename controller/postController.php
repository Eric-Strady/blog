<?php

	require_once('model/Post.php');
	require_once('model/PostsManager.php');
	require_once('model/Comment.php');
	require_once('model/CommentsManager.php');

	use \Eric\Blog\Model\Posts\Post;
	use \Eric\Blog\Model\Posts\PostsManager;
	use \Eric\Blog\Model\Comments\Comment;
	use \Eric\Blog\Model\Comments\CommentsManager;

												//DEFINE ACTION

	if (isset($_GET['action']) AND !empty($_GET['action']))
	{
		$action = strip_tags($_GET['action']);
		switch ($action)
		{
			case 'read':
				post();
			break;

			default:
				throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			break;
		}
	}
	else
	{
		throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
	}

												//FUNCTIONS

	function post()
	{
		if (isset($_GET['id']) AND !empty($_GET['id']))
		{
			$postsManager = new PostsManager();
			$comments = new Comment([]);
			$commentsManager = new CommentsManager();

			$post = $postsManager->findPost($_GET['id']);
			$comments = $commentsManager->listComments($_GET['id']);

			require 'view/frontend/postView.php';
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez le bon identifiant de billet.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
		}
	}




	/*
	//Affichage du post selectionné et de ses commentaires + ajout de commentaire + modification de commentaire
	function post($postId)
	{
		$_GET['post'] = (int) $_GET['post'];
		$postId = strip_tags($_GET['post']);

			post($postId);
		}
		$postsManager = new PostsManager();
		$commentsManager = new CommentsManager();

		$post = $postsManager->getPost($postId);
		$comments = $commentsManager->getComments($postId);

		require('view/frontend/postView.php');	
	}

	function insertComment($postId, $pseudo, $email, $comment)
	{
		$commentsManager = new CommentsManager();
		$commentsManager->addComment($postId, $pseudo, $email, $comment);
	}

	function reComment($comment, $commentId, $id_post)
	{
		$commentsManager = new CommentsManager();
		$commentsManager->updateComment($comment, $commentId, $id_post);
	}

	//Commentaires signalés
	function verifyWarning($id, $informer)
	{
		$warningManager = new WarningManager();
		$verifyWarning = $warningManager->checkWarning($id, $informer);

		return $verifyWarning;
	}

	function addWarnedComments($id, $informer)
	{
		$commentsManager = new CommentsManager();
		$warningManager = new WarningManager();

		$careComment = $commentsManager->getComment($id);
		$warnedComment = $careComment->fetch();

		$warningManager->insertWarnedComment($warnedComment['id'], $warnedComment['author'], $warnedComment['comment'], $warnedComment['id_post'], $informer);
	}
	*/