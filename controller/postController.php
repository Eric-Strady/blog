<?php

	require_once('model/Posts.php');
	require_once('model/Comments.php');
	require_once('model/Warning.php');

	use \Eric\Blog\Model\Posts\Posts;
	use \Eric\Blog\Model\Comments\Comments;
	use \Eric\Blog\Model\Warning\Warning;

	//Affichage du post selectionné et de ses commentaires + ajout de commentaire + modification de commentaire
	function post($postId)
	{
		$postsManager = new Posts();
		$commentsManager = new Comments();

		$post = $postsManager->getPost($postId);
		$comments = $commentsManager->getComments($postId);

		require('view/frontend/postView.php');	
	}

	function insertComment($postId, $pseudo, $email, $comment)
	{
		$commentsManager = new Comments();
		$commentsManager->addComment($postId, $pseudo, $email, $comment);
	}

	function reComment($comment, $commentId, $id_post)
	{
		$commentsManager = new Comments();
		$commentsManager->updateComment($comment, $commentId, $id_post);
	}

	//Commentaires signalés
	function verifyWarning($id, $informer)
	{
		$warningManager = new Warning();
		$verifyWarning = $warningManager->checkWarning($id, $informer);

		return $verifyWarning;
	}

	function addWarnedComments($id, $informer)
	{
		$commentsManager = new Comments();
		$warningManager = new Warning();

		$careComment = $commentsManager->getComment($id);
		$warnedComment = $careComment->fetch();

		$warningManager->insertWarnedComment($warnedComment['id'], $warnedComment['author'], $warnedComment['comment'], $warnedComment['id_post'], $informer);
	}