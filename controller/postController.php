<?php

	require_once('model/PostsManager.php');
	require_once('model/CommentsManager.php');
	require_once('model/WarningManager.php');

	use \Eric\Blog\Model\Posts\PostsManager;
	use \Eric\Blog\Model\Comments\CommentsManager;
	use \Eric\Blog\Model\Warning\WarningManager;

	//Affichage du post selectionné et de ses commentaires + ajout de commentaire + modification de commentaire
	function post($postId)
	{
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