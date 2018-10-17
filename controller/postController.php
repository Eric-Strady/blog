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

			case 'add_comment':
				newComment();
			break;

			case 'update_comment':
				changeComment();
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
			$id = $_GET['id'];

			$post = new Post(['id' => $id]);
			$postsManager = new PostsManager();
			$comments = new Comment([]);
			$commentsManager = new CommentsManager();

			if ($postsManager->isExist($post->getId()))
			{
				$post = $postsManager->findPost($post->getId());
				$comments = $commentsManager->listComments($post->getId());

				require 'view/frontend/postView.php';
			}
			else
			{
				throw new Exception('<p>Ce billet n\'existe pas !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez le bon identifiant de billet.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
		}
	}

	function newComment()
	{
		if (isset($_POST['comment'], $_POST['id_post'], $_POST['id_user']))
		{
			if ($_POST['comment']!='' AND $_POST['id_post']!='' AND $_POST['id_user']!='')
			{
				$new_comment = strip_tags($_POST['comment']);
				$id_post = $_POST['id_post'];
				$id_user = $_POST['id_user'];

				$comment = new Comment(['comment' => $new_comment, 'id_post' => $id_post, 'id_user' => $id_user]);
				$commentsManager = new CommentsManager();
				$commentsManager->addComment($comment->getIdUser(), $comment->getIdPost(), $comment->getComment());

				$path = 'Location: http://127.0.0.1/blog/index.php?link=post&action=read&id=' . $id_post . '#comments';
				header($path);
			}
			else
			{
				throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
		}
	}

	function changeComment()
	{
		if (isset($_POST['up_comment'], $_POST['id_comment'], $_POST['id_post']))
		{
			if ($_POST['up_comment']!='' AND $_POST['id_comment']!='' AND $_POST['id_post']!='')
			{
				$up_comment = strip_tags($_POST['up_comment']);
				$id = $_POST['id_comment'];
				$id_post = $_POST['id_post'];

				$comment = new Comment(['comment' => $up_comment, 'id' => $id]);
				$commentsManager = new CommentsManager();

				if ($commentsManager->isExist($comment->getId()))
				{
					$commentsManager->updateComment($comment->getComment(), $comment->getId());

					$path = 'Location: http://127.0.0.1/blog/index.php?link=post&action=read&id=' . $id_post . '#comments';
					header($path);
				}
				else
				{
					throw new Exception('<p>Impossible de modifier ce commentaire !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
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